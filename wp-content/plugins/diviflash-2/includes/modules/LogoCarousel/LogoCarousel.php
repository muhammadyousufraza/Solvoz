<?php

class DIFL_LogoCarousel extends ET_Builder_Module {
    public $slug       = 'difl_logocarousel';
    public $vb_support = 'on';
    public $child_slug = 'difl_logocarouselitem';
	public $icon_path;
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Logo Carousel', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/logo-carousel.svg';
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'carousel_settings'         => esc_html__('Carousel Settings', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'image'                     => esc_html__('Image Settings', 'divi_flash'),
                    'arrow'                     => esc_html__('Arrow', 'divi_flash'),
                    'dots'                      => esc_html__('Dots Color', 'divi_flash')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = false;
        $advanced_fields['borders'] = array(
            'default'   => array (
                'css'      => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .difl_logocarouselitem",
                        'border_radii_hover' => "{$this->main_css_element} .difl_logocarouselitem:hover",
                        'border_styles' => "{$this->main_css_element} .difl_logocarouselitem",
                        'border_styles_hover' => "{$this->main_css_element} .difl_logocarouselitem:hover",
                    ),
                ),
            )
        );
        $advanced_fields['box_shadow'] = false;
        $advanced_fields['filters'] = array(
			'child_filters_target' => array(
				'tab_slug' 		=> 'advanced',
				'toggle_slug' 	=> 'image',
				'css'         	=> array(
					'main' => '%%order_class%% img',
				),
			),
			'css'      => array(
				'main' => '%%order_class%%',
			),
		);
		$advanced_fields['image'] = array(
			'css' => array(
				'main' => array(
					'%%order_class%% img',
				)
			),
		);
        return $advanced_fields;
    }

    public function get_fields() {
        $image = array (
            'lc_max_width'   => array (
                'label'             => esc_html__( 'Image Max Width', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'image',
				'tab_slug'          => 'advanced',
				'default'           => '100%',
                'default_unit'      => '%',
                'responsive'        => true,
                'mobile_options'    => true,
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
                )
            ),
            'lc_vertical'       => array (
                'default'         => 'flex-start',
                'label'           => esc_html__( 'Vertical Alignment', 'divi_flash' ),
                'type'            => 'select',
                'options'         => array(
                    'flex-start'            => esc_html__( 'Top', 'divi_flash' ),
                    'center'                => esc_html__( 'Center', 'divi_flash' ),
                    'flex-end'              => esc_html__( 'Bottom', 'divi_flash' )
                ),
                'toggle_slug'     => 'image',
                'tab_slug'        => 'advanced'
            ),
            'equal_height'    => array (
                'label'             => esc_html__('Equal Height Image Container', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'image',
                'tab_slug'        => 'advanced'
            )
        );
        $carousel_settings = array (
            'item_desktop'    => array (
                'label'             => esc_html__( 'Max Slide Desktop', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '4',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '7',
					'step' => '1',
                ),
                'validate_unit'     => false
            ),
            'item_tablet'    => array (
                'label'             => esc_html__( 'Max Slide Tablet', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '3',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '7',
					'step' => '1',
                ),
                'validate_unit'     => false
            ),
            'item_mobile'    => array (
                'label'             => esc_html__( 'Max Slide Mobile', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '1',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '1',
					'max'  => '7',
					'step' => '1',
                ),
                'validate_unit'     => false
            ),
            'item_width'    => array (
                'label'             => esc_html__( 'Item Max Width (px)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '300px',
                'default_unit'      => 'px',
                'allowed_units'     => array ('px'),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '1000',
					'step' => '1',
                )
            ),
            'item_spacing'    => array (
                'label'             => esc_html__( 'Spacing (px)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '30px',
                'default_unit'      => 'px',
                'allowed_units'     => array ('px'),
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '200',
					'step' => '1',
                ),
                'responsive'        => true,
                'mobile_options'    => true
            ),
            'speed'    => array (
                'label'             => esc_html__( 'Animation Speed (ms)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '500',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '100',
					'max'  => '30000',
					'step' => '50',
                ),
                'validate_unit'     => false,
                'show_if_not'       => array (
                    'ticker'        => 'on'
                )
            ),
            'loop'    => array (
                'label'             => esc_html__('Loop', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if_not'       => array (
                    'ticker'        => 'on'
                )
            ),
            'autoplay'    => array (
                'label'             => esc_html__('Autoplay', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if_not'       => array (
                    'ticker'        => 'on'
                )
            ),
            'autospeed'    => array (
                'label'             => esc_html__( 'Autoplay Duration (ms)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '2000',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '100',
					'max'  => '10000',
					'step' => '50',
                ),
                'validate_unit'     => false,
                'show_if'           => array (
                    'autoplay'      => 'on'
                ),
                'show_if_not'       => array (
                    'ticker'        => 'on'
                )
            ),
            'pause_hover'    => array (
                'label'             => esc_html__('Pause On Hover', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if'           => array (
                    'autoplay'      => 'on'
                ),
                'show_if_not'       => array (
                    'ticker'        => 'on'
                )
            ),
            'arrow'    => array (
                'label'             => esc_html__('Arrow Navigation', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if_not'       => array (
                    'ticker'        => 'on'
                )
            ),
            'dots'    => array (
                'label'             => esc_html__('Dot Navigation', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if_not'       => array (
                    'ticker'        => 'on'
                )
            ),

            'ticker'    => array (
                'label'             => esc_html__('Ticker', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
            ),
            'ticker_hover'    => array (
                'label'             => esc_html__('Ticker Pause On Hover', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'carousel_settings',
                'show_if'       => array (
                    'ticker'        => 'on'
                )
            ),
            'ticker_speed'    => array (
                'label'             => esc_html__( 'Animation Speed (ms)', 'divi_flash' ),
				'type'              => 'range',
				'toggle_slug'       => 'carousel_settings',
				'default'           => '4000',
                'default_unit'      => '',
                'allowed_units'     => array (''),
				'range_settings'    => array(
					'min'  => '100',
					'max'  => '30000',
					'step' => '50',
                ),
                'validate_unit'     => false,
                'show_if'           => array (
                    'ticker'        => 'on'
                )
            )
        );
        $arrow_color = array (
            'arrow_icon_color' => array (
                'default'           => "#2ea3f2",
				'label'             => esc_html__( 'Arrow Icon Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrow',
                'hover'             => 'tabs'
            ),
            'arrow_bg_color' => array (
                'default'           => "#ffffff",
				'label'             => esc_html__( 'Arrow Background Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'arrow',
                'hover'             => 'tabs'
            ),
            'arrow_opacity_disable'    => array (
                'label'             => esc_html__( 'Disabled Arrow Opacity', 'divi_flash' ),
                'description'       => esc_html__('Here you can define the opacity of the disabled arrow when the total slide ends.', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'arrow',
                'tab_slug'          => 'advanced',
                'default'           => '0.5',
                'range_settings'    => array(
                    'min'  => '0',
                    'max'  => '1',
                    'step' => '.01',
                ),
                'validate_unit'     => false,
                'hover'             => 'tabs',
                'show_if_not'       => array (
                    'loop'  => 'on'
                )
            ),
        );
        $dots_color = array (
            'active_dot_color' => array (
                'default'           => "#000000",
				'label'             => esc_html__( 'Active Dot Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dots',
                'hover'             => 'tabs'
            ),
            'dots_color' => array (
                'default'           => "#666666",
				'label'             => esc_html__( 'Dots Color', 'divi_flash' ),
				'type'              => 'color-alpha',
				'depends_show_if'   => 'on',
				'tab_slug'          => 'advanced',
                'toggle_slug'       => 'dots',
                'hover'             => 'tabs'
            )
        );
        $wrapper = $this->add_margin_padding(array(
            'title'         => 'Wrapper',
            'key'           => 'wrapper',
            'toggle_slug'   => 'margin_padding'
        ));
        $arrow_prev = $this->add_margin_padding(array(
            'title'         => 'Arrow Prev',
            'key'           => 'arrow_prev',
            'toggle_slug'   => 'arrow',
            'option'        => 'margin'
        ));
        $arrow_next = $this->add_margin_padding(array(
            'title'         => 'Arrow Next',
            'key'           => 'arrow_next',
            'toggle_slug'   => 'arrow',
            'option'        => 'margin'
        ));

        return array_merge(
            $image,
            $carousel_settings,
            $arrow_color,
            $dots_color,
            $wrapper,
            $arrow_prev,
            $arrow_next
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $prev_arrow = '%%order_class%% .bx-controls-direction .bx-prev';
        $next_arrow = '%%order_class%% .bx-controls-direction .bx-next';
        $dots = '%%order_class%% .bx-pager .bx-pager-item a';
        $dot_active = '%%order_class%% .bx-pager .bx-pager-item a.active';

        $fields['arrow_icon_color'] = array ('color' => $prev_arrow);
        $fields['arrow_icon_color'] = array ('color' => $next_arrow);

        $fields['arrow_bg_color'] = array ('background-color' => $prev_arrow);
        $fields['arrow_bg_color'] = array ('background-color' => $next_arrow);

        $fields['arrow_opacity_disable'] = array ('opacity' => '%%order_class%% .bx-controls-direction a.disabled');

        $fields['dots_color'] = array ('background' => $dots);
        $fields['active_dot_color'] = array ('background' => $dot_active);

        $field['wrapper_margin'] = array('margin' => '%%order_class%% .bx-viewport');
        $field['wrapper_padding'] = array('padding' => '%%order_class%% .bx-viewport');

        $field['arrow_prev_margin'] = array('margin' => '%%order_class%% .bx-prev');
        $field['arrow_next_margin'] = array('margin' => '%%order_class%% .bx-next');

        return $fields;
    }

    public function additional_css_styles($render_slug) {
        $this->df_process_range( array (
            'render_slug'       => $render_slug,
            'slug'              => 'lc_max_width',
            'type'              => 'max-width',
            'selector'          => '%%order_class%% .df_lci_container img',
            'default'           => '0%'
        ));
        if ( isset($this->props['lc_vertical']) && $this->props['equal_height'] !== 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .df_lc_container',
                'declaration' => sprintf('align-items: %1$s;',
                    $this->props['lc_vertical']
                )
            ));
        }
        if ( $this->props['equal_height'] === 'on' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .difl_logocarouselitem',
                'declaration' => 'height: auto; align-items: center;'
            ));
        }

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .bx-viewport',
            'hover'             => '%%order_class%% .bx-viewport:hover',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'wrapper_padding',
            'type'              => 'padding',
            'selector'          => '%%order_class%% .bx-viewport',
            'hover'             => '%%order_class%% .bx-viewport:hover',
        ));
        // arrow margin
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'arrow_prev_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .bx-prev',
            'hover'             => '%%order_class%%:hover .bx-prev',
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'arrow_next_margin',
            'type'              => 'margin',
            'selector'          => '%%order_class%% .bx-next',
            'hover'             => '%%order_class%%:hover .bx-next',
        ));

        $this->df_process_color(array (
            'render_slug'       => $render_slug,
            'slug'              => 'arrow_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .bx-controls-direction .bx-prev, %%order_class%% .bx-controls-direction .bx-next',
            'hover'             => '%%order_class%%:hover .bx-controls-direction .bx-prev, %%order_class%%:hover .bx-controls-direction .bx-next'
        ));
        $this->df_process_color(array (
            'render_slug'       => $render_slug,
            'slug'              => 'arrow_bg_color',
            'type'              => 'background-color',
            'selector'          => '%%order_class%% .bx-controls-direction .bx-prev, %%order_class%% .bx-controls-direction .bx-next',
            'hover'             => '%%order_class%%:hover .bx-controls-direction .bx-prev, %%order_class%%:hover .bx-controls-direction .bx-next'
        ));
        if( 'on' !== $this->props['loop'] ){
            $this->df_process_range( array(
                'render_slug'       => $render_slug,
                'slug'              => 'arrow_opacity_disable',
                'type'              => 'opacity',
                'selector'          => '%%order_class%% .bx-controls-direction a.disabled',
                'hover'             => '%%order_class%% .bx-controls-direction a.disabled:hover'
            ) );
        }
        $this->df_process_color(array (
            'render_slug'       => $render_slug,
            'slug'              => 'dots_color',
            'type'              => 'background',
            'selector'          => '%%order_class%% .bx-pager .bx-pager-item a',
            'hover'             => '%%order_class%% .bx-pager .bx-pager-item a:hover'
        ));
        $this->df_process_color(array (
            'render_slug'       => $render_slug,
            'slug'              => 'active_dot_color',
            'type'              => 'background',
            'selector'          => '%%order_class%% .bx-pager .bx-pager-item a.active',
            'hover'             => '%%order_class%% .bx-pager .bx-pager-item a.active:hover'
        ));
    }

    public function render( $attrs, $content, $render_slug ) {
        if ( $this->content === '' ) {
            return sprintf(
                '<h2 style="background:#eee; padding: 10px 20px;">Please <strong>Add New Logo Item.</strong> </h2>'
            );
        }
        // wp_enqueue_style('bxslider-style');
        wp_enqueue_script('bxslider-script');
        wp_enqueue_script('df-logocarousel');
        $this->additional_css_styles($render_slug);

        // filter for images
		if (array_key_exists('image', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['image'])) {
			$this->add_classname($this->generate_css_filters(
				$render_slug,
				'child_',
				self::$data_utils->array_get($this->advanced_fields['image']['css'], 'main', '%%order_class%%')
			));
		}

        $order_class 	= self::get_module_order_class( $render_slug );
        $order_number	= str_replace('_','',str_replace($this->slug,'', $order_class));

        $data = [
            'desktop' => $this->props['item_desktop'],
            'tablet' => $this->props['item_tablet'],
            'mobile' => $this->props['item_mobile'],
            'width' => $this->props['item_width'],
            'loop' => $this->props['loop'] === 'on' ? true : false,
            'spacingbetween' => $this->props['item_spacing'],
            'arrows' => $this->props['arrow'] === 'on' ? true : false,
            'dots' => $this->props['dots'] === 'on' ? true : false,
            'autoplay' => $this->props['autoplay'] === 'on' ? true : false,
            'auto_delay' => $this->props['autospeed'],
            'speed' => $this->props['speed'],
            'pause_hover' => $this->props['pause_hover'] === 'on' ? true : false,
            'ticker' => $this->props['ticker'],
            'ticker_hover' => $this->props['ticker_hover'] === 'on' ? true : false,
            'order' => $order_number,
            'ticker_speed' => $this->props['ticker_speed']
        ];

        return sprintf('<div class="df_lc_outer">
                <div class="df_lc_container" data-settings=\'%2$s\'>
                    %1$s
                </div>
            </div>',
            et_core_sanitized_previously( $this->content ), wp_json_encode($data)
        );
    }
}
new DIFL_LogoCarousel;
