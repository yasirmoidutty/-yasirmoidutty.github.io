<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Arouse
 */

if ( ! function_exists( 'arouse_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function arouse_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	$byline = sprintf(
		esc_html_x( 'By %s', 'post author', 'arouse' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
			comments_popup_link( __( 'Leave a comment', 'arouse' ), __( '1 Comment', 'arouse' ), __( '% Comments', 'arouse' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'arouse' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);

}
endif;


if ( ! function_exists( 'arouse_entry_footer' ) ) :
/**
 * Prints category list.
 */
function arouse_category_list() {
	
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'arouse' ) );
		if ( $categories_list && arouse_categorized_blog() ) {
			echo '<span class="cat-links">' . $categories_list . '</span>'; // WPCS: XSS OK.
		}
	}

}
endif;


if ( ! function_exists( 'arouse_tag_list' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function arouse_tag_list() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list();
		if ( $tags_list ) {
			echo '<span class="tags-links">' . $tags_list . '</span>';
		}
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function arouse_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'arouse_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'arouse_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so arouse_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so arouse_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in arouse_categorized_blog.
 */
function arouse_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'arouse_categories' );
}
add_action( 'edit_category', 'arouse_category_transient_flusher' );
add_action( 'save_post',     'arouse_category_transient_flusher' );
