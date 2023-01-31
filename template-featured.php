<?php
/**
 * Template Name: Featured Front Page
 *
 * Description: A custom page template to display a slider, featured content and blog posts.
 *
 * @package Arouse
 */

get_header();

if ( get_theme_mod( 'display_slider', false ) && ! is_paged() ) {
	get_template_part('template-parts/slider');
}

if ( get_theme_mod( 'display_featured_section', false ) && ! is_paged() ) {
	get_template_part('template-parts/featured', 'content');
}

?>

<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8">
			<div id="primary" class="content-area">

				<main id="main" class="site-main" role="main">

				<?php

				if ( ! is_paged() ) {
					echo '<div class="arouse-listing-title"><p>';
						_e( 'Latest Articles', 'arouse' );
					echo "</p></div>";
				}

				$posts_per_page = get_option( 'posts_per_page' );
	
				$custom_query_args = array( 'posts_per_page' => $posts_per_page );

				// Get current page and append to custom query parameters array
				$custom_query_args['paged'] = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;

				$custom_query = new WP_Query( $custom_query_args );

				// Pagination fix
				$temp_query = $wp_query;
				$wp_query   = NULL;
				$wp_query   = $custom_query;

				
				if ( $custom_query->have_posts() ) :

					echo '<div class="grid-wrapper">';

				    while ( $custom_query->have_posts() ) :
				        
				        $custom_query->the_post();

				    	get_template_part( 'template-parts/content', '' );

				    endwhile;

				    echo '</div>';
				    
				endif;
				
				wp_reset_postdata();

				the_posts_pagination();

				// Reset main query object
				$wp_query = NULL;
				$wp_query = $temp_query; 

				?>							

				</main><!-- #main -->				         

			</div><!-- #primary -->
		</div><!-- .cols-->
		
		<div class="col-xs-12 col-sm-6 col-md-4">
			<?php get_sidebar(); ?>
		</div><!-- .cols-->

	</div><!-- .row -->

	<?php get_sidebar('content-bottom'); ?>

</div><!-- .container -->

<?php get_footer();