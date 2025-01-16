<?php

class DIFL_AdvancedDataTable extends ET_Builder_Module {
	public $slug = 'difl_advanced_data_table';
	public $vb_support = 'on';
	use DF_UTLS;

	protected $module_credits = [
		'module_uri' => '',
		'author'     => 'DiviFlash',
		'author_uri' => '',
	];

	public function init() {
		$this->name             = esc_html__( 'Data Table', 'divi_flash' );
		$this->main_css_element = '%%order_class%%';
		$this->icon_path        = DIFL_ADMIN_DIR_PATH . 'dashboard/static/module-icons/advanceddatatable.svg';
	}

	public function get_settings_modal_toggles() {
		return [
			'general'  => [
				'toggles' => [
					'general_settings' => esc_html__( 'Table Content', 'divi_flash' ),
					'table_options'    => esc_html__( 'Table Options', 'divi_flash' ),
				],
			],
			'advanced' => [
				'toggles' => [
					'design_table'    => esc_html__( 'Table', 'divi_flash' ),
					'design_head'     => esc_html__( 'Head', 'divi_flash' ),
					'design_body'     => esc_html__( 'Body', 'divi_flash' ),
					'design_search'   => esc_html__( 'Search', 'divi_flash' ),
					'design_info'     => esc_html__( 'Info', 'divi_flash' ),
					'design_paging'   => esc_html__( 'Pagination', 'divi_flash' ),
					'design_font'     => [
						'title'             => esc_html__( 'Font Style', 'divi_flash' ),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => [
							'input'          => [
								'name' => 'Input',
							],
							'current_button' => [
								'name' => 'Act Btn',
							],
							'disable_button' => [
								'name' => 'Dis Btn',
							],
						],
					],
					'design_image'    => esc_html__( 'Image', 'divi_flash' ),
					'design_icon'     => esc_html__( 'Icon', 'divi_flash' ),
					'design_link'     => esc_html__( 'Link', 'divi_flash' ),
					'design_no_match' => esc_html__( 'No Match', 'divi_flash' ),
					'design_border'   => esc_html__( 'Border Style', 'divi_flash' ),
					'custom_spacing'  => [
						'title'             => esc_html__( 'Custom Spacing', 'divi_flash' ),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => [
							'wrapper' => [
								'name' => 'Wrapper',
							],
							'content' => [
								'name' => 'Content',
							],
						],
					],

				],
			],
		];
	}

	public function get_advanced_fields_config() {
		$advanced_fields          = [];
		$advanced_fields['fonts'] = [
			'head_text' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'toggle_slug' => 'design_head',
				'tab_slug'    => 'advanced',
				'line_height' => [
					'default' => '1em',
				],
				'font_size'   => [
					'default' => '14px',
				],
				'font-weight' => [
					'default' => 'bold',
				],
				'css'         => [
					'main'      => ' %%order_class%% .df-advanced-table__head-column-cell ',
					'hover'     => '%%order_class%% .df-advanced-table__head:hover .df-advanced-table__head-column-cell',
					'important' => 'all',
				],
			],
			'row_text'  => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'toggle_slug' => 'design_body',
				'tab_slug'    => 'advanced',
				'line_height' => [
					'default' => '1em',
				],
				'font_size'   => [
					'default' => '14px',
				],
				'font-weight' => [
					'default' => 'semi-bold',
				],
				'css'         => [
					'main'      => '%%order_class%% .df-advanced-table__body-row-cell ',
					'hover'     => '%%order_class%% .df-advanced-table__body-row:hover .df-advanced-table__body-row-cell',
					'important' => 'all',
				],
			],

			'no_match_text' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'toggle_slug' => 'design_no_match',
				'tab_slug'    => 'advanced',
				'line_height' => [
					'default' => '1em',
				],
				'font_size'   => [
					'default' => '14px',
				],
				'font-weight' => [
					'default' => 'semi-bold',
				],
				'css'         => [
					'main'      => '%%order_class%% .df-advanced-table__body .dataTables_empty ',
					'hover'     => '%%order_class%% .df-advanced-table__body .dataTables_empty:hover',
					'important' => 'all',
				],
			],

			'search_lebel_text' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_search',
				'line_height' => [
					'default' => '1em',
				],
				'font_size'   => [
					'default' => '14px',
				],
				'css'         => [
					'main'      => '%%order_class%% .dataTables_filter label',
					'hover'     => '%%order_class%% .dataTables_filter label:hover',
					'important' => 'all',
				],
			],

			'search_input_text' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'sub_toggle'  => 'input',
				'toggle_slug' => 'design_font',
				'line_height' => [
					'default' => '1em',
				],
				'font_size'   => [
					'default' => '14px',
				],
				'css'         => [
					'main'      => '%%order_class%% .dataTables_wrapper .dataTables_filter input',
					'hover'     => '%%order_class%% .dataTables_wrapper .dataTables_filter input:hover',
					'important' => 'all',
				],
			],

			'pagination_disable_button_text' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'sub_toggle'  => 'disable_button',
				'toggle_slug' => 'design_font',
				'line_height' => [
					'default' => '1em',
				],
				'font_size'   => [
					'default' => '14px',
				],
				'css'         => [
					'main'      => '%%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button.disabled',
					'hover'     => '%%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button.disabled:hover',
					'important' => 'all',
				],
			],

			'pagination_current_button_text' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'sub_toggle'  => 'current_button',
				'toggle_slug' => 'design_font',
				'line_height' => [
					'default' => '1em',
				],
				'font_size'   => [
					'default' => '14px',
				],
				'css'         => [
					'main'      => '%%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button.current',
					'hover'     => '%%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button.current:hover',
					'important' => 'all',
				],
			],

			'paging_text' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_paging',
				'line_height' => [
					'default' => '1em',
				],
				'font_size'   => [
					'default' => '14px',
				],
				'css'         => [
					'main'      => '%%order_class%% .dataTables_paginate a.paginate_button,
                               %%order_class%% .dataTables_paginate span a.paginate_button',
					'hover'     => '%%order_class%% .dataTables_paginate a.paginate_button:hover',
					'important' => 'all',
				],
			],
			'info_text'   => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_info',
				'line_height' => [
					'default' => '1em',
				],
				'font_size'   => [
					'default' => '14px',
				],
				'css'         => [
					'main'  => '%%order_class%% .dataTables_info, 
                               %%order_class%% .dataTables_wrapper .dataTables_length label,
                               %%order_class%% .dataTables_wrapper .dataTables_length select',
					'hover' => '%%order_class%% .dataTables_wrapper .dataTables_length select:hover,
                    %%order_class%% .dataTables_info:hover,
                    %%order_class%% .dataTables_wrapper .dataTables_length label:hover',
				],
			],

			'link_text' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'toggle_slug' => 'design_link',
				'tab_slug'    => 'advanced',
				'line_height' => [
					'default' => '1em',
				],
				'font_size'   => [
					'default' => '14px',
				],
				'font-weight' => [
					'default' => 'semi-bold',
				],
				'css'         => [
					'main'      => '%%order_class%% .df-advanced-table__body-row-cell a',
					'hover'     => '%%order_class%% .df-advanced-table__body-row-cell a:hover',
					'important' => 'all',
				],
			],

		];

		$advanced_fields['borders']        = [
			'default'      => [],
			'table_border' => [
				'css'         => [
					'main' => [
						'border_radii'        => "{$this->main_css_element} table.dataTable",
						'border_radii_hover'  => "{$this->main_css_element} .df_adt_container:hover table.dataTable",
						'border_styles'       => "{$this->main_css_element} table.dataTable",
						'border_styles_hover' => "{$this->main_css_element} .df_adt_container:hover table.dataTable",
					],
				],
				'defaults'    => [
					'border_radii'  => 'on|0px|0px|0px|0px',
					'border_styles' => [
						'width' => '1px',
						'color' => 'rgb(102, 102, 102)',
						'style' => 'solid',
					],
				],
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_table',
			],
			'head_border'  => [
				'css'         => [
					'main' => [
						'border_radii'        => "{$this->main_css_element} .df-advanced-table__head-column-cell",
						'border_radii_hover'  => "{$this->main_css_element} .df-advanced-table__head:hover .df-advanced-table__head-column-cell",
						'border_styles'       => "{$this->main_css_element} .df-advanced-table__head-column-cell",
						'border_styles_hover' => "{$this->main_css_element} .df-advanced-table__head:hover .df-advanced-table__head-column-cell",
					],
				],
				'defaults'    => [
					'border_radii'  => 'on|0px|0px|0px|0px',
					'border_styles' => [
						'width' => '0px|0px|1px|0px',
						'color' => '#111',
						'style' => 'solid',
					],
				],
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_head',
			],

			'row_border' => [
				'css'         => [
					'main' => [
						'border_radii'        => "{$this->main_css_element} .df-advanced-table__body-row-cell",
						'border_radii_hover'  => "{$this->main_css_element} .df-advanced-table__body-row:hover .df-advanced-table__body-row-cell",
						'border_styles'       => "{$this->main_css_element} .df-advanced-table__body-row-cell",
						'border_styles_hover' => "{$this->main_css_element} .df-advanced-table__body-row:hover .df-advanced-table__body-row-cell",
					],
				],
				'defaults'    => [
					'border_radii'  => 'on|0px|0px|0px|0px',
					'border_styles' => [
						'width' => '1px|0px|0px|0px',
						'color' => '#eee',
						'style' => 'solid',
					],
				],
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_body',
			],

			'search_input_border' => [
				'css'         => [
					'main' => [
						'border_radii'        => "{$this->main_css_element} .dataTables_wrapper .dataTables_filter input",
						'border_radii_hover'  => "{$this->main_css_element} .dataTables_wrapper .dataTables_filter input:hover",
						'border_styles'       => "{$this->main_css_element} .dataTables_wrapper .dataTables_filter input",
						'border_styles_hover' => "{$this->main_css_element} .dataTables_wrapper .dataTables_filter input:hover",
					],
				],
				'defaults'    => [
					'border_radii'  => 'on|0px|0px|0px|0px',
					'border_styles' => [
						'width' => '1px',
						'color' => '#D0D9E2',
						'style' => 'solid',
					],
				],
				'label'       => esc_html__( 'Input', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_search',
			],

			'info_border' => [
				'css'         => [
					'main' => [
						'border_radii'        => "{$this->main_css_element} .dataTables_wrapper .dataTables_length select",
						'border_radii_hover'  => "{$this->main_css_element} .dataTables_wrapper .dataTables_length select:hover",
						'border_styles'       => "{$this->main_css_element} .dataTables_wrapper .dataTables_length select",
						'border_styles_hover' => "{$this->main_css_element} .dataTables_wrapper .dataTables_length select:hover",
					],
				],
				'defaults'    => [
					'border_radii'  => 'on|0px|0px|0px|0px',
					'border_styles' => [
						'width' => '1px',
						'color' => '#D0D9E2',
						'style' => 'solid',
					],
				],
				'label'       => esc_html__( 'Info', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_info',
			],


			'pagination_button_border' => [
				'css'         => [
					'main' => [
						'border_radii'        => "{$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button,
                                                {$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button.current,
                                                {$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button.disabled",
						'border_radii_hover'  => "{$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button:hover,
                                                {$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button.current:hover,
                                                {$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button.disabled:hover",
						'border_styles'       => "{$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button,
                                                {$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button.current,
                                                {$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button.disabled",
						'border_styles_hover' => "{$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button:hover,
                                                {$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button.current:hover,
                                                {$this->main_css_element} .dataTables_wrapper .dataTables_paginate a.paginate_button.disabled:hover",
					],
				],
				'defaults'    => [
					'border_radii'  => 'on|2px|2px|2px|2px',
					'border_styles' => [
						'width' => '0px',
						'color' => '#D0D9E2',
						'style' => 'solid',
					],
				],
				'label'       => esc_html__( 'Pagination Button', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_paging',
			],

			'link_border' => [
				'css'         => [
					'main' => [
						'border_radii'        => "{$this->main_css_element} .df-advanced-table__body-row-cell a",
						'border_radii_hover'  => "{$this->main_css_element} .df-advanced-table__body-row-cell a:hover",
						'border_styles'       => "{$this->main_css_element} .df-advanced-table__body-row-cell a",
						'border_styles_hover' => "{$this->main_css_element} .df-advanced-table__body-row-cell a:hover",
					],
				],
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_link',
			],

			'image_border' => [
				'css'         => [
					'main' => [
						'border_radii'        => "{$this->main_css_element} .df-advanced-table__body-row-cell img",
						'border_radii_hover'  => "{$this->main_css_element} .df-advanced-table__body-row-cell:hover img",
						'border_styles'       => "{$this->main_css_element} .df-advanced-table__body-row-cell img",
						'border_styles_hover' => "{$this->main_css_element} .df-advanced-table__body-row-cell:hover img",
					],
				],
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_image',
			],

			'icon_border' => [
				'css'         => [
					'main' => [
						'border_radii'        => "{$this->main_css_element} .df-advanced-table__body-row-cell span",
						'border_radii_hover'  => "{$this->main_css_element} .df-advanced-table__body-row-cell:hover span",
						'border_styles'       => "{$this->main_css_element} .df-advanced-table__body-row-cell span",
						'border_styles_hover' => "{$this->main_css_element} .df-advanced-table__body-row-cell:hover span",
					],
				],
				'label'       => esc_html__( '', 'divi_flash' ),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_icon',
			],

		];
		$advanced_fields['box_shadow']     = [
			'default'      => true,
			'table_shadow' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'css'         => [
					'main'  => '%%order_class%% table.dataTable',
					'hover' => '%%order_class%% .df_adt_container:hover table.dataTable',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_table',
			],
			'head_shadow'  => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'css'         => [
					'main'  => '%%order_class%% .df-advanced-table__head-column-cell',
					'hover' => '%%order_class%% .df-advanced-table__head:hover .df-advanced-table__head-column-cell',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_head',
			],

			'row_shadow' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'css'         => [
					'main'  => '%%order_class%% .df-advanced-table__body-row-cell',
					'hover' => '%%order_class%% .df-advanced-table__body-row:hover .df-advanced-table__body-row-cell',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_body',
			],

			'search_shadow' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'css'         => [
					'main'  => '%%order_class%% .dataTables_wrapper .dataTables_filter input',
					'hover' => '%%order_class%% .dataTables_wrapper .dataTables_filter input:hover',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_search',
			],

			'paging_info_shadow' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'css'         => [
					'main'  => '%%order_class%% .dataTables_wrapper .dataTables_length select',
					'hover' => '%%order_class%% .dataTables_wrapper .dataTables_length select:hover',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_info',
			],

			'pagination_button_shadow' => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'css'         => [
					'main'  => '%%order_class%% .dataTables_wrapper .dataTables_paginate .paginate_button',
					'hover' => '%%order_class%% .dataTables_wrapper .dataTables_paginate .paginate_button:hover ',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_paging',
			],
			'link_shadow'              => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'css'         => [
					'main'  => '%%order_class%% .df-advanced-table__body-row-cell a',
					'hover' => '%%order_class%% .df-advanced-table__body-row-cell a:hover',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_link',
			],
			'image_shadow'             => [
				'label'       => esc_html__( '', 'divi_flash' ),
				'css'         => [
					'main'  => '%%order_class%% .df-advanced-table__body-row-cell img',
					'hover' => '%%order_class%% .df-advanced-table__body-row-cell:hover img',
				],
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'design_image',
			],

		];
		$advanced_fields['margin_padding'] = [
			'css' => [
				'important' => 'all',
			],
		];
		$advanced_fields['filters']        = false;
		$advanced_fields['text']           = false;
		$advanced_fields['link_options']   = false;

		return $advanced_fields;
	}

	public function get_fields() {
		$general                 = [
			'table_type'      => [
				'label'       => esc_html__( 'Table Type', 'divi_flash' ),
				'type'        => 'select',
				'options'     => [
					'csv_upload'     => esc_html__( 'CSV Upload', 'divi_flash' ),
					'import_table'   => esc_html__( 'Import Table', 'divi_flash' ),
					'google_sheet'   => esc_html__( 'Google Sheet', 'divi_flash' ),
					'database_table' => esc_html__( 'Database Table', 'divi_flash' ),
					'table_press'    => esc_html__( 'Table Press', 'divi_flash' ),
				],
				'default'     => 'csv_upload',
				'toggle_slug' => 'general_settings',
			],
			'csv_upload_data' => [
				'label'              => esc_html__( 'CSV Upload', 'et_builder' ),
				'description'        => esc_html__( 'Only CSV file will support' ),
				'type'               => 'upload',
				'data_type'          => 'mine',
				'addImage'           => esc_html__( 'Add CSV File', 'et_builder' ),
				'upload_new_text'    => esc_attr__( 'Add CSV File', 'et_builder' ),
				'upload_button_text' => esc_attr__( 'Upload a csv', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose a csv', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As csv', 'et_builder' ),
				'toggle_slug'        => 'general_settings',
				'show_if'            => [
					'table_type' => 'csv_upload',
				],
			],

			'import_table_data' => [
				'label'       => esc_html__( 'CSV Data', 'et_builder' ),
				'description' => esc_html__( 'Put Comma separated Data' ),
				'type'        => 'codemirror',
				'mode'        => 'html',
				'toggle_slug' => 'general_settings',
				'show_if'     => [
					'table_type' => 'import_table',
				],
			],

			'database_tables_list' => [
				'label'       => esc_html__( 'Table Name', 'divi_flash' ),
				'type'        => 'select',
				'options'     => df_db_tables_list(),
				'default'     => 'select',
				'toggle_slug' => 'general_settings',
				'show_if'     => [
					'table_type' => 'database_table',
				],
			],

			'table_press_list' => [
				'label'       => esc_html__( 'Table Name', 'divi_flash' ),
				'type'        => 'select',
				'options'     => df_get_table_press_list(),
				'default'     => 'select',
				'toggle_slug' => 'general_settings',
				'show_if'     => [
					'table_type' => 'table_press',
				],
			],

			'google_api_key' => [
				'label'       => esc_html__( 'Google API Key', 'divi_flash' ),
				'description' => esc_html__( '<a href="https://console.developers.google.com/"> Get API Key</a' ),
				'type'        => 'text',
				'toggle_slug' => 'general_settings',
				'show_if'     => [
					'table_type' => 'google_sheet',
				],

			],

			'google_sheet_id' => [
				'label'       => esc_html__( 'Google Sheet ID', 'divi_flash' ),
				'type'        => 'text',
				'toggle_slug' => 'general_settings',
				'show_if'     => [
					'table_type' => 'google_sheet',
				],

			],

			'google_sheet_range' => [
				'label'       => esc_html__( 'Google Sheets Range', 'divi_flash' ),
				'description' => esc_html__( 'Add Google Sheets Range. Ex: A1:D5', 'divi_flash' ),
				'type'        => 'text',
				'toggle_slug' => 'general_settings',
				'show_if'     => [
					'table_type' => 'google_sheet',
				],

			],

			'google_cache_remove' => [
				'label'       => esc_html__( 'Cache Remove', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'On', 'divi_flash' ),
					'off' => esc_html__( 'Off', 'divi_flash' ),
				],
				'default'     => 'on',
				'toggle_slug' => 'general_settings',
				'show_if'     => [
					'table_type' => 'google_sheet',
				],
			],

		];
		$datatable_options       = [
			'adt_search'         => [
				'label'       => esc_html__( 'Search', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'On', 'divi_flash' ),
					'off' => esc_html__( 'Off', 'divi_flash' ),
				],
				'default'     => 'on',
				'toggle_slug' => 'table_options',
			],
			'adt_paging'         => [
				'label'       => esc_html__( 'Pagination', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'On', 'divi_flash' ),
					'off' => esc_html__( 'Off', 'divi_flash' ),
				],
				'default'     => 'on',
				'toggle_slug' => 'table_options',
			],
			'adt_order'          => [
				'label'       => esc_html__( 'Order', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'On', 'divi_flash' ),
					'off' => esc_html__( 'Off', 'divi_flash' ),
				],
				'default'     => 'off',
				'toggle_slug' => 'table_options',
			],
			'sorting_icon_color' => [
				'label' => esc_html__( 'Sorting Icon Color', 'divi_flash' ),

				'type'        => 'color-alpha',
				'toggle_slug' => 'table_options',
				//'depends_show_if'     => 'on',
				'show_if'     => [
					'adt_order' => 'on',
				],
				'hover'       => false,
			],
			'adt_info'           => [
				'label'       => esc_html__( 'Info', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'On', 'divi_flash' ),
					'off' => esc_html__( 'Off', 'divi_flash' ),
				],
				'default'     => 'on',
				'toggle_slug' => 'table_options',
			],
			'multi_lang_enable'  => [
				'label'       => esc_html__( 'Multi Language', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'on'  => esc_html__( 'On', 'divi_flash' ),
					'off' => esc_html__( 'Off', 'divi_flash' ),
				],
				'default'     => 'off',
				'toggle_slug' => 'table_options',
			],
			'multi_lang_name'    => [
				'label'       => esc_html__( 'Language Name', 'divi_flash' ),
				'type'        => 'select',
				'options'     => [
					'Afrikaans'           => esc_html__( 'Afrikaans', 'divi_flash' ),
					'Albanian'            => esc_html__( 'Albanian', 'divi_flash' ),
					'Arabic'              => esc_html__( 'Arabic', 'divi_flash' ),
					'Armenian'            => esc_html__( 'Armenian', 'divi_flash' ),
					'Bangla'              => esc_html__( 'Bangla', 'divi_flash' ),
					'Basque'              => esc_html__( 'Basque', 'divi_flash' ),
					'Belarusian'          => esc_html__( 'Belarusian', 'divi_flash' ),
					'Bulgarian'           => esc_html__( 'Bulgarian', 'divi_flash' ),
					'Catalan'             => esc_html__( 'Catalan', 'divi_flash' ),
					'Chinese-traditional' => esc_html__( 'Chinese-traditional', 'divi_flash' ),
					'Chinese'             => esc_html__( 'Chinese', 'divi_flash' ),
					'Croatian'            => esc_html__( 'Croatian', 'divi_flash' ),
					'Czech'               => esc_html__( 'Czech', 'divi_flash' ),
					'Danish'              => esc_html__( 'Danish', 'divi_flash' ),
					'Dutch'               => esc_html__( 'Dutch', 'divi_flash' ),
					'English'             => esc_html__( 'English', 'divi_flash' ),
					'Estonian'            => esc_html__( 'Estonian', 'divi_flash' ),
					'Filipino'            => esc_html__( 'Filipino', 'divi_flash' ),
					'Finnish'             => esc_html__( 'Finnish', 'divi_flash' ),
					'French'              => esc_html__( 'French', 'divi_flash' ),
					'Galician'            => esc_html__( 'Galician', 'divi_flash' ),
					'Georgian'            => esc_html__( 'Georgian', 'divi_flash' ),
					'German'              => esc_html__( 'German', 'divi_flash' ),
					'Greek'               => esc_html__( 'Greek', 'divi_flash' ),
					'Gujarati'            => esc_html__( 'Gujarati', 'divi_flash' ),
					'Hebrew'              => esc_html__( 'Hebrew', 'divi_flash' ),
					'Hindi'               => esc_html__( 'Hindi', 'divi_flash' ),
					'Hungarian'           => esc_html__( 'Hungarian', 'divi_flash' ),
					'Icelandic'           => esc_html__( 'Icelandic', 'divi_flash' ),
					'Indonesian'          => esc_html__( 'Indonesian', 'divi_flash' ),
					'Irish'               => esc_html__( 'Irish', 'divi_flash' ),
					'Italian'             => esc_html__( 'Italian', 'divi_flash' ),
					'Japanese'            => esc_html__( 'Japanese', 'divi_flash' ),
					'Kazakh'              => esc_html__( 'Kazakh', 'divi_flash' ),
					'Korean'              => esc_html__( 'Korean', 'divi_flash' ),
					'Kyrgyz'              => esc_html__( 'Kyrgyz', 'divi_flash' ),
					'Latvian'             => esc_html__( 'Latvian', 'divi_flash' ),
					'Lithuanian'          => esc_html__( 'Lithuanian', 'divi_flash' ),
					'Macedonian'          => esc_html__( 'Macedonian', 'divi_flash' ),
					'Malay'               => esc_html__( 'Malay', 'divi_flash' ),
					'Mongolian'           => esc_html__( 'Mongolian', 'divi_flash' ),
					'Nepali'              => esc_html__( 'Nepali', 'divi_flash' ),
					'Norwegian-Bokmal'    => esc_html__( 'Norwegian-Bokmal', 'divi_flash' ),
					'Norwegian-Nynorsk'   => esc_html__( 'Norwegian-Nynorsk', 'divi_flash' ),
					'Pashto'              => esc_html__( 'Pashto', 'divi_flash' ),
					'Persian'             => esc_html__( 'Persian', 'divi_flash' ),
					'Polish'              => esc_html__( 'Polish', 'divi_flash' ),
					'Portuguese-Brasil'   => esc_html__( 'Portuguese-Brasil', 'divi_flash' ),
					'Portuguese'          => esc_html__( 'Portuguese', 'divi_flash' ),
					'Romanian'            => esc_html__( 'Romanian', 'divi_flash' ),
					'Russian'             => esc_html__( 'Russian', 'divi_flash' ),
					'Serbian'             => esc_html__( 'Serbian', 'divi_flash' ),
					'Sinhala'             => esc_html__( 'Sinhala', 'divi_flash' ),
					'Slovak'              => esc_html__( 'Slovak', 'divi_flash' ),
					'Slovenian'           => esc_html__( 'Slovenian', 'divi_flash' ),
					'Spanish'             => esc_html__( 'Spanish', 'divi_flash' ),
					'Swahili'             => esc_html__( 'Swahili', 'divi_flash' ),
					'Swedish'             => esc_html__( 'Swedish', 'divi_flash' ),
					'Tamil'               => esc_html__( 'Tamil', 'divi_flash' ),
					'Thai'                => esc_html__( 'Thai', 'divi_flash' ),
					'Turkish'             => esc_html__( 'Turkish', 'divi_flash' ),
					'Ukrainian'           => esc_html__( 'Ukrainian', 'divi_flash' ),
					'Urdu'                => esc_html__( 'Urdu', 'divi_flash' ),
					'Uzbek'               => esc_html__( 'Uzbek', 'divi_flash' ),
					'Vietnamese'          => esc_html__( 'Vietnamese', 'divi_flash' ),
					'Welsh'               => esc_html__( 'Welsh', 'divi_flash' ),
					'telugu'              => esc_html__( 'Telugu', 'divi_flash' ),
				],
				'default'     => 'English',
				'toggle_slug' => 'table_options',
				'show_if'     => [
					'multi_lang_enable' => 'on',
				],
			],

		];
		$search_input_background = $this->df_add_bg_field( [
			'label'       => 'Search Input',
			'key'         => 'search_input_background',
			'toggle_slug' => 'design_search',
			'tab_slug'    => 'advanced',
			'default'     => '#ccc',
			'image'       => false,
		] );
		$table_background        = $this->df_add_bg_field( [
			'label'       => 'Table',
			'key'         => 'table_background',
			'toggle_slug' => 'design_table',
			'tab_slug'    => 'advanced',
			'image'       => false,
		] );
		$head_background         = $this->df_add_bg_field( [
			'label'       => 'Head',
			'key'         => 'head_background',
			'toggle_slug' => 'design_head',
			'tab_slug'    => 'advanced',
			'image'       => false,
		] );
		$row_background          = $this->df_add_bg_field( [
			'label'       => 'Body Row',
			'key'         => 'row_background',
			'toggle_slug' => 'design_body',
			'tab_slug'    => 'advanced',
			'image'       => false,
		] );
		$row_odd_background      = $this->df_add_bg_field( [
			'label'       => 'Body Row Odd',
			'key'         => 'row_odd_background',
			'toggle_slug' => 'design_body',
			'tab_slug'    => 'advanced',
			'image'       => false,
		] );
		$row_even_background     = $this->df_add_bg_field( [
			'label'       => 'Body Row Even',
			'key'         => 'row_even_background',
			'toggle_slug' => 'design_body',
			'tab_slug'    => 'advanced',
			'image'       => false,
		] );

		$paging_button_background = $this->df_add_bg_field( [
			'label'         => 'Pagination Button',
			'key'           => 'paging_button_background',
			'toggle_slug'   => 'design_paging',
			'tab_slug'      => 'advanced',
			'image'         => false,
			'order_reverse' => true,
		] );

		$paging_active_button_background = $this->df_add_bg_field( [
			'label'         => 'Active Button',
			'key'           => 'paging_active_button_background',
			'toggle_slug'   => 'design_paging',
			'tab_slug'      => 'advanced',
			'image'         => false,
			'important'     => true,
			'order_reverse' => true,
		] );

		$info_select_background = $this->df_add_bg_field( [
			'label'       => 'Info Select',
			'key'         => 'info_select_background',
			'toggle_slug' => 'design_info',
			'tab_slug'    => 'advanced',
			'image'       => false,
		] );
		$wrapper_spacing        = [
			'table_wrapper_padding' => [
				'label'          => sprintf( esc_html__( 'Table Wrapper Padding', 'divi_flash' ) ),
				'toggle_slug'    => 'custom_spacing',
				'tab_slug'       => 'advanced',
				'sub_toggle'     => 'wrapper',
				'type'           => 'custom_margin',
				'hover'          => 'tabs',
				'responsive'     => true,
				'mobile_options' => true,
			],

			'search_padding'      => [
				'label'          => sprintf( esc_html__( 'Search Padding', 'divi_flash' ) ),
				'toggle_slug'    => 'custom_spacing',
				'tab_slug'       => 'advanced',
				'sub_toggle'     => 'wrapper',
				'type'           => 'custom_margin',
				'hover'          => 'tabs',
				'mobile_options' => true,
			],
			'paging_info_padding' => [
				'label'          => sprintf( esc_html__( 'Pagination Top Info Padding', 'divi_flash' ) ),
				'toggle_slug'    => 'custom_spacing',
				'sub_toggle'     => 'wrapper',
				'tab_slug'       => 'advanced',
				'type'           => 'custom_margin',
				'hover'          => 'tabs',
				'mobile_options' => true,
			],

			'paging_bottom_info_padding' => [
				'label'          => sprintf( esc_html__( 'Pagination Bottom Info Padding', 'divi_flash' ) ),
				'toggle_slug'    => 'custom_spacing',
				'sub_toggle'     => 'wrapper',
				'tab_slug'       => 'advanced',
				'type'           => 'custom_margin',
				'hover'          => 'tabs',
				'mobile_options' => true,
			],

			'pagination_button_padding' => [
				'label'          => sprintf( esc_html__( 'Pagination Button Padding', 'divi_flash' ) ),
				'toggle_slug'    => 'custom_spacing',
				'sub_toggle'     => 'wrapper',
				'tab_slug'       => 'advanced',
				'type'           => 'custom_margin',
				'hover'          => 'tabs',
				'mobile_options' => true,
			],

			'pagination_spacing' => [
				'label'          => esc_html__( 'Pagination Spacing', 'divi_flash' ),
				'type'           => 'range',
				'sub_toggle'     => 'wrapper',
				'toggle_slug'    => 'custom_spacing',
				'tab_slug'       => 'advanced',
				'default'        => '0px',
				'allowed_units'  => [ 'px' ],
				'range_settings' => [
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				],
				'mobile_options' => true,
			],

		];
		$content_spacing        = [
			'table_padding' => [
				'label'          => sprintf( esc_html__( 'Table Padding', 'divi_flash' ) ),
				'toggle_slug'    => 'custom_spacing',
				'tab_slug'       => 'advanced',
				'sub_toggle'     => 'content',
				'type'           => 'custom_margin',
				'hover'          => 'tabs',
				'responsive'     => true,
				'mobile_options' => true,
			],

			'head_cell_padding' => [
				'label'          => sprintf( esc_html__( 'Head Cell Padding', 'divi_flash' ) ),
				'toggle_slug'    => 'custom_spacing',
				'sub_toggle'     => 'content',
				'tab_slug'       => 'advanced',
				'type'           => 'custom_margin',
				'hover'          => 'tabs',
				'mobile_options' => true,
			],

			'body_cell_padding' => [
				'label'          => sprintf( esc_html__( 'Body Cell Padding', 'divi_flash' ) ),
				'toggle_slug'    => 'custom_spacing',
				'sub_toggle'     => 'content',
				'tab_slug'       => 'advanced',
				'type'           => 'custom_margin',
				'hover'          => 'tabs',
				'mobile_options' => true,
			],

			'search_input_padding' => [
				'label'          => sprintf( esc_html__( 'Search Input Padding', 'divi_flash' ) ),
				'toggle_slug'    => 'custom_spacing',
				'sub_toggle'     => 'content',
				'tab_slug'       => 'advanced',
				'type'           => 'custom_margin',
				'hover'          => 'tabs',
				'mobile_options' => true,
			],

			'search_lebel_spacing' => [
				'label'          => esc_html__( 'Search Label Spacing', 'divi_flash' ),
				'type'           => 'range',
				'sub_toggle'     => 'content',
				'toggle_slug'    => 'custom_spacing',
				'tab_slug'       => 'advanced',
				'default'        => '10px',
				'allowed_units'  => [ 'px' ],
				'range_settings' => [
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				],
				'mobile_options' => true,

			],

			'between_button_spacing' => [
				'label'          => esc_html__( 'Between Button Spacing', 'divi_flash' ),
				'type'           => 'range',
				'sub_toggle'     => 'content',
				'toggle_slug'    => 'custom_spacing',
				'tab_slug'       => 'advanced',
				'default'        => '10px',
				'allowed_units'  => [ 'px' ],
				'range_settings' => [
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				],
				'mobile_options' => true,
			],
		];
		$custom_settings        = [
			'make_head_cell_equal_border' => [

				'label'       => esc_html__( 'Head Cell Equal Border', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				],
				'default'     => 'off',
				'toggle_slug' => 'design_border',
				'tab_slug'    => 'advanced',

			],

			'make_row_cell_equal_border' => [
				'label'       => esc_html__( 'Row Cell Equal Border', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				],
				'default'     => 'off',
				'toggle_slug' => 'design_border',
				'tab_slug'    => 'advanced',

			],

			'make_row_last_cell_border_right_0' => [
				'label'       => esc_html__( 'Row Last Cell Border Right 0', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				],
				'default'     => 'off',
				'toggle_slug' => 'design_border',
				'tab_slug'    => 'advanced',
			],

			'make_row_first_cell_border_left_0' => [
				'label'       => esc_html__( 'Row First Cell Border Left 0', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				],
				'default'     => 'off',
				'toggle_slug' => 'design_border',
				'tab_slug'    => 'advanced',
			],

			'make_first_row_all_cell_border_top_0' => [
				'label'       => esc_html__( 'First Row all Cell Border Top 0', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				],
				'default'     => 'off',
				'toggle_slug' => 'design_border',
				'tab_slug'    => 'advanced',
			],

			'make_last_row_all_cell_border_bottom_0' => [
				'label'       => esc_html__( 'Last Row All Cell Border Bottom 0', 'divi_flash' ),
				'type'        => 'yes_no_button',
				'options'     => [
					'off' => esc_html__( 'Off', 'divi_flash' ),
					'on'  => esc_html__( 'On', 'divi_flash' ),
				],
				'default'     => 'off',
				'toggle_slug' => 'design_border',
				'tab_slug'    => 'advanced',
			],

		];
		$pagination_dot_setting = [
			'pagination_dot_size' => [
				'label'          => esc_html__( 'Dot Size', 'divi_flash' ),
				'type'           => 'range',
				'sub_toggle'     => 'content',
				'toggle_slug'    => 'design_paging',
				'tab_slug'       => 'advanced',
				'default'        => '14px',
				'allowed_units'  => [ 'px' ],
				'range_settings' => [
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				],
				'mobile_options' => true,
				'important'      => false,
			],

			'pagination_dot_color' => [
				'label'       => esc_html__( 'Dot Color', 'divi_flash' ),
				'type'        => 'color-alpha',
				'toggle_slug' => 'design_paging',
				'tab_slug'    => 'advanced',
				'hover'       => 'tabs',
			],

		];
		$icon_settings          = [
			'icon_color' => [
				'label'       => esc_html__( 'Icon Color', 'divi_flash' ),
				'type'        => 'color-alpha',
				'toggle_slug' => 'design_icon',
				'tab_slug'    => 'advanced',
				'hover'       => 'tabs',
			],
			'icon_size'  => [
				'label'          => esc_html__( 'Icon Size', 'divi_flash' ),
				'type'           => 'range',
				'sub_toggle'     => 'content',
				'toggle_slug'    => 'design_icon',
				'tab_slug'       => 'advanced',
				'default'        => '40px',
				'allowed_units'  => [ 'px' ],
				'range_settings' => [
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				],
				'mobile_options' => true,
				'important'      => false,
			],
		];
		$image_settings         = [
			'image_size' => [
				'label'          => esc_html__( 'Image Size', 'divi_flash' ),
				'type'           => 'range',
				'sub_toggle'     => 'content',
				'toggle_slug'    => 'design_image',
				'tab_slug'       => 'advanced',
				'default'        => '50px',
				'allowed_units'  => [ 'px', '%' ],
				'range_settings' => [
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				],
				'mobile_options' => true,
			],
		];
		$link_background        = $this->df_add_bg_field( [
			'label'       => 'Link',
			'key'         => 'link_background',
			'toggle_slug' => 'design_link',
			'tab_slug'    => 'advanced',
			'image'       => false,
		] );
		$link_styling           = [
			'link_padding' => [
				'label'          => esc_html__( 'Link Padding', 'divi_flash' ),
				'toggle_slug'    => 'design_link',
				'sub_toggle'     => 'content',
				'tab_slug'       => 'advanced',
				'type'           => 'custom_margin',
				'hover'          => 'tabs',
				'mobile_options' => true,
			],
		];


		return array_merge(
			$general,
			$datatable_options,
			$search_input_background,
			$table_background,
			$head_background,
			$row_background,
			$row_odd_background,
			$row_even_background,
			$paging_button_background,
			$paging_active_button_background,
			$pagination_dot_setting,
			$info_select_background,
			$wrapper_spacing,
			$content_spacing,
			$custom_settings,
			$image_settings,
			$icon_settings,
			$link_background,
			$link_styling
		);
	}

	public function get_transition_fields_css_props() {
		$fields                          = parent::get_transition_fields_css_props();
		$table                           = "{$this->main_css_element} table.dataTable";
		$head                            = "{$this->main_css_element} .df-advanced-table__head-column-cell";
		$search_input                    = "{$this->main_css_element} .dataTables_wrapper .dataTables_filter input";
		$row                             = "{$this->main_css_element} .df-advanced-table__body-row";
		$image_cell                      = "{$this->main_css_element} .df-advanced-table__body-row-cell img";
		$icon_cell                       = "{$this->main_css_element} .df-advanced-table__body-row-cell span";
		$link_cell                       = "{$this->main_css_element} .df-advanced-table__body-row-cell a";
		$pagination_button               = "{$this->main_css_element} .dataTables_paginate a.paginate_button";
		$sorting_icon                    = "{$this->main_css_element} .df-advanced-table .df-advanced-table__head-column-cell.sorting:after";
		$fields['table_padding']         = [ 'padding' => $table ];
		$fields['table_wrapper_padding'] = [ 'padding' => "{$this->main_css_element} .df_adt_container" ];

		$fields['search_padding']      = [ 'padding' => '%%order_class%% .df_adt_container .dataTables_wrapper .dataTables_filter' ];
		$fields['paging_info_padding'] = [ 'padding' => '%%order_class%% .df_adt_container .dataTables_wrapper .dataTables_length' ];

		$fields['paging_bottom_info_padding'] = [ 'padding' => '%%order_class%% .df_adt_container .dataTables_wrapper .dataTables_info' ];

		$fields['pagination_button_padding'] = [ 'padding' => '%%order_class%% .df_adt_container .dataTables_paginate a.paginate_button' ];

		$fields['head_cell_padding']    = [ 'padding' => '%%order_class%% .df-advanced-table__head-column-cell' ];
		$fields['body_cell_padding']    = [ 'padding' => '%%order_class%% .df-advanced-table__body-row-cell' ];
		$fields['search_input_padding'] = [ 'padding' => '%%order_class%% .dataTables_wrapper .dataTables_filter input' ];
		$fields['link_padding']         = [ 'padding' => '%%order_class%% .df-advanced-table__body-row-cell a' ];
		$fields['sorting_icon_color']   = [ 'color' => $sorting_icon ];
		$fields['icon_color']           = [ 'color' => $icon_cell ];
		$fields                         = $this->df_background_transition( [
			'fields'   => $fields,
			'key'      => 'search_input_background',
			'selector' => $search_input,
		] );

		$fields = $this->df_background_transition( [
			'fields'   => $fields,
			'key'      => 'head_background',
			'selector' => '%%order_class%% .df-advanced-table__head',
		] );

		$fields = $this->df_background_transition( [
			'fields'   => $fields,
			'key'      => 'table_background',
			'selector' => '%%order_class%% .df_adt_container',
		] );

		$fields = $this->df_background_transition( [
			'fields'   => $fields,
			'key'      => 'row_background',
			'selector' => $row,
		] );
		$fields = $this->df_background_transition( [
			'fields'   => $fields,
			'key'      => 'row_background',
			'selector' => '%%order_class%% .df-advanced-table__body-row',
		] );
		$fields = $this->df_background_transition( [
			'fields'   => $fields,
			'key'      => 'row_odd_background',
			'selector' => '%%order_class%% .df-advanced-table__body-row.odd',
		] );
		$fields = $this->df_background_transition( [
			'fields'   => $fields,
			'key'      => 'row_even_background',
			'selector' => '%%order_class%% .df-advanced-table__body-row.even',
		] );

		$fields = $this->df_background_transition( [
			'fields'   => $fields,
			'key'      => 'paging_button_background',
			'selector' => '%%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button',
		] );

		$fields = $this->df_background_transition( [
			'fields'   => $fields,
			'key'      => 'paging_active_button_background',
			'selector' => '%%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button.current',
		] );
		$fields = $this->df_background_transition( [
			'fields'   => $fields,
			'key'      => 'info_select_background',
			'selector' => '%%order_class%% .dataTables_wrapper .dataTables_length select',
		] );

		$fields = $this->df_background_transition( [
			'fields'   => $fields,
			'key'      => 'link_background',
			'selector' => '%%order_class%% tr .df-advanced-table__body-row-cell img',
		] );

		// border
		$fields = $this->df_fix_border_transition(
			$fields,
			'table_border',
			$table
		);
		$fields = $this->df_fix_border_transition(
			$fields,
			'head_border',
			$head
		);

		$fields = $this->df_fix_border_transition(
			$fields,
			'row_border',
			"{$this->main_css_element} .df-advanced-table__body-row .df-advanced-table__body-row-cell"
		);

		$fields = $this->df_fix_border_transition(
			$fields,
			'pagination_button_border',
			$pagination_button
		);

		$fields = $this->df_fix_border_transition(
			$fields,
			'search_input_border',
			$search_input
		);

		$fields = $this->df_fix_border_transition(
			$fields,
			'info_border',
			'%%order_class%% .dataTables_wrapper .dataTables_length select'
		);

		$fields = $this->df_fix_border_transition(
			$fields,
			'image_border',
			$image_cell
		);

		$fields = $this->df_fix_border_transition(
			$fields,
			'link_border',
			$link_cell
		);

		$fields = $this->df_fix_border_transition(
			$fields,
			'icon_border',
			$icon_cell
		);
		// box-shadow transition
		$fields = $this->df_fix_box_shadow_transition(
			$fields,
			'table_shadow',
			$table
		);
		$fields = $this->df_fix_box_shadow_transition(
			$fields,
			'head_shadow',
			$head
		);
		$fields = $this->df_fix_box_shadow_transition(
			$fields,
			'row_shadow',
			$row
		);
		$fields = $this->df_fix_box_shadow_transition(
			$fields,
			'pagination_button_shadow',
			$pagination_button
		);

		$fields = $this->df_fix_box_shadow_transition(
			$fields,
			'paging_info_shadow',
			'%%order_class%% .dataTables_wrapper .dataTables_length select'
		);

		$fields = $this->df_fix_box_shadow_transition(
			$fields,
			'search_shadow',
			$search_input
		);

		$fields = $this->df_fix_box_shadow_transition(
			$fields,
			'image_shadow',
			$image_cell
		);
		$fields = $this->df_fix_box_shadow_transition(
			$fields,
			'link_shadow',
			$link_cell
		);

		return $fields;
	}

	public function additional_css_styles( $render_slug ) {
		ET_Builder_Element::set_style( $render_slug, [
			'selector'    => '%%order_class%% .df_adt_container .df_adt_content',
			'declaration' => 'overflow-x: scroll;',
			'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
		] );

		if ( 'on' === $this->props['make_head_cell_equal_border'] ) {
			ET_Builder_Element::set_style( $render_slug, [
				'selector'    => '%%order_class%% table.df-advanced-table tr.df-advanced-table__head-column .df-advanced-table__head-column-cell:not(:last-child)',
				'declaration' => 'border-right:0px;',
			] );
		}

		if ( 'on' === $this->props['make_row_cell_equal_border'] ) {
			ET_Builder_Element::set_style( $render_slug, [
				'selector'    => '%%order_class%% table.df-advanced-table tr.df-advanced-table__body-row:not(:first-child) .df-advanced-table__body-row-cell',
				'declaration' => 'border-top:0px;',
			] );
			ET_Builder_Element::set_style( $render_slug, [
				'selector'    => '%%order_class%%  table.df-advanced-table tr > td.df-advanced-table__body-row-cell:not(:last-child)',
				'declaration' => 'border-right:0px;',
			] );
		}

		if ( 'on' === $this->props['make_row_last_cell_border_right_0'] ) {
			ET_Builder_Element::set_style( $render_slug, [
				'selector'    => '%%order_class%% table.df-advanced-table tr > td.df-advanced-table__body-row-cell:last-child, %%order_class%% table.df-advanced-table tr.df-advanced-table__head-column .df-advanced-table__head-column-cell:last-child',
				'declaration' => 'border-right:0px;',
			] );
		}
		if ( 'on' === $this->props['make_row_first_cell_border_left_0'] ) {
			ET_Builder_Element::set_style( $render_slug, [
				'selector'    => '%%order_class%% table.df-advanced-table tr > td.df-advanced-table__body-row-cell:first-child , %%order_class%% table.df-advanced-table tr.df-advanced-table__head-column .df-advanced-table__head-column-cell:first-child',
				'declaration' => 'border-left:0px;',
			] );
		}

		if ( 'on' === $this->props['make_first_row_all_cell_border_top_0'] ) {
			ET_Builder_Element::set_style( $render_slug, [
				'selector'    => '%%order_class%% table.df-advanced-table tr.df-advanced-table__head-column .df-advanced-table__head-column-cell',
				'declaration' => 'border-top:0px;',
			] );
		}

		if ( 'on' === $this->props['make_last_row_all_cell_border_bottom_0'] ) {
			ET_Builder_Element::set_style( $render_slug, [
				'selector'    => '%%order_class%% table.df-advanced-table tr:last-child td.df-advanced-table__body-row-cell',
				'declaration' => 'border-bottom:0px;',
			] );
		}

		// padding and margin
		$this->df_process_range( [
			'render_slug' => $render_slug,
			'slug'        => 'pagination_spacing',
			'type'        => 'margin-bottom',
			'selector'    => '%%order_class%% table.dataTable',
		] );
		$this->df_process_range( [
			'render_slug' => $render_slug,
			'slug'        => 'between_button_spacing',
			'type'        => 'margin-right',
			'selector'    => '%%order_class%% .dataTables_paginate a:not(.next)',
		] );
		$this->df_process_range( [
			'render_slug' => $render_slug,
			'slug'        => 'between_button_spacing',
			'type'        => 'margin-left',
			'selector'    => '%%order_class%% .dataTables_paginate a:not(.previous)',
		] );
		$this->df_process_range( [
			'render_slug' => $render_slug,
			'slug'        => 'search_lebel_spacing',
			'type'        => 'margin-left',
			'selector'    => '%%order_class%% .dataTables_wrapper .dataTables_filter input',
		] );

		$this->df_process_range( [
			'render_slug' => $render_slug,
			'slug'        => 'image_size',
			'type'        => 'width',
			'selector'    => '%%order_class%% tr td.df-advanced-table__body-row-cell img,
                                    %%order_class%% tr th.df-advanced-table__head-column-cell img',
		] );

		$this->df_process_range( [
			'render_slug' => $render_slug,
			'slug'        => 'icon_size',
			'type'        => 'font-size',
			'selector'    => '%%order_class%% tr td.df-advanced-table__body-row-cell span',
		] );

		$this->df_process_range( [
			'render_slug' => $render_slug,
			'slug'        => 'pagination_dot_size',
			'type'        => 'font-size',
			'selector'    => '%%order_class%% .dataTables_wrapper .dataTables_paginate .ellipsis',
		] );

		$this->set_margin_padding_styles( [
			'render_slug' => $render_slug,
			'slug'        => 'table_padding',
			'type'        => 'padding',
			'selector'    => '%%order_class%% table.dataTable',
			'hover'       => '%%order_class%% .df_adt_container:hover table.dataTable',
			'important'   => false,
		] );

		$this->set_margin_padding_styles( [
			'render_slug' => $render_slug,
			'slug'        => 'table_wrapper_padding',
			'type'        => 'padding',
			'selector'    => '%%order_class%% .df_adt_container',
			'hover'       => '%%order_class%% .df_adt_container:hover',
			'important'   => false,
		] );

		$this->set_margin_padding_styles( [
			'render_slug' => $render_slug,
			'slug'        => 'search_padding',
			'type'        => 'padding',
			'selector'    => '%%order_class%% .df_adt_container .dataTables_wrapper .dataTables_filter',
			'hover'       => '%%order_class%% .df_adt_container .dataTables_wrapper .dataTables_filter:hover',
			'important'   => true,
		] );

		$this->set_margin_padding_styles( [
			'render_slug' => $render_slug,
			'slug'        => 'paging_info_padding',
			'type'        => 'padding',
			'selector'    => '%%order_class%% .df_adt_container .dataTables_wrapper .dataTables_length',
			'hover'       => '%%order_class%% .df_adt_container .dataTables_wrapper .dataTables_length:hover',
			'important'   => true,
		] );

		$this->set_margin_padding_styles( [
			'render_slug' => $render_slug,
			'slug'        => 'paging_bottom_info_padding',
			'type'        => 'padding',
			'selector'    => '%%order_class%% .df_adt_container .dataTables_wrapper .dataTables_info',
			'hover'       => '%%order_class%% .df_adt_container .dataTables_wrapper .dataTables_info:hover',
			'important'   => true,
		] );


		$this->set_margin_padding_styles( [
			'render_slug' => $render_slug,
			'slug'        => 'pagination_button_padding',
			'type'        => 'padding',
			'selector'    => '%%order_class%% .df_adt_container .dataTables_paginate a.paginate_button',
			'hover'       => '%%order_class%% .df_adt_container .dataTables_paginate a.paginate_button:hover',
			'important'   => true,
		] );


		$this->set_margin_padding_styles( [
			'render_slug' => $render_slug,
			'slug'        => 'body_cell_padding',
			'type'        => 'padding',
			'selector'    => '%%order_class%% .df-advanced-table__body-row-cell',
			'hover'       => '%%order_class%% .df_adt_container .df-advanced-table__body-row-cell:hover',
			'important'   => true,
		] );

		$this->set_margin_padding_styles( [
			'render_slug' => $render_slug,
			'slug'        => 'search_input_padding',
			'type'        => 'padding',
			'selector'    => '%%order_class%% .dataTables_wrapper .dataTables_filter input',
			'hover'       => '%%order_class%% .dataTables_wrapper .dataTables_filter input:hover',
			'important'   => true,
		] );

		$this->set_margin_padding_styles( [
			'render_slug' => $render_slug,
			'slug'        => 'head_cell_padding',
			'type'        => 'padding',
			'selector'    => '%%order_class%% .df-advanced-table__head-column-cell',
			'hover'       => '%%order_class%% .df-advanced-table__head-column-cell:hover',
			'important'   => true,
		] );

		$this->set_margin_padding_styles( [
			'render_slug' => $render_slug,
			'slug'        => 'link_padding',
			'type'        => 'padding',
			'selector'    => '%%order_class%% .df-advanced-table__body-row-cell a',
			'hover'       => '%%order_class%% .df_adt_container .df-advanced-table__body-row-cell a:hover',
			'important'   => true,
		] );

		$this->df_process_color( [
			'render_slug' => $render_slug,
			'slug'        => 'paging_current_button_color',
			'type'        => 'color',
			'selector'    => '%%order_class%% .dataTables_wrapper .dataTables_paginate .paginate_button.current',
			'hover'       => '%%order_class%% .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover',
		] );

		$this->df_process_color( [
			'render_slug' => $render_slug,
			'slug'        => 'icon_color',
			'type'        => 'color',
			'selector'    => '%%order_class%% .df-advanced-table__body-row-cell span',
			'hover'       => '%%order_class%% .df-advanced-table__body-row-cell span:hover',
		] );

		$this->df_process_color( [
			'render_slug' => $render_slug,
			'slug'        => 'pagination_dot_color',
			'type'        => 'color',
			'selector'    => '%%order_class%% .dataTables_wrapper .dataTables_paginate .ellipsis',
			'hover'       => '%%order_class%% .dataTables_wrapper .dataTables_paginate .ellipsis:hover',
		] );

		if ( $this->props['adt_order'] === 'on' ) {
			$this->df_process_color( [
				'render_slug' => $render_slug,
				'slug'        => 'sorting_icon_color',
				'type'        => 'border-bottom-color',
				'default'     => '#333',
				'selector'    => '%%order_class%% .df-advanced-table .df-advanced-table__head-column-cell.sorting:before',
			] );
			$this->df_process_color( [
				'render_slug' => $render_slug,
				'slug'        => 'sorting_icon_color',
				'type'        => 'border-bottom-color',
				'default'     => '#333',
				'selector'    => '%%order_class%%  .df-advanced-table .df-advanced-table__head-column-cell.sorting_asc:before',
			] );

			$this->df_process_color( [
				'render_slug' => $render_slug,
				'slug'        => 'sorting_icon_color',
				'type'        => 'border-top-color',
				'default'     => '#333',
				'selector'    => '%%order_class%% .df-advanced-table .df-advanced-table__head-column-cell.sorting:after',
			] );

			$this->df_process_color( [
				'render_slug' => $render_slug,
				'slug'        => 'sorting_icon_color',
				'type'        => 'border-top-color',
				'default'     => '#333',
				'selector'    => '%%order_class%% .df-advanced-table .df-advanced-table__head-column-cell.sorting_desc:after',
			] );
		}


		$this->df_process_bg( [
			'render_slug' => $render_slug,
			'slug'        => 'search_input_background',
			'selector'    => '%%order_class%% .dataTables_wrapper .dataTables_filter input',
			'hover'       => '%%order_class%% .dataTables_wrapper .dataTables_filter input:hover',
		] );


		$this->df_process_bg( [
			'render_slug' => $render_slug,
			'slug'        => 'head_background',
			'selector'    => '%%order_class%% .df-advanced-table__head',
			'hover'       => '%%order_class%% .df-advanced-table__head:hover',
		] );
		$this->df_process_bg( [
			'render_slug' => $render_slug,
			'slug'        => 'table_background',
			'selector'    => '%%order_class%% .df_adt_container',
			'hover'       => '%%order_class%% .df_adt_container:hover',
		] );
		$this->df_process_bg( [
			'render_slug' => $render_slug,
			'slug'        => 'row_background',
			'selector'    => '%%order_class%% .df-advanced-table__body-row',
			'hover'       => '%%order_class%% .df-advanced-table__body-row:hover',
		] );
		$this->df_process_bg( [
			'render_slug' => $render_slug,
			'slug'        => 'row_odd_background',
			'selector'    => '%%order_class%% .df-advanced-table__body-row.odd',
			'hover'       => '%%order_class%% .df-advanced-table__body-row.odd:hover',
		] );
		$this->df_process_bg( [
			'render_slug' => $render_slug,
			'slug'        => 'row_even_background',
			'selector'    => '%%order_class%% .df-advanced-table__body-row.even',
			'hover'       => '%%order_class%% .df-advanced-table__body-row.even:hover',
		] );
		$this->df_process_bg( [
			'render_slug' => $render_slug,
			'slug'        => 'paging_button_background',
			'selector'    => '%%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button,
                                    %%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button.current,
                                    %%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button.disabled',
			'hover'       => '%%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button:hover,
                                    %%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button.current:hover,
                                    %%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button.disabled:hover',
		] );
		$this->df_process_bg( [
			'render_slug' => $render_slug,
			'slug'        => 'paging_active_button_background',
			'selector'    => '%%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button.current,
                                    %%order_class%% .dataTables_wrapper .dataTables_paginate span a.paginate_button.current',
			'hover'       => '%%order_class%% .dataTables_wrapper .dataTables_paginate span a.paginate_button.current:hover,
                                    %%order_class%% .dataTables_wrapper .dataTables_paginate a.paginate_button.current:hover',
			'important'   => true,
		] );

		$this->df_process_bg( [
			'render_slug' => $render_slug,
			'slug'        => 'info_select_background',
			'selector'    => '%%order_class%% .dataTables_wrapper .dataTables_length select',
			'hover'       => '%%order_class%% .dataTables_wrapper .dataTables_length select:hover',
		] );

		$this->df_process_bg( [
			'render_slug' => $render_slug,
			'slug'        => 'link_background',
			'selector'    => '%%order_class%% .df-advanced-table__body-row a',
			'hover'       => '%%order_class%% .df-advanced-table__body-row a:hover',
		] );
	}

	public function google_sheet_head_function( $columns ) {
		$data = '';
		foreach ( $columns as $column ) :
			$data .= sprintf( '<th class="df-advanced-table__head-column-cell">%1$s</th>', et_core_esc_previously( $column ) );
		endforeach;

		return $data;
	}

	public function get_tds_escape( $num_list ) {
		static $escape_tds = [];
		$new_arr = range( $num_list[0], max( $num_list ) );
		array_push( $escape_tds, array_diff( $new_arr, $num_list ) );
	}

	public function get_merges_cols() {
		$api_key       = esc_html( $this->props['google_api_key'] );
		$sheet_id      = esc_html( $this->props['google_sheet_id'] );
		$url           = "https://sheets.googleapis.com/v4/spreadsheets/$sheet_id?key=$api_key";
		$id            = $this->get_id();
		$transient_key = $id . '_data_table_merges_cache';
		$table_data    = get_transient( $transient_key );

		if ( false === $table_data ) {
			$data       = wp_remote_get( $url );
			$table_data = json_decode( wp_remote_retrieve_body( $data ), true );
			set_transient( $transient_key, $table_data, 0 );
		}
		if ( $this->props['google_cache_remove'] == 'on' ) {
			delete_transient( $transient_key );
		}

		if ( empty( $data ) ) {
			return '';
		}

		return json_decode( wp_remote_retrieve_body( $data ) );
	}

	public function google_sheet_body_function( $table_rows, $table_columns ) {
		$tr_html = '';
		for ( $i = 0; $i < count( $table_rows ); $i ++ ) :
			if ( count( $table_columns ) > count( $table_rows[ $i ] ) ) {
				$diference = count( $table_columns ) - count( $table_rows[ $i ] );

				for ( $j = 0; $j < $diference; $j ++ ) {
					array_push( $table_rows[ $i ], null );
				}
			}

			$tr_html .= '<tr class="df-advanced-table__body-row">';

			foreach ( $table_rows[ $i ] as $key => $row ) :
				$cell = $row == null ? '' : $row;

				$tr_html .= sprintf( '<td class="df-advanced-table__body-row-cell">%1$s</td>', et_core_esc_previously( $cell ) ); //et_core_esc_previously
			endforeach;
			$tr_html .= '</tr>';
		endfor;

		return $tr_html;
	}

	public function google_sheet_render( $id ) {
		$error_message = [];
		$sheet_id      = esc_html( $this->props['google_sheet_id'] );
		$range         = $this->props['google_sheet_range'] ? str_replace( ':', '%3A', esc_html( trim( $this->props['google_sheet_range'] ) ) ) : '';
		$api_key       = esc_html( $this->props['google_api_key'] );
		$base_url      = 'https://sheets.googleapis.com/v4/spreadsheets/';
		$parameters    = '?dateTimeRenderOption=FORMATTED_STRING&majorDimension=ROWS&valueRenderOption=FORMATTED_VALUE&key=';
		$url           = $base_url . $sheet_id . '/values/' . $range . $parameters . $api_key;

		// error handling for editor fields.
		if ( empty( $api_key ) ) {
			$error_message[] = __( 'Add API key', 'divi_flash' );
		} elseif ( empty( $sheet_id ) ) {
			$error_message[] = __( 'Add Google Sheets ID', 'divi_flash' );
		} elseif ( empty( $range ) ) {
			$error_message[] = __( 'Add Sheets Range', 'divi_flash' );
		}
		if ( ! empty( $error_message ) ) {
			return sprintf( '<div class="df-data-table-error">%1$s</div>', $error_message[0] );
		}

		$transient_key = $id . '_data_table_cash';
		$table_data    = get_transient( $transient_key );

		if ( false === $table_data ) {
			$data       = wp_remote_get( $url );
			$table_data = json_decode( wp_remote_retrieve_body( $data ), true );
			set_transient( $transient_key, $table_data, 0 );
		}
		if ( $this->props['google_cache_remove'] == 'on' ) {
			delete_transient( $transient_key );
		}

		// error handling for google sheet
		if ( empty( $table_data ) ) {
			$error_message['sheet_empty'] = __( 'Google Sheet is Empty', 'divi_flash' );

			return sprintf( '<div class="df-data-table-error">%1$s</div>', $error_message['sheet_empty'] );
		} elseif ( ! empty( $table_data ) && ! empty( $table_data['error'] ) ) {
			$error_message['sheet_error'] = $table_data['error']['message'];

			if ( ! empty( $error_message['sheet_error'] ) ) {
				return sprintf( '<div class="df-data-table-error">%1$s</div>', $error_message['sheet_error'] );
			}
		}

		$table_columns = $table_data['values'][0];
		$table_rows    = array_splice( $table_data['values'], 1, count( $table_data['values'] ) );
		// Handle span if any
		$table_rows = $this->google_sheet_span_handler( $table_rows );
		$table_html = '';
		$table_html .= sprintf( '<table class="df-advanced-table">
                            <thead class="df-advanced-table__head"> 
                                <tr class="df-advanced-table__head-column">
                                %1$s
                                </tr>
                            </thead>', $this->google_sheet_head_function( $table_columns ) );
		$table_html .= sprintf( '<tbody class="df-advanced-table__body">
                                  %1$s
                                </tbody>
                        </table>', $this->google_sheet_body_function( $table_rows, $table_columns ) );

		return $table_html;

	}

	public function database_table_head_function( $columns ) {
		$data = '';
		foreach ( array_keys( $columns ) as $key => $column ) :
			$data .= sprintf( '<th class="df-advanced-table__head-column-cell">%1$s</th>', esc_html( $column ) );
		endforeach;

		return $data;
	}

	public function database_table_body_function( $table_rows ) {
		$tr_html = '';
		for ( $i = 0; $i < count( $table_rows ); $i ++ ) :

			$tr_html .= '<tr class="df-advanced-table__body-row">';
			foreach ( $table_rows[ $i ] as $row ) :
				$tr_html .= sprintf( '<td class="df-advanced-table__body-row-cell">%1$s</td>', esc_html( $row ) );
			endforeach;
			$tr_html .= '</tr>';
		endfor;

		return $tr_html;
	}

	public function database_table_render() {
		global $wpdb;

		$table_name = $this->props['database_tables_list'];
		if ( empty( $table_name ) || $table_name === 'select' ) {
			return sprintf( '<div class="df-data-table-error"> %1$s </div>', __( 'Must select a table', 'divi_flash' ) );
		}
		$query = "SELECT * FROM {$table_name}";
		// phpcs:disable WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
		$table = $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM %1s', $table_name ), ARRAY_A ); //phpcs:ignore WordPress.DB.DirectDatabaseQuery
		// phpcs:enable WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder

		if ( is_wp_error( $table ) ) {
			return sprintf( '<div class="df-data-table-error">%1$s</div>', $table->get_error_message() );
		}

		$table_html = '';
		$table_html .= sprintf( '<table class="df-advanced-table">
                                <thead class="df-advanced-table__head"> 
                                    <tr class="df-advanced-table__head-column">
                                     %1$s
                                    </tr>
                                </thead>', $this->database_table_head_function( $table[0] ) );
		$table_html .= sprintf( '<tbody class="df-advanced-table__body">
                                    %1$s
                                </tbody>
            </table>', $this->database_table_body_function( $table ) );

		return $table_html;
	}

	/**
	 *Table Type Tablepress : Data Table Head Creator.
	 *
	 * @param Array $columns
	 *
	 * @return String Table Rows
	 */
	public function tablepress_table_head_function( $columns ) {
		$data = '';
		foreach ( $columns as $key => $column ) :
			$data .= sprintf( '<th class="df-advanced-table__head-column-cell">%1$s</th>', esc_html( $column ) );
		endforeach;

		return $data;
	}

	/**
	 * Table Type Tablepress : Data Table Body Creator.
	 *
	 * @param Array $table_rows
	 *
	 * @return String Table Rows
	 */
	public function tablepress_table_body_function( $table_rows ) {
		$tr_html = '';
		for ( $i = 1; $i < count( $table_rows ); $i ++ ) :

			$tr_html .= '<tr class="df-advanced-table__body-row">';
			foreach ( $table_rows[ $i ] as $row ) :
				$tr_html .= sprintf( '<td class="df-advanced-table__body-row-cell">%1$s</td>', $row );
			endforeach;
			$tr_html .= '</tr>';
		endfor;

		return $tr_html;
	}

	/**
	 * Table Type Tablepress:  Data table render main function
	 * Process the Data Table and Error handaling
	 *
	 * @return String Data Table
	 */
	public function tablepress_render() {


		if ( ! df_is_table_press_activated() ) {
			return sprintf( '<div class="df-data-table-error"> %1$s </div>', __( 'Install TablePress', 'divi_flash' ) );
		}
		if ( empty( df_get_table_press_list() ) ) {
			return sprintf( '<div class="df-data-table-error"> %1$s </div>', __( 'Create Table', 'divi_flash' ) );
		}
		if ( empty( $this->props['table_press_list'] ) ) {
			return sprintf( '<div class="df-data-table-error"> %1$s </div>', __( 'Select Table', 'divi_flash' ) );
		}

		if ( $this->props['table_press_list'] === 'select' ) {
			return sprintf( '<div class="df-data-table-error"> %1$s </div>', __( 'Select Table', 'divi_flash' ) );
		}

		$tables        = [];
		$tables_option = get_option( 'tablepress_tables', '{}' );
		$tables_opt    = json_decode( $tables_option, true );
		$tables        = $tables_opt['table_post'];
		$table_id      = $tables[ $this->props['table_press_list'] ];
		$table_data    = get_post_field( 'post_content', $table_id );
		$tables        = json_decode( $table_data, true );

		$this->attributes();
		$table_html = '';
		$table_html .= sprintf( '<table class="df-advanced-table">
                            <thead class="df-advanced-table__head"> 
                                <tr class="df-advanced-table__head-column">
                                    %1$s 
                                </tr>
                            </thead>', $this->tablepress_table_head_function( $tables[0] ) );
		$table_html .= sprintf( '<tbody class="df-advanced-table__body">
                                    %1$s 
                                </tbody>
        </table>', $this->tablepress_table_body_function( $tables ) );

		return $table_html;

	}

	/**
	 * Table Type CSV upload :  Data Table Head Creator.
	 *
	 * @param Array $columns
	 *
	 * @return String Table Rows
	 */
	public function csv_upload_table_head_function( $columns ) {
		$data = '';
		foreach ( $columns as $key => $column ) :
			$data .= sprintf( '<th class="df-advanced-table__head-column-cell"> %1$s </th>',
				str_replace( '`', ',', mb_convert_encoding( $column, 'UTF-8', mb_detect_encoding( $column, 'UTF-8, ISO-8859-1, ISO-8859-15', true ) ) )
			);
		endforeach;

		return $data;
	}

	/**
	 * Table Type CSV upload : Data Table Body Creator.
	 *
	 * @param Array $table_rows
	 *
	 * @return String Table Rows
	 */

	public function csv_upload_table_body_function( $table_rows ) {
		$tr_html = '';
		for ( $i = 0; $i < count( $table_rows ); $i ++ ) :

			$expr    = "/,(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/";
			$result  = preg_split( $expr, trim( $table_rows[ $i ] ) );
			$rows    = preg_replace( "/^\"(.*)\"$/", '$1', $result );
			$tr_html .= '<tr class="df-advanced-table__body-row">';
			foreach ( $rows as $row ) :
				$tr_html .= sprintf( '<td class="df-advanced-table__body-row-cell">%1$s</td>',
					str_replace( '`', ',', mb_convert_encoding( $row, 'UTF-8', mb_detect_encoding( $row, 'UTF-8, ISO-8859-1, ISO-8859-15', true ) ) ) // change from utf8_encode() for Danish and other language special charecter.
				);
			endforeach;
			$tr_html .= '</tr>';
		endfor;

		return $tr_html;
	}

	/**
	 * Table Type CSV upload:  Data table render main function
	 * Process the Data Table and Error handaling
	 *
	 * @return String Data Table
	 */

	public function csv_upload_table_render() {

		if ( empty( $this->props['csv_upload_data'] ) ) {
			return sprintf( '<div class="df-data-table-error">%1$s</div>', __( 'Only CSV file will Suport. So Upload CSV file.', 'divi_flash' ) );
		}
		$file_url = @fopen( $this->props['csv_upload_data'], 'r' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( ! $file_url ) {
			return sprintf( '<div class="df-data-table-error">%1$s</div>', __( 'File isn\'t available', 'divi_flash' ) );
		}
		$file_parts = pathinfo( $this->props['csv_upload_data'] );
		if ( $file_parts['extension'] !== 'csv' ) {
			$error_message = sprintf( 'Oops! %1$s file can\'t be uploaded, So you have to Upload CSV file.', $file_parts['extension'] );

			return sprintf( '<div class="df-data-table-error">%1$s</div>', $error_message );
		}
		$file = $this->props['csv_upload_data'];

		$delimiter = '';
		if ( $this->df_detectCSVFileDelimiter( $file ) ) {
			$delimiter = $this->df_detectCSVFileDelimiter( $file );
		} else {
			$delimiter .= ',';
		}
		$csv      = [];
		$fileData = file( $file, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES );
		$csv      = array_map(
			function ( $v ) use ( $delimiter ) {
				return str_getcsv( $v, $delimiter );
			},
			$fileData
		);
		$csv_data = [];
		foreach ( $csv as $key => $value ) {
			$change_value = str_replace( ',', '`', $value );
			$change_value = str_replace( '"', '""', $change_value );
			$new_data     = implode( ',', $change_value );

			array_push(
				$csv_data,
				$new_data
			);
		}

		$columns = explode( ',', $csv_data[0] );

		$table_rows = array_splice( $csv_data, 1, count( $csv_data ) );
		$table_html = '';
		$table_html .= sprintf( '<table class="df-advanced-table">
                            <thead class="df-advanced-table__head"> 
                                <tr class="df-advanced-table__head-column">
                                    %1$s
                                 </tr>
                            </thead>', $this->csv_upload_table_head_function( $columns ) );
		$table_html .= sprintf( '<tbody class="df-advanced-table__body">
                             %1$s 
                        </tbody>
		</table>', $this->csv_upload_table_body_function( $table_rows ) );

		return $table_html;

	}

	/**
	 * Detact delimiter from CSV file.
	 * Parse the CSV file and find out the delimiter.
	 *
	 * @param String $csvFile
	 *
	 * @return String the delimiter
	 */
	public function df_detectCSVFileDelimiter( $csvFile ) {
		$delimiters = [ ',' => 0, ';' => 0, "\t" => 0, '|' => 0, ];
		$firstLine  = '';
		$handle     = fopen( $csvFile, 'r' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( $handle ) {
			$firstLine = fgets( $handle );
			fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		}
		if ( $firstLine ) {
			foreach ( $delimiters as $delimiter => &$count ) {
				$count = count( str_getcsv( $firstLine, $delimiter ) );
			}

			return array_search( max( $delimiters ), $delimiters );
		} else {
			return key( $delimiters );
		}
	}

	public function import_table_head_function( $columns ) {
		$data = '';
		foreach ( $columns as $key => $column ) :
			$data .= sprintf( '<th class="df-advanced-table__head-column-cell"> %1$s </th>', $column );
		endforeach;

		return $data;
	}

	public function import_table_body_function( $table_rows ) {
		$tr_html = '';
		for ( $i = 0; $i < count( $table_rows ); $i ++ ) :
			$rows    = explode( ',', $table_rows[ $i ] );
			$expr    = "/,(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/";
			$result  = preg_split( $expr, trim( $table_rows[ $i ] ) );
			$rows    = preg_replace( "/^\"(.*)\"$/", '$1', $result );
			$tr_html .= '<tr class="df-advanced-table__body-row">';
			foreach ( $rows as $row ) :
				$tr_html .= sprintf( '<td class="df-advanced-table__body-row-cell">%1$s</td>', preg_replace( "/\"/", '', $row ) );
			endforeach;
			$tr_html .= '</tr>';
		endfor;

		return $tr_html;
	}

	public function import_table_render() {

		if ( empty( $this->props['import_table_data'] ) ) {
			return sprintf( '<div class="df-data-table-error">%1$s</div>', __( 'Paste Data in CSV format.', 'divi_flash' ) );
		}

		$table_data = explode( "\n", $this->props['import_table_data'] );
		$columns    = explode( ',', $table_data[0] );
		$table_rows = array_splice( $table_data, 1, count( $table_data ) );
		for ( $i = 0; $i < count( $table_rows ); $i ++ ) :
			$rows   = explode( ',', $table_rows[ $i ] );
			$expr   = "/,(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/";
			$result = preg_split( $expr, trim( $table_rows[ $i ] ) );
			$rows   = preg_replace( "/^\"(.*)\"$/", '$1', $result );
			if ( count( $rows ) ) {
				if ( count( $rows ) !== count( $columns ) ) {
					return sprintf( '<div class="df-data-table-error">%1$s</div>', __( 'Datatable Format does\'t match', 'divi_flash' ) );
				}
			}
		endfor;
		$table_html = '';
		$table_html .= sprintf( '<table class="df-advanced-table">
                            <thead class="df-advanced-table__head"> 
                                <tr class="df-advanced-table__head-column">
                                    %1$s
                                 </tr>
                            </thead>', $this->import_table_head_function( $columns ) );
		$table_html .= sprintf( '<tbody class="df-advanced-table__body">
                             %1$s 
                        </tbody>
		</table>', $this->import_table_body_function( $table_rows ) );

		return $table_html;

	}

	public function render( $attrs, $content, $render_slug ) {
		wp_enqueue_script( 'data-table-script' );
		wp_enqueue_script( 'df-advanced-data-table' );

		$data_options = [
			'adt_search'        => isset( $this->props['adt_search'] ) && $this->props['adt_search'] === 'on' ? true : false,
			'adt_paging'        => isset( $this->props['adt_paging'] ) && $this->props['adt_paging'] === 'on' ? true : false,
			'adt_order'         => isset( $this->props['adt_order'] ) && $this->props['adt_order'] === 'on' ? true : false,
			'adt_info'          => isset( $this->props['adt_info'] ) && $this->props['adt_info'] === 'on' ? true : false,
			'multi_lang_enable' => isset( $this->props['multi_lang_enable'] ) && $this->props['multi_lang_enable'] === 'on' ? true : false,
			'multi_lang_name'   => isset( $this->props['multi_lang_name'] ) && $this->props['multi_lang_enable'] === 'on' ? $this->props['multi_lang_name'] : 'English',
			// 'adt_scroll_x'         => isset($this->props['adt_scroll_x']) && $this->props['adt_scroll_x'] === 'on' ? true : false,
		];
		$table_html   = '';
		if ( $this->props['table_type'] == 'google_sheet' ) {
			$table_html .= $this->google_sheet_render( $this->get_id() );
		} elseif ( $this->props['table_type'] == 'database_table' ) {
			$table_html .= $this->database_table_render();
		} elseif ( $this->props['table_type'] == 'table_press' ) {
			$table_html .= $this->tablepress_render();
		} elseif ( $this->props['table_type'] == 'import_table' ) {
			$table_html .= $this->import_table_render();
		} elseif ( $this->props['table_type'] == 'csv_upload' ) {
			$table_html .= $this->csv_upload_table_render();
		}
		$this->additional_css_styles( $render_slug );

		return sprintf( '<div class="df_adt_container" data-options=\'%2$s\'> 
                                <div class="df_adt_content">
                                    %1$s
                                </div>
                        </div>', $table_html, wp_json_encode( $data_options ) );
	}

	protected function google_sheet_span_handler( $rows ) {
		$sheet_data = reset( $this->get_merges_cols()->sheets );
		$merges     = [];

		if ( property_exists( $sheet_data, 'merges' ) && ! empty( $sheet_data->merges ) ) {
			$merges = $sheet_data->merges;
		}

		if ( empty( $merges ) ) {
			return $rows;
		}

		$span_mapper = $this->get_google_sheet_span_mapper( $merges );

		foreach ( $rows as $row_key => $row_data ) {
			foreach ( $row_data as $col_key => $col_data ) {
				if ( $col_data !== '' ) {
					continue;
				}
				$row = $row_key + 2;
				$col = $col_key + 1;

				if ( array_key_exists( $row, $span_mapper['rowspan'] ) ) {
					foreach ( $span_mapper['rowspan'][ $row ] as $item ) {
						$rows[ $row_key ][ $col_key ] = '#rowspan#';
					}
				}
				if ( array_key_exists( $row, $span_mapper['colspan'] ) ) {
					foreach ( $span_mapper['colspan'][ $row ] as $item ) {
						$rows[ $row_key ][ $col_key ] = '#colspan#';
					}
				}
			}
		}

		return $rows;

	}

	protected function get_google_sheet_span_mapper( $merges ) {
		$rowspan = [];
		$colspan = [];

		foreach ( $merges as $cells ) {
			if ( $cells->endRowIndex - $cells->startRowIndex > 1 && $cells->endColumnIndex - $cells->startColumnIndex === 1 ) {
				$rows = [];
				for ( $i = $cells->startRowIndex + 1; $i < $cells->endRowIndex; $i ++ ) {
					$rows[] = $i + 2;
				}
				$rowspan[ $cells->endRowIndex ] = $rows;
			}

			if ( $cells->endColumnIndex - $cells->startColumnIndex > 1 && $cells->endRowIndex - $cells->startRowIndex === 1 ) {
				$cols = [];
				for ( $i = $cells->startColumnIndex + 1; $i < $cells->endColumnIndex; $i ++ ) {
					$cols[] = $i + 1;
				}

				$colspan[ $cells->startRowIndex + 1 ] = $cols;
			}

		}

		return [ 'rowspan' => $rowspan, 'colspan' => $colspan ];

	}
}

new DIFL_AdvancedDataTable;
