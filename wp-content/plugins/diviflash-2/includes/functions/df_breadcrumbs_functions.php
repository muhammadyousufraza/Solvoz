<?php
/**
 * Render Products for diviflash Product Item on VB
 * 
 */
add_action('wp_ajax_df_breadcrumbs_data', 'df_breadcrumbs_function');
if(!function_exists('df_breadcrumbs_function')){
    function df_breadcrumbs_function() {
		if(!function_exists('et_pb_post_format')) {
			require_once get_template_directory() . '/includes/builder/functions.php';
		} 
		if(!class_exists('df-breadcrumbs')) {
			require_once( DIFL_MAIN_DIR . '/includes/classes/df-class-breadcrumbs.php' );
		}
        $settings = json_decode(file_get_contents('php://input'), true);
        if (! wp_verify_nonce( $settings['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
            wp_die();
        }
        $post_id = $settings['post_id'] ? $settings['post_id'] : '';
		$post_item = $settings['post_item'] ? $settings['post_item'] : '';
		$request_type = $settings['request_type'] ? $settings['request_type'] : '';
		$home_icon = '';
        $home_icon = $settings['use_home_icon'] !== 'off' ?
                            sprintf('<span class="et-pb-icon df-home-icon">%1$s</span>',
                                $settings['home_font_icon'] !== '' ? esc_attr( et_pb_process_font_icon($settings['home_font_icon']) )  : '&#xe074'
                            ) : '';

		$inner_icon = '';
		$inner_icon = $settings['use_icon_inner_item'] !== 'off' ?
							sprintf('<span class="et-pb-icon df-inner-icon">%1$s</span>',
								$settings['inner_icon'] !== '' ? esc_attr( et_pb_process_font_icon($settings['inner_icon']) )  : '&#x39'
							) : '';
		$separator = '';
		if( 'on' === $settings['use_separator_icon'] ){
			$icon =  sprintf('<span class="et-pb-icon df-separator-icon">%1$s</span>',
                        $settings['separator_font_icon'] !== '' ? esc_attr( et_pb_process_font_icon( $settings['separator_font_icon'] ) ) : '&#x39'
                    );
			$class = "df-breadcrumbs-separator-icon";
			$separator = sprintf( '<span class="%2$s"> %1$s </span>', $icon , $class );
		}else if( 'off' === $settings['use_separator_icon'] && isset($settings['separator_text']) && $settings['separator_text'] !=='' ){
			$class = "df-breadcrumbs-separator-text";
			$separator = sprintf( '<span class="%2$s"> %1$s </span>', $settings['separator_text'] , $class );
	    }
		
		$labels = array(
			'home' => isset($settings['home_text']) ? esc_html( $settings['home_text'] ) : '',
			'page_title' => isset($settings['page_title']) ? esc_html( $settings['page_title'] ) : '',
            
            'use_page_custom_url' => isset($settings['use_page_custom_url']) ? esc_attr( $settings['use_page_custom_url'] ) : 'off',
            'page_custom_url' => isset($settings['page_custom_url']) ? esc_url( $settings['page_custom_url'] ) : '',
            'page_custom_url_target' => isset($settings['page_custom_url_target']) ? esc_attr( $settings['page_custom_url_target'] ) : 'same_window',
			'search' =>isset( $settings['search_title']) ? esc_html( $settings['search_title'] ).' %s' : '%s',
			'error_404' => isset($settings['error_404_title']) ? esc_html( $settings['error_404_title'] ) : '',
		);
		$home_icon_placement = isset($settings['home_icon_placement']) ? $settings['home_icon_placement'] : 'left';
		$args = array(
			'request_type'      => $request_type,
			'visual_builder'    => isset($settings['visual_builder']) ? $settings['visual_builder'] : false,
			'post_id'			=> $post_id,
			'post_item'         => $post_item,
			'list_class'        => 'df-breadcrumbs',
			'item_class'        => 'df-breadcrumbs-item',
			'separator'         =>  $separator,
			'separator_class'   => 'df-breadcrumbs-separator',
			'home_icon'         => $home_icon,
			'home_icon_class'   => 'df-breadcrumbs-home-icon',
			'home_icon_placement' => $home_icon_placement,
			'use_icon_inner_item' => $settings['use_icon_inner_item'],
			'inner_icon'         => $inner_icon,
			'labels'            => $labels,
			'show_on_front'     => 'on' === $settings['show_on_front_page'] ? true : false,
			'show_title'        => $settings['show_title']
		);

		 $breadcrumb = new Df_Breadcrumb( $args );
        // echo $breadcrumb->trail();
        wp_send_json_success($breadcrumb->trail()['breadcrumb']);
    }
}