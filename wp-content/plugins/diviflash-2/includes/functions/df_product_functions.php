<?php
/**
 * Render Products for diviflash Product Item on VB
 * 
 */
add_action('wp_ajax_df_pg_products', 'df_pg_products');
if(!function_exists('df_pg_products')){
    function df_pg_products() {
        if ( ! is_plugin_active ( 'woocommerce/woocommerce.php' ) ) {
            $error_notice ="<div style='color:red'>" . esc_html__("Please Before Using the Diviflash Product Grid Module, you need to Activate and configure the WooCommerce Plugin", "divi_flash") . "</div>";
            wp_send_json_success($error_notice);
        }
        global $product, $paged, $wp_query, $wp_the_query, $wp_filter, $__et_blog_module_paged;
        $data = json_decode(file_get_contents('php://input'), true);
        if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
            wp_die();
        }
        $product_items = isset($data['productItems']) ? $data['productItems'] : array();    
        $product_item_inner = isset($product_items['inner']) ? $product_items['inner'] : array();
        $product_item_outer = isset($product_items['outer']) ? $product_items['outer'] : array();
    
        $posts_number = isset($data['posts_number']) ? intval($data['posts_number']) : 10;
        $type = isset($data['type']) ? $data['type'] : 'default';
        $columns = isset($data['column']) ? $data['column'] : 'default';
        $order = '';
        $orderby = isset($data['orderby']) ? $data['orderby'] : '1';
        $include_categories = isset($data['include_categories']) ? $data['include_categories'] : '';
        $include_tags = isset($data['include_tags']) ? $data['include_tags'] : '';
        $layout = isset($data['layout']) ? $data['layout'] : 'grid';
        $use_image_as_background = isset($data['use_image_as_background']) ? $data['use_image_as_background'] : 'off';
        $equal_height = isset($data['equal_height']) ? $data['equal_height'] : 'off';
        $pagination_value = isset($data['show_pagination']) ? $data['show_pagination'] : 'off';
        $pagination = ( $pagination_value === 'off' ) ? false : true;
    
        $show_badge = isset($data['show_badge']) ? $data['show_badge'] : 'off';
        $show_badge_in_image = isset($data['show_badge_in_image']) ? $data['show_badge_in_image'] : 'off';
        $on_sale_text = isset($data['on_sale_text']) ? $data['on_sale_text'] : 'sale!';
        $after_sale_text_enable = isset($data['after_sale_text_enable']) ? $data['after_sale_text_enable'] : 'off';
        $after_sale_text_type = isset($data['after_sale_text_type']) ? $data['after_sale_text_type']: 'price-percentise';
        $after_sale_text = isset($data['after_sale_text']) ? $data['after_sale_text'] : '';
        $enable_custom_soldout_text = isset($data['enable_custom_soldout_text']) ? $data['enable_custom_soldout_text'] : 'off';
        $custom_soldout_text = isset($data['custom_soldout_text']) ? $data['custom_soldout_text'] : 'Sold Out!';
        $use_current_loop = isset($data['use_current_loop'])? $data['use_current_loop']: 'off';
    
        $product_categories = array();
        $product_tags       = array();
        $use_current_loop   = 'on' === $use_current_loop;
        $use_current_loop   = $use_current_loop && ( is_post_type_archive( 'product' ) || is_search() || et_is_product_taxonomy() );
        $product_attribute  = '';
        $product_terms      = array();
        if ( $use_current_loop ) {
            $include_categories = 'all';

            if ( is_product_category() ) {
                $include_categories = (string) get_queried_object_id();
            } elseif ( is_product_tag() ) {
                $product_tags = array( get_queried_object()->slug );
            } elseif ( is_product_taxonomy() ) {
                $term = get_queried_object();

                // Product attribute taxonomy slugs start with pa_ .
                if ( et_()->starts_with( $term->taxonomy, 'pa_' ) ) {
                    $product_attribute = $term->taxonomy;
                    $product_terms[]   = $term->slug;
                }
            }
        }
    
        if ( 'product_category' === $type || ( $use_current_loop && ! empty( $include_categories ) ) ) {

            //$all_shop_categories     = et_builder_get_shop_categories();
            $args = array(
                'taxonomy'   => "product_cat"
            );
            $all_shop_categories = get_terms($args);
        
            $all_shop_categories_map = array();

            $raw_product_categories = explode(",", $include_categories);
            foreach ( $all_shop_categories as $term ) {
                if ( is_object( $term ) && is_a( $term, 'WP_Term' ) ) {
                    $all_shop_categories_map[ $term->term_id ] = $term->slug;
                }
            }

            $product_categories = array_values( $all_shop_categories_map );
        
            if ( ! empty( $raw_product_categories ) ) {
                $product_categories = array_intersect_key(
                    $all_shop_categories_map,
                    array_flip( $raw_product_categories )
                );
            }
        }
    
        // Recent was the default option in Divi once, so it is added here for the websites created before the change.
        if ( 'default_order' === $orderby && ( 'default' === $type || 'recent' === $type ) ) {
            // Leave the attribute empty to allow WooCommerce to take over and use the default sorting.
            $orderby = '';
        }

        if ( 'latest' === $type ) {
            $orderby = 'date-desc';
        }

        if ( in_array( $orderby, array( 'price-desc', 'date-desc' ), true ) ) {
            // Supported orderby arguments (as defined by WC_Query->get_catalog_ordering_args() ):
            // rand | date | price | popularity | rating | title .
            $orderby = str_replace( '-desc', '', $orderby );
            // Switch to descending order if orderby is 'price-desc' or 'date-desc'.
            $order = 'DESC';
        }

        $ids             = array();
        $wc_custom_view  = '';
        $wc_custom_views = array(
            'sale'         => array( 'on_sale', 'true' ),
            'best_selling' => array( 'best_selling', 'true' ),
            'top_rated'    => array( 'top_rated', 'true' ),
            'featured'     => array( 'visibility', 'featured' )
        );
        
        if ( et_()->includes( array_keys( $wc_custom_views ), $type ) ) {
            $custom_view_data = $wc_custom_views[ $type ];
            $wc_custom_view   = sprintf( '%1$s="%2$s"', esc_attr( $custom_view_data[0] ), esc_attr( $custom_view_data[1] ) );
        }
        
        $request_orderby_value = et_()->array_get_sanitized( $_GET, 'orderby', '' );
        
        $maybe_request_price_value_in_order_options = ! empty( $request_orderby_value ) && false !== strpos( strtolower( $request_orderby_value ), 'price' );
        if ( $maybe_request_price_value_in_order_options ) {
            $orderby = 'price';
            $order   = false !== strpos( strtolower( $request_orderby_value ), 'desc' ) ? 'DESC' : 'ASC';
        }
        
        $options= array(
            'show_badge'             => $show_badge,
            'show_badge_in_image'    => $show_badge_in_image,
            'on_sale_text'           => $on_sale_text,
            'after_sale_text_enable' => $after_sale_text_enable,
            'after_sale_text_type'   => $after_sale_text_type,
            'after_sale_text'        => $after_sale_text,
            'enable_custom_soldout_text'=> $enable_custom_soldout_text,
            'custom_soldout_text'    => $custom_soldout_text,
            'layout'                 =>  $layout,
            'equal_height'           =>  $equal_height
        );
        
        $df_product_element = array(
            'df_product_items' => $product_item_inner,
            'df_product_items_outside'=>$product_item_outer
        );
        ob_start();

        do_action('df_pg_before_print', $df_product_element , $options, true);
   
        
		$shortcode = sprintf(
			'[products columns="%4$s" %1$s limit="%2$s" orderby="%3$s" columns="%4$s" %5$s order="%6$s" %7$s %8$s %9$s %10$s %11$s]',
			et_core_intentionally_unescaped( $wc_custom_view, 'fixed_string' ),
			esc_attr( $posts_number ),
			esc_attr( $orderby ),
			esc_attr( $columns ),
			$product_categories ? sprintf( 'category="%s"', esc_attr( implode( ',', $product_categories ) ) ) : '',
			esc_attr( $order ),
			$pagination? 'paginate="true"' : '',
			$ids ? sprintf( 'ids="%s"', esc_attr( implode( ',', $ids ) ) ) : '',
			$product_tags ? sprintf( 'tag="%s"', esc_attr( implode( ',', $product_tags ) ) ) : '',
			$product_attribute ? sprintf( 'attribute="%s"', esc_attr( $product_attribute ) ) : '',
			$product_terms ? sprintf( 'terms="%s"', esc_attr( implode( ',', $product_terms ) ) ) : ''
		);
      
        echo do_shortcode( $shortcode );
        
        do_action('df_pg_after_print' , $df_product_element , $options);

        $shop = ob_get_contents();
        ob_end_clean();
        if(empty($product_item_inner) && empty($product_item_outer)) {
            $shop = '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Prodcut Element</strong> to continue.</h2>';
        }
            
        wp_send_json_success($shop);
    }
}


/**
 * For Product Carousel Render Products for diviflash Product Item on VB
 * 
 */
add_action('wp_ajax_df_carousel_products', 'df_carousel_products');
if(!function_exists('df_carousel_products')){
    function df_carousel_products() {
        if ( ! is_plugin_active ( 'woocommerce/woocommerce.php' ) ) {
            $error_notice ="<div style='color:red'>" . esc_html__("Please Before Using the Diviflash Product Grid Module, you need to Activate and configure the WooCommerce Plugin", "divi_flash") . "</div>";
            wp_send_json_success($error_notice);
        }
        global $product, $paged, $wp_query, $wp_the_query, $wp_filter, $__et_blog_module_paged;
        $data = json_decode(file_get_contents('php://input'), true);
        if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
            wp_die();
        }
        $product_items = isset($data['productItems']) ? $data['productItems'] : array();
        $product_item_inner = $product_items['inner'];
        $product_item_outer = $product_items['outer'];

        $posts_number = isset($data['posts_number']) ? intval($data['posts_number']) : 10;
        $type = isset($data['type']) ? $data['type'] : 'default';
        $columns = isset($data['column']) ? $data['column'] : 'default';
        $order = '';
        $orderby = isset($data['orderby']) ? $data['orderby'] : '1';
        $include_categories = isset($data['include_categories']) ? $data['include_categories'] : '';
        $include_tags = isset($data['include_tags']) ? $data['include_tags'] : '';
        $layout = isset($data['layout']) ? $data['layout'] : 'grid';
        $use_image_as_background = isset($data['use_image_as_background']) ? $data['use_image_as_background'] : 'off';
        $equal_height = isset($data['equal_height']) ? $data['equal_height'] : 'off';
        $pagination =  false;
    
        $show_badge = isset($data['show_badge']) ? $data['show_badge'] : 'off';
        $show_badge_in_image = isset($data['show_badge_in_image']) ? $data['show_badge_in_image'] : 'off';
        $on_sale_text = isset($data['on_sale_text']) ? $data['on_sale_text'] : 'sale!';
        $after_sale_text_enable = isset($data['after_sale_text_enable']) ? $data['after_sale_text_enable'] : 'off';
        $after_sale_text_type = isset($data['after_sale_text_type']) ? $data['after_sale_text_type']: 'price-percentise';
        $after_sale_text = isset($data['after_sale_text']) ? $data['after_sale_text'] : '';
        $enable_custom_soldout_text = isset($data['enable_custom_soldout_text']) ? $data['enable_custom_soldout_text'] : 'off';
        $custom_soldout_text = isset($data['custom_soldout_text']) ? $data['custom_soldout_text'] : 'Sold Out!';
        $use_current_loop = isset($data['use_current_loop'])? $data['use_current_loop']: 'off';
    
        $product_categories = array();
        $product_tags       = array();
        $use_current_loop   = 'on' === $use_current_loop;
        $use_current_loop   = $use_current_loop && ( is_post_type_archive( 'product' ) || is_search() || et_is_product_taxonomy() );
        $product_attribute  = '';
        $product_terms      = array();
        if ( $use_current_loop ) {
            $include_categories = 'all';

            if ( is_product_category() ) {
                $include_categories = (string) get_queried_object_id();
            } elseif ( is_product_tag() ) {
                $product_tags = array( get_queried_object()->slug );
            } elseif ( is_product_taxonomy() ) {
                $term = get_queried_object();

                // Product attribute taxonomy slugs start with pa_ .
                if ( et_()->starts_with( $term->taxonomy, 'pa_' ) ) {
                    $product_attribute = $term->taxonomy;
                    $product_terms[]   = $term->slug;
                }
            }
        }
    
        if ( 'product_category' === $type || ( $use_current_loop && ! empty( $include_categories ) ) ) {

            //$all_shop_categories     = et_builder_get_shop_categories();
            $args = array(
                'taxonomy'   => "product_cat"
            );
            $all_shop_categories = get_terms($args);
        
            $all_shop_categories_map = array();

            $raw_product_categories = explode(",", $include_categories);
            foreach ( $all_shop_categories as $term ) {
                if ( is_object( $term ) && is_a( $term, 'WP_Term' ) ) {
                    $all_shop_categories_map[ $term->term_id ] = $term->slug;
                }
            }

            $product_categories = array_values( $all_shop_categories_map );
        
            if ( ! empty( $raw_product_categories ) ) {
                $product_categories = array_intersect_key(
                    $all_shop_categories_map,
                    array_flip( $raw_product_categories )
                );
            }
        }
    
        // Recent was the default option in Divi once, so it is added here for the websites created before the change.
        if ( 'default' === $orderby && ( 'default' === $type || 'recent' === $type ) ) {
            // Leave the attribute empty to allow WooCommerce to take over and use the default sorting.
            $orderby = '';
        }

        if ( 'latest' === $type ) {
            $orderby = 'date-desc';
        }

        if ( in_array( $orderby, array( 'price-desc', 'date-desc' ), true ) ) {
            // Supported orderby arguments (as defined by WC_Query->get_catalog_ordering_args() ):
            // rand | date | price | popularity | rating | title .
            $orderby = str_replace( '-desc', '', $orderby );
            // Switch to descending order if orderby is 'price-desc' or 'date-desc'.
            $order = 'DESC';
        }

        $ids             = array();
        $wc_custom_view  = '';
        $wc_custom_views = array(
            'sale'         => array( 'on_sale', 'true' ),
            'best_selling' => array( 'best_selling', 'true' ),
            'top_rated'    => array( 'top_rated', 'true' ),
            'featured'     => array( 'visibility', 'featured' )
        );
        
        if ( et_()->includes( array_keys( $wc_custom_views ), $type ) ) {
            $custom_view_data = $wc_custom_views[ $type ];
            $wc_custom_view   = sprintf( '%1$s="%2$s"', esc_attr( $custom_view_data[0] ), esc_attr( $custom_view_data[1] ) );
        }
        
        $request_orderby_value = et_()->array_get_sanitized( $_GET, 'orderby', '' );
        
        $maybe_request_price_value_in_order_options = ! empty( $request_orderby_value ) && false !== strpos( strtolower( $request_orderby_value ), 'price' );
        if ( $maybe_request_price_value_in_order_options ) {
            $orderby = 'price';
            $order   = false !== strpos( strtolower( $request_orderby_value ), 'desc' ) ? 'DESC' : 'ASC';
        }
        
		$options= array(
          'show_badge'             => $show_badge,
          'show_badge_in_image'    => $show_badge_in_image,
          'on_sale_text'           => $on_sale_text,
          'after_sale_text_enable' => $after_sale_text_enable,
          'after_sale_text' => $after_sale_text,
          'after_sale_text_type'   => $after_sale_text_type,
          'enable_custom_soldout_text'=> $enable_custom_soldout_text,     
          'custom_soldout_text'    => $custom_soldout_text,
          'layout'                  =>  $layout,
          'equal_height'           =>  $equal_height,
        );
        
        $df_product_element = array(
            'df_product_items' => $product_item_inner,
            'df_product_items_outside'=>$product_item_outer
        );
        ob_start();

        do_action('df_pg_before_print', $df_product_element , $options, true);
       
        add_filter('post_class', 'df_product_carousel_class_add' ,10,3);   
        
		$shortcode = sprintf(
			'[products class="swiper-container" columns="%4$s" %1$s limit="%2$s" orderby="%3$s" columns="%4$s" %5$s order="%6$s" %7$s %8$s %9$s %10$s %11$s]',
			et_core_intentionally_unescaped( $wc_custom_view, 'fixed_string' ),
			esc_attr( $posts_number ),
			esc_attr( $orderby ),
			esc_attr( $columns ),
			$product_categories ? sprintf( 'category="%s"', esc_attr( implode( ',', $product_categories ) ) ) : '',
			esc_attr( $order ),
			$pagination,
			$ids ? sprintf( 'ids="%s"', esc_attr( implode( ',', $ids ) ) ) : '',
			$product_tags ? sprintf( 'tag="%s"', esc_attr( implode( ',', $product_tags ) ) ) : '',
			$product_attribute ? sprintf( 'attribute="%s"', esc_attr( $product_attribute ) ) : '',
			$product_terms ? sprintf( 'terms="%s"', esc_attr( implode( ',', $product_terms ) ) ) : ''
		);
      
        echo do_shortcode( $shortcode );
        
        do_action('df_pg_after_print' , $df_product_element , $options);

        $shop = ob_get_contents();
        ob_end_clean();
        if(empty($product_item_inner) && empty($product_item_outer)) {
            $shop = '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Product Element</strong> to continue.</h2>';
        }
            
        wp_send_json_success($shop);
    }
}


/**
 * Post Content
 * 
 * @param Array $settings
 * @param Array $options parent module options
 */
if(!function_exists('df_product_title')){
    function df_product_title( $settings = array() ,$options= array(), $builder = false ) {
        global $product;
        $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
        $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
        echo sprintf('<div class="df-item-wrap df-product-title-wrap %4$s %5$s">
                %6$s
                <%3$s class="df-product-title woocommerce-loop-product__title">
                    <a href="%2$s">
                        %1$s
                    </a>
                </%3$s>     
            </div>', 
            wp_kses_post(get_the_title()), 
            esc_url($link),
            esc_attr($settings['title_tag']),
            esc_attr($settings['class']),
            esc_attr($module_class),
            et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
        );
        
    }
}

/**
 * Post Content
 * 
 * @param Array $settings
 * @param Array $options parent module options
 */
if(!function_exists('df_product_content')){
    function df_product_content($settings = array(), $options= array(), $builder = false) {
        global $product,$post;
        $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
        if($product->get_short_description()){
            
            $short_desc =  et_core_esc_previously( apply_filters( 'woocommerce_short_description', $post->post_excerpt ) );//$short_desc =  et_core_esc_previously( $product->get_short_description() );
            $length = $settings['use_product_excrpt'] === 'on' ? $settings['excerpt_length'] : '100';   
            $excerpt = substr($short_desc, 0, $length);
            $excerpt = !empty($excerpt) ? $excerpt . "..." : '';
            $main_content = $settings['use_product_excrpt'] === 'on' ? $excerpt  :   $short_desc;
            echo sprintf(
                '<div class="df-item-wrap df-product-content-wrap  %1$s %2$s">  
                    %3$s 
                    %4$s  
                </div>', 
                esc_attr($settings['class']),
                esc_attr($module_class),
                et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings )),
                et_core_esc_previously($main_content)
            );

        }else{
            echo sprintf(
                '<span class="df-item-wrap df-product-content-wrap null_item_builder %1$s %2$s">       
                </span>', 
                esc_attr($settings['class']),
                esc_attr($module_class) 
            );
        }
   
    }
}

/**
 * Product Short Descripton custom filter
 * 
 * @param String $post_post_excerpt existing post excerpt
 * @param Int $limit charecter Limit
 */
if(!function_exists('df_filter_woocommerce_short_description')){
    function df_filter_woocommerce_short_description( $post_post_excerpt , $limit ) { 
     
        if(! is_product() ) { 
            $text = $post_post_excerpt; 
            $charecter_limit = intval($limit)+3;
            $more = '…';  
            $post_post_excerpt =  mb_strimwidth($text, 0, $charecter_limit, '...'); //substr($text, 0, $limit); //wp_trim_words( $text, $words, $more );
           
        }
        return $post_post_excerpt; 
    };
}


/**
 * Product Price
 * 
 * @param Array $settings
 * @param Array $options parent module options
 */
if ( ! function_exists( 'df_product_price' ) ) {
    function df_product_price($settings = array(), $options= array(), $builder = false){
        global $product;
        $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
        if( $price_html = $product->get_price_html() ) :
            echo sprintf(
                '<div class="df-item-wrap df-product-price-wrap %3$s %4$s">
                    %5$s
                    <%2$s class="df-product-price price">
                    %1$s
                    </%2$s>     
                </div>', 
                et_core_esc_previously($price_html), 
                esc_attr($settings['price_tag']),
                esc_attr($settings['class']),
                esc_attr($module_class),
                et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
            );
        elseif(empty($product->get_price_html() && $builder === true)): 
            echo sprintf(
                '<span class="df-item-wrap df-product-price-wrap null_item_builder %1$s %2$s">
                  
                </span>', 
                esc_attr($settings['class']),
                esc_attr($module_class)
            );

        endif;
    }
    
}

/**
 * product Rating
 * 
 * @param Array $settings
 * @param Array $options parent module options
 */
if ( ! function_exists( 'df_product_rating' ) ) {
	function df_product_rating( $settings = array(), $options= array() , $builder = false ) {
        global $product;
        $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
        $rating = $product->get_average_rating();
        $html = '';
        if ( 0 < $rating ) {
            $label = sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $rating );
            $html = sprintf(
                '<div class="df-item-wrap df-product-rating-wrap %1$s %2$s">
                %3$s',
                
                esc_attr($settings['class']),
                esc_attr($module_class),
                et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings )) 
            );
            
            ob_start();
            echo et_core_esc_previously($html);
            woocommerce_template_loop_rating();
            echo '</div>';
            $rating = ob_get_clean();

            echo et_core_esc_previously($rating);
        }else{
            if($settings['show_rating_all_item'] === 'on'){
                $html = sprintf(
                    '<div class="df-item-wrap df-product-rating-wrap %1$s %2$s">
                    %3$s',
                    esc_attr($settings['class']),
                    esc_attr($module_class),
                    et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
                );
                
                ob_start();
                echo et_core_esc_previously($html);
                echo '<div class="star-rating df-disable-rating" role="img" aria-label="Rated 0.00 out of 5"></div>';
                echo '</div>';
                $rating = ob_get_clean();
    
                echo et_core_esc_previously($rating);
            } else if($builder === true){
                echo sprintf('<span class="df-item-wrap df-product-rating-wrap null_item_builder"></span>');
            } 
        }        
	}
}

/**
 * Add to Cart Button
 * 
 * @param Array $settings
 * @param Array $options parent module options
 */
if ( ! function_exists( 'df_product_add_to_cart' ) ) {
    function df_product_add_to_cart($settings = array(), $options= array(), $builder = false) {
        global $product;
        
        $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
        $icon = df_pg_render_image_icon($settings, $builder);
        
        $add_to_cart_text = esc_html($settings['add_to_cart_text']);
        $dynamic_class ='';
        if ($product->get_type() === 'simple') {
            $custom_text = $add_to_cart_text !==''? $add_to_cart_text : $product->add_to_cart_text();
            $button_text = $product->is_purchasable() && $product->is_in_stock() ? __( $custom_text , 'divi_flash' ) : __( 'Out of stock', 'divi_flash' );    
        }
        else if ('external' === $product->get_type()) {

            $button_text =  json_decode($product)->button_text ? json_decode($product)->button_text : 'Buy product';
        }
        else if ('variable' === $product->get_type()) {
            $button_text = $product->is_purchasable() ? __( 'Select options', 'divi_flash' ) : __( 'Read more', 'divi_flash' );
        }
        else if('grouped' === $product->get_type()){
            $button_text = __( 'View products', 'divi_flash' );
        }
        else if('subscription' === $product->get_type()){
            $button_text = $product->is_purchasable() ? __( 'Sign up', 'divi_flash' ) : __( 'Read more', 'divi_flash' );
        }
        else if('variable-subscription' === $product->get_type()){
            $button_text = $product->is_purchasable() ? __( 'Select options', 'divi_flash' ) : __( 'Read more', 'divi_flash' );
        }
        else{
            $button_text = $product->is_in_stock() ? __( 'View product', 'divi_flash' ) : __( 'Read more', 'divi_flash' );
        }

        if($settings['use_icon'] === 'on' && $settings['use_only_icon'] === 'on'){
            $button_text = '';
            $dynamic_class ='only_icon_in_cart';
        }
        else if($settings['use_image_as_icon'] === 'on' && $settings['use_only_icon'] === 'on'){
            $button_text = '';
            $dynamic_class ='only_icon_in_cart';
        }
        else if( ($settings['use_only_icon'] === 'off') && ($settings['use_icon'] === 'on' || $settings['use_image_as_icon'] === 'on' ) ){
            $dynamic_class = $settings['image_icon_placement'] ==='right' ? ' placement_right': ' placement_left';
        }else{
            $dynamic_class ='';
        }
       
        $custom_button_text = apply_filters('woocommerce_product_add_to_cart_text', $button_text, $product);

        $output= sprintf('<div class="df-item-wrap df-product-add-to-cart-wrap %1$s %2$s %3$s">', 
                    esc_attr($settings['class']),
                    esc_attr($module_class),
                    esc_attr($dynamic_class)
                );

        ob_start();
        echo et_core_esc_previously($output);

        $button_filter_data = sprintf(
            
            '%10$s <a href="%1$s" rel="nofollow" data-product_id="%2$s" data-product_sku="%3$s" class="product_type_%9$s button df_button %4$s %7$s %8$s">%5$s %6$s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( $product->get_id() ),
            esc_attr( $product->get_sku() ),
            $product->get_type()=== 'simple' && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
            $settings['image_icon_placement'] ==='right' ? esc_html(  $custom_button_text ) :  $icon,
            $settings['image_icon_placement'] ==='right' ? $icon : esc_html(  $custom_button_text ),
            $settings['image_icon_placement'] ==='right' ? 'placement_right': 'placement_left',
            'add_to_cart_button',
            esc_attr( $product->get_type() ),
            et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))       
        );

        echo wp_kses_post(apply_filters(
	        'woocommerce_loop_add_to_cart_link',
	        $button_filter_data,
	        $product,
	        []
        ));
    
        echo "</div>";   
        $add_to_cart_button = ob_get_clean();
        echo et_core_esc_previously($add_to_cart_button);
        
    }
}

/**
 * Custom Text
 * 
 * @param Array $settings
 * @param Array $options parent module options
 */
if ( ! function_exists( 'df_product_custom_text' ) ) {
    function df_product_custom_text($settings = array(), $options= array(), $builder = false) {
        global $product;

        if( $settings['custom_text'] === '' ) return; 
        $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

        echo sprintf('<span class="df-item-wrap df-product-custom-text %2$s %3$s">%4$s%1$s</span>', 
            esc_html__($settings['custom_text'], 'divi_flash'),
            esc_attr($settings['class']),
            esc_attr($module_class),
            et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
        );
    }
}

/**
 * Read More Button
 * 
 * @param Array $settings
 * @param Array $options parent module options
 */
if ( ! function_exists( 'df_product_button' ) ) {
    function df_product_button($settings = array(), $options= array(), $builder = false) {
        global $product;
        $icon = df_pg_render_image_icon($settings, $builder);
        $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
        $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
        $read_more_text = $settings['use_only_icon'] === 'on' ? '' :  esc_html($settings['read_more_text']);
        $dynamic_class ='';
        if($settings['use_icon'] === 'on' && $settings['use_only_icon'] === 'on'){
            $button_text = '';
            $dynamic_class ='only_icon_in_cart';
        }
        else if($settings['use_image_as_icon'] === 'on' && $settings['use_only_icon'] === 'on'){
            $button_text = '';
            $dynamic_class ='only_icon_in_cart';
        }
        else if( ($settings['use_only_icon'] === 'off') && ($settings['use_icon'] === 'on' || $settings['use_image_as_icon'] === 'on' ) ){
            $dynamic_class = $settings['image_icon_placement'] ==='right' ? ' placement_right': ' placement_left';
        }else{
            $dynamic_class = '';
        }
        $output = sprintf('<div class="df-item-wrap df-product-button-wrap %2$s %5$s %6$s">
                %7$s
                <a class="df_button df-product-read-more" href="%1$s">%3$s %4$s</a>
            </div>', 
            $link,
            esc_attr($settings['class']),
            $settings['image_icon_placement'] ==='right' ? $read_more_text :  $icon,
            $settings['image_icon_placement'] ==='right' ? $icon : $read_more_text,
            esc_attr($module_class),
            esc_attr($dynamic_class),
            et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
        );
        
        echo et_core_esc_previously($output);
    }
}
/**
 * Divider
 * 
 * @param Array $settings
 * @param Array $options parent module options
 */
if ( ! function_exists( 'df_product_divider' ) ) {
    function df_product_divider($settings = array(), $options= array(), $builder = false) {
        global $product;

        $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

        echo sprintf(
            '<div class="df-item-wrap df-product-divider-wrap %1$s %2$s">
                %3$s
                <span class="df-product-ele-divider"></span>
            </div>',
            esc_attr($settings['class']),
            esc_attr($module_class),
            et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
        );
    }
}

/**
 * Product Image
 * 
 * @param Array $settings
 * @param Array $options parent module options
 */
if ( ! function_exists( 'df_product_image' ) ) {
    function df_product_image($settings = array(), $options= array(), $builder = false) {
        global $product;
    
        $image_overlay = $settings['overlay'];
    
        $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
        $classes = '';
        $overlay = '';
        $overlay_icon = '';
        
        $post_thumbnail = woocommerce_get_product_thumbnail();
        
        // overlay
        $classes = sprintf('df-hover-effect %1$s',
            $settings['image_scale']
        );
        $icon_value = !empty($settings['overlay_font_icon']) ?  explode("||", $settings['overlay_font_icon'])[0] : '5';
        if($image_overlay === 'on') {
            if($settings['overlay_icon'] === 'on') {
                $overlay_icon = sprintf('<span class="df-icon-wrap">
                        <span class="df-icon-overlay %2$s">%1$s</span>
                    </span>', 
                    ($builder === false) ? esc_attr(et_pb_process_font_icon( $settings['overlay_font_icon'])) :  $icon_value,
                    $settings['overlay_icon_reveal']
                );
            }

            $classes .= ' has_overlay';
            $overlay = '<span class="df-overlay"></span>';
        }
     
        ob_start();    
        if(!empty($post_thumbnail)) {
                echo sprintf('<div class="df-item-wrap df-product-image-wrap %1$s %2$s">', 
                    esc_attr($settings['class']),
                    esc_attr($module_class)
                );
                do_action('df_product_thumbnail_wrap');
	            echo sprintf( '%6$s<a class="%3$s" href="%2$s">%1$s%4$s%5$s</a>
                    </div>', 
                    wp_kses_post($post_thumbnail), 
                    esc_url(get_the_permalink()),
                    esc_attr($classes),
                    et_core_esc_previously($overlay),
                    et_core_esc_previously($overlay_icon),
                    et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
                );
            } elseif (empty($thumb) && $builder === true) {
                echo sprintf('<div class="df-item-wrap df-product-image-wrap df-empty-element %1$s %2$s"></div>', 
                    esc_attr($settings['class']),
                    esc_attr($module_class)
                );
            }

        $image_html = ob_get_clean();
        echo et_core_esc_previously($image_html);
    }
}

/**
 * Product badge render
 * @param Array $options parent module options
 */
if (! function_exists('df_product_badge_element')){
    function df_product_badge_element($options= array()) {
        global $product , $post;
        $numleft  = $product->get_stock_quantity(); 
        $stock_status = $product->get_stock_status();
        if($numleft===0 || $stock_status ==='outofstock' ) {
            $full_text   =  $options['enable_custom_soldout_text'] !== 'off' && !empty($options['custom_soldout_text']) ? $options['custom_soldout_text'] :'Sold Out!';
            echo  wp_kses_post(apply_filters( 
                'woocommerce_sale_flash',
                '<span class="df-sale-badge df-onsale">'.$full_text.' </span>',
                $post,
                $product 
            ));
        }else{
            $sale_html = '';  
            $sale_text = !empty($options['on_sale_text']) ? $options['on_sale_text'] : "Sale!" ;
            $after_sale_text_type = !empty($options['after_sale_text_type']) ? $options['after_sale_text_type'] : "price-percentise" ;
            $after_sale_text_enable =  !empty($options['after_sale_text_enable']) ? $options['after_sale_text_enable'] : "off" ;
            if ( $product->is_on_sale() ) :
    
                global $product;
                
                if( $product->is_type('variable') || $product->is_type('grouped')){
                    $percentages = array();
                    $amount_saved = array();
                    $currency_symbol = get_woocommerce_currency_symbol();
                    // This will get all the variation prices and loop throughout them
                    $children_ids = $product->get_children();
              
                    foreach( $children_ids as $child_id ){
                        $child_product = wc_get_product($child_id);
              
                        $regular_price = (float) $child_product->get_regular_price();
                        $sale_price    = (float) $child_product->get_sale_price();
              
                        if ( $sale_price != 0 || ! empty($sale_price) ) {
                            // Calculate and set in the array the percentage for each child on sale
                            $percentages[] =  round(100 - ($sale_price / $regular_price * 100));
                            $amount_saved[] = $regular_price - $sale_price;
                        }
                    }
                   // Displays maximum discount value
                    if($after_sale_text_type === 'price-percentise'){
                        $percentage = max($percentages). '%';
                    }
                    else if($after_sale_text_type === 'both-percentise-difference'){
                        $percentage = max($amount_saved) . $currency_symbol . "(". max($percentages) . '%'.")"; 
                    }else{
                        $percentage = max($amount_saved) . $currency_symbol;
                    }
              
                }
    
                else if( $product->is_type('simple') || $product->is_type('external') ){
             
                    $regular_price     = get_post_meta( $product->get_id(), '_regular_price', true ); 
                    $sale_price        = get_post_meta( $product->get_id(), '_sale_price', true );
                  
                    if( $sale_price !== ''  ) {
                        $amount_saved = $regular_price - $sale_price;
                        $currency_symbol = get_woocommerce_currency_symbol();
                       
                        $percentage =( ($after_sale_text_type === 'price-percentise' ) ? round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ). '%' : round($amount_saved) . $currency_symbol );
              
                        if($after_sale_text_type === 'price-percentise')  {
                            
                            $percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ). '%'; 
                        }
                        else if($after_sale_text_type === 'both-percentise-difference'){
                            $percentage = round($amount_saved) . $currency_symbol . "(". round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ). '%'.")"; 
                        }else{
                            $percentage = round($amount_saved) . $currency_symbol;
                        }
                    }else{
                       $percentage = '';
                   }
                }
    
                $before_text     = '<span class="before-text"> ' .  $sale_text . ' </span>';
                $after_text      = ($after_sale_text_enable === 'on' ) ? '<span class="after-text">' . $percentage . '</span>' : '';
                $after_sale_text = !empty($options['after_sale_text']) && $after_sale_text_enable === 'on'  ? '<span class="after-sale-text">' . $options['after_sale_text'] . '</span>'  : "" ;
                $full_text       = $before_text.$after_text.$after_sale_text;
                echo  wp_kses_post(apply_filters( 
                    'woocommerce_sale_flash',
                    '<span class="df-sale-badge df-onsale">'.$full_text.' </span>',
                    $post,
                    $product 
                ));
            endif;
        }
        
    }
}

/**
 * Make icon and image use as item
 * @param Array $settings
 * @param Array $options parent module options
 */
if(!function_exists('df_pg_render_image_icon')){
    function df_pg_render_image_icon($settings = array(), $builder= false)
    {
        if (isset($settings['use_icon']) && $settings['use_icon'] === 'on') {
    
            return sprintf(
                '<span class="et-pb-icon">%1$s</span>',
                isset($settings['font_icon']) && $settings['font_icon'] !== '' ?
                    $settings['font_icon'] : ''
            );
        } else if (isset($settings['image_as_icon']) && $settings['image_as_icon'] !== '' && $settings['use_image_as_icon'] === 'on') {
            $src = 'src';
            $image_alt_text =  isset($settings['image_as_icon']) ? df_image_alt_by_url($settings['image_as_icon']) : '';
            $image_icon_alt_text = isset($settings['image_alt_text']) && $settings['image_alt_text'] !== '' ? $settings['image_alt_text']  : $image_alt_text;
            return sprintf(
                '<img class="df_product_icon_image" alt="%3$s" %2$s="%1$s" />',
                $settings['image_as_icon'],
                $src,
                $image_icon_alt_text
            );
        }
    }
}

/**
 * Product Categories 
 * 
 * @param Array $settings
 * @param Array $options
 */
if(!function_exists('df_product_categories')){
    function df_product_categories( $settings = array(), $options= array() , $builder = false ) {
        global $product;
        $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
        $terms = get_the_terms( $product->get_id(), 'product_cat' );
        $categories_html = '';
        if ( $terms && ! is_wp_error( $terms ) ) :
            $cat_links = array();
            foreach ( $terms as $term ) {
                if($settings['use_category_link'] === 'off'){
                    $cat_links[] = sprintf('<span class="df_term_item" >%1$s</span>',
                    esc_html($term->name)
                );
                }else{
                    $term_link = get_term_link( $term );
                    $target = $settings['category_open_new_tab'] === 'on'  ? 'target="_blank"' : '';
                    $cat_links[] = sprintf('<a %1$s href=%2$s> <span class="df_term_item">%3$s</span> </a>',
                        $target,
                        esc_url($term_link),
                        esc_html($term->name)
                    );
                }
                
            }
            $category_separator = isset($settings['category_separator']) && $settings['category_separator'] !== '' ? $settings['category_separator'] : '|';
            $separator_sign = $settings['use_separator'] === 'on' ? $category_separator : ' ';
            $cat = join( $separator_sign , $cat_links );
            $categories_html =  sprintf('<div class="df-item-wrap df-product-categories-wrap %1$s %2$s">
                    %4$s 
                    %3$s
                </div>',
                esc_attr($settings['class']),
                esc_attr($module_class),
                wp_kses_post($cat),
                et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
            );
    
        elseif(empty($terms) && $builder === true): 
            $categories_html = sprintf(
                '<span class="df-item-wrap df-product-categories-wrap null_item_builder %1$s %2$s">       
                </span>', 
                esc_attr($settings['class']),
                esc_attr($module_class) 
            );
        endif; 
        echo et_core_esc_previously($categories_html);
    }
}

/**
 * Product Tags 
 * 
 * @param Array $settings
 * @param Array $options parent module options
 */
if(!function_exists('df_product_tags')){
    function df_product_tags( $settings = array(), $options= array() , $builder = false ) {
        global $product;
        $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
        $terms = get_the_terms( $product->get_id(), 'product_tag' );
        $tags_html = '';
        if ( $terms && ! is_wp_error( $terms ) ) :
            $tag_links = array();
            foreach ( $terms as $term ) {
                if($settings['use_category_link'] === 'off'){
                    $tag_links[] =sprintf('<span class="df_term_item">%1$s</span>',
                    esc_html($term->name)
                );
                }else{
                    $term_link = get_term_link( $term );
                    $target = $settings['category_open_new_tab'] === 'on'  ? 'target="_blank"' : '';
                    $tag_links[] = sprintf('<a %1$s href=%2$s><span class="df_term_item">%3$s</span></a>',
                        $target,
                        esc_url($term_link),
                        esc_html($term->name)
                    );
                }
                
            }
            $tag_separator = isset($settings['category_separator']) && $settings['category_separator'] !== '' ? $settings['category_separator'] : '|';
            $separator_sign = $settings['use_separator'] === 'on' ? $tag_separator : ' ';
            $tag = join( $separator_sign , $tag_links );
            $tags_html =  sprintf('<div class="df-item-wrap df-product-tags-wrap %1$s %2$s">
                    %4$s
                    %3$s
                </div>',
                esc_attr($settings['class']),
                esc_attr($module_class),
                wp_kses_post($tag),
                et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
            );
    
        elseif(empty($terms) && $builder === true): 
            $tags_html = sprintf(
                '<span class="df-item-wrap df-product-tags-wrap null_item_builder %1$s %2$s">     
                </span>', 
                esc_attr($settings['class']),
                esc_attr($module_class)
            );
        endif; 
        echo et_core_esc_previously($tags_html);
    }
}

if ( ! function_exists( 'df_template_loop_product_li_start' ) ) {
	/**
	 * Insert the opening Div tag for products in the loop.
	 */
	function df_template_loop_product_li_start() {
		global $product;

		echo '<div class="df-product-outer-wrap df-hover-trigger">';
        
        do_action( 'df_product_at_outer_wrap');
       
        echo '<div class="df-product-inner-wrap">';
        
        do_action( 'df_product_at_inner_wrap');
	}
}

if ( ! function_exists( 'df_template_loop_product_li_end' ) ) {
	/**
	 * Insert the closing Div tag for products in the loop.
	 */
	function df_template_loop_product_li_end() {
		echo '</div>
        </div>';
	}
}

/**
 * all Required Custom callback and priority
 * @return array 
 */
function df_pg_action_callback_array(){
    $action_array = array(
        'title' => array(
            'callback' => 'df_product_title',
            'priority' => 10
        ),
        'image' => array(
            'callback' => 'df_product_image',
            'priority' => 10
        ),
        'short_description' => array(
            'callback' => 'df_product_content',
            'priority' => 10
        ),
        'price' => array(
            'callback' => 'df_product_price',
            'priority' => 10
        ),
        'rating' => array(
            'callback' => 'df_product_rating',
            'priority' => 10
        ),
        'button' => array(
            'callback' => 'df_product_button',
            'priority' => 10
        ),
        'categories' => array(
            'callback' => 'df_product_categories',
            'priority' => 10
        ),
        'tags' => array(
            'callback' => 'df_product_tags',
            'priority' => 10
        ),
        'divider'  => array(
            'callback' => 'df_product_divider',
            'priority' => 10
        ),
        'add_to_cart' => array(
            'callback' => 'df_product_add_to_cart',
            'priority' => 10
        ),
        'quick_view' => array(
            'callback' => 'df_product_quick_view',
            'priority' => 10
        ),
        'custom_text' => array(
            'callback' => 'df_product_custom_text',
            'priority' => 10
        )

    );
    return $action_array;
}

/**
 * Before run Product list display
 * @param  array $items  Child Item props global variable
 * @param  array $options Options array from Parent Item
 */ 
add_action('df_pg_before_print', 'df_pg_before_print_callback', 10, 3);

function df_pg_before_print_callback( $items = array(), $options=array(), $builder = false ) {
    global $product;

    $action_and_callback_array = df_pg_action_callback_array();
    // Remove Require woocommerce hooks
    remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail',10 );
    remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
   
    add_action( 'woocommerce_before_shop_loop_item', 'df_template_loop_product_li_start', 10 );// overwrite woocommerce action
    add_action( 'woocommerce_after_shop_loop_item', 'df_template_loop_product_li_end', 5 );// overwrite woocommerce action

    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    remove_filter('woocommerce_sale_flash', 'df_product_grid_hide_sale_flash');

    if($options['show_badge'] === 'off'){
        add_filter('woocommerce_sale_flash', 'df_product_grid_hide_sale_flash');
    }

    $product_items_outside = $items['df_product_items_outside'];
    $product_items_inside= $items['df_product_items'];
  
    if(!empty($product_items_inside)){
        $options['action_name']= 'df_product_at_inner_wrap';
        df_product_run_all_action($product_items_inside, $action_and_callback_array, $options, $builder);
    }

    if(!empty($product_items_outside)){
        $options['action_name']= 'df_product_at_outer_wrap';
        df_product_run_all_action($product_items_outside, $action_and_callback_array, $options, $builder);
    } 

    if($options['show_badge'] === 'on'){
        $badge_action_name = $options['show_badge_in_image']=== 'on' ? 'df_product_thumbnail_wrap': 'df_product_at_inner_wrap';
       
        add_action(
            $badge_action_name, 
            function() use (  $options ) {
                df_product_badge_element($options);           
            } ,
            2
        );     
        
    }

    if($options['equal_height'] === 'on'){
        
        add_filter('post_class', 'df_equal_height_class_add',10,3);
    }
    
    add_filter( 'woocommerce_post_class', 'df_remove_post_class', 21, 3 ); 
}

/**
 *Filter function for 'post_class' hook
 * Added class 'df-equal-height' at product li
 * @param  array $classes  class list
*/ 

function df_equal_height_class_add($classes, $class, $product) {
    $classes = array_merge(['df-equal-height'], $classes);
    return $classes;
}

/**
 *Filter function for 'woocommerce_post_class' hook
 * remove class at product li only masonry layout
 * @param  array $classes  class list
*/ 
function df_remove_post_class( $classes ) {
    if ( 'product' == get_post_type() ) {
        $classes = array_diff( $classes, array( 'last','first' ) );
    }
    return $classes;
}

/**
 * Run All Custom action on df_product_at_inner_wrap or df_product_at_outer_wrap hook
 * remove All custom action
 * Add again woocommerce actions
 * @param  array $item_value Child Item props global variable
 * @param  array $action_and_callback call back function name
 * @param  array $optins Module settings 
 * @param boolean $builder 
 */ 
function df_product_run_all_action($item_value, $action_and_callback, $options, $builder){

    if( !empty($item_value) ) {
        foreach((array) $item_value as $index=>$item){
                  
            if( !isset($item['type'])) {
                continue;
            }
            $type     = $item['type'];
            $action   = !empty($options['action_name']) ? $options['action_name'] : 'df_product_at_inner_wrap';
            $callback = $action_and_callback[$type]['callback'];
            $priority  = $action_and_callback[$type]['priority'] + $index;
            
            add_action(
                $action,
                function() use ( $callback , $item , $options, $builder ) {
                    $callback($item, $options, $builder);           
                },
                $priority
            );
            
        }
        
    }
}

/**
 * After run Product list display
 * remove All custom action
 * Add again woocommerce actions
 * @param  array $items Child Item props global variable
 * @param  array $optins Parent Module settings 
 */ 

add_action( 'df_pg_after_print', 'df_pg_after_print_callback', 10, 2 );

function df_pg_after_print_callback($items = array(), $options = array()) {
    
    // remove custom hooks 
    remove_all_actions('df_product_at_inner_wrap');
    remove_all_actions('df_product_at_outer_wrap');
    remove_all_actions('df_product_thumbnail_wrap');

    remove_action( 'woocommerce_before_shop_loop_item', 'df_template_loop_product_li_start', 10 );
    remove_action( 'woocommerce_after_shop_loop_item', 'df_template_loop_product_li_end', 5 );

    remove_filter('post_class', 'df_equal_height_class_add',10);
    remove_filter('post_class', 'df_product_carousel_class_add' ,10);  
    remove_filter('df_woocommerce_short_description', 'df_filter_woocommerce_short_description');
    remove_filter( 'woocommerce_post_class', 'df_remove_post_class', 21 ); 
    // Options Setting condition 
    if($options['show_badge'] === 'off'){
        remove_filter('woocommerce_sale_flash', 'df_product_grid_hide_sale_flash');
    }  

    // Enable Woocomerce hooks 
    add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
    add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
    
    add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

    add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
    add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
    //add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 ); // Already Divi remove this hook so I shouldn't add the action.
}

/**
* Sales Badge Filter
*/
function df_product_grid_hide_sale_flash(){
    return false;
}

add_action('df_render_woo_add_to_cart', 'woocommerce_template_loop_add_to_cart');
add_action('df_render_woo_thumbnail' , 'woocommerce_get_product_thumbnail');

/**
 * Pagination next and prev icons
 * @param  $set String set name
 * @param  $type next/prev key
 */
function df_arrow_icon( $set = 'set_1', $type = 'next' ) {
    $icons = array(
        'set_1'  => array(
            'next' => '5',
            'prev' => '4'
        ),
        'set_2' => array(
            'next' => '$',
            'prev' => '#'
        ),
        'set_3' => array(
            'next' => '9',
            'prev' => '8'
        ),
        'set_4' => array(
            'next' => 'E',
            'prev' => 'D'
        )
    );
    return $icons[$set][$type];
}

/**
 * Pagination Icon Filter function
 * @param  array $args options array
 * @retrun  array $args Module settings 
 */ 
function df_pg_pagination( $args ) {

    $options['next_prev_icon'] ='set_3';
    $args['prev_text'] = '<span class="et-pb-icon">' . esc_attr(et_pb_process_font_icon( df_arrow_icon('set_1' , 'prev') )) . "</span>";
    $args['next_text'] = '<span class="et-pb-icon">' . esc_attr(et_pb_process_font_icon( df_arrow_icon('set_1' , 'next') )) . "</span>";

    return $args;
}

/**
 * new class add at li.product element only carousel module
 * @param $classes 
 * @return array list of classes
 */

function df_product_carousel_class_add($classes, $class, $product) {
    $classes = array_merge(['swiper-slide'], $classes);
    return $classes;
}
