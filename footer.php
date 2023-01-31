<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Arouse
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="row">
				<div class="footer-widget-area">
					<div class="col-md-4">
						<div class="left-footer">
							<div id="secondary" class="widget-area" role="complementary">
								<?php if ( ! dynamic_sidebar( 'footer-left' ) ) : ?>
									
								<?php endif; // end sidebar widget area ?>
							</div><!-- #secondary -->
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="mid-footer">
							<div id="secondary" class="widget-area" role="complementary">
								<?php if ( ! dynamic_sidebar( 'footer-mid' ) ) : ?>

								<?php endif; // end sidebar widget area ?>
							</div><!-- #secondary -->						</div>
					</div>

					<div class="col-md-4">
						<div class="right-footer">
							<div id="secondary" class="widget-area" role="complementary">
								<?php if ( ! dynamic_sidebar( 'footer-right' ) ) : ?>

								<?php endif; // end sidebar widget area ?>
							</div><!-- #secondary -->				
						</div>
					</div>						
				</div><!-- .footer-widget-area -->
			</div><!-- .row -->
		</div><!-- .container -->
		<div class="site-info">
			<div class="container">
				<div>
					<?php 

						$site_link = '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" >' . esc_attr( get_bloginfo( 'name' ) ) . '</a>';
						printf( __( 'Copyright &#169; %1$s %2$s.', 'arouse' ), date_i18n( 'Y' ), $site_link );		
					
					?>
				</div>
				<div>
					<?php
						printf( esc_html__( 'Powered by %1$s and %2$s.', 'arouse' ),
							'<a href="http://wordpress.org" target="_blank" title="WordPress">WordPress</a>',
							'<a href="http://themezhut.com/themes/arouse/" target="_blank" title="Arouse WordPress Theme">Arouse</a>'
						); 
					?>
				</div>
			</div><!-- .container -->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

</div><!-- #wrapper -->

<?php wp_footer(); ?>
</body>
</html>
