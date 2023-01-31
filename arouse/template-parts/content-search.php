<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Arouse
 */

?>

<?php 

$arouse_post_layout = get_theme_mod('archive_listing_layout', 'grid');
$arouse_post_class = ( $arouse_post_layout === 'grid' ) ? 'arouse-post-grid' : 'arouse-post-list';

?>


<article id="post-<?php the_ID(); ?>" <?php post_class( $arouse_post_class ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'arouse-featured' ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="post-content-wrapper">
		<header class="search-entry-header">
			<div class="arouse-entry-category">
				<?php arouse_category_list() ?>
			</div><!-- .entry-meta -->

			<?php
				the_title( '<h2 class="search-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->

		<div class="entry-meta">
			<?php arouse_posted_on(); ?>
		</div><!-- .entry-footer -->
	</div>
</article><!-- #post-## -->
