<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    diviflash
 * @subpackage diviflash/public
 * @author     diviflash <admin@diviflash.com>
 */
class DiviFlash_Public
{
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in DiviFlash_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The DiviFlash_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// lib styles
		// some inline styles will depend on this stylesheet id
		// file: inliudes/functions/df_dashboard.php df_process_menu_line_styles_fb()
		wp_register_style('df-lib-styles', DIFL_PUBLIC_DIR . 'css/lib/df_lib_styles.css', array(), $this->version);
		wp_enqueue_style('df-lib-styles');

		wp_register_style('df-builder-styles', DIFL_PUBLIC_DIR . 'css/df-builder-styles.css', array(), $this->version);
		wp_enqueue_style('df-builder-styles');

		wp_register_style('df-popup-styles', DIFL_PUBLIC_DIR . 'css/popup-custom.css', array(), $this->version);
		wp_enqueue_style('df-popup-styles');

		wp_register_style('df-rangeSlider-styles', DIFL_PUBLIC_DIR . 'css/lib/ion.rangeSlider.min.css', array(), $this->version);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in DiviFlash_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The DiviFlash_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 // lib scripts
		 wp_register_script( 'imageload', DIFL_PUBLIC_DIR . 'js/lib/imagesloaded.pkgd.min.js', array(), $this->version, true );
		 wp_register_script( 'animejs', DIFL_PUBLIC_DIR . 'js/lib/anime.js');
		 wp_register_script( 'df-tilt-lib', DIFL_PUBLIC_DIR . 'js/lib/vanilla-tilt.min.js', array(), $this->version, true );
		 wp_register_script( 'bxslider-script', DIFL_PUBLIC_DIR . 'js/lib/jquery.bxslider.min.js', array(), $this->version, true );
		 wp_register_script( 'df-marquee-script', DIFL_PUBLIC_DIR . 'js/lib/jquery.marquee.min.js', array(), $this->version, true );
		 wp_register_script( 'swiper-script', DIFL_PUBLIC_DIR . 'js/lib/swiper.min.js', array(), $this->version, true );
		 wp_register_script( 'df-imagegallery-lib', DIFL_PUBLIC_DIR . 'js/lib/gallerylib.js', array('jquery'), $this->version, true );
		 wp_register_script( 'justified-gallery-script', DIFL_PUBLIC_DIR . 'js/lib/jquery.justifiedGallery.js', array('jquery'), $this->version, true );
		 wp_register_script( 'lightgallery-script', DIFL_PUBLIC_DIR . 'js/lib/lightgallery.js', array('jquery'), $this->version, true );
		 wp_register_script( 'packery-script', DIFL_PUBLIC_DIR . 'js/lib/packery.pkgd.js', array('jquery'), $this->version, true );
		 wp_register_script( 'sticky-script', DIFL_PUBLIC_DIR . 'js/lib/hc-sticky.js', array('jquery'), $this->version, true );
		 wp_register_script( 'compare-image-script', DIFL_PUBLIC_DIR . 'js/lib/image-compare-viewer.min.js', array('jquery'), $this->version, true );
		 wp_register_script( 'data-table-script', DIFL_PUBLIC_DIR . 'js/lib/datatables.min.js', array('jquery'), $this->version, true );
		 wp_register_script( 'fitvids', DIFL_PUBLIC_DIR . 'js/lib/fitvids.js' , array('jquery'), $this->version, true );
		 wp_register_script( 'df-lottie-lib', DIFL_PUBLIC_DIR . 'js/lib/lottie.js' , array(), $this->version, true );
		 wp_register_script( 'image-hotspot-popper-script', DIFL_PUBLIC_DIR . 'js/lib/popper.min.js', array('jquery'), $this->version, true );
		 wp_register_script( 'image-hotspot-tippy-bundle-script', DIFL_PUBLIC_DIR . 'js/lib/tippy-bundle.min.js', array('image-hotspot-popper-script'), $this->version, true );
		 wp_register_script( 'type-writer-lib', DIFL_PUBLIC_DIR . 'js/lib/typewriterlib.js' , array('jquery'), $this->version, true );
		 wp_register_script( 'df-lottie-jszip', DIFL_PUBLIC_DIR . 'js/lib/jszip.min.js' , array('df-lottie-lib'), $this->version, true );
		 wp_register_script( 'df-flexmasonry', DIFL_PUBLIC_DIR . 'js/lib/flexmasonry.js' , array(''), $this->version, true );
		 wp_register_script( 'df-vivus-svg', DIFL_PUBLIC_DIR . 'js/lib/vivus.min.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df-rangeSlider', DIFL_PUBLIC_DIR . 'js/lib/ion.rangeSlider.min.js' , array('jquery'), $this->version, true );

		 // custom scripts
		 wp_register_script( 'df-tilt-script', DIFL_PUBLIC_DIR . 'js/tiltcard.js', array(), $this->version, true );
		 wp_register_script( 'df-floatimage-script', DIFL_PUBLIC_DIR . 'js/floatImage.js', array('animejs'), $this->version, true );
		 wp_register_script( 'df-logocarousel', DIFL_PUBLIC_DIR . 'js/logoCarousel.js', array('jquery', 'bxslider-script'), $this->version, true );
		 wp_register_script( 'df-instagramcarousel', DIFL_PUBLIC_DIR . 'js/instagramCarousel.js', array(), $this->version, true );
		 wp_register_script( 'df-imagecarousel', DIFL_PUBLIC_DIR . 'js/imageCarousel.js', array('lightgallery-script'), $this->version, true );
		 wp_register_script( 'df-imageaccordion', DIFL_PUBLIC_DIR . 'js/imageAccordion.js', array(), $this->version, true );
		 wp_register_script( 'df-testcarousel', DIFL_PUBLIC_DIR . 'js/testCarousel.js', array(), $this->version, true );
		 wp_register_script( 'df-contentcarousel', DIFL_PUBLIC_DIR . 'js/contentcarousel.js', array('lightgallery-script'), $this->version, true );
		 wp_register_script( 'df-imagegallery', DIFL_PUBLIC_DIR . 'js/imageGallery.js', array('lightgallery-script'), $this->version, true );
		 wp_register_script( 'df-acf-gallery', DIFL_PUBLIC_DIR . 'js/acfGallery.js', array('lightgallery-script'), $this->version, true );
		 wp_register_script( 'df-instagramgallery', DIFL_PUBLIC_DIR . 'js/instagramGallery.js', array(), $this->version, true );
		 wp_register_script( 'df-jsgallery', DIFL_PUBLIC_DIR . 'js/justifyGallery.js', array('jquery', 'lightgallery-script'), $this->version, true );
		 wp_register_script( 'df-packery', DIFL_PUBLIC_DIR . 'js/df-packery.js', array('jquery', 'lightgallery-script'), $this->version, true );
		 wp_register_script( 'headline-scripts', DIFL_PUBLIC_DIR . 'js/headline.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df-tabs', DIFL_PUBLIC_DIR . 'js/df-tabs.js', array('jquery', 'sticky-script'), $this->version, true );
		 wp_register_script( 'df-compareimage', DIFL_PUBLIC_DIR . 'js/comparemage.js', array('compare-image-script'), $this->version, true );
		 wp_register_script( 'df-posts', DIFL_PUBLIC_DIR . 'js/posts.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df-products', DIFL_PUBLIC_DIR . 'js/products.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df-blog-carousel', DIFL_PUBLIC_DIR . 'js/blogCarousel.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df-cpt-grid', DIFL_PUBLIC_DIR . 'js/cptgrid.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df-product-carousel', DIFL_PUBLIC_DIR . 'js/productCarousel.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df-advanced-data-table', DIFL_PUBLIC_DIR . 'js/advancedDataTable.js', array('data-table-script'), $this->version, true );
		 wp_register_script( 'df-lottie-control', DIFL_PUBLIC_DIR . 'js/df-lottie-control.js', array('df-lottie-lib'), $this->version, true );
		 wp_register_script( 'df-content-switcher', DIFL_PUBLIC_DIR . 'js/contentSwitcher.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df_image_hotspot', DIFL_PUBLIC_DIR . 'js/imageHotspot.js', array('image-hotspot-tippy-bundle-script'), $this->version, true );
		 wp_register_script( 'df-type-text-script', DIFL_PUBLIC_DIR . 'js/type-text.js', array( 'type-writer-lib' ), $this->version, true );
		 wp_register_script( 'df_cpt_filter', DIFL_PUBLIC_DIR . 'js/df-cpt-filter.js', array('jquery', 'imageload', 'df-imagegallery-lib', 'df-rangeSlider'), $this->version, true );
		 wp_register_script( 'df-cpt-carousel', DIFL_PUBLIC_DIR . 'js/cptCarousel.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df-scroll-image', DIFL_PUBLIC_DIR . 'js/scrollImage.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df_divider', DIFL_PUBLIC_DIR . 'js/divider.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df_iconlist', DIFL_PUBLIC_DIR . 'js/iconlist.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df_faq', DIFL_PUBLIC_DIR . 'js/faq.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df_timeline', DIFL_PUBLIC_DIR . 'js/df-timeline.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df_marquee_text', DIFL_PUBLIC_DIR . 'js/marqueeText.js', array( 'jquery' ), $this->version, true );
		 wp_register_script( 'df-image-reveal', DIFL_PUBLIC_DIR . 'js/imageReveal.js', array('jquery'), $this->version, true );
		 wp_register_script( 'df-text-highlighter', DIFL_PUBLIC_DIR . 'js/textHighlighter.js', array('jquery'), $this->version, true );

		 // menu extension script
		 wp_enqueue_script( 'df-menu-ext-script', DIFL_PUBLIC_DIR . 'js/df-menu-ext-script.js', array('jquery'), $this->version, true );


		 $popup_enable = get_option('df_general_popup_enable') === '1' ? 'on' : 'off';
		 if("on" === $popup_enable){
			 wp_enqueue_script('df_popup_script', DIFL_PUBLIC_DIR . 'js/popup-custom.js', array('jquery'), $this->version, true);

		 }
	}
}
