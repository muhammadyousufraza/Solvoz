<?php
require_once ( __DIR__ . '/MenuLayout.php');

class DIFL_AdvancedMenu extends ET_Builder_Module
{
    public $slug       = 'difl_advancedmenu';
    public $vb_support = 'on';
    public $child_slug = 'difl_advancedmenuitem';
	public $icon_path;
    use DF_UTLS;
    use MenuLayout;

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'DiviFlash',
        'author_uri' => '',
    );

    public function init()
    {
        $this->name = esc_html__('Advanced Menu', 'divi_flash');
        $this->main_css_element = "%%order_class%%";
        $this->icon_path        =  DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/advanced-menu.svg';
    }

    public function get_settings_modal_toggles()
    {
        return array(
            'general'  => array(
                'toggles' => array(
                    'main_content'                      => esc_html__('Content', 'divi_flash'),
                    'settings'                          => esc_html__('Settings', 'divi_flash'),
                    'builder_view'                      => esc_html__('Builder View', 'divi_flash'),
                    'button'                            => esc_html__('Button', 'divi_flash'),
                    'image'                             => esc_html__('Image and Icon', 'divi_flash'),
                    'badge'                             => esc_html__('Badge', 'divi_flash'),
                    'item_order'                        => esc_html__('Item Order', 'divi_flash'),
                    'title_link'                        => esc_html__('Title Link', 'divi_flash')
                ),
            ),
            'advanced'  =>  array(
                'toggles'   =>  array(
                    'top_row'                 => esc_html__('Top Row Settings', 'divi_flash'),
                    'center_row'              => esc_html__('Center Row Settings', 'divi_flash'),
                    'bottom_row'              => esc_html__('Bottom Row Settings', 'divi_flash'),
                    'menu'                    => esc_html__('Menu', 'divi_flash')
                )
            ),

            // Advance tab's slug is "custom_css"
            'custom_css' => array(
                'toggles' => array(
                    'limitation' => esc_html__('Limitation', 'divi_flash'), // totally made up
                )
            ),
        );
    }
    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = false;

        $advanced_fields['borders'] = array(
            'default'       => true,
            'top_row'              => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .top-row",
                        'border_radii_hover' => "{$this->main_css_element} .top-row:hover",
                        'border_styles' => "{$this->main_css_element} .top-row",
                        'border_styles_hover' => "{$this->main_css_element} .top-row:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'top_row',
            ),
            'center_row'              => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .center-row",
                        'border_radii_hover' => "{$this->main_css_element} .center-row:hover",
                        'border_styles' => "{$this->main_css_element} .center-row",
                        'border_styles_hover' => "{$this->main_css_element} .center-row:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'center_row',
            ),
            'bottom_row'              => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .bottom-row",
                        'border_radii_hover' => "{$this->main_css_element} .bottom-row:hover",
                        'border_styles' => "{$this->main_css_element} .bottom-row",
                        'border_styles_hover' => "{$this->main_css_element} .bottom-row:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'bottom_row',
            ),
        );
        
        return $advanced_fields;
    }

    public function get_fields(){
        $general = array();
        $content = array();

        $settings = array(
            'break_point'   => array(
                'label'             => esc_html__('Menu Break Point', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'settings',
                'default'           => '980',
                'default_unit'      => '',
                'allowed_units'     => array(''),
                // 'fixed_unit'        => 'px',
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '1500',
                    'step' => '1',
                ),
                'validate_unit'     => false,
            )
        );
        $mslide_background = $this->df_background_settings(array(
            'title' => esc_html__('Mobile Slide Background', 'divi_flash'),
            'option_name' => 'mslide_bg', 
            'tab_slug' => 'general', 
            'toggle_slug' => 'settings'
        ));

        $builder_view = array(
            'show_mobile_slide'  => array(
                'label'               => esc_html__( 'Show Mobile Slide on Builder', 'divi_flash'),
                'type'                => 'yes_no_button',
                'tab_slug'            => 'general',
                'toggle_slug'         => 'builder_view',
                'default'             => 'off',
                'options'             => array(
                    'off'         => esc_html__('No', 'divi_flash'),
                    'on'          => esc_html__('Yes', 'divi_flash')
                ),
                'default_on_front' => 'off',
            )
        );
        $top_row = array_merge(
            array(
                'trow_hide_on_sticky'  => array(
                    'label'               => esc_html__( 'Hide When Sticky', 'divi_flash'),
                    'type'                => 'yes_no_button',
                    'tab_slug'            => 'advanced',
                    'toggle_slug'         => 'top_row',
                    'default'             => 'off',
                    'options'             => array(
                        'off'         => esc_html__('No', 'divi_flash'),
                        'on'          => esc_html__('Yes', 'divi_flash')
                    ),
                    'default_on_front' => 'off',
                )
            ),
            $this->df_background_settings(array(
                'option_name' => 'top_row_bg', 
                'tab_slug' => 'advanced', 
                'toggle_slug' => 'top_row'
            )),
            array(
                'top_row_inner_width'    => array(
                    'label'             => esc_html__('Inner Wrapper Max Width', 'divi_flash'),
                    'type'              => 'range',
                    'toggle_slug'       => 'top_row',
                    'tab_slug'          => 'advanced',
                    'default'           => '100%',
                    'default_unit'      => '%',
                    'allowed_units'     => array('px', '%', 'em', 'vh', 'vw'),
                    'range_settings'    => array(
                        'min'  => '1',
                        'max'  => '100',
                        'step' => '1',
                    ),
                    'validate_unit'     => true,
                    'responsive'        => true,
                    'mobile_options'    => true,
                ),
            ),
            $this->add_margin_padding(array(
                'title'         => '',
                'key'           => 'top_row',
                'toggle_slug'   => 'top_row',
                'tab_slug'      => 'advanced'
            ))
        );
        
        
        $center_row = array_merge(
            array(
                'crow_hide_on_sticky'  => array(
                    'label'               => esc_html__( 'Hide When Sticky', 'divi_flash'),
                    'type'                => 'yes_no_button',
                    'tab_slug'            => 'advanced',
                    'toggle_slug'         => 'center_row',
                    'default'             => 'off',
                    'options'             => array(
                        'off'         => esc_html__('No', 'divi_flash'),
                        'on'          => esc_html__('Yes', 'divi_flash')
                    ),
                    'default_on_front' => 'off',
                )
            ),
            $this->df_background_settings(array(
                'option_name' => 'center_row_bg', 
                'tab_slug' => 'advanced', 
                'toggle_slug' => 'center_row'
            )),
            array(
                'center_row_inner_width'    => array(
                    'label'             => esc_html__('Inner Wrapper Max Width', 'divi_flash'),
                    'type'              => 'range',
                    'toggle_slug'       => 'center_row',
                    'tab_slug'          => 'advanced',
                    'default'           => '100%',
                    'default_unit'      => '%',
                    'allowed_units'     => array('px', '%', 'em', 'vh', 'vw'),
                    'range_settings'    => array(
                        'min'  => '1',
                        'max'  => '100',
                        'step' => '1',
                    ),
                    'validate_unit'     => true,
                    'responsive'        => true,
                    'mobile_options'    => true,
                ),
            ),
            $this->add_margin_padding(array(
                'title'         => '',
                'key'           => 'center_row',
                'toggle_slug'   => 'center_row',
                'tab_slug'      => 'advanced'
            ))
        );

        $bottom_row = array_merge(
            array(
                'brow_hide_on_sticky'  => array(
                    'label'               => esc_html__( 'Hide When Sticky', 'divi_flash'),
                    'type'                => 'yes_no_button',
                    'tab_slug'            => 'advanced',
                    'toggle_slug'         => 'bottom_row',
                    'default'             => 'off',
                    'options'             => array(
                        'off'         => esc_html__('No', 'divi_flash'),
                        'on'          => esc_html__('Yes', 'divi_flash')
                    ),
                    'default_on_front' => 'off',
                )
            ),
            $this->df_background_settings(array(
                'option_name' => 'bottom_row_bg', 
                'tab_slug' => 'advanced', 
                'toggle_slug' => 'bottom_row'
            )),
            array(
                'bottom_row_inner_width'    => array(
                    'label'             => esc_html__('Inner Wrapper Max Width', 'divi_flash'),
                    'type'              => 'range',
                    'toggle_slug'       => 'bottom_row',
                    'tab_slug'          => 'advanced',
                    'default'           => '100%',
                    'default_unit'      => '%',
                    'allowed_units'     => array('px', '%', 'em', 'vh', 'vw'),
                    'range_settings'    => array(
                        'min'  => '1',
                        'max'  => '100',
                        'step' => '1',
                    ),
                    'validate_unit'     => true,
                    'responsive'        => true,
                    'mobile_options'    => true,
                ),
            ),
            $this->add_margin_padding(array(
                'title'         => '',
                'key'           => 'bottom_row',
                'toggle_slug'   => 'bottom_row',
                'tab_slug'      => 'advanced'
            ))
        );

        return array_merge(
            $general,
            $content,
            $settings,
            $mslide_background,
            $builder_view,

            $top_row,
            $center_row,
            $bottom_row
        );
    } 
    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();
        $top_row = '%%order_class%% .top-row';
        $center_row = '%%order_class%% .center-row';
        $bottom_row = '%%order_class%% .bottom-row';

        // spacing
        $fields['top_row_margin'] = array('margin' => $top_row);
        $fields['top_row_padding'] = array('padding' => $top_row);
        $fields['center_row_margin'] = array('margin' => $center_row);
        $fields['center_row_padding'] = array('padding' => $center_row);
        $fields['bottom_row_margin'] = array('margin' => $bottom_row);
        $fields['bottom_row_padding'] = array('padding' => $bottom_row);

        // color
        // $fields['ofc_close_icon_color'] = array('color' => '%%order_class%%_ofc .df-ofc-close');

        $fields = $this->df_process_new_background_transition($fields, 'top_row_bg', $top_row);
        $fields = $this->df_process_new_background_transition($fields, 'center_row_bg', $center_row);
        $fields = $this->df_process_new_background_transition($fields, 'bottom_row_bg', $bottom_row);
        $fields = $this->df_process_new_background_transition($fields, 'mslide_bg', '%%order_class%% .df-mobile-menu-wrap .df-mobile-menu');

        return $fields;
    }
    public function additional_css_styles($render_slug, $attrs){
        $break_point_max = sprintf('@media only screen and ( max-width: %1$spx )', 
            $this->props['break_point']);
        $break_point_min = sprintf('@media only screen and ( min-width: %1$spx )', 
            intval($this->props['break_point']) + 1);
        $top_row = '%%order_class%% .top-row';
        $top_row_hover = '%%order_class%% .top-row:hover';
        $center_row = '%%order_class%% .center-row';
        $center_row_hover = '%%order_class%% .center-row:hover';
        $bottom_row = '%%order_class%% .bottom-row';
        $bottom_row_hover = '%%order_class%% .bottom-row:hover';

        
        

        // menu break point
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "%%order_class%% .df-am-container:not(.small-device)",
            'declaration' => 'display: none;',
            'media_query' => $break_point_max,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "%%order_class%% .df-am-container.small-device",
            'declaration' => 'display: none;',
            'media_query' => $break_point_min,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "%%order_class%% .df-am-container.small-device",
            'declaration' => 'display: block !important;',
            'media_query' => $break_point_max,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "%%order_class%% .df-normal-menu-wrap",
            'declaration' => 'display: none;',
            'media_query' => $break_point_max,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "%%order_class%% .df-mobile-menu-button",
            'declaration' => 'display: none;',
            'media_query' => $break_point_min,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "%%order_class%% .df-mobile-menu-wrap",
            'declaration' => 'display: none;',
            'media_query' => $break_point_min,
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => "%%order_class%% .hide_from_small",
            'declaration' => 'display: none;',
            'media_query' => $break_point_max,
        ));

        // background
        $this->props = array_merge($attrs , $this->props);

        $this->df_process_new_background_styles(
            array(
                'props' => $this->props, 
                'key' => 'top_row_bg', 
                'selector' => $top_row, 
                'hover' => $top_row_hover
            )
        );
        $this->df_process_new_background_styles(
            array(
                'props' => $this->props, 
                'key' => 'center_row_bg', 
                'selector' => $center_row, 
                'hover' => $center_row_hover
            )
        );
        $this->df_process_new_background_styles(
            array(
                'props' => $this->props, 
                'key' => 'bottom_row_bg', 
                'selector' => $bottom_row, 
                'hover' => $bottom_row_hover
            )
        );
        $this->df_process_new_background_styles(
            array(
                'props' => $this->props, 
                'key' => 'mslide_bg', 
                'selector' => '%%order_class%% .df-mobile-menu-wrap .df-mobile-menu', 
                'hover' => '%%order_class%% .df-mobile-menu-wrap .df-mobile-menu:hover'
            )
        );
        // spacing
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'top_row_margin',
            'type'              => 'margin',
            'selector'          => $top_row,
            'hover'             => $top_row_hover,
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'top_row_padding',
            'type'              => 'padding',
            'selector'          => $top_row,
            'hover'             => $top_row_hover,
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'center_row_margin',
            'type'              => 'margin',
            'selector'          => $center_row,
            'hover'             => $center_row_hover,
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'center_row_padding',
            'type'              => 'padding',
            'selector'          => $center_row,
            'hover'             => $center_row_hover,
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'bottom_row_margin',
            'type'              => 'margin',
            'selector'          => $bottom_row,
            'hover'             => $bottom_row_hover,
            'important'         => false
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'bottom_row_padding',
            'type'              => 'padding',
            'selector'          => $bottom_row,
            'hover'             => $bottom_row_hover,
            'important'         => false
        ));

        // sizing
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'top_row_inner_width',
            'type'              => 'max-width',
            'selector'          => $top_row . ' .row-inner',
            'important'         => false
        ));
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'center_row_inner_width',
            'type'              => 'max-width',
            'selector'          => $center_row . ' .row-inner',
            'important'         => false
        ));
        $this->df_process_range(array(
            'render_slug'       => $render_slug,
            'slug'              => 'bottom_row_inner_width',
            'type'              => 'max-width',
            'selector'          => $bottom_row . ' .row-inner',
            'important'         => false
        ));
    }

    public function render($attrs, $content, $render_slug) { 
        global $df_menu, $df_menu_mobile;
        $menu_index = ET_Builder_Element::get_module_order_class( $render_slug );
        $layout = $this->render_menu_layout($df_menu, $menu_index);
        $layoutSmall = $this->render_menu_layout($df_menu_mobile, $menu_index, 'small');
        $mobile_layout = $this->render_mobile_slide_items($df_menu, $menu_index);

        wp_enqueue_script('df-flexmasonry');
        wp_enqueue_script('df-menu-ext-script');

        $df_menu = array();
        $df_menu_mobile = array();

        $this->additional_css_styles($render_slug, $attrs);
        $this->background_sticky_style_fix($render_slug);

        return sprintf('
                <div class="df-am-container">
                    %1$s
                </div>
                <div class="df-am-container small-device" style="display: none;">
                    %5$s
                </div>
                <div class="df-mobile-menu-wrap">
                    <div class="df-mobile-menu %3$s_mobile_menu">
                        <div class="mobile-slide-inner-wrap">%4$s%2$s</div>
                    </div>
                </div>
            ', 
            $layout, 
            $mobile_layout, 
            $menu_index,
            $this->mobile_slide,
            $layoutSmall
        );
    }

    public function background_sticky_style_fix($render_slug) {
        $props = $this->props;

        if(isset($props['background__sticky_enabled']) && $props['background__sticky_enabled'] == 'on|sticky') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => ".et_pb_sticky%%order_class%%",
                'declaration' => sprintf('background-color: %1$s;', $props['background_color__sticky'])
            ));

            $background_color_gradient_stops__sticky = explode("|", $props['background_color_gradient_stops__sticky']);

            $background_color_gradient_stops__sticky = implode(",", $background_color_gradient_stops__sticky);

            $bg_gra = $props['background_color_gradient_type'] == 'linear' ?
                sprintf('linear-gradient(%2$s,%1$s)', 
                $background_color_gradient_stops__sticky,
                $props['background_color_gradient_direction__sticky']
                ) : '';
                
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => ".et_pb_sticky%%order_class%%",
                'declaration' => sprintf('background-image: %1$s;', $bg_gra)
            ));
        }
    }
}

new DIFL_AdvancedMenu;