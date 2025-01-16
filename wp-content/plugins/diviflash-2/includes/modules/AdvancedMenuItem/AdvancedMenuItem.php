<?php

class DIFL_AdvancedMenuItem extends ET_Builder_Module
{
	use \DIFL\Fa_Icon_Handler;

    public $slug       = 'difl_advancedmenuitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var  = 'admin_label';
    public $child_title_fallback_var = 'menu_item_label';
    use DF_UTLS;
	public $menu_item, $menu_item_hover, $menu_item_icon, $menu_item_icon_hover, $only_submenu_parent_container, $only_submenu_parent_container_hover, $submenu_container, $submenu_container_hover, $submenu_item, $submenu_item_hover, $submenu_item_icon, $submenu_item_icon_hover, $mega_menu_contianer, $mega_menu_contianer_hover, $mega_menu_item, $mega_menu_item_hover, $mega_menu_item_icon, $mega_menu_item_icon_hover, $first_level_parent, $second_level_parent, $third_level_parent, $first_level_parent_hover, $second_level_parent_hover, $third_level_parent_hover, $first_level_child, $second_level_child, $third_level_child, $first_level_child_hover, $second_level_child_hover, $third_level_child_hover, $first_level_parent_icon, $second_level_parent_icon, $third_level_parent_icon, $first_level_parent_icon_hover, $second_level_parent_icon_hover, $third_level_parent_icon_hover, $first_level_child_icon, $second_level_child_icon, $third_level_child_icon, $first_level_child_icon_hover, $second_level_child_icon_hover, $third_level_child_icon_hover, $mslide_item, $mslide_item_hover, $mslide_trigger_button, $mslide_trigger_button_hover, $mslide_button, $mslide_button_hover;

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'DiviFlash',
        'author_uri' => '',
    );

    public function init()
    {
        $this->name = esc_html__('Advanced Menu Item', 'divi_flash');
        $this->main_css_element = "%%order_class%%";

        $this->menu_item = '%%order_class%% .df-normal-menu-wrap .df-menu-nav>li.menu-item>a';
        $this->menu_item_hover = '%%order_class%% .df-normal-menu-wrap .df-menu-nav>li.menu-item:hover>a';
        $this->menu_item_icon = '%%order_class%% .df-normal-menu-wrap .df-menu-nav>li.menu-item>a .df-menu-icon';
        $this->menu_item_icon_hover = '%%order_class%% .df-normal-menu-wrap .df-menu-nav>li.menu-item:hover>a .df-menu-icon';

        $this->only_submenu_parent_container = '%%order_class%% .df-normal-menu-wrap .sub-menu:not(.df-inside-mega-menu)';
        $this->only_submenu_parent_container_hover = '%%order_class%% .df-normal-menu-wrap .sub-menu:not(.df-inside-mega-menu):hover';

        $this->submenu_container = '%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-inside-mega-menu):not(.df-mega-menu-item)';
        $this->submenu_container_hover = '%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-inside-mega-menu):not(.df-mega-menu-item):hover';
        $this->submenu_item = '%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) li.menu-item>a';
        $this->submenu_item_hover = '%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) li.menu-item:hover>a';
        $this->submenu_item_icon = '%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) .df-menu-icon';
        $this->submenu_item_icon_hover = '%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu)>li:hover>a .df-menu-icon';

        $this->mega_menu_contianer = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu>ul";
        $this->mega_menu_contianer_hover = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu>ul:hover";
	    $this->mega_menu_item = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu ul.df-inside-mega-menu li>a";
	    $this->mega_menu_item_hover = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu ul.df-inside-mega-menu li>a:hover";
	    $this->mega_menu_item_icon = '%%order_class%% .df-normal-menu-wrap li.df-mega-menu>ul.sub-menu:not(.df-custom-submenu) .df-menu-icon';
	    $this->mega_menu_item_icon_hover = '%%order_class%% .df-normal-menu-wrap li.df-mega-menu>ul.sub-menu:not(.df-custom-submenu) li:hover>a .df-menu-icon';
//	    $this->sub_mega_menu_header = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu li>a:not(.df-inside-mega-menu)";
//	    $this->sub_mega_menu_header_hover = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu li>a:not(.df-inside-mega-menu):hover";

	    $this->first_level_parent        = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-0:not(.df-menu-nav-level-1) > li.menu-item-has-children > a";
	    $this->second_level_parent       = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > div > li.menu-item-has-children > a, {$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > li.menu-item-has-children > a";
	    $this->third_level_parent        = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-2:not(.df-menu-nav-level-3) > li.menu-item-has-children > a";
	    $this->first_level_parent_hover  = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-0:not(.df-menu-nav-level-1) > li.menu-item-has-children > a:hover";
	    $this->second_level_parent_hover = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > div > li.menu-item-has-children > a:hover, {$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > li.menu-item-has-children > a:hover";
	    $this->third_level_parent_hover  = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-2:not(.df-menu-nav-level-3) > li.menu-item-has-children > a:hover";

	    $this->first_level_child        = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > li:not(.menu-item-has-children) > a, .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > div > li:not(.menu-item-has-children) > a";
	    $this->second_level_child       = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-2:not(.df-menu-nav-level-3) > li:not(.menu-item-has-children) > a";
	    $this->third_level_child        = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-3 > li:not(.menu-item-has-children) > a";
	    $this->first_level_child_hover  = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > li:not(.menu-item-has-children) > a:hover, {$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > div > li:not(.menu-item-has-children) > a:hover";
	    $this->second_level_child_hover = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-2:not(.df-menu-nav-level-3) > li:not(.menu-item-has-children) > a";
	    $this->third_level_child_hover  = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-3 > li:not(.menu-item-has-children) > a";

	    $this->first_level_parent_icon        = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-0:not(.df-menu-nav-level-1) > li.menu-item-has-children > a > .df-menu-icon";
	    $this->second_level_parent_icon       = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > div > li.menu-item-has-children > a > .df-menu-icon, {$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > li.menu-item-has-children > a > .df-menu-icon";
	    $this->third_level_parent_icon        = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-2:not(.df-menu-nav-level-3) > li.menu-item-has-children > a > .df-menu-icon";
	    $this->first_level_parent_icon_hover  = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-0:not(.df-menu-nav-level-1) > li.menu-item-has-children > a > .df-menu-icon:hover";
	    $this->second_level_parent_icon_hover = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > div > li.menu-item-has-children > a > .df-menu-icon:hover, {$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > li.menu-item-has-children > a > .df-menu-icon:hover";
	    $this->third_level_parent_icon_hover  = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-2:not(.df-menu-nav-level-3) > li.menu-item-has-children > a > .df-menu-icon:hover";

	    $this->first_level_child_icon        = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > li:not(.menu-item-has-children) > a > .df-menu-icon, .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > div > li:not(.menu-item-has-children) > a > .df-menu-icon";
	    $this->second_level_child_icon       = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-2:not(.df-menu-nav-level-3) > li:not(.menu-item-has-children) > a > .df-menu-icon";
	    $this->third_level_child_icon        = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-3 > li:not(.menu-item-has-children) > a > .df-menu-icon";
	    $this->first_level_child_icon_hover  = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > li:not(.menu-item-has-children) > a > .df-menu-icon:hover, {$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-1:not(.df-menu-nav-level-2) > div > li:not(.menu-item-has-children) > a > .df-menu-icon:hover";
	    $this->second_level_child_icon_hover = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-2:not(.df-menu-nav-level-3) > li:not(.menu-item-has-children) > a > .df-menu-icon";
	    $this->third_level_child_icon_hover  = "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap ul.df-menu-nav-level-3 > li:not(.menu-item-has-children) > a > .df-menu-icon";

        $this->mslide_item = '.df-mobile-menu %%order_class%% li.menu-item>a';
        $this->mslide_item_hover = '.df-mobile-menu %%order_class%% li.menu-item>a:hover';
        $this->mslide_trigger_button = '%%order_class%% .df-mobile-menu-button';
        $this->mslide_trigger_button_hover = '%%order_class%% .df-mobile-menu-button:hover';
        $this->mslide_button = '%%order_class%%_mslide_btn';
        $this->mslide_button_hover = '%%order_class%%_mslide_btn:hover';
    }

    public function get_settings_modal_toggles()
    {
        return array(
            'general'  => array(
                'toggles' => array(
                    'main_content'                      => esc_html__('Content', 'divi_flash'),

                    'divider'                           => esc_html__('Divider', 'divi_flash'),
                    'search'                            => esc_html__('Search', 'divi_flash'),
                    'icon_button'                       => esc_html__('Icon Box', 'divi_flash'),
                    'menu'                              => esc_html__('Menu', 'divi_flash'),
                    'menu_item_hover'                   => esc_html__('Menu Item Hover Animation', 'divi_flash'),
                    'logo'                              => esc_html__('Logo', 'divi_flash'),
                    'button'                            => esc_html__('Button', 'divi_flash'),
                    'custom_text'                       => esc_html__('Custom Text', 'divi_flash'),
                    'social'                            => esc_html__('Social', 'divi_flash'),
                    'cart'                              => esc_html__('Woo Cart', 'divi_flash'),

                    'mm_trigger'                        => esc_html__('Mobile Menu Trigger Button', 'divi_flash'),
                    'mobile_slide_button'             => esc_html__('Mobile Slide Elements', 'divi_flash'),
                    'df_disabled_on'                       => esc_html__('Disabled On', 'divi_flash'),
                ),
            ),
            'advanced'  =>  array(
                'toggles'   =>  array(
                    'text'                      => esc_html__('Text', 'divi_flash'),
                    'design_content'            => array(
                        'title' => esc_html__('Text Style', 'divi_flash'),
                        // Groups can be organized into tab
                        'tabbed_subtoggles' => true,
                        // Subtoggle tab configuration. Add `sub_toggle` attribute on field to put them here
                        'sub_toggles' => array(
                            'body'     => array(
                                'name' => 'P',
                                'icon' => 'text-left',
                            ),
                            'link'     => array(
                                'name' => 'A',
                                'icon' => 'text-link',
                            ),
                            'unorder_list'     => array(
                                'name' => 'A',
                                'icon' => 'list',
                            ),
                            'order_list'     => array(
                                'name' => 'A',
                                'icon' => 'numbered-list',
                            ),
                            'quote' => array(
                                'name' => 'QUOTE',
                                'icon' => 'text-quote',
                            ),
                            'search' => array(
                                'name' => '',
                                'icon' => 'search-box',
                            )
                        ),
                    ),
                    'design_form'               => array(
                        'title' => esc_html__('Form Text', 'divi_flash'),
                        // Groups can be organized into tab
                        'tabbed_subtoggles' => false,
                        // Subtoggle tab configuration. Add `sub_toggle` attribute on field to put them here
                        'sub_toggles' => array(
                            'input'     => array(
                                'name' => 'Input'
                            ),
                            'submit'     => array(
                                'name' => 'Submit'
                            )
                        ),
                    ),
                    'design_menu'               => esc_html__('Desktop Top Level Menu Items', 'divi_flash'),
                    'submenu'                   => array(
                        'title'                 => esc_html__('Submenu', 'divi_flash'),
                        'tabbed_subtoggles'     => true,
                        'sub_toggles' => array(
                            'container'     => array(
                                'name' => 'Container',
                            ),
                            'item'     => array(
                                'name' => 'Item',
                            ),
                        ),
                    ),
                    'mega_menu'                 => array(
                        'title'                 => esc_html__('Mega Menu', 'divi_flash'),
                        'tabbed_subtoggles'     => true,
                        'sub_toggles' => array(
                            'container'     => array(
                                'name' => 'Container',
                            ),
                            'item'     => array(
                                'name' => 'Item',
                            ),
                        ),
                    ),
                    'menu_parents'              => array(
	                    'title'             => esc_html__( 'Menu Parents', 'divi_flash' ),
	                    'tabbed_subtoggles' => true,
	                    'sub_toggles'       => array(
		                    'first_parent'  => array(
			                    'name' => '1st',
		                    ),
		                    'second_parent' => array(
			                    'name' => '2nd',
		                    ),
		                    'third_parent'  => array(
			                    'name' => '3rd',
		                    ),
	                    ),
                    ),
                    'menu_parents_icon'         => array(
	                    'title'             => esc_html__( 'Menu Parents Icon', 'divi_flash' ),
	                    'tabbed_subtoggles' => true,
	                    'sub_toggles'       => array(
		                    'first_parent'  => array(
			                    'name' => '1st',
		                    ),
		                    'second_parent' => array(
			                    'name' => '2nd',
		                    ),
		                    'third_parent'  => array(
			                    'name' => '3rd',
		                    ),
	                    ),
                    ),
                    'menu_childs'               => array(
	                    'title'             => esc_html__( 'Menu Childs', 'divi_flash' ),
	                    'tabbed_subtoggles' => true,
	                    'sub_toggles'       => array(
		                    'first_child'  => array(
			                    'name' => '1st',
		                    ),
		                    'second_child' => array(
			                    'name' => '2nd',
		                    ),
		                    'third_child'    => array(
			                    'name' => '3rd',
		                    ),
	                    ),
                    ),
                    'menu_childs_icon'          => array(
	                    'title'             => esc_html__( 'Menu Childs Icon', 'divi_flash' ),
	                    'tabbed_subtoggles' => true,
	                    'sub_toggles'       => array(
		                    'first_child'  => array(
			                    'name' => '1st',
		                    ),
		                    'second_child' => array(
			                    'name' => '2nd',
		                    ),
		                    'third_child'  => array(
			                    'name' => '3rd',
		                    ),
	                    ),
                    ),
                    'active_state'              => array(
                        'title'                 => esc_html__('Active State', 'divi_flash'),
                        'tabbed_subtoggles'     => true,
                        'sub_toggles' => array(
                            'top_level'     => array(
                                'name' => 'Menu',
                            ),
                            'sub_menu'     => array(
                                'name' => 'Sub Menu',
                            ),
                        ),
                    ),
                    'mobile_slide'              => array(
                        'title'                 => esc_html__('Mobile Slide', 'divi_flash'),
                        'tabbed_subtoggles'     => true,
                        'sub_toggles' => array(
                            'item'     => array(
                                'name' => 'Item',
                            ),
                            'button'     => array(
                                'name' => 'Button',
                            ),
                        ),
                    ),
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
        $advanced_fields['text_shadow'] = false;
        $advanced_fields['fonts']   = array(
            'content_body'   => array(
                'label'         => esc_html__('Body', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'sub_toggle'  => 'body',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% ",
                    'hover' => "%%order_class%%:hover",
                    'important' => 'all',
                ),
            ),

            'content_link'   => array(
                'label'         => esc_html__('Body Link', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'sub_toggle'  => 'link',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% a",
                    'hover' => "%%order_class%% a:hover",
                    'important' => 'all',
                ),
            ),

            'content_unorder_list'   => array(
                'label'         => esc_html__('Body Unorder List', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'sub_toggle'  => 'unorder_list',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% ul li",
                    'hover' => "%%order_class%% ul li:hover",
                    'important' => 'all',
                ),
            ),

            'content_order_list'   => array(
                'label'         => esc_html__('Body Order List', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'sub_toggle'  => 'order_list',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% ol li",
                    'hover' => "%%order_class%% .df_ab_blurb_description ol li:hover",
                    'important' => 'all',
                ),
            ),

            'content_quote'   => array(
                'label'         => esc_html__('Body Blockquote', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'sub_toggle'  => 'quote',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% blockquote",
                    'hover' => "%%order_class%% blockquote:hover",
                    'important' => 'all',
                ),
            ),

            'content_input'   => array(
                // 'label'         => esc_html__('', 'divi_flash'),
                'toggle_slug'   => 'design_content',
                'sub_toggle'  => 'search',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%% form [type='text'], 
                        %%order_class%% form [type='text']::placeholder,
                        %%order_class%%_modal form [type='text'],
                        %%order_class%%_modal form [type='text']::placeholder,
                        %%order_class%%_modal [type='text']",
                    'hover' => "%%order_class%% form [type='text']:hover, %%order_class%%_modal [type='text']:hover",
                    'important' => 'all',
                ),
                'hide_line_height' => true,
                'hide_text_shadow' => true,
                'hide_letter_spacing' => true,
                'hide_text_align' => true,
            ),
            'menu_items'   => array(
                'label'         => esc_html__('', 'divi_flash'),
                'tab_slug'   => 'advanced',
                'toggle_slug'   => 'design_menu',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => $this->menu_item,
                    'hover' => $this->menu_item_hover,
                ),
                'hide_text_shadow' => true,
                'hide_letter_spacing' => true,
                'hide_text_align' => true,
            ),
            'submenu_items'   => array(
                'label'         => esc_html__('', 'divi_flash'),
                'tab_slug'   => 'advanced',
                'toggle_slug'   => 'submenu',
                'sub_toggle'    => 'item',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => $this->submenu_item,
                    'hover' => $this->submenu_item_hover,
                ),
                'hide_text_shadow' => true,
                'hide_letter_spacing' => true,
                'hide_text_align' => true,
            ),
            'mslide_items'   => array(
                'label'         => esc_html__('', 'divi_flash'),
                'tab_slug'   => 'advanced',
                'toggle_slug'   => 'mobile_slide',
                'sub_toggle'    => 'item',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => $this->mslide_item,
                    'hover' => $this->mslide_item_hover,
                    'important' => 'all',
                ),
                'hide_text_shadow' => true,
                'hide_letter_spacing' => true,
                'hide_text_align' => true,
            ),
            'mslide_button'   => array(
                'label'         => esc_html__('', 'divi_flash'),
                'tab_slug'   => 'advanced',
                'toggle_slug'     => 'mobile_slide',
                'sub_toggle'      => 'button',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => "%%order_class%%_mslide_btn.df-mobile-button",
                    'hover' => "%%order_class%%_mslide_btn.df-mobile-button:hover",
                    'important' => 'all',
                ),
                'hide_text_shadow' => true,
                'hide_letter_spacing' => true,
                'hide_text_align' => true,
            ),
            'megamenu_item'   => array(
                'label'         => esc_html__('', 'divi_flash'),
                'tab_slug'   => 'advanced',
                'toggle_slug'   => 'mega_menu',
                'sub_toggle' => 'item',
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => $this->mega_menu_item,
                    'hover' => $this->mega_menu_item_hover,
                    'important' => 'all',
                ),
                'hide_text_shadow' => true,
                'hide_letter_spacing' => true,
                'hide_text_align' => true,
            ),
            'first_level_parent'  => array(
	            'label'               => esc_html__( '', 'divi_flash' ),
	            'tab_slug'            => 'advanced',
	            'toggle_slug'         => 'menu_parents',
	            'sub_toggle'          => 'first_parent',
	            'line_height'         => array(
		            'default' => '1em',
	            ),
	            'font_size'           => array(
		            'default' => '14px',
	            ),
	            'css'                 => array(
		            'main'      => $this->first_level_parent,
		            'hover'     => $this->first_level_parent_hover,
		            'important' => 'all',
	            ),
	            'hide_text_shadow'    => true,
	            'hide_letter_spacing' => true,
	            'hide_text_align'     => true,
            ),
            'second_level_parent' => array(
	            'label'               => esc_html__( '', 'divi_flash' ),
	            'tab_slug'            => 'advanced',
	            'toggle_slug'         => 'menu_parents',
	            'sub_toggle'          => 'second_parent',
	            'line_height'         => array(
		            'default' => '1em',
	            ),
	            'font_size'           => array(
		            'default' => '14px',
	            ),
	            'css'                 => array(
		            'main'      => $this->second_level_parent,
		            'hover'     => $this->second_level_parent_hover,
		            'important' => 'all',
	            ),
	            'hide_text_shadow'    => true,
	            'hide_letter_spacing' => true,
	            'hide_text_align'     => true,
            ),
            'third_level_parent'  => array(
	            'label'               => esc_html__( '', 'divi_flash' ),
	            'tab_slug'            => 'advanced',
	            'toggle_slug'         => 'menu_parents',
	            'sub_toggle'          => 'third_parent',
	            'line_height'         => array(
		            'default' => '1em',
	            ),
	            'font_size'           => array(
		            'default' => '14px',
	            ),
	            'css'                 => array(
		            'main'      => $this->third_level_parent,
		            'hover'     => $this->third_level_parent_hover,
		            'important' => 'all',
	            ),
	            'hide_text_shadow'    => true,
	            'hide_letter_spacing' => true,
	            'hide_text_align'     => true,
            ),
            'first_level_child'   => array(
	            'label'               => esc_html__( '', 'divi_flash' ),
	            'tab_slug'            => 'advanced',
	            'toggle_slug'         => 'menu_childs',
	            'sub_toggle'          => 'first_child',
	            'line_height'         => array(
		            'default' => '1em',
	            ),
	            'font_size'           => array(
		            'default' => '14px',
	            ),
	            'css'                 => array(
		            'main'      => $this->first_level_child,
		            'hover'     => $this->first_level_child_hover,
		            'important' => 'all',
	            ),
	            'hide_text_shadow'    => true,
	            'hide_letter_spacing' => true,
	            'hide_text_align'     => true,
            ),
            'second_level_child'  => array(
	            'label'               => esc_html__( '', 'divi_flash' ),
	            'tab_slug'            => 'advanced',
	            'toggle_slug'         => 'menu_childs',
	            'sub_toggle'          => 'second_child',
	            'line_height'         => array(
		            'default' => '1em',
	            ),
	            'font_size'           => array(
		            'default' => '14px',
	            ),
	            'css'                 => array(
		            'main'      => $this->second_level_child,
		            'hover'     => $this->second_level_child_hover,
		            'important' => 'all',
	            ),
	            'hide_text_shadow'    => true,
	            'hide_letter_spacing' => true,
	            'hide_text_align'     => true,
            ),
            'third_level_child'   => array(
	            'label'               => esc_html__( '', 'divi_flash' ),
	            'tab_slug'            => 'advanced',
	            'toggle_slug'         => 'menu_childs',
	            'sub_toggle'          => 'third_child',
	            'line_height'         => array(
		            'default' => '1em',
	            ),
	            'font_size'           => array(
		            'default' => '14px',
	            ),
	            'css'                 => array(
		            'main'      => $this->third_level_child,
		            'hover'     => $this->third_level_child_hover,
		            'important' => 'all',
	            ),
	            'hide_text_shadow'    => true,
	            'hide_letter_spacing' => true,
	            'hide_text_align'     => true,
            ),
        );

        $advanced_fields['box_shadow'] = array(
            'default'   => true,
            'mega_menu'      => array(
                'css' => array(
                    'main' => $this->mega_menu_contianer,
                    'hover' => $this->mega_menu_contianer_hover,
                    'important' => true
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'mega_menu',
                'sub_toggle'        => 'container'
            ),
            'mega_menu_item'      => array(
                'css' => array(
                    'main' => $this->mega_menu_contianer,
                    'hover' => $this->mega_menu_contianer_hover,
                    'important' => true
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'mega_menu',
                'sub_toggle'        => 'item'
            ),
            'submenu_container'      => array(
                'css' => array(
                    'main' => $this->submenu_container . " , %%order_class%% .df-normal-menu-wrap li .sub-menu.df-custom-submenu:not(.df-inside-mega-menu)",
                    'hover' => $this->submenu_container_hover . " , %%order_class%% .df-normal-menu-wrap li .sub-menu.df-custom-submenu:not(.df-inside-mega-menu)",
                    'important' => true
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'submenu',
                'sub_toggle'        => 'container',
            ),
            'first_level_parent'       => array(
	            'css'         => array(
		            'main'      => $this->first_level_parent,
		            'hover'     => $this->first_level_parent_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents',
	            'sub_toggle'  => 'first_parent',
            ),
            'second_level_parent'      => array(
	            'css'         => array(
		            'main'      => $this->second_level_parent,
		            'hover'     => $this->second_level_parent_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents',
	            'sub_toggle'  => 'second_parent',
            ),
            'third_level_parent'       => array(
	            'css'         => array(
		            'main'      => $this->third_level_parent,
		            'hover'     => $this->third_level_parent_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents',
	            'sub_toggle'  => 'third_parent',
            ),
            'first_level_parent_icon'  => array(
	            'css'         => array(
		            'main'      => $this->first_level_parent_icon,
		            'hover'     => $this->first_level_parent_icon_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents_icon',
	            'sub_toggle'  => 'first_parent',
            ),
            'second_level_parent_icon' => array(
	            'css'         => array(
		            'main'      => $this->second_level_parent_icon,
		            'hover'     => $this->second_level_parent_icon_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents_icon',
	            'sub_toggle'  => 'second_parent',
            ),
            'third_level_parent_icon'  => array(
	            'css'         => array(
		            'main'      => $this->third_level_parent_icon,
		            'hover'     => $this->third_level_parent_icon_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents_icon',
	            'sub_toggle'  => 'third_parent',
            ),
            'first_level_child'        => array(
	            'css'         => array(
		            'main'      => $this->first_level_child,
		            'hover'     => $this->first_level_child_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs',
	            'sub_toggle'  => 'first_child',
            ),
            'second_level_child'       => array(
	            'css'         => array(
		            'main'      => $this->second_level_child,
		            'hover'     => $this->second_level_child_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs',
	            'sub_toggle'  => 'second_child',
            ),
            'third_level_child'        => array(
	            'css'         => array(
		            'main'      => $this->third_level_child,
		            'hover'     => $this->third_level_child_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs',
	            'sub_toggle'  => 'third_child',
            ),
            'first_level_child_icon'   => array(
	            'css'         => array(
		            'main'      => $this->first_level_child_icon,
		            'hover'     => $this->first_level_child_icon_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs_icon',
	            'sub_toggle'  => 'first_child',
            ),
            'second_level_child_icon'  => array(
	            'css'         => array(
		            'main'      => $this->second_level_child_icon,
		            'hover'     => $this->second_level_child_icon_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs_icon',
	            'sub_toggle'  => 'second_child',
            ),
            'third_level_child_icon'   => array(
	            'css'         => array(
		            'main'      => $this->third_level_child_icon,
		            'hover'     => $this->third_level_child_icon_hover,
		            'important' => true
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs_icon',
	            'sub_toggle'  => 'third_child',
            ),
            'mslide_button_shadow'      => array(
                'css' => array(
                    'main' => "%%order_class%%_mslide_btn.df-mobile-button",
                    'hover' => "%%order_class%%_mslide_btn.df-mobile-button:hover",
                    'important' => true
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'mobile_slide',
                'sub_toggle'        => 'button',
            ),
        );

        $advanced_fields['borders'] = array(
            'default' => true,
            'mega_menu' => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => $this->mega_menu_contianer,
                        'border_radii_hover' => $this->mega_menu_contianer_hover,
                        'border_styles' => $this->mega_menu_contianer,
                        'border_styles_hover' => $this->mega_menu_contianer_hover,
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'mega_menu',
                'sub_toggle'        => 'container',
            ),
            'mega_menu_item' => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => $this->mega_menu_item,
                        'border_radii_hover' => $this->mega_menu_item_hover,
                        'border_styles' => $this->mega_menu_item,
                        'border_styles_hover' => $this->mega_menu_item_hover,
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'mega_menu',
                'sub_toggle'        => 'item'
            ),
            'menu_item' => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.menu-item>a",
                        'border_radii_hover' => "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.menu-item>a:hover",
                        'border_styles' => "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.menu-item>a",
                        'border_styles_hover' => "{$this->main_css_element} .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.menu-item>a:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'design_menu'
            ),
            'submenu_container' => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => $this->submenu_container . " , %%order_class%% .df-normal-menu-wrap li .sub-menu.df-custom-submenu:not(.df-inside-mega-menu)",
                        'border_radii_hover' => $this->submenu_container_hover . " , %%order_class%% .df-normal-menu-wrap li .sub-menu.df-custom-submenu:not(.df-inside-mega-menu):hover" ,
                        'border_styles' => $this->submenu_container . " , %%order_class%% .df-normal-menu-wrap li .sub-menu.df-custom-submenu:not(.df-inside-mega-menu)" ,
                        'border_styles_hover' => $this->submenu_container_hover . " , %%order_class%% .df-normal-menu-wrap li .sub-menu.df-custom-submenu:not(.df-inside-mega-menu):hover"
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'submenu',
                'sub_toggle'      => 'container',
            ),
            'submenu_item' => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => $this->submenu_item,
                        'border_radii_hover' => $this->submenu_item_hover,
                        'border_styles' => $this->submenu_item,
                        'border_styles_hover' => $this->submenu_item_hover,
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'submenu',
                'sub_toggle'      => 'item',
            ),
            'first_level_parent'       => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->first_level_parent,
			            'border_radii_hover'  => $this->first_level_parent_hover,
			            'border_styles'       => $this->first_level_parent,
			            'border_styles_hover' => $this->first_level_parent_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents',
	            'sub_toggle'  => 'first_parent',
            ),
            'second_level_parent'      => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->second_level_parent,
			            'border_radii_hover'  => $this->second_level_parent_hover,
			            'border_styles'       => $this->second_level_parent,
			            'border_styles_hover' => $this->second_level_parent_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents',
	            'sub_toggle'  => 'second_parent',
            ),
            'third_level_parent'       => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->third_level_parent,
			            'border_radii_hover'  => $this->third_level_parent_hover,
			            'border_styles'       => $this->third_level_parent,
			            'border_styles_hover' => $this->third_level_parent_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents',
	            'sub_toggle'  => 'third_parent',
            ),
            'first_level_parent_icon'  => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->first_level_parent_icon,
			            'border_radii_hover'  => $this->first_level_parent_icon_hover,
			            'border_styles'       => $this->first_level_parent_icon,
			            'border_styles_hover' => $this->first_level_parent_icon_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents_icon',
	            'sub_toggle'  => 'first_parent',
            ),
            'second_level_parent_icon' => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->second_level_parent_icon,
			            'border_radii_hover'  => $this->second_level_parent_icon_hover,
			            'border_styles'       => $this->second_level_parent_icon,
			            'border_styles_hover' => $this->second_level_parent_icon_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents_icon',
	            'sub_toggle'  => 'second_parent',
            ),
            'third_level_parent_icon'  => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->third_level_parent_icon,
			            'border_radii_hover'  => $this->third_level_parent_icon_hover,
			            'border_styles'       => $this->third_level_parent_icon,
			            'border_styles_hover' => $this->third_level_parent_icon_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_parents_icon',
	            'sub_toggle'  => 'third_parent',
            ),
            'first_level_child'        => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->first_level_child,
			            'border_radii_hover'  => $this->first_level_child_hover,
			            'border_styles'       => $this->first_level_child,
			            'border_styles_hover' => $this->first_level_child_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs',
	            'sub_toggle'  => 'first_child',
            ),
            'second_level_child'       => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->second_level_child,
			            'border_radii_hover'  => $this->second_level_child_hover,
			            'border_styles'       => $this->second_level_child,
			            'border_styles_hover' => $this->second_level_child_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs',
	            'sub_toggle'  => 'second_child',
            ),
            'third_level_child'        => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->third_level_child,
			            'border_radii_hover'  => $this->third_level_child_hover,
			            'border_styles'       => $this->third_level_child,
			            'border_styles_hover' => $this->third_level_child_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs',
	            'sub_toggle'  => 'third_child',
            ),
            'first_level_child_icon'   => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->first_level_child_icon,
			            'border_radii_hover'  => $this->first_level_child_icon_hover,
			            'border_styles'       => $this->first_level_child_icon,
			            'border_styles_hover' => $this->first_level_child_icon_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs_icon',
	            'sub_toggle'  => 'first_child',
            ),
            'second_level_child_icon'  => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->second_level_child_icon,
			            'border_radii_hover'  => $this->second_level_child_icon_hover,
			            'border_styles'       => $this->second_level_child_icon,
			            'border_styles_hover' => $this->second_level_child_icon_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs_icon',
	            'sub_toggle'  => 'second_child',
            ),
            'third_level_child_icon'   => array(
	            'css'         => array(
		            'main' => array(
			            'border_radii'        => $this->third_level_child_icon,
			            'border_radii_hover'  => $this->third_level_child_icon_hover,
			            'border_styles'       => $this->third_level_child_icon,
			            'border_styles_hover' => $this->third_level_child_icon_hover,
		            )
	            ),
	            'tab_slug'    => 'advanced',
	            'toggle_slug' => 'menu_childs_icon',
	            'sub_toggle'  => 'third_child',
            ),
            'mslide_item' => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => ".df-mobile-menu {$this->main_css_element} li.menu-item>a",
                        'border_radii_hover' => ".df-mobile-menu {$this->main_css_element} li.menu-item>a:hover",
                        'border_styles' => ".df-mobile-menu {$this->main_css_element} li.menu-item>a",
                        'border_styles_hover' => ".df-mobile-menu {$this->main_css_element} li.menu-item>a:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'mobile_slide',
                'sub_toggle'      => 'item',
            ),
            'mslide_button' => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => "%%order_class%%_mslide_btn.df-mobile-button",
                        'border_radii_hover' => "%%order_class%%_mslide_btn.df-mobile-button:hover",
                        'border_styles' => "%%order_class%%_mslide_btn.df-mobile-button",
                        'border_styles_hover' => "%%order_class%%_mslide_btn.df-mobile-button:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'mobile_slide',
                'sub_toggle'      => 'button',
            ),
        );

        $advanced_fields['margin_padding'] = array(
            'css' => array(
                'important' => 'all'
            )
        );

        return $advanced_fields;
    }

    public function get_fields(){
        $general = array(
            'admin_label' => array (
				'label'           => esc_html__( 'Admin Label', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'admin_label',
            ),
            'type' => array(
				'label'               => esc_html__( 'Type', 'divi_flash' ),
				'type'                => 'select',
				'toggle_slug'         => 'main_content',
				'default'             => 'select',
                'options'             => array(
                    'logo'            => esc_html__('Logo', 'divi_flash'),
                    'menu'            => esc_html__('Menu', 'divi_flash'),
                    'button'          => esc_html__('Button', 'divi_flash'),
                    'search'          => esc_html__('Search', 'divi_flash'),
                    'text'            => esc_html__('Text', 'divi_flash'),
                    'cart'            => esc_html__('Woo Cart', 'divi_flash'),
                    'icon_box'        => esc_html__('Icon Box', 'divi_flash'),
                    'divider'         => esc_html__('Divider', 'divi_flash'),
                    'select'          => esc_html__('Select Type', 'divi_flash'),
                ),
                'affects'             => array(
                    'menu',
                    'desktop_menu',
                    'mobile_menu',
                    'logo_upload',
                    'logo_alt',
                    'logo_url',
                    'logo_url_new_window',
                    'button_text',
                    'button_url',
                    'button_url_new_window',
                    'use_button_icon',
                    'content',
                    'social',
                    'icon_btn_font_icon',
                    'icon_link_title',
                    'icon_box_url',
                    'icon_box_url_new_window',
                    'mm_trigger_icon',
                    'mm_icon_color',
                    'mm_icon_size',
                    'menu_item_gap',
                    'menu_icon_color',
                    'submenu_icon_color',
                    'search_input_bgcolor',
                    'top_level_menu_active_color',
                    'top_level_menu_active_link_bg',
                    'top_level_menu_active_border_color',
                    'sub_menu_active_color',
                    'sub_menu_active_link_bg',
                    'sub_menu_active_border_color'
                )
            ),

        );

        $layout = array(
            'menu_item_position'             => array(
                'label'               => esc_html__( 'Item Position on Desktop', 'divi_flash'),
                'type'                => 'menu_row_selector',
                'toggle_slug'         => 'main_content',
            ),
            'menu_item_position_small'             => array(
                'label'               => esc_html__( 'Item Position on Small Device', 'divi_flash'),
                'type'                => 'menu_row_selector',
                'toggle_slug'         => 'main_content',
            ),
            'menu_item_label'      => array(
                'type'                  => 'df_am_admin_label',
                'tab_slug'              => 'general',
                'toggle_slug'           => 'main_content'
            ),
        );
        $divider = array(
            'divider_width'    => array(
                'label'             => esc_html__('Divider Width', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'main_content',
                'tab_slug'          => 'general',
                'default'           => '2px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => true,
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if'             => array(
                    'type'    => 'divider'
                )
            ),
            'divider_color' => array(
				'label'               => esc_html__( 'Divider Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if'             => array(
                    'type'    => 'divider'
                )
            ),
        );
        $woo_cart = array(
            'cart_icon' => array(
				'label'               => esc_html__( 'Cart Icon', 'divi_flash' ),
				'type'                => 'select_icon',
                'class'               => array('et-pb-font-icon'),
                // 'default'             => '5',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'show_if'             => array(
                    'type'    => 'cart'
                )
            ),
            'cart_icon_color' => array(
				'label'               => esc_html__( 'Cart Icon Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if'             => array(
                    'type'    => 'cart'
                )
            ),
            'cart_icon_size'    => array(
                'label'             => esc_html__('Cart Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'main_content',
                'tab_slug'          => 'general',
                'default'           => '14px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px', '%', 'em', 'vh', 'vw'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => true,
                'responsive'        => true,
                'mobile_options'    => true,
                'hover'             => 'tabs',
                'show_if'             => array(
                    'type'    => 'cart'
                )
            ),
            'use_cart_count' => array(
				'label'                 => esc_html__( 'Cart Item Count', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'main_content',
                'tab_slug'              => 'general',
                'show_if'             => array(
                    'type'    => 'cart'
                )
            ),
            'cart_count_color' => array(
				'label'               => esc_html__( 'Cart Count Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if'             => array(
                    'type'    => 'cart',
                    'use_cart_count' => 'on'
                )
            ),
            'cart_count_bg' => array(
				'label'               => esc_html__( 'Cart Count Background Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if'             => array(
                    'type'    => 'cart',
                    'use_cart_count' => 'on'
                )
            ),
            'use_cart_total' => array(
				'label'                 => esc_html__( 'Cart Total', 'divi_flash' ),
				'type'                  => 'yes_no_button',
				'option_category'       => 'basic_option',
				'options'               => array(
					'off' => esc_html__( 'No', 'divi_flash' ),
					'on'  => esc_html__( 'Yes', 'divi_flash' ),
                ),
                'toggle_slug'           => 'main_content',
                'tab_slug'              => 'general',
                'show_if'             => array(
                    'type'    => 'cart'
                )
            ),
            'cart_total_color' => array(
				'label'               => esc_html__( 'Cart Total Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if'             => array(
                    'type'    => 'cart',
                    'use_cart_total' => 'on'
                )
            ),
        );
        $search = array(
            'search_style'  => array(
                'label'               => esc_html__( 'Search Style', 'divi_flash'),
                'type'                => 'select',
                'tab_slug'            => 'general',
                'toggle_slug'         => 'main_content',
                'default'             => 'df-searchbox-style-1',
                'options'             => array(
                    'df-searchbox-style-1'       => esc_html__('Style 1', 'divi_flash'),
                    'df-searchbox-style-2'       => esc_html__('Style 2', 'divi_flash'),
                    'df-searchbox-style-3'       => esc_html__('Style 3', 'divi_flash'),
                    'df-searchbox-style-4'       => esc_html__('Style 4', 'divi_flash'),
                    'df-searchbox-style-5'       => esc_html__('Style 5', 'divi_flash')
                ),
                'show_if' => array( 'type' => 'search' )
            ),
            'placeholder' => array (
				'label'           => esc_html__( 'Placeholder', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
                'show_if' => array( 'type' => 'search' )
            ),
            'search_icon_divider'      => array(
                'type'                  => 'df_divider_with_title',
                'tab_slug'              => 'general',
                'toggle_slug'           => 'main_content',
                'options'               => array(
                    'title' => 'Search'
                ),
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-1',
                        'df-searchbox-style-2',
                        'df-searchbox-style-3',
                        'df-searchbox-style-4'
                    )
                )
            ),
            'search_icon' => array(
				'label'               => esc_html__( 'Submit Icon', 'divi_flash' ),
				'type'                => 'select_icon',
                'class'               => array('et-pb-font-icon'),
                'default'             => 'U',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-1',
                        'df-searchbox-style-2',
                        'df-searchbox-style-3',
                        'df-searchbox-style-4'
                    )
                )
            ),
            'search_icon_color' => array(
				'label'               => esc_html__( 'Submit Icon Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-1',
                        'df-searchbox-style-2',
                        'df-searchbox-style-3',
                        'df-searchbox-style-4'
                    )
                )
            ),
            'search_icon_bg' => array(
				'label'               => esc_html__( 'Submit Icon Background', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if_not'         => array(
                    'search_style'    => 'df-searchbox-style-5'
                ),
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-1',
                        'df-searchbox-style-2',
                        'df-searchbox-style-3',
                        'df-searchbox-style-4'
                    )
                )
            ),
            'search_input_bgcolor' => array(
				'label'               => esc_html__( 'Input Background Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if_not'         => array(
                    'search_style'    => 'df-searchbox-style-5'
                ),
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-1',
                        'df-searchbox-style-2',
                        'df-searchbox-style-3',
                        'df-searchbox-style-4'
                    )
                )
            ),
            'search_icon_size'    => array(
                'label'             => esc_html__('Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'main_content',
                'tab_slug'          => 'general',
                'default'           => '14px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => true,
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-1',
                        'df-searchbox-style-2',
                        'df-searchbox-style-3',
                        'df-searchbox-style-4'
                    )
                )
            ),
            'search_tr_icon_divider'      => array(
                'type'                  => 'df_divider_with_title',
                'tab_slug'              => 'general',
                'toggle_slug'           => 'main_content',
                'options'               => array(
                    'title' => 'Search Triggr'
                ),
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-5'
                    )
                )
            ),
            'search_tr_icon' => array(
				'label'               => esc_html__( 'Icon', 'divi_flash' ),
				'type'                => 'select_icon',
                'class'               => array('et-pb-font-icon'),
                'default'             => 'U',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-5'
                    )
                )
            ),
            'search_tr_icon_color' => array(
				'label'               => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-5'
                    )
                )
            ),
            'search_tr_icon_bg' => array(
				'label'               => esc_html__( 'Icon Background', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-5'
                    )
                )
            ),
            'search_tr_icon_size'    => array(
                'label'             => esc_html__('Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'main_content',
                'tab_slug'          => 'general',
                'default'           => '14px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => true,
                'responsive'        => true,
                'mobile_options'    => true,
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-5'
                    )
                )
            ),
            'search_pp_title'      => array(
                'type'                  => 'df_divider_with_title',
                'tab_slug'              => 'general',
                'toggle_slug'           => 'main_content',
                'options'               => array(
                    'title' => 'Search Popup'
                ),
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-5'
                    )
                )
            ),
            'search_popup_bg' => array(
				'label'               => esc_html__( 'Background Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-5'
                    )
                )
            ),
            'search_popup_icon_color' => array(
				'label'               => esc_html__( 'Submit Icon Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-5'
                    )
                )
            ),
            'search_popup_close_color' => array(
				'label'               => esc_html__( 'Close Icon Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-5'
                    )
                )
            ),
            'search_popup_input_color' => array(
				'label'               => esc_html__( 'Input Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-5'
                    )
                )
            ),
            'search_popup_line_color' => array(
				'label'               => esc_html__( 'Line Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
                'show_if' => array(
                    'type' => 'search',
                    'search_style' => array(
                        'df-searchbox-style-5'
                    )
                )
            ),
        );
        $icon_button = array(
            'icon_btn_font_icon' => array(
				'label'               => esc_html__( 'Select Icon', 'divi_flash' ),
				'type'                => 'select_icon',
                'class'               => array('et-pb-font-icon'),
                'default'             => '9',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general' ,
                'depends_show_if'     => 'icon_box'
            ),
            'icon_btn_icon_color' => array(
				'label'               => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general',
                'hover'               => 'tabs',
				'sticky'              => true,
                'show_if'             => array(
                    'type' => 'icon_box'
                )
            ),
            'icon_btn_icon_size'    => array(
                'label'             => esc_html__('Icon Size', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'main_content',
                'tab_slug'          => 'general',
                'default'           => '14px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px', '%', 'em', 'vh', 'vw'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => true,
                'responsive'        => true,
                'mobile_options'    => true,
                'hover'             => 'tabs',
                'show_if'           => array(
                    'type'    => 'icon_box'
                )
            ),
            'icon_link_title'            => array(
				'label'           => esc_html__( 'Title Attribute', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
                'depends_show_if' => 'icon_box'
			),
            'icon_box_url'                        => array(
				'label'           => esc_html__( 'Icon Box Link URL', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
                'depends_show_if' => 'icon_box'
			),
            'icon_box_url_new_window'             => array(
				'label'            => esc_html__( 'Icon Box Link Target', 'divi_flash' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'In The Same Window', 'divi_flash' ),
					'on'  => esc_html__( 'In The New Tab', 'divi_flash' ),
				),
				'toggle_slug'      => 'main_content',
				'default_on_front' => 'off',
                'depends_show_if' => 'icon_box'
			),
        );
        $logo = array(
            'logo_upload' => array(
                'label'              => esc_html__( 'Logo', 'divi_flash' ),
				'type'               => 'upload',
                'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'        => esc_attr__( 'Set As Image', 'divi_flash' ),
				'add_text'           => esc_attr__( 'Add Logo', 'divi_flash' ),
                'toggle_slug'        => 'main_content',
                'dynamic_content'    => 'image',
                'depends_show_if'    => 'logo'
            ),
            'sticky_logo' => array(
                'label'              => esc_html__( 'Sticky Logo', 'divi_flash' ),
				'type'               => 'upload',
                'option_category'    => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'        => esc_attr__( 'Set As Image', 'divi_flash' ),
				'add_text'           => esc_attr__( 'Add Logo', 'divi_flash' ),
                'toggle_slug'        => 'main_content',
                'dynamic_content'    => 'image',
                'show_if'            => array(
                    'type' => 'logo'
                )
            ),
            'logo_alt'            => array(
				'label'           => esc_html__( 'Logo Alt Text', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the HTML ALT text for your logo here.', 'divi_flash' ),
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
				'dynamic_content' => 'text',
                'depends_show_if'    => 'logo'
			),
            'logo_url'                        => array(
				'label'           => esc_html__( 'Logo Link URL', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'If you would like to make your logo a link, input your destination URL here.', 'divi_flash' ),
				'toggle_slug'     => 'main_content',
				'dynamic_content' => 'url',
                'depends_show_if' => 'logo'
			),
            'logo_url_new_window'             => array(
				'label'            => esc_html__( 'Logo Link Target', 'divi_flash' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'In The Same Window', 'divi_flash' ),
					'on'  => esc_html__( 'In The New Tab', 'divi_flash' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'divi_flash' ),
				'default_on_front' => 'off',
                'depends_show_if' => 'logo'
			)
        );
        $button = array(
            'button_text'         => array(
				'label'           => esc_html__( 'Button Text', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
				'dynamic_content' => 'text',
                'depends_show_if' => 'button'
			),
            'button_url'          => array(
				'label'           => esc_html__( 'Button URL', 'divi_flash' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
				'dynamic_content' => 'url',
                'depends_show_if' => 'button'
			),
            'button_url_new_window'             => array(
				'label'            => esc_html__( 'Button Link Target', 'divi_flash' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'In The Same Window', 'divi_flash' ),
					'on'  => esc_html__( 'In The New Tab', 'divi_flash' ),
				),
				'toggle_slug'      => 'main_content',
				'default_on_front' => 'off',
                'depends_show_if' => 'button'
			),
            'use_button_icon'  => array(
                'label'               => esc_html__( 'Use Button Icon', 'divi_flash'),
                'type'                => 'yes_no_button',
                'tab_slug'            => 'general',
                'toggle_slug'         => 'main_content',
                'default'             => 'off',
                'options'             => array(
                    'off'         => esc_html__('No', 'divi_flash'),
                    'on'          => esc_html__('Yes', 'divi_flash')
                ),
                'default_on_front' => 'off',
                'depends_show_if' => 'button'
            ),
            'button_font_icon' => array(
				'label'               => esc_html__( 'Button Icon', 'divi_flash' ),
				'type'                => 'select_icon',
                'class'               => array('et-pb-font-icon'),
                'default'             => '5',
				'toggle_slug'         => 'main_content',
                'tab_slug'            => 'general' ,
                'show_if'             => array(
                    'use_button_icon' => 'on',
                    'type'            => 'button'
                )
            ),
            'button_icon_on_left'  => array(
                'label'               => esc_html__( 'Icon on Left', 'divi_flash'),
                'type'                => 'yes_no_button',
                'tab_slug'            => 'general',
                'toggle_slug'         => 'main_content',
                'default'             => 'off',
                'options'             => array(
                    'off'         => esc_html__('No', 'divi_flash'),
                    'on'          => esc_html__('Yes', 'divi_flash')
                ),
                'default_on_front' => 'off',
                'show_if'             => array(
                    'use_button_icon' => 'on',
                    'type'            => 'button'
                )
            ),
            'button_show_icon_on_hover'  => array(
                'label'               => esc_html__( 'Show Icon On Hover', 'divi_flash'),
                'type'                => 'yes_no_button',
                'tab_slug'            => 'general',
                'toggle_slug'         => 'main_content',
                'default'             => 'off',
                'options'             => array(
                    'off'         => esc_html__('No', 'divi_flash'),
                    'on'          => esc_html__('Yes', 'divi_flash')
                ),
                'default_on_front' => 'off',
                'show_if'             => array(
                    'use_button_icon' => 'on',
                    'type'            => 'button'
                )
            ),
        );
        $text = array(
            'content' => array(
                'label'           => esc_html__('Content', 'divi_flash'),
                'type'            => 'tiny_mce',
                'option_category' => 'basic_option',
                'toggle_slug'     => 'main_content',
                'dynamic_content' => 'text',
                'depends_show_if' => 'text'
            ),
        );
        $menu = array(
            'menu_id'   => array(
				'label'            => esc_html__( 'Menu', 'divi_flash' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
                'default'          => 'none',
				'options'          => et_builder_get_nav_menus_options(),
				'description'      => sprintf(
					'<p class="description">%2$s. <a href="%1$s" target="_blank">%3$s</a>.</p>',
					esc_url( admin_url( 'nav-menus.php' ) ),
					esc_html__( 'Select a menu that should be used in the module', 'divi_flash' ),
					esc_html__( 'Click here to create/edit menu', 'divi_flash' )
				),
                'tab_slug'         => 'general',
				'toggle_slug'      => 'main_content',
                'show_if'          => array( 'type' => 'menu' )
			),
            'desktop_menu'  => array(
                'label'               => esc_html__( 'Layout (large device)', 'divi_flash'),
                'type'                => 'select',
                'tab_slug'            => 'general',
                'toggle_slug'         => 'main_content',
                'default'             => 'normal',
                'options'             => array(
                    'normal'         => esc_html__('Normal', 'divi_flash'),
                    'hidden'         => esc_html__('Hidden', 'divi_flash'),
                ),
                'depends_show_if'     => 'menu',
            ),
            'mobile_menu'  => array(
                'label'               => esc_html__( 'Layout (small device)', 'divi_flash'),
                'type'                => 'select',
                'tab_slug'            => 'general',
                'toggle_slug'         => 'main_content',
                'default'             => 'mobile_menu',
                'options'             => array(
                    'mobile_menu'    => esc_html__('Mobile Menu', 'divi_flash'),
                    'hidden'         => esc_html__('Hidden', 'divi_flash')
                ),
                'depends_show_if'     => 'menu',
            ),
            'submenu_reveal_anime'  => array(
                'label'               => esc_html__( 'Submenu Reveal Animation', 'divi_flash'),
                'type'                => 'select',
                'tab_slug'            => 'general',
                'toggle_slug'         => 'main_content',
                'default'             => 'animtaion-submenu-1',
                'options'             => array(
                    'animtaion-submenu-1'    => esc_html__('Animation 1', 'divi_flash'),
                    'animtaion-submenu-2'    => esc_html__('Animation 2', 'divi_flash'),
                    'animtaion-submenu-3'    => esc_html__('Animation 3', 'divi_flash')
                ),
                'show_if'             => array(
                    'type'            => 'menu'
                )
            ),
            'submenu_distance_desktop'    => array(
                'label'             => esc_html__('Submenu Distance Desktop', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'main_content',
                'tab_slug'          => 'general',
                'default_unit'      => 'px',
                'fixed_unit'        => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '100',
                    'step' => '1',
                ),
                'validate_unit'     => true,
                'show_if'             => array(
                    'type'            => 'menu'
                )
            ),
        );
        $menu_item_hover_animation = array(
            'use_item_animation'  => array(
                'label'               => esc_html__( 'Enable Item Animation', 'divi_flash'),
                'type'                => 'yes_no_button',
                'tab_slug'            => 'general',
                'toggle_slug'         => 'menu_item_hover',
                'default'             => 'off',
                'options'             => array(
                    'off'         => esc_html__('No', 'divi_flash'),
                    'on'          => esc_html__('Yes', 'divi_flash')
                ),
                'show_if'             => array(
                    'type'            => 'menu'
                )
            ),
            'menu_item_hover_anim'  => array(
                'label'               => esc_html__( 'Menu Item Hover Animation', 'divi_flash'),
                'type'                => 'select',
                'tab_slug'            => 'general',
                'toggle_slug'         => 'menu_item_hover',
                'default'             => 'item-hover-1',
                'options'             => array(
                    'item-hover-1'      => esc_html__('Animation 1', 'divi_flash'),
                    'item-hover-2'      => esc_html__('Animation 2', 'divi_flash'),
                    'item-hover-3'      => esc_html__('Animation 3', 'divi_flash'),
                    'item-hover-4'      => esc_html__('Animation 4', 'divi_flash'),
                    'item-hover-5'      => esc_html__('Animation 5', 'divi_flash'),
                ),
                'show_if'             => array(
                    'type'                  => 'menu',
                    'use_item_animation'    => 'on'
                )
            ),
            'line_weight'    => array(
                'label'             => esc_html__('Line Weight', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'menu_item_hover',
                'tab_slug'          => 'general',
                'default'           => '2px',
                'default_unit'      => 'px',
                'fixed_unit'        => 'px',
                'allowed_units'     => array('px'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '20',
                    'step' => '1',
                ),
                'validate_unit'     => true,
                'show_if'             => array(
                    'type'                  => 'menu',
                    'use_item_animation'    => 'on',
                    'menu_item_hover_anim'  => array(
                        'item-hover-1',
                        'item-hover-2',
                        'item-hover-4',
                        'item-hover-3',
                        // 'item-hover-5',
                    )
                )
            ),
            'line_space_between_item'    => array(
                'label'             => esc_html__('Line Space Between Item', 'divi_flash'),
                'type'              => 'range',
                'toggle_slug'       => 'menu_item_hover',
                'tab_slug'          => 'general',
                'default'           => '7px',
                'default_unit'      => 'px',
                'allowed_units'     => array('px','%'),
                'range_settings'    => array(
                    'min'  => '1',
                    'max'  => '20',
                    'step' => '1',
                ),
                'validate_unit'     => true,
                'show_if'             => array(
                    'type'                  => 'menu',
                    'use_item_animation'    => 'on',
                    'menu_item_hover_anim'  => array(
                        // 'item-hover-1',
                        // 'item-hover-2',
                        'item-hover-4',
                        // 'item-hover-3',
                        'item-hover-5',
                    )
                )
            ),
            'line_color' => array(
				'label'               => esc_html__( 'Line Color', 'divi_flash' ),
				'type'                => 'color-alpha',
				'toggle_slug'         => 'menu_item_hover',
                'tab_slug'            => 'general',
                'default'             => '#0038F0',
                // 'hover'               => 'tabs',
                'responsive'          => false,
                'mobile_options'      => false,
                'show_if'             => array(
                    'type'                  => 'menu',
                    'use_item_animation'    => 'on',
                    'menu_item_hover_anim'  => array(
                        'item-hover-1',
                        'item-hover-2',
                        'item-hover-4',
                        'item-hover-3',
                        'item-hover-5',
                    )
                )
            )
        );
        $mobile_menu_trigger = array_merge(
            array(
                'mm_trigger_icon' => array(
                    'label'               => esc_html__( 'Mobile Menu Trigger Icon', 'divi_flash' ),
                    'type'                => 'select_icon',
                    'class'               => array('et-pb-font-icon'),
                    'default'             => 'a',
                    'toggle_slug'         => 'mm_trigger',
                    'tab_slug'            => 'general',
                    'depends_show_if'     => 'menu'
                ),
                'mm_icon_color' => array(
                    'label'               => esc_html__( 'Icon Color', 'divi_flash' ),
                    'type'                => 'color-alpha',
                    'toggle_slug'         => 'mm_trigger',
                    'tab_slug'            => 'general',
                    'depends_show_if'     => 'menu',
                    'hover'               => 'tabs'
                ),
                'mm_icon_size' => array(
                    'label'             => esc_html__('Icon Size', 'divi_flash'),
                    'type'              => 'range',
                    'toggle_slug'       => 'mm_trigger',
                    'tab_slug'          => 'general',
                    'default'           => '32px',
                    'allowed_units'     => array('px'),
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1'
                    ),
                    'responsive'        => true,
                    'mobile_options'    => true,
                    'depends_show_if'   => 'menu'
                ),
            ),
            $this->df_background_settings(array(
                'option_name' => 'mm_trigger_bg',
                'tab_slug' => 'general',
                'toggle_slug' => 'mm_trigger',
                'show_if'   => array( 'type' => 'menu' )
            )),
            $this->add_margin_padding(array(
                'title'         => '',
                'key'           => 'mmenu_trigger',
                'toggle_slug'   => 'mm_trigger',
                'tab_slug'      => 'general',
                'option'        => 'padding',
                'show_if'       => array( 'type' => 'menu')
            ))
        );
        $mobile_slide_button = array_merge(
            array(
                'use_mslide_btn' => array(
                    'label'                 => esc_html__( 'Use Button', 'divi_flash' ),
                    'type'                  => 'yes_no_button',
                    'option_category'       => 'basic_option',
                    'options'               => array(
                        'off' => esc_html__( 'No', 'divi_flash' ),
                        'on'  => esc_html__( 'Yes', 'divi_flash' ),
                    ),
                    'toggle_slug'           => 'mobile_slide_button',
                    'tab_slug'              => 'general',
                    'show_if'             => array(
                        'type'    => 'menu'
                    )
                ),
                'mslide_button_text'         => array(
                    'label'           => esc_html__( 'Button Text', 'divi_flash' ),
                    'type'            => 'text',
                    'option_category' => 'basic_option',
                    'tab_slug'        => 'general',
                    'toggle_slug'     => 'mobile_slide_button',
                    'dynamic_content' => 'text',
                    'show_if'             => array(
                        'use_mslide_btn'  => 'on',
                        'type'            => 'menu'
                    )
                ),
                'mslide_button_url'          => array(
                    'label'           => esc_html__( 'Button URL', 'divi_flash' ),
                    'type'            => 'text',
                    'option_category' => 'basic_option',
                    'toggle_slug'     => 'mobile_slide_button',
                    'dynamic_content' => 'url',
                    'show_if'             => array(
                        'use_mslide_btn'  => 'on',
                        'type'            => 'menu'
                    )
                ),
                'mslide_button_url_new_window'             => array(
                    'label'            => esc_html__( 'Button Link Target', 'divi_flash' ),
                    'type'             => 'select',
                    'option_category'  => 'configuration',
                    'options'          => array(
                        'off' => esc_html__( 'In The Same Window', 'divi_flash' ),
                        'on'  => esc_html__( 'In The New Tab', 'divi_flash' ),
                    ),
                    'toggle_slug'      => 'mobile_slide_button',
                    'default_on_front' => 'off',
                    'show_if'             => array(
                        'use_mslide_btn'  => 'on',
                        'type'            => 'menu'
                    )
                ),
                'mslide_use_button_icon'  => array(
                    'label'               => esc_html__( 'Use Button Icon', 'divi_flash'),
                    'type'                => 'yes_no_button',
                    'tab_slug'            => 'general',
                    'toggle_slug'         => 'mobile_slide_button',
                    'default'             => 'off',
                    'options'             => array(
                        'off'         => esc_html__('No', 'divi_flash'),
                        'on'          => esc_html__('Yes', 'divi_flash')
                    ),
                    'default_on_front' => 'off',
                    'show_if'             => array(
                        'use_mslide_btn'  => 'on',
                        'type'            => 'menu'
                    )
                ),
                'mslide_button_font_icon' => array(
                    'label'               => esc_html__( 'Button Icon', 'divi_flash' ),
                    'type'                => 'select_icon',
                    'class'               => array('et-pb-font-icon'),
                    'default'             => '5',
                    'toggle_slug'         => 'mobile_slide_button',
                    'tab_slug'            => 'general' ,
                    'show_if'             => array(
                        'mslide_use_button_icon' => 'on',
                        'type'            => 'menu'
                    )
                ),
                'mslide_button_icon_on_left'  => array(
                    'label'               => esc_html__( 'Icon on Left', 'divi_flash'),
                    'type'                => 'yes_no_button',
                    'tab_slug'            => 'general',
                    'toggle_slug'         => 'mobile_slide_button',
                    'default'             => 'off',
                    'options'             => array(
                        'off'         => esc_html__('No', 'divi_flash'),
                        'on'          => esc_html__('Yes', 'divi_flash')
                    ),
                    'default_on_front' => 'off',
                    'show_if'             => array(
                        'mslide_use_button_icon' => 'on',
                        'type'            => 'menu'
                    )
                ),
            ),
            $this->df_background_settings(array(
                'option_name' => 'mslide_button_bg',
                'tab_slug' => 'advanced',
                'toggle_slug'     => 'mobile_slide',
                'sub_toggle'      => 'button'
            )),
            $this->add_margin_padding(array(
                'key'           => 'mslide_button',
                'toggle_slug'     => 'mobile_slide',
                'sub_toggle'      => 'button',
                'tab_slug'      => 'advanced',
                'show_if'       => array( 'type' => 'menu'),
                'priority'      => 10
            ))
        );
        $menu_design = array_merge(
            array(
                'menu_item_gap' => array(
                    'label'             => esc_html__('Item Gap', 'divi_flash'),
                    'type'              => 'range',
                    'toggle_slug'       => 'design_menu',
                    'tab_slug'          => 'advanced',
                    'default'           => '20px',
                    'allowed_units'     => array('px'),
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1'
                    ),
                    'responsive'        => true,
                    'mobile_options'    => true,
                    'depends_show_if'   => 'menu'
                ),
                'menu_icon_color' => array(
                    'label'               => esc_html__( 'Icon Color', 'divi_flash' ),
                    'type'                => 'color-alpha',
                    'toggle_slug'         => 'design_menu',
                    'tab_slug'            => 'advanced',
                    'depends_show_if'     => 'menu',
                    'hover'               => 'tabs',
                    'responsive'          => true,
                    'mobile_options'      => true,
                ),
                'menu_item_icon_size' => array(
                    'label'             => esc_html__('Icon Size', 'divi_flash'),
                    'type'              => 'range',
                    'toggle_slug'       => 'design_menu',
                    'tab_slug'          => 'advanced',
                    'default'           => '14px',
                    'allowed_units'     => array('px'),
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1'
                    ),
                    'responsive'        => true,
                    'mobile_options'    => true,
                    'depends_show_if'   => 'menu'
                )
            ),
            $this->df_background_settings(array(
                'option_name' => 'menu_item_bg',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'design_menu'
            )),
            $this->add_margin_padding(array(
                'title'         => 'Menu Item',
                'key'           => 'menu_item',
                'toggle_slug'   => 'design_menu',
                'tab_slug'      => 'advanced',
                'show_if'       => array( 'type' => 'menu')
            ))
        );

        $sub_menu_design = array_merge(
            array(
                'submenu_icon_color' => array(
                    'label'               => esc_html__( 'Icon Color', 'divi_flash' ),
                    'type'                => 'color-alpha',
                    'toggle_slug'         => 'submenu',
                    'sub_toggle'          => 'item',
                    'tab_slug'            => 'advanced',
                    'depends_show_if'     => 'menu',
                    'hover'               => 'tabs',
                    'responsive'          => true,
                    'mobile_options'      => true,
                ),
                'submenu_item_icon_size' => array(
                    'label'             => esc_html__('Icon Size', 'divi_flash'),
                    'type'              => 'range',
                    'toggle_slug'       => 'submenu',
                    'sub_toggle'        => 'item',
                    'tab_slug'          => 'advanced',
                    'default'           => '14px',
                    'allowed_units'     => array('px'),
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1'
                    ),
                    'responsive'        => true,
                    'mobile_options'    => true,
                    'depends_show_if'   => 'menu'
                ),
            ),
            $this->df_background_settings(array(
                'option_name' => 'submenu_item_bg',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'submenu',
                'sub_toggle' => 'item',
            )),
            $this->add_margin_padding(array(
                'title'         => '',
                'key'           => 'submenu_item',
                'toggle_slug'   => 'submenu',
                'sub_toggle'    => 'item',
                'tab_slug'      => 'advanced',
                'show_if'       => array( 'type' => 'menu'),
                'priority'      => 10
            )),
            $this->df_background_settings(array(
                'option_name' => 'submenu_container_bg',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'submenu',
                'sub_toggle' => 'container',
            ))
        );
        $mega_menu = array_merge(
            array(
                'maga_menu_columgap'    => array(
                    'label'             => esc_html__('Column Gap', 'divi_flash'),
                    'type'              => 'range',
                    'toggle_slug'       => 'mega_menu',
                    'tab_slug'          => 'advanced',
                    'sub_toggle'        => 'container',
                    'default_unit'      => 'px',
                    'default'           => '30px',
                    'fixed_unit'        => 'px',
                    'allowed_units'     => array('px'),
                    'range_settings'    => array(
                        'min'  => '1',
                        'max'  => '100',
                        'step' => '1',
                    ),
                    'validate_unit'     => true,
                ),
                'megamenu_item_icon_color' => array(
                    'label'               => esc_html__( 'Icon Color', 'divi_flash' ),
                    'type'                => 'color-alpha',
                    'toggle_slug'         => 'mega_menu',
                    'tab_slug'            => 'advanced',
                    'sub_toggle'          => 'item',
                    'depends_show_if'     => 'menu',
                    'hover'               => 'tabs',
                    'responsive'          => true,
                    'mobile_options'      => true,
                ),
                'megamenu_item_icon_size' => array(
                    'label'             => esc_html__('Icon Size', 'divi_flash'),
                    'type'              => 'range',
                    'toggle_slug'       => 'mega_menu',
                    'tab_slug'          => 'advanced',
                    'sub_toggle'          => 'item',
                    'default'           => '14px',
                    'allowed_units'     => array('px'),
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1'
                    ),
                    'responsive'        => true,
                    'mobile_options'    => true,
                    'depends_show_if'   => 'menu'
                )
            ),
            $this->df_background_settings(array(
                'option_name' => 'mega_menu_bg',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'mega_menu',
                'sub_toggle' => 'container'
            )),
            $this->df_background_settings(array(
                'option_name' => 'mega_menuitem_bg',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'mega_menu',
                'sub_toggle' => 'item'
            )),
            $this->add_margin_padding(array(
                'title'         => '',
                'key'           => 'megamenu_container',
                'toggle_slug'   => 'mega_menu',
                'tab_slug'      => 'advanced',
                'sub_toggle'    => 'container',
                'show_if'       => array( 'type' => 'menu'),
                'priority'      => 10,
                'option'        => 'padding'
            )),
            $this->add_margin_padding(array(
                'title'         => '',
                'key'           => 'megamenu_item',
                'toggle_slug'   => 'mega_menu',
                'tab_slug'      => 'advanced',
                'sub_toggle'    => 'item',
                'show_if'       => array( 'type' => 'menu'),
                'priority'      => 10
            ))
        );

	    $menu_parents = array_merge(
		    array(
			    'menu_1st_parent_icon_color'      => array(
				    'label'           => esc_html__( 'Color', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_parents_icon',
				    'sub_toggle'      => 'first_parent',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_2nd_parent_icon_color'      => array(
				    'label'           => esc_html__( 'Color', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_parents_icon',
				    'sub_toggle'      => 'second_parent',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_3rd_parent_icon_color'      => array(
				    'label'           => esc_html__( 'Color', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_parents_icon',
				    'sub_toggle'      => 'third_parent',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_1st_parent_icon_background' => array(
				    'label'           => esc_html__( 'Background', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_parents_icon',
				    'sub_toggle'      => 'first_parent',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_2nd_parent_icon_background' => array(
				    'label'           => esc_html__( 'Background', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_parents_icon',
				    'sub_toggle'      => 'second_parent',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_3rd_parent_icon_background' => array(
				    'label'           => esc_html__( 'Background', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_parents_icon',
				    'sub_toggle'      => 'third_parent',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_1st_parent_icon_size'       => array(
				    'label'           => esc_html__( 'Size', 'divi_flash' ),
				    'type'            => 'range',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_parents_icon',
				    'sub_toggle'      => 'first_parent',
				    'default'         => '14px',
				    'allowed_units'   => array( 'px' ),
				    'range_settings'  => array(
					    'min'  => '0',
					    'max'  => '100',
					    'step' => '1'
				    ),
				    'responsive'      => true,
				    'mobile_options'  => true,
				    'depends_show_if' => 'menu'
			    ),
			    'menu_2nd_parent_icon_size'       => array(
				    'label'           => esc_html__( 'Size', 'divi_flash' ),
				    'type'            => 'range',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_parents_icon',
				    'sub_toggle'      => 'second_parent',
				    'default'         => '14px',
				    'allowed_units'   => array( 'px' ),
				    'range_settings'  => array(
					    'min'  => '0',
					    'max'  => '100',
					    'step' => '1'
				    ),
				    'responsive'      => true,
				    'mobile_options'  => true,
				    'depends_show_if' => 'menu'
			    ),
			    'menu_3rd_parent_icon_size'       => array(
				    'label'           => esc_html__( 'Size', 'divi_flash' ),
				    'type'            => 'range',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_parents_icon',
				    'sub_toggle'      => 'third_parent',
				    'default'         => '14px',
				    'allowed_units'   => array( 'px' ),
				    'range_settings'  => array(
					    'min'  => '0',
					    'max'  => '100',
					    'step' => '1'
				    ),
				    'responsive'      => true,
				    'mobile_options'  => true,
				    'depends_show_if' => 'menu'
			    ),
		    ),
		    $this->add_margin_padding( array(
			    'title'       => '',
			    'key'         => 'menu_1st_parent_icon',
			    'tab_slug'    => 'advanced',
			    'toggle_slug' => 'menu_parents_icon',
			    'sub_toggle'  => 'first_parent',
			    'show_if'     => array( 'type' => 'menu' ),
			    'priority'    => 10
		    ) ),
		    $this->add_margin_padding( array(
			    'title'       => '',
			    'key'         => 'menu_2nd_parent_icon',
			    'tab_slug'    => 'advanced',
			    'toggle_slug' => 'menu_parents_icon',
			    'sub_toggle'  => 'second_parent',
			    'show_if'     => array( 'type' => 'menu' ),
			    'priority'    => 10
		    ) ),
		    $this->add_margin_padding( array(
			    'title'       => '',
			    'key'         => 'menu_3rd_parent_icon',
			    'tab_slug'    => 'advanced',
			    'toggle_slug' => 'menu_parents_icon',
			    'sub_toggle'  => 'third_parent',
			    'show_if'     => array( 'type' => 'menu' ),
			    'priority'    => 10
		    ) )
	    );
	    $menu_childs  = array_merge(
		    array(
			    'menu_1st_child_icon_color'      => array(
				    'label'           => esc_html__( 'Color', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_childs_icon',
				    'sub_toggle'      => 'first_child',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_2nd_child_icon_color'      => array(
				    'label'           => esc_html__( 'Color', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_childs_icon',
				    'sub_toggle'      => 'second_child',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_3rd_child_icon_color'      => array(
				    'label'           => esc_html__( 'Color', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_childs_icon',
				    'sub_toggle'      => 'third_child',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_1st_child_icon_background' => array(
				    'label'           => esc_html__( 'Background', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_childs_icon',
				    'sub_toggle'      => 'first_child',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_2nd_child_icon_background' => array(
				    'label'           => esc_html__( 'Background', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_childs_icon',
				    'sub_toggle'      => 'second_child',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_3rd_child_icon_background' => array(
				    'label'           => esc_html__( 'Background', 'divi_flash' ),
				    'type'            => 'color-alpha',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_childs_icon',
				    'sub_toggle'      => 'third_child',
				    'depends_show_if' => 'menu',
				    'hover'           => 'tabs',
				    'responsive'      => true,
				    'mobile_options'  => true,
			    ),
			    'menu_1st_child_icon_size'       => array(
				    'label'           => esc_html__( 'Size', 'divi_flash' ),
				    'type'            => 'range',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_childs_icon',
				    'sub_toggle'      => 'first_child',
				    'default'         => '14px',
				    'allowed_units'   => array( 'px' ),
				    'range_settings'  => array(
					    'min'  => '0',
					    'max'  => '100',
					    'step' => '1'
				    ),
				    'responsive'      => true,
				    'mobile_options'  => true,
				    'depends_show_if' => 'menu'
			    ),
			    'menu_2nd_child_icon_size'       => array(
				    'label'           => esc_html__( 'Size', 'divi_flash' ),
				    'type'            => 'range',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_childs_icon',
				    'sub_toggle'      => 'second_child',
				    'default'         => '14px',
				    'allowed_units'   => array( 'px' ),
				    'range_settings'  => array(
					    'min'  => '0',
					    'max'  => '100',
					    'step' => '1'
				    ),
				    'responsive'      => true,
				    'mobile_options'  => true,
				    'depends_show_if' => 'menu'
			    ),
			    'menu_3rd_child_icon_size'       => array(
				    'label'           => esc_html__( 'Size', 'divi_flash' ),
				    'type'            => 'range',
				    'tab_slug'        => 'advanced',
				    'toggle_slug'     => 'menu_childs_icon',
				    'sub_toggle'      => 'third_child',
				    'default'         => '14px',
				    'allowed_units'   => array( 'px' ),
				    'range_settings'  => array(
					    'min'  => '0',
					    'max'  => '100',
					    'step' => '1'
				    ),
				    'responsive'      => true,
				    'mobile_options'  => true,
				    'depends_show_if' => 'menu'
			    ),
		    ),
		    $this->add_margin_padding( array(
			    'title'       => 'Icon',
			    'key'         => 'menu_1st_child_icon',
			    'tab_slug'    => 'advanced',
			    'toggle_slug' => 'menu_childs_icon',
			    'sub_toggle'  => 'first_child',
			    'show_if'     => array( 'type' => 'menu' ),
			    'priority'    => 10
		    ) ),
		    $this->add_margin_padding( array(
			    'title'       => 'Icon',
			    'key'         => 'menu_2nd_child_icon',
			    'tab_slug'    => 'advanced',
			    'toggle_slug' => 'menu_childs_icon',
			    'sub_toggle'  => 'second_child',
			    'show_if'     => array( 'type' => 'menu' ),
			    'priority'    => 10
		    ) ),
		    $this->add_margin_padding( array(
			    'title'       => 'Icon',
			    'key'         => 'menu_3rd_child_icon',
			    'tab_slug'    => 'advanced',
			    'toggle_slug' => 'menu_childs_icon',
			    'sub_toggle'  => 'third_child',
			    'show_if'     => array( 'type' => 'menu' ),
			    'priority'    => 10
		    ) )
	    );

        $active_state = array_merge(
            array(
                'top_level_menu_active_color' => array(
                    'label'               => esc_html__('Top Level Menu Active Color', 'divi_flash'),
                    'type'                => 'color-alpha',
                    'tab_slug'            => 'advanced',
                    'toggle_slug'         => 'active_state',
                    'sub_toggle'          => 'top_level',
                    'depends_show_if'     => 'menu',
                    // 'hover'               => 'tabs',
                    'responsive'          => true,
                    'mobile_options'      => true,
                )
            ),
            $this->df_background_settings(array(
                'title'         => 'Top Level Menu Active Link Background',
                'option_name' => 'top_lebel_menu_active_link_bg',
                'tab_slug' => 'advanced',
                'toggle_slug'         => 'active_state',
                'sub_toggle'          => 'top_level',
                'show_if'             => array(
                    'type' => 'menu'
                )
            )),
            array(
                'top_level_menu_active_border_color' => array(
                    'label'               => esc_html__('Top Level Menu Active Border Color', 'divi_flash'),
                    'type'                => 'color-alpha',
                    'tab_slug'            => 'advanced',
                    'toggle_slug'         => 'active_state',
                    'sub_toggle'          => 'top_level',
                    'depends_show_if'     => 'menu',
                    'hover'               => 'tabs',
                    'responsive'          => true,
                    'mobile_options'      => true,
                )
            ),
            array(
                'sub_menu_active_color' => array(
                    'label'               => esc_html__('Sub Menu Active Color', 'divi_flash'),
                    'type'                => 'color-alpha',
                    'tab_slug'            => 'advanced',
                    'toggle_slug'         => 'active_state',
                    'sub_toggle'          => 'sub_menu',
                    'depends_show_if'     => 'menu',
                    'hover'               => 'tabs',
                    'responsive'          => true,
                    'mobile_options'      => true,
                )
            ),

            $this->df_background_settings(array(
                'title'         => 'Sub Menu Active Link Background',
                'option_name'   => 'sub_menu_active_link_bg',
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'active_state',
                'sub_toggle'    => 'sub_menu',
                'show_if'             => array(
                    'type' => 'menu'
                )
            )),

            array(
                'sub_menu_active_border_color' => array(
                    'label'               => esc_html__('Sub Menu Active Border Color', 'divi_flash'),
                    'type'                => 'color-alpha',
                    'tab_slug'            => 'advanced',
                    'toggle_slug'         => 'active_state',
                    'sub_toggle'          => 'sub_menu',
                    'depends_show_if'     => 'menu',
                    'hover'               => 'tabs',
                    'responsive'          => true,
                    'mobile_options'      => true,
                )
            )
        );

        $mobile_slide   = array_merge(
            array(
                'mm_item_icon_color' => array(
                    'label'               => esc_html__( 'Icon Color', 'divi_flash' ),
                    'type'                => 'color-alpha',
                    'toggle_slug'         => 'mobile_slide',
                    'sub_toggle'          => 'item',
                    'tab_slug'            => 'advanced',
                    'depends_show_if'     => 'menu',
                    'hover'               => 'tabs',
                    'responsive'          => true,
                    'mobile_options'      => true,
                    'show_if'             => array( 'type' => 'menu')
                ),
                'mm_item_icon_size' => array(
                    'label'             => esc_html__('Icon Size', 'divi_flash'),
                    'type'              => 'range',
                    'toggle_slug'       => 'mobile_slide',
                    'sub_toggle'        => 'item',
                    'tab_slug'          => 'advanced',
                    'default'           => '14px',
                    'allowed_units'     => array('px'),
                    'range_settings'    => array(
                        'min'  => '0',
                        'max'  => '100',
                        'step' => '1'
                    ),
                    'responsive'        => true,
                    'mobile_options'    => true,
                    'depends_show_if'   => 'menu'
                ),
            ),
            $this->df_background_settings(array(
                'option_name' => 'mslide_item_bg',
                'tab_slug' => 'advanced',
                'toggle_slug'     => 'mobile_slide',
                'sub_toggle'      => 'item',
            )),
            $this->add_margin_padding(array(
                'title'         => '',
                'key'           => 'mslide_item',
                'toggle_slug'     => 'mobile_slide',
                'sub_toggle'      => 'item',
                'tab_slug'      => 'advanced',
                'show_if'       => array( 'type' => 'menu'),
                'priority'         => 10
            ))
        );

        $disable_on = array(
            'df_disabled_on'  => array(
                'label'               => esc_html__( 'Disabled On', 'divi_flash'),
                'type'                => 'multiple_checkboxes',
                'tab_slug'            => 'general',
                'toggle_slug'         => 'df_disabled_on',
                'options'             => array(
                    'desktop'         => esc_html__('Desktop', 'divi_flash'),
                    'small'           => esc_html__('Small', 'divi_flash')
                )
            ),
        );

        return array_merge(
            $general,
            $layout,
            $divider,
            $woo_cart,
            $search,
            $icon_button,
            $logo,
            $button,
            $text,
            $menu,
            $menu_item_hover_animation,
            $mobile_menu_trigger,
            $mobile_slide_button,
            $disable_on,
            $menu_design,
            $sub_menu_design,
            $mega_menu,
	        $menu_parents,
	        $menu_childs,
            $active_state,
            $mobile_slide
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        $fields['search_icon_color'] = array('color' => '%%order_class%% .df_am_searchsubmit');
        $fields['mm_icon_color'] = array('color' => "%%order_class%% .df-mobile-menu-button");
        $fields['menu_icon_color'] = array('color' => "%%order_class%% .df-menu-nav>li>a .df-menu-icon");
        $fields['submenu_icon_color'] = array('color' => "%%order_class%% .sub-menu:not(.df-custom-submenu) .df-menu-icon");

        $fields['icon_btn_icon_color'] = array('color' => "%%order_class%%.df-icon-button");
        $fields['icon_btn_icon_size'] = array('font-size' => "%%order_class%%.df-icon-button");

        $fields['cart_icon_color'] = array('color' => "%%order_class%% .df-cart-info span.cart-icon");
        $fields['cart_total_color'] = array('color' => "%%order_class%% .df-cart-info span.cart-total");
        $fields['cart_count_color'] = array('color' => "%%order_class%% .df-cart-info span.cart-item-count");
        $fields['cart_count_bg'] = array('background-color' => "%%order_class%% .df-cart-info span.cart-item-count");
        $fields['cart_icon_size'] = array('font-size' => "%%order_class%% .df-cart-info span.cart-icon");

        $fields['menu_item_margin'] = array('margin' => '%%order_class%% .df-menu-nav>li>a');
        $fields['menu_item_padding'] = array('padding' => '%%order_class%% .df-menu-nav>li>a');

        $fields['submenu_item_margin'] = array('margin' => '%%order_class%% .sub-menu:not(.df-custom-submenu) li a');
        $fields['submenu_item_padding'] = array('padding' => '%%order_class%% .sub-menu:not(.df-custom-submenu) li a');

        $fields['submenu_container_padding'] = array('padding' => '%%order_class%% .sub-menu');

        $fields['search_icon_color'] = array('color' => "%%order_class%% .df_am_searchsubmit");
        $fields['search_icon_bg'] = array('background-color' => "%%order_class%% .df_am_searchsubmit");
        $fields['search_input_bgcolor'] = array('background-color' => "%%order_class%%");
        $fields['search_tr_icon_color'] = array('color' => "%%order_class%%.df-am-search-button");
        $fields['search_tr_icon_bg'] = array('background-color' => "%%order_class%%.df-am-search-button");
        $fields['search_popup_bg'] = array('background-color' => "%%order_class%%_modal.df-searchbox-style-5");
        $fields['search_popup_icon_color'] = array('color' => "%%order_class%%_modal.df-searchbox-style-5 .df_am_searchsubmit");
        $fields['search_popup_close_color'] = array('color' => "%%order_class%%_modal.df-searchbox-style-5 .serach-box-close");
        $fields['search_popup_input_color'] = array('color' => "%%order_class%%_modal.df-searchbox-style-5 [type='text']");
        $fields['search_popup_line_color'] = array('border-color' => "%%order_class%%_modal.df-searchbox-style-5 form");

        // custom transition
        $fields['submenu_reveal_anime'] = array(
            'opacity' => '%%order_class%% .sub-menu',
            'transform' => '%%order_class%% .sub-menu',
            'visibility' => '%%order_class%% .sub-menu'
        );
        $fields['sticky_logo'] = array(
            'width' => '%%order_class%%',
        );
        $fields['button_show_icon_on_hover'] = array('margin' => '%%order_class%%.df-menu-button.show_icon_on_hover .df-am-button-icon');
        // fix background transition
        $fields = $this->df_process_new_background_transition($fields, 'menu_item_bg', $this->menu_item);
        $fields = $this->df_process_new_background_transition($fields, 'submenu_container_bg', $this->submenu_container);
        $fields = $this->df_process_new_background_transition($fields, 'submenu_item_bg', $this->submenu_item);
        $fields = $this->df_process_new_background_transition($fields, 'mslide_item_bg', $this->mslide_item);
        $fields = $this->df_process_new_background_transition($fields, 'mslide_button_bg', $this->mslide_button);
        $fields = $this->df_process_new_background_transition($fields, 'mm_trigger_bg', $this->mslide_trigger_button);
        $fields = $this->df_process_new_background_transition($fields, 'mega_menu_bg', $this->mega_menu_contianer);
        $fields = $this->df_process_new_background_transition($fields, 'mega_menuitem_bg', $this->mega_menu_item);

        return $fields;
    }
    // custom transition
    public function before_render() {
        $this->props['submenu_reveal_anime__hover'] = '1px||||false|false';
        $this->props['submenu_reveal_anime__hover_enabled'] = "on|hover";
        $this->props['sticky_logo__hover'] = '1px||||false|false';
        $this->props['sticky_logo__hover_enabled'] = "on|hover";

        $this->props['button_show_icon_on_hover__hover'] = '1px||||false|false';
        $this->props['button_show_icon_on_hover__hover_enabled'] = "on|hover";


    }
    public function df_disabled_on() {
        if(isset($this->props['df_disabled_on'])) {
            return explode('|', $this->props['df_disabled_on']);
        }
        return array('off', 'off');
    }

    public function process_icon_size($render_slug) {
        $submit_font_size = $this->props['search_icon_size'] ? $this->props['search_icon_size'] : '14px';
        $container_size = intval($submit_font_size) + 20;
        $styles = [
            'df-searchbox-style-1',
            'df-searchbox-style-2',
            'df-searchbox-style-3',
            'df-searchbox-style-4'
        ];

        if (in_array($this->props['search_style'], $styles)) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => "%%order_class%% .df_am_searchsubmit",
                'declaration' => sprintf(
                    'width: %1$s; min-width: %1$s; height: %1$s; min-height: %1$s;',
                    $container_size .'px'
                )
            ]);
        }
    }

    public function additional_css_styles($render_slug, $attrs){
        $module_alignment = array(
            'left' => '',
            'center' => 'margin-left: auto!important; margin-right: auto!important;',
            'right' => 'margin-left: auto !important; margin-right: 0!important;',
            '' => ''
        );
        $parent_module = isset(self::get_parent_modules('page')['difl_advancedmenu']) ?
            self::get_parent_modules('page') ['difl_advancedmenu']: new stdClass;
        $menu_break_point = 'max_width_' . $parent_module->props['break_point'];
        $break_point_max = sprintf('@media only screen and ( max-width: %1$spx )',
            intval($parent_module->props['break_point']));
        $break_point_min = sprintf('@media only screen and ( min-width: %1$spx )',
            intval($parent_module->props['break_point']) + 1);
        $disabled = $this->df_disabled_on();

        // background
        $this->props = array_merge($attrs , $this->props);
        $this->df_process_new_background_styles(
            array(
                'props' => $this->props,
                'key' => 'menu_item_bg',
                'selector' => $this->menu_item,
                'hover' => $this->menu_item_hover
            )
        );
        $this->df_process_new_background_styles(
            array(
                'props' => $this->props,
                'key' => 'submenu_container_bg',
                'selector' => $this->submenu_container,
                'hover' => $this->submenu_container_hover,
            )
        );
        $this->df_process_new_background_styles(
            array(
                'props' => $this->props,
                'key' => 'submenu_item_bg',
                'selector' => $this->submenu_item,
                'hover' => $this->submenu_item_hover
            )
        );
        $this->df_process_new_background_styles(
            array(
                'props' => $this->props,
                'key' => 'mslide_item_bg',
                'selector' => $this->mslide_item,
                'hover' => $this->mslide_item_hover
            )
        );
        $this->df_process_new_background_styles(
            array(
                'props' => $this->props,
                'key' => 'mslide_button_bg',
                'selector' => $this->mslide_button,
                'hover' => $this->mslide_button_hover
            )
        );
        $this->df_process_new_background_styles(
            array(
                'props' => $this->props,
                'key' => 'mm_trigger_bg',
                'selector' => $this->mslide_trigger_button,
                'hover' => $this->mslide_trigger_button_hover
            )
        );
        $this->df_process_new_background_styles(
            array(
                'props' => $this->props,
                'key' => 'mega_menu_bg',
                'selector' => $this->mega_menu_contianer,
                'hover' => $this->mega_menu_contianer_hover
            )
        );
        $this->df_process_new_background_styles(
            array(
                'props' => $this->props,
                'key' => 'mega_menuitem_bg',
                'selector' => $this->mega_menu_item,
                'hover' => $this->mega_menu_item_hover
            )
        );


        // mega menu
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => $this->mega_menu_contianer,
            'declaration' => sprintf('gap: %1$s !important;',
                $this->props['maga_menu_columgap']
            )
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'megamenu_item_icon_color',
            'type'              => 'color',
            'selector'          => $this->mega_menu_item_icon,
            'hover'             => $this->mega_menu_item_icon_hover,
            'important'         => false
        ));
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'megamenu_item_icon_size',
            'type'              => 'font-size',
            'selector'          => $this->mega_menu_item_icon,
        ) );
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'megamenu_container_padding',
            'type'              => 'padding',
            'selector'          => $this->mega_menu_contianer,
            'hover'             => $this->mega_menu_contianer_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'megamenu_item_padding',
            'type'              => 'padding',
            'selector'          => $this->mega_menu_item,
            'hover'             => $this->mega_menu_item_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'megamenu_item_margin',
            'type'              => 'margin',
            'selector'          => $this->mega_menu_item,
            'hover'             => $this->mega_menu_item_hover,
        ));

		// Menu parents icon
	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_1st_parent_icon_color',
		    'type'              => 'color',
		    'selector'          => $this->first_level_parent_icon,
		    'hover'             => $this->first_level_parent_icon_hover
	    ));
	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_2nd_parent_icon_color',
		    'type'              => 'color',
		    'selector'          => $this->second_level_parent_icon,
		    'hover'             => $this->second_level_parent_icon_hover
	    ));
	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_3rd_parent_icon_color',
		    'type'              => 'color',
		    'selector'          => $this->third_level_parent_icon,
		    'hover'             => $this->third_level_parent_icon_hover
	    ));

	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_1st_parent_icon_background',
		    'type'              => 'background-color',
		    'selector'          => $this->first_level_parent_icon,
		    'hover'             => $this->first_level_parent_icon_hover
	    ));
	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_2nd_parent_icon_background',
		    'type'              => 'background-color',
		    'selector'          => $this->second_level_parent_icon,
		    'hover'             => $this->second_level_parent_icon_hover
	    ));
	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_3rd_parent_icon_background',
		    'type'              => 'background-color',
		    'selector'          => $this->third_level_parent_icon,
		    'hover'             => $this->third_level_parent_icon_hover
	    ));

	    $this->df_process_range( array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_1st_parent_icon_size',
		    'type'              => 'font-size',
		    'selector'          => $this->first_level_parent_icon,
	    ) );
	    $this->df_process_range( array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_2nd_parent_icon_size',
		    'type'              => 'font-size',
		    'selector'          => $this->second_level_parent_icon,
	    ) );
	    $this->df_process_range( array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_3rd_parent_icon_size',
		    'type'              => 'font-size',
		    'selector'          => $this->third_level_parent_icon,
	    ) );

	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_1st_parent_icon_margin',
		    'type'              => 'margin',
		    'selector'          => $this->first_level_parent_icon,
		    'hover'             => $this->first_level_parent_icon_hover,
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_2nd_parent_icon_margin',
		    'type'              => 'margin',
		    'selector'          => $this->second_level_parent_icon,
		    'hover'             => $this->second_level_parent_icon_hover,
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_3rd_parent_icon_margin',
		    'type'              => 'margin',
		    'selector'          => $this->third_level_parent_icon,
		    'hover'             => $this->third_level_parent_icon_hover,
	    ));

	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_1st_parent_icon_padding',
		    'type'              => 'padding',
		    'selector'          => $this->first_level_parent_icon,
		    'hover'             => $this->first_level_parent_icon_hover,
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_2nd_parent_icon_padding',
		    'type'              => 'padding',
		    'selector'          => $this->second_level_parent_icon,
		    'hover'             => $this->second_level_parent_icon_hover,
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_3rd_parent_icon_padding',
		    'type'              => 'padding',
		    'selector'          => $this->third_level_parent_icon,
		    'hover'             => $this->third_level_parent_icon_hover,
	    ));

	    // menu childs icon
	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_1st_child_icon_color',
		    'type'              => 'color',
		    'selector'          => $this->first_level_child_icon,
		    'hover'             => $this->first_level_child_icon_hover
	    ));
	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_2nd_child_icon_color',
		    'type'              => 'color',
		    'selector'          => $this->second_level_child_icon,
		    'hover'             => $this->second_level_child_icon_hover
	    ));
	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_3rd_child_icon_color',
		    'type'              => 'color',
		    'selector'          => $this->third_level_child_icon,
		    'hover'             => $this->third_level_child_icon_hover
	    ));

	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_1st_child_icon_background',
		    'type'              => 'background-color',
		    'selector'          => $this->first_level_child_icon,
		    'hover'             => $this->first_level_child_icon_hover
	    ));
	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_2nd_child_icon_background',
		    'type'              => 'background-color',
		    'selector'          => $this->second_level_child_icon,
		    'hover'             => $this->second_level_child_icon_hover
	    ));
	    $this->df_process_color(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_3rd_child_icon_background',
		    'type'              => 'background-color',
		    'selector'          => $this->third_level_child_icon,
		    'hover'             => $this->third_level_child_icon_hover
	    ));

	    $this->df_process_range( array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_1st_child_icon_size',
		    'type'              => 'font-size',
		    'selector'          => $this->first_level_child_icon,
	    ) );
	    $this->df_process_range( array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_2nd_child_icon_size',
		    'type'              => 'font-size',
		    'selector'          => $this->second_level_child_icon,
	    ) );
	    $this->df_process_range( array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_3rd_child_icon_size',
		    'type'              => 'font-size',
		    'selector'          => $this->third_level_child_icon,
	    ) );

	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_1st_child_icon_margin',
		    'type'              => 'margin',
		    'selector'          => $this->first_level_child_icon,
		    'hover'             => $this->first_level_child_icon_hover,
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_2nd_child_icon_margin',
		    'type'              => 'margin',
		    'selector'          => $this->second_level_child_icon,
		    'hover'             => $this->second_level_child_icon_hover,
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_3rd_child_icon_margin',
		    'type'              => 'margin',
		    'selector'          => $this->third_level_child_icon,
		    'hover'             => $this->third_level_child_icon_hover,
	    ));

	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_1st_child_icon_padding',
		    'type'              => 'padding',
		    'selector'          => $this->first_level_child_icon,
		    'hover'             => $this->first_level_child_icon_hover,
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_2nd_child_icon_padding',
		    'type'              => 'padding',
		    'selector'          => $this->second_level_child_icon,
		    'hover'             => $this->second_level_child_icon_hover,
	    ));
	    $this->set_margin_padding_styles(array(
		    'render_slug'       => $render_slug,
		    'slug'              => 'menu_3rd_child_icon_padding',
		    'type'              => 'padding',
		    'selector'          => $this->third_level_child_icon,
		    'hover'             => $this->third_level_child_icon_hover,
	    ));

        if(isset($disabled[0]) && $disabled[0] == 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%%",
                'declaration' => "display: none !important;",
                'media_query' => $break_point_min,
            ));
        }
        if(isset($disabled[1]) && $disabled[1] == 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%%",
                'declaration' => "display: none !important;",
                'media_query' => $break_point_max,
            ));
        }

        if( isset($this->props['submenu_distance_desktop']) && !empty($this->props['submenu_distance_desktop'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .df-menu-nav>li.menu-item>.sub-menu",
                'declaration' => sprintf('margin-top: %1$s;', $this->props['submenu_distance_desktop']),
                'media_query' => $break_point_min,
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .df-menu-nav>li.menu-item.df-hover:after",
                'declaration' => sprintf('height: %1$s;',
                    $this->props['submenu_distance_desktop']
                ),
                'media_query' => $break_point_min,
            ));
            // ET_Builder_Element::set_style($render_slug, array(
            //     'selector'    => "%%order_class%% .df-menu-nav>li.menu-item>.sub-menu:after",
            //     'declaration' => sprintf('height: %1$s; top: -%1$s;',
            //         $this->props['submenu_distance_desktop']
            //     ),
            //     'media_query' => $break_point_min,
            // ));
        }

        // search styles
        $this->generate_styles(
            array(
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'search_icon',
                'important'      => true,
                'selector'       => '%%order_class%% .df_am_searchsubmit',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon',
                ),
            )
        );
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df_am_searchsubmit',
            'hover'             => '%%order_class%% .df_am_searchsubmit:hover'
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_icon_bg',
            'type'              => 'background-color',
            'selector'          => '%%order_class%% .df_am_searchsubmit',
            'hover'             => '%%order_class%% .df_am_searchsubmit:hover'
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_input_bgcolor',
            'type'              => 'background-color',
            'selector'          => '%%order_class%%',
            'hover'             => '%%order_class%%:hover'
        ));
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%% .df_am_searchsubmit',
        ) );
        $this->process_icon_size($render_slug);
        // style 5
        $this->generate_styles(
            array(
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'search_tr_icon',
                'important'      => true,
                'selector'       => '%%order_class%%.df-am-search-button',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon',
                ),
            )
        );
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_tr_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%%.df-am-search-button',
            'hover'             => '%%order_class%%.df-am-search-button:hover'
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_tr_icon_bg',
            'type'              => 'background-color',
            'selector'          => '%%order_class%%.df-am-search-button',
            'hover'             => '%%order_class%%.df-am-search-button:hover'
        ));
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_tr_icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%%.df-am-search-button'
        ) );
        // search popup
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_popup_bg',
            'type'              => 'background-color',
            'selector'          => '%%order_class%%_modal.df-searchbox-style-5',
            'hover'             => '%%order_class%%_modal.df-searchbox-style-5:hover',
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_popup_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%%_modal.df-searchbox-style-5 .df_am_searchsubmit',
            'hover'             => '%%order_class%%_modal.df-searchbox-style-5 .df_am_searchsubmit:hover',
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_popup_close_color',
            'type'              => 'color',
            'selector'          => '%%order_class%%_modal.df-searchbox-style-5 .serach-box-close',
            'hover'             => '%%order_class%%_modal.df-searchbox-style-5 .serach-box-close:hover',
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_popup_input_color',
            'type'              => 'color',
            'selector'          => '%%order_class%%_modal.df-searchbox-style-5 [type="text"]',
            'hover'             => '%%order_class%%_modal.df-searchbox-style-5 [type="text"]:hover',
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'search_popup_line_color',
            'type'              => 'border-color',
            'selector'          => '%%order_class%%_modal.df-searchbox-style-5 form',
            'hover'             => '%%order_class%%_modal.df-searchbox-style-5 form:hover',
            'important'         => true
        ));

        // fix module alignment
        if(isset($this->props['module_alignment'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%%",
                'declaration' => $module_alignment[$this->props['module_alignment']],
            ));
        }
        if(isset($this->props['module_alignment_tablet'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%%",
                'declaration' => $module_alignment[$this->props['module_alignment_tablet']],
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }
        if(isset($this->props['module_alignment_phone'])) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%%",
                'declaration' => $module_alignment[$this->props['module_alignment_phone']],
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
        // menu item animation
        if($this->props['use_item_animation'] === 'on') {
            // line hover 1
            if($this->props['menu_item_hover_anim'] === 'item-hover-1') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-1 .menu-item>a:after",
                    'declaration' => sprintf('height: %1$s;', $this->props['line_weight'])
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-1 .df-menu-nav > .menu-item>a:after",
                    'declaration' => sprintf('background-color: %1$s;', $this->props['line_color'])
                ));
            }
            // line hover 2
            if($this->props['menu_item_hover_anim'] === 'item-hover-2') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-2 .menu-item>a:before,
                    %%order_class%%.has-item-animation.item-hover-2 .menu-item>a:after",
                    'declaration' => sprintf('height: %1$s;', $this->props['line_weight'])
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-2 .df-menu-nav > .menu-item>a:before,
                    %%order_class%%.has-item-animation.item-hover-2 .df-menu-nav > .menu-item>a:after",
                    'declaration' => sprintf('background-color: %1$s;', $this->props['line_color'])
                ));
            }
            // line hover 3
            if($this->props['menu_item_hover_anim'] === 'item-hover-3') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-3 .menu-item>a:before,
                    %%order_class%%.has-item-animation.item-hover-3 .menu-item>a:after",
                    'declaration' => sprintf('height: %1$s;', $this->props['line_weight'])
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-3 .df-menu-nav > .menu-item>a:before,
                    %%order_class%%.has-item-animation.item-hover-3 .df-menu-nav > .menu-item>a:after",
                    'declaration' => sprintf('background-color: %1$s;', $this->props['line_color'])
                ));
            }
            // line hover 4
            if($this->props['menu_item_hover_anim'] === 'item-hover-4') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-4 .menu-item>a:before,
                    %%order_class%%.has-item-animation.item-hover-4 .menu-item>a:after",
                    'declaration' => sprintf('width: %1$s;', $this->props['line_weight'])
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-4 .df-menu-nav > .menu-item>a:before,
                    %%order_class%%.has-item-animation.item-hover-4 .df-menu-nav > .menu-item>a:after",
                    'declaration' => sprintf('background-color: %1$s;', $this->props['line_color'])
                ));
                // Line Gap Between Text
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-4 .df-menu-nav>.menu-item.df-hover>a:before",
                    'declaration' => sprintf('left: -%1$s;', $this->props['line_space_between_item'])
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-4 .df-menu-nav>.menu-item.df-hover>a:after",
                    'declaration' => sprintf('right: -%1$s;', $this->props['line_space_between_item'])
                ));

            }
            // line hover 5
            if($this->props['menu_item_hover_anim'] === 'item-hover-5') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-5 .df-menu-nav > .menu-item>a:before,
                    %%order_class%%.has-item-animation.item-hover-5 .df-menu-nav > .menu-item>a:after",
                    'declaration' => sprintf('background-color: %1$s;', $this->props['line_color'])
                ));

                // Line Gap Between Text
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-5 .df-menu-nav>.menu-item.df-hover>a:before",
                    'declaration' => sprintf('left: -%1$s;', $this->props['line_space_between_item'])
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "%%order_class%%.has-item-animation.item-hover-5 .df-menu-nav>.menu-item.df-hover>a:after",
                    'declaration' => sprintf('right: -%1$s;', $this->props['line_space_between_item'])
                ));
            }
        }


        // divider
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_width',
            'type'              => 'width',
            'selector'          => '%%order_class%%.df-vr-divider'
        ) );
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'divider_color',
            'type'              => 'background-color',
            'selector'          => '%%order_class%%.df-vr-divider',
            'hover'             => '%%order_class%%.df-vr-divider:hover',
            'important'         => false
        ));

        // icon button
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_btn_icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%%.df-icon-button',
            'hover'             => '%%order_class%%.df-icon-button:hover',
            'important'         => true
        ) );
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'icon_btn_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%%.df-icon-button',
            'hover'             => '%%order_class%%.df-icon-button:hover',
        ));
	    if( "menu" === $this->props['type']){
		    ET_Builder_Element::set_style($render_slug, array(
			    'selector'    => "%%order_class%%",
			    'declaration' => "overflow: visible !important;"
		    ));
	    }
	    //icon-box
	    if( "icon_box" === $this->props['type'] && isset($this->props['icon_btn_icon_color__sticky_enabled']) && str_contains($this->props['icon_btn_icon_color__sticky_enabled'], 'on|')){
		    $sticky_icon_color = $this->props['icon_btn_icon_color__sticky'] ? $this->props['icon_btn_icon_color__sticky'] : "#000000";
			ET_Builder_Element::set_style($render_slug, array(
				'selector'    => ".et_pb_sticky %%order_class%%.df-icon-button",
				'declaration' => sprintf('color: %1$s !important;', esc_attr( $sticky_icon_color ) )
			));
        }

        // cart styles
        $this->generate_styles(
            array(
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'cart_icon',
                'important'      => true,
                'selector'       => '%%order_class%% .df-cart-info span.cart-icon',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon',
                ),
            )
        );
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'cart_icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%% .df-cart-info span.cart-icon',
            'hover'             => '%%order_class%%:hover .df-cart-info span.cart-icon',
            'important'         => true
        ) );
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'cart_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df-cart-info span.cart-icon',
            'hover'             => '%%order_class%%:hover .df-cart-info span.cart-icon',
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'cart_count_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df-cart-info span.cart-item-count',
            'hover'             => '%%order_class%%:hover .df-cart-info span.cart-item-count',
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'cart_count_bg',
            'type'              => 'background-color',
            'selector'          => '%%order_class%% .df-cart-info span.cart-item-count',
            'hover'             => '%%order_class%%:hover .df-cart-info span.cart-item-count',
        ));
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'cart_total_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .df-cart-info span.cart-total',
            'hover'             => '%%order_class%%:hover .df-cart-info span.cart-total',
        ));
        // mobile button
        if($this->props['mslide_button_icon_on_left'] === 'on' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%%_mslide_btn .df-mslide-button-icon",
                'declaration' => 'margin-right: 5px;',
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%%_mslide_btn .df-mslide-button-icon",
                'declaration' => 'margin-left: 5px;',
            ));
        }
        $this->generate_styles(
            array(
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'mslide_button_font_icon',
                'important'      => true,
                'selector'       => '%%order_class%%_mslide_btn .df-mslide-button-icon',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon',
                ),
            )
        );

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'mslide_button_padding',
            'type'              => 'padding',
            'selector'          => $this->mslide_button,
            'hover'             => $this->mslide_button_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'mslide_button_margin',
            'type'              => 'margin',
            'selector'          => $this->mslide_button,
            'hover'             => '%%order_class%%_mslide_btn:hober',
        ));
        // button icon
        if($this->props['button_icon_on_left'] === 'on' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .df-am-button-icon",
                'declaration' => 'margin-right: 5px;',
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => "%%order_class%% .df-am-button-icon",
                'declaration' => 'margin-left: 5px;',
            ));
        }

         // show icon on hover
         if ('off' !== $this->props['button_show_icon_on_hover']) {
            $icon_size = "" !== $this->props['content_body_font_size'] ? $this->props['content_body_font_size'] : "14px";

            if ('on' !== $this->props['button_icon_on_left']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element.df-menu-button.show_icon_on_hover .df-am-button-icon",
                    'declaration' => "margin: 0px; margin-right: -" . $icon_size . " !important; opacity: 0 !important;"
                ));

                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element.df-menu-button.show_icon_on_hover:hover .df-am-button-icon",
                    'declaration' => "margin-right:0px !important; opacity: 1 !important;"
                ));
            }
            else {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element.df-menu-button.show_icon_on_hover .df-am-button-icon",
                    'declaration' => "margin-left: -" . $icon_size . " !important; opacity: 0 !important;"
                ));

                ET_Builder_Element::set_style($render_slug, array(
                    'selector'    => "$this->main_css_element.df-menu-button.show_icon_on_hover:hover .df-am-button-icon",
                    'declaration' => "margin: 0px; margin-left:0px !important; opacity: 1 !important;"
                ));
            }

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => ".df-am-container .df-am-col.show_icon_on_hover",
                'declaration' => "min-width: 140px;"
            ));
        }

        $this->generate_styles(
            array(
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'button_font_icon',
                'important'      => true,
                'selector'       => '%%order_class%% .df-am-button-icon',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon',
                ),
            )
        );
        $this->generate_styles(
            array(
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'icon_btn_font_icon',
                'important'      => true,
                'selector'       => '%%order_class%%.df-icon-button span',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon',
                ),
            )
        );
        $this->generate_styles(
            array(
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'search_icon',
                'important'      => true,
                'selector'       => '%%order_class%% .df_am_searchsubmit, %%order_class%%_modal .df_am_searchsubmit',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon',
                ),
            )
        );
        $this->generate_styles(
            array(
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'search_tr_icon',
                'important'      => true,
                'selector'       => '%%order_class%%.df-am-search-button',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon',
                ),
            )
        );
        $this->generate_styles(
            array(
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'mm_trigger_icon',
                'important'      => true,
                'selector'       => $this->mslide_trigger_button,
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon',
                ),
            )
        );


        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'mm_icon_color',
            'type'              => 'color',
            'selector'          => "%%order_class%% .df-mobile-menu-button",
            'hover'             => $this->mslide_trigger_button_hover
        ));
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'mm_icon_size',
            'type'              => 'font-size',
            'selector'          => $this->mslide_trigger_button,
            'important'         => true
        ) );

        // menu items
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'menu_item_gap',
            'type'              => 'gap',
            'selector'          => '%%order_class%% .df-normal-menu-wrap .df-menu-nav'
        ) );

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'menu_icon_color',
            'type'              => 'color',
            'selector'          => $this->menu_item_icon,
            'hover'             => $this->menu_item_icon_hover,
            'important'         => false
        ));
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'menu_item_icon_size',
            'type'              => 'font-size',
            'selector'          => $this->menu_item_icon
        ) );

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'menu_item_margin',
            'type'              => 'margin',
            'selector'          => $this->menu_item,
            'hover'             => $this->menu_item_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'menu_item_padding',
            'type'              => 'padding',
            'selector'          => $this->menu_item,
            'hover'             => $this->menu_item_hover,
        ));
        // submenu items
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'submenu_icon_color',
            'type'              => 'color',
            'selector'          => $this->submenu_item_icon,
            'hover'             => $this->submenu_item_icon_hover,
            'important'         => false
        ));
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'submenu_item_icon_size',
            'type'              => 'font-size',
            'selector'          => $this->submenu_item_icon,
        ) );
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'submenu_item_margin',
            'type'              => 'margin',
            'selector'          => $this->submenu_item,
            'hover'             => $this->submenu_item_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'submenu_item_padding',
            'type'              => 'padding',
            'selector'          => $this->submenu_item,
            'hover'             => $this->submenu_item_hover,
        ));

        // Active state
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'top_level_menu_active_color',
            'type'              => 'color',
            'selector'          => "%%order_class%% .df-normal-menu-wrap .df-menu-nav>li.menu-item.current-menu-item>a , %%order_class%% .df-normal-menu-wrap .df-menu-nav>li.current_page_ancestor>a",
            'hover'             => '%%order_class%% .df-normal-menu-wrap .df-menu-nav>li.menu-item.current-menu-item>a:hover, %%order_class%% .df-normal-menu-wrap .df-menu-nav>li.current_page_ancestor>a:hover',
            'important'         => true
        ));
        $this->df_process_new_background_styles(
            array(
                'props'    => $this->props,
                'key'      => 'top_lebel_menu_active_link_bg',
                'selector' => "%%order_class%% .df-normal-menu-wrap .df-menu-nav>li.menu-item.current-menu-item>a , %%order_class%% .df-normal-menu-wrap .df-menu-nav>li.current_page_ancestor>a",
                'hover'    => '%%order_class%% .df-normal-menu-wrap .df-menu-nav>li.menu-item.current-menu-item>a:hover , %%order_class%% .df-normal-menu-wrap .df-menu-nav>li.current_page_ancestor>a:hover',
            )
        );

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'top_level_menu_active_border_color',
            'type'              => 'border-color',
            'selector'          => "%%order_class%% .df-normal-menu-wrap .df-menu-nav>li.menu-item.current-menu-item>a , %%order_class%% .df-normal-menu-wrap .df-menu-nav>li.current_page_ancestor>a",
            'hover'             => '%%order_class%% .df-normal-menu-wrap .df-menu-nav>li.menu-item.current-menu-item>a:hover, %%order_class%% .df-normal-menu-wrap .df-menu-nav>li.current_page_ancestor>a:hover',
            'important'         => true
        ));

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'sub_menu_active_color',
            'type'              => 'color',
            'selector'          => "%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) li.menu-item.current-menu-item> a,
                                    %%order_class%% .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu li.current-menu-item>a,
                                    %%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) li.menu-item.current-menu-ancestor> a",
            'hover'             => "%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) li.menu-item.current-menu-item>a:hover, %%order_class%% .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu li.current-menu-item>a:hover",
            'important'         => true
        ));


        $this->df_process_new_background_styles(
            array(
                'props'     => $this->props,
                'key'       => 'sub_menu_active_link_bg',
                'selector'  => "%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) li.menu-item.current-menu-item> a,
                                %%order_class%% .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu li.current-menu-item>a,
                                %%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) li.menu-item.current-menu-ancestor> a",
                'hover'     => "%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) li.menu-item.current-menu-item>a:hover, %%order_class%% .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu li.current-menu-item>a:hover",
            )
        );

        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'sub_menu_active_border_color',
            'type'              => 'border-color',
            'selector'          => "%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) li.menu-item.current-menu-item> a,
                                    %%order_class%% .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu li.current-menu-item>a,
                                    %%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) li.menu-item.current-menu-ancestor> a",
            'hover'             => "%%order_class%% .df-normal-menu-wrap li:not(.df-mega-menu) .sub-menu:not(.df-custom-submenu):not(.df-inside-mega-menu) li.menu-item.current-menu-item>a:hover, %%order_class%% .df-normal-menu-wrap .df-menu-wrap .df-menu-nav>li.df-mega-menu li.current-menu-item>a:hover",
            'important'         => true
        ));


        // mobile slide
        $this->df_process_color(array(
            'render_slug'       => $render_slug,
            'slug'              => 'mm_item_icon_color',
            'type'              => 'color',
            'selector'          => ".df-mobile-menu %%order_class%% li.menu-item>a .df-menu-icon",
            'hover'             => '.df-mobile-menu %%order_class%% li.menu-item>a:hover .df-menu-icon',
            'important'         => false
        ));
        $this->df_process_range( array(
            'render_slug'       => $render_slug,
            'slug'              => 'mm_item_icon_size',
            'type'              => 'font-size',
            'selector'          => ".df-mobile-menu %%order_class%% li.menu-item>a .df-menu-icon",
        ) );
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'mslide_item_margin',
            'type'              => 'margin',
            'selector'          => $this->mslide_item,
            'hover'             => $this->mslide_item_hover,
        ));
        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'mslide_item_padding',
            'type'              => 'padding',
            'selector'          => $this->mslide_item,
            'hover'             => $this->mslide_item_hover,
        ));

        $this->set_margin_padding_styles(array(
            'render_slug'       => $render_slug,
            'slug'              => 'mmenu_trigger_padding',
            'type'              => 'padding',
            'selector'          => $this->mslide_trigger_button,
            'hover'             => $this->mslide_trigger_button_hover,
        ));

    }

    public function render($attrs, $content, $render_slug) {
		$this->handle_fa_icon();
        global $df_menu, $df_menu_mobile;

        $type_settings = array();

        $type_settings['type'] = $this->props['type'];
        $type_settings['class'] = ET_Builder_Element::get_module_order_class( $render_slug );
        $type_settings['indexClass'] = $type_settings['class'];
        $type_settings['link_option_url'] = isset($this->props['link_option_url']) ? $this->props['link_option_url'] : '';
        // $type_settings['class'] = isset($this->props['hide_from_small']) && $this->props['hide_from_small'] === 'on' ?
        //     $type_settings['class'] . ' hide_from_small' : $type_settings['class'];

        // cart
        $type_settings['cart_icon'] = isset($this->props['cart_icon']) && '' != $this->props['cart_icon'] ?
            esc_attr( et_pb_process_font_icon($this->props['cart_icon']) ) : '';
        $type_settings['use_cart_count'] = isset($this->props['use_cart_count']) ?
            $this->props['use_cart_count'] : 'off';
        $type_settings['use_cart_total'] = isset($this->props['use_cart_total']) ?
            $this->props['use_cart_total'] : 'off';

        // search
        $type_settings['search_style'] = isset($this->props['search_style']) ?
            $this->props['search_style'] : '' ;
        $type_settings['placeholder'] = isset($this->props['placeholder']) ?
            $this->props['placeholder'] : '' ;
        $type_settings['search_icon'] = isset($this->props['search_icon']) ?
            esc_attr( et_pb_process_font_icon($this->props['search_icon']) ) : 'U' ;
        $type_settings['search_tr_icon'] = isset($this->props['search_tr_icon']) ?
            esc_attr( et_pb_process_font_icon($this->props['search_tr_icon']) ) : 'U' ;

        // button icon
        $type_settings['icon_btn_font_icon'] = isset($this->props['icon_btn_font_icon']) ?
            esc_attr( et_pb_process_font_icon($this->props['icon_btn_font_icon']) ) : '';
        $type_settings['icon_link_title'] = isset($this->props['icon_link_title']) ?
            $this->props['icon_link_title'] : '';
        $type_settings['icon_box_url'] = isset($this->props['icon_box_url']) ?
            $this->props['icon_box_url'] : '';
        $type_settings['icon_box_url_new_window'] = isset($this->props['icon_box_url_new_window']) ?
            $this->props['icon_box_url_new_window'] : '';

        // mobile button
        if($this->props['use_mslide_btn'] == 'on') {
            $type_settings['use_mslide_btn'] = isset($this->props['use_mslide_btn']) ? $this->props['use_mslide_btn'] : 'Button Text';
            $type_settings['mslide_button_text'] = isset($this->props['mslide_button_text']) ? $this->props['mslide_button_text'] : '';
            $type_settings['mslide_button_url'] = isset($this->props['mslide_button_url']) ?
                $this->props['mslide_button_url'] : '';
            $type_settings['mslide_button_url_new_window'] = isset($this->props['mslide_button_url_new_window']) ?
                $this->props['mslide_button_url_new_window'] : '';
            $type_settings['mslide_use_button_icon'] = isset($this->props['mslide_use_button_icon']) ?
                $this->props['mslide_use_button_icon'] : '';
            $type_settings['mslide_button_font_icon'] = isset($this->props['mslide_button_font_icon']) ?
                esc_attr( et_pb_process_font_icon($this->props['mslide_button_font_icon']) ) : '';
            $type_settings['mslide_button_icon_on_left'] = isset($this->props['mslide_button_icon_on_left']) ?
                $this->props['mslide_button_icon_on_left'] : '';
        }

        // logo
        $type_settings['logo_upload'] = isset($this->props['logo_upload']) ? $this->props['logo_upload'] : '';
        $type_settings['sticky_logo'] = isset($this->props['sticky_logo']) ? $this->props['sticky_logo'] : '';
        $type_settings['logo_alt'] = isset($this->props['logo_alt']) ? $this->props['logo_alt'] : '';
        $type_settings['logo_url'] = isset($this->props['logo_url']) ? $this->props['logo_url'] : '';
        $type_settings['logo_url_new_window'] = isset($this->props['logo_url_new_window']) ?
            $this->props['logo_url_new_window'] : '';

        // button
        $type_settings['button_text'] = isset($this->props['button_text']) ? $this->props['button_text'] : 'Button Text';
        $type_settings['button_url'] = isset($this->props['button_url']) ? $this->props['button_url'] : '';
        $type_settings['button_url_new_window'] = isset($this->props['button_url_new_window']) ?
            $this->props['button_url_new_window'] : '';
        $type_settings['use_button_icon'] = isset($this->props['use_button_icon']) ?
            $this->props['use_button_icon'] : '';
        $type_settings['button_font_icon'] = isset($this->props['button_font_icon']) ?
            esc_attr( et_pb_process_font_icon($this->props['button_font_icon']) ) : '';
        $type_settings['button_icon_on_left'] = isset($this->props['button_icon_on_left']) ?
            $this->props['button_icon_on_left'] : '';
        $type_settings['button_show_icon_on_hover'] = isset($this->props['button_show_icon_on_hover']) ?
            $this->props['button_show_icon_on_hover'] : '';
        // content
        $type_settings['content'] = $this->props['content'] !== '' ? $this->props['content'] : '';

        // navigation menu
        $type_settings['menu_id'] = isset($this->props['menu_id']) ? $this->props['menu_id'] : '';
        $type_settings['desktop_menu'] = isset($this->props['desktop_menu']) ? $this->props['desktop_menu'] : '';
        $type_settings['mobile_menu'] = isset($this->props['mobile_menu']) ? $this->props['mobile_menu'] : '';
        $type_settings['use_item_hover'] = isset($this->props['use_item_animation']) ? $this->props['use_item_animation'] : 'off';
        $type_settings['item_hover'] = isset($this->props['menu_item_hover_anim']) ? $this->props['menu_item_hover_anim'] : 'item-hover-1';

        // submenu
        $type_settings['submenu_reveal_anime'] = isset($this->props['submenu_reveal_anime']) ?
        $this->props['submenu_reveal_anime'] : 'animtaion-submenu-1';
        $type_settings['use_submenu_arrow'] = isset($this->props['use_submenu_arrow']) ?
        $this->props['use_submenu_arrow'] : 'off';

        // social
        $type_settings['social'] = isset($this->props['social']) ? $this->props['social'] : '';


        // mobile menu trigger button
        $type_settings['mm_trigger_icon'] = isset($this->props['mm_trigger_icon']) ?
            esc_attr( et_pb_process_font_icon($this->props['mm_trigger_icon']) ) : 'a';

        // common
        if(isset($this->props['menu_item_position']) && $this->props['menu_item_position'] !== '') {
            $df_menu[$this->props['menu_item_position']][] = $type_settings;
        } else {
            $df_menu['center_left'][] = $type_settings;
        }
        if(isset($this->props['menu_item_position_small']) && $this->props['menu_item_position_small'] !== '') {
            $df_menu_mobile[$this->props['menu_item_position_small']][] = $type_settings;
        } else {
            $df_menu_mobile['center_left'][] = $type_settings;
        }

        $this->additional_css_styles($render_slug, $attrs);

        return '';
    }
}

new DIFL_AdvancedMenuItem;
