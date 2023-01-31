<?php

class Arouse_Featured_Content {

	public static $max_posts = 5;

	public static function setup() {
		add_action( 'init', array( __CLASS__ , 'init' ), 30 );
	}

	public static function init() {

		$theme_support = get_theme_support( 'arouse-featured-content' );

		// Return early if theme does not support Featured Content.
		if ( ! $theme_support ) {
			return;
		}

		/*
		 * An array of named arguments must be passed as the second parameter
		 * of add_theme_support().
		 */
		if ( ! isset( $theme_support[0] ) ) {
			return;
		}

		// Return early if "featured_content_filter" has not been defined.
		if ( ! isset( $theme_support[0]['featured_content_filter'] ) ) {
			return;
		}

		$filter = $theme_support[0]['featured_content_filter'];

		// Theme can override the number of max posts.
		if ( isset( $theme_support[0]['max_posts'] ) ) {
			self::$max_posts = absint( $theme_support[0]['max_posts'] );
		}

		add_filter( $filter, array( __CLASS__, 'get_featured_posts' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'exclude_single_posts_home' ) );
		add_action( 'customize_register', array( __CLASS__, 'customize_register' ) );
	}

	public static function get_featured_posts() {

		$post_ids = self::get_featured_post_ids();

		// No need to query if there are no featured posts.
		if ( empty( $post_ids ) ) {
			return array();
		}

		$featured_posts = get_posts( array(
			'include'        => $post_ids,
			'posts_per_page' => count( $post_ids ),
		) );

		return $featured_posts;		

	}

	public static function get_featured_post_ids() {

		$category_id = get_theme_mod( 'slider_category', '' );

		if ( $category_id ) {

			$featured_ids = get_posts( array(
								'fields' 			=> 'ids',
								'numberposts'		=> self::$max_posts,
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
								'numberposts'		=> self::$max_posts,
								'suppress_filters'	=> false,
								)
							);

		}

		// Ensure correct format before return.
		return array_map( 'absint', $featured_ids );

	}

	public static function exclude_single_posts_home( $query ) {

		// Stop if the user does not want to exclude posts from the blog posts.
		if( get_theme_mod( 'show_slider_posts_onblog', true ) ) {
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

		$featured = self::get_featured_post_ids();

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

	public static function customize_register( $wp_customize ) {

		/**
	     * Slider Settings section.
	     */
	    $wp_customize->add_section( 
	    	'arouse_slider', 
	    	array(
				'title' => __( 'Slider', 'arouse' ),
				'description' => __( 'Use this section to setup the front page slider. Featured images of the posts of the selected category will be displayed as slider images.', 'arouse' ),
				'priority' => 30,
			) 
		);

	    // Display slider?
	    $wp_customize->add_setting(
			'display_slider',
			array(
				'default'			=> false,
				'sanitize_callback'	=> 'arouse_sanitize_checkbox'
			)
		);
	    $wp_customize->add_control(
			'display_slider',
			array(
				'settings'		=> 'display_slider',
				'section'		=> 'arouse_slider',
				'type'			=> 'checkbox',
				'label'			=> __( 'Display slider?', 'arouse' )
			)
		);

		$wp_customize->add_setting(
			'slider_category',
			array(
				'default'			=> '',
				'sanitize_callback'	=> 'arouse_sanitize_category_dropdown'
			)
		);

		$wp_customize->add_control(
			new Arouse_Customize_Category_Control( 
				$wp_customize,
				'slider_category', 
				array(
				    'label'   		=> __( 'Select the category for slider.', 'arouse' ),
				    'description'	=> __( 'Featured images of the posts from selected category will be displayed in the slider', 'arouse' ),
				    'section' 		=> 'arouse_slider',
				    'settings'  	=> 'slider_category',
				) 
			) 
		);
	
	    $wp_customize->add_setting(
			'show_slider_posts_onblog',
			array(
				'default'			=> true,
				'sanitize_callback'	=> 'arouse_sanitize_checkbox'
			)
		);
	    $wp_customize->add_control(
			'show_slider_posts_onblog',
			array(
				'settings'			=> 'show_slider_posts_onblog',
				'section'			=> 'arouse_slider',
				'active_callback'	=> 'arouse_is_home_activated',
				'type'				=> 'checkbox',
				'label'				=> __( 'Display slider posts on blog?', 'arouse' ),
				'description'		=> __( 'Leave the checkbox empty if you want to hide posts from blog that are already displayed in the slider', 'arouse' )
			)
		);
	
	}

}

Arouse_Featured_Content::setup();