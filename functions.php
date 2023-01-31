<?php
/**
 * Arouse functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Arouse
 */

if ( ! function_exists( 'arouse_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function arouse_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Arouse, use a find and replace
	 * to change 'arouse' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'arouse', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'arouse-featured', 330, 240, true );
	add_image_size( 'arouse-featured-slider', 1070, 500, true );
	add_image_size( 'arouse-featured-single', 700, 510, true );
	add_image_size( 'arouse-featured-thumbnail', 100, 80, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'arouse' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'arouse_custom_background_args', array(
		'default-color' => 'eeeeee',
		'default-image' => '',
	) ) );

	// Declare custom logo support.
	add_theme_support( 'custom-logo', array(
		'height'      => 95,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	// Add editor style.
	add_editor_style( array( 'css/editor-style.css', arouse_fonts_url() ) );

	// Declare WooCommerce support.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Add support for featured content.
	add_theme_support( 'arouse-featured-content', array(
		'featured_content_filter' => 'arouse_get_featured_posts',
		'max_posts' => 5,
	) );	

}
endif;
add_action( 'after_setup_theme', 'arouse_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function arouse_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'arouse_content_width', 700 );
}
add_action( 'after_setup_theme', 'arouse_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function arouse_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'arouse' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'arouse' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Shop Page Sidebar', 'arouse' ),
		'id'            => 'arouse-woocommerce-sidebar',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	
	register_sidebar( array(
		'name'          => __( 'Footer Left Sidebar', 'arouse' ),
		'id'            => 'footer-left',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="footer-widget-title">',
		'after_title'   => '</h3>',
	) );	
	register_sidebar( array(
		'name'          => __( 'Footer Mid Sidebar', 'arouse' ),
		'id'            => 'footer-mid',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="footer-widget-title">',
		'after_title'   => '</h3>',
	) );	
	register_sidebar( array(
		'name'          => __( 'Footer Right Sidebar', 'arouse' ),
		'id'            => 'footer-right',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="footer-widget-title">',
		'after_title'   => '</h3>',
	) );	
}
add_action( 'widgets_init', 'arouse_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function arouse_scripts() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.6', false );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.6.3' );

	wp_enqueue_style( 'arouse-style', get_stylesheet_uri() );

	wp_enqueue_script( 'arouse-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'arouse-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'jquery-flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), '', true );

	wp_enqueue_script( 'arouse-flex-custom-js', get_template_directory_uri() . '/js/flex-custom.js', array(), '', true );

	wp_enqueue_style( 'jquery-flexslider', get_template_directory_uri() . '/css/flexslider.css', '', '', 'screen' );

	wp_enqueue_script( 'respond', get_template_directory_uri().'/js/respond.min.js' );
    wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );
 
    wp_enqueue_script( 'html5shiv',get_template_directory_uri().'/js/html5shiv.js');
    wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'arouse_scripts' );

/**
 * Load Google Fonts
 */
function arouse_fonts_url() {
    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by Open Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $open_sans = _x( 'on', 'Open Sans font: on or off', 'arouse' );

    /* Translators: If there are characters in your language that are not
    * supported by Montserrat, translate this to 'off'. Do not translate
    * into your own language.
    */
    $montserrat = _x( 'on', 'Montserrat font: on or off', 'arouse' );
 
    /* Translators: If there are characters in your language that are not
    * supported by Lora, translate this to 'off'. Do not translate
    * into your own language.
    */
    $lora = _x( 'on', 'Lora font: on or off', 'arouse' );
 
    if ( 'off' !== $open_sans || 'off' !== $montserrat || 'off' !== $lora ) {
        $font_families = array();
 
        if ( 'off' !== $montserrat ) {
            $font_families[] = 'Montserrat:400,500';
        }

        if ( 'off' !== $open_sans ) {
            $font_families[] = 'Open Sans:400,700,400italic,700italic';
        }
 
        if ( 'off' !== $lora ) {
            $font_families[] = 'Lora:400,400italic,700';
        }
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}
/**
* Enqueue Google fonts.
*/
function arouse_font_styles() {
    wp_enqueue_style( 'arouse-fonts', arouse_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'arouse_font_styles' );

/**
* Custom excerpt length.
*/
function arouse_excerpt_length( $length ) {

	if ( is_admin() ) {
		return $length;
	}

	return 30;
}
add_filter( 'excerpt_length', 'arouse_excerpt_length', 999 );

/**
 * Custom Logo
 */
function arouse_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load widgets.
 */
require get_template_directory() . '/inc/widgets/social-links-widget.php';
require get_template_directory() . '/inc/widgets/category-posts-widget.php';

function arouse_get_featured_posts() {
	return apply_filters( 'arouse_get_featured_posts', array() );
}

function arouse_has_featured_posts() {
	return ! is_paged() && (bool) arouse_get_featured_posts();
}

if ( ! class_exists( 'Arouse_Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content.php';
}