<?php

defined( 'ABSPATH' ) || die();

class DiviFlash_Media_Category {
	const TAXONOMY = "difl_media_category";

	public function __construct() {
		add_action( 'init', [ $this, 'init_media_category' ] );
		add_action( 'restrict_manage_posts', [ $this, 'add_category_filter_in_list_view' ] );
		add_filter( 'ajax_query_attachments_args', [ $this, 'add_category_filter_in_grid_view' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_media_action_for_grid_view_filter' ] );
		add_action( 'admin_footer-upload.php', [ $this, 'custom_bulk_admin_footer' ] );
		add_action( 'load-upload.php', [ $this, 'custom_bulk_action' ] );
		add_filter( 'attachment_fields_to_edit', [ $this, 'attachment_fields_to_edit' ], 10, 2 );
		add_action( 'wp_ajax_save-attachment-compat', [ $this, 'save_attachment_compat' ], 0 );
	}

	public function init_media_category() {
		if ( taxonomy_exists( self::TAXONOMY ) ) {
			register_taxonomy_for_object_type( self::TAXONOMY, 'attachment' );
		} else {
			$labels = [
				'name'              => _x( 'DF Media Categories', 'taxonomy general name', 'divi_flash' ),
				'singular_name'     => _x( 'DF Media Categories', 'taxonomy singular name', 'divi_flash' ),
				'search_items'      => __( 'Search Category', 'divi_flash' ),
				'all_items'         => __( 'All Category', 'divi_flash' ),
				'edit_item'         => __( 'Edit Category', 'divi_flash' ),
				'update_item'       => __( 'Update Category', 'divi_flash' ),
				'add_new_item'      => __( 'Add New Category', 'divi_flash' ),
				'new_item_name'     => __( 'New Category Name', 'divi_flash' ),
				'menu_name'         => __( 'DF Media Categories', 'divi_flash' ),

			];

			$args = [
				'labels'                => $labels,
				'hierarchical'          => false,
				'show_admin_column'     => true,
				'show_ui'               => true,
				'update_count_callback' => "_update_generic_term_count",
				'show_in_rest'          => false,
				'public'                => false,
				'publicly_queryable'    => false,
				'show_in_quick_edit'    => true
			];
			register_taxonomy( self::TAXONOMY, [ 'attachment' ], $args );
		}
	}

	public function add_category_filter_in_list_view() {
		global $pagenow, $wp_query;
		if ( 'upload.php' == $pagenow ) {
			$selected         = isset( $wp_query->query[ self::TAXONOMY ] ) ? $wp_query->query[ self::TAXONOMY ] : 0;
			$dropdown_options = [
				'taxonomy'        => self::TAXONOMY,
				'name'            => self::TAXONOMY,
				'class'           => 'postform difl-mc-taxonomy-filter',
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

	public function add_category_filter_in_grid_view( $query = [] ) {
		$taxonomies = get_object_taxonomies( 'attachment', 'names' );
		foreach ( $taxonomies as $taxonomy ) {
			if ( isset( $query[ $taxonomy ] ) && is_numeric( $query[ $taxonomy ] ) ) {
				$query['tax_query'][] = [
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => $query[ $taxonomy ]
				];
			}
			unset( $query[ $taxonomy ] );
		}

		return $query;
	}

	public function enqueue_media_action_for_grid_view_filter() {
		global $pagenow;

		if ( wp_script_is( 'media-editor' ) && 'upload.php' == $pagenow ) {
			$this->load_media_view_scripts();
		}

		wp_enqueue_style( 'df-wp-media-category', DIFL_ADMIN_DIR. 'css/df-wp-media-category.css', [], DIFL_VERSION );
	}

	public function load_media_view_scripts() {

		$terms_data = [];
		$terms = get_terms( [
			'taxonomy'   => self::TAXONOMY,
			'show_count' => true,
			'hide_empty' => false
		] );
		foreach ($terms as $term){
			$terms_data[] = ["term_id" => $term->term_id, "term_name" => $term->name, "total_count"=>$term->count];
		}

		wp_enqueue_script( 'df-wp-media-category-media-views', DIFL_ADMIN_DIR.'js/df-wp-media-category-media-views.js',  [ 'media-views' ], DIFL_VERSION, true );

		wp_localize_script( 'df-wp-media-category-media-views', 'difl_media_taxonomie_data', [
			self::TAXONOMY => [
				'list_title' => esc_html__( __( 'View all Category', 'divi_flash' ), ENT_QUOTES, 'UTF-8' ),
				'term_list' => $terms_data,
			],
		]);
	}


	public function custom_bulk_admin_footer() {
		$terms = get_terms( [
			'taxonomy'   => self::TAXONOMY,
			'hide_empty' => false,
		] );

		if ($terms && !is_wp_error($terms)) :

			ob_start(); ?>

			<script type="text/javascript">
                jQuery(window).on('load', function () {
                    jQuery('<optgroup id="difl-mc-optgroup-1" label="<?php echo esc_html__('DF Media', 'divi_flash'); ?>">').appendTo("select[name='action']");
                    jQuery('<optgroup id="difl-mc-optgroup-2" label="<?php echo esc_html__('DF Media', 'divi_flash'); ?>">').appendTo("select[name='action2']");

                    // add categories
	                <?php foreach ($terms as $term) : ?>
	                <?php
	                $optionValue = 'difl-mc-add-' . esc_attr($term->term_taxonomy_id);
	                $optionText = esc_js(__('Add', 'divi_flash') . ': ' . esc_html($term->name));
	                ?>
                    jQuery('<option>').val('<?php echo esc_attr($optionValue); ?>').text('<?php echo esc_html($optionText); ?>').appendTo('#difl-mc-optgroup-1');
                    jQuery('<option>').val('<?php echo esc_attr($optionValue); ?>').text('<?php echo esc_html($optionText); ?>').appendTo('#difl-mc-optgroup-2');
	                <?php endforeach; ?>


                    // remove categories
	                <?php foreach ($terms as $term) : ?>
	                <?php
	                $optionValue = 'difl-mc-remove-' . esc_attr($term->term_taxonomy_id);
	                $optionText = esc_js(__('Remove', 'divi_flash') . ': ' . esc_html($term->name));
	                ?>
                    jQuery('<option>').val('<?php echo esc_attr($optionValue); ?>').text('<?php echo esc_html($optionText); ?>').appendTo('#difl-mc-optgroup-1');
                    jQuery('<option>').val('<?php echo esc_attr($optionValue); ?>').text('<?php echo esc_html($optionText); ?>').appendTo('#difl-mc-optgroup-2');
	                <?php endforeach; ?>



                    // remove all categories
                    jQuery('<option>').val('difl-mc-remove-0').text('<?php echo esc_attr(__('Remove all categories', 'divi_flash')); ?>').appendTo('#difl-mc-optgroup-1');
                    jQuery('<option>').val('difl-mc-remove-0').text('<?php echo esc_attr(__('Remove all categories', 'divi_flash')); ?>').appendTo('#difl-mc-optgroup-2');
                });
			</script>

			<?php
			$output = ob_get_clean();
			echo et_core_esc_previously($output);

		endif;
	}



	public function custom_bulk_action() {

		if ( ! isset( $_REQUEST['action'] ) ) {
			return;
		}


		// is it a category?
		$sAction = ( isset($_REQUEST['action']) && $_REQUEST['action'] !== -1 ) ? sanitize_text_field($_REQUEST['action']) : ( isset($_REQUEST['action2']) ? sanitize_text_field($_REQUEST['action2']) : '' ); // phpcs:ignore WordPress.Security.NonceVerification
		if ( 'difl-mc-' !== substr( $sAction, 0, 8 )) {
			return;
		}

		// security check
		check_admin_referer( 'bulk-media' );

		// make sure ids are submitted.  depending on the resource type, this may be 'media' or 'post'
		if ( isset( $_REQUEST['media'] ) ) {
			$post_ids = array_map( 'intval', $_REQUEST['media'] );
		}

		if ( empty( $post_ids ) ) {
			return;
		}

		$sendback = admin_url( "upload.php?editCategory=1" );

		// remember pagenumber
		$pagenum  = isset( $_REQUEST['paged'] ) ? absint( $_REQUEST['paged'] ) : 0;
		$sendback = add_query_arg( 'paged', $pagenum, $sendback );

		// remember orderby
		if ( isset( $_REQUEST['orderby'] ) ) {
			$sOrderby = sanitize_text_field($_REQUEST['orderby']);
			$sendback = esc_url( add_query_arg( 'orderby', $sOrderby, $sendback ) );
		}
		// remember order
		if ( isset( $_REQUEST['order'] ) ) {
			$sOrder   = sanitize_text_field($_REQUEST['order']);
			$sendback = esc_url( add_query_arg( 'order', $sOrder, $sendback ) );
		}
		// remember author
		if ( isset( $_REQUEST['author'] ) ) {
			$sOrderby = sanitize_text_field($_REQUEST['author']);
			$sendback = esc_url( add_query_arg( 'author', $sOrderby, $sendback ) );
		}

		foreach ( $post_ids as $post_id ) {

			if ( is_numeric( str_replace( 'difl-mc-add-', '', $sAction ) ) ) {
				$nCategory = str_replace( 'difl-mc-add-', '', $sAction );

				// update or insert category
				$term = get_term_by( 'term_taxonomy_id', $nCategory, self::TAXONOMY );
				wp_set_object_terms($post_id, $term->name, self::TAXONOMY, true);

			} else if ( is_numeric( str_replace( 'difl-mc-remove-', '', $sAction ) ) ) {
				$nCategory = str_replace( 'difl-mc-remove-', '', $sAction );

				// remove all categories
				if ( $nCategory == 0 ) {
					wp_delete_object_term_relationships($post_id, self::TAXONOMY);
					// remove category
				} else {
					$term_ids = array_map( 'intval', [$nCategory] );
					wp_remove_object_terms($post_id, $term_ids,self::TAXONOMY);
				}

			}
		}

		wp_safe_redirect( $sendback ); // perform a safe (local) redirect
		exit();
	}

    public function attachment_fields_to_edit($form_fields, $post) {
	    $terms_data = [];
	    $terms = get_terms( [
		    'taxonomy'   => self::TAXONOMY,
		    'hide_empty' => false
	    ] );
        if(count($terms) <= 0){
	        return $form_fields;
        }
        $_option_data = '';
	    $selected_cats = wp_get_object_terms( $post->ID, self::TAXONOMY, array_merge( ['taxonomy'=>self::TAXONOMY], array( 'fields' => 'ids' ) ) );
	    foreach ($terms as $term){
		    $terms_data[] = $term->name;
		    $_option_data .= '<li id="difl_media_category-' . esc_attr($term->slug) . '" class="popular-category">';
		    $_option_data .= '<label class="selectit">';
		    $_option_data .= '<input value="' . esc_attr($term->slug) . '" type="checkbox" name="tax_input[difl_media_category][]" id="in-difl_media_category-' . esc_attr($term->slug) . '" ' . (in_array($term->term_taxonomy_id, $selected_cats) ? 'checked="checked"' : '') . '>';
		    $_option_data .= esc_html($term->name);
		    $_option_data .= '</label>';
		    $_option_data .= '</li>';
	    }


        $html = '<ul class="difl-media-term-list">' . $_option_data . '</ul>';

	    $form_fields[self::TAXONOMY] = array(
		    'label' => "DF Media Category",
		    'input' => 'html',
            'html' => $html,
            'value' => join(', ', $terms_data),
            'show_in_edit' => false,
            'multiple' => true
	    );
	    return $form_fields;
    }

    public function save_attachment_compat() {
	    if (isset($_REQUEST['nonce']) && wp_verify_nonce( sanitize_text_field($_REQUEST['nonce']), 'nonce' )) {
		    wp_die();
	    }
	    if ( ! isset( $_REQUEST['id'] ) ) {
		    wp_send_json_error();
	    }

	    if ( ! $id = absint( $_REQUEST['id'] ) ) {
		    wp_send_json_error();
	    }

	    if ( empty( $_REQUEST['attachments'] ) || empty( $_REQUEST['attachments'][ $id ] ) ) {
		    wp_send_json_error();
	    }
	    $attachment_data = wp_unslash(sanitize_text_field($_REQUEST['attachments'][ $id ]));

	    check_ajax_referer( 'update-post_' . $id, 'nonce' );

	    if ( ! current_user_can( 'edit_post', $id ) ) {
		    wp_send_json_error();
	    }

	    $post = get_post( $id, ARRAY_A );

	    if ( 'attachment' != $post['post_type'] ) {
		    wp_send_json_error();
	    }

	    /** This filter is documented in wp-admin/includes/media.php */
	    $post = apply_filters( 'attachment_fields_to_save', $post, $attachment_data );

	    if ( isset( $post['errors'] ) ) {
		    $errors = $post['errors']; // @todo return me and display me!
		    unset( $post['errors'] );
	    }

	    wp_update_post( $post );

	    foreach ( get_attachment_taxonomies( $post ) as $taxonomy ) {
		    if ( isset( $attachment_data[ $taxonomy ] ) ) {
			    wp_set_object_terms( $id, array_map( 'sanitize_key', (array) $attachment_data[ $taxonomy ] ), $taxonomy, false );
		    } else if ( isset( $_REQUEST['tax_input'] ) && isset( $_REQUEST['tax_input'][ $taxonomy ] ) ) {
			    wp_set_object_terms( $id, array_map( 'sanitize_key', (array) $_REQUEST['tax_input'][ $taxonomy ] ), $taxonomy, false );
		    } else {
			    wp_set_object_terms( $id, '', $taxonomy, false );
		    }
	    }
    }

}
new DiviFlash_Media_Category();