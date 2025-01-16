<?php

namespace DIFL\Importer;

class Layout {
	/**
	 * @var string
	 */
	public static $folder_slug = '/difl-layouts/';
	/**
	 * @var string
	 */
	public static $temp_dir;

	public function __construct() {
		$slug           = self::$folder_slug;
		self::$temp_dir = rtrim( sys_get_temp_dir(), DIRECTORY_SEPARATOR ) . $slug;
		if ( ! is_dir( self::$temp_dir ) ) {
			mkdir( self::$temp_dir );
		}
	}

	public static function layout_list() {
		return [
			[
				'slug'             => 'pet-care',
				'version'          => '1.0.0',
				'name'             => 'Pet Care',
				'package_name'     => 'Pet Care Layout Packs',
				'description'      => 'Pre-designed website layouts for pet care services or professionals, featuring services, appointments & testimonials.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/12/Divi-Barber-Shop-Layout-Packs.jpg',
				'demo_url'         => 'https://layouts.diviflash.xyz/pet-care/',
				'package_url'      => 'https://layouts.diviflash.xyz/pet-care/wp-content/uploads/sites/33/2023/12/diviflash_pet_care_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/pet-care/wp-content/uploads/sites/33/2023/12/Pet-Care-Layout-Pack-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/pet-care/',
				'menu_instruction' => [
					'list' => 'Home, About, Services(child menu: Pet Grooming), Pet Adoption, Blog',
				],
			],
			[
				'slug'             => 'barber-shop',
				'version'          => '1.0.0',
				'name'             => 'Barber Shop',
				'package_name'     => 'Barber Shop Layout Packs',
				'description'      => 'Pre-built website layouts designs for barber shop owner, featuring services, appointments and about section.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/12/Pet-Care-Layout-Packs.png',
				'demo_url'         => 'https://layouts.diviflash.xyz/barber-shop/',
				'package_url'      => 'https://layouts.diviflash.xyz/barber-shop/wp-content/uploads/sites/32/2023/12/diviflash_barber_shop_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/barber-shop/wp-content/uploads/sites/32/2023/12/Barber-Shop-Layout-Pack-DiviFlash-1.zip',
				'doc_link'         => 'https://diviflash.com/docs/barber-shop/',
				'menu_instruction' => [
					'list' => 'Home, About, Services(child menu: Haircut Style), Gallery, Blog',
				],
			],
			[
				'slug'             => 'spa',
				'version'          => '1.0.0',
				'name'             => 'Massage & Spa',
				'package_name'     => 'Massage & Spa Layout Packs',
				'description'      => 'Tailored for massage & spa businesses, highlighting services, appointments & relaxation choices for a soothing ambiance.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/08/Divi-SPA-Layout-Packs.jpg.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/spa/',
				'package_url'      => 'https://layouts.diviflash.xyz/spa/wp-content/uploads/sites/31/2023/12/diviflash_spa_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/spa/wp-content/uploads/sites/31/2023/08/SPA-Layout-Pack-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/spa/',
				'menu_instruction' => [
					'list' => 'Home, About, Services(child menu: Body Massage), Gallery, Blog, Contact',
				],
			],
			[
				'slug'             => 'podcast',
				'version'          => '1.0.0',
				'name'             => 'Podcast',
				'package_name'     => 'Podcast Layout Packs',
				'description'      => 'Layouts for podcasters, featuring episodes, host bios, and social media integration to promote and share podcast.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/08/Divi-Podcast-Layout-Packs.jpg.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/podcast/',
				'package_url'      => 'https://layouts.diviflash.xyz/podcast/wp-content/uploads/sites/30/2023/12/diviflash_podcast_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/podcast/wp-content/uploads/sites/30/2023/08/Podcast-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/podcast/',
				'menu_instruction' => [
					'list' => 'Home, About, Episodes, Blog, Contact',
				],
			],
			[
				'slug'             => 'logistics',
				'version'          => '1.0.0',
				'name'             => 'Logistics',
				'package_name'     => 'Logistics Layout Packs',
				'description'      => 'Website designs for logistics companies, featuring services and solutions to showcase their logistics capabilities.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/07/Divi-Logistics-Layout-Packs.jpg.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/logistics/',
				'package_url'      => 'https://layouts.diviflash.xyz/logistics/wp-content/uploads/sites/29/2023/12/diviflash_logistics_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/logistics/wp-content/uploads/sites/29/2023/07/Logistics-Layout-DiviFlash.zip',
				'plugins'          => [
					'wpforms',
				],
				'plugins_pro'      => [
					'monarch',
				],
				'doc_link'         => 'https://diviflash.com/docs/logistics/',
				'menu_instruction' => [
					'list' => 'Home, Company, Services(child menu: Sea Transportation), News & Media, Features, Contact Us',
				],
			],
			[
				'slug'             => 'seo',
				'version'          => '1.0.0',
				'name'             => 'SEO',
				'package_name'     => 'SEO Layout Packs',
				'description'      => 'Pre-designed website layouts for SEO agencies or professionals, showcasing services, case studies & testimonials.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Law-Firm-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/seo/',
				'package_url'      => 'https://layouts.diviflash.xyz/seo/wp-content/uploads/sites/28/2023/12/diviflash_seo_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/seo/wp-content/uploads/sites/28/2023/07/SEO-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/seo/',
				'menu_instruction' => [
					'list' => 'Home, About, Services(child menu: Mega menu Library), Blog, Contact',
				],
			],
			[
				'slug'             => 'accountant',
				'version'          => '1.0.0',
				'name'             => 'Accountant',
				'package_name'     => 'Accountant Layout Packs',
				'description'      => 'Professionally designed website layouts for accounting firms or individual accountants, featuring services & testimonials.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/06/Divi-Accountant-Layout-Packs.jpg.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/accountant/',
				'details_url'      => 'https://layouts.diviflash.xyz/accountant/',
				'package_url'      => 'https://layouts.diviflash.xyz/accountant/wp-content/uploads/sites/27/2023/12/diviflash_accountant_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/accountant/wp-content/uploads/sites/27/2023/07/Accountant-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/accountant/',
				'menu_instruction' => [
					'list' => 'Accouonting Services(child menu: Audit & assurance), About, News & Media',
				],
			],
			[
				'slug'             => 'ai',
				'version'          => '1.0.0',
				'name'             => 'AI',
				'package_name'     => 'AI Layout Packs',
				'description'      => 'Designed for AI-focused companies or projects, highlighting services, case studies, testimonials, and industry expertise.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/06/Divi-AI-Layout-Packs.jpg.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/ai/',
				'package_url'      => 'https://layouts.diviflash.xyz/ai/wp-content/uploads/sites/26/2023/12/diviflash_ai_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/ai/wp-content/uploads/sites/26/2023/06/AI-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/ai/',
				'menu_instruction' => [
					'list' => 'Home, About, Services(child menu: Service Details), Blog',
				],
			],
			[
				'slug'             => 'charity',
				'version'          => '1.0.0',
				'name'             => 'Charity',
				'package_name'     => 'Charity Layout Packs',
				'description'      => 'Pre-made layouts for charitable organizations, featuring donation options, impact stories, and volunteer opportunities.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/05/Divi-Charity-Layout-Packs.jpg.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/charity/',
				'package_url'      => 'https://layouts.diviflash.xyz/charity/wp-content/uploads/sites/23/2023/12/diviflash_charity_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/charity/wp-content/uploads/sites/23/2023/05/charity-layout-DiviFlash.zip',
				'plugins'          => [
					'cpt_ui',
					'acf',
					'contact_form7',
				],
				'doc_link'         => 'https://diviflash.com/docs/charity/',
				'menu_instruction' => [
					'list' => 'Home, About, Causes, Pages(child menu: Event, Volunteers, Donors, Our Gallery, Donation, Become A Volunteers, 404 Page), Blog, Contact',
				],
			],
			[
				'slug'             => 'fitness',
				'version'          => '1.0.0',
				'name'             => 'Gym & Fitness',
				'package_name'     => 'Gym & Fitness Layout Packs',
				'description'      => 'Authoritative layouts for lawyers and law firms to showcase their expertise.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/06/Divi-Gym-Fitness-Layout-Packs.jpg.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/fitness/',
				'package_url'      => 'https://layouts.diviflash.xyz/fitness/wp-content/uploads/sites/25/2023/12/diviflash_fitness_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/fitness/wp-content/uploads/sites/25/2023/06/Fitness-Gym-Layout-DiviFlash.zip',
				'plugins'          => [
					'contact_form7',
				],
				'doc_link'         => 'https://diviflash.com/docs/fitness/',
				'menu_instruction' => [
					'list' => 'About, Fitness Trainings(child menu: Body Building), Gallery, Contact Us',
				],
			],
			[
				'slug'             => 'real-estate',
				'version'          => '1.0.0',
				'name'             => 'Real Estate',
				'package_name'     => 'Real Estate Layout Packs',
				'description'      => 'Website designs for real estate agencies, featuring property listings, agent bios, and search functionality.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/05/Divi-Real-Estate-Layout-Packs.jpg.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/real-estate/',
				'package_url'      => 'https://layouts.diviflash.xyz/real-estate/wp-content/uploads/sites/22/2023/12/diviflash_real_estate_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/real-estate/wp-content/uploads/sites/22/2023/05/Real-Estate-Layout-DiviFlash.zip',
				'plugins'          => [
					'cpt_ui',
					'acf',
				],
				'doc_link'         => 'https://diviflash.com/docs/real-estate/',
				'menu_instruction' => [
					'list'    => 'Home, Pages(child menu: About us, Services, Agent List, Agent Profile, 404 Page), Property, Blog, Contact, Mobile number',
					'classes' => [
						"Include class 'menu_button' with 'Mobile number' menu.",
					],
				],
			],
			[
				'slug'             => 'roofing',
				'version'          => '1.0.0',
				'name'             => 'Roofing',
				'package_name'     => 'Roofing Layout Packs',
				'description'      => 'Free layouts for roofing agencies or contractors, featuring services offered, past projects, and contact information.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/05/Divi-Roofing-Layout-Packs.jpg.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/roofing/',
				'package_url'      => 'https://layouts.diviflash.xyz/roofing/wp-content/uploads/sites/24/2023/12/diviflash_roofing_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/roofing/wp-content/uploads/sites/24/2023/05/Roofing-Layout-DiviFlash.zip',
				'plugins'          => [
					'contact_form7',
				],
				'doc_link'         => 'https://diviflash.com/docs/roofing/',
				'menu_instruction' => [
					'list' => 'Home, About, Services(child menu: Service Details), Projects, Blog, Contact',
				],
			],
			[
				'slug'             => 'restaurant',
				'version'          => '1.0.0',
				'name'             => 'Restaurant',
				'package_name'     => 'Restaurant Layout Packs',
				'description'      => 'Beautifully designed for restaurants, cafes, and other food businesses.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Restaurant-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/restaurant/',
				'package_url'      => 'https://layouts.diviflash.xyz/restaurant/wp-content/uploads/sites/21/2023/12/diviflash_restaurant_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/restaurant/wp-content/uploads/sites/21/2023/10/Restaurant-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/restaurant/',
				'menu_instruction' => [
					'list'    => 'Home, Pages(child menu: About us, Meet Our Chefs, 404 page, Book A Table), Menu, Blog, Contact, Order Online',
					'classes' => [
						"Include class 'menubtn_order' with 'Order Online' menu.",
					],
				],
			],
			[
				'slug'             => 'digital-agency',
				'version'          => '1.0.0',
				'name'             => 'Digital Agency',
				'package_name'     => 'Digital Agency Layout Packs',
				'description'      => 'Single page landing page layout to showcase your portfolio and services.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Digital-Agency-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/digital-agency/',
				'package_url'      => 'https://layouts.diviflash.xyz/digital-agency/wp-content/uploads/sites/13/2023/12/diviflash_digital_agency_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/digital-agency/wp-content/uploads/sites/13/2023/01/Digital-Agency-Layout-DiviFlash.zip',
				'doc_link'         => 'https://www.diviflash.com/docs-category/layouts/',
				'menu_instruction' => [
					'list' => 'Home, About, Service, Portfolio, Contact',
				],
			],
			[
				'slug'             => 'hosting',
				'version'          => '1.0.0',
				'name'             => 'Hosting',
				'package_name'     => 'Hosting Layout Packs',
				'description'      => 'Designed for domain & hosting companies, featuring pricing tables, hosting plans, and features.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Hosting-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/hosting/',
				'package_url'      => 'https://layouts.diviflash.xyz/hosting/wp-content/uploads/sites/19/2023/12/diviflash_hosting_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/hosting/wp-content/uploads/sites/19/2023/01/Hosting-Layout-DiviFlash.zip',
				'plugins_pro'      => [
					'monarch',
				],
				'doc_link'         => 'https://diviflash.com/docs/hosting/',
				'menu_instruction' => [
					'list'    => 'Home, Pages(child menu: About us, Pricing, Testimonial, Contact, 404 page), Hosting, Domain, Blog, Login',
					'classes' => [
						"Include class 'menu_button' with 'Login' menu.",
					],
				],
			],
			[
				'slug'             => 'ebook',
				'version'          => '1.0.0',
				'name'             => 'eBook',
				'package_name'     => 'eBook Layout Packs',
				'description'      => 'Single-page templates for promoting books, authors and publishers.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/eBook-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/ebook/',
				'package_url'      => 'https://layouts.diviflash.xyz/ebook/wp-content/uploads/sites/20/2023/12/diviflash_ebook_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/ebook/wp-content/uploads/sites/20/2023/01/Ebook-Layout-DiviFlash.zip',
				'doc_link'         => 'https://www.diviflash.com/docs-category/layouts/',
				'menu_instruction' => [
					'list'    => 'Home, Feature, Chapters, About Author, Testimonial, Contact',
					'classes' => [
						"Include class 'df - menu - active' with 'Home' menu.",
					],
				],
			],
			[
				'slug'             => 'consulting',
				'version'          => '1.0.0',
				'name'             => 'Consultant',
				'package_name'     => 'Consultant Layout Packs',
				'description'      => 'Pre-made website designs for consultants or coaches, featuring client testimonials and services offered.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Consultant-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/consulting/',
				'package_url'      => 'https://layouts.diviflash.xyz/consulting/wp-content/uploads/sites/18/2023/12/diviflash_consultant_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/consulting/wp-content/uploads/sites/18/2023/01/Consultant-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/consulting/',
				'menu_instruction' => [
					'list' => 'Home, About us, Services, Case Studies, Blog, Contact',
				],
			],
			[
				'slug'         => 'black-friday',
				'version'      => '1.0.0',
				'name'         => 'Black Friday',
				'package_name' => 'Black Friday Layout Packs',
				'description'  => 'Designed specifically for sales and promotions, featuring discounts, product images, and CTAs.',
				'thumb'        => 'https://diviflash.com/wp-content/uploads/2023/02/Black-Friday-Layout-Packs.png.webp',
				'demo_url'     => 'https://layouts.diviflash.xyz/black-friday/',
				'package_url'  => 'https://layouts.diviflash.xyz/black-friday/wp-content/uploads/sites/16/2023/12/diviflash_black_friday_layout_pack.zip',
				'download_url' => 'https://layouts.diviflash.xyz/black-friday/wp-content/uploads/sites/16/2023/01/Black-Friday-Layout-DiviFlash.zip',
				'doc_link'     => 'https://diviflash.com/docs/black-friday-3/',
			],
			[
				'slug'             => 'cv-resume',
				'version'          => '1.0.0',
				'name'             => 'CV Resume',
				'package_name'     => 'CV Resume Layout Packs',
				'description'      => 'Layouts specifically designed for job seekers to showcase their skills, experience, and education.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/CV-Resume-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/cv-resume/',
				'package_url'      => 'https://layouts.diviflash.xyz/cv-resume/wp-content/uploads/sites/15/2023/12/diviflash_cv_resume_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/cv-resume/wp-content/uploads/sites/15/2023/03/cv-resume-layout.zip',
				'doc_link'         => 'https://www.diviflash.com/docs-category/layouts/',
				'menu_instruction' => [
					'list'    => 'Home, Skills, Service, Experience, Portfolio, Testimonials, Contact, Download CV',
					'classes' => [
						"Include class 'download_btn' with 'Download CV' menu.",
					],
				],
			],
			[
				'slug'             => 'construction',
				'version'          => '1.0.0',
				'name'             => 'Construction',
				'package_name'     => 'Construction Layout Packs',
				'description'      => 'Website layouts for construction companies or contractors, highlighting past projects and services offered.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Construction-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/construction/',
				'package_url'      => 'https://layouts.diviflash.xyz/construction/wp-content/uploads/sites/17/2023/12/diviflash_construction_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/construction/wp-content/uploads/sites/17/2023/01/Construction-Layout-DiviFlash-1.zip',
				'doc_link'         => 'https://diviflash.com/docs/construction/',
				'menu_instruction' => [
					'list'    => 'Home, About Us, Our Services(child menu: Construction, Renovation, Architecture, Interior Designing, Roofing, Walkways), Blog, Contact, Get a quote',
					'classes' => [
						"Include class 'get_quote' with 'Get a quote' menu.",
					],
				],
			],
			[
				'slug'             => 'coffee',
				'version'          => '1.0.0',
				'name'             => 'Coffee',
				'package_name'     => 'Coffee Shop Layout Packs',
				'description'      => 'Templates designed with food in mind that showcase your restaurant’s items.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Coffee-Shop-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/coffee/',
				'package_url'      => 'https://layouts.diviflash.xyz/coffee/wp-content/uploads/sites/12/2023/12/diviflash_coffee_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/coffee/wp-content/uploads/sites/12/2023/01/Coffee-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/coffee-shop/',
				'menu_instruction' => [
					'list' => 'Home, About, Menu, Review, Blog, Contact',
				],
			],
			[
				'slug'             => 'appecho',
				'version'          => '1.0.0',
				'name'             => 'Appecho',
				'package_name'     => 'Mobile App Layout Packs',
				'description'      => 'Website designs tailored for mobile app developers, featuring app features, and download links.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Mobile-App-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/appecho/',
				'package_url'      => 'https://layouts.diviflash.xyz/appecho/wp-content/uploads/sites/14/2023/12/diviflash_appecho_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/appecho/wp-content/uploads/sites/14/2023/01/Appecho-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/appecho/',
				'menu_instruction' => [
					'list'    => 'Home, About, Features, Pricing, Contact, Download',
					'classes' => [
						"Include class 'get_download' with 'Download' menu.",
					],
				],
			],
			[
				'slug'             => 'medipulse',
				'version'          => '1.0.0',
				'name'             => 'MediPulse',
				'package_name'     => 'Medical Layout Packs',
				'description'      => 'Layouts that are designed for hospitals, clinics, doctors, and other medical professionals.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Medical-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/medipulse/',
				'package_url'      => 'https://layouts.diviflash.xyz/medipulse/wp-content/uploads/sites/10/2023/12/diviflash_medipulse_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/medipulse/wp-content/uploads/sites/10/2023/01/MediPulse-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/medical/',
				'menu_instruction' => [
					'list' => 'Home, About Us, Services, Departments, Blog, Contact Us',
				],
			],
			[
				'slug'             => 'lawfirm',
				'version'          => '1.0.0',
				'name'             => 'Law Firm',
				'package_name'     => 'Law Firm Layout Packs',
				'description'      => 'Authoritative layouts for lawyers and law firms to showcase their expertise.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Law-Firm-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/lawfirm/',
				'package_url'      => 'https://layouts.diviflash.xyz/lawfirm/wp-content/uploads/sites/11/2023/12/diviflash_law_firm_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/lawfirm/wp-content/uploads/sites/11/2023/01/Law-Firm-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/law-firm/',
				'menu_instruction' => [
					'list' => 'Home, About Us, Services(child menu: Criminal Law, Family Law, Technology Law, Real Estate Law, International Law, Financial Law), Blog, Contact Us',
				],
			],
			[
				'slug'             => 'saas ',
				'version'          => '1.0.0',
				'name'             => 'SaaS ',
				'description'      => 'Ready-made layouts for digital products or SaaS websites, highlighting product features and benefits.',
				'package_name'     => 'SaaS Layout Packs',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Saas-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/saas/',
				'package_url'      => 'https://layouts.diviflash.xyz/saas/wp-content/uploads/sites/9/2023/12/diviflash_saas_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/saas/wp-content/uploads/sites/9/2023/01/Saas-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/saas/',
				'menu_instruction' => [
					'list'    => 'Home, Feature, About, Price, Contact, Download App',
					'classes' => [
						"Include class 'download - app' with 'Download App' menu.",
					],
				],
			],
			[
				'slug'             => 'agency',
				'version'          => '1.0.0',
				'name'             => 'Agency',
				'package_name'     => 'Agency Layout Packs',
				'description'      => 'Pre-built website layouts that will give your startups and agencies the perfect branding.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Agency-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/agency/',
				'package_url'      => 'https://layouts.diviflash.xyz/agency/wp-content/uploads/sites/8/2023/12/diviflash_agency_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/agency/wp-content/uploads/sites/8/2023/01/Agency-Layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/agency/',
				'menu_instruction' => [
					'list' => 'Home, About Us, Services, Our Work, Blog, Contact Us, Login',
				],
			],
			[
				'slug'             => 'photography',
				'version'          => '1.0.0',
				'name'             => 'Photography',
				'package_name'     => 'Photography Layout Packs',
				'description'      => 'Creative layouts that are perfect for showcasing photography portfolios or artwork.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Photography-Layout-Packs.png.webp',
				'demo_url'         => 'https://layouts.diviflash.xyz/photography/',
				'package_url'      => 'https://layouts.diviflash.xyz/photography/wp-content/uploads/sites/6/2023/12/diviflash_photography_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/photography/wp-content/uploads/sites/6/2023/01/Photography-layout-DiviFlash.zip',
				'doc_link'         => 'https://diviflash.com/docs/photography/',
				'menu_instruction' => [
					'list' => 'Home, About Us, Services, Galleries, Testimonials, Contact Us',
				],
			],
			[
				'slug'             => 'business',
				'version'          => '1.0.0',
				'name'             => 'Business',
				'description'      => 'Professionally designed layouts for corporate or small business websites.',
				'thumb'            => 'https://diviflash.com/wp-content/uploads/2023/02/Business-Layout-Packs.png.webp',
				'package_name'     => 'Business Layout Packs',
				'demo_url'         => 'https://layouts.diviflash.xyz/business/',
				'package_url'      => 'https://layouts.diviflash.xyz/business/wp-content/uploads/sites/4/2023/12/diviflash_business_layout_pack.zip',
				'download_url'     => 'https://layouts.diviflash.xyz/business/wp-content/uploads/sites/4/2023/01/Business-Layout-DiviFlash.zip',
				'doc_link'         => 'https://www.diviflash.com/docs-category/layouts/',
				'menu_instruction' => [
					'list' => 'Home, About Us, Services, Clients, Blog, Contact Us',
				],
			],
		];
	}
}

new Layout();