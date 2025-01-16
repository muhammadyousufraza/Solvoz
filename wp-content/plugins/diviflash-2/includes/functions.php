<?php
/**
 * Allowed Html for text input.
 * Used by wordpress wp_kses() function
 *
 * @return Array
 */
function df_allowed_html_for_text_input() {
    return $allowed_html = array(
        'br' => array(),
        'em' => array(
            'style' => array()
        ),
        'strong' => array(
            'style' => array()
        ),
        'b' => array(
            'style' => array()
        ),
        'p' => array(
            'style' => array()
        ),
        'ul' => array(
            'style' => array(),
            'class' => array()
        ),
        'li' => array(
            'style' => array(),
            'class' => array()
        ),
        'ol' => array(
            'style' => array(),
            'class' => array()
        ),
        'a' => array(
            'style' => array(),
            'class' => array(),
            'href'  => array()
        )
    );
}

/**
 * VB HTML on AJAX request for CFSeven
 * @return json response
 */
add_action( 'wp_ajax_df_cfseven_requestdata', 'df_cfseven_requestdata' );
function df_cfseven_requestdata() {
    global $paged, $post;

    $data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }
    $options = $data['props'];

    $args = array(
        'post_type' => 'wpcf7_contact_form',
    );

    if ($options['cf7_forms'] === 'default') {
        $contact_forms = "Please select an contact form!";
    } else {
        $contact_forms = do_shortcode('[contact-form-7 id="'.$options['cf7_forms'].'" ]');
    }

    $posts = $contact_forms;
    wp_send_json_success($posts);
}

/**
 * VB HTML on AJAX request for WPForms
 * @return json response
 *
 */
add_action( 'wp_ajax_df_wpforms_requestdata', 'df_wpforms_requestdata' );
function df_wpforms_requestdata() {
    global $paged, $post, $wp_scripts, $wp_styles;

    $data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }
    $options = $data['props'];

    unset( $wp_scripts->registered );

    $preview_template = DIFL_MAIN_DIR . "/template/preview.php";

    $shortcode = '[wpforms id="'.$options['wpforms'].'"]';

    ob_start();
    echo et_core_esc_wp(include($preview_template));
    $wpforms = ob_get_clean();

    $form = [
        'content'   => $wpforms,
        'styles'    => $wp_styles,
        'scripts'   => $wp_scripts
    ];
    wp_send_json_success($form);
}

function df_wpforms_et_builder_load_actions( $actions ) {
	$actions[] = 'df_wpforms_requestdata';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'df_wpforms_et_builder_load_actions' );

/**
 * Add URL fields to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */
function df_ig_add_attachment_field( $form_fields, $post ) {

    $form_fields['df-ig-url'] = array(
        'label' => 'URL',
        'input' => 'url',
        'value' => esc_attr(get_post_meta( $post->ID, 'df_ig_url', true )),
        'helps' => 'Add URL',
    );

    return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'df_ig_add_attachment_field', 10, 2 );

/**
 * Save values URL in media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */
function df_ig_save_attachment_field_save( $post, $attachment ) {

    if( isset( $attachment['df-ig-url'] ) ) {
        update_post_meta( $post['ID'], 'df_ig_url', esc_url( $attachment['df-ig-url'] ) );
    }

    return $post;
}

add_filter( 'attachment_fields_to_save', 'df_ig_save_attachment_field_save', 10, 2 );


// Active Mim Type upload
add_filter( 'mime_types', 'df_mime_types' );
function df_mime_types( $existing_mimes ) {

    $existing_mimes['csv'] = 'text/csv';
    return $existing_mimes;
}
// Image Alternative Text from url
function df_image_alt_by_url( $image_url ) {
    global $wpdb;
    // phpcs:disable WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
    $attachment = $wpdb->get_col( $wpdb->prepare("SELECT ID FROM %1s WHERE guid='%2s';", esc_sql($wpdb->posts) , esc_sql($image_url) ) ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery
    // phpcs:enable WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
    if($wpdb->last_error !== '')
        return false;
    //$attachment = $wpdb->get_col($query);

    if(count ($attachment) < 1)
        return false;
    $image_id  = intval($attachment[0]);
    $image_alt = get_post_meta( $image_id , '_wp_attachment_image_alt', true );

    return $image_alt;
}

/**
 * Filter through the selector and remove the wrapper if any
 *
 * @param String $selector the css selector
 * @param String $function_name
 */
add_filter('et_pb_set_style_selector', 'df_remove_css_selector_wrapper', 999, 2);
function df_remove_css_selector_wrapper($selector, $function_name) {
    if ( 'difl_flipbox' === $function_name ) {
        return $selector;
    }
    if ( 'difl_datatable' === $function_name ) {
        return $selector;
    }

    if (strpos($selector, 'difl_')) {
        $selector = str_replace( '.et-db ', "", $selector );
        $selector = str_replace( '#et-boc ', "", $selector );
        $selector = str_replace( '.et-l ', "", $selector );
    }
    return $selector;
}

/**
* Get the list of registered Post Types options.
*
* @since 3.18
* @since 4.0.7 Added the $require_editor parameter.
*
* @param boolean|callable $usort Comparision callback.
* @param boolean          $require_editor Optional. Whether to retrieve only post type that has editor support.
*
* @return array
*/
function df_get_registered_post_type_options( $usort = false, $require_editor = true , $post_include = false) {
    $require_editor_key = $require_editor ? '1' : '0';
    $key                = "df_get_registered_post_type_options:{$require_editor_key}";

    if ( ET_Core_Cache::has( $key )  && $post_include === false) {
        return ET_Core_Cache::get( $key );
    }

    $blocklist = et_builder_get_blocklisted_post_types();
    $allowlist = et_builder_get_third_party_post_types();

    // Extra and Library layouts shouldn't appear in Theme Options as configurable post types.
    /**
     * Get array of post types to prevent from appearing as options for builder usage.
     *
     * @since 4.0
     *
     * @param string[] $blocklist Post types to blocklist.
     */
    if (!$post_include){
        $blocklist      = array_merge(
            $blocklist,
            array(
                'et_pb_layout',
                'layout',
                'post',
                'attachment',
                'page'
            )
        );
    }else{
        $blocklist      = array_merge(
            $blocklist,
            array(
                'et_pb_layout',
                'layout',
                'attachment',
                'page'
            )
        );
    }

    $blocklist      = apply_filters( 'et_builder_post_type_options_blocklist', $blocklist );
    $raw_post_types = get_post_types(
        array(
            'show_ui' => true,
        ),
        'objects'
    );
    $post_types     = array();
    foreach ( $raw_post_types as $post_type ) {
        $is_allowlisted  = in_array( $post_type->name, $allowlist, true );
        $is_blocklisted  = in_array( $post_type->name, $blocklist, true );
        $supports_editor = $require_editor ? post_type_supports( $post_type->name, 'editor' ) : true;
        $is_public       = et_builder_is_post_type_public( $post_type->name );

        if ( ! $is_allowlisted && ( $is_blocklisted || ! $supports_editor || ! $is_public ) ) {
            continue;
        }

        $post_types[]

        = $post_type;
    }

    if ( $usort && is_callable( $usort ) ) {
        usort( $post_types, $usort );
    }

    $post_type_options = array_combine(
        wp_list_pluck( $post_types, 'name' ),
        wp_list_pluck( $post_types, 'label' )
    );

    // did_action() actually checks if the action has started, not ended so we
    // need to check that we are not currently doing the action as well.
    if ( did_action( 'init' ) && ! doing_action( 'init' ) ) {
        // Only cache the value after init is done when we are sure all
        // plugins have registered their post types.
        ET_Core_Cache::add( $key, $post_type_options );
    }

    $post_type_options['select'] = 'Select Post Type';

    if(empty($post_type_options)) {
         $post_type_options = array(
             'not_found' => 'No Custom Post Type Found'
         );
    }

    return $post_type_options;
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

 function df_acf_fields_function($settings, $builder = false){
    global $post;
	 if (!class_exists('Df_Acf_Fields')){
		 require_once( DIFL_MAIN_DIR . '/includes/classes/df-acf-fields.php' );
	 }
    // get acf data stored in this instance
    // If no instance found then create instance and store all fields data
    $fields_storage = Df_Acf_Fields::getInstance();
    if(!isset($settings['acf_field'])) return;
    $field_type =  !empty($fields_storage->acf_fields_type) && isset($fields_storage->acf_fields_type[$settings['acf_field']]) ?
        $fields_storage->acf_fields_type[$settings['acf_field']] : array();
    $module_class = isset($settings['module_vb_class']) ? $settings['module_vb_class'] : '';
    $default_value = '';

    if( class_exists('ACF') ) {
        $default_value = "No ACF field selected";
    }
    ob_start();
    switch($field_type) {
        case 'text':
            echo et_core_esc_previously(df_acf_render_text_type($settings));
            break;
        case 'number':
            echo et_core_esc_previously(df_acf_render_number_type($settings));
            break;
        case 'textarea':
            echo et_core_esc_previously(df_acf_render_textarea_type($settings));
            break;
        case 'range':
            echo et_core_esc_previously(df_acf_render_range_type($settings));
            break;
        case 'email':
            echo et_core_esc_previously(df_acf_render_email_type($settings));
            break;
        case 'url':
            echo et_core_esc_previously(df_acf_render_url_type($settings));
            break;
        case 'image':
            echo et_core_esc_previously(df_acf_render_image_type($settings));
            break;
        case 'select':
            echo et_core_esc_previously(df_acf_render_select_type($settings));
            break;
        case 'date_picker':
            echo et_core_esc_previously(df_acf_render_date_type($settings));
            break;
        case 'wysiwyg':
            echo et_core_esc_previously(df_acf_render_wysiwyg_type($settings));
            break;
        default:
            echo esc_html($default_value);
    }
    $data = ob_get_clean();

    if( !empty($data) ) {
        echo sprintf('<div class="df-item-wrap df-item-acf %1$s %2$s">', esc_attr($settings['class']), esc_attr($module_class));
            echo et_core_esc_previously(df_render_pattern_or_mask_html($settings['background_enable_pattern_style'], 'pattern'));
            echo et_core_esc_previously(df_render_pattern_or_mask_html($settings['background_enable_mask_style'], 'mask'));
            echo '<div class="df-acf-field-inner">'. et_core_esc_previously($data) .'</div>';
        echo '</div>';
    }else{
	    echo sprintf('<span class="df-item-wrap df-item-acf df-empty-element %1$s %2$s"></span>',
		    esc_attr($settings['class']),
		    esc_attr($module_class)
	    );
    }

 }

 /**
 * Render ACF text field
 *
 * Supported tag - br, em, strong, b, p, ul, ol, li
 *
 * @param Array $settings
 * @return String
 */
function df_acf_render_text_type($settings) {
    global $post;
    $acf_field_data = wp_kses(get_field( $settings['acf_field'], $post->ID ), df_allowed_html_for_text_input());

    return $acf_field_data !== '' ?
        sprintf('%4$s%1$s%2$s%3$s',
            df_acf_before_after($settings)['before'],
            $acf_field_data,
            df_acf_before_after($settings)['after'],
            df_cpt_render_icon_image($settings)
        ): '';
}
/**
 * Render ACF Number field
 *
 * @param Array $settings
 * @return String
 */
function df_acf_render_number_type($settings) {
    global $post;
    $acf_field_data = wp_kses(get_field( $settings['acf_field'], $post->ID ), df_allowed_html_for_text_input());

    return $acf_field_data !== '' ?
        sprintf('%4$s%1$s%2$s%3$s',
            df_acf_before_after($settings)['before'],
            $acf_field_data,
            df_acf_before_after($settings)['after'],
            df_cpt_render_icon_image($settings)
        ) : '';
}
/**
 * Render ACF textarea field
 *
 * @param Array
 * @return String
 */
function df_acf_render_textarea_type($settings) {
    global $post;
    $acf_field_data = wp_kses(get_field( $settings['acf_field'], $post->ID ), df_allowed_html_for_text_input());

    return $acf_field_data !== '' ?
            sprintf('%4$s%1$s%2$s%3$s',
            df_acf_before_after($settings)['before'],
            $acf_field_data,
            df_acf_before_after($settings)['after'],
            df_cpt_render_icon_image($settings)
        ) : '';
}
/**
 * Render ACF range field
 *
 * @param Array
 * @return String
 */
function df_acf_render_range_type($settings) {
    global $post;
    $acf_field_data = wp_kses(get_field( $settings['acf_field'], $post->ID ), df_allowed_html_for_text_input());

    return $acf_field_data !== '' ?
            sprintf('%4$s%1$s%2$s%3$s',
            df_acf_before_after($settings)['before'],
            $acf_field_data,
            df_acf_before_after($settings)['after'],
            df_cpt_render_icon_image($settings)
        ) : '';
}
/**
 * Render ACF email field value
 *
 * @param Array
 * @return String
 */
function df_acf_render_email_type($settings) {
    global $post;
    $acf_field_data = esc_attr(get_field( $settings['acf_field'], $post->ID ));
    $email_text = $settings['acf_email_text'] !== '' ?
        esc_html($settings['acf_email_text']) : $acf_field_data;

    if($acf_field_data !== '') {
        $acf_field_data = sprintf('%5$s%1$s<a href="mailto:%2$s">%4$s</a>%3$s',
            df_acf_before_after($settings)['before'],
            $acf_field_data,
            df_acf_before_after($settings)['after'],
            $email_text,
            df_cpt_render_icon_image($settings)
        );
    }

    return $acf_field_data;
}
/**
 * Render ACF URL field type
 *
 * @param Array
 * @return String
 */
function df_acf_render_url_type($settings) {
    global $post;
    $acf_field_data = esc_attr(get_field($settings['acf_field'], $post->ID));
    $url_text = $settings['acf_url_text'] !== '' ?
        esc_html($settings['acf_url_text']) : $acf_field_data;
    $url_target = $settings['acf_url_new_window'] === 'on' ?
        'target="_blank"' : '';

    if($acf_field_data !== '') {
        $acf_field_data = sprintf('%6$s%1$s<a href="%2$s" %5$s>%4$s</a>%3$s',
            df_acf_before_after($settings)['before'],
            $acf_field_data,
            df_acf_before_after($settings)['after'],
            $url_text,
            $url_target,
            df_cpt_render_icon_image($settings)
        );
    }

    return $acf_field_data;
}
/**
 * Get AFC image url
 */
function df_get_acf_image_url( $data ) {
    if(is_array($data)) {
        return $data['url'];
    } elseif( is_int($data) ) {
        return wp_get_attachment_url($data);
    }
    return $data;
}
/**
 * Render ACF Image field type
 *
 * @param Array
 * @return String
 */
function df_acf_render_image_type($settings) {
    global $post;
    $acf_image_url = df_get_acf_image_url(get_field($settings['acf_field'], $post->ID));
    $image_alt_text =  df_image_alt_by_url($acf_image_url);
    
    if( !empty($acf_image_url) ) {
        return sprintf('%4$s%1$s<img class="df-acf-image" alt="%5$s" src="%2$s" />%3$s',
            df_acf_before_after($settings)['before'],
            esc_attr($acf_image_url),
            df_acf_before_after($settings)['after'],
            df_cpt_render_icon_image($settings),
            esc_attr($image_alt_text)
        );
    }
}
/**
 * Render ACF Select Field
 *
 * @param Array
 * @return String
 */
function df_acf_render_select_type($settings) {
    global $post;

    $acf_field_data = wp_kses(get_field( $settings['acf_field'], $post->ID ), df_allowed_html_for_text_input());

    return $acf_field_data !== '' ?
            sprintf('%4$s%1$s%2$s%3$s',
            df_acf_before_after($settings)['before'],
            $acf_field_data,
            df_acf_before_after($settings)['after'],
            df_cpt_render_icon_image($settings)
        ) : '';
}
/**
 * Render ACF Date Picker Field
 *
 * @param Array
 * @return String
 */
function df_acf_render_date_type($settings) {
    global $post;

    $acf_field_data = wp_kses(get_field( $settings['acf_field'], $post->ID ), df_allowed_html_for_text_input());

    return $acf_field_data !== '' ?
            sprintf('%4$s%1$s%2$s%3$s',
            df_acf_before_after($settings)['before'],
            $acf_field_data,
            df_acf_before_after($settings)['after'],
            df_cpt_render_icon_image($settings)
        ) : '';
}
/**
 * Render ACF wysiwyg Field
 *
 * @param Array
 * @return String
 */
function df_acf_render_wysiwyg_type($settings) {
    global $post;

    $acf_field_data = wp_kses_post(get_field( $settings['acf_field'], $post->ID));

    return $acf_field_data !== '' ?
            sprintf('%4$s%1$s%2$s%3$s',
            df_acf_before_after($settings)['before'],
            $acf_field_data,
            df_acf_before_after($settings)['after'],
            df_cpt_render_icon_image($settings)
        ) : '';
}

/**
 * Render ACF Fields before and after text
 *
 * @param Array $settings
 * @return Array
 */
function df_acf_before_after($settings){
    $before_label = wp_kses($settings['acf_before_label'], df_allowed_html_for_text_input());
    $after_label = wp_kses($settings['acf_after_label'], df_allowed_html_for_text_input());

    return array(
        'before' => $before_label !== '' ? sprintf('<span class="before-text">%1$s</span>', $before_label) : '',
        'after' => $after_label !== '' ? sprintf('<span class="after-text">%1$s</span>', $after_label) : ''
    );
}
/**
 * render pattern or mask markup
 *
 */


/**
 * Render markup for meta box fields
 *
 * Supported fields: 'text', 'number', 'textarea', 'range', 'email', 'url', 'image', 'select', 'date_picker', 'wysiwyg'
 *
 * @param Array $settings
 * @param Boolean
 * @return String
 */
function df_metabox_fields_function( $settings, $builder = false ) {
	if ( ! class_exists( 'Df_MetaBox_Fields' ) ) {
		require_once( DIFL_MAIN_DIR . '/includes/classes/df-metabox-fields.php' );
	}
	$fields_storage = Df_MetaBox_Fields::getInstance();
	if ( ! isset( $settings['metabox_field'] ) ) {
		return;
	}
	$field_type    = ! empty( $fields_storage->metabox_field_type ) && isset( $fields_storage->metabox_field_type[ $settings['metabox_field'] ] ) ?
		$fields_storage->metabox_field_type[ $settings['metabox_field'] ] : [];
	$module_class  = isset( $settings['module_vb_class'] ) ? $settings['module_vb_class'] : '';
	$default_value = '';

	if ( ! class_exists( $fields_storage->metabox_dependent_class ) ) {
		$default_value = "No Meta Box field selected";
	}

	ob_start();
	switch ( $field_type ) {
		case 'text':
			echo et_core_esc_previously( df_metabox_render_text_type( $settings ) );
			break;
		case 'number':
			echo et_core_esc_previously( df_metabox_render_number_type( $settings ) );
			break;
		case 'textarea':
			echo et_core_esc_previously( df_metabox_render_textarea_type( $settings ) );
			break;
		case 'range':
			echo et_core_esc_previously( df_metabox_render_range_type( $settings ) );
			break;
		case 'email':
			echo et_core_esc_previously( df_metabox_render_email_type( $settings ) );
			break;
		case 'url':
			echo et_core_esc_previously( df_metabox_render_url_type( $settings ) );
			break;
		case 'image':
			echo et_core_esc_previously( df_metabox_render_image_type( $settings ) );
			break;
		case 'select':
			echo et_core_esc_previously( df_metabox_render_select_type( $settings ) );
			break;
		case 'date_picker':
			echo et_core_esc_previously( df_metabox_render_date_type( $settings ) );
			break;
		case 'wysiwyg':
			echo et_core_esc_previously( df_metabox_render_wysiwyg_type( $settings ) );
			break;
		default:
			echo esc_html( $default_value );
	}

	$data = ob_get_clean();

	if ( ! empty( $data ) ) {
		echo sprintf( '<div class="df-item-wrap df-item-metabox %1$s %2$s">', esc_attr( $settings['class'] ), esc_attr( $module_class ) );
		echo et_core_esc_previously( df_render_pattern_or_mask_html( $settings['background_enable_pattern_style'], 'pattern' ) );
		echo et_core_esc_previously( df_render_pattern_or_mask_html( $settings['background_enable_mask_style'], 'mask' ) );
		echo '<div class="df-metabox-field-inner">' . et_core_esc_previously( $data ) . '</div>';
		echo '</div>';
	} else {
		echo sprintf( '<span class="df-item-wrap df-item-metabox df-empty-element %1$s %2$s"></span>',
			esc_attr( $settings['class'] ),
			esc_attr( $module_class )
		);
	}
}

function df_metabox_render_text_type( $settings ) {
	global $post;
	/*
	 * $meta_key = $settings['metabox_field'];
	 * $post_id = $post->ID;
	 * $post_type   = get_post_type($post_id);
	 * $object_type = $settings['post_type_for_metabox'];
	 * $sub_type    = $post_type;
	 * $identifier  = $post_id;
	 * $args = [];
	 * $field_registry = rwmb_get_registry('field');
	 * $field          = $field_registry->get($meta_key, $sub_type, $object_type);
	 * $$field_value    = rwmb_meta($meta_key, $args, $identifier);;
	*/

	$metabox_field_data = wp_kses( rwmb_meta( $settings['metabox_field'], [], $post->ID ), df_allowed_html_for_text_input() );

	return $metabox_field_data !== '' ?
		sprintf( '%4$s%1$s%2$s%3$s',
			df_metabox_before_after( $settings )['before'],
			$metabox_field_data,
			df_metabox_before_after( $settings )['after'],
			df_cpt_render_icon_image( $settings )
		) : '';
}

function df_metabox_render_number_type( $settings ) {
	global $post;
	$metabox_field_data = wp_kses( rwmb_meta( $settings['metabox_field'], [], $post->ID ), df_allowed_html_for_text_input() );

	return $metabox_field_data !== '' ?
		sprintf( '%4$s%1$s%2$s%3$s',
			df_metabox_before_after( $settings )['before'],
			$metabox_field_data,
			df_metabox_before_after( $settings )['after'],
			df_cpt_render_icon_image( $settings )
		) : '';
}

function df_metabox_render_textarea_type( $settings ) {
	global $post;
	$metabox_field_data = wp_kses( rwmb_meta( $settings['metabox_field'], [], $post->ID ), df_allowed_html_for_text_input() );

	return $metabox_field_data !== '' ?
		sprintf( '%4$s%1$s%2$s%3$s',
			df_metabox_before_after( $settings )['before'],
			$metabox_field_data,
			df_metabox_before_after( $settings )['after'],
			df_cpt_render_icon_image( $settings )
		) : '';
}

function df_metabox_render_range_type( $settings ) {
	global $post;
	$metabox_field_data = wp_kses( rwmb_meta( $settings['metabox_field'], [], $post->ID ), df_allowed_html_for_text_input() );

	return $metabox_field_data !== '' ?
		sprintf( '%4$s%1$s%2$s%3$s',
			df_metabox_before_after( $settings )['before'],
			$metabox_field_data,
			df_metabox_before_after( $settings )['after'],
			df_cpt_render_icon_image( $settings )
		) : '';
}

function df_metabox_render_email_type( $settings ) {
	global $post;
	$metabox_field_data = esc_attr( rwmb_meta( $settings['metabox_field'], [], $post->ID ) );
	$email_text         = $settings['metabox_email_text'] !== '' ? esc_html( $settings['metabox_email_text'] ) : $metabox_field_data;

	if ( $metabox_field_data !== '' ) {
		$metabox_field_data = sprintf( '%5$s%1$s<a href="mailto:%2$s">%4$s</a>%3$s',
			df_metabox_before_after( $settings )['before'],
			$metabox_field_data,
			df_metabox_before_after( $settings )['after'],
			$email_text,
			df_cpt_render_icon_image( $settings )
		);
	}

	return $metabox_field_data;
}

function df_metabox_render_url_type( $settings ) {
	global $post;
	$metabox_field_data = esc_attr( rwmb_meta( $settings['metabox_field'], [], $post->ID ) );
	$url_text           = $settings['metabox_url_text'] !== '' ? esc_html( $settings['metabox_url_text'] ) : $metabox_field_data;
	$url_target         = $settings['metabox_url_new_window'] === 'on' ? 'target="_blank"' : '';

	if ( $metabox_field_data !== '' ) {
		$metabox_field_data = sprintf( '%6$s%1$s<a href="%2$s" %5$s>%4$s</a>%3$s',
			df_metabox_before_after( $settings )['before'],
			$metabox_field_data,
			df_metabox_before_after( $settings )['after'],
			$url_text,
			$url_target,
			df_cpt_render_icon_image( $settings )
		);
	}

	return $metabox_field_data;
}

function df_metabox_render_image_type( $settings ) {
	global $post;
	$metabox_field_data = rwmb_meta( $settings['metabox_field'], [], $post->ID );
	if(!isset(reset( $metabox_field_data )['full_url'])){ return ""; }
	$metabox_image_url  = reset( $metabox_field_data )['full_url'];
	$image_alt_text     = df_image_alt_by_url( $metabox_image_url );

	if ( ! empty( $metabox_image_url ) ) {
		return sprintf( '%4$s%1$s<img class="df-acf-image" alt="%5$s" src="%2$s" />%3$s',
			df_metabox_before_after( $settings )['before'],
			esc_attr( $metabox_image_url ),
			df_metabox_before_after( $settings )['after'],
			df_cpt_render_icon_image( $settings ),
			esc_attr( $image_alt_text )
		);
	}
}

function df_metabox_render_select_type( $settings ) {
	global $post;
	$metabox_field_data = wp_kses( rwmb_meta( $settings['metabox_field'], [], $post->ID ), df_allowed_html_for_text_input() );

	return $metabox_field_data !== '' ?
		sprintf( '%4$s%1$s%2$s%3$s',
			df_metabox_before_after( $settings )['before'],
			$metabox_field_data,
			df_metabox_before_after( $settings )['after'],
			df_cpt_render_icon_image( $settings )
		) : '';
}

function df_metabox_render_date_type( $settings ) {
	global $post;
	$metabox_field_data = wp_kses( rwmb_meta( $settings['metabox_field'], [], $post->ID ), df_allowed_html_for_text_input() );

	return $metabox_field_data !== '' ?
		sprintf( '%4$s%1$s%2$s%3$s',
			df_metabox_before_after( $settings )['before'],
			$metabox_field_data,
			df_metabox_before_after( $settings )['after'],
			df_cpt_render_icon_image( $settings )
		) : '';
}

function df_metabox_render_wysiwyg_type( $settings ) {
	global $post;
	$metabox_field_data = wp_kses_post( rwmb_meta( $settings['metabox_field'], [], $post->ID ) );

	return $metabox_field_data !== '' ?
		sprintf( '%4$s%1$s%2$s%3$s',
			df_metabox_before_after( $settings )['before'],
			$metabox_field_data,
			df_metabox_before_after( $settings )['after'],
			df_cpt_render_icon_image( $settings )
		) : '';
}

function df_metabox_before_after( $settings ) {
	$before_label = wp_kses( $settings['metabox_before_label'], df_allowed_html_for_text_input() );
	$after_label  = wp_kses( $settings['metabox_after_label'], df_allowed_html_for_text_input() );

	return array(
		'before' => $before_label !== '' ? sprintf( '<span class="metabox-before-text">%1$s</span>', $before_label ) : '',
		'after'  => $after_label !== '' ? sprintf( '<span class="metabox-after-text">%1$s</span>', $after_label ) : ''
	);
}


function df_render_pattern_or_mask_html( $props, $type ) {
    $html = array(
        'pattern' => '<span class="et_pb_background_pattern"></span>',
        'mask' => '<span class="et_pb_background_mask"></span>'
    );
    return $props == 'on' ? $html[$type] : '';
}
/**
 * Use Post , Product , CPT Function file
 *
 * @param Array $settings
 * @return HTML
 */
function df_print_background_mask_and_pattern_dynamic_modules( $settings ) {
    $pattern_background = isset($settings['background_enable_pattern_style']) ? df_render_pattern_or_mask_html($settings['background_enable_pattern_style'], 'pattern') : '';
    $masking_background = isset($settings['background_enable_mask_style']) ? df_render_pattern_or_mask_html($settings['background_enable_mask_style'], 'mask') : '';
    return $pattern_background . $masking_background;
}

/**
 * Required functions
 *
 */
require_once( DIFL_MAIN_DIR . '/includes/functions/df_dashboard.php');
require_once( DIFL_MAIN_DIR . '/includes/functions/df_advanced_datatable_functions.php');
require_once( DIFL_MAIN_DIR . '/includes/functions/df_instagram.php');
require_once( DIFL_MAIN_DIR . '/includes/functions/df_imagegallery_functions.php');
require_once( DIFL_MAIN_DIR . '/includes/functions/df_jsgallery_functions.php');
require_once( DIFL_MAIN_DIR . '/includes/functions/df_packery_functions.php');
require_once( DIFL_MAIN_DIR . '/includes/functions/df_post_functions.php');
require_once( DIFL_MAIN_DIR . '/includes/functions/df_cpt_functions.php');
require_once( DIFL_MAIN_DIR . '/includes/functions/df_product_functions.php');
require_once( DIFL_MAIN_DIR . '/includes/functions/df_menu_functions.php');
require_once( DIFL_MAIN_DIR . '/includes/functions/df_breadcrumbs_functions.php');
require_once( DIFL_MAIN_DIR . '/includes/functions/df_acf_gallery_functions.php');

/**
 * Module Active/Inaction checker function
 *
 * @param Array $module_name
 * @return bolean true/false
 */
function is_module_active($module_name){
    $module_obj = new Diviflash_Module_Manage();
    $all_modules = $module_obj->all_modules_map();
    $all_parent_modules = array_column( $all_modules, 'parent' );
    $inactive_module = json_decode($module_obj->get_inactive_modules() );

    if (in_array( $module_name, $all_parent_modules ) && !in_array( $module_name, $inactive_module )) {
        return true;
    }
    return false;
}

function df_load_library() {
    $args = array(
        'post_type'      => 'et_pb_layout',
        'posts_per_page' => -1,
    );

    if ( false === ( $df_library_list = get_transient( 'df_load_library' ) ) ) {

        $df_library_list = array( 'none' => '-- Select Library --' );

        if ( $categories = get_posts( $args ) ) {
            foreach ( $categories as $category ) {
                $df_library_list[ $category->ID ] = $category->post_title;
            }
        }

        set_transient( 'df_load_library', $df_library_list, 24 * HOUR_IN_SECONDS );
    }

    return get_transient( 'df_load_library' );
}
function df_delete_library_transient() {
    delete_transient( 'df_load_library' );
}
add_action( 'save_post_et_pb_layout', 'df_delete_library_transient', 10, 3 );
add_action( 'deleted_post_et_pb_layout', 'df_delete_library_transient', 10, 3 );
add_action( 'edit_post_et_pb_layout', 'df_delete_library_transient', 10, 3 );

/**
 * VB HTML on AJAX request for Content Carousel
 * @return json response
 */
add_action( 'wp_ajax_df_content_switcher_request', 'df_content_switcher_request' );
function df_content_switcher_request() {

    $data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }
    $options = $data['props'];

    $args = array(
        'library_id_primary' =>  isset($options['library_id_primary']) ? $options['library_id_primary'] : [] ,
        'library_id_secondary' =>   isset($options['library_id_secondary']) ? $options['library_id_secondary'] : []
    );

     ob_start();

		ET_Builder_Element::clean_internal_modules_styles();

		echo do_shortcode(
			sprintf(
				'[et_pb_section global_module="%1$s" template_type="section" fullwidth="on"][/et_pb_section]',
				isset($args['library_id_primary']) ? $args['library_id_primary'] : []
			)
		);

		$internal_style = ET_Builder_Element::get_style();
		ET_Builder_Element::clean_internal_modules_styles( false );

		if ( $internal_style ) {
			$modules_style = sprintf(
				'<style id="df_content_switcher_styles_%2$s" type="text/css" class="df_content_switcher_styles_%2$s">
					%1$s
				</style>',
				$internal_style,
				isset($args['library_id_primary']) ? $args['library_id_primary'] : []
			);
		}

		if ( function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled() ) {
			echo et_core_esc_previously( $modules_style );
		}

		$render_shortcode = ob_get_clean();
    wp_send_json_success($render_shortcode);
}

/**
 * Render Divi library item
 *
 */
function df_render_library_layout($id) {
    $divi_library_shortcode = do_shortcode('[et_pb_section global_module="' . $id . '"][/et_pb_section]');
    $divi_library_shortcode .= '<style type="text/css">' . ET_Builder_Element::get_style() . '</style>';
    ET_Builder_Element::clean_internal_modules_styles(false);
	return $divi_library_shortcode;
}

function df_render_library_layout_for_popup($post_data)
{

		// $module_slugs = ET_Builder_Element::get_module_slugs_by_post_type();
		// $uuid = uniqid();
		// // TODO: This array could be cached as it never changes (unlike the replacements which need the uuid)
		// $map_to_regex = function ($value) {return '/' . $value . '_(\d+)(_tb_footer|)(,|\.|:| |")/';};
		// $regex = array_map($map_to_regex, $module_slugs);

		// $map_to_replacements = function ($value) use ($uuid) {return 'df_' . $uuid . '_' . $value . '_${1}${2}${3}';};
		// $replacements = array_map($map_to_replacements, $module_slugs);
		
		// $divi_library_shortcode = do_shortcode( $post_data->post_content );
		// $divi_library_shortcode .= '<style type="text/css">' . ET_Builder_Element::get_style() . '</style>';
		// ET_Builder_Element::clean_internal_modules_styles(false);

		// return str_replace("#page-container", "#df-popup-extension", preg_replace($regex, $replacements, $divi_library_shortcode));
        $difl_library_shortcode = do_shortcode( $post_data->post_content );
		if (class_exists('ET_Builder_Element') && method_exists('ET_Builder_Element', 'set_style' )) {
            $modified_css = str_replace(".et_pb_section_", ".df_popup_wrapper .et_pb_section_", ET_Builder_Element::get_style());
			$difl_library_shortcode .= '<style type="text/css">' . $modified_css . '</style>';
			ET_Builder_Element::clean_internal_modules_styles(false);
		}
		return str_replace("#page-container", "#df-popup-extension", $difl_library_shortcode);
}
/* Fontawsome Icon process issue when  dynamic css enable */
if ( ! function_exists( 'difl_inject_fa_icons' ) ) :
	/**
	 * Add Font Awesome css support manually when Dynamic CSS option is turn on in current installation
	 *
	 * @return void
	 * @since 1.0.0
	 */
	function difl_inject_fa_icons( $icon_data ) {
		if ( function_exists( 'et_pb_maybe_fa_font_icon' ) && et_pb_maybe_fa_font_icon( $icon_data ) ) {
			add_filter( 'et_global_assets_list', 'difl_global_assets_list' );
			add_filter( 'et_late_global_assets_list', 'difl_global_assets_list' );
		}
	}
endif;

if ( ! function_exists( 'difl_global_assets_list' ) ) {
    /**
     * Add Font Awesome css into divi asset list when Dynamic CSS option is turn on in current installation
     *
     * @return void
     * @since 1.0.0
     */
    function difl_global_assets_list( $global_list ) {
        $assets_list   = array();
        $assets_prefix = et_get_dynamic_assets_path();
        $assets_list['et_icons_fa'] = array(
            'css' => "{$assets_prefix}/css/icons_fa_all.css",
        );
        return array_merge( $global_list, $assets_list );
    }
}
/* Default Value Set Function */

if ( ! function_exists( 'difl_backend_support_for_divi' ) ):
	// wp-content/plugins/divi-shop-builder/divi-shop-builder.php:1457
	function difl_backend_support_for_divi( $defs ) {

		$modules_defaults = array(
			'title'    => _x( 'Your Title Goes Here', 'Modules dummy content', 'et_builder' ),
			'subtitle' => _x( 'Subtitle goes Here', 'et_builder' ),
			'body'     => _x(
				'<p>Your content goes here. Edit or remove this text inline or in the module Content settings. You can also style every aspect of this content in the module Design settings and even apply custom CSS to this text in the module Advanced settings.</p>', // phpcs:ignore WordPress.WP.I18n.NoHtmlWrappedStrings -- Need to have p tag.
				'et_builder'
			),
			'number'   => 50,
			'button'   => _x( 'Click Here', 'Modules dummy content', 'et_builder' ),
			'icon'     => array(
				'icon_list'       => '&#x4e;||divi||400',
			),
			'image'    => array(
				'landscape'       => ET_BUILDER_PLACEHOLDER_LANDSCAPE_IMAGE_DATA,
				'portrait'        => ET_BUILDER_PLACEHOLDER_PORTRAIT_IMAGE_DATA,
			),
			'video'    => 'https://www.youtube.com/watch?v=FkQuawiGWUw',
		);

		$single_shortcode = sprintf(
			'[difl_iconlistitem list_item_title="%1$s" list_icon_type="icon" list_item_icon="%2$s"][/difl_iconlistitem]',
			$modules_defaults['title'],
			$modules_defaults['icon']['icon_list']
		);

		$shortcodes = implode('', array( $single_shortcode, $single_shortcode, $single_shortcode));

        // FAQ module
        $faq_defaults = [
            'question' => _x( 'Your Question Goes Here', 'Modules dummy content', 'et_builder' ),
            'content'   => _x( 'Your Answer Goes Here...', 'Modules dummy content', 'et_builder' )
        ];

        $faq_shortcode = sprintf(
            '[difl_faqitem question="%1$s"]%2$s[/difl_faqitem]',
            $faq_defaults['question'],
            $faq_defaults['content']
        );
        
        $generate_faq_items = implode('', array( $faq_shortcode, $faq_shortcode, $faq_shortcode));
        
        // Timeline module
        $tmln_defaults = [
            'title'      => _x( 'Your title goes here', 'Modules dummy content', 'et_builder' ),
            'content'    => _x( 'Your content goes here...', 'Modules dummy content', 'et_builder'),
            'date_title' => _x( 'Title', 'Modules dummy content', 'et_builder' ),
            'date_sub_title' => _x( '01 Mar, 2023', 'Modules dummy content', 'et_builder' ),
            'button_text'=> _x( 'Click Here', 'Modules dummy content', 'et_builder' ),
			'icon'       => array(
				'marker_icon' => '&#x4c;||divi||400',
			),
			'content_image' => array(
				'landscape' => ET_BUILDER_PLACEHOLDER_LANDSCAPE_IMAGE_DATA
			)
        ];

        $tmln_shortcode = sprintf(
            '[difl_timelineitem title="%1$s" content_image="%3$s" marker_separetor_type="icon" marker_icon="%4$s" button_text="%5$s" date_title="%6$s" date_sub_title="%7$s"]%2$s[/difl_timelineitem]',
            $tmln_defaults['title'],
            $tmln_defaults['content'],
            $tmln_defaults['content_image']['landscape'],
            $tmln_defaults['icon']['marker_icon'],
            $tmln_defaults['button_text'],
            $tmln_defaults['date_title'],
            $tmln_defaults['date_sub_title']
        );

        $generate_tmln_items = implode('', array( $tmln_shortcode, $tmln_shortcode, $tmln_shortcode));

        // advanced menu
        $advncedmenuItem1 = sprintf('[difl_advancedmenuitem type="logo" menu_item_label="logo" menu_item_position="center_left" menu_item_position_small="center_left" logo_upload="%1$s"][/difl_advancedmenuitem]', DIFL_PLACEHOLDER_LOGO);
        $advncedmenuItem2 = sprintf('[difl_advancedmenuitem type="menu" menu_item_position="center_center" menu_item_position_small="center_center" menu_item_label="menu" menu_id="%1$s"][/difl_advancedmenuitem]', df_get_primary_menu_id());
        $advncedmenuItem3 = '[difl_advancedmenuitem type="button" menu_item_position="center_right" menu_item_position_small="center_right" menu_item_label="button" button_text="Button Text"][/difl_advancedmenuitem]';
        $advMenu_shortcode = implode('', array($advncedmenuItem1, $advncedmenuItem2, $advncedmenuItem3));

        // postList
        $postList1 = '[difl_postlistitem type="title"][/difl_postlistitem]';
        $postList2 = '[difl_postlistitem type="date"][/difl_postlistitem]';
        $postList3 = '[difl_postlistitem type="author"][/difl_postlistitem]';
        $postList4 = '[difl_postlistitem type="content"][/difl_postlistitem]';

        $postlist_shortcode = implode('', array($postList1, $postList2, $postList3, $postList4));

		// Image Reveal_defaults
		$imageReveal_defaults = array(
			'hover_content_title' => _x( 'Your Title Goes Here..', 'Modules dummy content', 'et_builder' ),
			'caption'             => _x( 'Your Caption Goes Here', 'Modules dummy content', 'et_builder' ),
			'image'               => array(
				'landscape' => ET_BUILDER_PLACEHOLDER_LANDSCAPE_IMAGE_DATA,
				'portrait'  => ET_BUILDER_PLACEHOLDER_PORTRAIT_IMAGE_DATA,
			),
		);

        // Marquee Text
        $marqueetext_defaults = [
            'text' => _x('Your Text Goes Here...', 'Modules dummy content', 'et_builder')
        ];

        $marqueetext_shortcode = sprintf(
            '[difl_marqueetextitem text="%1$s"]%1$s[/difl_marqueetextitem]',
            $marqueetext_defaults['text']
        );

        // TextHighlighter module
        $text_highlighter_defaults = [
            'title_prefix' => _x( 'Prefix', 'Modules dummy content', 'et_builder' ),
            'title_infix'  => _x( 'Infix', 'Modules dummy content', 'et_builder' ),
            'title_suffix' => _x( 'Suffix', 'Modules dummy content', 'et_builder' ),
        ];

        $generate_marqueTxt_items = implode('', array($marqueetext_shortcode, $marqueetext_shortcode, $marqueetext_shortcode, $marqueetext_shortcode, $marqueetext_shortcode));

		return $defs . sprintf(
				'; window.DIFL_Diviflash_Backend=%s;',
				et_fb_remove_site_url_protocol(
					wp_json_encode(
						array(
							// wp-content/themes/Divi/includes/builder/functions.php:11181
							// wp-content/themes/Divi/includes/builder/frontend-builder/helpers.php:727
							'iconListDefault'       => array(
								'content' => et_fb_process_shortcode( $shortcodes )
							),
							'iconListItemDefault'     => array(
								'list_item_title'     => $modules_defaults['title'],
								'list_icon_type'      => 'icon',
								'list_item_icon'      => $modules_defaults['icon']['icon_list'],
								'list_item_image'     => $modules_defaults['image']['landscape'],
								'list_item_icon_text' => '01',
								'alt' => 'Icon Image',
								'admin_label' => 'List item',
							),
                            'faqDefault'  => array(
								'content' => et_fb_process_shortcode($generate_faq_items),
								'faq_item_per_column' => 3,
								'faq_item_per_column_tablet' => 2,
								'faq_item_per_column_phone' => 1,
                                'faq_item_per_column_last_edited' => "on|desktop"
							),
							'faqItemDefault' => array(
								'question'   => $faq_defaults['question'],
								'content'     => $faq_defaults['content'],
							),
                            'timelineDefault'  => array(
								'content' => et_fb_process_shortcode($generate_tmln_items)
							),
							'timelineItemDefault' => array(
								'title'   => $tmln_defaults['title'],
								'content'     => $tmln_defaults['content'],
								// 'date_title'   => $tmln_defaults['date_title'],
								'date_sub_title'     => $tmln_defaults['date_sub_title'],
								'button_text'     => $tmln_defaults['button_text'],
								'marker_icon'     => $tmln_defaults['icon']['marker_icon'],
								'content_image'     => $tmln_defaults['content_image']['landscape']
							),
                            'advancedMenuDefault' => array(
                                'content'         =>  et_fb_process_shortcode( $advMenu_shortcode )
                            ),
                            'advancedMenuItemDefault' => array(
                                'logo_upload'         =>  DIFL_PLACEHOLDER_LOGO,
                                'button_text'         => 'Button Text'
                            ),
                            'postListDefault' => array(
                                'content'         =>  et_fb_process_shortcode( $postlist_shortcode )
                            ),
							'imageRevealDefault'      => array(
								'field_image'         => $imageReveal_defaults['image']['landscape'],
								'field_hover_content_title_text' => $imageReveal_defaults['hover_content_title'],
								'field_caption_title' => $imageReveal_defaults['caption']
                            ),
                            'marqueeTextDefault'  => array(
								'content' => et_fb_process_shortcode($generate_marqueTxt_items)
							),
							'marqueeTextItemDefault' => array(
								'text' => $marqueetext_defaults['text']
							),
							'textHighlighterDefault' => array(
								'title_prefix' => $text_highlighter_defaults['title_prefix'],
								'title_infix' => $text_highlighter_defaults['title_infix'],
								'title_suffix' => $text_highlighter_defaults['title_suffix']
							),
						),
						ET_BUILDER_JSON_ENCODE_OPTIONS
					)
				)
			);
	}

	add_filter( 'et_fb_get_asset_definitions', 'difl_backend_support_for_divi', 11 );
endif;

/**
 * Get the primary menu ID
 * 
 * @return String | menu id if primary-menu set or 'none'
 */
function df_get_primary_menu_id() {
    $menu = get_nav_menu_locations();
    if(isset($menu['primary-menu'])) {
        return $menu['primary-menu'];
    } else { 
        return 'none'; 
    }
}
/**
* Still not use
* To Get Dynamic content: Ajax Callback function
* 
* @return response | JSON
 */

function df_builder_ajax_resolve_post_content() {
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ), 'et_fb_resolve_post_content' ) ) { // phpcs:ignore ET.Sniffs.ValidatedSanitizedInput -- The nonce value is used only for comparision in the `wp_verify_nonce`.
		et_core_die();
	}

	$_       = ET_Core_Data_Utils::instance();
	$post_id = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : 0;
	// phpcs:disable ET.Sniffs.ValidatedSanitizedInput -- All values from `$_POST['groups']` and `$_POST['overrides']` arrays value are being sanitized before use in following foreach loop.
	$groups    = isset( $_POST['groups'] ) && is_array( $_POST['groups'] ) ? $_POST['groups'] : array();
	$overrides = isset( $_POST['overrides'] ) && is_array( $_POST['overrides'] ) ? $_POST['overrides'] : array();
	// phpcs:enable
	$overrides = array_map( 'wp_kses_post', $overrides );
	$post      = get_post( $post_id );

	$invalid_permissions = ! current_user_can( 'edit_post', $post_id );
	$invalid_post        = null === $post;

	if ( $invalid_permissions || $invalid_post ) {
		et_core_die();
	}

	$response = array();

	foreach ( $groups as $hash => $field_group ) {
		$group             = sanitize_text_field( isset( $field_group['group'] ) ? (string) $field_group['group'] : '' );
		$field             = isset( $field_group['field'] ) ? sanitize_text_field( (string) $field_group['field'] ) : '';
		$settings          = isset( $field_group['settings'] ) && is_array( $field_group['settings'] ) ? wp_unslash( $field_group['settings'] ) : array();
		$settings          = array_map( 'wp_kses_post', $settings );
		$is_content        = $_->array_get( $field_group, 'attribute' ) === 'content';
		$response[ 'value' ] = apply_filters( "et_builder_resolve_{$group}_post_content_field", $field, $settings, $post_id, $overrides, $is_content );
        // $content = apply_filters( 'et_builder_resolve_dynamic_content', '', $name, $settings, $post_id, 'display', $overrides );

        // $content = apply_filters( "et_builder_resolve_dynamic_content_{$field}", $content, $settings, $post_id, 'display', $overrides );

        // $content = et_maybe_enable_embed_shortcode( $content, $is_content );

        // $value = $is_content ? do_shortcode( $content ) : $content;
        // $response[ 'value'] = $value;
	}
	wp_send_json_success( $response );
}
add_action( 'wp_ajax_df_builder_resolve_post_content', 'df_builder_ajax_resolve_post_content' );

/**
 * Get all gravity forms
 * 
 */
function df_load_g_forms() {
    $option_array = array(
        'none' => 'Select a form'
    );
    if(class_exists('GFAPI')) {
        $forms = GFAPI::get_forms();
        if(!empty($forms)) {
            foreach($forms as $form) {
                $option_array[$form['id']] = $form['title'];
            }
            return $option_array;
        }
    }
    return $option_array;
}
// Handle custom date format
function df_handle_custom_date_format( $post_id ) {
	if ( ! $post_id ) {
		return;
	}
	$post_data    = isset( $_POST['modules'] ) ? json_decode( stripslashes( $_POST['modules'] ), true ) : []; //phpcs:ignore -- handle through filter for date format escaping
	$post_content = et_fb_process_to_shortcode( $post_data, [], '', true, true );
	if ( false !== strpos( $post_content, 'difl_cptitem' ) || false !== strpos( $post_content, 'difl_postitem' ) || false !== strpos( $post_content, 'difl_postlistitem' ) ) {
		$post_content       = str_replace( '\\', '%92', $post_content );
		$post               = get_post( $post_id );
		$post->post_content = $post_content;
		wp_update_post( $post );
		add_filter( 'et_fb_ajax_save_verification_result', function () {
			return true;
		} );
	}
}

add_action( 'et_save_post', 'df_handle_custom_date_format', 10 );

function df_border_radius_important( $style, $selector ) {
	$slugs   = [ 'difl_wpforms' ];
	$modules = [];
	$slugs   = apply_filters( 'df_border_radius_module_slug', $slugs );
	foreach ( $slugs as $slug ) {
		foreach ( range( 0, 5 ) as $number ) {
			$modules[] = $slug . '_' . $number;
		}
	}

	$found = false;

	foreach ( $modules as $module ) {
		if ( false === strpos( $selector, $module ) ) {
			continue;
		}
		$found = true;
		break;
	}

	if ( ! $found ) {
		return $style;
	}

	$declaration = isset( $style['declaration'] ) ? $style['declaration'] : '';
	$priority    = isset( $style['priority'] ) ? $style['priority'] : '';

	if ( false === strpos( $declaration, 'border-radius' ) || false !== strpos( $declaration, '!important' ) ) {
		return $style;
	}

	$important            = str_replace( ';', ' !important; ', $declaration );
	$style['declaration'] = $important;
	$style['priority']    = $priority;

	return $style;
}

add_filter( 'et_builder_set_style', 'df_border_radius_important', 10, 2 );

function df_sanitize_text_field( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'df_sanitize_text_field', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}

	function df_divi_is_theme() {
		return ( strpos( get_template_directory(), 'Divi' ) !== false ) || ( strpos( get_template_directory(), 'Extra' ) !== false );
	}

	function df_divi_is_plugin() {
		$plugins = get_option( 'active_plugins' );
		$plugin  = 'divi-builder/divi-builder.php';

		return in_array( $plugin, $plugins );
	}

	function df_load_portability_class() {
		if ( df_divi_is_theme() ) {
			return get_template_directory() . '/core/components/Portability.php';
		}

		if ( df_divi_is_plugin() ) {
			return WP_PLUGIN_DIR . '/' . plugin_dir_path( 'divi-builder/divi-builder.php' ) . '/core/components/Portability.php';
		}
	}