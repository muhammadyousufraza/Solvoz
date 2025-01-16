<?php

/**
 * CPT Image
 *
 * @param Array $settings
 */
function df_cpt_image($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
    $size_array = array(
        'large' => array(1080, 675),
        'mid-hr' => array(350, 450),
        'mid' => array(400, 250),
        'mid-squ' => array(400, 400),
        'sm-squ' => array(300, 300),
        'original' => 'original'
    );

    $image_overlay = $settings['overlay'];
    $classes = '';
    $overlay = '';
    $overlay_icon = '';
    $post_format    = et_pb_post_format();
    $width          = (int) apply_filters( 'et_pb_blog_image_width', $size_array[$settings['image_size']][0] );
    $height         = (int) apply_filters( 'et_pb_blog_image_height', $size_array[$settings['image_size']][1] );
    $titletext      = get_the_title();
    $alttext        = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
    $thumbnail      = get_thumbnail( $width, $height, 'df-cpt-image', $alttext, $titletext, false, 'Blogimage' );
    $thumb          = $thumbnail['thumb'];

    $post_thumbnail = get_the_post_thumbnail();

    if( $size_array[$settings['image_size']] !== 'original' && !empty($thumb) ) {
        $post_thumbnail = print_thumbnail( $thumb, $thumbnail['use_timthumb'], $titletext, $width, $height, '', false );
    }

    // overlay
    $classes = sprintf('df-hover-effect %1$s',
        $settings['image_scale']
    );
    if($image_overlay === 'on') {
        if($settings['overlay_icon'] === 'on') {
            $overlay_icon = sprintf('<span class="df-icon-wrap">
                    <span class="df-icon-overlay %2$s">%1$s</span>
                </span>',
                esc_attr(et_pb_process_font_icon($settings['overlay_font_icon'])),
                $settings['overlay_icon_reveal']
            );
        }
        $classes .= ' has_overlay';
        $overlay = '<span class="df-overlay"></span>';
    }

    et_divi_post_format_content();

    if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
        $video_overlay = has_post_thumbnail() ? sprintf(
            '<div class="et_pb_video_overlay" style="background-image: url(%1$s); background-size: cover;">
                <div class="et_pb_video_overlay_hover">
                    <a href="#" class="et_pb_video_play"></a>
                </div>
            </div>',
            $thumb
        ) : '';

        if(empty($first_video)) return;
        echo sprintf(
            '<div class="df-item-wrap df-cpt-image-wrap %3$s %4$s">
                <div class="et_main_video_container">
                    %1$s
                    %2$s
                </div>
            </div>',
            et_core_esc_previously( $video_overlay ),
            et_core_esc_previously( $first_video ),
            esc_attr($settings['class']),
            esc_attr($module_class)
        );
    else:
        if(!empty($thumb)) {
            echo sprintf('<div class="df-item-wrap df-cpt-image-wrap %3$s %7$s">
                    %8$s
                    <a class="%4$s" href="%2$s">%1$s%5$s%6$s</a>
                </div>',
                wp_kses_post($post_thumbnail),
                esc_url(get_the_permalink()),
                esc_attr($settings['class']),
                esc_attr($classes),
                et_core_esc_previously($overlay),
                et_core_esc_previously($overlay_icon),
                esc_attr($module_class),
                et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
            );
        } elseif (empty($thumb) && $builder === true) {
            echo sprintf('<div class="df-item-wrap df-cpt-image-wrap df-empty-element %1$s %2$s"></div>',
                esc_attr($settings['class']),
                esc_attr($module_class)
            );
        };

    endif;
}


/**
 * CPT Date
 *
 * @param Array $settings
 */
function df_cpt_date($settings = array(), $builder = false) {
    global $post;


    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    echo sprintf('<span class="df-item-wrap df-cpt-date-wrap %2$s %4$s">%5$s %3$s %1$s</span>',
        get_the_date($settings['date_format']),
        esc_attr($settings['class']),
        et_core_esc_previously(df_cpt_render_icon_image($settings)),
        esc_attr($module_class),
        et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
    );
}
/**
 * CPT Author
 *
 * @param Array $settings
 */
function df_cpt_author($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    $height = '';
    $min_height = '';

    if($settings['show_author_image'] === 'on') {
        $height = $settings['author_image_size'] . 'px';
        $min_height = ' style=height:'.$settings['author_image_size'].'px;';
    }

    $author_image = 'on' === $settings['show_author_image'] ? sprintf(
        '<a href="%2$s" class="author-image">%1$s</a> ',
        get_avatar( get_the_author_meta( 'ID' ), $settings['author_image_size'] ),
        get_author_posts_url( get_the_author_meta( 'ID' ) )
    ) : '';

    $author_link = 'on' === $settings['show_author_image'] && 'on' === $settings['hide_author_text'] ?
        '' : et_pb_get_the_author_posts_link();

    echo sprintf('<span class="df-item-wrap df-cpt-author-wrap %2$s %6$s">%7$s %4$s %3$s %1$s</span>',
        et_core_esc_previously($author_link),
        esc_attr($settings['class']),
        et_core_esc_previously($author_image),
        et_core_esc_previously(df_cpt_render_icon_image($settings)),
        et_core_esc_previously($min_height),
        esc_attr($module_class),
        et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
    );
}
/**
 * CPT Title
 *
 * @param Array $settings
 */
function df_cpt_title($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    if(!empty(get_the_title())) {
        echo sprintf('<div class="df-item-wrap df-cpt-title-wrap %4$s %5$s">
                %6$s
                <%3$s class="df-cpt-title">
                    <a href="%2$s">
                        %1$s
                    </a>
                </%3$s>
            </div>',
            wp_kses_post(get_the_title()),
            esc_url(get_the_permalink()),
            esc_attr($settings['title_tag']),
            esc_attr($settings['class']),
            esc_attr($module_class),
            et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
        );
    } elseif (empty(get_the_title()) && $builder === true) {
        echo sprintf('<div class="df-item-wrap df-cpt-title-wrap df-empty-element %1$s %2$s"></div>',
            esc_attr($settings['class']),
            esc_attr($module_class)
        );
    }

}

/**
 * CPT Content
 *
 * @param Array $settings
 * @param Boolean
 */
function df_cpt_content($settings = array(), $builder = false) {
    global $post, $et_fb_processing_shortcode_object, $et_pb_rendering_column_content;

    $post_content = et_strip_shortcodes( et_delete_post_first_video( get_the_content() ), true );
    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    echo '<div class="df-item-wrap df-cpt-content-wrap '.esc_attr($settings['class']) . ' ' . esc_attr($module_class) .'">';
        echo et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ));
        if('content' === $settings['post_content']) {
            global $more;

            // page builder doesn't support more tag, so display the_content() in case of post made with page builder
            if ( et_pb_is_pagebuilder_used( get_the_ID() ) ) {
                $more = 1; // phpcs:ignore WordPress.WP.GlobalVariablesOverride

                echo et_core_intentionally_unescaped( apply_filters( 'the_content', $post_content ), 'html' );
            } else {
                $more = null; // phpcs:ignore WordPress.WP.GlobalVariablesOverride

                echo et_core_intentionally_unescaped( apply_filters( 'the_content', et_delete_post_first_video( get_the_content( esc_html__( 'read more...', 'divi_flash' ) ) ) ), 'html' );
            }
        } elseif('excerpt' === $settings['post_content']) {
            if ( has_excerpt() && 'on' === $settings['use_post_excrpt']) {
                $excerpt = get_the_excerpt();
                $excerpt = substr( $excerpt , 0, intval($settings['excerpt_length']));

                if (strlen($excerpt)>=intval($settings['excerpt_length'])) {
                    $excerpt =  $excerpt.'...';
                }
                $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	            echo wp_kses_post( $excerpt );

            } else {
                echo et_core_intentionally_unescaped( wpautop( et_delete_post_first_video( strip_shortcodes( truncate_post( intval($settings['excerpt_length']), false, '', true ) ) ) ), 'html' );
            }
        }
    echo '</div>';
}


/**
 * CPT Read More Button
 *
 * @param Array $settings
 * @param Boolean
 * @return void
 */
function df_cpt_button($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    $output = sprintf('<div class="df-item-wrap df-cpt-button-wrap %2$s %5$s">
            %6$s
            <a class="df-cpt-read-more" href="%1$s"><span>%3$s</span> %4$s</a>
        </div>',
        get_the_permalink(),
        esc_attr($settings['class']),
        esc_html($settings['read_more_text']),
        df_cpt_render_icon_image($settings),
        esc_attr($module_class),
        et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
    );

    echo et_core_esc_previously($output);
}

/**
 * CPT element divider
 *
 * @param Array $settings
 * @param Boolean
 * @return void
 */
function df_cpt_divider($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    echo sprintf(
        '<div class="df-item-wrap %1$s %2$s">
            %3$s
            <span class="df-cpt-ele-divider"></span>
        </div>',
        esc_attr($settings['class']),
        esc_attr($module_class),
        et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
    );
}

/**
 * CPT Custom Text
 *
 * @param Array $settings
 * @param Boolean
 */
function df_cpt_custom_text($settings = array(), $builder = false) {
    global $post;

    if( $settings['custom_text'] === '' ) return;
    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    echo sprintf('<span class="df-item-wrap df-cpt-custom-text %2$s %3$s">%4$s %1$s</span>',
        esc_html__($settings['custom_text'], 'divi_flash'),
        esc_attr($settings['class']),
        esc_attr($module_class),
        et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
    );
}

/**
 * CPT Icon
 *
 * @param Array $settings
 */
function df_cpt_icon($settings = array(), $builder = false) {
    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    if(!empty(get_the_title())) {
        echo sprintf('<div class="df-item-wrap df-cpt-icon-wrap %2$s %3$s">
            %4$s
            <div class="df-cpt-icon">%1$s</div>
            </div>',
            et_core_esc_previously( df_cpt_render_icon_image($settings) ),
            esc_attr($settings['class']),
            esc_attr($module_class),
            et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
        );
    }
}


/**
 * CPT taxonomies
 *
 * @param Array $settings
 * @param Boolean
 * @return String
 */
function df_cpt_taxonomy($settings = [], $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    if ($settings['taxonomy'] === 'select_tax') return;
    if(!taxonomy_exists($settings['taxonomy'])) return;
	$taxonomies = get_the_term_list($post->ID, $settings['taxonomy'], '', $settings['separator_tax'], '');

    if(!empty($taxonomies)) {
        echo sprintf('<span class="df-item-wrap df-cpt-taxonomies %1$s %2$s">
                %7$s %6$s %3$s %4$s %5$s
            </span>',
            esc_attr($settings['class']),
            esc_attr($module_class),
	        et_core_esc_previously(df_tax_before_after($settings)['before']),
            wp_kses_post($taxonomies),
	        et_core_esc_previously(df_tax_before_after($settings)['after']),
            et_core_esc_previously(df_cpt_render_icon_image($settings)),
            et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
        );
    } elseif(empty($taxonomies) && $builder === true) {
        echo sprintf('<span class="df-item-wrap df-cpt-taxonomies df-empty-element %1$s %2$s"></span>',
            esc_attr($settings['class']),
            esc_attr($module_class)
        );
    }


}

function df_tax_before_after($settings){
	$before_label = isset($settings['tax_before_label'])?esc_attr($settings['tax_before_label']):"";
	$after_label = isset($settings['tax_after_label'])?esc_attr($settings['tax_after_label']):"";

	return array(
		'before' => $before_label !== '' ? sprintf('<span class="tax-before-text">%1$s</span>', $before_label) : '',
		'after' => $after_label !== '' ? sprintf('<span class="tax-after-text">%1$s</span>', $after_label) : ''
	);
}

/**
 * CPT image as background
 *
 * @param String $use_image_as_background
 * @return String
 */
function df_cpt_image_as_background($use_image_as_background) {
    global $post;
    // use_image_as_background
    if($use_image_as_background === 'on' && !empty(get_the_post_thumbnail_url($post->ID))) {
        return sprintf('style="background-image:url(%1$s);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-origin: border-box;"',
            get_the_post_thumbnail_url($post->ID)
        );
    }
}

/**
 * Render markup for acf fields
 *
 * Supported fields: 'text', 'number', 'textarea', 'range', 'email', 'url', 'image', 'select', 'date_picker', 'wysiwyg'
 *
 * @param Array $settings
 * @param Boolean
 * @return String
 */
function df_cpt_acf_fields($settings = [], $builder = false) {
   df_acf_fields_function($settings , $builder);
}

function df_cpt_metabox_fields($settings = [], $builder = false) {
	df_metabox_fields_function($settings , $builder);
}

/**
 * CPTGrid: Render Posts for CPTGrid Module on VB
 *
 */
add_action('wp_ajax_df_cpt_grid', 'df_cpt_grid');
function df_cpt_grid() {
    global $paged, $post, $wp_query, $wp_filter, $__et_blog_module_paged;

    // create the display gallery code
    $data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }

    $cpt_items = isset($data['cptItems']) ? $data['cptItems'] : array();

    $cpt_item_inner = isset($cpt_items['inner']) ? $cpt_items['inner'] : array();
    $cpt_item_outer = isset($cpt_items['outer']) ? $cpt_items['outer'] : array();

    $post_type = isset($data['post_type']) ? $data['post_type'] : ' project';
    $posts_number = isset($data['posts_number']) ? intval($data['posts_number']) : 10;
    $post_display = isset($data['post_display']) ? $data['post_display'] : 'recent';
    $orderby = isset($data['orderby']) ? $data['orderby'] : '1';
    $selected_taxonomy = isset($data['selected_taxonomy']) ? $data['selected_taxonomy'] : '';
    $selected_terms = isset($data['selected_terms']) ? $data['selected_terms'] : '';
    $offset_number = isset($data['offset_number']) ? $data['offset_number']: '0';
    $layout = isset($data['layout']) ? $data['layout'] : 'grid';
    $use_image_as_background = isset($data['use_image_as_background']) ? $data['use_image_as_background'] : 'off';
    $use_background_scale = isset($data['use_background_scale']) ? $data['use_background_scale'] : 'off';
    $equal_height = isset($data['equal_height']) ? $data['equal_height'] : 'off';
    $show_pagination = isset($data['show_pagination']) ? $data['show_pagination'] : 'off';
    $use_number_pagination = isset($data['use_number_pagination']) ? $data['use_number_pagination'] : 'off';
    $older_text = isset($data['older_text']) ? $data['older_text'] : 'Older Entries';
    $newer_text = isset($data['newer_text']) ? $data['newer_text'] : 'Next Entries';
    $use_current_loop = $data['use_current_loop'];
    $post_type_arch = $data['post_type_arch'];
    $use_icon_only_at_pagination = isset($data['use_icon_only_at_pagination']) ? $data['use_icon_only_at_pagination'] : 'off';

    $post_type = $use_current_loop === 'on' ? $post_type_arch : $post_type;

    $query_args = array(
        'posts_per_page' => $posts_number,
        'post_status'    => array( 'publish' ),
        'post_type'      => $post_type,
    );

    if(empty($post_type) || 'select' === $post_type) {
        wp_send_json_success('<h2 style="background:#eee; padding: 10px 20px;">Please select a <strong>Post Type</strong>.</h2>');
        return;
    }

    // by taxonomy
    if( 'by_tax' === $post_display && '' !== $selected_terms ) {
 
        if(! str_contains($selected_terms, 'current')){ // If current term check then default query run.
            $query_args['tax_query'] = array( //phpcs:ignore WordPress.DB.SlowDBQuery
                'relation' => 'AND',
                array(
                    'taxonomy'  => $selected_taxonomy,
                    'field'     => 'term_id',
                    'terms'     => explode(',', $selected_terms)
                )
            );
        }
    }
    // orderby

    if ('2' === $orderby) {
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'ASC';
    } else if ('3' === $orderby
    ) {
        $query_args['orderby'] = 'title';
        $query_args['order'] = 'ASC';
    } else if ('4' === $orderby
    ) {
        $query_args['orderby'] = 'title';
        $query_args['order'] = 'DESC';
    } else if ('5' === $orderby
    ) {
        $query_args['orderby'] = 'rand';
    } else if ('6' === $orderby
    ) {
        $query_args['orderby'] = 'menu_order';
        $query_args['order'] = 'ASC';
    } else if ('7' === $orderby
    ) {
        $query_args['orderby'] = 'menu_order';
        $query_args['order'] = 'DESC';
    } else {
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'DESC';
    }

    $df_pg_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
    if ( is_front_page() ) {
        $paged = $df_pg_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride
    }
    if ( $__et_blog_module_paged > 1 ) {
        $df_pg_paged            = $__et_blog_module_paged;
        $paged                  = $__et_blog_module_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride
        $query_args['paged']    = $__et_blog_module_paged;
    }
    if ( ! is_search() ) {
        $paged = $df_pg_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride
        $query_args['paged'] = $df_pg_paged;
    }else{
	    $query_args['paged'] = $df_pg_paged;
    }

    if ( '' !== $offset_number && ! empty( $offset_number ) ) {
        /**
         * Offset + pagination don't play well. Manual offset calculation required
         *
         * @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
         */
        if ( $paged > 1 ) {
            $query_args['offset'] = ( ( $df_pg_paged - 1 ) * intval( $posts_number ) ) + intval( $offset_number );
        } else {
            $query_args['offset'] = intval( $offset_number );
        }
    }

    ob_start();
    query_posts( $query_args ); // phpcs:ignore WordPress.WP.DiscouragedFunctions

    echo '<div class="df-cpts-wrap layout-'.esc_attr($layout).'">';
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();

            $equal_height_class = $equal_height === 'on' ? ' df-equal-height' : '';
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( "df-cpt-item v2{$equal_height_class}" ) ?>>
                <div class="df-cpt-outer-wrap df-hover-trigger" <?php echo $use_background_scale !== 'on' ? et_core_esc_previously(df_cpt_image_as_background($use_image_as_background)): '';?>>
                    <?php
                        // render markup to achive the scale effect.
                        if($use_image_as_background === 'on' && $use_background_scale === 'on') {
                            echo '<div class="df-cpt-bg-on-hover"><div ' . et_core_esc_previously(df_cpt_image_as_background($use_image_as_background)) .'></div></div>';
                        }
                        if(!empty($cpt_item_outer)) {
                            foreach( $cpt_item_outer as $cpt_item ) {

                                if( !isset($cpt_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_cpt_' . $cpt_item['type'];

                                call_user_func($callback, $cpt_item, true);

                            } // end of foreach
                        }
                    ?>
                    <div class="df-cpt-inner-wrap">
                        <?php
                            foreach( $cpt_item_inner as $cpt_item ) {

                                if( !isset($cpt_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_cpt_' . $cpt_item['type'];

                                call_user_func($callback, $cpt_item, true);

                            } // end of foreach
                        ?>
                    </div>
                </div>
            </article>
            <?php
        } // endwhile
    }
    echo '</div>';

    // ajax navigation
    if ( 'on' === $show_pagination ) {
        if ( function_exists( 'wp_pagenavi' ) ) {
            wp_pagenavi();
        } else {
            add_filter( 'get_pagenum_link', array( 'DIFL_CptGrid', 'filter_pagination_url' ) );
            if ($use_number_pagination !== 'on') {
                cpt_render_pagination($older_text, $newer_text, $use_icon_only_at_pagination, true);
            } else {
                cpt_render_number_pagination($older_text, $newer_text, $use_icon_only_at_pagination, true);
            }
            remove_filter( 'get_pagenum_link', array( 'DIFL_CptGrid', 'filter_pagination_url' ) );
        }
    }

    wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
    $posts = ob_get_contents();
    ob_end_clean();

    if(empty($cpt_items)) {
        $posts = '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Item</strong> to continue.</h2>';
    }

    wp_send_json_success($posts);
}

function df_display_cpt_grid_load_actions( $actions ) {
	$actions[] = 'df_cpt_grid';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'df_display_cpt_grid_load_actions' );

/**
 * CptFilter: Render Posts for CptFilter Module on VB
 *
 */

add_action('wp_ajax_df_cpt_filter', 'df_cpt_filter');
function df_cpt_filter() {
    global $paged, $post, $wp_query, $wp_filter, $__et_blog_module_paged, $et_fb_processing_shortcode_object, $et_pb_rendering_column_content;

    // create the display gallery code
    $data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }

    $cpt_items = isset($data['cptItems']) ? $data['cptItems'] : array();

    $post_type = isset($data['post_type']) ? $data['post_type'] : ' project';
    $posts_number = isset($data['posts_number']) ? intval($data['posts_number']) : 10;
    $post_display = isset($data['post_display']) ? $data['post_display'] : 'recent';
    $use_search_bar = isset($data['use_search_bar']) ? $data['use_search_bar'] : 'off';
    $orderby = isset($data['orderby']) ? $data['orderby'] : '1';
    $selected_taxonomy = isset($data['selected_taxonomy']) ? $data['selected_taxonomy'] : '';
    $selected_terms = isset($data['selected_terms']) ? $data['selected_terms'] : '';
    $offset_number = isset($data['offset_number']) ? $data['offset_number']: '0';
    $all_items = isset($data['all_items']) ? $data['all_items'] : 'off';
    $all_items_text = isset($data['all_items_text']) ? $data['all_items_text'] : 'All';
    $selected_texonomy_list = isset($data['selected_texonomy_list']) ? $data['selected_texonomy_list'] : '';
    $acf_filter = isset($data['acf_filter']) ? $data['acf_filter'] : 'off';
	  $acf_filter_options = isset($data['acf_filter_options']) ? $data['acf_filter_options'] : '';
  	$entire_item_clickable = isset($data['entire_item_clickable']) ? $data['entire_item_clickable'] : 'off';
	  $enable_mobile_responsive = isset($data['enable_mobile_responsive']) ? sanitize_text_field($data['enable_mobile_responsive']) : 'on';
    $query_args = array(
        'posts_per_page' => $posts_number,
        'post_status'    => array( 'publish' ),
        'post_type'      => $post_type,
    );
    // orderby
    if ( '2' === $orderby ) {
        $query_args['orderby'] = 'date';
        $query_args[ 'order' ] = 'ASC';
    }
    else if('3' === $orderby) {
        $query_args['orderby'] = 'title';
        $query_args['order'] = 'ASC';
    }
    else if('4' === $orderby) {
        $query_args['orderby'] = 'title';
        $query_args['order'] = 'DESC';
    }
    else if( '5' === $orderby ) {
        $query_args[ 'orderby' ] = 'rand';
    } 
    else if( '6' === $orderby ) {
        $query_args['orderby'] = 'menu_order';
        $query_args['order'] = 'ASC';
    }
    else if( '7' === $orderby ) {
        $query_args['orderby'] = 'menu_order';
        $query_args['order'] = 'DESC';
    }
    else{
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'DESC';
    }

    //by Multiple texonomy filter
    $multiple_cat = array();
    if($post_display === 'multiple_filter'){

        $selected_multi = explode("|", $selected_texonomy_list);
        $taxonomies = get_object_taxonomies( $post_type);

        $list_multi_key = array_values($taxonomies);

	    $iMax = count( $selected_multi );
        for($i =0; $i < $iMax; $i++){
            if($selected_multi[$i] === 'on'){
                $multiple_cat[] = $list_multi_key[ $i ];
            }
        }
        if(empty($multiple_cat)){
            wp_send_json_success('<h2 style="background:#eee; padding: 10px 20px;">Please select any <strong>Taxonomy</strong>.</h2>');
            return;
        }
        $terms_query   = [];
        foreach($multiple_cat as $cat){

            $terms = get_terms( array(
                'taxonomy' => $cat,
                'hide_empty' => true,
            ) );

            $permittedValues = array_values($terms);

            //$all_terms = $str = implode (", ", array_column($permittedValues, 'term_id'));
            $all_terms = $str = array_column($permittedValues, 'term_id'); // Fixed load data from first term id. Now data come from all term id. 
            $terms_query[] = [
                'taxonomy' => $cat,
                'field'    => 'term_id',
                'terms'    => $all_terms,
            ];

        }
        $multi_filter_type = isset($data['multi_filter_type']) ? sanitize_text_field($data['multi_filter_type']) : 'AND';
        if (!empty($terms_query)) {

            $query_args['tax_query']             = $terms_query;
            $query_args['tax_query']['relation'] = 'OR';//$multi_filter_type;
        }

    }
    // by taxonomy
    else if('' !== $selected_terms) {
        $selected_terms_array = explode(',', $selected_terms);
	    $initial_term_id = $selected_terms_array[0];
	    if(str_contains($selected_terms, 'current') && is_single()){
		    $terms = explode(',', $selected_terms);
	    }else{
		    $terms = 'current' !== $initial_term_id && 'on' !== $all_items ? $initial_term_id: $selected_terms_array;
	    }
	    $query_args['tax_query'] = array( //phpcs:ignore WordPress.DB.SlowDBQuery
		    'relation' => 'AND',
		    array(
			    'taxonomy'  => $selected_taxonomy,
			    'field'     => 'term_id',
			    'terms'     => $terms
		    )
	    );

    }
    else {
        wp_send_json_success('<h2 style="background:#eee; padding: 10px 20px;">Please select a <strong>Post Type</strong>, <strong>Taxonomy</strong> and <strong>Terms</strong>.</h2>');
        return;
    }

    $df_pg_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
    if ( is_front_page() ) {
        $paged = $df_pg_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride
    }
    if ( $__et_blog_module_paged > 1 ) {
        $df_pg_paged            = $__et_blog_module_paged;
        $paged                  = $__et_blog_module_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride
        $query_args['paged']    = $__et_blog_module_paged;
    }
    if ( ! is_search() ) {
        $paged = $df_pg_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride
        $query_args['paged'] = $df_pg_paged;
    }else{
	    $query_args['paged'] = $df_pg_paged;
    }

    if ( '' !== $offset_number && ! empty( $offset_number ) ) {
        /**
         * Offset + pagination don't play well. Manual offset calculation required
         *
         * @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
         */
        if ( $paged > 1 ) {
            $query_args['offset'] = ( ( $df_pg_paged - 1 ) * intval( $posts_number ) ) + intval( $offset_number );
        } else {
            $query_args['offset'] = intval( $offset_number );
        }
    }

    $cpt_grid_options = array(
        'layout' => isset($data['layout']) ? $data['layout'] : 'grid',
        'cpt_item_inner' => isset($cpt_items['inner']) ? $cpt_items['inner'] : array(),
        'cpt_item_outer' => isset($cpt_items['outer']) ? $cpt_items['outer'] : array(),
        'equal_height' => isset($data['equal_height']) ? $data['equal_height'] : 'off',
        'use_image_as_background' => isset($data['use_image_as_background']) ? $data['use_image_as_background'] : 'off',
        'use_background_scale' => isset($data['use_background_scale']) ? $data['use_background_scale'] : 'off',
        'load_more' => isset($data['load_more']) ? $data['load_more'] : 'off',
        'use_load_more_icon' => isset($data['use_load_more_icon']) ? $data['use_load_more_icon'] : '',
        'load_more_font_icon' => isset($data['load_more_font_icon']) ? $data['load_more_font_icon'] : '',
        'load_more_icon_pos' => isset($data['load_more_icon_pos']) ? $data['load_more_icon_pos'] : '',
        'use_load_more_text' => isset($data['use_load_more_text']) ? $data['use_load_more_text'] : '',
        'use_search_bar' => isset($data['use_search_bar']) ? $data['use_search_bar'] : 'off',
        'use_search_bar_icon' => isset($data['use_search_bar_icon']) ? $data['use_search_bar_icon'] : '',
        'search_bar_font_icon' => isset($data['search_bar_font_icon']) ? $data['search_bar_font_icon'] : '&#x55;',
        'use_only_search_bar_icon' => isset($data['use_only_search_bar_icon']) ? $data['use_only_search_bar_icon'] : 'off',
        'search_button_icon_placement' => isset($data['search_button_icon_placement']) ? $data['search_button_icon_placement'] : 'right',
        'search_bar_button_text' => isset($data['search_bar_button_text']) ? $data['search_bar_button_text'] : '',
        'search_bar_placeholder_text' => isset($data['search_bar_placeholder_text']) ? $data['search_bar_placeholder_text'] : '',
        'multi_filter_dropdown_placeholder_prefix'=> isset($data['multi_filter_dropdown_placeholder_prefix']) ? $data['multi_filter_dropdown_placeholder_prefix'] : ''
    );

    $post_orderby = ! empty( $query_args['orderby'] ) ? $query_args['orderby'] : 'date';

    ob_start();
    query_posts( $query_args ); // phpcs:ignore WordPress.WP.DiscouragedFunctions

    // render Cpt Filter navigation
	echo "<div class='filter_section " . (("on" === $enable_mobile_responsive) ? 'df_phn_resp' : '') . "'><div class='filter_wrapper'>";
	echo '<div class="difl_filter_short_desc_card_header">
            <div class="filter_elements">
                <div class="filter_element_card">
                    <span class="filter_element_card_text">Active Filter Data</span>
                    <a class="filter_element_card_close" href="javascript:void(0);">x</a>
                </div>
            </div>
         </div>';
    echo "<div class='filter_field_wrapper'>";
    if($use_search_bar === 'on'){
        echo et_core_esc_previously(df_search_filter_html(
            $cpt_grid_options['use_search_bar_icon'],
            $cpt_grid_options['search_bar_font_icon'],
            $cpt_grid_options['search_bar_placeholder_text'],
            $cpt_grid_options['search_bar_button_text'],
            $cpt_grid_options['use_only_search_bar_icon'],
            $cpt_grid_options['search_button_icon_placement']
        ));
    }

    if($post_display === 'multiple_filter') {
	    echo '<ul class="multi_filter_container">';
	    echo et_core_esc_previously (generate_taxonomy_dropdown($multiple_cat , $data));
	    /* ACF Filter */
	    if('on' === $acf_filter){
		    $cpt_filter = new ACF_Data_Process_for_Builder($post_type, $acf_filter_options);
		    $cpt_filter->get_acf_filter_values();
		    echo et_core_esc_previously(generate_acf_filter_fields($post_type, $cpt_filter->selected_acf_filter_fields, $cpt_filter->df_acf_field_details_for_filter, $data));
	    }
	    /* ACF Filter */
	    echo '</ul>';
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
	if($post_display !== 'multiple_filter') {
		echo et_core_esc_previously(render_cpt_filter_nav (
			$post_type,
			$selected_taxonomy,
			$selected_terms,
			$all_items,
			$all_items_text,
			$post_orderby
		));
	}
    echo '<div class="df-cpts-wrap layout-'.esc_attr($cpt_grid_options['layout']).'">';
    echo '<div class="df-cpts-inner-wrap">';
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            
            $this_post_orderby = 'date';
            if ('date' === $post_orderby) {
                $this_post_orderby = get_the_date('U');
            } elseif ('title' === $post_orderby) {
                $shorten_code = str_replace(' ', '', strtolower( get_the_title() ) );
                $this_post_orderby = substr( $shorten_code, 0, 10 );
            }else if('menu_order' === $post_orderby){
                $this_post_orderby = $post->menu_order;
            }

            $equal_height_class = $cpt_grid_options['equal_height'] === 'on' ? ' df-equal-height' : '';
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( "df-cpt-item v2{$equal_height_class}" ) ?> data-order="<?php echo esc_attr( $this_post_orderby ); ?>"
	             <?php if ('on' === $entire_item_clickable) { echo 'onclick="location.href=\'', esc_url(get_the_permalink()), '\'" style="cursor:pointer;"';} ?>
            >
                <div class="df-cpt-outer-wrap df-hover-trigger"
                    <?php echo $cpt_grid_options['use_background_scale'] !== 'on' ? et_core_esc_previously(df_cpt_image_as_background($cpt_grid_options['use_image_as_background'])) : '';?>>
                    <?php
                        // render markup to achive the scale effect.
                        if($cpt_grid_options['use_image_as_background'] === 'on' && $cpt_grid_options['use_background_scale'] === 'on') {
                            echo '<div class="df-cpt-bg-on-hover"><div ' . et_core_esc_previously(df_cpt_image_as_background($cpt_grid_options['use_image_as_background'])) .'></div></div>';
                        }
                        if(!empty($cpt_grid_options['cpt_item_outer'])) {
                            foreach( $cpt_grid_options['cpt_item_outer'] as $cpt_item ) {

                                if( !isset($cpt_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_cpt_' . $cpt_item['type'];

                                call_user_func($callback, $cpt_item, true);

                            } // end of foreach
                        }
                    ?>
                    <div class="df-cpt-inner-wrap">
                        <?php
                            foreach( $cpt_grid_options['cpt_item_inner'] as $cpt_item ) {

                                if( !isset($cpt_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_cpt_' . $cpt_item['type'];

                                call_user_func($callback, $cpt_item, true);

                            } // end of foreach
                        ?>
                    </div>
                </div>
            </article>
            <?php
        } // endwhile
    }
    echo '</div>';

    // loading load more pagination
    if('on' === $cpt_grid_options['load_more']) {
        if (  $wp_query->max_num_pages > 1 ) {
            df_cpt_filter_load_more_btn(
                'all',
                $wp_query->max_num_pages,
                $cpt_grid_options['use_load_more_icon'],
                $cpt_grid_options['load_more_font_icon'],
                $cpt_grid_options['load_more_icon_pos'],
                $cpt_grid_options['use_load_more_text']
            );
        }
    }
    echo '</div>';

    wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
    $posts = ob_get_contents();
    ob_end_clean();

    if(empty($cpt_items)) {
        $posts = '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Item</strong> to continue.</h2>';
    }

    wp_send_json_success($posts);
}

/**
 * CPTFilter: Process Divi builder shortcode on ajax call
 * Builder, Filter, Loadmore
 *
 */
function df_display_cpt_filter_load_actions( $actions ) {
    $actions[] = 'df_cpt_filter_data';
    $actions[] = 'df_cpt_filter';
    return $actions;
}
add_filter( 'et_builder_load_actions', 'df_display_cpt_filter_load_actions' );

/**
 * CPT Filter: process grid data
 *
 * @return String HTML
 */
function df_process_filter_grid_data($cpt_grid_options = array(), $term_id = ''){
    global $wp_query, $post;
    $custom_post_type = '';
    ob_start();
    echo '<div class="df-cpts-inner-wrap">';

    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            $width = 'on' === 1080;
            // $width = 'on' === $fullwidth ? 1080 : 400;
            $width = (int) apply_filters( 'et_pb_blog_image_width', $width );

            $height    = 'on' === 675;
            $height    = (int) apply_filters( 'et_pb_blog_image_height', $height );
            $equal_height_class = $cpt_grid_options['equal_height'] === 'on' ? ' df-equal-height' : '';

            $outer_content = '';
            $inner_content = '';

            $post_orderby = $cpt_grid_options['orderby'];

            if ('date' === $post_orderby) {
                $post_orderby = get_the_date('U');
            } else if ('title' === $post_orderby) {
                $shorten_code = str_replace(' ', '', strtolower( get_the_title() ) );
                $post_orderby = substr( $shorten_code, 0, 10 );
            }else if('menu_order' === $post_orderby){
                $post_orderby = $post->menu_order;
            }

            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( "df-cpt-item v2{$equal_height_class}" ) ?> data-height='auto' data-order="<?php echo esc_attr( $post_orderby ); ?>" <?php if ('on' === $cpt_grid_options['entire_item_clickable']) { echo 'onclick="location.href=\'', esc_url(get_the_permalink()), '\'" style="cursor:pointer;"';} ?>>
                <div class="df-cpt-outer-wrap df-hover-trigger"
                    <?php echo $cpt_grid_options['use_background_scale'] !== 'on' ? et_core_esc_previously(df_cpt_image_as_background($cpt_grid_options['use_image_as_background'])) : '';?>>
                    <?php
                        // render markup to achive the scale effect.
                        if($cpt_grid_options['use_image_as_background'] === 'on' && $cpt_grid_options['use_background_scale'] === 'on') {
                            echo '<div class="df-cpt-bg-on-hover"><div ' . et_core_esc_previously(df_cpt_image_as_background($cpt_grid_options['use_image_as_background'])) .'></div></div>';
                        }
                        if( !empty($cpt_grid_options['cpt_item_outer']) ) {
                            foreach( $cpt_grid_options['cpt_item_outer'] as $post_item ) {

                                if( !isset($post_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_cpt_' . $post_item['type'];

                                call_user_func($callback, $post_item);

                            } // end of foreach
                        }
                    ?>
                    <div class="df-cpt-inner-wrap">
                        <?php
                            if( !empty( $cpt_grid_options['cpt_item_inner'] ) ) {
                                foreach( $cpt_grid_options['cpt_item_inner'] as $post_item ) {

                                    if( !isset($post_item['type'])) {
                                        continue;
                                    }

                                    $callback = 'df_cpt_' . $post_item['type'];

                                    call_user_func($callback, $post_item);
                                }
                            }
                            // end of foreach
                        ?>
                    </div>
                </div>
            </article>
            <?php
        } // endwhile


    }
    else{
        $empty_post_message = 'on' === $cpt_grid_options['use_empty_post_message'] && isset($cpt_grid_options['empty_post_message']) && $cpt_grid_options['empty_post_message'] !== ''? $cpt_grid_options['empty_post_message'] : 'No data found.';
       
        echo '<h2 class="no-post"style="background-color:#eee; padding: 10px 20px; text-align:center">'. esc_html__( $empty_post_message , 'divi_flash' ) .'</h2>';
    }
    echo '</div>';

    if('on' === $cpt_grid_options['load_more']) {
        // loading load more pagination
        if (  $wp_query->max_num_pages > 1) {
            df_cpt_filter_load_more_btn(
                $term_id,
                $wp_query->max_num_pages,
                $cpt_grid_options['use_load_more_icon'],
                $cpt_grid_options['load_more_font_icon'],
                $cpt_grid_options['load_more_icon_pos'],
                $cpt_grid_options['use_load_more_text']
            );
        }
    }

    $posts = ob_get_contents();
    ob_end_clean();
    return $posts;
}

/**
 * CPT Filter: Rendering filtered data.
 * Fetch Request.
 *
 */
add_action('wp_ajax_df_cpt_filter_data', 'df_cpt_filter_data');
add_action('wp_ajax_nopriv_df_cpt_filter_data', 'df_cpt_filter_data');

function df_cpt_filter_data() {
    global $post, $paged, $wp_query, $wp_the_query, $wp_filter, $__et_blog_module_paged;

    $main_query = $wp_the_query;

    if (isset($_POST['et_frontend_nonce']) && !wp_verify_nonce( sanitize_text_field($_POST['et_frontend_nonce']), 'et_frontend_nonce' ) ) {
        wp_die();
    }

    if(!function_exists('et_pb_post_format')) {
        require_once get_template_directory() . '/includes/builder/functions.php';
    }
    if(!class_exists('Df_Acf_Fields')) {
        require_once( DIFL_MAIN_DIR . '/includes/classes/df-acf-fields.php' );
    }

    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : '';
    $post_display = isset($_POST['post_display']) ? sanitize_text_field($_POST['post_display']) : '';
    $posts_number = isset($_POST['posts_number']) ? sanitize_text_field($_POST['posts_number']) : '';
    $offset_number = isset($_POST['offset_number']) ? sanitize_text_field($_POST['offset_number']) : 0;
	$load_more = isset($_POST['load_more']) ? sanitize_text_field($_POST['load_more']) : 'off';
	$_request = isset($_POST['_request']) ? sanitize_text_field($_POST['_request']) : 'filter';
	$current_paged = isset($_POST['current_page']) ? sanitize_text_field($_POST['current_page']) : '';

	$term_id = isset($_POST['term_id']) && !empty($_POST['term_id']) ? sanitize_text_field($_POST['term_id']) : 'all';

    $taxonomy = isset($_POST['selected_tax']) ? sanitize_text_field($_POST['selected_tax']) : '';
    $taxonomy = str_replace('\\', '', $taxonomy);
    $enable_acf_filter = isset($_POST['enable_acf_filter']) ? sanitize_text_field($_POST['enable_acf_filter']) : '';
    $acf_data = isset($_POST['selected_acf']) ? sanitize_text_field($_POST['selected_acf']) : '';
    $entire_item_clickable = isset($_POST['entire_item_clickable']) ? sanitize_text_field($_POST['entire_item_clickable']) : 'off';

    $query_args = array(
        'posts_per_page' => intval($posts_number),
        'post_status'    => array( 'publish' ),
        'perm'           => 'readable',
        'post_type'      => $post_type,
        'paged'          => 'filter' === $_request ? 1 : intval($current_paged) + 1
    );
    // order by
    if (isset($_POST['orderby']) && '2' === $_POST['orderby']) {
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'ASC';
    } else if (isset($_POST['orderby']) && '3' === $_POST['orderby']) {
        $query_args['orderby'] = 'title';
        $query_args['order'] = 'ASC';
    } else if (isset($_POST['orderby']) && '4' === $_POST['orderby']) {
        $query_args['orderby'] = 'title';
        $query_args['order'] = 'DESC';
    } else if (isset($_POST['orderby']) && '5' === $_POST['orderby']) {
        $query_args['orderby'] = 'rand';
    } else if (isset($_POST['orderby']) && '6' === $_POST['orderby']) {
        $query_args['orderby'] = 'menu_order';
        $query_args['order'] = 'ASC';
    } else if (isset($_POST['orderby']) && '7' === $_POST['orderby']) {
        $query_args['orderby'] = 'menu_order';
        $query_args['order'] = 'DESC';
    } else {
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'DESC';
    }

	if ( '' !== $offset_number && ! empty( $offset_number ) ) {
		if ( ((int) $current_paged + 1) > 1 && 'filter' !== $_request) {
			$query_args['offset'] = ( (int) $current_paged * (int) $posts_number ) + (int) $offset_number;
		} else {
			$query_args['offset'] = (int) $offset_number;
		}
	}
    $search_value = isset($_POST['search_value']) ? sanitize_text_field( $_POST['search_value'] ) : '';

    if('' !== $search_value){
        $query_args['s'] = $search_value;
        $query_args['search_columns'] = [ 'post_content', 'post_name', 'post_title' ];
    }

    // check if all term available (by tax)
    $is_all_terms = (bool) in_array('current', explode(',', $term_id));
    $is_enable_multifilter = $post_display === 'multiple_filter';

    if($is_enable_multifilter){

        $terms_query   = [];
        $multi_texonomies = json_decode($taxonomy);

        foreach($multi_texonomies as $multi_texonomy){
            if(!empty($multi_texonomy->term_id)){
                //$slugs = substr($multi_texonomy->term_id, 1, -1);
                 $terms_query[] = [
                    'taxonomy' => $multi_texonomy->texonomy_name,
                    'field'    => 'slug',
                    'terms'    => $multi_texonomy->term_id,
                    'operator' => 'IN',
                ];
            }else{
	            $terms = get_terms( array(
		            'taxonomy' => $multi_texonomy->texonomy_name,
		            'hide_empty' => true,
	            ) );

	            $permittedValues = array_values($terms);

	            $all_terms = array_column($permittedValues, 'term_id');

	            $terms_query[] = [
		            'taxonomy' => $multi_texonomy->texonomy_name,
		            'field'     => 'term_id',
		            'terms'     =>   $all_terms
	            ];
            }

        }

        $multi_filter_type = isset($_POST['multi_filter_type']) ? sanitize_text_field($_POST['multi_filter_type']) : 'AND';
        if (!empty($terms_query)) {
            $query_args['tax_query']             = $terms_query;
            $query_args['tax_query']['relation'] =  $multi_filter_type;
        }
        if('on' === $enable_acf_filter){
	        $multi_acf_datas = json_decode(str_replace('\\', '', $acf_data));
	        $acf_meta_query  = [];
	        $fields_storage  = Df_Acf_Fields::getInstance();
	        foreach($multi_acf_datas as $multi_acf_data){
		        if(!empty($multi_acf_data->acf_value)){
			        $multi_acf_field_type = $fields_storage->acf_fields_type;
			        if(in_array($multi_acf_data->field_type, ['checkbox','select']) && in_array($multi_acf_field_type[$multi_acf_data->acf_name],['number'])){
				        $acf_meta_query[] = [
					        'key' => $multi_acf_data->acf_name,
					        'value' => $multi_acf_data->acf_value,
					        'compare' => 'IN',
				        ];
			        }
			        if(in_array($multi_acf_data->field_type, ['checkbox','select']) && in_array($multi_acf_field_type[$multi_acf_data->acf_name],['textarea', 'text', 'select'])){
				        $acf_meta_query_for_multiple = [];
				        foreach ($multi_acf_data->acf_value as $single_value){
					        $acf_meta_query_for_multiple[] = [
						        'key' => $multi_acf_data->acf_name,
						        'value' => $single_value
					        ];
				        }
				        $acf_meta_query_for_multiple['relation'] = 'OR';
				        $acf_meta_query[] = $acf_meta_query_for_multiple;
			        }
			        if('range' === $multi_acf_data->field_type){
				        $acf_meta_query[] = [
					        'key' => $multi_acf_data->acf_name,
					        'value' => $multi_acf_data->acf_value,
					        'compare' => 'BETWEEN',
					        'type' => 'NUMERIC'
				        ];
			        }
		        }

	        }
	        if (!empty($acf_meta_query)) {
		        $query_args['meta_query'] = $acf_meta_query;
		        $query_args['meta_query']['relation'] =  'AND';
	        }
        }
    }else{
        if( (! $is_all_terms && str_contains($term_id, ',')) || ('all' !== $term_id && 'current' !== $term_id) ) {
            $query_args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery
                'relation' => 'OR',
                array(
                    'taxonomy'      => str_replace(['"', '\\'], '', $taxonomy),
                    'field'         => 'term_id',
                    'terms'         => explode(',', $term_id)
                )
            );
        }
        else{
            $query_args['taxonomy'] = array( str_replace(['"', '\\'], '', $taxonomy) );
        }
    }

	$cpt_grid_options = array(
        'layout' => isset($_POST['layout']) ? sanitize_text_field($_POST['layout']) : 'grid',
        'cpt_item_inner' => isset($_POST['cpt_item_inner']) ? json_decode(stripslashes(trim(sanitize_text_field($_POST["cpt_item_inner"]), '"')), true) : array(),
        'cpt_item_outer' => isset($_POST['cpt_item_outer']) ? json_decode(stripslashes(trim(sanitize_text_field($_POST["cpt_item_outer"]), '"')), true) : array(),
        'equal_height' => isset($_POST['equal_height']) ? sanitize_text_field($_POST['equal_height']) : '',
        'use_image_as_background' => isset($_POST['use_image_as_background']) ? sanitize_text_field($_POST['use_image_as_background']) : '',
        'use_background_scale' => isset($_POST['use_background_scale']) ? sanitize_text_field($_POST['use_background_scale']) : '',
        'load_more' => $load_more,
        'use_load_more_icon' => isset($_POST['use_load_more_icon']) ? sanitize_text_field($_POST['use_load_more_icon']) : '',
        'load_more_font_icon' => isset($_POST['load_more_font_icon']) ? sanitize_text_field($_POST['load_more_font_icon']) : '',
        'load_more_icon_pos' => isset($_POST['load_more_icon_pos']) ? sanitize_text_field($_POST['load_more_icon_pos']) : '',
        'use_load_more_text' => isset($_POST['use_load_more_text']) ? sanitize_text_field($_POST['use_load_more_text']) : '',
        'use_empty_post_message' => isset($_POST['use_empty_post_message']) ? sanitize_text_field($_POST['use_empty_post_message']) : 'off',
        'empty_post_message' => isset($_POST['empty_post_message']) ? sanitize_text_field($_POST['empty_post_message']) : '',
        'orderby' => ! empty( $query_args['orderby'] ) ? $query_args['orderby'] : 'date',
        'entire_item_clickable' => $entire_item_clickable,
    );

    ob_start();
	query_posts( $query_args );

    echo et_core_esc_previously(df_process_filter_grid_data($cpt_grid_options, $term_id));
    $wp_the_query = $wp_query = $main_query; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
    wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
    $posts = ob_get_contents();
    ob_end_clean();

    wp_send_json_success($posts);
}


/**
 * CptFilter: Load more button renderer
 *
 * @param String $term_id
 * @param INT $max_num_pages
 * @param String $use_icon
 * @param String $font_icon
 * @param Strign $position
 * @param String $text | load more text
 */
function df_cpt_filter_load_more_btn($term_id, $max_num_pages, $use_icon, $font_icon, $position = 'right', $text = 'Load More'){
    $icon = 'on' == $use_icon ? sprintf('<span class="et-pb-icon df-load-more-icon">%1$s</span>',
        esc_attr(et_pb_process_font_icon($font_icon))) : '';
    $icon_right = ($position === 'right') ? $icon : '';
    $icon_left = ($position === 'left') ? $icon : '';
    echo sprintf('<div class="load-more-pagintaion-container" style="opacity:0;">
            <a class="df-cptfilter-load-more" href="#" data-term="%2$s" data-pages="%3$s" data-current="1">%5$s %1$s %4$s</a>
        </div>',
        esc_html($text),
        esc_attr($term_id),
        esc_attr($max_num_pages),
        et_core_esc_previously($icon_right),
        et_core_esc_previously($icon_left)
    );
}



function generate_multi_filter_select($class_name, $selector, $title, $label ,$options, $multi_filter_dropdown_placeholder_prefix){
	return sprintf('
                        <li class="%6$s">
                            <div class="dropdown-container">
                                %3$s
                                <div class="multi-select-component">
                                    <select  placeholder="All Terms" id="%1$s" name="%1$s" multiple data-multi-select-plugin>
                                        %2$s
                                    </select>
    
                                    <div class="search-container"><input class="selected-input" autocomplete="off" tabindex="0" placeholder="%5$s %4$s"><a href="#" class="dropdown-icon"></a></div>
                                </div>
                            </div>
                        </li>
                        ',
		$selector,
		$options,
		$title,
		esc_html__( $label),
		$multi_filter_dropdown_placeholder_prefix,
		$class_name
	);
}
function generate_multi_filter_checkbox($class_name, $selector, $label, $options){
	return sprintf('
                    <li class="%4$s">
                    	<div class="checkbox_container" id="%1$s">
	                        <span class="multi_filter_label">%3$s</span>
	                        %2$s
                    	</div> 
                    </li>
                    ',
		$selector,
		$options,
		esc_html__( $label),
		$class_name
	);
}
function generate_multi_filter_range($args = []){
	return sprintf('
                    <li class="%5$s">
                        %2$s
                        <input type="text" class="df-rangle-slider" id="%1$s" data-range_value = "%4$s" data-range=\'%3$s\' data-value="%1$s"/>
                    </li>
                    ',
		$args['selector'],
		$args['title'],
		wp_json_encode($args['data']),
		wp_json_encode([$args['data']['min'],$args['data']['max']]),
		$args['class_name']
	);
}

/**
 * CptFilter: Rendering Multiple Texonomy filter for CptFilter
 *
 * @param String | $post_type
 * @param String | $taxonomy
 * @param String | $terms
 *
 * @return String | $html
 */
 function termlist_options($tex_name , $tex_label){
    $terms = get_terms($tex_name);
    $term_name_html = "<option value='all'> All  $tex_label </option>";
    foreach($terms as $term ){
        $term_id = $term->term_id;
        $name = $term->name;
        $term_name_html .= "<option value=$term_id> $name </option>";
    }
    return $term_name_html;
}
 function get_taxonomy_field_options($tex_name) {
	$terms = get_terms($tex_name);
	$option_html = "";
	foreach($terms as $term ){
		$option_html .= sprintf('
							<label class="checkbox_content">%1$s
							  <input type="checkbox"  data-value="%2$s">
							  <span class="checkmark"></span>
							</label>',
			$term->name,
			$term->slug
		);
	}
	return $option_html;
}
 function generate_taxonomy_dropdown($taxonomy_lists , $data){
    $html = "";

    $heading_text = $data['use_multi_filter_label'] === 'on' && $data['enable_single_filter_label'] === 'on' && isset($data['single_label_text']) && $data['single_label_text'] !== '' ?
                sprintf('<li><span class="multi_filter_label"> %1$s </span></li>' , esc_html__($data['single_label_text'], 'divi_flash') )
                : '';
    $html .=$heading_text;
    $index = 0;
    foreach($taxonomy_lists as $key =>$value){
        $index++;
        $taxonomy_details = get_taxonomy( $value );
        $prefix_label = $data['use_multi_filter_label'] === 'on' && isset($data['prefix_multi_filter_label']) && $data['prefix_multi_filter_label'] !== '' ? $data['prefix_multi_filter_label'] : '';
        $label_text = $data['enable_single_filter_label'] === 'on' && isset($data['single_label_text']) && $data['single_label_text'] !== '' ?  $data['single_label_text'] :  $prefix_label  ." ". $taxonomy_details->label;
        $term_options = termlist_options($value , $taxonomy_details->label);
        $multi_filter_label=$data['use_multi_filter_label'] === 'on' ?
                            sprintf('<span class="multi_filter_label"> %1$s </span>' , esc_html__($label_text, 'divi_flash') )
                            : '';
        if($data['enable_single_filter_label'] === 'on'){
            $multi_filter_label = '';
        }
        $multi_filter_dropdown_placeholder_prefix = isset($data['multi_filter_dropdown_placeholder_prefix']) ? $data['multi_filter_dropdown_placeholder_prefix']: '';
	    $field_type = $data['multi_filter_fields_type']['tax_filter_field_type_'.$data['post_type'].'_'.$value];
	    if('select' === $field_type){
		    $html .= generate_multi_filter_select('multiple_taxonomy_filter', $value, $multi_filter_label, $taxonomy_details->label, $term_options, $multi_filter_dropdown_placeholder_prefix);
	    }
	    else if('checkbox' === $field_type){
		    $html .= generate_multi_filter_checkbox('multiple_taxonomy_filter', $value, $taxonomy_details->label, get_taxonomy_field_options($value));
	    }
	    else {
		    $html .= generate_multi_filter_select('multiple_taxonomy_filter', $value, $multi_filter_label, $taxonomy_details->label, $term_options, $multi_filter_dropdown_placeholder_prefix);
	    }
    }

    return $html;
}




function get_acf_field_options($post_type, $field, $type) {
	$posts = new WP_Query([
		'post_type' => $post_type,
		'posts_per_page' => -1,
	]);

	$options = [];

	if ($posts->have_posts()) {
		while ($posts->have_posts()) {
			$posts->the_post();
			$acf_meta_value = trim(get_post_meta(get_the_ID(), $field['name'], true));
			if(!in_array($acf_meta_value, $options) && "" !== $acf_meta_value && "0" !== $acf_meta_value){
				$options[] = $acf_meta_value;
			}
		}
		wp_reset_postdata();
	}
	$options = array_unique($options);
	$acf_option_html = "";
	foreach($options as $option ){
		if('checkbox' === $type){
			$acf_option_html .= sprintf('
							<label class="checkbox_content">%2$s %1$s %3$s
							  <input type="checkbox"  data-value="%1$s">
							  <span class="checkmark"></span>
							</label>',
				$option,
				$field['prepend'],
				$field['append']
			);
		}
		if('select' === $type){
			$acf_option_html .= sprintf('<option value="%1$s">%2$s %1$s %3$s</option>', $option, $field['prepend'], $field['append']);
		}

	}
	return $acf_option_html;
}
function get_acf_field_range_min_max($post_type, $field) {
	$posts = new WP_Query([
		'post_type' => $post_type,
		'posts_per_page' => -1,
	]);

	$options = [];

	if ($posts->have_posts()) {
		while ($posts->have_posts()) {
			$posts->the_post();
			$acf_meta_value = trim(get_post_meta(get_the_ID(), $field['name'], true));
			if(!in_array($acf_meta_value, $options) && "" !== $acf_meta_value && "0" !== $acf_meta_value){
				$options[] = $acf_meta_value;
			}
		}
		wp_reset_postdata();
	}
	$options = array_unique($options);
	$values = [];
	foreach($options as $option ){
		$values[] = (int) $option;

	}
	return ['min' => min($values), 'max' => max($values)];
}
function get_acf_field_choices($post_type,$field, $type) {
	$get_field_choice = $field['choices'];
	$html = "";
	foreach ($get_field_choice as $key => $value) {
		if('checkbox' === $type){
			$html .= sprintf('
							<label class="checkbox_content">%1$s
							  <input type="checkbox"  data-key="%2$s" data-value="%1$s">
							  <span class="checkmark"></span>
							</label>',
				$value,
				$key
			);
		}
		if('select' === $type){
			$html .= "<option value=$key> $value </option>";
		}

	}
	return $html;
}
function generate_acf_filter_fields($post_type, $selected_acf_filter_fields, $df_acf_field_details_for_filter, $data) {
	if(empty($selected_acf_filter_fields)){
		return ;
	}
	$html = "";
	$acf_field_details = $df_acf_field_details_for_filter[$post_type];
	foreach ($acf_field_details as $field){
		$multi_filter_label=$data['use_multi_filter_label'] === 'on' ?
			sprintf('<span class="multi_filter_label"> %1$s </span>' , esc_html__($field['label'], 'divi_flash') )
			: '';
		if($data['enable_single_filter_label'] === 'on'){
			$multi_filter_label = '';
		}
		$field_type = $data['multi_filter_fields_type']['acf_filter_field_type_'.$post_type.'_'.$field['name']];
		if(in_array($field['name'], $selected_acf_filter_fields)){
			if(in_array($field['type'],['textarea', 'text', 'number'])){
				if('select' === $field_type){
					$html .= generate_multi_filter_select('multiple_acf_filter', $field['name'], $multi_filter_label, $field['label'], get_acf_field_options($post_type,$field, 'select'),'');
				}
				else if('checkbox' === $field_type){
					$html .= generate_multi_filter_checkbox('multiple_acf_filter', $field['name'], $field['label'], get_acf_field_options($post_type,$field, 'checkbox'));
				}
				else if('range' === $field_type){
                    $range_label = sprintf('<span class="multi_filter_range_label"> %1$s </span>' , esc_html__($field['label'], 'divi_flash') );
					$min_max = get_acf_field_range_min_max($post_type,$field);
					$html .= generate_multi_filter_range( [
						'class_name' => 'multiple_acf_filter',
						'selector'   => $field['name'],
						'title'      => $range_label,
						'data'       => [
							'skin'    => 'flat',
							'type'    => "double",
							'grid'    => false,
							'min'     => $min_max['min'],
							'max'     => $min_max['max'],
							'from'    => $min_max['min'],
							'to'      => $min_max['max'],
							'prefix'  => $field['prepend'],
							'postfix' => $field['append']
						]
					] );
				}
				else{
					$html .= generate_multi_filter_checkbox('multiple_acf_filter', $field['name'], $field['label'], get_acf_field_options($post_type,$field, 'checkbox'));
				}
			}
			if('select' === $field['type']){
				if('select' === $field_type){
					$html .= generate_multi_filter_select('multiple_acf_filter', $field['name'], $multi_filter_label, $field['label'], get_acf_field_choices($post_type, $field, 'select'),'');
				}
				else if('checkbox' === $field_type){
					$html .= generate_multi_filter_checkbox('multiple_acf_filter', $field['name'], $field['label'], get_acf_field_choices($post_type, $field, 'checkbox'));
				}
				else{
					$html .= generate_multi_filter_checkbox('multiple_acf_filter', $field['name'], $field['label'], get_acf_field_choices($post_type, $field, 'checkbox'));
				}
			}
			if('range' === $field['type'] && 'range' === $field_type){
				$range_label = sprintf('<span class="multi_filter_range_label"> %1$s </span>' , esc_html__($field['label'], 'divi_flash') );
				$html .= generate_multi_filter_range( [
					'class_name' => 'multiple_acf_filter',
					'selector'   => $field['name'],
					'title'      => $range_label,
					'data'       => [
						'skin'    => 'flat',
						'type'    => "double",
						'grid'    => false,
						'min'     => $field['min'],
						'max'     => $field['max'],
						'from'    => $field['min'],
						'to'      => $field['max'],
						'prefix'  => $field['prepend'],
						'postfix' => $field['append']
					]
				] );
			}
		}
	}

	return $html;
}


/**
 * CptFilter: Rendering navigation for CptFilter
 *
 * @param String | $post_type
 * @param String | $taxonomy
 * @param String | $terms
 *
 * @return String | $html
 */
function render_cpt_filter_nav($post_type, $taxonomy, $terms, $all_items = 'off', $all_items_text = 'All', $post_orderby = 'date') {
    $terms_array = explode(',', $terms);
    $html = '';
    $index = 0;

    if(empty($terms)) {
        return;
    }

    $html .= '<ul class="df-cpt-filter-nav">';
    if('on' === $all_items) {
        $html .= sprintf('<li data-sort-value="%3$s" data-term="%2$s" class="df-cpt-filter-nav-item df-active">%1$s</li>',
            esc_html($all_items_text),
            et_core_esc_previously( $terms ),
            et_core_esc_previously( $post_orderby )
        );
    }
    foreach ( $terms_array as $term ) {

        if($term === 'current'){
            continue;
        }
       // $active_class = $index === 0 && $all_items != 'on' ? 'df-active' : '';
        $active_class = $index === 0 && 'on' !== $all_items ? '' : '';  // added at version 1.2.10
        $term_id = intval($term);
        $term_obj = get_term($term_id);
        $html .= sprintf('<li data-sort-value="%4$s" data-term="%1$s" class="df-cpt-filter-nav-item %3$s">%2$s</li>',
            !is_wp_error($term_obj) && $term_obj !== null ? esc_html(get_term(intval($term))->term_id) : '',
            !is_wp_error($term_obj) && $term_obj !== null ? esc_html(get_term(intval($term))->name) : '',
            et_core_esc_previously( $active_class ),
            et_core_esc_previously( $post_orderby )// 4
        );
        $index++;
    }
    $html .= '</ul>';

    return $html;
}



/**
 * Render simple pagination for blog
 *
 * @param String older entries text
 *
 * @param String next entries text
 */
function cpt_render_pagination( $older, $newer, $use_icon_only_at_pagination, $builder = false ) {
    add_filter('next_posts_link_attributes', 'df_cpt_next_link_attributes');
    add_filter('previous_posts_link_attributes', 'df_cpt_prev_link_attributes');

    $older = $use_icon_only_at_pagination === 'on' ? '' : $older;
    $newer = $use_icon_only_at_pagination === 'on' ? '' : $newer;
    $class = $use_icon_only_at_pagination == 'on' ? 'only_icon' : '';

    echo '<div class="df-pagination pagination clearfix '.esc_attr($class).'">';
        if($builder === true) {
            echo '<a class="older page-numbers" href="#">'.esc_html__("{$older}",'divi_flash').'</a>';
            echo '<a class="newer page-numbers" href="#">'.esc_html__("{$newer}",'divi_flash').'</a>';
        } else {
            next_posts_link(esc_html__("{$older}",'divi_flash'));
            previous_posts_link(esc_html__("{$newer}", 'divi_flash'));
        }
    echo '</div>';

    remove_filter('next_posts_link_attributes', 'df_cpt_next_link_attributes');
    remove_filter('previous_posts_link_attributes', 'df_cpt_prev_link_attributes');
}
/**
 * Render numbered pagination
 *
 * @param String older entries text
 *
 * @param String next entries text
 */
function cpt_render_number_pagination( $older, $newer, $use_icon_only_at_pagination, $builder = false ) {
    global $wp_query;
    $older = $use_icon_only_at_pagination === 'on' ? '' : $older;
    $newer = $use_icon_only_at_pagination === 'on' ? '' : $newer;
    $class = $use_icon_only_at_pagination == 'on' ? 'only_icon' : '';
    $big = 9999999; // need an unlikely integer
    echo '<div class="df-pagination pagination clearfix '.esc_attr($class).'">';
        if($builder === true) {
            echo '<a class="prev page-numbers" href="#">'.esc_html__("{$older}",'divi_flash').'</a>';
        }
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
            'total' => $wp_query->max_num_pages,
            'prev_text' => esc_html__("{$older}",'divi_flash'),
            'next_text' => esc_html__("{$newer}", 'divi_flash')
        ));
    echo '</div>';
}
/**
 * add class attributes to
 * previous and next posts links
 *
 */
function df_cpt_next_link_attributes() {
    return 'class="older page-numbers"';
}
function df_cpt_prev_link_attributes() {
    return 'class="newer page-numbers"';
}

/**
 * Render Posts for CPTCarousel Module on VB
 *
 */
add_action('wp_ajax_df_cpt_carousel', 'df_cpt_carousel');
function df_cpt_carousel() {
    global $paged, $post, $wp_query, $wp_filter, $__et_blog_module_paged;

    // create the display gallery code
    $data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }
    if($data['post_type'] === 'select'){
        wp_send_json_success('<h2 style="background:#eee; padding: 10px 20px;">Please select a <strong>Custom Post Type</strong>.</h2>');
        return;
    }
    $post_type = isset($data['post_type']) ? $data['post_type'] : 'project';

    $cpt_items = isset($data['cptItems']) ? $data['cptItems'] : array();

    $posts_number = isset($data['posts_number']) ? intval($data['posts_number']) : 10;
    $post_display = isset($data['post_display']) ? $data['post_display'] : 'recent';
    $orderby = isset($data['orderby']) ? $data['orderby'] : '1';
    $selected_taxonomy = isset($data['selected_taxonomy']) ? $data['selected_taxonomy'] : '';
    $selected_terms = isset($data['selected_terms']) ? $data['selected_terms'] : '';
    $offset_number = isset($data['offset_number']) ? $data['offset_number']: '0';
    $use_current_loop = $data['use_current_loop'];
    $post_type_arch = $data['post_type_arch'];
    $post_type = $use_current_loop === 'on' ? $post_type_arch : $post_type;
    $query_args = array(
        'posts_per_page' => $posts_number,
        'post_status'    => array( 'publish' ),
        'perm'           => 'readable',
        'post_type'      => $post_type,
    );
    // orderby
    if( $orderby === '5' ) {
        $query_args[ 'orderby' ] = 'rand';
    } elseif ( $orderby === '2' ) {
        $query_args[ 'order' ] = 'ASC';
    }
    else if('3' === $orderby) {
        $query_args['orderby'] = 'title';
        $query_args['order'] = 'ASC';
    }
    else if('4' === $orderby) {
        $query_args['orderby'] = 'title';
        $query_args['order'] = 'DESC';
    }
    else{
        $query_args['orderby'] = 'date';
        $query_args['order'] = 'DESC';
    }
    

    // by taxonomy
    if( 'by_tax' === $post_display && '' !== $selected_terms ) {
        // $selected_terms_array = explode(',', $selected_terms);
        // $initial_term_id = $selected_terms_array[0];
        // $query_args['tax_query'] = array( //phpcs:ignore WordPress.DB.SlowDBQuery
        //     'relation' => 'AND',
        //     array(
        //         'taxonomy'  => $selected_taxonomy,
        //         'field'     => 'term_id',
        //         'terms'     => $initial_term_id
        //     )
        // );
        if(! str_contains($selected_terms, 'current')){ // If current term check then default query run.
            $query_args['tax_query'] = array( //phpcs:ignore WordPress.DB.SlowDBQuery
                'relation' => 'AND',
                array(
                    'taxonomy'  => $selected_taxonomy,
                    'field'     => 'term_id',
                    'terms'     => explode(',', $selected_terms)
                )
            );
        }
    }

    $df_pg_paged = is_front_page() ? get_query_var( 'page' ) : get_query_var( 'paged' );
    if ( is_front_page() ) {
        $paged = $df_pg_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride
    }
    if ( $__et_blog_module_paged > 1 ) {
        $df_pg_paged            = $__et_blog_module_paged;
        $paged                  = $__et_blog_module_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride
        $query_args['paged']    = $__et_blog_module_paged;
    }
    if ( ! is_search() ) {
        $paged = $df_pg_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride
        $query_args['paged'] = $df_pg_paged;
    }else{
	    $query_args['paged'] = $df_pg_paged;
    }


    if ( 'off' === $use_current_loop ) {
        query_posts( $query_args ); // phpcs:ignore WordPress.WP.DiscouragedFunctions
    } elseif ( is_singular() ) {
        // Force an empty result set in order to avoid loops over the current post.
        query_posts( array( 'post__in' => array( 0 ) ) ); // phpcs:ignore WordPress.WP.DiscouragedFunctions
        // $show_no_results_template = false;
    } else {
        // Only allow certain args when `Posts For Current Page` is set.
        $original = $wp_query->query_vars;
        $custom   = array_intersect_key( $query_args, array_flip( array( 'posts_per_page', 'offset', 'paged' ) ) );

        // Trick WP into reporting this query as the main query so third party filters
        // that check for is_main_query() are applied.
        $wp_the_query = $wp_query = new WP_Query( array_merge( $original, $custom ) ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
    }


    if ( '' !== $offset_number && ! empty( $offset_number ) ) {
        /**
         * Offset + pagination don't play well. Manual offset calculation required
         *
         * @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
         */
        if ( $paged > 1 ) {
            $query_args['offset'] = ( ( $df_pg_paged - 1 ) * intval( $posts_number ) ) + intval( $offset_number );
        } else {
            $query_args['offset'] = intval( $offset_number );
        }
    }

    $cpt_carousel_options = array(
        'cpt_item_inner' => isset($cpt_items['inner']) ? $cpt_items['inner'] : array(),
        'cpt_item_outer' => isset($cpt_items['outer']) ? $cpt_items['outer'] : array(),
        'equal_height' => isset($data['equal_height']) ? $data['equal_height'] : 'off',
        'use_image_as_background' => isset($data['use_image_as_background']) ? $data['use_image_as_background'] : 'off',
        'use_background_scale' => isset($data['use_background_scale']) ? $data['use_background_scale'] : 'off',
    );

    ob_start();
    query_posts( $query_args ); // phpcs:ignore WordPress.WP.DiscouragedFunctions


    //echo '<div class="df-cpts-inner-wrap">';
    if ( have_posts() ) {
        echo '<div class="df-cpts-wrap swiper-wrapper">';
        while ( have_posts() ) {
            the_post();

            $equal_height_class = $cpt_carousel_options['equal_height'] === 'on' ? ' df-equal-height' : '';
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( "df-cpt-item swiper-slide v2{$equal_height_class}" ) ?>>
                <div class="df-cpt-outer-wrap df-hover-trigger"
                    <?php echo $cpt_carousel_options['use_background_scale'] !== 'on' ? et_core_esc_previously(df_cpt_image_as_background($cpt_carousel_options['use_image_as_background'])) : '';?>>
                    <?php
                        // render markup to achive the scale effect.
                        if($cpt_carousel_options['use_image_as_background'] === 'on' && $cpt_carousel_options['use_background_scale'] === 'on') {
                            echo '<div class="df-cpt-bg-on-hover"><div ' . et_core_esc_previously(df_cpt_image_as_background($cpt_carousel_options['use_image_as_background'])) .'></div></div>';
                        }
                        if(!empty($cpt_carousel_options['cpt_item_outer'])) {
                            foreach( $cpt_carousel_options['cpt_item_outer'] as $cpt_item ) {

                                if( !isset($cpt_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_cpt_' . $cpt_item['type'];

                                call_user_func($callback, $cpt_item, true);

                            } // end of foreach
                        }
                    ?>
                    <div class="df-cpt-inner-wrap">
                        <?php
                            foreach( $cpt_carousel_options['cpt_item_inner'] as $cpt_item ) {

                                if( !isset($cpt_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_cpt_' . $cpt_item['type'];

                                call_user_func($callback, $cpt_item, true);

                            } // end of foreach
                        ?>
                    </div>
                </div>
            </article>
            <?php
        } // endwhile
        echo '</div>';
    }else{
        echo "<h3 style='text-align:center;background:#eee; padding: 10px 20px;'>No Post Found.</h3>";
    }

    wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
    $posts = ob_get_contents();
    ob_end_clean();

    if(empty($cpt_items)) {
        $posts = '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Post Element.</strong></h2>';
    }

    wp_send_json_success($posts);
}

function df_display_cpt_carousel_load_actions( $actions ) {
	$actions[] = 'df_cpt_carousel';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'df_display_cpt_carousel_load_actions' );

/**
 * Render icon/image for times
 *
 * @param Array $settings
 * @return String html
 */
function df_cpt_render_icon_image($settings) {
    if(('on' != $settings['use_icon']) && !isset($settings['image_icon'])) {
        return;
    }

    $image_alt_text =  isset($settings['image_icon']) ? df_image_alt_by_url($settings['image_icon']) : '';

    $image_icon = isset($settings['image_icon']) && $settings['image_icon'] !== '' ? sprintf('<img class="df-icon-image" alt="%2$s" src="%1$s" />', esc_attr($settings['image_icon']) , esc_attr($image_alt_text)) : '';
    return $settings['use_icon'] === 'on' ?
        sprintf('<span class="et-pb-icon">%1$s</span>', $settings['font_icon']) : $image_icon;
}

/**
 * Filter the main query paged arg to avoid pagination clashes with the Post modules pagination.
 *
 * @param WP_Query $query Query object.
 *
 * @return void
 */
function df_filter_main_query_paged_for_cpt_module( $query ) {
	global $__et_blog_module_paged;

	// phpcs:ignore WordPress.Security.NonceVerification -- This function does not change any state, and is therefore not susceptible to CSRF.
	if ( isset( $_GET['df_cpt'] ) && $query->is_main_query() ) {
		$__et_blog_module_paged = $query->get( 'paged' );
		$query->set( 'paged', 0 );
	}
}
add_filter( 'pre_get_posts', 'df_filter_main_query_paged_for_cpt_module' );

/**
 * CptFilter: Search Bar renderer
 *
 * @param String $term_id
 * @param INT $max_num_pages
 * @param String $use_icon
 * @param String $font_icon
 * @param Strign $position
 * @param String $text | load more text
 */
function df_search_filter_html($use_icon = 'on', $font_icon ='5', $placeholder_text = 'Search', $button_text = 'Search', $only_icon = 'off' , $button_icon_placement = 'right'){
    $icon = 'on' === $use_icon ?
            sprintf('<span class="et-pb-icon search_icon">%1$s</span>',
                esc_attr(et_pb_process_font_icon($font_icon))
            ) : '';
    $button_icon_html = sprintf('<span class="search_bar_button">
                                %2$s
                                %1$s
                                %3$s
                            </span>',
                            esc_html($button_text),
                            $button_icon_placement === 'left' ? $icon : '',
                            $button_icon_placement === 'right' ? $icon : ''
                        );
    $only_icon_html  = sprintf('<span class="search_bar_button">
                        %1$s
                    </span>',
                    $icon
                );
    return sprintf('<div class="search_bar">
                    <input type="text" name="df_search_filter" placeholder="%2$s" class="df_search_filter_input"/>
                    %1$s
                </div>',
                et_core_esc_previously( $only_icon ) === 'off' ? et_core_esc_previously( $button_icon_html ) : et_core_esc_previously( $only_icon_html ),
                esc_html($placeholder_text)
            );
}

add_action( 'wp_ajax_df_cpt_grid_scroll_data', 'df_cpt_grid_scroll_data' );
add_action( 'wp_ajax_nopriv_df_cpt_grid_scroll_data', 'df_cpt_grid_scroll_data' );
function df_cpt_grid_scroll_data() {
	if ( isset( $_POST['et_frontend_nonce'] ) && ! wp_verify_nonce( sanitize_text_field( $_POST['et_frontend_nonce'] ), 'et_frontend_nonce' ) ) {
		wp_die();
	}

	global $post, $paged, $wp_query, $wp_the_query;
	new ET_Builder_Element();

	$main_query = $wp_the_query;

	$use_current_loop        = ! empty( $_POST['use_current_loop'] ) ? sanitize_text_field($_POST['use_current_loop']) : 'off';
	$offset_number           = ! empty( $_POST['offset_number'] ) ? sanitize_text_field($_POST['offset_number']) : 0;
	$post_type               = ! empty( $_POST['post_type'] ) ? sanitize_text_field($_POST['post_type']): '';
	$posts_number            = ! empty( $_POST['posts_number'] ) ? sanitize_text_field($_POST['posts_number']): 10;
	$post_display            = ! empty( $_POST['post_display'] ) ? sanitize_text_field($_POST['post_display']) : 'recent';
	$orderby                 = ! empty( $_POST['orderby'] ) ? sanitize_text_field($_POST['orderby']) : '';
	$use_image_as_background = ! empty( $_POST['use_image_as_background'] ) ? sanitize_text_field($_POST['use_image_as_background']) : 'off';
	$use_background_scale    = ! empty( $_POST['use_background_scale'] ) ? sanitize_text_field($_POST['use_background_scale']) : 'off';
	$df_cpt_items            = isset( $_POST["df_cpt_items"] ) ? json_decode( stripslashes( sanitize_text_field( $_POST["df_cpt_items"] ) ), true ) : [];
	$df_cpt_items_outside    = isset( $_POST["df_cpt_items_outside"] ) ? json_decode( stripslashes( sanitize_text_field( $_POST["df_cpt_items_outside"] ) ), true ) : [];

	if ( 'off' === $use_current_loop && ( ! isset( $post_type ) || 'select' === $post_type ) ) return;

	$query_args = [
		'posts_per_page' => intval( $posts_number ),
		'post_status'    => ['publish'],
		'post_type'      => $post_type,
	];

	// post_types by taxonomies
	$selected_terms    = ! empty( $_POST['selected_terms'] ) ? sanitize_text_field($_POST['selected_terms']) : '';
	$selected_taxonomy = ! empty( $_POST['selected_taxonomy'] ) ? sanitize_text_field($_POST['selected_taxonomy']) : '';
	if ( 'by_tax' === $post_display && '' !== $selected_terms ) {
		if ( ! str_contains( $selected_terms, 'current' ) ) { // If current term check then default query run.
			$query_args['tax_query'] = [ //phpcs:ignore WordPress.DB.SlowDBQuery
				'relation' => 'AND',
				[
					'taxonomy' => $selected_taxonomy,
					'field'    => 'term_id',
					'terms'    => explode( ',', $selected_terms )
				]
			];
		}
	}

	// orderby
	//if ( 'recent' == $post_display) {
	switch ( $orderby ) {
		case '2':
			$query_args['orderby'] = 'date';
			$query_args['order']   = 'ASC';
			break;
		case '3':
			$query_args['orderby'] = 'title';
			$query_args['order']   = 'ASC';
			break;
		case '4':
			$query_args['orderby'] = 'title';
			$query_args['order']   = 'DESC';
			break;
		case '5':
			$query_args['orderby'] = 'rand';
			break;
		default:
			$query_args['orderby'] = 'date';
			$query_args['order']   = 'DESC';
			break;
	}
	//}

	$df_pg_paged = ! empty( $_POST['page_number'] ) ? sanitize_text_field($_POST['page_number']) : 1;
	$paged       = $df_pg_paged; //phpcs:ignore WordPress.WP.GlobalVariablesOverride

	$query_args['paged'] = $df_pg_paged;

	if ( '' !== $offset_number && ! empty( $offset_number ) ) {
		/**
		 * Offset + pagination don't play well. Manual offset calculation required
		 *
		 * @see: https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
		 */
		if ( $paged > 1 ) {
			$query_args['offset'] = ( ( $df_pg_paged - 1 ) * intval( $posts_number ) ) + intval( $offset_number );
		} else {
			$query_args['offset'] = intval( $offset_number );
		}
	}


	ob_start();

	if ( 'off' === $use_current_loop ) {
		query_posts( $query_args ); // phpcs:ignore WordPress.WP.DiscouragedFunctions
	} elseif ( is_singular() ) {
		// Force an empty result set in order to avoid loops over the current post.
		query_posts( [ 'post__in' => [ 0 ] ] ); // phpcs:ignore WordPress.WP.DiscouragedFunctions
		// $show_no_results_template = false;
	} else {
		// Only allow certain args when `Posts For Current Page` is set.
		$original = $wp_query->query_vars;
		$custom   = array_intersect_key( $query_args, array_flip( [ 'posts_per_page', 'offset', 'paged' ] ) );

		// Trick WP into reporting this query as the main query so third party filters
		// that check for is_main_query() are applied.
		$wp_the_query = $wp_query = new WP_Query( array_merge( $original, $custom ) ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride
	}

	// Manually set the max_num_pages to make the `next_posts_link` work
	if ( '' !== $offset_number && ! empty( $offset_number ) ) {
		global $wp_query;
		$wp_query->found_posts   = max( 0, $wp_query->found_posts - intval( $offset_number ) );
		$posts_number            = intval( $posts_number );
		$wp_query->max_num_pages = $posts_number > 1 ? ceil( $wp_query->found_posts / $posts_number ) : 1;
	}

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();

			$width = 'on' === 1080;
			$width = (int) apply_filters( 'et_pb_blog_image_width', $width );

			$height             = 'on' === 675;
			$height             = (int) apply_filters( 'et_pb_blog_image_height', $height );
            $equal_height = ! empty( $_POST['equal_height'] ) ? sanitize_text_field($_POST['equal_height']) : 'off';
			$equal_height_class = 'on' === $equal_height ? ' df-equal-height' : '';

            $entire_item_clickable = ! empty( $_POST['entire_item_clickable'] ) ? sanitize_text_field($_POST['entire_item_clickable']) : 'off';

			?>
            <article id="post-<?php the_ID(); ?>" <?php post_class("df-cpt-item v2{$equal_height_class}") ?>
				<?php echo 'on' === $entire_item_clickable ? 'onclick="location.href=\'' . esc_url(get_the_permalink()) . '\'" style="cursor:pointer;"' : ''; ?>>
                <div class="df-cpt-outer-wrap df-hover-trigger" <?php echo 'on' !== $use_background_scale ? et_core_esc_previously(df_cpt_image_as_background($use_image_as_background)) : ''; ?>>
					<?php
					if ('on' === $use_image_as_background && 'on' === $use_background_scale) {
						echo '<div class="df-cpt-bg-on-hover"><div ' . et_core_esc_previously(df_cpt_image_as_background($use_image_as_background)) . '></div></div>';
					}
					foreach ($df_cpt_items_outside as $post_item) {
						if (isset($post_item['type'])) {
							call_user_func('df_cpt_' . $post_item['type'], $post_item);
						}
					}
					?>
                    <div class="df-cpt-inner-wrap">
						<?php foreach ($df_cpt_items as $post_item) {
							if (isset($post_item['type'])) {
								call_user_func('df_cpt_' . $post_item['type'], $post_item);
							}
						} ?>
                    </div>
                </div>
            </article>

			<?php
		}
	}

	$wp_the_query = $wp_query = $main_query; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
	wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions

	$posts = ob_get_contents();
    ob_get_clean();

	wp_send_json_success( $posts );
}

class ACF_Data_Process_for_Builder {
	public $selected_acf_filter_fields = [];
	public $df_acf_field_details_for_filter = [];
	public $df_acf_fields_for_filter = [];

    private $post_type, $filter_options;
	function __construct($post_type, $filter_options) {
        $this->post_type = $post_type;
        $this->filter_options = $filter_options;

		$fields_storage = Df_Acf_Fields::getInstance();
		$this->df_acf_fields_for_filter = $fields_storage->processed_acf_fields_for_filter_options();
		$this->df_acf_field_details_for_filter = $fields_storage->acf_fields_with_details;
	}
	public function get_acf_filter_values(){
		$this->selected_acf_filter_fields = $this->get_multi_filter_acf_fields($this->filter_options);
	}

	public function get_multi_filter_acf_fields($selected_acf_filter_options){
		$main_value = array();
		$selected_multi = explode("|",$selected_acf_filter_options);

		$list_multi_key = array_keys($this->df_acf_fields_for_filter[$this->post_type]);
		$iMax = count( $selected_multi );
		for($i =0; $i < $iMax; $i++){
			if($selected_multi[$i] === 'on'){
				$main_value[] = $list_multi_key[ $i ];
			}
		}
		return $main_value;
	}
}