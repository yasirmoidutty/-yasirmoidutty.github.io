<?php
/**
 * Template Name: Slider Page
 *
 * Description: A custom page template to display a slider, featured pages and content.
 *
 * @package Arouse
 */

get_header(); 

get_template_part('template-parts/slider');

if ( get_theme_mod( 'display_featured_section', false ) ) {
	get_template_part('template-parts/featured', 'content');
}

?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">

					<?php
					while ( have_posts() ) : the_post();

						get_template_part( 'template-parts/content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>

				</main><!-- #main -->
			</div><!-- #primary -->

		</div><!-- .cols-->
		<div class="col-xs-6 col-sm-6 col-md-4">
			<?php get_sidebar(); ?>
		</div><!-- .cols-->
	</div><!-- .row -->
</div><!-- .container -->
<?php
get_footer();