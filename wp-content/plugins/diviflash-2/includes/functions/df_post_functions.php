<?php
/**
 * Post Comments
 * 
 * @param Array $settings
 */
function df_post_comments($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    $text = $settings['comment_text'] === 'on' ? '' : 'Comment';
    $text_plural = $settings['comment_text'] === 'on' ? '' : 'Comments';

    $comment = sprintf( esc_html( _nx( '%s %2$s', '%s %3$s', get_comments_number(), 'number of comments', 'divi_flash' ) ), number_format_i18n( get_comments_number() ), $text, $text_plural );

    echo sprintf('<span class="df-item-wrap df-post-comments-wrap %2$s %6$s">%7$s %4$s %3$s %1$s %5$s</span>', 
        sprintf( '
            <span class="comments">%1$s</span>', 
            esc_html($comment)
        ),
        esc_attr($settings['class']),
        et_core_esc_previously(df_post_render_icon_image($settings)),
	    et_core_esc_previously(df_element_before_after($settings)['before']),
	    et_core_esc_previously(df_element_before_after($settings)['after']),
        esc_attr($module_class),
        et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
    );
}
/**
 * Post Categories
 * 
 * @param Array $settings
 */
function df_post_categories($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    $categories = get_the_term_list($post->ID, 'category', '', ', ');

    if(!empty($categories)) {
        echo sprintf('<span class="df-item-wrap df-post-categories-wrap %2$s %4$s">%5$s %3$s %1$s</span>', 
            wp_kses_post($categories),
            esc_attr($settings['class']),
            et_core_esc_previously(df_post_render_icon_image($settings)),
            esc_attr($module_class),
            et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
        );
    } elseif(empty($categories) && $builder === true) {
        echo sprintf('<span class="df-item-wrap df-post-categories-wrap %1$s %2$s"></span>', 
            esc_attr($settings['class']),
            esc_attr($module_class)
        );
    }
}
/**
 * Post Categories
 * 
 * @param Array $settings
 */
function df_post_tags($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    $tags = get_the_term_list($post->ID, 'post_tag', '', ', ');

    if(!empty($tags)) {
        echo sprintf('<span class="df-item-wrap df-post-tags-wrap %2$s %4$s">%5$s %3$s %1$s</span>', 
            wp_kses_post($tags),
            esc_attr($settings['class']),
            et_core_esc_previously(df_post_render_icon_image($settings)),
            esc_attr($module_class),
            et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
        );
    } elseif(empty($tags) && $builder === true) {
        echo sprintf('<span class="df-item-wrap df-post-tags-wrap %1$s %2$s"></span>', 
            esc_attr($settings['class']),
            esc_attr($module_class)
        );
    }
}
/**
 * Post Date
 * 
 * @param Array $settings
 */
function df_post_date($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    echo sprintf('<span class="df-item-wrap df-post-date-wrap %2$s %6$s">%7$s %3$s %4$s %1$s  %5$s</span>', 
        get_the_date($settings['date_format']),
        esc_attr($settings['class']),
        et_core_esc_previously(df_post_render_icon_image($settings)),
	    et_core_esc_previously(df_element_before_after($settings)['before']),
	    et_core_esc_previously(df_element_before_after($settings)['after']),
        esc_attr($module_class),
        et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
    );
}
/**
 * Post Author
 * 
 * @param Array $settings
 */
function df_post_author($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    $author_image = 'on' === $settings['show_author_image'] ? sprintf(
        '<a href="%2$s" class="author-image">%1$s</a> ',
        get_avatar( get_the_author_meta( 'ID' ), 96 ), // wp default avatar size
        get_author_posts_url( get_the_author_meta( 'ID' ) )
    ) : '';
    $author_link = 'on' == $settings['show_author_image'] && 'on' == $settings['hide_author_text'] ? 
    '' : et_pb_get_the_author_posts_link();

    echo sprintf('<span class="df-item-wrap df-post-author-wrap %2$s %7$s">%8$s %5$s %4$s %3$s %1$s %6$s</span>', 
        et_core_esc_previously($author_link),
        esc_attr($settings['class']),
        et_core_esc_previously($author_image),
        et_core_esc_previously(df_post_render_icon_image($settings)),
	    et_core_esc_previously(df_element_before_after($settings)['before']),
	    et_core_esc_previously(df_element_before_after($settings)['after']),
        esc_attr($module_class),
        et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
    );
}
/**
 * Post Title
 * 
 * @param Array $settings
 */
function df_post_title($settings = array(), $builder = false) {    
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    echo sprintf('<div class="df-item-wrap df-post-title-wrap %4$s %5$s">
            %6$s
            <%3$s class="df-post-title">
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
}

/**
 * Post Image
 * 
 * @param Array $settings
 */
function df_post_image($settings = array(), $builder = false) {
    global $post;

    $size_array = array(
        'large' => array(1080, 675),
        'mid-hr' => array(350, 450),
        'mid' => array(400, 250),
        'mid-squ' => array(400, 400),
        'sm-squ' => array(300, 300),
        'original' => 'original'
    );

    $image_overlay = $settings['overlay'];
    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
    $classes = '';
    $overlay = '';
    $overlay_icon = '';

    $post_format    = et_pb_post_format();
    $width          = (int) apply_filters( 'et_pb_blog_image_width', $size_array[$settings['image_size']][0] );
    $height         = (int) apply_filters( 'et_pb_blog_image_height', $size_array[$settings['image_size']][1] );
    $titletext      = get_the_title();
    $alttext        = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
    $thumbnail      = get_thumbnail( $width, $height, 'df-post-image', $alttext, $titletext, false, 'Blogimage' );
    $thumb          = $thumbnail['thumb'];
    $post_thumbnail = '';

    if($size_array[$settings['image_size']] === 'original') {
        $post_thumbnail = get_the_post_thumbnail();
    } else if( '' !== $thumb ) {
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
                esc_attr($settings['overlay_icon_reveal'])
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
            '<div class="df-item-wrap df-post-image-wrap %3$s %4$s">
                %5$s
                <div class="et_main_video_container">
                    %1$s
                    %2$s
                </div>
            </div>',
            et_core_esc_previously( $video_overlay ),
            et_core_esc_previously( $first_video ),
            esc_attr($settings['class']),
            esc_attr($module_class),
            et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
        );
    else:
        if(!empty($thumb)) {
            echo sprintf('<div class="df-item-wrap df-post-image-wrap %3$s %7$s">
                    <a class="%4$s" href="%2$s">%8$s%1$s%5$s%6$s</a>
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
            echo sprintf('<div class="df-item-wrap df-post-image-wrap df-empty-element %1$s %2$s"></div>', 
                esc_attr($settings['class']),
                esc_attr($module_class)            
            );
        }
        
    endif;
}
/**
 * Custom Text
 * 
 * @param Array $settings
 */
function df_post_custom_text($settings = array(), $builder = false) {
    global $post;

    $custom_text = '' !== $settings['custom_text'] ? $settings['custom_text'] : '' ; 
    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    echo sprintf('<span class="df-item-wrap df-post-custom-text %2$s %3$s">%4$s%1$s</span>', 
        esc_html__($custom_text, 'divi_flash'),
        esc_attr($settings['class']),
        esc_attr($module_class),
        et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
    );
}

/**
 * Post Content
 * 
 * @param Array $settings
 */
function df_post_content($settings = array(), $builder = false) {
    global $post;

    $post_content = et_strip_shortcodes( et_delete_post_first_video( get_the_content() ), true );
    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
    
    echo '<div class="df-item-wrap df-post-content-wrap '.esc_attr($settings['class']). ' ' . esc_attr($module_class) .'">';
        
        echo et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ));

        if('content' === $settings['post_content']) {
            global $more;

            // page builder doesn't support more tag, so display the_content() in case of post made with page builder
            if ( et_pb_is_pagebuilder_used( get_the_ID() ) ) {
                $more = 1; // phpcs:ignore WordPress.WP.GlobalVariablesOverride

                echo et_core_intentionally_unescaped( apply_filters( 'the_content', $post_content ), 'html' );

            } else {
                $more = null; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
                echo et_core_intentionally_unescaped( apply_filters( 'the_content', et_delete_post_first_video( get_the_content( esc_html__( 'read more...', 'et_builder' ) ) ) ), 'html' );
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
                echo et_core_intentionally_unescaped( wpautop( et_delete_post_first_video( strip_shortcodes( truncate_post( intval($settings['excerpt_length']), false, '') ) ) ), 'html' );
            }
        }
    echo '</div>';
}
/**
 * Read More Button
 * 
 * @param Array $settings
 */
function df_post_button($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    $output = sprintf('<div class="df-item-wrap df-post-button-wrap %2$s %5$s">
            %6$s
            <a class="df-post-read-more" href="%1$s"><span class="btn-text">%3$s</span> %4$s</a>
        </div>', 
        get_the_permalink(),
        esc_attr($settings['class']),
        esc_html__($settings['read_more_text']),
        df_post_render_icon_image($settings),
        esc_attr($module_class),
        et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
    );
    
    echo et_core_esc_previously($output);
}
/**
 * Read More Button
 * 
 * @param Array $settings
 */
function df_post_divider($settings = array(), $builder = false) {
    global $post;

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';

    echo sprintf(
        '<div class="df-item-wrap %1$s %2$s">
            %3$s
            <span class="df-post-ele-divider"></span>
        </div>',
        esc_attr($settings['class']),
        esc_attr($module_class),
        et_core_esc_previously(df_print_background_mask_and_pattern_dynamic_modules( $settings ))
    );
}
/**
 * Post image as background
 * 
 */
function df_post_image_as_background($use_image_as_background) {
    global $post;
    // use_image_as_background
    if($use_image_as_background === 'on' && !empty(get_the_post_thumbnail_url($post->ID))) {
        return sprintf('style="background-image:url(%1$s); 
            background-size: cover; 
            background-repeat: no-repeat;
            background-position: center;
            background-origin: border-box;"', 
            esc_url(get_the_post_thumbnail_url($post->ID))
        );
    }
}

/**
 * Render ACF Fields before and after text
 *
 * @param Array $settings
 * @return Array
 */
function df_element_before_after($settings){
    $before_label = isset($settings['element_before_label']) ? wp_kses($settings['element_before_label'], df_allowed_html_for_text_input()) : '';
    $after_label = isset($settings['element_after_label']) ? wp_kses($settings['element_after_label'], df_allowed_html_for_text_input()) : '';

    return array(
        'before' => $before_label !== '' ? sprintf('<span class="before-text">%1$s</span>', $before_label) : '',
        'after' => $after_label !== '' ? sprintf('<span class="after-text">%1$s</span>', $after_label) : ''
    );
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
function df_post_acf_fields($settings = array(), $builder = false) {
    df_acf_fields_function($settings , $builder);
 }
/**
 * Render Posts for PostGrid Module on VB
 * module - PostGrid
 */
add_action('wp_ajax_df_pg_posts', 'df_pg_posts');
function df_pg_posts() {
    global $paged, $post, $wp_query, $wp_filter, $__et_blog_module_paged;

    // create the display gallery code
    $data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }

    $post_items = isset($data['postItems']) ? $data['postItems'] : array();
    
    $post_item_inner = isset($post_items['inner']) ? $post_items['inner'] : array();
    $post_item_outer = isset($post_items['outer']) ? $post_items['outer'] : array();

    $posts_number = isset($data['posts_number']) ? intval($data['posts_number']) : 10;
    $post_display = isset($data['post_display']) ? $data['post_display'] : 'recent';
    $orderby = isset($data['orderby']) ? $data['orderby'] : '1';
    $include_categories = isset($data['include_categories']) ? $data['include_categories'] : '';
    $include_tags = isset($data['include_tags']) ? $data['include_tags'] : '';
    $offset_number = isset($data['offset_number']) ? $data['offset_number']: '0';
    $layout = isset($data['layout']) ? $data['layout'] : 'grid';
    $use_image_as_background = isset($data['use_image_as_background']) ? $data['use_image_as_background'] : 'off';
    $use_background_scale = isset($data['use_background_scale']) ? $data['use_background_scale'] : 'off';
    $equal_height = isset($data['equal_height']) ? $data['equal_height'] : 'off';
    $show_pagination = isset($data['show_pagination']) ? $data['show_pagination'] : 'off';
    $use_number_pagination = isset($data['use_number_pagination']) ? $data['use_number_pagination'] : 'off';
    $older_text = isset($data['older_text']) ? $data['older_text'] : 'Older Entries';
    $newer_text = isset($data['newer_text']) ? $data['newer_text'] : 'Next Entries';

    $query_args = array(
        'posts_per_page' => $posts_number,
        'post_status'    => array( 'publish' ),
        'post_type'      => 'post',
    );

    // post by categories
    if ( 'by_category' == $post_display) {
        $query_args['cat'] = $include_categories;
    }
    // post by tag
    if ( 'by_tag' == $post_display) {
        $query_args['tag__in'] = explode(',', $include_tags );
    }
    // orderby
    if ( 'recent' == $post_display) {
        if ( '3' === $orderby ) {
            $query_args['orderby'] = 'rand';
        } else if('2' === $orderby) {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'ASC';
        } else {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'DESC';
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
    }
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
    query_posts( $query_args ); // phpcs:ignore WordPress.WP.DiscouragedFunctions
    echo '<div class="df-posts-wrap layout-'. esc_attr($layout) .'">';
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();

            $equal_height_class = $equal_height === 'on' ? ' df-equal-height' : '';
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( "df-post-item v2{$equal_height_class}" ) ?>>
                <div class="df-post-outer-wrap df-hover-trigger" <?php echo $use_background_scale !== 'on' ? et_core_esc_previously(df_post_image_as_background($use_image_as_background)): '';?>>
                    <?php 
                        // render markup to achive the scale effect.
                        if($use_image_as_background === 'on' && $use_background_scale === 'on') {
                            echo '<div class="df-postgrid-bg-on-hover"><div ' . et_core_esc_previously(df_post_image_as_background($use_image_as_background)) .'></div></div>';
                        }
                        if(!empty($post_item_outer)) {
                            foreach( $post_item_outer as $post_item ) {

                                if( !isset($post_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_post_' . $post_item['type'];

                                call_user_func($callback, $post_item, true);

                            } // end of foreach
                        }
                    ?>
                    <div class="df-post-inner-wrap">
                        <?php 
                            foreach( $post_item_inner as $post_item ) {

                                if( !isset($post_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_post_' . $post_item['type'];

                                call_user_func($callback, $post_item, true);

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
            add_filter( 'get_pagenum_link', array( 'DIFL_PostGrid', 'filter_pagination_url' ) );
            if ($use_number_pagination !== 'on') {
                render_pagination($older_text, $newer_text, true);
            } else {
                render_number_pagination($older_text, $newer_text, true);
            }
            remove_filter( 'get_pagenum_link', array( 'DIFL_PostGrid', 'filter_pagination_url' ) );
        }
    }

    wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
    $posts = ob_get_contents();
    ob_end_clean();

    if(empty($post_items)) {
        $posts = '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Post Element.</strong></h2>';
    }

    wp_send_json_success($posts);
}
/**
 * Render Posts for PostList Module on VB
 * module - PostList
 */
add_action('wp_ajax_df_pl_posts', 'df_pl_posts');
function df_pl_posts() {
    global $paged, $post, $wp_query, $wp_filter, $__et_blog_module_paged;

    // create the display gallery code
    $data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }

    $post_items = isset($data['postItems']) ? $data['postItems'] : array();
    $post_item_inner = isset($post_items['inner']) ? $post_items['inner'] : array();
    $post_item_outer = isset($post_items['outer']) ? $post_items['outer'] : array();
    $posts_number = isset($data['posts_number']) ? intval($data['posts_number']) : 10;
    $post_display = isset($data['post_display']) ? $data['post_display'] : 'recent';
    $orderby = isset($data['orderby']) ? $data['orderby'] : '1';
    $include_categories = isset($data['include_categories']) ? $data['include_categories'] : '';
    $include_tags = isset($data['include_tags']) ? $data['include_tags'] : '';
    $offset_number = isset($data['offset_number']) ? $data['offset_number']: '0';
    $show_pagination = isset($data['show_pagination']) ? $data['show_pagination'] : 'off';
    $use_number_pagination = isset($data['use_number_pagination']) ? $data['use_number_pagination'] : 'off';
    $older_text = isset($data['older_text']) ? $data['older_text'] : 'Older Entries';
    $newer_text = isset($data['newer_text']) ? $data['newer_text'] : 'Next Entries';
    $layout = isset($data['layout']) ? $data['layout'] : 'layout-1';
    $collapse = isset($data['collapse']) && $data['collapse'] === 'on' && $data['vertical_align'] !== 'stretch' ? 'layout-collapse' : '';
    $image_size = isset($data['image_size']) && $data['image_size'] !== '' ? $data['image_size'] : 'large';
    $image_scale = isset($data['image_scale']) && $data['image_scale'] !== '' ? $data['image_scale'] : 'no-image-scale';
    $equal_height = isset($data['equal_height']) ? $data['equal_height'] : 'off';
    $use_iamge = isset($data['use_iamge']) ? $data['use_iamge'] : 'on';
    $use_icon = isset($data['use_icon']) ? $data['use_icon'] : 'off';
    $icon_image = $data['icon_image'];

    $query_args = array(
        'posts_per_page' => $posts_number,
        'post_status'    => array( 'publish' ),
        'post_type'      => 'post',
    );

    // post by categories
    if ( 'by_category' == $post_display) {
        $query_args['cat'] = $include_categories;
    }
    // post by tag
    if ( 'by_tag' == $post_display) {
        $query_args['tag__in'] = explode(',', $include_tags );
    }
    // orderby
    if ( 'recent' == $post_display) {
        if ( '3' === $orderby ) {
            $query_args['orderby'] = 'rand';
        } else if('2' === $orderby) {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'ASC';
        } else {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'DESC';
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
    }
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
    query_posts( $query_args ); // phpcs:ignore WordPress.WP.DiscouragedFunctions
    echo '<div class="df-posts-wrap list-'.esc_attr( $layout ).'">';
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();

            $featured_image = $use_iamge === 'on' ? df_post_image_render(array(
                'image_size'    => $image_size,
                'image_scale'   => $image_scale,
                'equal_height'  => $equal_height
            )) : '';
            $collapse_class = !empty($featured_image) && $equal_height !== 'on' ? $collapse : '';
            $classes = array(
                'df-post-item',
                $collapse_class,
                empty($featured_image) ? 'no-thumbnail' : '',
                $equal_height === 'on' ? 'equal-height' : '',
                $use_icon === 'on' ? 'has-icon' : ''
            );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( $classes ) ?>>
                <?php if (!empty($featured_image)): ?>
                    <div class="df-postlist-featured-image">
                        <?php echo et_core_esc_previously( $featured_image ); ?>
                    </div>
                <?php endif; ?>
                <?php if($use_iamge != 'on' && $use_icon === 'on'): ?>
                    <div class="df-pl-icon"><?php echo esc_html( $icon_image ); ?></div>
                <?php endif; ?>
                <div class="df-post-outer-wrap df-hover-trigger">
                    <?php 
                        if(!empty($post_item_outer)) {
                            foreach( $post_item_outer as $post_item ) {

                                if( !isset($post_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_post_' . $post_item['type'];

                                call_user_func($callback, $post_item, true);

                            } // end of foreach
                        }
                    ?>
                    <div class="df-post-inner-wrap">
                        <?php 
                            foreach( $post_item_inner as $post_item ) {

                                if( !isset($post_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_post_' . $post_item['type'];

                                call_user_func($callback, $post_item, true);

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
            add_filter( 'get_pagenum_link', array( 'DIFL_PostList', 'filter_pagination_url' ) );
            if ($use_number_pagination !== 'on') {
                render_pagination($older_text, $newer_text, true);
            } else {
                render_number_pagination($older_text, $newer_text, true);
            }
            remove_filter( 'get_pagenum_link', array( 'DIFL_PostList', 'filter_pagination_url' ) );
        }
    }

    wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
    $posts = ob_get_contents();
    ob_end_clean();

    if(empty($post_items)) {
        $posts = '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Post Element.</strong></h2>';
    }

    wp_send_json_success($posts);
}

function df_display_post_list_load_actions( $actions ) {
	$actions[] = 'df_pl_posts';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'df_display_post_list_load_actions' );
/**
 * Render icon/image for times
 * 
 * @param Array $settings
 * @return String html
 */
function df_post_render_icon_image($settings) {
    $image_icon_setting =isset($settings['image_icon']) ? $settings['image_icon'] : '';
    $image_icon_alt_text = isset($settings['image_alt_text']) && $settings['image_alt_text'] !== '' ? $settings['image_alt_text']  : df_image_alt_by_url($image_icon_setting);
    $image_icon = ( $image_icon_setting !== '' ) ? 
                    sprintf('<img class="df-icon-image" alt="%2$s" src="%1$s" />', esc_attr($image_icon_setting), $image_icon_alt_text
                    ) : '';
    return $settings['use_icon'] === 'on' ? 
        sprintf('<span class="et-pb-icon">%1$s</span>', $settings['font_icon']) : $image_icon;
}

function df_display_post_grid_load_actions( $actions ) {
	$actions[] = 'df_pg_posts';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'df_display_post_grid_load_actions' );

/**
 * Render Posts for BlogCarousel Module on VB
 * 
 */
add_action('wp_ajax_df_bc_posts', 'df_bc_posts');
function df_bc_posts() {
    global $paged, $post, $wp_query, $wp_filter, $__et_blog_module_paged;

    // create the display gallery code
    $data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }

    $post_items = isset($data['postItems']) ? $data['postItems'] : array();
    
    $post_item_inner = isset($post_items['inner']) ? $post_items['inner'] : array();
    $post_item_outer = isset($post_items['outer']) ? $post_items['outer'] : array();

    $posts_number = isset($data['posts_number']) ? intval($data['posts_number']) : 10;
    $post_display = isset($data['post_display']) ? $data['post_display'] : 'recent';
    $orderby = isset($data['orderby']) ? $data['orderby'] : '1';
    $include_categories = isset($data['include_categories']) ? $data['include_categories'] : '';
    $include_tags = isset($data['include_tags']) ? $data['include_tags'] : '';
    $offset_number = isset($data['offset_number']) ? $data['offset_number']: '0';
    $use_image_as_background = isset($data['use_image_as_background']) ? $data['use_image_as_background'] : 'off';
    $use_background_scale = isset($data['use_background_scale']) ? $data['use_background_scale'] : 'off';
    $equal_height = isset($data['equal_height']) ? $data['equal_height'] : 'off';


    $query_args = array(
        'posts_per_page' => $posts_number,
        'post_status'    => array( 'publish' ),
        // 'perm'           => 'readable',
        'post_type'      => 'post',
    );

    // post by categories
    if ( 'by_category' == $post_display) {
        $query_args['cat'] = $include_categories;
    }
    // post by tag
    if ( 'by_tag' == $post_display) {
        $query_args['tag__in'] = explode(',', $include_tags );
    }
    // orderby
    if ( 'recent' == $post_display) {
        if ( '3' === $orderby ) {
            $query_args['orderby'] = 'rand';
        } else if('2' === $orderby) {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'ASC';
        } else {
            $query_args['orderby'] = 'date';
            $query_args['order'] = 'DESC';
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
    }
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
    query_posts( $query_args ); // phpcs:ignore WordPress.WP.DiscouragedFunctions
    echo '<div class="df-posts-wrap swiper-wrapper">';
    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();

            $equal_height_class = $equal_height === 'on' ? ' df-equal-height' : '';
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( "df-post-item swiper-slide v2{$equal_height_class}" ) ?>>
                <div class="df-post-outer-wrap df-hover-trigger" <?php echo $use_background_scale !== 'on' ? et_core_esc_previously(df_post_image_as_background($use_image_as_background)): '';?>>
                    <?php 
                        // render markup to achive the scale effect.
                        if($use_image_as_background === 'on' && $use_background_scale === 'on') {
                            echo '<div class="df-blogcarousel-bg-on-hover"><div ' .et_core_esc_previously(df_post_image_as_background($use_image_as_background)) .'></div></div>';
                        }
                        if(!empty($post_item_outer)) {
                            foreach( $post_item_outer as $post_item ) {

                                if( !isset($post_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_post_' . $post_item['type'];

                                call_user_func($callback, $post_item, true);

                            } // end of foreach
                        }
                    ?>
                    <div class="df-post-inner-wrap">
                        <?php 
                            foreach( $post_item_inner as $post_item ) {

                                if( !isset($post_item['type'])) {
                                    continue;
                                }

                                $callback = 'df_post_' . $post_item['type'];

                                call_user_func($callback, $post_item, true);

                            } // end of foreach
                        ?>
                    </div>
                </div>
            </article>
            <?php
        } // endwhile
    }
    echo '</div>';

    wp_reset_query(); // phpcs:ignore WordPress.WP.DiscouragedFunctions
    $posts = ob_get_contents();
    ob_end_clean();

    if(empty($post_items)) {
        $posts = '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Post Element.</strong></h2>';
    }

    wp_send_json_success($posts);
}

function df_display_blog_carousel_load_actions( $actions ) {
	$actions[] = 'df_bc_posts';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'df_display_blog_carousel_load_actions' );

/**
 * Filter the main query paged arg to avoid pagination clashes with the Post modules pagination.
 *
 * @param WP_Query $query Query object.
 *
 * @return void
 */
function df_filter_main_query_paged_for_posts_module( $query ) {
	global $__et_blog_module_paged;

	// phpcs:ignore WordPress.Security.NonceVerification -- This function does not change any state, and is therefore not susceptible to CSRF.
	if ( isset( $_GET['df_blog'] ) && $query->is_main_query() ) {
		$__et_blog_module_paged = $query->get( 'paged' );
		$query->set( 'paged', 0 );
	}
}
add_filter( 'pre_get_posts', 'df_filter_main_query_paged_for_posts_module' );

/**
 * Render simple pagination for blog
 * 
 * @param String older entries text
 * 
 * @param String next entries text
 */
function render_pagination( $older, $newer, $builder = false ) {
    add_filter('next_posts_link_attributes', 'df_posts_next_link_attributes');
    add_filter('previous_posts_link_attributes', 'df_posts_prev_link_attributes');

    echo '<div class="df-pagination pagination clearfix">';
        if($builder === true) {
            echo '<a class="older page-numbers" href="#">'.esc_html__("{$older}",'divi_flash').'</a>';
            echo '<a class="newer page-numbers" href="#">'.esc_html__("{$newer}",'divi_flash').'</a>';
        } else {
            next_posts_link(esc_html__("{$older}",'divi_flash'));
            previous_posts_link(esc_html__("{$newer}", 'divi_flash'));
        }
    echo '</div>';

    remove_filter('next_posts_link_attributes', 'df_posts_next_link_attributes');
    remove_filter('previous_posts_link_attributes', 'df_posts_prev_link_attributes');
}
/**
 * Render numbered pagination
 * 
 * @param String older entries text
 * 
 * @param String next entries text
 */
function render_number_pagination( $older, $newer, $builder = false ) {
    global $wp_query;
    $big = 9999999; // need an unlikely integer
    echo '<div class="df-pagination pagination clearfix">';
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
function df_posts_next_link_attributes() {
    return 'class="older page-numbers"';
}
function df_posts_prev_link_attributes() {
    return 'class="newer page-numbers"';
}
/**
 * Post Image for PostList
 * 
 * @param Array $settings
 */
function df_post_image_render($settings = array()) {
    global $post;

    $size_array = array(
        '1080x675' => array(1080, 675),
        'large' => array(1080, 675),
        '400x250' => array(400, 250),
        'mid' => array(400, 250),
        '300x300' => array(300, 300),
        '300x187' => array(300, 187),
        '150x150' => array(150, 150),
        '100x100' => array(100, 100),
        'original' => 'original',
        '' => 'original'
    );

    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
    $classes = '';

    $post_format    = et_pb_post_format();
    $width          = (int) apply_filters( 'et_pb_blog_image_width', $size_array[$settings['image_size']][0] );
    $height         = (int) apply_filters( 'et_pb_blog_image_height', $size_array[$settings['image_size']][1] );
    $titletext      = get_the_title();
    $alttext        = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
    $thumbnail      = get_thumbnail( $width, $height, 'df-post-image', $alttext, $titletext, false, 'Blogimage' );
    $thumb          = $thumbnail['thumb'];
    $post_thumbnail = '';

    if($size_array[$settings['image_size']] === 'original') {
        $post_thumbnail = get_the_post_thumbnail();
    } else if( '' !== $thumb ) {
        $post_thumbnail = print_thumbnail( $thumb, $thumbnail['use_timthumb'], $titletext, $width, $height, '', false );
    }

    $classes = sprintf('df-hover-effect %1$s',
        $settings['image_scale']
    );
    ob_start();

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
            '<div class="df-item-wrap df-post-image-wrap %3$s">
                <div class="et_main_video_container">
                    %1$s
                    %2$s
                </div>
            </div>',
            et_core_esc_previously( $video_overlay ),
            et_core_esc_previously( $first_video ),
            esc_attr($module_class)
        );
    else:
        if(!empty($thumb)) {
            $image = $settings['equal_height'] !== 'on' ? sprintf(
                '<a class="%2$s" href="%3$s">%1$s</a>',
                wp_kses_post($post_thumbnail), 
                esc_attr($classes),
                esc_url(get_the_permalink())
            ) : sprintf(
                '<a class="%1$s" href="%2$s" %3$s></a>',
                esc_attr($classes),
                esc_url(get_the_permalink()),
                sprintf('style="background-image:url(%1$s);"',
                    $thumb
                )
            );
            echo sprintf('<div class="df-item-wrap df-post-image-wrap %1$s">%2$s</div>', 
                esc_attr($module_class),
	            et_core_esc_previously( $image )
            );
        } 
        
    endif;

    $image = ob_get_contents();
    ob_end_clean();
    return $image;
}
