<?php
/**
 * mayhem-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mayhem-theme
 */

if ( ! function_exists( 'mayhem_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the 'after_setup_theme' hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mayhem_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on mayhem-theme, use a find and replace
		 * to change 'mayhem' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'mayhem', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'mayhem' ),
			'social' => esc_html__( 'Social Media Menu', 'mayhem' ),
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
		add_theme_support( 'custom-background', apply_filters( 'mayhem_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo' );
	}
endif;
add_action( 'after_setup_theme', 'mayhem_setup' );

if ( ! function_exists( 'mayhem_content_width' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function mayhem_content_width() {
		// This variable is intended to be overruled from themes.
		// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
		$GLOBALS['content_width'] = apply_filters( 'mayhem_content_width', 640 );
	}
endif;
add_action( 'after_setup_theme', 'mayhem_content_width', 0 );

if ( ! function_exists( 'mayhem_widgets_init' ) ) :
	/**
	 * Register widget area.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	function mayhem_widgets_init() {
		// Default Widget Area
		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'mayhem' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'mayhem' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		// Footer Widget Area
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Widget', 'mayhem' ),
			'id'            => 'footer-widget',
			'description'   => esc_html__( 'Footer Widget Area.', 'mayhem' ),
			'before_widget' => '<section id="%1$s" class="footer-widget widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="footer-widget__title widget-title">',
			'after_title'   => '</h2>',
		) );
	}
endif;
add_action( 'widgets_init', 'mayhem_widgets_init' );

if ( ! function_exists( 'mayhem_scripts' ) ) :
	/**
	 * Enqueue scripts and styles.
	 */
	function mayhem_scripts() {
		wp_enqueue_style( 'mayhem-style', get_stylesheet_uri(), NULL, microtime() );

		wp_enqueue_script( 'mayhem-navigation', get_template_directory_uri() . '/js/navigation.js', array(), microtime(), true);

		wp_enqueue_script( 'mayhem-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), microtime(), true );

		// Font Awesome
		wp_enqueue_style( 'font-awesome', 'https://use.fontawesome.com/releases/v5.0.13/css/all.css');

		// Enqueue roster.js if on archive-roster.php page
		if (is_post_type_archive('roster')) {
			wp_enqueue_script( 'mayhem-roster', get_template_directory_uri() . '/js/roster.js', array(), microtime(), true );
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
endif;
add_action( 'wp_enqueue_scripts', 'mayhem_scripts' );

// Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) :
	require get_template_directory() . '/inc/jetpack.php';
endif;
// Implement the Custom Header feature.
require get_template_directory() . '/inc/custom-header.php';
// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';
// Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';
// Customizer additions.
require get_template_directory() . '/inc/customizer.php';
// Custom hooks
require get_template_directory() . '/inc/custom-hooks/custom-hooks-main.php';
// PHP Helper functions
require get_template_directory() . '/inc/helper-functions.php';