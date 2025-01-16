<?php
defined( 'ABSPATH' ) || die();
class Diviflash_Module_Manage {
    const INACTIVE_MODULE_KEY = 'df_inactive_modules';
    const ACTIVE_MODULE_KEY = 'df_active_modules';
    /**
     * Fetch/get all Inactive module from DB
     * @return json respons
     */
    public function get_inactive_modules(){
        return  get_option( self::INACTIVE_MODULE_KEY ) ? get_option( self::INACTIVE_MODULE_KEY, [] ) : "['ProductCarousel','ImageHotspot']";
    }
    public function get_active_modules(){
        return  get_option( self::ACTIVE_MODULE_KEY ) ? get_option( self::ACTIVE_MODULE_KEY, [] ) : "['ProductCarousel','ImageHotspot']";
    }
    public static function get_default_active_modules()
	{
		$default_active = array_filter(self::all_modules_map(), function ($var) {
			return $var['is_default_active'] === true;
		});
		return array_keys($default_active);
	}

    public static function get_default_inactive_modules()
	{
		$default_inactive = array_filter(self::all_modules_map(), function ($var) {
            if(isset($var['is_default_active'])){
                return $var['is_default_active'] == false;
            }

		});
		return array_keys($default_inactive);
	}

    public static function get_new_modules()
	{
		$new_inactive = array_filter(self::all_modules_map(), function ($var) {
            if(isset($var['is_new_module'])){
                return $var['is_new_module'] == true;
            }
			
		});
		return array_keys($new_inactive);
	}

    public static function get_all_modules()
	{

		return self::all_modules_map();
	}

    /**
     * Save Inactive Module list
     *
     * @param array $modles Module array
     */
    public function save_inactive_modules($modules = array()){
        update_option( self::INACTIVE_MODULE_KEY, wp_json_encode($modules) );
    }

    /**
     * Save Inactive Module list
     *
     * @param array $modles Module array
     */
    public function save_active_modules($modules = array()){
        update_option( self::ACTIVE_MODULE_KEY, wp_json_encode($modules) );
    }

    /**
     * All Module store in an array
     * Each array item have parent, parent name, icon property
     * For Child Module have child, child_name property
     * Use at Dashboard
     * New Module array item will add when new module developed
     */
	public static function all_modules_map(){
        $modules = array(
           'AdvancedBlurb' => [
                'parent' => 'AdvancedBlurb',
                'parent_name' => 'Advanced Blurb',
                'icon'  => 'dashboard/static/module-icons/advanced-blurb.svg',
                'release_version' => '1.0.1',
                'is_default_active' => true
             ],
             'AdvancedDataTable' => [
                'parent' => 'AdvancedDataTable',
                'parent_name' => 'Data Table',
                'icon'  => 'dashboard/static/module-icons/advanceddatatable.svg',
                'release_version' => '1.0.6',
                'is_default_active' => true
            ],
            'AdvancedPerson' => [
                'parent' => 'AdvancedPerson',
                'parent_name' => 'Advanced Person',
                'icon'  => 'dashboard/static/module-icons/advanced-person.svg',
                'release_version' => '1.0.7',
                'is_default_active' => true
            ],
            'AdvancedTab' =>[
                'parent' => 'AdvancedTab',
                'parent_name' => 'Advanced Tabs',
                'child'  => 'AdvancedTabItem',
                'child_name'  => 'Advanced Tab Item',
                'icon'  => 'dashboard/static/module-icons/advanced-tabs.svg',
                'release_version' => '1.0.2',
                'is_default_active' => true
            ],
            'ImageGallery' =>[
                'parent' => 'ImageGallery',
                'parent_name' => 'Advanced Gallery',
                'child'=> 'ImageGalleryItem',
                'child_name'=> 'Advanced Gallery Item',
                'icon' => 'dashboard/static/module-icons/image-gallery.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'Heading' =>[
                'parent' => 'Heading',
                'parent_name' => 'Advanced Heading',
                'icon' => 'dashboard/static/module-icons/advanced-heading.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'Heading_Anim' =>[
                'parent' => 'Heading_Anim',
                'parent_name' => 'Animated Heading',
                'icon' => 'dashboard/static/module-icons/animated-heading.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'BlogCarousel' =>[
                'parent' => 'BlogCarousel',
                'parent_name' => 'Post Carousel',
                'child' => 'PostItem',
                'child_name' => 'Post Item',
                'icon' => 'dashboard/static/module-icons/blogcarousel.svg',
                'release_version' => '1.0.4',
                'is_default_active' => true
            ],
            'PostGrid' =>[
                'parent' => 'PostGrid',
                'parent_name' => 'Post Grid',
                'child' => 'PostItem',
                'child_name' => 'Post Item',
                'icon' => 'dashboard/static/module-icons/postgrid.svg',
                'release_version' => '1.0.4',
                'is_default_active' => true
            ],
            'PostList' => [
                'parent' => 'PostList',
                'parent_name' => 'Post List',
                'child' => 'PostListItem',
                'child_name' => 'Post Item',
                'icon' => 'dashboard/static/module-icons/postlist.svg',
                'release_version' => '1.0.4',
                'is_default_active' => false
            ],
            'BusinessHours' =>[
                'parent' => 'BusinessHours',
                'parent_name' => 'Business Hours',
                'child'=> 'BusinessHoursItem',
                'child_name'=> 'Business Hours Item',
                'icon' => 'dashboard/static/module-icons/business-hours.svg',
                'release_version' => '1.0.2',
                'is_default_active' => true
            ],
            'CompareImage' =>[
                'parent' => 'CompareImage',
                'parent_name' => 'Before After Slider',
                'icon' => 'dashboard/static/module-icons/image-compare.svg',
                'release_version' => '1.0.4',
                'is_default_active' => true
            ],
            'CFSeven' =>[
                'parent' => 'CFSeven',
                'parent_name' => 'Contact Form 7 Styler',
                'icon' => 'dashboard/static/module-icons/contact-form-7.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'ContentCarousel' =>[
                'parent' => 'ContentCarousel',
                'parent_name' => 'Advanced Carousel',
                'child'  => 'ContentCarouselItem',
                'child_name'=> 'Advanced Carousel Item',
                'icon' => 'dashboard/static/module-icons/content-carousel.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'DataTable' =>[
                'parent' => 'DataTable',
                'parent_name' => 'Table',
                'child'  => 'DataTableItem',
                'child_name'  => 'Table Row',
                'icon' => 'dashboard/static/module-icons/datatable.svg',
                'release_version' => '1.0.6',
                'is_default_active' => true
            ],
            'DualButton' =>[
                'parent' => 'DualButton',
                'parent_name' => 'Dual Button',
                'icon' => 'dashboard/static/module-icons/dual-button.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'FlipBox' =>[
                'parent' => 'FlipBox',
                'parent_name' => 'Flip Box',
                'icon' => 'dashboard/static/module-icons/flip.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'FloatImage' =>[
                'parent' => 'FloatImage',
                'parent_name' => 'Floating Images',
                'child'=> 'FloatImageItem',
                'child_name'=> 'Float Image Item',
                'icon' => 'dashboard/static/module-icons/float-image.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'HoverBox' =>[
                'parent' => 'HoverBox',
                'parent_name' => 'Hover Box',
                'icon' => 'dashboard/static/module-icons/hover-box.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'ImageAccordion' =>[
                'parent' => 'ImageAccordion',
                'parent_name' => 'Image Accordion',
                'child'  => 'ImageAccordionItem',
                'child_name'  => 'Image Accordion Item',
                'icon' => 'dashboard/static/module-icons/image-accordion.svg',
                'release_version' => '1.0.4',
                'is_default_active' => true
            ],
            'ImageCarousel' =>[
                'parent'      => 'ImageCarousel',
                'parent_name' => 'Image Carousel',
                'child'       => 'ImageCarouselItem',
                'child_name'  => 'Image Carousel Item',
                'icon' => 'dashboard/static/module-icons/image-carousel.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'ImageHover' =>[
                'parent' => 'ImageHover',
                'parent_name' => 'Image Hover',
                'icon' => 'dashboard/static/module-icons/image-hover-box.svg',
                'release_version' => '1.0.1',
                'is_default_active' => true
            ],
            'ImageMask' =>[
                'parent' => 'ImageMask',
                'parent_name' => 'Image Mask',
                'icon' => 'dashboard/static/module-icons/image-masking.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
           'ImageReveal' =>[
			   'parent' => 'ImageReveal',
			   'parent_name' => 'Image Reveal',
			   'icon' => 'dashboard/static/module-icons/image-reveal.svg',
			   'release_version' => '1.0.0',
			   'is_default_active' => true,
			   'is_new_module' => true
           ],
            'InstagramCarousel' =>[
                'parent' => 'InstagramCarousel',
                'parent_name' => 'Instagram Feed Carousel',
                'icon' => 'dashboard/static/module-icons/instagram-carousel.svg',
                'release_version' => '1.0.2',
                'is_default_active' => true
            ],
            'InstagramGallery' =>[
                'parent' => 'InstagramGallery',
                'parent_name' => 'Instagram Feed',
                'icon' => 'dashboard/static/module-icons/instagram-gallery.svg',
                'release_version' => '1.0.2',
                'is_default_active' => true
            ],
            'JustifiedGallery' =>[
                'parent' => 'JustifiedGallery',
                'parent_name' => 'Justified Gallery',
                'icon' => 'dashboard/static/module-icons/justified-gallery.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'LogoCarousel' =>[
                'parent' => 'LogoCarousel',
                'parent_name' => 'Logo Carousel',
                'child' => 'LogoCarouselItem',
                'child_name' => 'Logo Carousel Item',
                'icon' => 'dashboard/static/module-icons/logo-carousel.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'PackeryGallery' =>[
                'parent' => 'PackeryGallery',
                'parent_name' => 'Packery Gallery',
                'icon' => 'dashboard/static/module-icons/packery.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'TestimonialCarousel' =>[
                'parent' => 'TestimonialCarousel',
                'parent_name' => 'Testimonial Carousel',
                'child' => 'TestimonialCarouselItem',
                'child_name' => 'Testimonial Carousel Item',
                'icon' => 'dashboard/static/module-icons/test-carousel.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'TiltCard' =>[
                'parent' => 'TiltCard',
                'parent_name' => 'Tilt Card',
                'icon' => 'dashboard/static/module-icons/titlt-box.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'TypewriterText' =>[
                'parent' => 'TypewriterText',
                'parent_name' => 'Typing Text',
                'icon' => 'dashboard/static/module-icons/typewriter.svg',
                'release_version' => '1.1.8',
                'is_default_active' => false
            ],
            'WPForms' =>[
                'parent' => 'WPForms',
                'parent_name' => 'WPForms Styler',
                'icon' => 'dashboard/static/module-icons/wp-form.svg',
                'release_version' => '1.0.0',
                'is_default_active' => true
            ],
            'GravityForm' =>[
                'parent' => 'GravityForm',
                'parent_name' => 'Gravity Form Styler',
                'icon' => 'dashboard/static/module-icons/gravityform.svg',
                'release_version' => '1.0.0',
                'is_default_active' => false
            ],
            'CptGrid' =>[
                'parent' => 'CptGrid',
                'parent_name' => 'CPT Grid',
                'child' => 'CptItem',
                'child_name' => 'CPT Item',
                'icon' => 'dashboard/static/module-icons/postgrid.svg',
                'release_version' => '1.1.0',
                'is_default_active' => true,
            ],
            'ProductGrid' =>[
                'parent' => 'ProductGrid',
                'parent_name' => 'Product Grid',
                'child' => 'ProductItem',
                'child_name' => 'Product Item',
                'icon' => 'dashboard/static/module-icons/product-grid.svg',
                'release_version' => '1.1.2',
                'is_default_active' => false
            ],
            'ProductCarousel' =>[
                'parent' => 'ProductCarousel',
                'parent_name' => 'Product Carousel',
                'child' => 'ProductItem',
                'child_name' => 'Product Item',
                'icon' => 'dashboard/static/module-icons/product-carousel.svg',
                'release_version' => '1.1.5',
                'is_default_active' => false
            ],
            'ImageHotspot' =>[
                'parent' => 'ImageHotspot',
                'parent_name' => 'Image Hotspot',
                'child' => 'ImageHotspotItem',
                'child_name' => 'Image Hotspot Item',
                'icon' => 'dashboard/static/module-icons/image-hotspot.svg',
                'is_default_active' => false,
                'release_version' => '1.1.8'
            ],
            'CptFilter' =>[
                'parent' => 'CptFilter',
                'parent_name' => 'Filterable CPT',
                'child' => 'CptItem',
                'child_name' => 'CPT Item',
                'icon' => 'dashboard/static/module-icons/cpt-filter.svg',
                'is_default_active' => false,
                'release_version' => '1.1.8'
            ],
            'LottieImage' =>[
                'parent' => 'LottieImage',
                'parent_name' => 'Lottie',
                'icon' => 'dashboard/static/module-icons/lottie-image.svg',
                'release_version' => '1.2.1',
                'is_default_active' => false
            ],
            'CptCarousel' =>[
                'parent' => 'CptCarousel',
                'parent_name' => 'CPT Carousel',
                'child' => 'CptItem',
                'child_name' => 'CPT Item',
                'icon' => 'dashboard/static/module-icons/cpt-carousel.svg',
                'release_version' => '1.2.1',
                'is_default_active' => false,
            ],
            'ContentSwitcher' =>[
                'parent' => 'ContentSwitcher',
                'parent_name' => 'Content Toggle',
                'icon' => 'dashboard/static/module-icons/content-toggle.svg',
                'release_version' => '1.2.1',
                'is_default_active' => false,
            ],
            'ScrollImage' =>[
                'parent' => 'ScrollImage',
                'parent_name' => 'Scroll Image',
                'icon' => 'dashboard/static/module-icons/scroll-image.svg',
                'release_version' => '1.2.3',
                'is_default_active' => false,
            ],
            'Divider' =>[
                'parent' => 'Divider',
                'parent_name' => 'Advanced Divider',
                'icon' => 'dashboard/static/module-icons/divider.svg',
                'release_version' => '1.2.3',
                'is_default_active' => false
            ],
            'IconList' =>[
                'parent' => 'IconList',
                'parent_name' => 'Advanced List',
                'child' => 'IconListItem',
                'child_name' => 'List Item',
                'icon' => 'dashboard/static/module-icons/icon-list.svg',
                'release_version' => '1.2.4',
                'is_default_active' => false,
                'is_new_module' => true
            ], 
            'Breadcrumbs' =>[
                'parent' => 'Breadcrumbs',
                'parent_name' => 'Breadcrumbs',
                'icon' => 'dashboard/static/module-icons/breadcrumbs.svg',
                'release_version' => '1.2.4',
                'is_default_active' => false,
                'is_new_module' => true
            ],
            'RatingBox' =>[
                'parent' => 'RatingBox',
                'parent_name' => 'Star Rating',
                'icon' => 'dashboard/static/module-icons/star-rating.svg',
                'release_version' => '1.2.8',
                'is_default_active' => false,
                'is_new_module' => true
            ],
			'Faq' =>[
                'parent' => 'Faq',
                'parent_name' => 'FAQ',
				'child' => 'FaqItem',
                'child_name' => 'Faq Item',
                'icon' => 'dashboard/static/module-icons/faq.svg',
                'release_version' => '1.2.10',
                'is_default_active' => false,
                'is_new_module' => true
            ],
            'AdvancedMenu' => [
                'parent' => 'AdvancedMenu',
                'parent_name' => 'Advanced Menu',
                'child'  => 'AdvancedMenuItem',
                'child_name'  => 'Advanced Menu Item',
                'icon'  => 'dashboard/static/module-icons/advanced-menu.svg',
                'release_version' => '1.3.0',
                'is_default_active' => true,
                'is_new_module' => true                
            ],
            'Timeline' =>[
                'parent' => 'Timeline',
                'parent_name' => 'Timeline',
				'child' => 'TimelineItem',
                'child_name' => 'Timeline Item',
                'icon' => 'dashboard/static/module-icons/timeline.svg',
                'release_version' => '1.3.6',
                'is_default_active' => false,
                'is_new_module' => true
            ],
            'MarqueeText' =>[
                'parent' => 'MarqueeText',
                'parent_name' => 'Marquee Text',
				'child' => 'MarqueeTextItem',
                'child_name' => 'Marquee Text Item',
                'icon' => 'dashboard/static/module-icons/marquee-text.svg',
                'release_version' => '1.3.40',
                'is_default_active' => true,
                'is_new_module' => true
            ],
            'TextHighlighter' =>[
                'parent' => 'TextHighlighter',
                'parent_name' => 'Text Highlighter',
                'icon' => 'dashboard/static/module-icons/text-highlighter.svg',
                'release_version' => '1.4.3',
                'is_default_active' => false
            ],
           'ACFGallery' =>[
	           'parent' => 'ACFGallery',
	           'parent_name' => 'ACF Gallery',
	           'icon' => 'dashboard/static/module-icons/acf-gallery.svg',
	           'release_version' => '1.0.0',
	           'is_default_active' => false
           ],
        );

        return $modules;
    }

    /**
     * Include all Module files স
     * call register_module() function
     */
	public function include_module(){
        if ( empty( $this->all_modules_map() ) ) {
            return;
        }
        $all_modules        = $this->all_modules_map();
		$all_parent_modules = array_column($all_modules, 'parent');
		$all_child_modules = array_column($all_modules, 'child');
		$modules = array_unique(array_merge($all_parent_modules, $all_child_modules ));

        if ( empty( $this->get_active_modules() ) ) {
            return;
        }
        $all_active_modules = json_decode($this->get_active_modules());

        if ( ! class_exists( 'ET_Builder_Element' ) ) {
            return;
        }

        // include the files that will
        // used by the module
        require_once( DIFL_MAIN_DIR . '/includes/utils/df_utls.php' );
        require_once( DIFL_MAIN_DIR . '/includes/classes/df-cpt-taxonomies.php' );
        require_once( DIFL_MAIN_DIR . '/includes/classes/df-acf-fields.php' );
        require_once( DIFL_MAIN_DIR . '/includes/classes/df-acf-data-process.php' );
		require_once( DIFL_MAIN_DIR . '/includes/classes/df-metabox-fields.php' );
		require_once( DIFL_MAIN_DIR . '/includes/classes/df-metabox-data-process.php' );
        require_once( DIFL_MAIN_DIR . '/includes/classes/df-class-breadcrumbs.php' );
        require_once( DIFL_MAIN_DIR . '/includes/classes/df-class-localize-vars.php' );
        require_once( DIFL_MAIN_DIR . '/includes/classes/df-menu-walker.php' );
		$fully_acf_dependent_modules = ['ACFGallery'];
		foreach ( $modules as $key => $module_name ) {
			if ( ! class_exists( 'ACF' ) && in_array( $module_name, $fully_acf_dependent_modules ) ) {
				continue;
			}
			if ( in_array( $module_name, $all_active_modules) ) {
				$this->register_module( $module_name );
                if(array_key_exists('child' , $all_modules[$module_name]) ){
                    $this->register_module( $all_modules[$module_name]['child'] );
                }
			}
		}
	}

    /**
     * Inculde each module one by one
     *
     * @param String $module_name It come's  from 'parent' property of all_modules_map()
     */
	protected function register_module( $module_name ) {
		$module_file = DIFL_MAIN_DIR . '/includes/modules/' . $module_name . '/'.$module_name .'.php';

		if ( is_readable( $module_file ) ) {
            require_once $module_file;
		}
	}
}
