<?php
class DF_BG_PROCESS {
    private $module;
    private $options;
    private $important_text;
    private $seperator;
    public $settings = [
        '_bgcolor'                      => '',
        '_use_gradient'                 => 'off',
        '_above_image'                  => 'off',
        '_color_gradient_1'             => '#2b87da',
        '_color_gradient_2'             => '#29c4a9',
        '_gradient_type'                => 'leniar',
        '_gradient_direction'           => '180deg',
        '_start_position'               => '0%',
        '_end_position'                 => '100%',
        '_radial_direction'             => 'center',
        '_background_image'             => '',
        '_background_image_size'        => 'cover',
        '_background_image_position'    => 'center',
        '_background_image_repeat'      => 'no_repeat',
        '_position_horizontal'          => '0%',
        '_position_vertical'            => '0%',
        '_size_width'                   => '50%',
        '_size_height'                  => '50%'
    ];
    private $settings_hover = [];

    function __construct($module, $options) {
        $this->module = $module;
        $this->options = $options;
    }

    /**
     * Set important text data
     * 
     */
    function set_important_text() {
        if ( $this->options['important'] === true ) {
            $this->important_text = '!important';
        }  
    }

    /**
     * Setup the settings data
     * 
     */
    private function set_settings_values() {
        foreach ( $this->settings as $key => $value ) {
            if ( 
                isset($this->module->props[$this->options['slug'] . $key]) && 
                !empty($this->module->props[$this->options['slug'] . $key]) 
            ) {
                $this->settings[$key] = $this->module->props[$this->options['slug'] . $key];
            }   
        }
    }

    /**
     * Setup hover settings data
     * 
     */
    private function set_hover_settings_values() {
        foreach ($this->settings as $key => $value) {
            if ( 
                isset($this->module->props[$this->options['slug'] . $key . '__hover']) && 
                !empty($this->module->props[$this->options['slug'] . $key . '__hover']) 
            ) {
                $this->settings_hover[$key] = $this->module->props[$this->options['slug'] . $key . '__hover'];
            } else {
                $this->settings_hover[$key] = $this->settings[$key];
            }
        }
    }

    /**
     * Set styles 
     * 
     */
    function set_style() {
        $this->set_settings_values();
        $this->set_important_text();

        $this->seperator = $this->settings['_use_gradient'] === 'on' &&
            $this->settings['_background_image'] !== '' ? ', ' : null;
        $background_size = $this->df_process_values($this->settings['_background_image_size']);
        $background_position = $this->df_process_values($this->settings['_background_image_position']);

        if($this->df_process_values($this->settings['_background_image_position']) === 'custom') {
            $background_position = sprintf('%1$s %2$s', $this->settings['_position_horizontal'], $this->settings['_position_vertical']);
        }
        if($this->df_process_values($this->settings['_background_image_size']) === 'custom') {
            $background_size = sprintf('%1$s %2$s', $this->settings['_size_width'], $this->settings['_size_height']);
        }

        // setting up background-color
        if ($this->settings['_bgcolor'] !== '') {
            ET_Builder_Element::set_style($this->options['render_slug'], array(
                'selector' => $this->options['selector'],
                'declaration' => sprintf( 'background-color: %1$s %2$s;',
                    $this->module->props[$this->options['slug'] . '_bgcolor'], 
                    $this->important_text 
                ),
            ));
        }

        if ($this->settings['_use_gradient'] === 'on' || $this->settings['_background_image'] !== '') {
            ET_Builder_Element::set_style($this->options['render_slug'], array(
                'selector' => $this->options['selector'],
                'declaration' => sprintf( 'background-image: %1$s %2$s;
                    background-size:%3$s %2$s;
                    background-position: %4$s %2$s;
                    background-repeat: %5$s %2$s;',
                    $this->background(), 
                    $this->important_text,
                    $background_size,
                    $background_position,
                    $this->df_process_values($this->settings['_background_image_repeat'])
                )
            ));
        }

        // settings up background styles on hover
        if ($this->options['hover'] !== '') {
            $this->set_hover_settings_values();
            $this->set_hover_styles();
        }
    }

    /**
     * Set hover Styles
     * 
     */
    private function set_hover_styles() {
        $background_size = $this->df_process_values($this->settings_hover['_background_image_size']);
        $background_position = $this->df_process_values($this->settings_hover['_background_image_position']);

        if($this->df_process_values($this->settings_hover['_background_image_position']) === 'custom') {
            $background_position = sprintf('%1$s %2$s', $this->settings_hover['_position_horizontal'], $this->settings_hover['_position_vertical']);
        }
        if($this->df_process_values($this->settings_hover['_background_image_size']) === 'custom') {
            $background_size = sprintf('%1$s %2$s', $this->settings_hover['_size_width'], $this->settings_hover['_size_height']);
        }

        if ($this->settings_hover['_bgcolor'] !== '') {
            ET_Builder_Element::set_style($this->options['render_slug'], array(
                'selector' => $this->options['hover'],
                'declaration' => sprintf( 'background-color: %1$s %2$s;',
                    $this->settings_hover['_bgcolor'], 
                    $this->important_text 
                ),
            ));
        }

        if ($this->settings_hover['_use_gradient'] === 'on' || $this->settings_hover['_background_image'] !== '') {
            ET_Builder_Element::set_style($this->options['render_slug'], array(
                'selector' => $this->options['hover'],
                'declaration' => sprintf( 'background-image: %1$s %2$s;
                    background-size:%3$s %2$s;
                    background-position: %4$s %2$s;
                    background-repeat: %5$s %2$s;',
                    $this->background('hover'), 
                    $this->important_text,
                    $background_size,
                    $background_position,
                    $this->df_process_values($this->settings_hover['_background_image_repeat'])
                ),
            ));
        }
    }

    /**
     * Set the background styles
     * 
     */
    private function background($type = 'default') {
        if ( $this->settings['_above_image'] === 'on' ) {
            return sprintf('%2$s%3$s %1$s',
                $this->df_background_image($type),
                $this->df_background_gradient($type),
                $this->seperator
            );
        } else {
            return sprintf('%1$s%3$s %2$s',
                $this->df_background_image($type),
                $this->df_background_gradient($type),
                $this->seperator
            );
        }
    }

    /**
     * Background image
     */
    private function df_background_image($type) {
        $settings = $type === 'default' ? $this->settings : $this->settings_hover;

        if ( $settings['_background_image'] !== '' ) {
            return sprintf('url(%1$s)', $settings['_background_image']);
        }
    }

    /**
     * Background gradient syles
     * 
     */
    private function df_background_gradient($type) {
        $settings = $type === 'default' ? $this->settings : $this->settings_hover;

        if ($settings['_use_gradient'] === 'on' ) {
            if ( $settings['_gradient_type'] !== 'radial') {
                return sprintf('linear-gradient( %3$s, %1$s %4$s, %2$s %5$s )', 
                    $settings['_color_gradient_1'],
                    $settings['_color_gradient_2'],
                    $settings['_gradient_direction'],
                    $settings['_start_position'],
                    $settings['_end_position']
                );
            } else {
                return sprintf('radial-gradient( circle at %3$s, %1$s %4$s, %2$s %5$s )', 
                    $settings['_color_gradient_1'],
                    $settings['_color_gradient_2'],
                    $this->df_process_values($settings['_radial_direction']),
                    $settings['_start_position'],
                    $settings['_end_position']
                );
            }
        }
    }

    
    /**
     * Process values
     */
    function df_process_values($value) {
        $array = array(
            'center'        => 'center',
            'top_left'      => 'top left',
            'top_center'    => 'top center',
            'center_top'    => 'center top',
            'top'           => 'top',
            'top_right'     => 'top right',
            'right'         => 'right',
            'center_right'  => 'center right',
            'bottom_right'  => 'bottom right',
            'bottom'        => 'bottom',
            'bottom_center' => 'bottom center',
            'bottom_left'   => 'bottom left',
            'left'          => 'left',
            'center_left'   => 'center left',
            'no_repeat'     => 'no-repeat',
            'repeat'        => 'repeat',
            'repeat_x'      => 'repeat-x',
            'repeat_y'      => 'repeat-y',
            'space'         => 'space',
            'round'         => 'round',
            'cover'         => 'cover',
            'fit'           => 'contain',
            'actual_size'   => 'initial',
            'custom'        => 'custom'
        );
        return $array[$value];
    }

    /**
     * Process transition
     * 
     * @param Array $options
     * @return Array $fields
     */
    public function df_process_transiton($options) {
        $fields = $options['fields'];
        $key = $options['key'];
        $selector = $options['selector'];
        foreach ($this->settings as $setting => $value ) {
            if ( $setting === '_bgcolor') {
                $fields[$key . $setting ] = array('background-color' => $selector);
            } elseif ( $setting === '_above_image' ) {
                $fields[$key . $setting] = array('background-image' => $selector);
            } elseif ( $setting === '_background_image_size' ) {
                $fields[$key . $setting ] = array('background-image-size' => $selector);
            } elseif ( $setting === '_background_image_position' ) {
                $fields[$key . $setting ] = array('background-image-position' => $selector);
            } elseif ( $setting === '_background_image' ) {
                $fields[$key . $setting ] = array('background-image' => $selector);
            }
            $fields[$key . $setting ] = array('background' => $selector);
        }
        return $fields;
    }
}