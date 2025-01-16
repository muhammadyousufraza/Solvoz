<?php
class DF_Popup_Extension_Init
{

    public static $popup_settings_key = '_df_popup_item_settings';

    public function __construct()
    {
        // load Popup dashboard styles and scripts
        add_action('admin_enqueue_scripts', array($this, 'load_styles_scripts'));
        $popup_enable = get_option('df_general_popup_enable') === '1' ? 'on' : 'off'; // change key after dashboard code update
        if ($popup_enable === 'on') {
            add_action('init', array($this, 'create_popup_post_type'));
            add_action('admin_menu', array($this, 'df_popup_import_export_menu'));
            add_action('admin_init',  array($this, 'df_handle_import_request'));
            add_action('admin_init',  array($this,'df_handle_export_request'));
            add_filter('template_include', array($this, 'df_popup_custom_template'));
            // remove view from post list
            add_filter( 'post_row_actions', array($this, 'df_popup_remove_view_option'), 10, 2 );
            add_filter('enter_title_here', array($this, 'df_change_popup_title_text'));
            add_filter('use_block_editor_for_post_type', array($this, 'disable_gutenberg_for_popup_post_type'), 10, 2);
            add_filter('et_builder_post_types', array($this, 'enable_divi_builder_for_popup_post_type'));
            /* Add custom column in post type */
            add_filter('manage_edit-difl_popup_columns',   array($this, 'df_edit_difl_popup_columns'));

            add_action('manage_difl_popup_posts_custom_column', array($this, 'df_manage_difl_popup_columns'), 10, 2);

            // Custom checkbox on quickedit
            add_action('quick_edit_custom_box', array($this, 'difl_popup_custom_active_checkbox'), 11, 2);
            add_action('save_post_difl_popup', array($this, 'difl_popup_update_custom_active_checkbox'));
            add_action('admin_print_footer_scripts-edit.php', array($this, 'difl_popup_maker_custom_checkbox_js'));

            add_action('rest_api_init', array($this, 'df_register_popup_ex_route'));

            add_action('admin_footer', array($this, 'render_container_for_dashboard'));

        }
    }

    /**
     * Render container for dashboard
     *
     * @return void
     */
    public function render_container_for_dashboard()
    {
        if (!$this->check_current_screen()) return;
        echo '<div id="difl_popup_settings_container"></div>';
    }
    /**
     * Check current screen
     * If the screen is not Popup then return false
     *
     * @return boolean
     */
    public function check_current_screen()
    {
        $screen = get_current_screen();
        return $screen->id === 'difl_popup' ? true : false;
    }

    /**
     * Load necessary styles & scripts
     * for DiviFlash Popup
     *
     * @return void
     */
    public function load_styles_scripts()
    {
        if (!$this->check_current_screen()) return;
        $dir = __DIR__;
        $df_popup_asset_path = "$dir/df-popup-panel/index.asset.php";

        // popup script
        $df_popup_js     = 'df-popup-panel/index.js';
        $df_popup_script_asset = require($df_popup_asset_path);
        wp_enqueue_script(
            'diviflash-popup-admin-editor',
            plugins_url($df_popup_js, __FILE__),
            $df_popup_script_asset['dependencies'],
            $df_popup_script_asset['version'],
            true
        );
        wp_set_script_translations('diviflash-popup-admin-editor', 'divi_flash');

        // popup css
        $df_popup_css = 'df-popup-panel/index.css';
        wp_enqueue_style(
            'diviflash-popup-admin',
            plugins_url($df_popup_css, __FILE__),
            ['wp-components'],
            filemtime("$dir/$df_popup_css")
        );
    }


    public function create_popup_post_type()
    {
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
	        if ( in_array( 'administrator', $current_user->roles ) || in_array( 'editor', $current_user->roles ) || in_array( 'author', $current_user->roles ) || is_super_admin( get_current_user_id() ) ) {
                $labels = array(
                    'name'          => _x('Popup', 'divi_flash'),
                    'singular_name' => _x('Popup', 'divi_flash'),
                    'all_items'     => _x('All Popups', 'divi_flash'),
                    'add_new'       => _x('Add New', 'divi_flash'),
                    'add_new_item'  => _x('Add New', 'divi_flash'),
                    'edit_item'     => _x('Edit Popup', 'divi_flash'),
                    'new_item'      => _x('New Popup', 'divi_flash'),
                    'view_item'     => _x('View Popup', 'divi_flash'),
                    'search_items'  => _x('Search Popup', 'divi_flash'),
                    'not_found'     => _x('No Popup found', 'divi_flash'),
                    'not_found_in_trash' => _x('No Popups found in Trash', 'divi_flash'),
                    'parent_item_colon' => _x('Parent Popup:', 'divi_flash'),
                    'menu_name'     => _x('DF Popups', 'divi_flash'),
                );

                register_post_type(
                    'difl_popup',
                    array(
                        'labels' =>  $labels,
                        'public'             => false,
                        'publicly_queryable' => true,
                        'menu_icon' => plugin_dir_url(__FILE__ ).'img/popup.svg',
                        'show_in_menu'       => true,
                        'show_ui'            => true,
                        'supports' => array('title' => array('placeholder' => 'Add Title'), 'editor')
                    )
                );

                flush_rewrite_rules();
            }
        }
    }

    // Export Import Submenu
    public function df_popup_import_export_menu(){
        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
	        if ( in_array( 'administrator', $current_user->roles ) || in_array( 'editor', $current_user->roles ) || in_array( 'author', $current_user->roles ) || is_super_admin( get_current_user_id() ) ) {
                add_submenu_page(
                    'edit.php?post_type=difl_popup',
                    __( 'DF Popup Import Export', 'divi-flash' ),
                    __( 'Import & Export', 'divi-flash' ),
                    'edit_posts',
                    'popup_import_export',
                    [ $this, 'df_popup_import_export_page' ]
                );
            }
        }
    }

    // Handle import request
    public function df_handle_import_request() {
	    if ( isset( $_POST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ), 'df_popup_import' ) ) {
		    return;
	    }
        if (isset($_POST['import'])) {
            $error = isset( $_FILES['import_file']['error'] ) && ! empty( $_FILES['import_file']['error'] ) ? sanitize_text_field( $_FILES['import_file']['error'] ) : 0;
            if (isset($_FILES['import_file']) && $error  === UPLOAD_ERR_OK) {
	            $file = isset( $_FILES['import_file']['tmp_name'] ) ? sanitize_text_field( $_FILES['import_file']['tmp_name'] ) : false;
	            $name = isset( $_FILES['import_file']['name'] ) ? sanitize_text_field( $_FILES['import_file']['name'] ) : false;
	            if ( empty( $file ) ) {
		            return;
	            }
                // Check if the uploaded file is a valid JSON file
                if (pathinfo($name, PATHINFO_EXTENSION) !== 'json') {
                    add_action('admin_notices', function() {
                        echo '<div class="notice notice-error is-dismissible">
                                <p>Invalid file type. Please upload a JSON file.</p>
                            </div>';
                    });
                    return;
                }

                // Read the JSON file content
                $json_content = file_get_contents($file);

                // Decode the JSON content into an associative array
                $import_data = json_decode($json_content, true);

                // Check if the JSON decoding was successful
                if ($import_data === null) {
                    add_action('admin_notices', function() {
                        echo '<div class="notice notice-error is-dismissible">
                                <p>Error decoding JSON data. Please ensure your JSON file is valid.</p>
                            </div>';
                    });
                    return;
                }

                $imported_items_links = array();

                foreach ($import_data as $row) {
                    // Validate the required fields in the JSON row before processing
                    if (!isset($row['Title']) || !isset($row['Content']) || !isset($row['post_status'])) {
                        add_action('admin_notices', function() {
                            echo '<div class="notice notice-error is-dismissible">
                                    <p>Invalid data format in the JSON file. Each row must contain "Title", "Content", and "post_status" fields.</p>
                                </div>';
                        });
                        return;
                    }

                    $post_data = array(
                        'post_type' => 'difl_popup', // Replace with your custom post type slug
                        'post_title' => $row['Title'],
                        'post_content' => $row['Content'],
                        'post_status' => 'draft'
                        // Add more fields as needed based on the JSON structure
                    );

                    // Insert or update the post
                    $post_id = wp_insert_post($post_data);

                    // Handle custom meta fields
                    if ($post_id) {
	                    $temp_data = json_decode($row['_df_popup_item_settings'], true);
	                    if(!isset($temp_data['df_popup_scroll_element_viewport'])){
		                    $temp_data['df_popup_scroll_element_viewport'] = 'on_bottom';
	                    }
                        update_post_meta($post_id, '_df_popup_item_settings', wp_json_encode($temp_data));
                        update_post_meta($post_id, '_df_popup_item_trigger_type', $row['_df_popup_item_trigger_type']);
                        update_post_meta($post_id, '_df_popup_item_status', $row['_df_popup_item_status']);
                        update_post_meta($post_id, '_et_pb_use_builder', $row['_et_pb_use_builder']);
                         // Store the link of the imported item
                         $edit_link = get_edit_post_link($post_id);
                         $imported_items_data[] = array(
                             'title' => $row['Title'],
                             'link' => $edit_link
                         );
                    }
                }

	            // Clear static file generation as it might overlap imported design
	            if ( class_exists( 'ET_Core_PageResource' ) ) {
		            $post_id = 'all';
		            $owner   = 'all';
		            \ET_Core_PageResource::remove_static_resources( $post_id, $owner );
	            }

               // Display success notice with item titles and links
                add_action('admin_notices', function() use ($imported_items_data) {
                    $count = count($imported_items_data);

                    if ($count > 0) {
                        echo '<div class="notice notice-success is-dismissible">';
                        echo '<p>Import completed successfully. ' . esc_html( $count ) . ' item(s) imported: ';
                        foreach ($imported_items_data as $item_data) {
                            echo '<a href="' . esc_url($item_data['link']) . '">' . esc_html($item_data['title']) . '</a>, ';
                        }
                        echo '</p>';
                        echo '</div>';
                    } else {
                        echo '<div class="notice notice-success is-dismissible">
                                <p>Import completed successfully.</p>
                            </div>';
                    }
                });

            } else {
	            add_action( 'admin_notices', function () {
		            echo '<div class="notice notice-error is-dismissible">
                            <p>File upload error: ' .
		                 esc_html( $_FILES['import_file']['error'] ) . // phpcs:ignore -- not needed as it doesnt process anything
		                 '</p>
                        </div>';
	            } );
            }
        }
    }


    // Handle export request
    public function df_handle_export_request() {
	    if ( isset( $_POST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['_wpnonce'] ), 'df_popup_export' ) ) {
		    return;
	    }
        if (isset($_POST['export'])) {
            if (!isset($_POST['post_ids']) || empty($_POST['post_ids'])) {
                return; // No posts selected, do nothing
            }

            // Fetch and export selected posts
            $selected_post_ids = array_map('intval', $_POST['post_ids'] );

            // Prepare the JSON data array
            $json_data = array();

            // Loop through each selected post and append data to the JSON data array
            foreach ($selected_post_ids as $post_id) {
                $post = get_post($post_id);
                if ($post) {
                    setup_postdata($post);

                    // Get post meta values
                    $meta_values = array(
                        'ID' => $post->ID,
                        'Title' => $post->post_title,
                        'Content' => $post->post_content,
                        'post_status' => $post->post_status,
                        '_df_popup_item_settings' => $post->_df_popup_item_settings,
                        '_df_popup_item_trigger_type' => $post->_df_popup_item_trigger_type,
                        '_df_popup_item_status' => $post->_df_popup_item_status,
                        '_et_pb_use_builder' => $post->_et_pb_use_builder
                    );

                    foreach (get_post_custom($post->ID) as $meta_key => $meta_value) {
                        // Exclude private keys (prefixed with "_")
                        if (substr($meta_key, 0, 1) !== '_') {
                            $meta_values[$meta_key] = $meta_value;
                        }
                    }

                    // Append post data and meta values to the JSON data array
                    $json_data[] = $meta_values;
                }
            }

            // Set appropriate headers for file download
            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="df-popup.json"');

            // Output the JSON data to the browser
            echo wp_json_encode($json_data);

            // Stop further execution
            exit;
        }
    }

    // Render export page
    public function df_popup_import_export_page() {
        // Fetch all posts of your custom post type
        $args = array(
        'post_type' => 'difl_popup', // Replace with your custom post type
        'posts_per_page' => -1,
        'post_status'    => array('publish', 'draft', 'pending', 'private'),
        );
        $posts = get_posts($args);

        ?>
        <div class="df_popup_dashboard_wrapper">
            <div class="df_popup_export_import_title"><h2>Popup Import & Export</h2></div>

            <div class="df_popup_export_import">

                <div class="wrap">
                    <h3> Export </h3>
                    <form method="post" action="" id="export_form">
                        <table class="wp-list-table widefat fixed striped">

                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all-header"></th>
                                <th> Title </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post) {
                                $get_title = $post->post_title !=='' ? $post->post_title : '(no title)';
                                $postTitle = $post->post_status === 'publish' ?  $get_title :  $get_title . ' — <span class="post_status_title">' . ucwords($post->post_status) . '</span>';
                                $editPostLink = get_edit_post_link($post->ID);
                                ?>
                            <tr>
                                <td><input type="checkbox" name="post_ids[]" value="<?php echo esc_attr( $post->ID ); ?>"></td>
                                <td><a href="<?php echo esc_url( $editPostLink ); ?>"><?php echo et_core_esc_previously( $postTitle ); ?></a></td>
	                            <?php wp_nonce_field( 'df_popup_export' ) ?>

                            </tr>
                            <?php } ?>
                        </tbody>
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all-footer"></th>
                                <th> Title </th>
                            </tr>
                        </thead>
                        </table>
                        <p><input type="submit" class="button button-primary" name="export" value="Export" id="export_button" disabled></p>
                    </form>
                </div>
                <div class="wrap">
                    <h3> Import </h3>
                    <form method="post" action="" enctype="multipart/form-data">
                        <input type="file" name="import_file" required accept=".json">
	                    <?php wp_nonce_field( 'df_popup_import' ) ?>
                        <br><br>
                        <input type="submit" class="button button-primary" name="import" value="Import" id="import_button" disabled>
                    </form>
                </div>
            </div>
        </div>

    <?php
    }

    // define custom template
    function df_popup_custom_template($template)
    {
        if (is_singular('difl_popup')) {
            $template = get_template_directory() . '/page-template-blank.php';
            if (file_exists($template)) {
                return $template;
            }
        }
        return $template;
    }

    // remove view option
    public function df_popup_remove_view_option($actions, $post)
    {
        if ($post->post_type == "difl_popup") {
            unset($actions['view']);
        }
        return $actions;
    }

    public function disable_gutenberg_for_popup_post_type($use_block_editor, $post_type)
    {
        if ('difl_popup' === $post_type) {
            return false;
        }
        return $use_block_editor;
    }

    public function enable_divi_builder_for_popup_post_type($post_types)
    {
        $post_types[] = 'difl_popup';
        return $post_types;
    }

    public function df_edit_difl_popup_columns($columns)
    {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title'),
            'unique_indentifier' => __('Popup Target ID'),
            'active_status' => __('Status'),
            'triggering_setting' => __('Triggering'),
            'author' => __('Author'),
            'date' => __('Date')
        );

        return $columns;
    }


    public function df_manage_difl_popup_columns($column, $post_id)
    {
        global $post;
        $pm_sub_setting_name_selected = get_post_meta(
            $post->ID,
            '_df_popup_item_settings',
            true
        );
        $post_settings = json_decode($pm_sub_setting_name_selected);
        switch ($column) {
            case 'preview_column':

                echo sprintf(
                    '<a href="#" target="_blank">
                        <span class="dashicons dashicons-visibility"></span>
                    </a>',
                    esc_url(wp_nonce_url(
                        sprintf(
                            '#',
                            get_site_url(),
                            esc_attr($post->ID)
                        ),
                        'difl_popup_nonce',
                        'difl_popup_nonce'
                    ))
                );
                break;
                /* If displaying the 'unique-indentifier' column. */
            case 'unique_indentifier':

                /* Get the post meta. */
                $post_slug = "#popup_$post->ID";
                echo ('<div class="df-popupid-wrapper">
                            <p class="df-popupid-copy">' . esc_html($post_slug) . '</p>
                            <p class="df-cpy-tooltip">Click to copy</p>
                        </div>'
                );
                break;
            case 'active_status':

                /* Get the post meta. */
                $difl_popup_active = get_post_meta($post->ID, '_df_popup_item_status', true);

                if ($difl_popup_active) {
                    echo '<span class="active">Active</span>';
                } else {
                    echo '<span class="inactive">Inactive</span>';
                }

                break;
            case 'triggering_setting':


                $pm_sub_setting_options = array(
                    'click'   => esc_html__('Click', 'divi_flash'),
                    'on_load'   => esc_html__('On Load', 'divi_flash'),
                    'on_scroll'   => esc_html__('On Scroll', 'divi_flash'),
                    'scroll_to_element'   => esc_html__('Scroll To Element', 'divi_flash'),
                    'on_exit'   => esc_html__('On Exit', 'divi_flash'),
                    'on_inactivity'   => esc_html__('On Inactivity', 'divi_flash'),
                );
                $df_popup_trigger_type = isset($post_settings->df_popup_trigger_type) ? $pm_sub_setting_options[$post_settings->df_popup_trigger_type] : $pm_sub_setting_options['on_load'];
                echo sprintf(
                    '<span class="%1$s">%2$s</span>',
                    esc_attr(isset($post_settings->df_popup_trigger_type) ? $post_settings->df_popup_trigger_type : 'on_load' ),
                    esc_html($df_popup_trigger_type)
                );
                break;

                /* Just break out of the switch statement for everything else. */
            default:
                break;
        }
    }

    // Custom Active checkbox on Quick Edit
    public function difl_popup_custom_active_checkbox($column_name, $post_type)
    {
        switch ($post_type) {
            case 'difl_popup':
                if ($column_name === 'active_status') :
                    ?>
                    <fieldset class="inline-edit-col-left" id="#edit-">
                        <div class="inline-edit-col">
                            <label class="alignleft">
                                <input type="checkbox" name="difl_popup-checkbox-active" class="difl_popup_custom_checkbox">
                                <span class="difl_popup_checkbox-title">Active</span>
                            </label>
                        </div>
                    </fieldset>
            <?php
                endif;
                break;
            default:
                break;
        }
    }

    // Save quick edit active checkbox
	public function difl_popup_update_custom_active_checkbox() {
		//phpcs:disable WordPress.Security.NonceVerification -- saving post data
		$req_action = isset( $_REQUEST['action'] ) && 'inline-save' === $_REQUEST['action'];
		$post_id    = isset( $_POST['post_ID'] ) ? sanitize_text_field( $_POST['post_ID'] ) : 0;

		//add blank template to difl for full page view
		if ( ! empty( $post_id ) ) {
			$meta_key = '_wp_page_template';
			$meta_val = 'page-template-blank.php';
			$cur_val  = get_post_meta( $post_id, $meta_key, true );
			if ( $meta_val !== $cur_val ) {
				update_post_meta( $post_id, $meta_key, $meta_val );
			}
		}

		if ( ! $req_action ) {
			return;
		}

        if ( isset( $_POST['difl_popup-checkbox-active'] ) ) {
			$popup_active = sanitize_text_field( $_POST['difl_popup-checkbox-active'] ) === "true" ? 1 : 0;
			update_post_meta( $post_id, '_df_popup_item_status', $popup_active );
		}

		if ( ! empty( $post_id ) ) {
			update_post_meta( $post_id, '_df_popup_item_status', 0 );
		}
		//phpcs:enable
	}

    // action on custom active checkbox
    public function difl_popup_maker_custom_checkbox_js()
    {
        $current_screen = get_current_screen();
        if ($current_screen->id != 'edit-difl_popup' || $current_screen->post_type !== 'difl_popup')
            return;
        ?>
        <script type="text/javascript">
            jQuery(function($) {
                var $difl_popup_inline_editor = inlineEditPost.edit;
                inlineEditPost.edit = function(id) {
                    $difl_popup_inline_editor.apply(this, arguments);

                    var $post_id = 0;
                    if (typeof(id) == 'object') {
                        $post_id = parseInt(this.getId(id));
                    }
                    if ($post_id != 0) {
                        var $edit_box = $('#edit-' + $post_id);
                        var $post_box = $('#post-' + $post_id);
                        var $status = $('.column-active_status span', $post_box).text();

                        if ($status === "Active") {
                            $('.difl_popup_custom_checkbox[type="checkbox"]', $edit_box).prop('checked', true);
                            $('.difl_popup_custom_checkbox[type="checkbox"]', $edit_box).val("true")
                        } else {
                            $('.difl_popup_custom_checkbox[type="checkbox"]', $edit_box).val("false")
                        }

                        $('.difl_popup_custom_checkbox[type="checkbox"]', $edit_box).change(
                            function() {
                                var self = $(this);
                                self.is(':checked') ? self.val("true") : self.val("false")
                            });
                    }
                }
            });
        </script>
<?php
    }

    // Meta boxes for Popup Maker //
    public function difl_add_popup_container_meta_box()
    {
        $screen = get_current_screen();
        if ($screen->post_type == 'difl_popup') {
            add_meta_box(
                'difl_popup_settings_meta_box',
                esc_html__('Diviflash Popup Settings', 'divi_flash'),
                function () {
                    return;
                },
                'difl_popup'
            );
        }
    }


    /**
     * Registering Rest API endpoints.
     *
     * - get-nav-menu
     * - get-nav-menu-items
     * - save-nav-menu-items
     *
     * @return void
     */
    public function df_register_popup_ex_route()
    {
        register_rest_route('df-popup-settings/v2', '/get-popup-item-data', array(
            'methods'  => WP_REST_Server::CREATABLE,
            'callback' => array($this, 'get_popup_item_data_callback'),
            'permission_callback' => function () {
                return current_user_can('edit_others_posts');
            }
        ));
        // Get All Pages

        register_rest_route('df-popup-settings/v2', '/get-popup-status', array(
            'methods'  => WP_REST_Server::CREATABLE,
            'callback' => array($this, 'getPopupStatus'),
            'permission_callback' => function () {
                return current_user_can('edit_others_posts');
            }
        ));

        register_rest_route('df-popup-settings/v2', '/save-popup-item-data', array(
            'methods'  => WP_REST_Server::CREATABLE,
            'callback' => array($this, 'save_popup_item_data_callback'),
            'permission_callback' => function () {
                return current_user_can('edit_others_posts');
            }
        ));

        // Get All Pages

        register_rest_route('df-popup-settings/v2', '/get-all-page-data', array(
            'methods'  => WP_REST_Server::READABLE,
            'callback' => array($this, 'getAllPages'),
            'permission_callback' => function () {
                return current_user_can('edit_others_posts');
            }
        ));

        // Get All Role

        register_rest_route('df-popup-settings/v2', '/get-all-role-data', array(
            'methods'  => WP_REST_Server::READABLE,
            'callback' => array($this, 'getRoles'),
            'permission_callback' => function () {
                return current_user_can('edit_others_posts');
            }
        ));

        // Get All texonomies

        register_rest_route('df-popup-settings/v2', '/get-all-texonomies', array(
            'methods'  => WP_REST_Server::READABLE,
            'callback' => array($this, 'getTexonomies'),
            'permission_callback' => function () {
                return current_user_can('edit_others_posts');
            }
        ));
    }

    public function getPopupStatus(WP_REST_Request $request){
       $popup_id = sanitize_key($request['id']);
        if($popup_id){
            $popup_status = get_post_meta($popup_id, '_df_popup_item_status', true);
            return $popup_status === '1' ? true : false;
        }

    }
    public function getRoles(WP_REST_Request $request)
    {
        $role_list = wp_roles();
        // Return the roles in a successful response
        $response = new \WP_REST_Response($role_list->role_names, 200);

        return $response;
    }


    public function getTexonomies(WP_REST_Request $request)
    {
        $registered_taxonomies = array();

        $post_types = get_post_types(array('public' => true, '_builtin' => false));
        array_push($post_types, 'post');
        foreach ($post_types as $post_type) {
            $taxonomies = get_object_taxonomies($post_type);

            foreach ($taxonomies as $taxonomy) {
                array_push($registered_taxonomies, $taxonomy);
            }
        }

        // Return the roles in a successful response
        $response = new \WP_REST_Response($registered_taxonomies, 200);

        return $response;
    }

    public function getAllPages(WP_REST_REQUEST $request)
    {
        $post_type = 'page'; // replace this with your actual custom post type
        $args = array(
            'post_type' => $post_type,
            'posts_per_page' => -1, // retrieve all posts of the specified post type
        );

        $query = new WP_Query($args);

        $results = array(); // initialize an empty array to hold the results

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                // Build an array with the post's title and ID
                $post_data = array(
                    'title' => get_the_title(),
                    'id' => get_the_ID(),
                );

                // Add the post data to the results array
                $results[] = $post_data;
            }
        }

        wp_reset_postdata();

        // Return the results array
        $response = new \WP_REST_Response($results, 200);
        return $response;
    }

    /**
     * Request API callback.
     * Process the request and save menu items data.
     *
     * @return string | response
     */
    public function save_popup_item_data_callback(WP_REST_Request $request)
    {

        if (isset($request['id'])) {
            $popup_id = sanitize_key($request['id']);

            if (isset($request['settings'])) {
                $settings = $request['settings'];
                if(!isset($settings['df_popup_scroll_element_selector'])){
                    $settings['df_popup_scroll_element_selector'] = '';
                }
                update_post_meta($popup_id, DF_Popup_Extension_Init::$popup_settings_key, wp_json_encode($settings));
                update_post_meta($popup_id, '_df_popup_item_trigger_type', $settings['df_popup_trigger_type']);
                $popup_status = isset($settings['df_popup_enable']) && $settings['df_popup_enable'] === true ? 1 : 0;
                update_post_meta($popup_id, '_df_popup_item_status', $popup_status);

                $postData = ['ID' => $popup_id, 'post_status' => 'publish'];
                wp_update_post($postData);

                return 'Successfully Saved';
            } else {
                return 'Missing settings data';
            }
        } else {
            return 'Missing ID parameter';
        }
    }
    /**
     * Get the parent has mega menu
     * enabled/disabled
     *
     * @param string | $id
     * @param string | $key
     * @return string
     */
    public static function get_parent_item_data($id, $key)
    {
        $parent         = get_post_meta($id, DF_Menu_Admin_Init::$menu_item_settings_key, true);
        $parent_object  = json_decode($parent, true);

        return isset($parent_object[$key]) ? $parent_object[$key] : null;
    }
    /**
     * Menu item data array
     *
     * @param object $request
     * @return string
     */
    public function get_popup_item_data_callback(WP_REST_Request $request)
    {
        $popup_id = sanitize_key($request['id']);

        if ($popup_id) {
            $popup_settings = get_post_meta($popup_id, '_df_popup_item_settings', true);
            if ($popup_settings) {
                $settings   = json_decode($popup_settings, true);
                if(!isset($settings['df_popup_scroll_element_viewport'])){
                    $settings['df_popup_scroll_element_viewport'] = 'on_bottom';
                }
                return $settings;
            } else {
                return "default";
            }
        }
        return "No Popup found";
    }

    // for POPUP

    public function df_change_popup_title_text($title)
    {
        $screen = get_current_screen();

        if ('difl_popup' == $screen->post_type) {
            $title = 'Add Title';
        }

        return $title;
    }

}
new DF_Popup_Extension_Init;
