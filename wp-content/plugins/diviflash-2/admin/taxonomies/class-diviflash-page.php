<?php

defined( 'ABSPATH' ) || die();

class DiviFlash_Page_Category {
	const TAXONOMY = "difl_page_category";
	public function __construct() {
		add_action( 'init', [ $this, 'init_page_category' ] );
		add_action( 'restrict_manage_posts', [ $this, 'add_category_filter' ] );
	}

	public function init_page_category() {
		if ( taxonomy_exists( self::TAXONOMY ) ) {
			register_taxonomy_for_object_type( self::TAXONOMY, 'page' );
		} else {
			// translations part for GUI
			$labels = [
				'name'              => _x( 'DF Page Categories', 'taxonomy general name', 'divi_flash' ),
				'singular_name'     => _x( 'DF Page Categories', 'taxonomy singular name', 'divi_flash' ),
				'search_items'      => __( 'Search Category', 'divi_flash' ),
				'all_items'         => __( 'All Category', 'divi_flash' ),
				'edit_item'         => __( 'Edit Category', 'divi_flash' ),
				'update_item'       => __( 'Update Category', 'divi_flash' ),
				'add_new_item'      => __( 'Add New Category', 'divi_flash' ),
				'new_item_name'     => __( 'New Category Name', 'divi_flash' ),
				'menu_name'         => __( 'DF Page Categories', 'divi_flash' ),

			];

			$args = [
				'labels'                => $labels,
				'hierarchical'          => false,
				'show_admin_column'     => true,
				'update_count_callback' => "_update_generic_term_count",
				'show_in_rest'          => true,
			];
			register_taxonomy( self::TAXONOMY, [ 'page' ], $args );
		}
	}

	public function add_category_filter() {
		global $pagenow, $wp_query;
		if ( 'edit.php' == $pagenow ) {
			$selected         = isset( $wp_query->query[ self::TAXONOMY ] ) ? $wp_query->query[ self::TAXONOMY ] : 0;
			$dropdown_options = [
				'taxonomy'        => self::TAXONOMY,
				'name'            => self::TAXONOMY,
				'class'           => 'postform difl-pc-taxonomy-filter',
				'show_option_all' => __( 'View all Category', 'divi_flash' ),
				'hide_empty'      => false,
				'hierarchical'    => false,
				'orderby'         => 'name',
				'selected'        => $selected,
				'show_count'      => true,
				'value'           => 'slug',
				'value_field'     => 'slug',
			];
			wp_dropdown_categories( $dropdown_options );
		}
	}

}
new DiviFlash_Page_Category();