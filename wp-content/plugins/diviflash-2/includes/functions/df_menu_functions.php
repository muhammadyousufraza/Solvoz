<?php

/**
 * Advanced Menu: Render Menus for AdvancedMenu in VB
 * 
 */
add_action('wp_ajax_df_am_menu', 'df_am_menu');
function df_am_menu() {

    // create the display gallery code
    $data = json_decode(file_get_contents('php://input'), true);
    if (! wp_verify_nonce( $data['et_admin_load_nonce'], 'et_admin_load_nonce' )) {
        wp_die();
    }

    $menu_id = $data['menu_id'];

    $defaults     = array(
        'menu'           => '',
        'menu_id'        => $menu_id,
    );

    $menu = df_get_am_menu($defaults);
    wp_send_json_success($menu);
}

function df_display_am_menus_load_actions( $actions ) {
	$actions[] = 'df_am_menu';

	return $actions;
}
add_filter( 'et_builder_load_actions', 'df_display_am_menus_load_actions' );

/**
 * Get the menu
 * 
 */
function df_get_am_menu($defaults) {
    // modify the menu item to include the required data
    // add_filter( 'wp_setup_nav_menu_item', array( 'ET_Builder_Module_Menu', 'modify_fullwidth_menu_item' ) );

    $args      = array();
    $args      = wp_parse_args( $args, $defaults );
    $menu      = '<nav class="df-menu-wrap">';
    $menuClass = 'df-menu-nav df-menu-nav-level-0';

    // divi_disable_toptier option available in Divi theme only
    if ( ! et_is_builder_plugin_active() && 'on' === et_get_option( 'divi_disable_toptier' ) ) {
        $menuClass .= ' et_disable_top_tier';
    }

    $menu_args = array(
        'theme_location' => '',
        'container'      => '',
        'fallback_cb'    => '',
        'menu_class'     => $menuClass,
        'menu_id'        => '',
        'echo'           => false,
        'walker'         => new DF_Nav_Walker()
    );

    if ( '' !== $args['menu_id'] ) {
        $menu_args['menu'] = (int) $args['menu_id'];
    } else {
        // When menu ID is not preset, let's use the primary menu.
        // However, it's highly unlikely that the menu module won't have an ID.
        // When were're using menu module via the `menu_id` we dont need the menu's theme location.
        // We only need it when the menu doesn't have any ID and that occurs only used on headers and/or footers,
        // Or any other static places where we need menu by location and not by ID.
        $menu_args['theme_location'] = 'primary-menu';
    }

    $filter     = 'et_menu_args';
    $primaryNav = wp_nav_menu( apply_filters( $filter, $menu_args ) );
    
    if ( empty( $primaryNav ) ) {
        $menu .= sprintf(
            '<ul class="%1$s">
                %2$s',
            esc_attr( $menuClass ),
            ( ! et_is_builder_plugin_active() && 'on' === et_get_option( 'divi_home_link' )
                ? sprintf(
                    '<li%1$s><a href="%2$s">%3$s</a></li>',
                    ( is_home() ? ' class="current_page_item"' : '' ),
                    esc_url( home_url( '/' ) ),
                    esc_html__( 'Home', 'divi_flash' )
                )
                : ''
            )
        );

        ob_start();

        // @todo: check if Menu module works fine with no menu selected in settings
        if ( et_is_builder_plugin_active() ) {
            wp_page_menu();
        } else {
            show_page_menu( $menuClass, false, false );
            show_categories_menu( $menuClass, false );
        }

        $menu .= ob_get_contents();

        $menu .= '</ul>';

        ob_end_clean();
    } else {
        $menu .= $primaryNav;
    }

    $menu .= '</nav>';

    // remove_filter( 'wp_setup_nav_menu_item', array( 'ET_Builder_Module_Menu', 'modify_fullwidth_menu_item' ) );

    return $menu;
}

function df_get_menu_item_meta($id) {
    $options = get_post_meta($id, '_df_mega_menu_item_settings');
    $default = array(
        "menu_item_id"          => $id,
        'submenu_type'          => 'normal',
        "content_width_type"    => 'normal_width',
        "custom_width_value"    => '',
        "submenu_position"      => 'bottom_left',
        "menu_icon"             => '',
        "icon_color"            => '',
        "tooltip_text"          => '',
        "tooltip_color"         => '',
        "tooltip_background"    => '',
        "tooltip_position"      => '',
        "tooltip_position"      => '',
        'item_position'         => '',
        'mega_menu'             => '',
        'mega_menu_column'      => '',
        'menu_position'         => '',
        'mega_menu_width'       => 'normal_width',
        'mega_menu_custom_width'=> '',
        'mega_menu_alignment'   => 'bottom_left'
    );
    
    if(!empty($options)) {
        $options = json_decode($options[0], true);

        if(isset($options['menu_id'])) {
            $menu_settings = get_term_meta($options['menu_id'], '_df_am_dashboard', true);
            if($menu_settings !== 'on') return $default;
        } else return $default;

        $options = array_merge($default, $options);

        return $options;
    }
    return $options;
}

/**
 * Render menu icon & image
 * 
 * @param Array     $options
 * @return Srting   $icon/$image
 */
function df_render_menu_icon($options) {
    if(empty($options)) return;
    $output = '';
    // process icon
    if((!isset($options['use_image']) || $options['use_image'] == false) && !empty($options['menu_icon'])) {
        $color = $options['icon_color'] != '' ? 'color: '. $options['icon_color'] . ';' : '';
        $font_weight = $options['menu_icon']['font_weight'] != '' ? 'font-weight: '. $options['menu_icon']['font_weight'] . ';' : '';
        $font_family = $options['menu_icon']['is_divi_icon'] == true ? 'font-family: ETmodules;' : 'font-family: FontAwesome;';

        $style = $color . $font_weight . $font_family;
        $output = sprintf('<span class="df-menu-icon" %2$s>
                %1$s
            </span>',
            $options['menu_icon']['unicode'],
            $style !== '' ? 'style="'.$style.'"' : ''
        );
    }
    // process image
    if(isset($options['use_image']) && $options['use_image'] == true && (!empty($options['image_url']) || !empty($options['image_object']))) {
        $image_width = isset($options['image_icon_width']) && !empty($options['image_icon_width']) ? 
            $options['image_icon_width'] : '25';
        $output = sprintf('<img src="%1$s" width="%2$s"/>', isset($options['image_object']) && !empty($options['image_object']) ? $options['image_object']['url'] : esc_url( $options['image_url'] ), esc_attr( $image_width ) );
    }

    return $output;
}
/**
 * Render submenu layout
 * 
 * @param Array     $options
 * @return String   $submenu
 */
add_filter('df_nav_item_layout', 'df_render_menu_layout', 99);
function df_render_menu_layout($options) {
    if(empty($options)) return;
    if($options['submenu_type'] != 'divi_layout') return;
    // process the layout
    ob_start();
    echo '<div class="sub-menu df-custom-submenu">';
        echo '<div class="df-menu-layout-inner">';
            echo do_shortcode('[et_pb_section global_module="'. $options['library_items'].'"/]');
        echo '</div>';
    echo '</div>';
    $submenu = ob_get_contents();
    ob_get_clean();

    return $submenu;
}

/**
 * Render tooltip for nav item
 * 
 * @param Array     $options
 * @return String   HTML
 */
add_filter('df_nav_item_tooltip', 'df_nav_item_tooltip_callback', 99);
function df_nav_item_tooltip_callback($options) {
    if(empty($options['tooltip_text'])) return;

    $style = sprintf('style="%1$s%2$s"',
        !empty($options['tooltip_color']) ? 'color: ' . $options['tooltip_color'] . ';' : '',
        !empty($options['tooltip_background']) ? 'background-color: ' . $options['tooltip_background'] . ';' : ''
    );
    $tooltip_position = !empty($options['tooltip_position']) ? $options['tooltip_position'] : 'left';

    return sprintf(
        '<span class="df-nav-item-tooltip" data-tooltip-positon="%3$s" %2$s>%1$s</span>',
         $options['tooltip_text'], $style, $tooltip_position
    );
}

/**
 * Render badge for nav item
 * 
 * @param Array     $options
 * @return String   HTML
 */
add_filter('df_nav_item_badge', 'df_nav_item_badge_callback', 99, 2);
function df_nav_item_badge_callback($badge, $options) {
    if(empty($options['badge_text'])) return;

    $style = sprintf('style="%1$s%2$s%3$s"',
        !empty($options['badge_color']) ? 'color: ' . $options['badge_color'] . ';' : '',
        !empty($options['badge_background']) ? 'background-color: ' . $options['badge_background'] . ';' : '',
        isset($options['badge_position']) && $options['badge_position'] == 'left' ? 'order: -1;' : ''
    );
    $arrow_class = isset($options['badge_arrow']) && $options['badge_arrow'] == true ? 'has-arrow' : '';

    $badge = sprintf(
        '<span class="df-nav-item-badge %3$s%4$s" %2$s>%1$s</span>',
         $options['badge_text'], 
         $style, 
         $arrow_class,
         isset($options['badge_position']) && $options['badge_position'] == 'left' ? ' left' : ''
    );
    return $badge;
}
/**
 * Adding class to custom submenu parent
 * 
 * 'menu-item-has-children'
 * 'df-mega-menu'
 * 
 * @param string    $classes
 * @param object    $menu_item
 * @param array     $args
 * @param string    $depth
 * @return string
 */
add_filter('df_nav_menu_css_class', 'df_nav_menu_css_class', 10, 5);
function df_nav_menu_css_class( $classes, $menu_item, $args, $depth, $options ) {

    if (isset($options['submenu_type']) && $options['submenu_type'] === 'divi_layout' && !empty($options['library_items'])) {
        $classes[] = 'menu-item-has-children';
        $classes[] = 'df-mega-menu';
    }
    if($depth == 0) {
        if(isset($options['mega_menu']) && $options['mega_menu'] === true) {
            $classes[] = 'df-mega-menu';
        }
        $classes[] = 'menu-item-level-0';
    }

    return $classes;
}

/**
 * Render arrow if the item has children
 * 
 * @param
 */
add_filter('df_nav_item_arrow', 'df_nav_item_arrow_callback', 10, 4);
function df_nav_item_arrow_callback($options, $menu_item, $args, $depth) {
    $arrow = '<span class="dropdown-arrow">3</span>';
    if (isset($options['submenu_type']) && $options['submenu_type'] === 'divi_layout' && !empty($options['library_items'])) {
        return $arrow;
    }
    if($args->walker->has_children == '1') {
        return $arrow;
    }
}
/**
 * Adding custom data attributes to li
 * 
 * @param object    $menu_item
 * @param array     $args
 * @param string    $depth
 * @param array     $options
 * @return string
 */
add_filter('df_nav_menu_item_data', 'df_nav_menu_item_data_callback', 10, 4);
function df_nav_menu_item_data_callback($menu_item, $args, $depth, $options) {
    $data = '';

    if ( $depth == '0' && isset($options['mega_menu_column']) && !empty($options['mega_menu_column'])) {
        $data .= ' data-column="' . $options['mega_menu_column'] . '"';
    }
    if ( $depth == '1' && isset($options['item_position']) && !empty($options['item_position'])) {
        $data .= ' data-column="' . $options['item_position'] . '"';
    }
    // adding attributes for default mega menu
    if( $depth == '0' && isset($options['mega_menu']) && $options['mega_menu'] == true ) {
        if( isset($options['mega_menu_width']) && !empty($options['mega_menu_width']) ) {
            $data .= ' data-width="'.$options['mega_menu_width'].'"';
        } else {
            $data .= ' data-width="normal_width"';
        }
        if( isset($options['mega_menu_custom_width']) && !empty($options['mega_menu_custom_width']) ) {
            $data .= ' data-width-value="'.$options['mega_menu_custom_width'].'"';
        }
        if( isset($options['mega_menu_alignment']) && !empty($options['mega_menu_alignment']) ) {
            $data .= ' data-alignment="'.$options['mega_menu_alignment'].'"';
        }
    }

    // adding attributes submenu layout
    if( $depth == '0' && isset($options['submenu_type']) && $options['submenu_type'] == 'divi_layout' ) {
        if( isset($options['content_width_type']) && !empty($options['content_width_type']) ) {
            $data .= ' data-width="'.$options['content_width_type'].'"';
        } else {
            $data .= ' data-width="normal_width"';
        }
        if( isset($options['custom_width_value']) && !empty($options['custom_width_value']) ) {
            $data .= ' data-width-value="'.$options['custom_width_value'].'"';
        }
        if( isset($options['submenu_position']) && !empty($options['submenu_position']) ) {
            $data .= ' data-alignment="'.$options['submenu_position'].'"';
        }
    }
    

    return $data;
}