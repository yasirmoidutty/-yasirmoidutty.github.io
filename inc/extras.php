<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Arouse
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function arouse_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	$display_slider = get_theme_mod( 'display_slider', false );
	
	if ( $display_slider == true && is_page_template( 'template-featured.php' )  && ! is_paged() ) { $classes[] = 'slider-active'; }
	
	if ( $display_slider == true && is_home() && ! is_paged() ) { $classes[] = 'slider-active'; }
	
	if ( is_page_template( 'template-slider.php' ) ) { $classes[] = 'slider-active'; }

	return $classes;
}
add_filter( 'body_class', 'arouse_body_classes' );


/**
 * Changes tag font size.
 */
function arouse_tag_cloud_sizes($args) {
	$args['smallest']	= 9;
	$args['largest'] 	= 9;
	return $args; 
}
add_filter('widget_tag_cloud_args','arouse_tag_cloud_sizes');

/**
 * Replaces content [...] with ...
 */
function arouse_excerpt_more( $more ) {

	if ( is_admin() ) {
		return $more;
	}

	return '&hellip; ';
}
add_filter( 'excerpt_more', 'arouse_excerpt_more' );

/**
 * WooCommerce Support
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

add_action('woocommerce_before_main_content', 'arouse_woocommerce_before_main_content', 10);
add_action('woocommerce_after_main_content', 'arouse_woocommerce_after_main_content', 10);

function arouse_woocommerce_before_main_content() {
	echo '<div class="container">';

	if ( is_active_sidebar( 'arouse-woocommerce-sidebar' ) ) {
		echo '<div class="row"><div class="col-xs-12 col-sm-12 col-md-8">';
	}
}

function arouse_woocommerce_after_main_content() {
	
	echo '</div><!-- .container -->';

	if ( ! is_active_sidebar( 'arouse-woocommerce-sidebar' ) ) {
		return;
	}

	?>

	<div class="col-xs-12 col-sm-6 col-md-4">
		<aside id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'arouse-woocommerce-sidebar' ); ?>
		</aside><!-- #secondary -->
	</div>

	<?php

	echo '</div><!-- .bootstrap-cols --></div><!-- .row -->';

}

function arouse_get_featured_content_ids() {

	$featured_content_type = get_theme_mod( 'featured_content_type', 'posts' );

	if ( $featured_content_type == 'sticky' ) {

		$featured_ids = get_posts( array(
						'fields' 				=> 'ids',
						'numberposts'			=> 3,
						'suppress_filters'		=> false,
						'post__in'  			=> get_option( 'sticky_posts' ),
						'ignore_sticky_posts' 	=> 1
					) );

	} elseif ( $featured_content_type == 'posts' ) {

		$category_id = get_theme_mod( 'fcontent_category', '' );

		if ( $category_id ) {

			$featured_ids = get_posts( array(
								'fields' 			=> 'ids',
								'numberposts'		=> 3,
								'suppress_filters'	=> false,
								'tax_query'			=> array(
										array(
											'field'		=> 'term_id',
											'taxonomy'	=> 'category',
											'terms'		=> $category_id,
										),
									),
								)
							);
		} else {

			// Get the latest post ids.
			$featured_ids = get_posts( array(
								'fields' 			=> 'ids',
								'numberposts'		=> 3,
								'suppress_filters'	=> false,
								)
							);

		}		

	} else {
		$featured_ids = array();
	}

	return array_map( 'absint', $featured_ids );

}

/**
 * Hides the first three featured posts from blog that are already displayed on featured content.
 */
function arouse_hide_featured_posts( $query ) {

	// Stop if the featured post boxes are not displayed.
	if( get_theme_mod( 'display_featured_section', false ) == false ) {
		return;
	}

	$featured_content_type = get_theme_mod( 'featured_content_type', 'posts' );
	
	// Stop if featured content type is pages.
	if( $featured_content_type == 'pages' ) {
		return;
	}

	// Stop if the user does not want to exclude posts from the blog posts.
	if( get_theme_mod( 'hide_fposts_onblog', false ) == false ) {
		return;
	}

	// Bail if not home or not main query.
	if ( ! $query->is_home() || ! $query->is_main_query() ) {
		return;
	}

	// Bail if the blog page is not the front page.
	if ( 'posts' !== get_option( 'show_on_front' ) ) {
		return;
	}

	$featured = arouse_get_featured_content_ids();

	// Bail if no featured posts.
	if ( ! $featured ) {
		return;
	}

	// We need to respect post ids already in the blacklist.
	$post__not_in = $query->get( 'post__not_in' );

	if ( ! empty( $post__not_in ) ) {
		$featured = array_merge( (array) $post__not_in, $featured );
		$featured = array_unique( $featured );
	}

	$query->set( 'post__not_in', $featured );	

}

add_action( 'pre_get_posts', 'arouse_hide_featured_posts', 30 );

/**
 * Hooks custom css into the head.
 */
function arouse_custom_styles() {
	
	$arouse_custom_styles = "";

	$primary_color = get_theme_mod( 'arouse_primary_color', '#a58e78' );

	$primary_color = esc_attr( $primary_color );

	if ( $primary_color != '#a58e78' ) {

		$arouse_custom_styles .= '
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"] {
				background: '. $primary_color .';
			}
			.main-navigation a:hover {
				color: '. $primary_color .';
			}
			.main-navigation .current_page_item > a,
			.main-navigation .current-menu-item > a,
			.main-navigation .current_page_ancestor > a,
			.main-navigation .current-menu-ancestor > a {
				color: '. $primary_color .';
			}
			.arouse-search-form .search-form .search-submit {
				background-color: '. $primary_color .';
			}
			.nav-links .current {
				background: '. $primary_color .';
			}
			.widget-area a:hover {
				color: '. $primary_color .';
			}
			.search-form .search-submit {
				background: '. $primary_color .';
			}
			.widget_tag_cloud .tagcloud a {
				background: '. $primary_color .';
			}
			.widget_tag_cloud .tagcloud a:hover {
				color: #ffffff;
			}	
			.ar-cat-title a:hover {
				color: '. $primary_color .';
			}		
			.site-title a:hover {
				color: '. $primary_color .';
			}
			.site-description {
				color: '. $primary_color .';
			}
			.arouse-post-list .entry-title a:hover,
			.arouse-post-list .search-entry-title a:hover,
			.arouse-post-grid .entry-title a:hover,
			.arouse-post-grid .search-entry-title a:hover {
				color: '. $primary_color .';
			}
			.page-template-template-featured .arouse-post-list .entry-title a:hover,
			.page-template-template-featured .arouse-post-list .search-entry-title a:hover,
			.page-template-template-featured .arouse-post-grid .entry-title a:hover,
			.page-template-template-featured .arouse-post-grid .search-entry-title a:hover {
				color: '. $primary_color .';
			}			
			.comment-author .fn,
			.comment-author .url,
			.comment-reply-link,
			.comment-reply-login {
				color: '. $primary_color .';
			}
			.woocommerce ul.products li.product .star-rating {
				color: '. $primary_color .';
			}
			.woocommerce ul.products li.product h3:hover {
				color: '. $primary_color .';
			}
			.woocommerce-product-search input[type="submit"] {
				background: '. $primary_color .';
			}			
			.woocommerce #respond input#submit,
			.woocommerce a.button,
			.woocommerce button.button,
			.woocommerce input.button {
				background: '. $primary_color .';
			}
			.woocommerce nav.woocommerce-pagination ul li span.current {
				background: '. $primary_color .';
			}	
			.woocommerce .star-rating span {
				color: '. $primary_color .';
			}	
			.woocommerce .posted_in a,
			a.woocommerce-review-link {
				color: '. $primary_color .';
			}';

	}

	$category_link_color = get_theme_mod( 'arouse_category_link_color', '#a58e78' );

	$category_link_color = esc_attr( $category_link_color );

	if ( $category_link_color != '#a58e78' ) {
		$arouse_custom_styles .= '
			.arouse-entry-category a {
				color: '. $category_link_color .';
			}
			.arouse-post-list .cat-links a,
			.arouse-post-grid .cat-links a {
				color: '. $category_link_color .';
			}	
			.page-template-template-featured .arouse-post-list .cat-links a,
			.page-template-template-featured .arouse-post-grid .cat-links a {
				color: '. $category_link_color .';
			}
		';
	}

	if ( ! empty( $arouse_custom_styles ) ) { ?>
		<style type="text/css">
			<?php echo $arouse_custom_styles; ?>
		</style>
	<?php }

}
add_action( 'wp_head', 'arouse_custom_styles' );