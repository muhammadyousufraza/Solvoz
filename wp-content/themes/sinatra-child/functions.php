<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

// END ENQUEUE PARENT ACTION

function sinatra_child_scripts() {
	wp_enqueue_style( 'style-sinatra_child', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'sinatra_child_scripts' );


add_shortcode('sliding-sidebar', 'sliding_sidebar_callback');
function sliding_sidebar_callback(){
    ob_start(); ?>
    <!-- <div class="slidingDiv"> --><?php wp_nav_menu('explore-menu'); ?><!-- </div> -->
    <script>
		
    jQuery(document).ready(function ($) {

        $(".slidingDiv").hide();
        $(".show_hide").show();

        $('.btnExplore a').click(function (e) {
            e.preventDefault();
            $(".slidingDiv").toggle("slide");
            $('.bannerMain .bannerCol').toggleClass("toggleCol");;
        });

    });
    </script>

    <?php 
    return ob_get_clean();
}

//add_shortcode('solvoz-tabs', 'solvoz_tabs_callback');
function solvoz_tabs_callback(){
	global $post;
	ob_start();
	$tabs = get_field('tabs', $post->ID);
	if(!empty($tabs)){
		echo '<div class="tabset">';
		foreach($tabs as $key => $value){
			$attr = '';
			if($value['do_you_want_to_make_it_a_link'] == 1){
				$attr = 'data-link="'.$value['tab_link'].'"';
			}	?>
				<input type="radio" class="tab_open_cst" name="tabset" id="tab-<?=$key?>" <?= $attr?> aria-controls="tab_content-<?=$key?>" <?= ($key === 0) ? 'checked' : ''?>>
				<label for="tab-<?=$key?>"><?=$value['tab_title']?></label>				
			
		<?php }
		echo '<div class="tab-panels">';
		foreach($tabs as $key => $value){
				if($value['do_you_want_to_make_it_a_link'] != 1){ ?>
					<section id="tab_content-<?=$key?>" class="tab-panel">
						<?php echo apply_filters('the_content', $value['tab_content']); ?>
					</section>	
				<?php 
			} 
		 }
		echo '</div></div>';
	}
	return ob_get_clean();
}

add_action('wp_footer', 'solvoz_tabs_scripts');
function solvoz_tabs_scripts(){
	global $post;
	if( strpos( $post->post_content, "[solvoz-tabs" ) !== false ){ echo "hi"; ?>
		<script type="text/javascript">
			jQuery(document).on('click', '.tab_open_cst', function(){
				window.open(jQuery(this).attr("data-link"), '_blank');
			});
		</script>
	<?php 
	}
}

add_shortcode('tenders', 'tenders_callback');
function tenders_callback(){
	$args = array(
		'post_type' => 'post',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => array( 'active-tenders', 'closed-tenders' ),
				'operator' => 'IN'
			),
		),
	);
	$arr_posts = get_posts( $args );
	ob_start(); 
	if ( !empty($arr_posts) ) :  ?>
		<h2>Currently Advertised Tenders</h2>
		<table>
			<thead>
				<tr>
					<th>Tender Name</th>
					<th>Tender Location</th>
					<th>Type</th>
					<th>Description</th>
					<th>Advertised</th>
					<th>Closing</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($arr_posts as $key => $value) {
                    $id = $value->ID; ?>
                    <tr>
                        <td><a href="<?php the_field('link', $id); ?>" target="_blank"><?php echo $value->post_title ; ?></a>
                        </td>
                        <td><?php the_field('tender_location', $id); ?></td>
                        <td><?php the_field('type_of_tender', $id); ?></td>
                        <td><?php echo get_the_excerpt($id); ?></td>
                        <td><?php the_field('advertised_on', $id); ?></td>
                        <td><?php the_field('closing_on', $id); ?></td>
                    </tr>			
                <?php } ?>
			</tbody>
		</table><?php
	endif;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_filter( 'gettext', 'snippetpress_change_text', 10, 3 ); 
function snippetpress_change_text( $translation, $text, $domain ) {
    if ( $text == 'Job Type' ) {        
        $translation = __('Tender Type', $domain);
    }
    if ( $text == 'Job Locations' ) {        
        $translation = __('Tender Locations', $domain);
    }
    return $translation;
}
