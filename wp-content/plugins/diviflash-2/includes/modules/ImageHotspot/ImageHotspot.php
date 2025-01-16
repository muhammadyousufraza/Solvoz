<?php

class DIFL_ImageHotspot extends ET_Builder_Module
{
    public $slug       = 'difl_imagehotspot';
    public $vb_support = 'on';
    public $child_slug = 'difl_imagehotspotitem';
    use DF_UTLS;

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'DiviFlash',
        'author_uri' => '',
    );

    public function init()
    {
        $this->name = esc_html__('Image Hotspot', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/image-hotspot.svg';
    }

    public function get_settings_modal_toggles()
    {
        return array(
            'general'   => array(
                'toggles'      => array(
                    'image' => esc_html__('Main Image', 'divi_flash'),
                    'tooltip' => esc_html__('Tooltip Settings', 'divi_flash'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'hotspot_wrapper' => esc_html__('Module Alignment', 'divi_flash'),    
                    'image' => esc_html__('Main Image Style', 'divi_flash'),                
                    'spot' => esc_html__('Spot', 'divi_flash'),
                    'spot_image' => esc_html__('Spot Icon/Image', 'divi_flash'),
                    'tooltip_text'   => array(
						'title'             => esc_html__(' Tooltip Text', 'divi_flash'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
                            'body'     => array(
								'name' => 'p',
								'icon' => 'text-left',
							),
							'a'     => array(
								'name' => 'A',
								'icon' => 'text-link',
							),
							'ul'    => array(
								'name' => 'UL',
								'icon' => 'list',
							),
							'ol'    => array(
								'name' => 'OL',
								'icon' => 'numbered-list',
							),
							'quote' => array(
								'name' => 'QUOTE',
								'icon' => 'text-quote',
							)
						),
					),
					'tooltip_header' => array(
						'title'             => esc_html__( 'Tooltip Heading Text', 'et_builder' ),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'h1' => array(  
                                'name' => 'H1',          
								'icon' => 'text-h1',
							),
							'h2' => array(
								'name' => 'H2',
								'icon' => 'text-h2',
							),
							'h3' => array(
								'name' => 'H3',
								'icon' => 'text-h3',
							),
							'h4' => array(
								'name' => 'H4',
								'icon' => 'text-h4',
							),
							'h5' => array(
								'name' => 'H5',
								'icon' => 'text-h5',
							),
							'h6' => array(
								'name' => 'H6',
								'icon' => 'text-h6',
							),
						),
                    ),
                    'tooltip' => esc_html__('Tooltip', 'divi_flash'),
                    'item_design' => esc_html__('Items', 'divi_flash'),
                    'custom_spacing'        => array(
                        'title'             => esc_html__('Custom Spacing', 'divi_flash'),
                    )
                )
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = array();
        $advanced_fields['text'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['fonts'] = array (
            'tooltip_text_body'     => array(
                'label'         => esc_html__( 'Body', 'divi_flash' ),
                'toggle_slug'   => 'tooltip',
                'tab_slug'		=> 'advanced',
                'toggle_slug'   => 'tooltip_text',
                'sub_toggle'  => 'body',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '18px',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%']",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover",
                    'important'	=> 'all'
                )
            ),
   
            'tooltip_text_a'     => array(
                'label'         => esc_html__( 'Link', 'divi_flash' ),
                'toggle_slug'   => 'tooltip',
                'tab_slug'		=> 'advanced',
                'toggle_slug'   => 'tooltip_text',
                'sub_toggle'  => 'a',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '18px',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%'] a",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover a",
                    'important'	=> 'all'
                )
            ),
            'tooltip_text_ul'     => array(
                'label'         => esc_html__( 'Ul', 'divi_flash' ),
                'toggle_slug'   => 'tooltip',
                'tab_slug'		=> 'advanced',
                'toggle_slug'   => 'tooltip_text',
                'sub_toggle'  => 'ul',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '18px',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%'] ul li",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover ul li",
                    'important'	=> 'all'
                )
            ),
            'tooltip_text_ol'     => array(
                'label'         => esc_html__( 'Ol', 'divi_flash' ),
                'toggle_slug'   => 'tooltip',
                'tab_slug'		=> 'advanced',
                'toggle_slug'   => 'tooltip_text',
                'sub_toggle'  => 'ol',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '18px',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%'] ol li",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover ol li",
                    'important'	=> 'all'
                )
            ),
            'tooltip_text_quote'     => array(
                'label'         => esc_html__( 'Quote', 'divi_flash' ),
                'tab_slug'		=> 'advanced',
                'toggle_slug'   => 'tooltip_text',
                'sub_toggle'  => 'quote',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '18px',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%'] blockquote",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover blockquote",
                    'important'	=> 'all'
                )
            ),
            'tooltip_text_h1'     => array(
                'label'         => esc_html__( 'H1', 'divi_flash' ),
                'tab_slug'		=> 'advanced',
                'toggle_slug'   => 'tooltip_header',
                'sub_toggle'  => 'h1',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '32px',
                ),
                'font_size' => array(
                    'default' => '32px',
                ),
                'css'      => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%'] h1",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover h1",
                    'important'	=> 'all'
                )
            ),
            'tooltip_text_h2'     => array(
                'label'         => esc_html__( 'H2', 'divi_flash' ),
                'toggle_slug'   => 'tooltip',
                'tab_slug'		=> 'advanced',
                'toggle_slug'   => 'tooltip_header',
                'sub_toggle'  => 'h2',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '28px',
                ),
                'font_size' => array(
                    'default' => '28px',
                ),
                'css'      => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%'] h2",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover h2",
                    'important'	=> 'all'
                )
            ),
            'tooltip_text_h3'     => array(
                'label'         => esc_html__( 'H3', 'divi_flash' ),
                'toggle_slug'   => 'tooltip',
                'tab_slug'		=> 'advanced',
                'toggle_slug'   => 'tooltip_header',
                'sub_toggle'  => 'h3',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '24px',
                ),
                'font_size' => array(
                    'default' => '24px',
                ),
                'css'      => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%'] h3",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover h3",
                    'important'	=> 'all'
                )
            ),
            'tooltip_text_h4'     => array(
                'label'         => esc_html__( 'H4', 'divi_flash' ),
                'toggle_slug'   => 'tooltip',
                'tab_slug'		=> 'advanced',
                'toggle_slug'   => 'tooltip_header',
                'sub_toggle'  => 'h4',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '20px',
                ),
                'font_size' => array(
                    'default' => '20px',
                ),
                'css'      => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%'] h4",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover h4",
                    'important'	=> 'all'
                )
            ),
            'tooltip_text_h5'     => array(
                'label'         => esc_html__( 'H5', 'divi_flash' ),
                'toggle_slug'   => 'tooltip',
                'tab_slug'		=> 'advanced',
                'toggle_slug'   => 'tooltip_header',
                'sub_toggle'  => 'h5',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '16px',
                ),
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%'] h5",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover h5",
                    'important'	=> 'all'
                )
            ),
            'tooltip_text_h6'     => array(
                'label'         => esc_html__( 'H6', 'divi_flash' ),
                'toggle_slug'   => 'tooltip',
                'tab_slug'		=> 'advanced',
                'toggle_slug'   => 'tooltip_header',
                'sub_toggle'  => 'h6',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '14px',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%'] h6",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover h6",
                    'important'	=> 'all'
                )
            ),
            'spot'     => array(
                'label'         => esc_html__( 'Spot', 'divi_flash' ),
                'toggle_slug'   => 'spot',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'font_size' => array(
                    'default' => '16px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% .difl_imagehotspotitem .difl_marker_wrapper",
                    'hover' => "%%order_class%% .difl_imagehotspotitem:hover .difl_marker_wrapper",
                    'important'	=> 'all'
                )
            )
        );

        $advanced_fields['borders'] = array (
            'default'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%%',
                        'border_radii_hover' => '%%order_class%%:hover',
                        'border_styles' => '%%order_class%%',
                        'border_styles_hover' => '%%order_class%%:hover'
                    )
                )
            ),

            'spots_border' => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .difl_imagehotspotitem ",
                        'border_radii_hover' => "%%order_class%% .difl_imagehotspotitem:hover",
                        'border_styles' => '%%order_class%% .difl_imagehotspotitem',
                        'border_styles_hover' => '%%order_class%% .difl_imagehotspotitem'
                    )
                ),
                'toggle_slug'   => 'spot',
                'tab_slug'		=> 'advanced'
            ),

            'spots_image_border'               => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => '%%order_class%% .difl_image_marker img , %%order_class%% .et-pb-icon.df-image-hotspot-icon',
                        'border_radii_hover' => '%%order_class%% .difl_imagehotspotitem:hover .difl_image_marker img ,%%order_class%% .difl_imagehotspotitem:hover .et-pb-icon.df-image-hotspot-icon',
                        'border_styles' => '%%order_class%% .difl_image_marker img , %%order_class%% .et-pb-icon.df-image-hotspot-icon',
                        'border_styles_hover' => '%%order_class%% .difl_imagehotspotitem:hover .difl_image_marker img , %%order_class%% .difl_imagehotspotitem:hover .et-pb-icon.df-image-hotspot-icon'
                    )
                ),
                'toggle_slug'   => 'spot_image',
                'tab_slug'		=> 'advanced'
            ),

            'tooltips_border' => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".tippy-box[data-theme~='%%order_class%%']",
                        'border_styles' => ".tippy-box[data-theme~='%%order_class%%']",
                        'border_styles_hover' => ".tippy-box[data-theme~='%%order_class%%']:hover"
                    )
                ),
                'toggle_slug'   => 'tooltip',
                'tab_slug'		=> 'advanced'
            ),

            'image_border' => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .difl_image_wrapper img.hotspot_image",
                        'border_styles' => "%%order_class%% .difl_image_wrapper img.hotspot_image",
                        'border_styles_hover' => "%%order_class%% .difl_image_wrapper img.hotspot_image:hover"
                    )
                ),
                'toggle_slug'   => 'image',
                'tab_slug'		=> 'advanced'
            ),
        );

        $advanced_fields['box_shadow'] = array (
            'default' => array(
                'css' => array(
                    'main' => "{$this->main_css_element}"
                )
            ),
        
            'spots_box_shadow' => array(
                'css' => array(
                    'main' => "%%order_class%% .difl_imagehotspotitem",
                    'hover' => "%%order_class%% .difl_imagehotspotitem:hover"
                ),
                'toggle_slug'   => 'spot',
                'tab_slug'		=> 'advanced'
            ),
            
            'tooltips_box_shadow' => array(
                'css' => array(
                    'main' => ".tippy-box[data-theme~='%%order_class%%']",
                    'hover' => ".tippy-box[data-theme~='%%order_class%%']:hover"
                ),
                'toggle_slug'   => 'tooltip',
                'tab_slug'		=> 'advanced'
            ),

            'image_box_shadow' => array(
                'css' => array(
                    'main' => "%%order_class%% .difl_image_wrapper img.hotspot_image",
                    'hover' => "%%order_class%% .difl_image_wrapper img.hotspot_image:hover"
                ),
                'toggle_slug'   => 'image',
                'tab_slug'		=> 'advanced'
            )
        );
   
        return $advanced_fields;
    }

    public function get_fields()
    {
        $image = array(
            'hotsopt_image' => array(
                'label'              => et_builder_i18n( 'Image' ),
                'type'               => 'upload',
                'option_category'    => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an Image', 'divi_flash'),
                'choose_text'        => esc_attr__('Choose an Image', 'divi_flash'),
                'update_text'        => esc_attr__('Set As Image', 'divi_flash'),
                'toggle_slug'        => 'image',
                'dynamic_content'    => 'image',
				'hide_metadata'      => true,
				'description'        => esc_html__( 'Upload your desired image, or type in the URL to the image you would like to display.', 'divi_flash' )
            ),
            'hotsopt_image_alt_text' => array(
                'label'              => esc_html__('Image Alt Text', 'divi_flash'),
                'type'               => 'text',
                'toggle_slug'        => 'image'  
            ),
            'hotsopt_image_alignment' => array(
                'label'               => esc_html__('Alignment', 'divi_flash'),
                'type'                => 'text_align',
                'options'             => et_builder_get_text_orientation_options(array('justified')),
                'toggle_slug'         => 'hotspot_wrapper',
                'tab_slug'            => 'advanced',
                'mobile_options'      => true,
                'show_if_not'         => array(
                    'hotspot_image'     => array('')
                )
            ),

        );
     
        $spots_background =  $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'spots_background',
            'toggle_slug'           => 'spot',
            'tab_slug'              => 'advanced',
            'hover'				    => 'tabs'
        ));


        $spots_design = array(
            'spots_icon_color' => array(
                'label'             => esc_html__('Spot Icon Color', 'divi_flash'),
                'type'              => 'color-alpha',
                'toggle_slug'       => 'spot_image',
                'tab_slug'          => 'advanced', 
                'hover'             => 'tabs'
            ),
            'spots_icon_size' => array (
                'label'             => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'spot_image',
                'tab_slug'          => 'advanced',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'default'           => '36px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '120',
					'step' => '1'
                ),
				'mobile_options'    => true
            )
        );

        $tooltips_settings = array(
            
            'tooltip_enable'      => array (
                'label'              => esc_html__( 'Tooltip', 'divi_flash' ),
                'descriptoin'        => esc_html__( 'Tooltip On/ Off.', 'divi_flash' ),
                'type'               => 'yes_no_button',
				'options'            => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' )
                ),
                'default'             => 'on',
                'toggle_slug'         => 'tooltip'
            ),
       
            'tooltip_arrow'      => array (
                'label'                 => esc_html__( 'Arrow', 'divi_flash' ),
                'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' )
                ),
                'default'               => 'on',
                'toggle_slug'           => 'tooltip',
                'show_if'               => array(
                    'tooltip_enable' => 'on'
                )
            ),

            'tooltip_placement'   => array (
                'label'             => esc_html__('Placement', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
					'top'         => esc_html__( 'Top', 'divi_flash' ),
					'top-start'   => esc_html__( 'Top Start', 'divi_flash' ),
					'top-end'     => esc_html__( 'Top End', 'divi_flash' ),
                    'right'       => esc_html__( 'Right', 'divi_flash' ),
					'right-start' => esc_html__( 'Right Start', 'divi_flash' ),
					'right-end'   => esc_html__( 'Right End', 'divi_flash' ),
                    'bottom'      => esc_html__( 'Bottom', 'divi_flash' ),
					'bottom-start'=> esc_html__( 'Bottom Start', 'divi_flash' ),
					'bottom-end'  => esc_html__( 'Bottom End', 'divi_flash' ),
                    'left'        => esc_html__( 'Left', 'divi_flash' ),
					'left-start'  => esc_html__( 'Left Start', 'divi_flash' ),
					'left-end'    => esc_html__( 'Left End', 'divi_flash' )
                ),
                'default'           => 'top',
                'toggle_slug'       => 'tooltip',
                'show_if'           => array(
                    'tooltip_enable' => 'on'
                )
            ), 

            'tooltip_animation'   => array (
                'label'             => esc_html__('Animation', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
                    'fade'           => esc_html__( 'fade', 'divi_flash' ),
                    'scale'          => esc_html__( 'Scale', 'divi_flash' ),
                    'rotate'         => esc_html__( 'Rotate', 'divi_flash' ),
                    'shift-away'     => esc_html__( 'Shift-away', 'divi_flash' ),
                    'shift-toward'   => esc_html__( 'Shift-toward', 'divi_flash' ),
                    'perspective'    => esc_html__( 'perspective', 'divi_flash' )
                ),
                'default'           => 'fade',
                'toggle_slug'       => 'tooltip',
                'show_if'               => array(
                    'tooltip_enable' => 'on'
                )
            ), 

            'tooltip_trigger'   => array (
                'label'             => esc_html__('Trigger', 'divi_flash'),
                'type'              => 'select',
                'options'           => array(
					'mouseenter focus'         => esc_html__( 'Hover', 'divi_flash' ),
					'click'          => esc_html__( 'Click', 'divi_flash' ),
					'mouseenter click'          => esc_html__( 'Hover And Click', 'divi_flash' )
                ),
                'default'           => 'mouseenter focus',
                'toggle_slug'       => 'tooltip',
                'show_if'               => array(
                    'tooltip_enable' => 'on'
                )
            ), 

            'tooltip_interactive'      => array (
                'label'                 => esc_html__( 'Hover Over Tooltip', 'divi_flash' ),
                'description'           => esc_html__( 'Tooltip allowing you to hover over and click inside it.', 'divi_flash' ),
                'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' )
                ),
                'default'               => 'on',
                'toggle_slug'           => 'tooltip',
                'show_if'               => array(
                    'tooltip_enable' => 'on'
                )
            ),
            'tooltip_interactive_border' => array(
                'label'             => esc_html__('Tooltip Hover Area', 'divi_flash'),
                'description'       => esc_html__('Determines the size of the invisible border around the tooltip that will prevent it from hiding if the cursor left it.' , 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'tooltip',
                'default'           => 2,
                'allowed_units'     => array(),
                'validate_unit'    => false,
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1'
                ),
                'show_if'         => array(
                    'tooltip_interactive'     => 'on',
                    'tooltip_enable' => 'on'
                )
            ),

            'tooltip_interactive_debounce' => array(
                'label'             => esc_html__('Tooltip Content Hide Delay', 'divi_flash'),
                'description'       => esc_html__('Determines the time in ms to debounce the Tooltip content hide handler when the cursor leaves.' , 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'tooltip',
                'default'           => 0,
                'allowed_units'     => array(),
                'validate_unit'    => false,
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1000',
                    'step' => '10'
                ),
                'show_if'         => array(
                    'tooltip_interactive'     => 'on',
                    'tooltip_enable' => 'on'
                )
            ),

            'tooltip_follow_cursor'      => array (
                'label'                 => esc_html__( 'Follow Cursor', 'divi_flash' ),
                'description'           => esc_html__( 'Tooltip move with mouse courser.', 'divi_flash' ),
                'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' )
                ),
                'default'               => 'off',
                'toggle_slug'           => 'tooltip',
                'show_if'               => array(
                    'tooltip_enable' => 'on',
                    'tooltip_trigger' => 'mouseenter focus'
                )
            ),

            'tooltip_custom_maxwidth'      => array (
                'label'             => esc_html__('Max Width', 'divi_flash'),
                'description'       => esc_html__('Specifies the maximum width of the tooltip. Useful to prevent it from being too horizontally wide to read.' , 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'tooltip',
                'default'           => 350,
                'allowed_units'     => array(),
                'validate_unit'    => false,
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1000',
                    'step' => '1'
                ),
                'show_if'               => array(
                    'tooltip_enable' => 'on'
                )
            ),

            'tooltip_offset_enable'      => array (
                'label'                 => esc_html__( 'Tooltip Distance', 'divi_flash' ),
                'descriptoin'           => esc_html__( 'Displaces the tippy from its reference element in pixels (skidding and distance).', 'divi_flash' ),
                'type'                  => 'yes_no_button',
				'options'               => array(
					'on' => esc_html__( 'On', 'divi_flash' ),
					'off'  => esc_html__( 'Off', 'divi_flash' )
                ),
                'default'               => 'off',
                'toggle_slug'           => 'tooltip',
                'show_if'               => array(
                    'tooltip_enable' => 'on'
                )
            ),

            'tooltip_offset_skidding'      => array (
                'label'             => esc_html__('Tooltip Arrow Move', 'divi_flash'),
                'description'       => esc_html__('Tooltip Arrow Move length.' , 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'tooltip',
                'default'           => 0,
                'allowed_units'     => array(),
                'validate_unit'    => false,
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1000',
                    'step' => '1'
                ),
                'show_if' => array(
                    'tooltip_offset_enable' => 'on',
                    'tooltip_enable' => 'on'
                )
            ),

            'tooltip_offset_distance'      => array (
                'label'             => esc_html__('Tooltip Distance', 'divi_flash'),
                'description'       => esc_html__('Tooltip Distance length from spot to tooltip' , 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'tooltip',
                'default'           => 10,
                'allowed_units'     => array(),
                'validate_unit'     => false,
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '100',
                    'step' => '1',
                ),
                'show_if' => array(
                    'tooltip_offset_enable' => 'on',
                    'tooltip_enable' => 'on'
                )
            ),         
            
        );
        $tooltips_background =  $this->df_add_bg_field(array(
            'label'                 => 'Background',
            'key'                   => 'tooltips_background',
            'toggle_slug'           => 'tooltip',
            'tab_slug'              => 'advanced',           
            'image'                 => false,
            'hover'				    => 'tabs',
            'show_if' => array(
                'tooltip_enable' => 'on'
            )
        ));

        $tooltips_design = array(
            'tooltips_arrow_color' => array(
                'label'                 => esc_html__('Tooltip Arrow Color', 'divi_flash'),
                'type'                  => 'color-alpha',
                'toggle_slug'           => 'tooltip',
                'tab_slug'              => 'advanced', 
                'hover'                 => 'tabs',
                'show_if' => array(
                    'tooltip_enable' => 'on'
                )
            )
        );

        $wrapper_spacing = $this->add_margin_padding(array(
            'title'         => 'Wrapper',
            'key'           => 'wrapper',
            'toggle_slug'   => 'margin_padding',
            'tab_slug'      => 'advanced'
        ));
        $spots_spacing = $this->add_margin_padding(array(
            'title'         => 'Spots',
            'key'           => 'spots',
            'toggle_slug'   => 'margin_padding',
            'tab_slug'      => 'advanced',
            'option'        => 'padding'
        ));

        $tooltips_spacing = $this->add_margin_padding(array(
            'title'         => 'Tooltips',
            'key'           => 'tooltips',
            'toggle_slug'   => 'margin_padding',
            'tab_slug'      => 'advanced',
            'option'        => 'padding',
            'show_if' => array(
                'tooltip_enable' => 'on'
            )
        ));

        return array_merge(
            $image,
            //$hotspot_wrapper_background,
            $spots_background,
            // $spots_icon_background,
            $spots_design,
            $tooltips_settings,
            $tooltips_background,
            $tooltips_design,
            $wrapper_spacing,
            $spots_spacing,
            $tooltips_spacing
        );
        
    }

    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();
        
        $wrapper = '%%order_class%% .difl_imagehotspot_wrapper';
        $image = '%%order_class%% .difl_image_wrapper img.hotspot_image';
        $spots = '%%order_class%% .difl_imagehotspotitem';
        $tooltips = '%%order_class%% .tippy-box';
        $tooltips_arrow = '%%order_class%% .tippy-arrow:before';
        $spot_image = '%%order_class%% .difl_image_marker img , %%order_class%% .et-pb-icon.df-image-hotspot-icon';
        $spots_icon = '%%order_class%% .et-pb-icon.df-image-hotspot-icon';
        //spacing
        $fields['wrapper_margin'] = array ('margin' => $wrapper);
        $fields['wrapper_padding'] = array ('padding' => $wrapper);
        $fields['spots_padding'] = array ('padding' => $spots);
        $fields['tooltips_padding'] = array ('padding' => $tooltips);
        
        //Background

        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'spots_background',
            'selector'      => $spots
        ));
   
        $fields = $this->df_background_transition(array (
            'fields'        => $fields,
            'key'           => 'tooltips_background',
            'selector'      => $tooltips
        ));
    
        // Color 
         $fields['spots_icon_color'] = array('color' => $spots_icon);
         $fields['tooltips_arrow_color'] = array('color' => $tooltips_arrow);
        
         // border fix
        $fields = $this->df_fix_border_transition(
            $fields,
            'hotspot_wrapper_border',
            $wrapper
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'image_border',
            $image
        );
         $fields = $this->df_fix_border_transition(
             $fields,
             'tooltips_border',
             $tooltips
         );

         $fields = $this->df_fix_border_transition(
            $fields,
            'spots_border',
            $spots
        );
        $fields = $this->df_fix_border_transition(
            $fields,
            'spots_image_border',
            $spot_image
        );

        //box-shadow Fix
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'hotspot_wrapper_box_shadow',
            $wrapper
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'image_box_shadow',
            $image
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'tooltips_box_shadow',
            $tooltips
        );
        $fields = $this->df_fix_box_shadow_transition(
            $fields,
            'spots_box_shadow',
            $spots
        );

        return $fields;
    }

    public function get_custom_css_fields_config()
    {
      
    }

    public function additional_css_styles($render_slug)
    {
        $this->df_process_string_attr(array(
            'render_slug'       => $render_slug,
            'slug'              => 'hotsopt_image_alignment',
            'type'              => 'text-align',
            'selector'          => '%%order_class%% .difl_imagehotspot_container'
        ));
        // wrapper spacing
         $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_margin',
            'type'              => 'margin',
            'selector'          => "{$this->main_css_element} .difl_imagehotspot_wrapper",
            'hover'             => "{$this->main_css_element} .difl_imagehotspot_wrapper:hover"
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .difl_imagehotspot_wrapper",
            'hover'             => "{$this->main_css_element} .difl_imagehotspot_wrapper:hover"
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'spots_padding',
            'type'              => 'padding',
            'selector'          => "{$this->main_css_element} .difl_imagehotspotitem",
            'hover'             => "{$this->main_css_element} .difl_imagehotspotitem:hover"
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'tooltips_padding',
            'type'              => 'padding',
            'selector'          => ".tippy-box[data-theme~='$this->main_css_element']",
            'hover'             => ".tippy-box[data-theme~='$this->main_css_element']:hover"
        ));     

    
        //Spot
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'spots_background',
            'selector'          => "{$this->main_css_element} .difl_imagehotspotitem",
            'hover'             => "{$this->main_css_element} .difl_imagehotspotitem:hover"
        ));
  
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'spots_icon_color',
            'type'              => 'color',
            'selector'          => "%%order_class%% .et-pb-icon.df-image-hotspot-icon",
            'hover'             => '%%order_class%% .et-pb-icon.df-image-hotspot-icon:hover'
        ));

        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'spots_icon_size',
            'type'              => 'font-size',
            'default_unit'      => 'px',
            'selector'          => "%%order_class%% .et-pb-icon.df-image-hotspot-icon",
            'hover'             => '%%order_class%% .et-pb-icon.df-image-hotspot-icon:hover'
        ));
        
        // Tooltip
        $this->df_process_bg(array(
            'render_slug'       => $render_slug,
            'slug'              => 'tooltips_background',
            'selector'          => ".tippy-box[data-theme~='$this->main_css_element']",
            'hover'             => ".tippy-box[data-theme~='$this->main_css_element']:hover"
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'tooltips_arrow_color',
            'type'              => 'border-top-color',
            'selector'          => ".tippy-box[data-theme~='$this->main_css_element'][data-placement^='top'] > .tippy-arrow::before",
            'hover'             => ".tippy-box[data-theme~='$this->main_css_element'][data-placement^='top']:hover > .tippy-arrow::before"
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'tooltips_arrow_color',
            'type'              => 'border-bottom-color',
            'selector'          => ".tippy-box[data-theme~='$this->main_css_element'][data-placement^='bottom'] > .tippy-arrow::before",
            'hover'             => ".tippy-box[data-theme~='$this->main_css_element'][data-placement^='bottom']:hover > .tippy-arrow::before"
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'tooltips_arrow_color',
            'type'              => 'border-left-color',
            'selector'          => ".tippy-box[data-theme~='$this->main_css_element'][data-placement^='left'] > .tippy-arrow::before",
            'hover'             => ".tippy-box[data-theme~='$this->main_css_element'][data-placement^='left']:hover > .tippy-arrow::before"
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'tooltips_arrow_color',
            'type'              => 'border-right-color',
            'selector'          => ".tippy-box[data-theme~='$this->main_css_element'][data-placement^='right'] > .tippy-arrow::before",
            'hover'             => ".tippy-box[data-theme~='$this->main_css_element'][data-placement^='right']:hover > .tippy-arrow::before"
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => ".tippy-box[data-theme~='$this->main_css_element'] .tippy-content p",
            'declaration' => sprintf('padding-bottom: 0px;')
        ));
       
    }
    public function df_render_image($props_key)
    {   
        $default_image = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA4MCIgaGVpZ2h0PSI1NDAiIHZpZXdCb3g9IjAgMCAxMDgwIDU0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHBhdGggZmlsbD0iI0VCRUJFQiIgZD0iTTAgMGgxMDgwdjU0MEgweiIvPgogICAgICAgIDxwYXRoIGQ9Ik00NDUuNjQ5IDU0MGgtOTguOTk1TDE0NC42NDkgMzM3Ljk5NSAwIDQ4Mi42NDR2LTk4Ljk5NWwxMTYuMzY1LTExNi4zNjVjMTUuNjItMTUuNjIgNDAuOTQ3LTE1LjYyIDU2LjU2OCAwTDQ0NS42NSA1NDB6IiBmaWxsLW9wYWNpdHk9Ii4xIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgICAgICA8Y2lyY2xlIGZpbGwtb3BhY2l0eT0iLjA1IiBmaWxsPSIjMDAwIiBjeD0iMzMxIiBjeT0iMTQ4IiByPSI3MCIvPgogICAgICAgIDxwYXRoIGQ9Ik0xMDgwIDM3OXYxMTMuMTM3TDcyOC4xNjIgMTQwLjMgMzI4LjQ2MiA1NDBIMjE1LjMyNEw2OTkuODc4IDU1LjQ0NmMxNS42Mi0xNS42MiA0MC45NDgtMTUuNjIgNTYuNTY4IDBMMTA4MCAzNzl6IiBmaWxsLW9wYWNpdHk9Ii4yIiBmaWxsPSIjMDAwIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz4KICAgIDwvZz4KPC9zdmc+Cg==';
        if (isset($this->props[$props_key]) && $this->props[$props_key] !== '') {
            //$photo_alt_text = $this->props[$props_key . '_alt_text'] !== '' ? $this->props[$props_key . '_alt_text']  : df_image_alt_by_url($this->props[$props_key]);   //change by bellow code
            $image_alt_text =  isset($this->props[$props_key]) ? df_image_alt_by_url($this->props[$props_key]) : '';
            $photo_alt_text = isset($this->props[$props_key . '_alt_text']) && $this->props[$props_key . '_alt_text'] !== '' ? $this->props[$props_key . '_alt_text']  : $image_alt_text;
            $src = 'src';
            $image_html = sprintf(
                '<img class="hotspot_image" %3$s="%1$s" alt="%4$s" />',
                isset($this->props[$props_key]) ? esc_url($this->props[$props_key]): $default_image ,
                $props_key,
                $src,
                $photo_alt_text
            );

            return $image_html;
                   
        }else{
            return sprintf(
                '<img class="hotspot_image" src="%1$s"/>',
                 $default_image 
            );
        }
    }
    public function render($attrs, $content, $render_slug)
    {   
        $tooltip_status = $this->props['tooltip_enable'] === 'on' ? true : false;
        if($tooltip_status === true){
            wp_enqueue_script('image-hotspot-popper-script');
            wp_enqueue_script('image-hotspot-tippy-bundle-script');
            wp_enqueue_script('df_image_hotspot');
        }
        global $df_image_hotspot_data;

        $order_class = self::get_module_order_class($render_slug);
        DF_Localize_Vars::enqueue( 'df_image_hotspot', array( 
            'class' => $order_class,
            'toogle_content_data' => $df_image_hotspot_data,
        ) );
        
        $df_image_hotspot_data = array();
        $this->additional_css_styles($render_slug);
        $hotspot_image = $this->df_render_image('hotsopt_image');  
        $data_options = array(
            'tooltip_enable'     =>  $this->props['tooltip_enable'] === 'on' ? true : false,
            'arrow'              =>  $this->props['tooltip_arrow'] === 'on' ? true : false,
            'interactive'        => $this->props['tooltip_interactive'] === 'on' ? true : false,
            'interactiveBorder'  => $this->props['tooltip_interactive'] ==='on' && isset($this->props['tooltip_interactive_border']) ? $this->props['tooltip_interactive_border'] : 2,
            'interactiveDebounce'=> $this->props['tooltip_interactive'] ==='on' && isset($this->props['tooltip_interactive_debounce']) ? $this->props['tooltip_interactive_debounce'] : 0,
            'animation'          => isset($this->props['tooltip_animation']) ? $this->props['tooltip_animation'] : 'fade',
            'placement'          => isset($this->props['tooltip_placement']) ? $this->props['tooltip_placement'] : 'top',
            'trigger'            => isset($this->props['tooltip_trigger']) ? $this->props['tooltip_trigger'] : 'focus',
            'followCursor'       => $this->props['tooltip_follow_cursor'] === 'on' ? true : false, 
            'maxWidth'           => isset($this->props['tooltip_custom_maxwidth']) ? $this->props['tooltip_custom_maxwidth'] : 350,
            'offsetEnable'       => $this->props['tooltip_offset_enable'] === 'on' ? true : false, 
            'offsetSkidding'     => $this->props['tooltip_offset_enable'] ==='on' && isset($this->props['tooltip_offset_skidding']) ? $this->props['tooltip_offset_skidding'] : 0,
            'offsetDistance'     => $this->props['tooltip_offset_enable'] ==='on' && isset($this->props['tooltip_offset_distance']) ? $this->props['tooltip_offset_distance'] : 10  
        );

        $html_code = sprintf(
                '<div class="difl_imagehotspot_container" data-options=\'%3$s\'> 
                    <div class="difl_imagehotspot_wrapper">
                        <div class="difl_image_wrapper">
                            %2$s 
                        </div>
                        %1$s 
                    </div>
                </div>',
                et_core_sanitized_previously($this->content),
                $hotspot_image,
                wp_json_encode($data_options)
        );        
        return $html_code;       
    } 
}
new DIFL_ImageHotspot;
