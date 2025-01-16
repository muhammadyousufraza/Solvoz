<?php

namespace DIFL\Importer;

use DIFL\Dashboard;

class Processor {
	protected $errors = null;

	protected $notices = [];

	public $layout;

	public $layout_folder;
	protected $portability_manager;

	protected $response = [];

	public function __construct() {
		add_action( 'wp_ajax_difl_layout_import', [ $this, 'ajax_layout_import_action' ] );
		$this->set_filesystem();
		$this->errors = new \WP_Error();
	}

	public function handle_import() {
		$this->portability_manager = new Portability( 'epanel' );
		$this->install_dep_plugins();
		$this->import_other_plugin_settings();
		//Media
		$this->import_content();
		//Divi Theme options
		$this->import_theme_options();
		//DF options
		$this->import_df_options();
		//Customizer & Widget
		$this->import_customizer();
		//Theme Builder template
		$this->import_builder_templates();
		// Import layout
		$this->import_layout();
		$this->handle_menu();
		$this->delete_layout_folder();
		wp_send_json( $this->response );
	}

	protected function import_layout() {
		$layout                    = $this->get_file_content( 'layouts_all' );
		$this->portability_manager = new Portability( 'et_builder_layouts' );
		$result                    = $this->handle_customizer_layout_import( $layout );
		if ( $result ) {
			$this->response['success'] = true;
			$this->response['message'] = __( 'Layout imported successfully', 'divi_flash' );
		}
		$this->delete_layout_folder();
		wp_send_json_success( $this->response );
	}

	protected function handle_customizer_layout_import( $layout ) {
		if ( ! isset( $layout['context'] ) ) {
			et_core_die();
		}
		$context = $layout['context'];
		$post_id = isset( $layout['post'] ) ? (int) $layout['post'] : 0;
		$replace = 1;

		if ( ! et_core_portability_cap( $context ) ) {
			et_core_die();
		}

		$result = $this->portability_manager->import_customizer_and_layout( $layout );

		if ( ! $result ) {
			wp_send_json_error();
		}

		if ( $replace && $post_id > 0 && current_user_can( 'edit_post', $post_id ) ) {
			wp_update_post( array(
				'ID'           => $post_id,
				'post_content' => sanitize_post_field( 'post_content', $result['postContent'], 0, 'db'),
			) );
		}

		return true;
	}

	protected function get_file_content( $type_slug, $type = 'json' ) {
		global $wp_filesystem;
		$slug        = trim( $this->layout->slug );
		$file_prefix = Layout::$temp_dir . $this->layout_folder . '/' . $slug . '_';
		$file        = $file_prefix . $type_slug . '.' . $type;

		if ( ! is_file( $file ) ) {
			return false;
		}

		$content = $wp_filesystem->get_contents( $file );

		if ( 'json' === $type ) {
			return json_decode( $content, true );
		}

		return $content;
	}

	public function import_content() {
		$this->import_other_plugin_settings();
        $this->import_df_popup();
        $folder      = Layout::$temp_dir . $this->layout_folder;
		$all_content = glob( "$folder/*.xml" );

		if ( empty( $all_content ) ) {
			return false;
		}

		$this->install_wp_importer();

		if ( ! class_exists( 'WP_Import' ) ) {
			if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
				define( 'WP_LOAD_IMPORTERS', true );
			}
			if ( file_exists( WP_PLUGIN_DIR . '/' . 'wordpress-importer/wordpress-importer.php' ) ) {
				require_once WP_PLUGIN_DIR . '/' . 'wordpress-importer/wordpress-importer.php';
			}
		}

		if ( ! class_exists( 'WP_Import' ) ) {
			return false;
		}

		$wp_import                    = new \WP_Import();
		$wp_import->fetch_attachments = true;

		foreach ( $all_content as $file ) {
			ob_start();
			$wp_import->import( $file );
			$results = ob_get_clean();
		}

		$this->response['success'] = true;
		$this->response['message'] = esc_html__( 'Import content successfully', 'divi_flash' );
		wp_send_json_success( $this->response );
	}

	public function install_wp_importer() {
		if ( class_exists( 'WP_Import' ) ) {
			return true;
		}
		$slug   = 'wordpress-importer';
		$plugin = 'wordpress-importer/wordpress-importer.php';

		return $this->handle_dep_plugins( $slug, $plugin );
	}

	public function handle_dep_plugins( $slug, $plugin ) {
		if ( empty( $slug ) || empty( $plugin ) ) {
			return false;
		}

		if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin ) ) {
			$this->portability_manager->activate_plugin( $plugin );

			return true;
		}

		$results = $this->portability_manager->install_plugin( $slug );

		if ( $results['success'] ) {
			$this->portability_manager->activate_plugin( $plugin );

			return true;
		}

		return false;
	}

	public function import_builder_templates() {
		$templates = $this->get_file_content( 'divi_theme_builder' );
		$impoter   = new Builder( $templates );
		$result    = $impoter->import();
		if ( $result ) {
			$this->response['success'] = true;
			$this->response['message'] = esc_html__( 'Import builder templates successfully', 'divi_flash' );
		}
		wp_send_json_success( $this->response );
	}

	public function initialize() {
		update_option( 'difl_svg_upload', 'on' );
		global $wp_filesystem;
		WP_Filesystem();
		$this->portability_manager = new Portability( 'epanel' );

		$results = [ 'success' => true ];
		if ( ! $wp_filesystem->exists( WP_PLUGIN_DIR . '/wordpress-importer/wordpress-importer.php' ) ) {
			$results = $this->portability_manager->install_plugin( 'wordpress-importer' );
		}
		if ( $results['success'] ) {
			$this->portability_manager->activate_plugin( 'wordpress-importer/wordpress-importer.php' );
		}
		$this->install_dep_plugins();
		$this->response['success'] = true;
		$this->response['message'] = esc_html__( 'Initialized successfully', 'divi_flash' );
		wp_send_json_success( $this->response );
	}

	public function ajax_layout_import_action() {
		if ( ! check_ajax_referer( 'difl_dashboard' ) ) {
			$this->response['success'] = false;
			$this->response['message'] = __( 'Nonce failed', 'divi_falsh' );
			$this->response['abort']   = true;
			wp_send_json_success( $this->response );
		}

		$this->prevent_failure();
		$this->load_divi_framework();
		$post_data = $_POST; //phpcs:ignore WordPress.Security.NonceVerification.Missing --handled below
		$steps     = [
			'init'              => [ $this, 'initialize' ],
			'download'          => [ $this, 'download_layout_package' ],
			'content'           => [ $this, 'import_content' ],
			'divi_options'      => [ $this, 'import_theme_options' ],
			'df_options'        => [ $this, 'import_df_options' ],
			'customizer'        => [ $this, 'import_customizer' ],
			'builder_templates' => [ $this, 'import_builder_templates' ],
			'template_library'  => [ $this, 'import_layout' ],
		];
		$task      = $steps[ $post_data['task'] ];
		if ( empty( $task ) ) {
			$this->response['success'] = false;
			$this->response['message'] = __( 'Task not found.something went wrong', 'divi_falsh' );
			wp_send_json_success( $this->response );
		}

		$obj    = $task[0];
		$method = $task[1];

		if ( ! method_exists( $obj, $method ) ) {
			$this->response['success'] = false;
			$this->response['message'] = __( 'Method not found.something went wrong', 'divi_falsh' );
			wp_send_json_success( $this->response );
		}

		$this->setup_layout( $post_data );
		$obj->$method();
	}

	protected function setup_layout( $post_data ) {
		$this->portability_manager = new Portability( 'epanel' );
		$post_data                 = array_map( 'wp_unslash', $post_data );
		$post_data['settings']     = (object) $this->trim( json_decode( $post_data['settings'], true ) );
		$this->layout              = $post_data['settings'];

		$temp_dir            = Layout::$temp_dir;
		$slug                = $this->layout->slug;
		$this->layout_folder = "diviflash_{$slug}_layout_pack";
	}

	protected function load_divi_framework() {
		add_filter( 'et_builder_should_load_framework', '__return_true' );
	}

	public function set_filesystem() {
		add_filter( 'filesystem_method', [ $this, 'replace_filesystem_method' ] );
	}

	public function replace_filesystem_method() {
		return 'direct';
	}

	public function download_layout_package() {
		$this->response['success'] = true;
		$this->response['message'] = __( 'Download layout package successfully', 'divi_flash' );

		$current_file        = Layout::$temp_dir . $this->layout->slug . '.zip';
		$temp_dir            = Layout::$temp_dir;
		$files = glob( rtrim( sys_get_temp_dir(), DIRECTORY_SEPARATOR ) . '/*' );
		foreach ( $files as $file ) {
			if ( is_file( $file ) ) {
				unlink( $file );
			}
		}

		$slug                = $this->layout->slug;
		$this->layout_folder = "diviflash_{$slug}_layout_pack";
		if ( file_exists( $current_file ) || file_exists( $temp_dir . $this->layout_folder ) ) {
			wp_send_json_success( $this->response );
		}

		$response = wp_remote_get( $this->layout->package_url, [
			'timeout'   => 600,
			'sslverify' => false
		] );

		if ( is_wp_error( $response ) ) {
			return [
				'success'      => false,
				'errorMessage' => 'Faild to download layout package (invalid package url)',
				'res'          => $response
			];
		}

		$content_type = wp_remote_retrieve_header( $response, 'content-type' );

		if ( ! $content_type === 'application/zip' ) {
			wp_send_json_error( [
				'success' => false,
				'message' => 'Failed to download layout package (invalid file type)',
				'abort'   => true
			], 500 );
		}

		$zip = $response['body'];

		global $file;
		if ( empty( $file ) ) {
			$file = $current_file;
		}
		if ( ! empty( $file ) && $file !== $current_file ) {
			$file = $current_file;
		}

		global $wp_filesystem;
		$wp_filesystem->put_contents( $file, $zip );
		$this->unzip_file( Layout::$temp_dir . $this->layout->slug . '.zip' );
		wp_send_json_success( $this->response, 200 );
	}

	protected function prevent_failure() {
		@set_time_limit( 0 );
		wp_raise_memory_limit();
	}

	protected function install_dep_plugins() {
		$plugins = [
			'contact_form7' => [ 'slug' => 'contact-form-7', 'file' => 'contact-form-7/wp-contact-form-7.php' ],
			'wpforms'       => [ 'slug' => 'wpforms-lite', 'file' => 'wpforms-lite/wpforms.php' ],
			'acf'           => [ 'slug' => 'advanced-custom-fields', 'file' => 'advanced-custom-fields/acf.php' ],
			'cpt_ui'        => [
				'slug' => 'custom-post-type-ui',
				'file' => 'custom-post-type-ui/custom-post-type-ui.php'
			],
			'gravity_forms' => 'pro',
			'monarch'       => 'pro',
			'bloom'         => 'pro',
		];

		if ( ! property_exists( $this->layout, 'plugins' ) ) {
			return false;
		}

		$dep_plugins = $this->layout->plugins;

		foreach ( $plugins as $key => $plugin ) {
			list( 'slug' => $slug, 'file' => $file ) = $plugin; //phpcs:ignore

			if ( ! in_array( $key, $dep_plugins ) ) {
				continue;
			}

			$this->handle_dep_plugins( $slug, $file );
		}
	}

	protected function import_theme_options() {
		$options = $this->get_file_content( 'divi_theme_options' );
		$this->portability_manager->import_theme_options( $options );
		$this->response['success'] = true;
		$this->response['message'] = esc_html__( 'Import theme options successfully', 'divi_flash' );
		wp_send_json_success( $this->response );
	}

	protected function import_df_options() {
		$settings = $this->get_file_content( 'difl_options' );

		// Enable All Modules
		$modules = array_map( function ( $module ) {
			return $module['parent'];
		}, Dashboard::get_module_list() );

		update_option( 'df_active_modules', wp_json_encode( $modules ) );

		if ( empty( $settings ) ) {
			$this->response['success'] = true;
			$this->response['message'] = esc_html__( 'Import DF options successfully', 'divi_flash' );
			wp_send_json_success( $this->response );
			return false;
		}

		$settings_key = Dashboard::get_setting_keys();

		foreach ( df_sanitize_text_field( $settings ) as $key => $value ) {
			if ( in_array( $key, $settings_key ) ) {
				update_option( $key, $value ); //phpcs:ignore sanitized through helper
			}
		}

		$this->response['success'] = true;
		$this->response['message'] = esc_html__( 'Import DF options successfully', 'divi_flash' );
		wp_send_json_success( $this->response );
	}

	protected function import_other_plugin_settings() {
		$this->import_acf_settings();
		$this->import_bloom_settings();
		$this->import_cpt_ui_settings();
		$this->import_monarch_settings();
		$this->import_wp_forms();
	}

	protected function import_wp_forms() {
		$forms = $this->get_file_content( 'others_wpforms' );
		$exist = $this->func_exists( 'wpforms_encode' );

		if ( empty( $forms ) || empty( $exist ) ) {
			return false;
		}

		foreach ( $forms as $form ) {
			$title  = ! empty( $form['settings']['form_title'] ) ? $form['settings']['form_title'] : '';
			$desc   = ! empty( $form['settings']['form_desc'] ) ? $form['settings']['form_desc'] : '';
			$new_id = wp_insert_post(
				[
					'post_title'   => sanitize_post_field( 'post_title', $title, 0, 'db'),
					'post_status'  => 'publish',
					'post_type'    => 'wpforms',
					'post_excerpt' => sanitize_post_field( 'post_excerpt', $desc, 0, 'db' )
				]
			);

			if ( $new_id ) {
				$form['id'] = $new_id;

				wp_update_post(
					[
						'ID'           => $new_id,
						'post_content' => wpforms_encode( $form ),
					]
				);
			}

			if ( ! empty( $form['settings']['form_tags'] ) ) {
				wp_set_post_terms(
					$new_id,
					implode( ',', (array) $form['settings']['form_tags'] ),
					\WPForms_Form_Handler::TAGS_TAXONOMY
				);
			}
		}
	}

	protected function import_monarch_settings() {
		$monarch_settings = $this->get_file_content( 'others_monarch' );

		if ( empty( $monarch_settings ) ) {
			return false;
		}

		if ( ! class_exists( 'ET_Monarch' ) ) {
			require_once WP_PLUGIN_DIR . '/monarch/monarch.php';
		}

		global $et_monarch;

		if ( empty( $et_monarch ) ) {
			$et_monarch = new \ET_Monarch();
		}

		if ( empty( $et_monarch ) || is_wp_error( $et_monarch ) ) {
			return false;
		}
		// update the networks list and remove retired networks
		$updated_networks                                      = $et_monarch->update_saved_networks( $monarch_settings );
		$monarch_settings['follow_networks_networks_sorting']  = $updated_networks['follow_networks_networks_sorting'];
		$monarch_settings['sharing_networks_networks_sorting'] = $updated_networks['sharing_networks_networks_sorting'];
		$monarch_settings                                      = array_filter( $monarch_settings, function ( $settings ) {
			return ! empty( $settings );
		} );
		$error_message                                         = $et_monarch->process_and_update_options( $monarch_settings );
	}

	protected function import_acf_settings() {
		$acf_settings   = $this->get_file_content( 'others_acf' );
		$used_functions = [
			'acf_determine_internal_post_type',
			'acf_get_internal_post_type_post',
			'acf_import_internal_post_type'
		];

		$exist = $this->func_exists( $used_functions );
		if ( empty( $exist ) || empty( $acf_settings ) ) {
			return false;
		}

		foreach ( $acf_settings as $setting ) {
			$post_type = acf_determine_internal_post_type( $setting['key'] );
			$post      = acf_get_internal_post_type_post( $setting['key'], $post_type );

			if ( $post ) {
				$setting['ID'] = $post->ID;
			}

			$posts = acf_import_internal_post_type( $setting, $post_type );
			if ( ! empty( $posts ) ) {
				return true;
			}
		}
	}

	protected function import_bloom_settings() {
		//Todo if coming
	}

	protected function import_cpt_ui_settings() {
		$exist = $this->func_exists( 'cptui_import_types_taxes_settings' );

		if ( empty( $exist ) ) {
			return false;
		}

		$types = [ 'cptui_post_import' => 'others_cpt_ui_posts', 'cptui_tax_import' => 'others_cpt_ui_taxonomies' ];
		foreach ( $types as $type => $value ) {
			$postdata                                    = [];
			$postdata[ $type ]                           = json_decode( $this->get_file_content( $value, 'txt' ), true );
			$postdata['delete']                          = 'others_cpt_ui_posts' === $value ? 'type_true' : 'tax_true';
			$_POST['cptui_typetaximport_nonce_field']    = wp_create_nonce( 'cptui_typetaximport_nonce_action' );
			$_REQUEST['cptui_typetaximport_nonce_field'] = wp_create_nonce( 'cptui_typetaximport_nonce_action' );

			if ( ! function_exists( 'cptui_import_types_taxes_settings' ) ) {
				continue;
			}
			$result = cptui_import_types_taxes_settings( $postdata );
		}

	}

	private function func_exists( $functions ) {
		$functions = ! is_array( $functions ) ? [ $functions ] : $functions;
		$exist     = true;

		foreach ( $functions as $function ) {
			if ( ! function_exists( $function ) || ! is_callable( $function ) ) {
				$exist = false;
				break;
			}
		}

		return $exist;
	}

	protected function import_customizer() {
		wp_cache_delete( 'et_divi', 'options' );
		wp_cache_delete( 'alloptions', 'options' );

		$layout                    = $this->get_file_content( 'divi_theme_customizer' );
		$this->portability_manager = new Portability( 'et_divi_mods' );
		$result                    = $this->handle_customizer_layout_import( $layout );
		if ( $result ) {
			$this->response['success'] = true;
			$this->response['message'] = esc_html__( 'Import customizer successfully', 'divi_flash' );
		}
		wp_send_json_success( $this->response );
	}

	protected function trim( $var ) {
		if ( is_array( $var ) ) {
			return array_map( [ $this, 'trim' ], $var );
		} else {
			return is_scalar( $var ) ? trim( $var ) : $var;
		}
	}

	protected function unzip_file( $file ) {
		global $wp_filesystem;

		WP_Filesystem();

		$base_name = basename( $file, '.zip' );
		$path      = Layout::$temp_dir . $base_name;
		$result    = unzip_file( $file, Layout::$temp_dir );
		if ( is_wp_error( $result ) ) {
			echo json_encode( $result );

			return $result;
		}
		if ( $wp_filesystem->is_dir( $path ) ) {
			$wp_filesystem->delete( $path, true );
		}
		unzip_file( $file, Layout::$temp_dir );

		wp_delete_file( $file );

		return $path;
	}

	protected function delete_layout_folder() {
		global $wp_filesystem;

		WP_Filesystem();

		$wp_filesystem->delete( Layout::$temp_dir . $this->layout_folder, true, 'd' );
	}

	protected function handle_menu() {
		$taxonomy  = \DiviFlash_Page_Category::TAXONOMY;
		$term_name = $this->layout->page_categories;

		$term    = get_term_by( 'name', $term_name, $taxonomy );
		$term_id = $term->term_id;

		$pages = get_posts( [
			'post_type' => 'page',
			'tax_query' => [
				[
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => $term_id,
				],
			],
		] );

	}

    protected function import_df_popup() {
        $import_data = $this->get_file_content( 'dfpopup' );
        if ( empty( $import_data ) ) {
            return;
        }
        foreach ( $import_data as $row ) {
            if ( ! isset( $row['Title'] ) || ! isset( $row['Content'] ) || ! isset( $row['post_status'] ) ) {
                continue;
            }

            $post_data = [
                'post_type'    => 'difl_popup',
                'post_title'   => $row['Title'],
                'post_content' => $row['Content'],
                'post_status'  => $row['post_status'],
            ];

            $post_id = wp_insert_post( $post_data );

            // Handle custom meta fields
            if ( $post_id ) {
                $temp_data = json_decode( $row['_df_popup_item_settings'], true );
                if ( ! isset( $temp_data['df_popup_scroll_element_viewport'] ) ) {
                    $temp_data['df_popup_scroll_element_viewport'] = 'on_bottom';
                }
                update_post_meta( $post_id, '_df_popup_item_settings', wp_json_encode( $temp_data ) );
                update_post_meta( $post_id, '_df_popup_item_trigger_type', $row['_df_popup_item_trigger_type'] );
                update_post_meta( $post_id, '_df_popup_item_status', $row['_df_popup_item_status'] );
                update_post_meta( $post_id, '_et_pb_use_builder', $row['_et_pb_use_builder'] );
            }
        }

        // Clear static file generation as it might overlap imported design
        if ( class_exists( 'ET_Core_PageResource' ) ) {
            $post_id = 'all';
            $owner   = 'all';
            \ET_Core_PageResource::remove_static_resources( $post_id, $owner );
        }
    }
}
