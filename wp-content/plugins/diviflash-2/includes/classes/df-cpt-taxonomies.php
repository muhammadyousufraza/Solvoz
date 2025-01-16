<?php

trait Df_Cpt_Taxonomy_Support {
    public $df_post_types = ['select'    => 'Select post type'];
    public $df_taxonomies;
    public $tax_settings = [];
    public $tax_list = [];
    public $df_multi_filter_tax_field_type = [];
    public $tax_list_for_mutiple = [];
    public $term_settings = [];
    public $tab_slug;
    public $toggle_slug;
    public $selected_post_type = '';
    public $selected_taxonomy = '';
    public $selected_taxonomy_list = '';
    public $selected_terms = '';
    public $multi_filter_terms = [];
    public $tax_show_if = [];
    public $terms_show_if = [];
    public $titles = [];
    /**
     * Initialise the class
     * 
     */
    public function init_cpt_tax(
        $tab_slug = 'general', 
        $toggle_slug = 'settings',
        $tax_show_if = [],
        $terms_show_if = [],
        $titles = ['terms' => 'Include Terms']
    ) {
        $this->tab_slug = $tab_slug;
        $this->toggle_slug = $toggle_slug;
        $this->tax_show_if = $tax_show_if;
        $this->terms_show_if = $terms_show_if;
        $this->titles = $titles;

        $this->df_post_types = array_merge($this->df_post_types, $this->df_get_post_types(false, false));
        $this->df_taxonomies = $this->df_tax_for_cpts();
        $this->tax_settings = $this->df_get_tax_settings();
        $this->tax_list = $this->df_get_tax_list();

    }

    /**
     * Genarate taxonomy settings for 
     * each taxonomy
     * 
     * @return array
     */
    public function df_get_tax_settings() {
        $tax_settings = array();
        foreach($this->df_taxonomies as $cpt_slug => $tax_array) {
            $tax_settings['tax_for_' . $cpt_slug ] = $this->df_tax_settings($tax_array, $cpt_slug);
        }
        return $tax_settings;
    }

    public function df_get_tax_list() {
        $tax_settings_array = [];
        foreach( $this->df_taxonomies as $cpt_slug => $tax_array) {
            $tax_settings_array['tax_list_for_' . $cpt_slug ] = $this->df_tax_list($tax_array, $cpt_slug);
	        unset($tax_array['select_tax']);
	        foreach ($tax_array as $key => $value){
		        $this->df_multi_filter_tax_field_type['tax_filter_field_type_'.$cpt_slug.'_'.$key] = $this->df_tax_list_field_type_for_filter($cpt_slug,$value);
	        }
        }
        return $tax_settings_array;
    }

    /**
     * Generate taxonomy array for 
     * a post type
     * 
     * @param string $cpt
     * @param array $tax_array
     * 
     * @return array
     */
    public function df_tax_settings($tax_array, $tax_slug) {
      
        $df_tax_settings = array(
            'label'             => esc_html__('Select Taxonomy', 'divi_flash'),
            'type'              => 'select',
            'options'           => $tax_array,
            'default'           => 'select_tax',
            'tab_slug'          => $this->tab_slug,
            'toggle_slug'       => $this->toggle_slug,
            'show_if_not'       => array(
                'use_current_loop' => 'on',
                'post_type' => 'select',
                 'post_display' => 'multiple_filter'
            )
        );
        $show_if = array(
            'post_type'  => $tax_slug
        );
        $show_if = array_merge($show_if, $this->tax_show_if);
        $df_tax_settings['show_if'] = $show_if;
        
        return $df_tax_settings;
    }

    public function df_tax_list($tax_array, $tax_slug) {
        array_shift($tax_array);
        $df_tax_settings = array(
            'label'             => esc_html__('Select Taxonomy According post type', 'divi_flash'),
            'type'              => 'multiple_checkboxes',
             'options'           => $tax_array,
            'tab_slug'          => $this->tab_slug,
            'toggle_slug'       => $this->toggle_slug,
            'show_if_not'       => array(
                'use_current_loop' => 'on',
                'post_type' => 'select',
            )
        );
        $show_if = array(
            'post_type'  => $tax_slug,
            'post_display' => 'multiple_filter'
        );
        $show_if = array_merge($show_if, $this->tax_show_if);
        $df_tax_settings['show_if'] = $show_if;
        
        return $df_tax_settings;
    }

	public function df_tax_list_field_type_for_filter($tax_slug, $tax_name) {
		$df_tax_field_type = array(
			'label'             => esc_html__($tax_name.' Field Type', 'divi_flash'),
			'type'             => 'select',
			'option_category'  => 'configuration',
			'options'           => array(
				'checkbox' => esc_html__('Checkbox', 'divi_flash'),
				'select' => esc_html__('Dropdown', 'divi_flash'),
			),
			'default'           => 'select',
			'tab_slug'          => 'general',
			'toggle_slug'       => 'multi_filter_field_type',
			'show_if_not'       => array(
				'use_current_loop' => 'on',
				'post_type' => 'select',
			)
		);
		$show_if = array(
			'post_type'  => $tax_slug,
			'post_display' => 'multiple_filter'
		);
		$show_if = array_merge($show_if, $this->tax_show_if);
		$df_tax_field_type['show_if'] = $show_if;

		return $df_tax_field_type;
	}
    

    /**
     * Get taxonomies for post types
     * 
     * @return array
     */
    public function df_tax_for_cpts() {
        $post_types = $this->df_post_types;
        $tax_arrays = array();
        foreach( $post_types as $name => $label ) {
            $tax_arrays[$name] = $this->df_get_taxonomies($name);
        }
        return $tax_arrays;
    }

    /**
     * Get Taxonomiy list
     * 
     * @param string $post_type
     * @return array
     */
    public function df_get_taxonomies($post_type) {
        $taxonomies = get_object_taxonomies( $post_type,'objects' );
        $tax_array = array();
        if(!empty($taxonomies)) {
            $tax_array['select_tax'] = 'Select Taxonomy';
            foreach ( $taxonomies as $key => $texonomy ) {
                $tax_array[$texonomy->name] = $texonomy->label;
                $this->df_get_terms($texonomy->name, $post_type);
            }
        } else {
            $tax_array['select_tax'] = 'No Taxonomy Found';
        }

        return $tax_array;
    }

    /**
     * Generate term settings for each taxonomies
     * 
     * @param String $texonomy
     * @param String $post_type
     * @return null
     */
    public function df_get_terms($texonomy, $post_type) {
        $this->term_settings[$post_type . '_terms_'. $texonomy] = $this->df_term_settings($texonomy, $post_type);
    }

    /**
     * Term settings
     * 
     * @param String $term_slug
     * @param String $post_type
     * @return array
     */
    public function df_term_settings($term_slug, $post_type) {
        $df_term_settings =  array(
            'label'            => esc_html__( $this->titles['terms'], 'divi_flash' ),
            'type'             => 'categories',
            'meta_categories'  => array(
                'current' => esc_html__( 'Current Terms', 'et_builder' ),
            ),
            'renderer_options' => array(
                'use_terms'    => true,
                'term_name'    => $term_slug,
            ),
            'taxonomy_name'    => $term_slug,
            'toggle_slug'      => 'settings',
            'show_if'         => array(
                
            ),
            'show_if_not'       => array(
                'use_current_loop' => 'on',
                 'post_display' => 'multiple_filter'
            )
        );

        $show_if = array(
            'post_type'             => $post_type,
            'tax_for_'.$post_type   => $term_slug
        );

        $show_if = array_merge($show_if, $this->tax_show_if);
        $df_term_settings['show_if'] = $show_if;

        return $df_term_settings;
    }

    /**
    * Get the list of registered Post Types options.
    *
    * @param boolean|callable $usort Comparision callback.
    * @param boolean          $require_editor Optional. Whether to retrieve only post type that has editor support.
    *
    * @return array
    */
    function df_get_post_types( $usort = false, $require_editor = true ) {
        $require_editor_key = $require_editor ? '1' : '0';
        $key                = "df_get_registered_post_type_options:{$require_editor_key}";
    
        if ( ET_Core_Cache::has( $key ) ) {
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
        $blocklist      = array_merge(
            $blocklist,
            array(
                'et_pb_layout',
                'layout',
                // 'post',
                'attachment',
                'page'
            )
        );
        $blocklist      = apply_filters( 'et_builder_post_type_options_blocklist', $blocklist );
        $raw_post_types = get_post_types(
            ['show_ui' => true],
            'objects'
        );
        $post_types     = [];
    
        foreach ( $raw_post_types as $post_type ) {
            $is_allowlisted  = in_array( $post_type->name, $allowlist, true );
            $is_blocklisted  = in_array( $post_type->name, $blocklist, true );
            $supports_editor = $require_editor ? post_type_supports( $post_type->name, 'editor' ) : true;
            $is_public       = et_builder_is_post_type_public( $post_type->name );
    
            if ( ! $is_allowlisted && ( $is_blocklisted || ! $supports_editor || ! $is_public ) ) {
                continue;
            }
    
            $post_types[] = $post_type;
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
    
        if(empty($post_type_options)) {
            $post_type_options = array(
                'not_found' => 'No Custom Post Type Found'
            );
        }
    
        return $post_type_options;
    }
    /**
     * Get taxonomy values by selected post type
     * and selected taxonomy
     * 
     * @return void
     */
    public function get_taxonomy_values(){
        $this->selected_post_type = $this->props['post_type'];
        $this->selected_taxonomy = isset($this->props['tax_for_'.$this->selected_post_type]) ? $this->props['tax_for_'.$this->selected_post_type]: '';
        $this->selected_taxonomy_list = isset($this->props['tax_list_for_'.$this->selected_post_type]) ? $this->props['tax_list_for_'.$this->selected_post_type]: '';
        $this->selected_terms = isset($this->props[$this->selected_post_type . '_terms_'.$this->selected_taxonomy]) ? $this->props[$this->selected_post_type . '_terms_'.$this->selected_taxonomy] : '';
        $this->multi_filter_terms = $this->get_multi_filter_terms($this->selected_taxonomy_list);
    }

    public function get_multi_filter_terms($selected_taxonomy_list){
        $main_value = array();
        $selected_multi = explode("|",$selected_taxonomy_list);
		if(!is_array($this->df_taxonomies[$this->selected_post_type])) return $main_value;
        $list_multi_key = array_keys($this->df_taxonomies[$this->selected_post_type]);
        array_shift($list_multi_key);
	    $iMax = count( $selected_multi );
        for($i =0; $i < $iMax; $i++){
            if($selected_multi[$i] === 'on'){
                $main_value[] = $list_multi_key[ $i ];
            }
        }
        return $main_value;
    }
}