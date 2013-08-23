<?php
/**
 * {%= title %} functions and definitions
 *
 * @package {%= title %}
 * @since 0.1.0
 */

// Useful global constants
define( '{%= prefix_caps %}_VERSION', '0.1.0' );


/**
 * Set the content width based on the theme's design and stylesheet.
 */
 
if ( ! isset( $content_width ) )
	$content_width = 1280; /* pixels */


if ( ! function_exists( '{%= prefix %}_setup' ) ) :
 /**
	* Set up theme defaults and register supported WordPress features.
	*
	* @uses load_theme_textdomain() For translation/localization support.
	* @uses add_theme_support() For adding theme features.
	* @uses add_image_size() For adding image sizes.
	*
	* @since 0.1.0
	*/
	
	function {%= prefix %}_setup() {
		 
		/**
		 * Custom functions that act independently of the theme templates
		 */
		//require( get_template_directory() . '/inc/extras.php' );
		
		/**
		 * Makes {%= title %} available for translation.
		 *
		 * Translations can be added to the /lang directory.
		 * If you're building a theme based on {%= title %}, use a find and replace
		 * to change '{%= prefix %}' to the name of your theme in all template files.
		 */
		load_theme_textdomain( '{%= prefix %}', get_template_directory() . '/languages' );
		
		/**
		 * Enable support for Post Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		
		/**
		 * Custom image sizes
		 */
		//add_image_size( 'thumbnail-small', 110, 110, true );
		
		/**
		 * Enable support for Post Formats
		 */
		//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
		
		/**
		 * Add custom Post Types
		 */
		//add_post_types();
		
		/**
		 * Add custom Taxonomies
		 */
		//add_taxonomies();
		
		/**
		 * Remove extraneous things
		 */
		add_action( 'wp_head', 'remove_widget_action', 1);
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_filter( 'the_content', 'prepend_attachment' );
		
		function remove_widget_action() {
			global $wp_widget_factory;
			
			remove_action( 'wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style') );
		}
	}
endif; // {%= prefix %}_setup

add_action( 'after_setup_theme', '{%= prefix %}_setup' );


if ( ! function_exists( '{%= prefix %}_widgets_init' ) ) :
	/**
	 * Register widgetized area and update sidebar with default widgets
	 *
	 * @uses register_sidebar to register sidebars
	 *
	 * @since 0.1.0
	 */

	function {%= prefix %}_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', '{%= prefix %}' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		) );
	}
endif; // {%= prefix %}_widgets_init

//add_action( 'widgets_init', '{%= prefix %}_widgets_init' );


if ( ! function_exists( '{%= prefix %}_scripts_styles' ) ) :
	/**
	 * Enqueue scripts and styles.
	 *
	 * @uses wp_enqueue_script
	 * @uses wp_enqueue_style
	 *
	 * @since 0.1.0
	 */
	 
	function {%= prefix %}_scripts_styles() {
		if ( !is_admin() ) {
			$postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';
			
			wp_enqueue_script( '{%= prefix %}', get_template_directory_uri() . "/assets/js/{%= js_safe_name %}{$postfix}.js", array(), {%= prefix_caps %}_VERSION, true );
			wp_enqueue_script( '{%= prefix %}-head', get_template_directory_uri() . "/assets/js/head{$postfix}.js", array(), {%= prefix_caps %}_VERSION, false );
			
			wp_enqueue_style( '{%= prefix %}', get_template_directory_uri() . "/assets/css/{%= js_safe_name %}{$postfix}.css", array(), {%= prefix_caps %}_VERSION );
		}
	}
endif; // {%= prefix %}_scripts_styles

add_action( 'wp_enqueue_scripts', '{%= prefix %}_scripts_styles' );


if ( ! function_exists( '{%= prefix %}_admin_scripts_styles' ) ) :
	/**
	 * Enqueue admin scripts and styles.
	 *
	 * @uses wp_enqueue_script
	 * @uses wp_enqueue_style
	 *
	 * @since 0.1.0
	 */

	function {%= prefix %}_admin_scripts_styles() {
		$postfix = ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_script( '{%= prefix %}-admin', get_template_directory_uri() . "/assets/js/admin{$postfix}.js", array(), {%= prefix_caps %}_VERSION, true );

		wp_enqueue_style( '{%= prefix %}-admin', get_template_directory_uri() . "/assets/css/admin{$postfix}.css", array(), {%= prefix_caps %}_VERSION );
	}
endif; // {%= prefix %}_admin_scripts_styles

add_action( 'admin_enqueue_scripts', '{%= prefix %}_admin_scripts_styles' );


if ( ! function_exists( '{%= prefix %}_header_meta' ) ) :
	/**
	 * Add humans.txt to the <head> element.
	 *
	 * @uses apply_filters
	 *
	 * @since 0.1.0
	 */
	 
	function {%= prefix %}_header_meta() {
		$humans = '<link type="text/plain" rel="author" href="' . get_template_directory_uri() . '/humans.txt" />';
		
		$selectivizr = '<!--[if (gte IE 6)&(lte IE 8)]>';
		$selectivizr .= '<script type="text/javascript" src="' . get_template_directory_uri() . '/assets/js/vendor/selectivizr.js"></script>';
		$selectivizr .= '<![endif]-->';
		
		echo apply_filters( '{%= prefix %}_humans', $humans );
		
		//echo apply_filters( '{%= prefix %}_selectivizr', $selectivizr );
	}
endif; // {%= prefix %}_header_meta

add_action( 'wp_head', '{%= prefix %}_header_meta' );


if ( ! function_exists( '{%= prefix %}_post_types' ) ):
	/**
	 * Register Custom Post Types
	 *
	 * @uses register_post_types
	 *
	 * @since 0.1.0
	 */
	 
	function {%= prefix %}_post_types() {
		$labels = array(
			'name'                 => _x('Post Type', 'post type general name'),
			'singular_name'        => _x('Post Type', 'post type singular name'),
			'menu_name'            => __('Post Types'),
			'add_new'              => _x('Add New', 'post type'),
			'add_new_item'         => __('Add New Post Type'),
			'edit_item'            => __('Edit Post Type'),
			'new_item'             => __('New Post Type'),
			'all_items'            => __('All Post Types'),
			'view_item'            => __('View Post Type'),
			'search_items'         => __('Search Post Types'),
			'not_found'            => __('No post type found'),
			'not_found_in_trash'   => __('No post types found in Trash'),
			'parent_item_colon'    => '',
		);

		$args = array(
			'label'                => __('Post Types'),
			'labels'               => $labels,
			'public'               => true,
			'publicly_queryable'   => true,
			'show_ui'              => true,
			'show_in_menu'         => true,
			'show_in_nav_menus'    => true,
			'query_var'            => true,
			'rewrite'              => array(
				'slug'               	=> 'post-types',
				'hierarchical'       	=> false
			),
			'has_archive'          => 'post-types',
			'capability_type'      => 'post',
			'hierarchical'         => false,
			'menu_position'        => null,
			//'taxonomies'           => array(),
			//'register_meta_box_cb' => 'add_post-type_metaboxes',
			'supports'             => array( 'title','editor','thumbnail','excerpt' )
		);

		register_post_type( 'post-type-name', $args );
	}
endif; // {%= prefix %}_post_types


if ( ! function_exists( '{%= prefix %}_taxonomies' ) ):
	/**
	 * Register Custom Taxonomies
	 *
	 * @uses register_taxonomy
	 *
	 * @since 0.1.0
	 */

	function {%= prefix %}_taxonomies() {

		$labels = array(
			'name'              => _x( 'Genres', 'taxonomy general name' ),
			'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Genres' ),
			'all_items'         => __( 'All Genres' ),
			'parent_item'       => __( 'Parent Genre' ),
			'parent_item_colon' => __( 'Parent Genre:' ),
			'edit_item'         => __( 'Edit Genre' ),
			'update_item'       => __( 'Update Genre' ),
			'add_new_item'      => __( 'Add New Genre' ),
			'new_item_name'     => __( 'New Genre Name' ),
			'menu_name'         => __( 'Genre' ),
		);
	
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'genre' ),
		);
		
	}
	
	register_taxonomy( 'taxonomy-name', array( 'post-type' ), $args );

endif; // {%= prefix %}_taxonomies


if ( ! function_exists( '{%= prefix %}_post_connections' ) ):
	/**
	 * Register Post Connections
	 *
	 * Requires posts-to-posts plugin.
	 *
	 * @uses p2p_register_connection_type
	 *
	 * @since 0.1.0
	 */
	
	function {%= prefix %}_post_connections() {
		p2p_register_connection_type( array(
			'name' => 'connection_name',
			'from' => 'post-type',
			'to' => 'post-type',
			'reciprocal' => true,
			'sortable' => 'to',
			'admin_dropdown' => 'any',
			'admin_column' => 'any',
			'from_labels' => array(
				'column_title' => 'Column Title'
			),
			'to_labels' => array(
				'column_title' => 'Column Title'
			)
		) );
	}
endif; // {%= prefix %}_post_connections

//add_action( 'p2p_init', '{%= prefix %}_post_connections');


