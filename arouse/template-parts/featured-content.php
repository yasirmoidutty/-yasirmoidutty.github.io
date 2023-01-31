<?php

$featured_content_type = get_theme_mod( 'featured_content_type', 'posts' );

if ( $featured_content_type == 'pages' ) {

	$page_array = array();
	for ( $i = 1; $i <= 3; $i++ ) {
	    $mod = get_theme_mod( 'featured_article_' . $i );
	    if ( 'page-none-selected' != $mod ) {
	        $page_array[] = $mod;
	    }
	}


	$featured_pages = new WP_Query(
		array (
			'posts_per_page'	=> 3,
			'post_type'			=> array( 'page' ),
			'post__in'			=> $page_array,
			'orderby'			=> 'post__in'
		)
	);

	?>

	<div class="arouse-featured-content">
		<div class="container">
			<div class="row">
				<?php 

					if ( $featured_pages->have_posts() ) :
					
						while( $featured_pages->have_posts() ) : $featured_pages->the_post(); ?>
					
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<a href="<?php the_permalink(); ?>" rel="bookmark">
							<div class="arouse-fpage-block">
								
	                            <?php if ( has_post_thumbnail() ) { 

	                                $thumb_id           = get_post_thumbnail_id();
	                                $thumb_url_array    = wp_get_attachment_image_src( $thumb_id, 'arouse-featured' );
	                                $featured_image_url = $thumb_url_array[0]; 

	                                ?>
	                                <div class="arouse-fpage-holder" style="background: url(<?php echo esc_url( $featured_image_url ); ?>);">
	                            <?php } else { ?>
	                                <div class="arouse-fpage-holder" style="background: url(<?php echo get_template_directory_uri() . '/images/featured-default.jpg' ?>);">
	                            <?php } ?>	

	                            		<div class="arouse-fpage-content">	

											<?php if ( get_theme_mod( 'display_page_titles', true ) ) : ?>
												<div class="overlay"></div>
												<div class="arouse-fpage-title">
													<h3><?php the_title(); ?></h3>
												</div>
											<?php endif; ?>

										</div><!-- .arouse-fpage-content -->

									</div><!-- .arouse-fpage-holder -->

							</div><!-- .arouse-fpage-block -->
							</a>
						</div><!--.bootstrap cols -->

					<?php 
						endwhile; 
						wp_reset_postdata();

					endif;
				?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .arouse-featured-content -->

<?php } elseif ( $featured_content_type == 'posts' ) {

	$fcontent_category = get_theme_mod( 'fcontent_category', '' );

	$featured_posts = new WP_Query(
		array (
			'cat'					=> $fcontent_category,
			'posts_per_page'		=> 3,
			'ignore_sticky_posts'	=> true
		)
	);

	?>

	<div class="arouse-featured-content">
		<div class="container">
			<div class="row">
				<?php 

					if ( $featured_posts->have_posts() ) :
					
						while( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>
					
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<a href="<?php the_permalink(); ?>" rel="bookmark">
							<div class="arouse-fpost-block">

	                            <?php if ( has_post_thumbnail() ) { 

	                                $thumb_id           = get_post_thumbnail_id();
	                                $thumb_url_array    = wp_get_attachment_image_src( $thumb_id, 'arouse-featured' );
	                                $featured_image_url = $thumb_url_array[0]; 

	                                ?>
	                                <div class="arouse-fpost-holder" style="background: url(<?php echo esc_url( $featured_image_url ); ?>);">
	                            <?php } else { ?>
	                                <div class="arouse-fpost-holder" style="background: url(<?php echo get_template_directory_uri() . '/images/featured-default.jpg' ?>);">
	                            <?php } ?>	

	                            		<div class="arouse-fpost-content">							

										<?php if ( get_theme_mod( 'display_fpost_titles', true ) ) : ?>
											<div class="overlay"></div>
											<div class="arouse-fpost-title">
												<h3><?php the_title(); ?></h3>
											</div>
										<?php endif; ?>

										</div><!-- .arouse-fpost-content -->

									</div><!-- .arouse-fpost-holder -->

							</div><!-- .arouse-fpost-block -->
							</a>
						</div><!--.bootstrap cols -->

					<?php
						endwhile; 
						wp_reset_postdata();

					endif;
				?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .arouse-featured-content -->

<?php } elseif ( $featured_content_type == 'sticky' ) {

	$featured_posts = new WP_Query(
		array(
			'posts_per_page' => 3,
			'post__in'  => get_option( 'sticky_posts' ),
			'ignore_sticky_posts' => 1
		)
	);

	?>

	<div class="arouse-featured-content">
		<div class="container">
			<div class="row">
				<?php 

					if ( $featured_posts->have_posts() ) :
					
						while( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>
					
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<a href="<?php the_permalink(); ?>" rel="bookmark">
							<div class="arouse-fpost-block">

	                            <?php if ( has_post_thumbnail() ) { 

	                                $thumb_id           = get_post_thumbnail_id();
	                                $thumb_url_array    = wp_get_attachment_image_src( $thumb_id, 'arouse-featured' );
	                                $featured_image_url = $thumb_url_array[0]; 

	                                ?>
	                                <div class="arouse-fpost-holder" style="background: url(<?php echo esc_url( $featured_image_url ); ?>);">
	                            <?php } else { ?>
	                                <div class="arouse-fpost-holder" style="background: url(<?php echo get_template_directory_uri() . '/images/featured-default.jpg' ?>);">
	                            <?php } ?>	

	                            		<div class="arouse-fpost-content">							

										<?php if ( get_theme_mod( 'display_fpost_titles', true ) ) : ?>
											<div class="overlay"></div>
											<div class="arouse-fpost-title">
												<h3><?php the_title(); ?></h3>
											</div>
										<?php endif; ?>

										</div><!-- .arouse-fpost-content -->

									</div><!-- .arouse-fpost-holder -->

							</div><!-- .arouse-fpost-block -->
							</a>
						</div><!--.bootstrap cols -->

					<?php
						endwhile; 
						wp_reset_postdata();

					endif;
				?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .arouse-featured-content -->

<?php }