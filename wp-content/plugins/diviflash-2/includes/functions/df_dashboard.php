<?php
defined( 'ABSPATH' ) || die();

/**
 * Process styles for diviflash
 * from dashboard settings
 *
 * - menu hover line styles
 *
 * @return void
 */
function df_process_menu_line_styles_fb () {
	$menu_line 						= get_option('df_menu_bottom_line');
	$hide_menu_border_bottom 		= get_option('df_menu_hide_bottom_border');

	$styles = '';

	// generate menu line styles
	// check if the option is on?
	if($menu_line == '1') {
		$line_color 			= get_option('df_menu_bottom_line_color');
		$line_height 			= get_option('df_menu_bottom_line_height');
		$line_width 			= get_option('df_menu_line_width', 'full');
		$line_distance 			= get_option('df_menu_bottom_line_distance');
		$line_distance_fixed	= get_option('df_menu_bottom_line_distance_fixed');
		$line_animation 		= get_option('df_menu_line_animation');

		$width 	= array (
			'full'			=> array (
				'width'	=> '100%',
				'left'	=> '0',
				'right'	=> '0'
			),
			'half_left'		=> array (
				'width' => '50%',
				'left'	=> '0',
				'right'	=> 'auto'
			),
			'half_right'	=> array (
				'width' => '50%',
				'right' => '0',
				'left'	=> 'auto'
			)
		);
		// menu line styles
		$styles .= sprintf('
				#top-menu-nav .nav li a {
					position: relative;
				}
				#top-menu-nav ul.nav > li > a:before {
					content: "";
					display: block;
					width: %1$s;
					left: %2$s;
					right: %3$s;
					height: %4$spx;
					background-color: %5$s;
					position: absolute;
					bottom: %6$spx;
					transition: all .3s ease;
					transform: scaleX(0);
					transform-origin: %7$s;
				}
				.et-fixed-header #top-menu-nav .nav li a:before {
					bottom: %8$spx;
				}
				#top-menu-nav .nav li a:hover:before,
				#top-menu-nav .nav li.current-menu-item a:before {
					transform: scaleX(1);
				}
			',
			esc_attr($width[$line_width]['width']),
			esc_attr($width[$line_width]['left']),
			esc_attr($width[$line_width]['right']),
			esc_attr($line_height),
			esc_attr($line_color),
			esc_attr($line_distance),
			esc_attr($line_animation),
			esc_attr($line_distance_fixed)
		);
	};

	// menu button styles
	if ($hide_menu_border_bottom == '1') {
		$styles .= '#main-header {box-shadow: none !important;}';
	}

	// menu item distance between
	$styles .= sprintf('
			#top-menu-nav .nav li:not(:last-child) {
				padding-right: %1$spx;
			}
		',
		esc_attr(get_option('df_menu_item_distance'))
	);

	wp_add_inline_style('df-lib-styles', $styles);
}
add_action( 'wp_enqueue_scripts', 'df_process_menu_line_styles_fb', 99 );

/**
 * Adding mime type support
 * from the dashboard settings
 *
 * @return object
 */
add_filter( 'mime_types', 'df_adding_mime_types_support', 99);

function df_adding_mime_types_support( $mimes ) {
    $df_general_svg_support = get_option('df_general_svg_support');
    $df_general_json_support = get_option('df_general_json_support');

    if($df_general_svg_support == 1) {
		if(!defined('ALLOW_UNFILTERED_UPLOADS')) {
			define('ALLOW_UNFILTERED_UPLOADS', true);
		}
        $mimes['svg']  = 'image/svg+xml';
    }
    if($df_general_json_support == 1) {
		if(!defined('ALLOW_UNFILTERED_UPLOADS')) {
			define('ALLOW_UNFILTERED_UPLOADS', true);
		}
        $mimes['json']  = 'text/plain';
    }
	
    return $mimes;
}

/**
 * Create New Admin Column
 * for shortcode to use
 * 
 * @return Object
 */
add_filter( 'manage_et_pb_layout_posts_columns', 'df_shortcode_create_shortcode_column', 5 );

function df_shortcode_create_shortcode_column( $columns ) {

    $df_general_library_shortcode = get_option('df_general_library_shortcode');

    if($df_general_library_shortcode == 1) {
        $columns['df_shortcode_id'] = __( 'Shortcode', 'divi_flash');
    }
    
    return $columns;
}
/**
 * Display Shortcode
 * from library post type
 * 
 * @return Void
 */
add_action( 'manage_et_pb_layout_posts_custom_column', 'df_shortcode_content', 5, 2 );
function df_shortcode_content ( $column, $id ) {
    if( 'df_shortcode_id' == $column ) {
        ?>
        <div class="df-shortcode-wrapper">
            <p class="df-shortcode-copy"><?php echo '[df_layout_shortcode id="'.esc_attr( $id ).'"]'; ?></p>
            <p class="df-cpy-tooltip">Click to copy</p>
        </div>
        <?php
    }
}
/**
 * Function to show the module
 * from library item
 * 
 * @return String
 */
function df_module_shortcode_callback($atts) {
	$atts = shortcode_atts(array('id' => ''), $atts);
	return do_shortcode('[et_pb_section global_module="'.  esc_attr($atts['id']).'"][/et_pb_section]');	
}
add_shortcode('df_layout_shortcode', 'df_module_shortcode_callback');

