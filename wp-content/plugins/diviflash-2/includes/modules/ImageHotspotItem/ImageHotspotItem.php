<?php

class DIFL_ImageHotspotItem extends ET_Builder_Module {
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_imagehotspotitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var          = 'admin_label';
	public $child_title_fallback_var = 'admin_label';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => ''
    );

    public function init() {
        $this->name = esc_html__( 'Image Hotspot Item', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'spot' => esc_html__('Spot Content', 'divi_flash'),
                    'spot_settings' => esc_html__('Spot Settings', 'divi_flash'),
                    'tooltip_content' => esc_html__('Tooltip Content', 'divi_flash'),
                    'tooltip_settings' => esc_html__('Tooltip Settings', 'divi_flash'),
                    'spot_background' => esc_html__('Spot Background', 'divi_flash')
                )
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'spot_item_design' => esc_html__('Spot Text', 'divi_flash'),
                    'spot_icon_image' => esc_html__('Spot Icon/Image', 'divi_flash'),
                    'tooltip_content' => esc_html__('Tooltip', 'divi_flash'),
                    'custom_spacing'        => array(
                        'title'             => esc_html__('Custom Spacing', 'divi_flash')
                    )
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['background'] = false;

        $advanced_fields['fonts'] = array(
            
            'spot_item_font'=> array(
                'toggle_slug'   => 'spot_item_design',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'css'      => array(
                    'main' => ".difl_imagehotspot .difl_imagehotspotitem%%order_class%% .difl_marker_wrapper",
                    'hover' => ".difl_imagehotspot .difl_imagehotspotitem%%order_class%%:hover .difl_marker_wrapper",
                    'important' => 'all'
                )
            )    
        );

        $advanced_fields['borders'] = array (
            
            'default'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '.difl_imagehotspot .difl_imagehotspotitem%%order_class%%',
                        'border_radii_hover' => '.difl_imagehotspot .difl_imagehotspotitem%%order_class%%:hover',
                        'border_styles' => '.difl_imagehotspot .difl_imagehotspotitem%%order_class%%',
                        'border_styles_hover' => '.difl_imagehotspot .difl_imagehotspotitem%%order_class%%:hover',
                        'important' => 'all'
                    )
                ),
                'label'    => esc_html__('Spot Item', 'divi_flash')
            ),
            'spot_image_border'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '.difl_imagehotspot %%order_class%% .difl_image_marker img , .difl_imagehotspot %%order_class%% .et-pb-icon.df-image-hotspot-icon',
                        'border_radii_hover' => '.difl_imagehotspot %%order_class%% .difl_image_marker img:hover , .difl_imagehotspot %%order_class%%:hover .et-pb-icon.df-image-hotspot-icon',
                        'border_styles' => '.difl_imagehotspot %%order_class%% .difl_image_marker img , .difl_imagehotspot %%order_class%% .et-pb-icon.df-image-hotspot-icon',
                        'border_styles_hover' => '.difl_imagehotspot %%order_class%%:hover .difl_image_marker img , .difl_imagehotspot %%order_class%%:hover .et-pb-icon.df-image-hotspot-icon',
                        'important' => 'all'
                        )
                ),
                'label'    => esc_html__('Spot Image', 'divi_flash'),
                'toggle_slug'   => 'spot_icon_image',
                'tab_slug'		=> 'advanced'
            ),
        );
        $advanced_fields['box_shadow'] = array (
          'default' => array(
                'css' => array(
                    'main' => ".difl_imagehotspot .difl_imagehotspotitem%%order_class%%",
                    'hover' => ".difl_imagehotspot .difl_imagehotspotitem%%order_class%%:hover"
                )
            ),

        );
        $advanced_fields['transform'] = array(
			'css' => array(
				'main'	=> ".difl_imagehotspotitem{$this->main_css_element}",
                'important' => 'all'
			)
        );
        $advanced_fields['text'] = false;
        $advanced_fields['filters'] = false;
        // $advanced_fields['transform'] = false;
        // $advanced_fields['link_options'] = false;
        $advanced_fields['margin_padding'] = false;
        $advanced_fields['max_width'] = false;
        return $advanced_fields;
    }

    public function get_fields() {

        $general = array (
            'admin_label' => array (
				'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'admin_label',
				'default_on_front'=> 'Image Hotspot Item'
			)
        );
    
        $content_settings = array(
            'spot_type'   => array (
                'label'             => esc_html__('Spot Type', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
					'icon'          => esc_html__( 'Icon', 'divi_flash' ),
					'text'          => esc_html__( 'Text', 'divi_flash' ),
                    'empty'         => esc_html__( 'Blank', 'divi_flash' )
					// 'both_icon_and_text'     => esc_html__( 'Both Icon & Text', 'divi_flash' )
                ),
                'default'           => 'icon',
                'toggle_slug'       => 'spot'
            ),
            'spot_text' => array (
                'label'                 => esc_html__( 'Spot Text', 'divi_flash' ),
                'description'       => esc_html__('Spot Text. We can use Html tag also', 'divi_flash'),
                'type'              => 'codemirror',
                'mode'              => 'html',
                'option_category'   => 'basic_option',
                'toggle_slug'       => 'spot',
                'dynamic_content'   => 'text',
                'show_if'           => array(
                    'spot_type'     => array('text', 'both_icon_and_text')
                )
            ),
            'use_image_as_icon'     => array(
                'label'             => esc_html__('Use Image as Icon', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
                    'off' => esc_html__('Off', 'divi_flash'),
                    'on'  => esc_html__('On', 'divi_flash')
                ),
                'default'           => 'off',
                'toggle_slug'       => 'spot',
                'show_if'           => array(
                    'spot_type'     => 'icon'
                )
            ),
            'image_as_icon' => array(
                'label'                 => esc_html__('Image', 'divi_flash'),
                'type'                  => 'upload',
                'option_category'       => 'basic_option',
                'upload_button_text'    => esc_attr__('Upload an image', 'divi_flash'),
                'choose_text'           => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'           => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'           => 'spot',
                'dynamic_content'       => 'image',
                'show_if'               => array(
                    'use_image_as_icon' => 'on',
                    'spot_type'         => array('icon', 'both_icon_and_text')
                )

            ),
            'image_alt_text' => array (
                'label'                 => esc_html__( 'Image Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'spot',
                'show_if'         => array(
                    'use_image_as_icon' => 'on',
                    'spot_type'     => array('icon', 'both_icon_and_text')
                )
            ),
            'image_as_icon_width' => array(
                'label'             => esc_html__('Image as Icon Width(%)', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'spot_icon_image',
                'tab_slug'          => 'advanced',
                'default_unit'      => 'px',
                'default'           => '32px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'responsive'        => true,
                'show_if'           => array(
                    'use_image_as_icon' => 'on',
                    'spot_type'     => array('icon', 'both_icon_and_text')
                )
            ),
            
            'font_icon'                 => array(
				'label'                 => esc_html__( 'Icon', 'divi_flash' ),
				'type'                  => 'select_icon',
				'option_category'       => 'basic_option',
				'class'                 => array( 'et-pb-font-icon' ),
                'toggle_slug'           => 'spot',
                'show_if'           => array(
                    'use_image_as_icon' => 'off',
                    'spot_type'     => array('icon', 'both_icon_and_text')
                )
            ),
            'icon_color'            => array (
				'label'             => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'divi_flash' ),
				'depends_show_if'   => 'on',
                'toggle_slug'       => 'spot_icon_image',
                'tab_slug'          => 'advanced',
                'hover'             => 'tabs',
                'show_if'           => array(
                    'use_image_as_icon' => 'off',
                    'spot_type'     => array('icon', 'both_icon_and_text')
                )
            ),
            'icon_size'             => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'option_category'   => 'font_option',
				'toggle_slug'       => 'spot_icon_image',
                'tab_slug'          => 'advanced',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1'
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
                'responsive'        => true,
                'show_if'           => array(
                    'use_image_as_icon' => 'off',
                    'spot_type'     => array('icon', 'both_icon_and_text')
                )
            )
           
        );

        $spot_spacing = $this->add_margin_padding(array(
            'title'         => 'Spot',
            'key'           => 'spot',
            'toggle_slug'   => 'margin_padding',
            'tab_slug'      => 'advanced',
            'option'        => 'padding'
        ));
        $spots_background =  $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'spot_background',
            'toggle_slug'           => 'spot_background',
            'tab_slug'              => 'general',
            'hover'				    => 'tabs'
        ));
        $spot = array(
            'left_position'  => array (
                'label'             => esc_html__( 'Left Position', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'spot_settings',
				'default'           => '50%',
                'default_value'     =>  '50',
                'default_unit'      => '%',
                'validate_unit'     => true,
                'allowed_units'     => array( 'px','%'),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '.1'
                ),
				'mobile_options'    => true
            ),
            'top_position'  => array (
                'label'             => esc_html__( 'Top Position', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'spot_settings',
				'default'           => '30%',
                'default_value'     =>  '50',
                'default_unit'      => '%',
                'validate_unit'    => true,
                'allowed_units'    => array( 'px','%'),
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '.1'
                ),
				'mobile_options'    => true
            ),
            'variable_width'  => array (
                'label'             => esc_html__('Variable Width', 'divi_flash'),
                'description'       => esc_html__('Spot Variable Width.', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' )
                ),
                'default'           => 'on',
                'toggle_slug'       => 'spot_settings'
            ),
            'spot_width'      => array (
                'label'             => esc_html__( 'Max Spot Width', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'spot_settings',
				'default'           => '50px',
                'default_unit'      => 'px',
                'validate_unit'    => true,
                'allowed_units'     => array ('px'),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '200',
					'step' => '1',
                ),
                'mobile_options'    => true,
                'show_if'           => array (
                    'variable_width' => 'on'
                )
            ),
            'spot_animation'  => array (
                'label'             => esc_html__('Spot Animation', 'divi_flash'),
                'description'       => esc_html__('Spot Animation.', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' )
                ),
                'default'           => 'off',
                'toggle_slug'       => 'spot_settings'
            ),
            'spot_animation_style'  => array (
                'label'             => esc_html__('Select Style', 'divi_flash'),
                'description'       => esc_html__(' style 1 and style 2 use background-color , style 3 use border-color, style 4 and style 5 use color. To use style 7 and Style 8 you should spot type Blank', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
					'style_1'          => esc_html__( 'Style 1', 'divi_flash' ),
					'style_2'          => esc_html__( 'Style 2', 'divi_flash' ),
                    'style_3'          => esc_html__( 'Style 3', 'divi_flash' ),
					'style_4'          => esc_html__( 'Style 4', 'divi_flash' ),
                    'style_5'          => esc_html__( 'Style 5', 'divi_flash' ),
                    'style_6'          => esc_html__( 'Style 6', 'divi_flash' ),
                    'style_7'          => esc_html__( 'Style 7', 'divi_flash' ),
                    'style_8'          => esc_html__( 'Style 8', 'divi_flash' )
                ),
                'default'           => 'style_1',
                'toggle_slug'       => 'spot_settings',
                'show_if'           => array (
                    'spot_animation' => 'on'
                )
            ),

            'animation_color'            => array (
				'label'             => esc_html__( 'Animation Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Here you can define a custom color for your Animation.', 'divi_flash' ),
				'depends_show_if'   => 'on',
                'toggle_slug'       => 'spot_settings',
                'show_if'           => array(
                    'spot_animation' => 'on'
                )
            )

        );
    
        $tooltip_content = array(
            'content' => array (
                'label'           => esc_html__( 'Tooltip Content', 'divi_flash' ),
                'type'            => 'tiny_mce',
                'formate'         => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__('Note: Html tags, shortcode are supported and shortcode will be view only frontend ', 'divi_flash'),
                'toggle_slug'           => 'tooltip_content',
                'dynamic_content'       => 'text'
            ),
        );
        
        return array_merge(
            $general,
            //$spot_icon_background,
            $content_settings,
            $spot,
            $spots_background,
            $tooltip_content,
            $spot_spacing
        );
        
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        
        $spot = '.difl_imagehotspot %%order_class%%';
        $icon = '.difl_imagehotspot %%order_class%% .et-pb-icon.df-image-hotspot-icon';
        $spot_image = '.difl_imagehotspot %%order_class%% .difl_image_marker img , .difl_imagehotspot %%order_class%% .et-pb-icon.df-image-hotspot-icon';

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'spot_background',
            'selector'      => $spot
        ));

        //spacing
        $fields['spot_padding'] = array ('padding' => $spot);
        
        // Color 
        $fields['icon_color'] = array('color' => $icon);
      
        $fields = $this->df_fix_border_transition(
            $fields,
            'spot_item_border',
            $spot
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'spot_image_border',
            $spot_image
        );
        //box-shadow Fix
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'spot_item_box_shadow',
            $spot
        );


        return $fields;
    }
    
    public function additional_css_styles($render_slug) {
        
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'spot_background',
            'selector'          => ".difl_imagehotspot {$this->main_css_element}",
            'hover'             => ".difl_imagehotspot {$this->main_css_element}:hover",
            'important'         => true
        ));

        if ('text' === $this->props['spot_type']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => ".difl_imagehotspot %%order_class%%",
                'declaration' => sprintf('width: auto; height:auto;')
            ));
        }

        if($this->props['spot_animation'] === 'on'){
            $animation_style = array('style_1', 'style_2', 'style_3', 'style_4', 'style_5');
            if( $this->props['spot_animation_style'] === 'style_1' || $this->props['spot_animation_style'] === 'style_2' ){
                $this->df_process_color(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'animation_color',
                    'type'              => 'background-color',
                    'selector'          => ".difl_imagehotspot %%order_class%% , .difl_imagehotspot %%order_class%%.pulsating:before , .difl_imagehotspot %%order_class%%.pulsating_2:before",
                    'important'         => true
                ));
            }

            if( $this->props['spot_animation_style'] === 'style_3'){
                $this->df_process_color(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'animation_color',
                    'type'              => 'border-color',
                    'selector'          => ".difl_imagehotspot %%order_class%%.pulse:before, .difl_imagehotspot %%order_class%%.pulse:after"
                ));
            }

            if( $this->props['spot_animation_style'] === 'style_4' || $this->props['spot_animation_style'] === 'style_5' ){
                $this->df_process_color(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'animation_color',
                    'type'              => 'color',
                    'selector'          => ".difl_imagehotspot %%order_class%%.pulse_2 , .difl_imagehotspot %%order_class%%.web_pulse-1 "
                ));
            }
            $hex = $this->props['animation_color'];
            list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
            if( $this->props['spot_animation_style'] === 'style_7' ){
                $this->df_process_color(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'animation_color',
                    'type'              => 'border-color',
                    'selector'          => ".difl_imagehotspot %%order_class%% .wheel"
                ));

                $this->df_process_color(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'animation_color',
                    'type'              => 'background-color',
                    'selector'          => ".difl_imagehotspot %%order_class%% .wheel:before"
                ));
               
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => ".difl_imagehotspot %%order_class%% .wheel",
                    'declaration' => sprintf(' box-shadow: inset 0 0 4px 2px rgba(%1$s, %2$s, %3$s , 0.6);' ,$r, $g, $b )
                ));
               
            }

            if( $this->props['spot_animation_style'] === 'style_8' ){
       
                $this->df_process_color(array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'animation_color',
                    'type'              => 'background-color',
                    'selector'          => ".difl_imagehotspot %%order_class%% .sq"
                ));
    
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => ".difl_imagehotspot %%order_class%% .sq",
                    'declaration' => sprintf(' box-shadow: inset 0 0 8px 6px rgba(%1$s, %2$s, %3$s , 0.4);' ,$r, $g, $b )
                ));
               
            }
      
        }

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'left_position',
            'type'              => 'left',
            'selector'          => ".difl_imagehotspot %%order_class%%",
            'important'         => 'true'
        ));
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'top_position',
            'type'              => 'top',
            'selector'          => ".difl_imagehotspot %%order_class%%",
            'important'         => 'true'
        ));
          
        $this->df_process_transform(array(
            'render_slug'       => $render_slug,
            'selector'          => '.difl_imagehotspot %%order_class%%',
            'oposite'           => true,
            'transforms'        => [
                [
                    'type' => 'translateX',
                    'unit' => '%',
                    'slug'  => 'left_position'
                ],
                [
                    'type' => 'translateY',
                    'unit' => '%',
                    'slug'  => 'top_position'
                ]
            ]
        ));

       // }
    
        if ('on' === $this->props['variable_width']) {
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'spot_width',
                'type'              => 'width',
                'default_unit'      => 'px',
                'selector'          => ".difl_imagehotspot %%order_class%%",
                'hover'             => '.difl_imagehotspot %%order_class%%',
                'important'         => 'true'
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'spot_width',
                'type'              => 'height',
                'default_unit'      => 'px',
                'selector'          => ".difl_imagehotspot %%order_class%%",
                'hover'             => '.difl_imagehotspot %%order_class%%',
                'important'         => 'true'
            ));
        }
        // Item Icon
        if (isset($this->props['spot_type']) && 'icon' === $this->props['spot_type']) {

            $this->df_process_color(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_color',
                'type'              => 'color',
                'selector'          => ".difl_imagehotspot %%order_class%% .et-pb-icon.df-image-hotspot-icon",
                'hover'             => '.difl_imagehotspot %%order_class%%:hover .et-pb-icon.df-image-hotspot-icon'
            ));
            $this->df_process_range(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_size',
                'type'              => 'font-size',
                'default_unit'      => 'px',
                'selector'          => ".difl_imagehotspot %%order_class%% .et-pb-icon.df-image-hotspot-icon",
                'hover'             => '.difl_imagehotspot %%order_class%% .et-pb-icon.df-image-hotspot-icon:hover',
                'important'         =>  'true'
            ));    
        }

        if ('on' === $this->props['use_image_as_icon']) {
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'image_as_icon_width',
                'type'              => 'width',
                'selector'          => '.difl_imagehotspot %%order_class%% img.df-image-hotspot-icon'
                ) 
            );

            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'image_as_icon_width',
                'type'              => 'height',
                'selector'          => '.difl_imagehotspot %%order_class%% img.df-image-hotspot-icon'
                ) 
            );
        }
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'spot_padding',
            'type'              => 'padding',
            'selector'          => ".difl_imagehotspot {$this->main_css_element}",
            'hover'             => ".difl_imagehotspot {$this->main_css_element}:hover"
        ));  

        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df-image-hotspot-icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon'
                    ),
                )
            );
        
        }
    }
    public function df_render_image_icon()
    {
        if (isset($this->props['spot_type']) && $this->props['spot_type'] === 'icon' && $this->props['use_image_as_icon'] ==='off') {

            return sprintf(
                '<span class="et-pb-icon df-image-hotspot-icon">%1$s</span>',
                isset($this->props['font_icon']) && $this->props['font_icon'] !== '' ?
                    esc_attr(et_pb_process_font_icon($this->props['font_icon'])) : 'P'
            );
        } else if (isset($this->props['use_image_as_icon']) && $this->props['use_image_as_icon'] === 'on') {
            
            $src = 'src';
            $image_alt_text =  isset($this->props['image_as_icon']) ? df_image_alt_by_url($this->props['image_as_icon']) : '';
            $image_alt = isset($this->props['image_alt_text']) && $this->props['image_alt_text'] !== '' ? $this->props['image_alt_text']  : $image_alt_text;
            $image_url = $this->props['image_as_icon'];    
           
            return sprintf(
                '<img class="df-image-hotspot-icon" %3$s="%1$s" alt="%2$s" />',
                $this->props['image_as_icon'],
                $image_alt,
                $src
            );
        }
    }
    public function render( $attrs, $content, $render_slug ) {
		$this->handle_fa_icon();
        $icon_html = $this->df_render_image_icon();
        $spot_text = isset($this->props['spot_text']) && $this->props['spot_text'] !== '' && 'empty' !== $this->props['spot_type'] ? wp_kses_post( $this->props['spot_text'] ) : '';
        $spot_html = sprintf('%1$s %2$s', $icon_html , $spot_text);
        $spot_animation_class = '';
        if ( $this->props['spot_animation'] === 'on' && isset($this->props['spot_animation_style']) && $this->props['spot_animation_style'] ==='style_1') {
            $spot_animation_class = 'pulsating';
        }
        if ( $this->props['spot_animation'] === 'on' && isset($this->props['spot_animation_style']) && $this->props['spot_animation_style'] ==='style_2') {
            $spot_animation_class = 'pulsating_2';
        }
        if ( $this->props['spot_animation'] === 'on' && isset($this->props['spot_animation_style']) && $this->props['spot_animation_style'] ==='style_3') {
            $spot_animation_class = 'pulse';
        }
        if ( $this->props['spot_animation'] === 'on' && isset($this->props['spot_animation_style']) && $this->props['spot_animation_style'] ==='style_4') {
            $spot_animation_class = 'pulse_2';
        }
        if ( $this->props['spot_animation'] === 'on' && isset($this->props['spot_animation_style']) && $this->props['spot_animation_style'] ==='style_5') {
            $spot_animation_class = 'web_pulse-1';
        }
        if ( $this->props['spot_animation'] === 'on' && isset($this->props['spot_animation_style']) && $this->props['spot_animation_style'] ==='style_6') {
            $spot_animation_class = 'pulse_key';
        }

        
        array_push($this->classname, $spot_animation_class);
        $this->additional_css_styles($render_slug);
	    $item_content = ! empty( $this->props['content'] ) ? $this->props['content'] : '';
        //$item_content = preg_replace("/<p[^>]*>(?:\s|&nbsp;)*<\/p>/", '', $item_content);//trim(str_replace($tags, "", $item_content), "\n");
        if ($item_content !== null) {
            $item_content = preg_replace("/<p[^>]*>(?:\s|&nbsp;)*<\/p>/", '', $item_content);
        }
        global $df_image_hotspot_data;
        $df_imh_child_class = ET_Builder_Element::get_module_order_class( $render_slug );
      
        $df_image_hotspot_data[$df_imh_child_class] = $item_content;
    
        $spot_type_class =  isset($this->props['spot_type']) ? 'spot_type_' . $this->props['spot_type'] : '';
        $item_html =sprintf(
                    '<div class="difl_marker %2$s %3$s %4$s">
                        <span class="difl_marker_wrapper difl_image_marker">%1$s</span>
                    </div>',
                    $spot_html,
                    $spot_type_class,
                    $this->props['spot_animation'] === 'on' && isset($this->props['spot_animation_style']) && $this->props['spot_animation_style'] ==='style_7' ? 'wheel' : '',
                    $this->props['spot_animation'] === 'on' && isset($this->props['spot_animation_style']) && $this->props['spot_animation_style'] ==='style_8' ? 'sq' : ''
                );
            
        return $item_html;    
    }   
}
new DIFL_ImageHotspotItem;