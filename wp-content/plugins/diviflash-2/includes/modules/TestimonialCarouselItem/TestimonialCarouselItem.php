<?php

class DIFL_TestimonialCarouselItem extends ET_Builder_Module {
    public $slug       = 'difl_testimonialcarouselitem';
    public $vb_support = 'on';
    public $type       = 'child';
    public $child_title_var          = 'author';
	public $child_title_fallback_var = 'admin_label';
    use DF_UTLS;

    protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
    );

    public function init() {
        $this->name = esc_html__( 'Testimonial Carousel Item', 'divi_flash' );
        $this->main_css_element = "%%order_class%%";
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'content'               => esc_html__('Content', 'divi_flash'),
                    'images'                => esc_html__('Images', 'divi_flash'),
                    'settings'              => esc_html__('Settings', 'divi_flash'),
                    'image'                 => esc_html__('Author Image', 'divi_flash'),
                    'company_logo'          => esc_html__('Company Logo', 'divi_flash'),
                    'rating'                => esc_html__('Rating', 'divi_flash')
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'font'                      => array (
                        'title'         => esc_html__('Font Style', 'divi_flash'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'name'   => array(
                                'name' => 'Name'
                            ),
                            'title'     => array(
                                'name' => 'Title',
                            ),
                            'company'     => array(
                                'name' => 'Company',
                            ),
                            'body'     => array(
                                'name' => 'Body',
                            )
                        )
                    ),
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();

        $advanced_fields['fonts'] = array (
            'name'     => array(
                'label'         => esc_html__( 'Name', 'divi_flash' ),
                'toggle_slug'   => 'font',
                'sub_toggle'    => 'name',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '18px',
                ),
                'css'      => array(
                    'main' => ".difl_testimonialcarousel {$this->main_css_element} .df_tc_author_info .author_name",
                    'hover' => ".difl_testimonialcarousel {$this->main_css_element}:hover .df_tc_author_info .author_name",
                    'important'	=> 'all'
                ),
            ),
            'title'     => array(
                'label'         => esc_html__( 'Job Title', 'divi_flash' ),
                'toggle_slug'   => 'font',
                'sub_toggle'    => 'title',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => ".difl_testimonialcarousel {$this->main_css_element} .tc_job_title",
                    'hover' => ".difl_testimonialcarousel {$this->main_css_element}:hover .tc_job_title",
                    'important'	=> 'all'
                ),
            ),
            'company'     => array(
                'label'         => esc_html__( 'Company', 'divi_flash' ),
                'toggle_slug'   => 'font',
                'sub_toggle'    => 'company',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'hide_text_align'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => ".difl_testimonialcarousel {$this->main_css_element} .tc_company",
                    'hover' => ".difl_testimonialcarousel {$this->main_css_element}:hover .tc_company",
                    'important'	=> 'all'
                ),
            ),
            'body'     => array(
                'label'         => esc_html__( 'Body', 'divi_flash' ),
                'toggle_slug'   => 'font',
                'sub_toggle'    => 'body',
                'tab_slug'		=> 'advanced',
                'hide_text_shadow'  => true,
                'line_height' => array (
                    'default' => '1em',
                ),
                'font_size' => array(
                    'default' => '14px',
                ),
                'css'      => array(
                    'main' => ".difl_testimonialcarousel {$this->main_css_element} .df_tc_content",
                    'hover' => ".difl_testimonialcarousel {$this->main_css_element}:hover .df_tc_content",
                    'important'	=> 'all'
                ),
            ),
        );
        $advanced_fields['borders'] = array (
            'default'             => array (
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".difl_testimonialcarousel {$this->main_css_element} > div:first-child",
                        'border_styles' => ".difl_testimonialcarousel {$this->main_css_element} > div:first-child",
                        'border_styles_hover' => ".difl_testimonialcarousel {$this->main_css_element} > div:first-child:hover",
                    )
                )
            )
        );

        $advanced_fields['background'] = array (
            'css' => array (
                'main'  => ".difl_testimonialcarousel {$this->main_css_element} .df_tci_container"
            )
        );
        $advanced_fields['text'] = false;
        $advanced_fields['filters'] = false;
        $advanced_fields['box_shadow'] = false;
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
                'default_on_front'=> 'Carousel Item'
            )
        );
        $content = array (
            'author' => array (
                'label'                 => esc_html__( 'Author', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'content',
                'dynamic_content'       => 'text'
            ),
            'job_title' => array (
                'label'                 => esc_html__( 'Job Title', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'content',
                'dynamic_content'       => 'text'
            ),
            'company' => array (
                'label'                 => esc_html__( 'Company', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'content',
                'dynamic_content'       => 'text'
            ),
            'company_url' => array (
                'label'                 => esc_html__( 'Company Url', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'content',
                'dynamic_content'       => 'url'
            ),
            'content'        => array (
                'label'                 => esc_html__('Body', 'divi_flash'),
                'type'                  => 'tiny_mce',
                'toggle_slug'           => 'content',
                'dynamic_content'       => 'text'
            )
        );
        $image = array (
            'image' => array (
                'label'                 => esc_html__( 'Author Image', 'divi_flash' ),
				'type'                  => 'upload',
                'option_category'       => 'basic_option',
				'upload_button_text'    => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'           => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'           => esc_attr__( 'Set As Image', 'divi_flash' ),
                'toggle_slug'           => 'images',
                'dynamic_content'       => 'image'
            ),
            'author_image_alt_text' => array (
                'label'                 => esc_html__( 'Author Image Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'images',
                'show_if_not'           => array(
                    'image' => array('')
                ),
            ),
            'company_logo' => array (
                'label'                 => esc_html__( 'Company Logo', 'divi_flash' ),
				'type'                  => 'upload',
                'option_category'       => 'basic_option',
				'upload_button_text'    => esc_attr__( 'Upload an image', 'divi_flash' ),
				'choose_text'           => esc_attr__( 'Choose an Image', 'divi_flash' ),
				'update_text'           => esc_attr__( 'Set As Image', 'divi_flash' ),
                'toggle_slug'           => 'images',
                'dynamic_content'       => 'image'
            ),
            'company_logo_alt_text' => array (
                'label'                 => esc_html__( 'Company Logo Alt Text', 'divi_flash' ),
				'type'                  => 'text',
                'toggle_slug'           => 'images',
                'show_if_not'           => array(
                    'company_logo' => array('')
                ),
            )
        );
        $rating = array (
            'rating'    => array (
                'label'             => esc_html__('Enable Rating', 'divi_flash'),
                'type'              => 'yes_no_button',
                'options'           => array(
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
                ),
                'default'           => 'off',
                'toggle_slug'       => 'settings'
            ),

            'rating_scale_type'   => array(
                'label'           => esc_html__('Rating Scale Type', 'divi_flash'),
                'description'     => esc_html__('Choose Rating Scale Type', 'divi_flash'),
                'type'            => 'select',
                'default'         => '5',
                'options'         => array(
                    '5'   => esc_html__('0-5', 'divi_flash'),
                    '10'  => esc_html__('0-10', 'divi_flash'),
                ),
                'option_category' => 'basic_option',
                'toggle_slug'     => 'settings',
                'show_if'     => array(
                    'rating' => 'on'
                )
            ),

            'rating_value_5' => array(
                'label'             => esc_html__('Rating Value', 'divi_flash'),
                'description'       => esc_html__('Set Rating Value', 'divi_flash'),
                'type'              => 'range',
                'default'           => '5',
                'range_settings'    => array(
                    'min'       => '0.1',
                    'max'       => '5',
                    'step'      => '0.1',
                    'min_limit' => '0',
                    'max_limit' => '5'
                ),
                'toggle_slug'   => 'settings',
                'show_if'       => array(
                    'rating'            => 'on',
                    'rating_scale_type' => '5'
                )
            ),

            'rating_value_10' => array(
                'label'             => esc_html__('Rating Value', 'divi_flash'),
                'description'       => esc_html__('Set Rating Value', 'divi_flash'),
                'type'              => 'range',
                'default'           => '10',
                'range_settings'    => array(
                    'min'       => '0.1',
                    'max'       => '10',
                    'step'      => '0.1',
                    'min_limit' => '0',
                    'max_limit' => '10'
                ),
                'toggle_slug'     => 'settings',
                'show_if'         => array(
                    'rating'            => 'on',
                    'rating_scale_type' => '10'
                )
            ),
        );
        $quote = $this->df_add_icon_settings(array (
            'title'                 => 'Enable Quote Icon',
            'image_title'           => 'Image for Quote Icon',
            'key'                   => 'quote_icon',
            'toggle_slug'           => 'settings',
            'default_size'          => '48px',
            'icon_alignment'        => false,
            'image_styles'          => false,
            'circle_icon'           => false,
            'icon_color'            => false,
            'icon_size'             => false,
            'image_alt'             => true,
            'dynamic_option'        => true
        ));

        return array_merge(
            $general,
            $content,
            $image,
            $rating,
            $quote
        );
    }

    public function get_transition_fields_css_props() {
        $fields = parent::get_transition_fields_css_props();

        return $fields;
    }

    public function additional_css_styles($render_slug) {
        // icon font family
        if(method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
            $this->generate_styles(
                array(
                    'utility_arg'    => 'icon_font_family',
                    'render_slug'    => $render_slug,
                    'base_attr_name' => 'quote_icon_font_icon',
                    'important'      => true,
                    'selector'       => '%%order_class%% .et-pb-icon.df_tc_quote_icon',
                    'processor'      => array(
                        'ET_Builder_Module_Helper_Style_Processor',
                        'process_extended_icon',
                    ),
                )
            );
        }

        if(isset($this->props['background_repeat']) && 'no-repeat' === $this->props['background_repeat']){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '.difl_testimonialcarousel %%order_class%% .df_tci_container',
                'declaration' => 'background-repeat: inherit;',
            ));
        }
    }

    public function render( $attrs, $content, $render_slug ) {
        $this->additional_css_styles($render_slug);
        array_push($this->classname, 'swiper-slide');

        $company_logo_image = $this->props['company_logo'] !== '' ? $this->props['company_logo'] : '';
        $company_logo_alt_text = $this->props['company_logo_alt_text'] !== '' ? $this->props['company_logo_alt_text']  : df_image_alt_by_url($company_logo_image);
        $company_logo = $this->props['company_logo'] !== '' ? sprintf('
            <div class="df_tc_company_logo">
                <img class="tc_company_logo" alt="%2$s" src="%1$s" />
            </div>
        ',
        $company_logo_image,
        $company_logo_alt_text
        )
        : '';

        $content = $this->props['content'] !== '' ? sprintf('
            <div class="df_tc_content">
                %1$s
            </div>    
        ', $this->props['content']) : '';
        $author_image_url = $this->props['image'] !== '' ? $this->props['image'] : '';
        $author_image_alt_text = $this->props['author_image_alt_text'] !== '' ? $this->props['author_image_alt_text']  : df_image_alt_by_url($author_image_url);

        $author_image = $this->props['image'] !== '' ? sprintf('
            <div class="df_tc_author_image">
                <img class="tc_author_image" alt="%2$s" src="%1$s" />
            </div>  
        ',
        $author_image_url ,
        $author_image_alt_text
        ) : '';
        $author_name = $this->props['author'] !== '' ?
            sprintf('<h4 class="author_name">%1$s<h4/>', $this->props['author'] ) : '';
        
        $job_title = $this->props['job_title'] !== '' ?
            sprintf('<span class="tc_job_title">%1$s</span>', $this->props['job_title']) : '';

        $company = '';
        if ($this->props['company'] !== '') {
            if ($this->props['company_url'] !== '') {
                $company = sprintf('
                    <a href="%2$s" target="_blank" class="tc_company">%1$s</a>', 
                    $this->props['company'], esc_attr($this->props['company_url'])) ;
            } else {
                $company = sprintf('
                    <span class="tc_company">%1$s</span>', 
                    $this->props['company']);
            }
        }
        
        $separator = $job_title !== '' && $company !== '' ? ', ' : '';

        $info = $author_name !== '' || $job_title !== '' || $company !== '' ?
            sprintf('<div class="df_tc_author_info">%1$s%2$s %3$s</div>',
            $author_name, $job_title, $company) : '';

        $info_box = $author_image !== '' || $info !== '' ? sprintf('
                <div class="df_tc_author_box">%1$s%2$s</div>
            ', $author_image, $info) : '';

   

        // Rating Icon only
        $get_rating_icon = "☆";

        // Rating scale type
        $rating_scale_type =  !empty($this->props['rating_scale_type']) ? $this->props['rating_scale_type'] : 5;

        $rating_value = $rating_scale_type == 5
            ? ($this->props['rating_value_5'] <= 5 && $this->props['rating_value_5'] >= 0
                ? $this->props['rating_value_5'] : 5) : ($this->props['rating_value_10'] <= 10 && $this->props['rating_value_10'] >= 0
                ? $this->props['rating_value_10'] : 10);

        // Get float value
        $get_float = explode('.', $rating_value);

        $rating_icon = '';
        $rating_active_class = '';

        // Display Rating Icon
        for ($i = 1; $i <= $rating_scale_type; $i++) {
            if (!isset($rating_value)) {
                $rating_active_class = '';
            } else if ($i <= $rating_value) {
                $rating_active_class = 'df_rating_icon_fill';
            } else if ($i == $get_float[0] + 1 && isset($get_float[1]) && $get_float[1] != '' && $get_float[1] != 0) {
                $rating_active_class = 'df_rating_icon_fill df_rating_icon_empty df_fill_' . $get_float[1];
            } else {
                $rating_active_class = 'df_rating_icon_empty';
            }
            $rating_icon .= '<span class="et-pb-icon ' . $rating_active_class . '" data-icon="' . $get_rating_icon . '">' . $get_rating_icon . '</span>';
        }
        $rating = $this->props['rating'] === 'on' ?  //df_tc_ratings
                sprintf('
                    <div class="df_tc_ratings">
                        %1$s
                    </div>
                ',
                $rating_icon 
                ) : '';

        $parent_module = isset(self::get_parent_modules('page')['difl_testimonialcarousel']) ? self::get_parent_modules('page') ['difl_testimonialcarousel']: new stdClass;

        return sprintf('%6$s<div class="df_tci_container">
                %7$s
                <div class="df_tci_inner">
                    %5$s
                    %1$s
                    %2$s
                    %3$s
                    %4$s
                </div>
            </div>',
            $company_logo,
            $content,
            $info_box,
            $rating,
            $this->df_render_image('quote_icon'),
            df_print_background_mask_and_pattern_dynamic_modules( $parent_module->props ),
            df_print_background_mask_and_pattern_dynamic_modules( $this->props )
        );
    }

    /**
     * Render image for the front image
     * 
     * @param String $key
     * @return HTML | markup for the image
     */
    public function df_render_image($key = '') {
        if ( isset($this->props[$key . '_use_icon']) && $this->props[$key . '_use_icon'] === 'on' ) {
            return sprintf('<div class="df_tc_quote_image"><span class="et-pb-icon df_tc_quote_icon">%1$s</span></div>', 
                isset($this->props[$key . '_font_icon']) && $this->props[$key . '_font_icon'] !== '' ? 
                    esc_attr(et_pb_process_font_icon( $this->props[$key . '_font_icon'] )) : '{'
            );
        } else if ( isset($this->props[$key . '_image']) && $this->props[$key . '_image'] !== ''){
            $image_alt = $this->props[$key . '_alt_text'] !== '' ? $this->props[$key . '_alt_text']  : df_image_alt_by_url($this->props[$key . '_image']);
            $image_url = $this->props[$key . '_image'];  
            return sprintf('<div class="df_tc_quote_image">
                    <img class="tc_quote_image" alt="%2$s" src="%1$s" />
                </div>',
                esc_url($image_url),
                esc_attr($image_alt)
            );
        }
    }
}
new DIFL_TestimonialCarouselItem;
