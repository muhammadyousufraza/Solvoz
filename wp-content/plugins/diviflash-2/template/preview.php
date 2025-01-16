
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />

        <?php
		/**
		 * Fires in the head, before {@see wp_head()} is called. This action can be used to
		 * insert elements into the beginning of the head before any styles are scripts.
		 *
		 * @since 1.0
		 */
		do_action( 'et_head_meta' );
		?>

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<?php //wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="page-container">
			<div id="main-content">
				<div class="container">
                     <?php
                        echo et_core_intentionally_unescaped( apply_filters('the_content', wp_unslash($shortcode)), 'html' );
                     ?>
					</div> <!-- .entry-content.post-content.entry -->
					</div> <!-- #content -->
					<?php //echo et_builder_disabled_link_modal(); ?>
				</div><!-- .container -->
			</div><!-- #main-content -->
		</div> <!-- #page-container -->
		<?php wp_footer(); ?>
	</body>
</html>
