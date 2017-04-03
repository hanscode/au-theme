<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own ghostpool_theme_setup() function to override in a child theme.
 *
 */
if ( ! function_exists( 'ghostpool_theme_setup' ) ) {
	function ghostpool_theme_setup() {

		// Localisation
		load_theme_textdomain( 'socialize', trailingslashit( WP_LANG_DIR ) . 'themes/' );
		load_theme_textdomain( 'socialize', get_stylesheet_directory() . '/languages' );
		load_theme_textdomain( 'socialize', get_template_directory() . '/languages' );

		// If theme plugin is not activated
		if ( ! function_exists( 'ghostpool_option' ) && ! function_exists( 'redux_post_meta' ) ) {
			function ghostpool_option( $gp_opt_1, $gp_opt_2 = false, $gp_opt_3 = false ) {
				if ( $gp_opt_3 != false ) {
					return $gp_opt_3;
				}
			}
			function redux_post_meta() {}
		}

		// Featured images
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 150, 150, true );

		// Background customizer
		add_theme_support( 'custom-background' );

		// This theme styles the visual editor with editor-style.css to match the theme style
		add_editor_style( 'lib/css/editor-style.css' );

		// Add default posts and comments RSS feed links to <head>
		add_theme_support( 'automatic-feed-links' );

		// WooCommerce Support
		add_theme_support( 'woocommerce' );

		// Post formats
		add_theme_support( 'post-formats', array( 'quote', 'video', 'audio', 'gallery', 'link' ) );

		// Title support
		add_theme_support( 'title-tag' );

		// Register navigation menus
		register_nav_menus( array(
			'gp-primary-main-header-nav' => esc_html__( 'Primary Main Header Navigation', 'socialize' ),
			'gp-secondary-main-header-nav' => esc_html__( 'Secondary Main Header Navigation', 'socialize' ),
			'gp-left-small-header-nav'    => esc_html__( 'Left Small Header Navigation', 'socialize' ),
			'gp-right-small-header-nav' => esc_html__( 'Right Small Header Navigation', 'socialize' ),
			'gp-footer-nav' => esc_html__( 'Footer Navigation', 'socialize' ),
		) );

		// Category options
		require_once( get_template_directory() . '/lib/inc/category-config.php' );

		// Init variables
		require_once( get_template_directory() . '/lib/inc/init-variables.php' );

		// Loop variables
		require_once( get_template_directory() . '/lib/inc/loop-variables.php' );

		// Category variables
		require_once( get_template_directory() . '/lib/inc/category-variables.php' );

		// Page headers
		require_once( get_template_directory() . '/lib/inc/page-headers.php' );

		// Image resizer
		require_once( get_template_directory() . '/lib/inc/aq_resizer.php' );

		// Custom menu walker
		require_once( get_template_directory() . '/lib/menus/custom-menu-walker.php' );

		// Custom menu fields
		require_once( get_template_directory() . '/lib/menus/menu-item-custom-fields.php' );

		// Plugin defaults
		require_once( get_template_directory() . '/lib/inc/plugin-defaults.php' );

		// Theme updates
		require_once( get_template_directory() . '/lib/inc/github.php' );

		// BuddyPress functions
		if ( function_exists( 'bp_is_active' ) ) {
			require_once( get_template_directory() . '/lib/inc/bp-functions.php' );
		}

		// bbPress functions
		if ( function_exists( 'is_bbpress' ) ) {
			require_once( get_template_directory() . '/lib/inc/bbpress-functions.php' );
		}

		// Woocommerce functions
		if ( function_exists( 'is_woocommerce' ) ) {
			require_once( get_template_directory() . '/lib/inc/wc-functions.php' );
		}

		// Shortcodes
		if ( function_exists( 'vc_set_as_theme' ) ) {
			require_once( get_template_directory() . '/lib/inc/default-vc-templates.php' );
			function ghostpool_vc_shortcodes_container() {
				if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
					class WPBakeryShortCode_Pricing_Table extends WPBakeryShortCodesContainer {}
					class WPBakeryShortCode_Testimonial_Slider extends WPBakeryShortCodesContainer {}
					class WPBakeryShortCode_Team extends WPBakeryShortCodesContainer {}
				}
				if ( class_exists( 'WPBakeryShortCode' ) ) {
					class WPBakeryShortCode_Pricing_Column extends WPBakeryShortCode {}
					class WPBakeryShortCode_Testimonial extends WPBakeryShortCode {}
					class WPBakeryShortCode_Team_Member extends WPBakeryShortCode {}
				}
			}
			add_action( 'init', 'ghostpool_vc_shortcodes_container' );
		}

		// Load ajax
		require_once( get_template_directory() . '/lib/inc/ajax.php' );

		// Login settings
		include_once( get_template_directory() . '/lib/inc/login-settings.php' );

	}
}
add_action( 'after_setup_theme', 'ghostpool_theme_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 */
function ghostpool_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ghostpool_content_width', 730 );
}
add_action( 'after_setup_theme', 'ghostpool_content_width', 0 );

/**
 * Enqueues scripts and styles.
 *
 */
if ( ! function_exists( 'ghostpool_scripts' ) ) {

	function ghostpool_scripts() {

		wp_enqueue_style( 'ghostpool-style', get_stylesheet_uri() );

		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/lib/fonts/font-awesome/css/font-awesome.min.css' );

		if ( ghostpool_option( 'lightbox' ) != 'disabled' ) {
			wp_enqueue_style( 'prettyphoto', get_template_directory_uri() . '/lib/scripts/prettyPhoto/css/prettyPhoto.css' );
		}

		if ( ghostpool_option( 'custom_stylesheet' ) ) {
			wp_enqueue_style( 'ghostpool-custom-style', get_template_directory_uri() . '/' . ghostpool_option( 'custom_stylesheet' ) );
		}

		$gp_custom_css = '';

		$gp_custom_css .= '<!--[if gte IE 9]>.gp-slider-wrapper .gp-slide-caption + .gp-post-thumbnail:before,body:not(.gp-full-page-page-header) .gp-page-header.gp-has-text:before,body:not(.gp-full-page-page-header) .gp-page-header.gp-has-teaser-video.gp-has-text .gp-video-header:before{filter: none;}<![endif]-->' .

		'#gp-main-header {height:' . ghostpool_option( 'desktop_header_height', 'height' ) . 'px;}' .

		'.gp-scrolling #gp-main-header {height:' . ghostpool_option( 'desktop_scrolling_header_height', 'height' ) . 'px;}' .

		'.gp-header-standard #gp-logo {padding:' . ( ghostpool_option( 'desktop_header_height', 'height' ) - ghostpool_option( 'desktop_logo_dimensions', 'height' ) ) / 2 . 'px 0;}' .

		'.gp-scrolling.gp-header-standard #gp-logo {padding:' . ( ghostpool_option( 'desktop_scrolling_header_height', 'height' ) - ghostpool_option( 'desktop_logo_dimensions', 'height' ) ) / 2 . 'px 0;}' .

		'.gp-header-standard #gp-primary-main-nav .menu > li > a{padding:' . ( ghostpool_option( 'desktop_header_height', 'height' ) - ( ghostpool_option( 'primary_nav_typography', 'line-height' ) + ghostpool_option( 'primary_nav_link_border_hover', 'border-top' ) ) ) / 2 . 'px 0;}
		.gp-header-standard #gp-cart-button,.gp-header-standard #gp-search-button,.gp-header-standard #gp-profile-button{padding:' . ( ghostpool_option( 'desktop_header_height', 'height' ) - 18 ) / 2 . 'px 0;}' .

		'.gp-scrolling.gp-header-standard #gp-primary-main-nav .menu > li > a{padding:' . ( ghostpool_option( 'desktop_scrolling_header_height', 'height' ) - ( ghostpool_option( 'primary_nav_typography', 'line-height' ) + ghostpool_option( 'primary_nav_link_border_hover', 'border-top' ) ) ) / 2 . 'px 0;}
		.gp-scrolling.gp-header-standard #gp-cart-button,.gp-scrolling.gp-header-standard #gp-search-button,.gp-scrolling.gp-header-standard #gp-profile-button{padding:' . ( ghostpool_option( 'desktop_scrolling_header_height', 'height' ) - 18 ) / 2 . 'px 0;}' .

		'.gp-nav .menu > .gp-standard-menu > .sub-menu > li:hover > a{color:' . ghostpool_option( 'dropdown_link', 'hover' ) . '}' .

		'.gp-theme li:hover .gp-primary-dropdown-icon{color:' . ghostpool_option( 'primary_dropdown_icon', 'hover' ) . '}' .

		'.gp-theme .sub-menu li:hover .gp-secondary-dropdown-icon{color:' . ghostpool_option( 'secondary_dropdown_icon', 'hover' ) . '}' .

		'.gp-header-centered #gp-cart-button,.gp-header-centered #gp-search-button,.gp-header-centered #gp-profile-button{line-height:' . ( ghostpool_option( 'primary_nav_typography', 'line-height' ) + 2 ) . 'px;}' .

		'.gp-header-standard #gp-secondary-main-nav .menu > li > a{padding:' . ( ghostpool_option( 'desktop_header_height', 'height' ) - ( ghostpool_option( 'secondary_nav_typography', 'line-height' ) + ghostpool_option( 'secondary_nav_link_border_hover', 'border-top' ) ) ) / 2 . 'px 0;}' .

		'.gp-scrolling.gp-header-standard #gp-secondary-main-nav .menu > li > a{padding:' . ( ghostpool_option( 'desktop_scrolling_header_height', 'height' ) - ( ghostpool_option( 'secondary_nav_typography', 'line-height' ) + ghostpool_option( 'secondary_nav_link_border_hover', 'border-top' ) ) ) / 2 . 'px 0;}' .

		'.gp-header-centered #gp-secondary-main-nav .menu > li > a {line-height:' . ghostpool_option( 'primary_nav_typography', 'line-height' ) . ';}' .

		'.gp-active{color: ' . ghostpool_option( 'general_link', 'hover' ) . ';}' .

		'.gp-theme .widget.buddypress div.item-options a.selected:hover{color: ' . ghostpool_option( 'widget_title_link', 'regular' ) . '!important;}' .

		'.gp-theme #buddypress .activity-list .activity-content blockquote a{color: ' . ghostpool_option( 'general_link', 'regular' ) . '}' .

		'.gp-theme #buddypress .activity-list .activity-content blockquote a:hover{color: ' . ghostpool_option( 'general_link', 'hover' ) . '}' .

		'@media only screen and (max-width: 1082px) {' .

			'.gp-header-standard #gp-primary-main-nav .menu > li > a {padding:' . ( ghostpool_option( 'desktop_header_height', 'height' ) - ( 16 + ghostpool_option( 'primary_nav_link_border_hover', 'border-top' ) ) ) / 2 . 'px 0;}' .

			'.gp-scrolling.gp-header-standard #gp-primary-main-nav .menu > li > a {padding:' . ( ghostpool_option( 'desktop_scrolling_header_height', 'height' ) - ( 16 + ghostpool_option( 'primary_nav_link_border_hover', 'border-top' ) ) ) / 2 . 'px 0;}' .

			'.gp-header-standard #gp-cart-button,.gp-header-standard #gp-search-button,.gp-header-standard #gp-profile-button{padding:' . ( ghostpool_option( 'desktop_header_height', 'height' ) - 18 ) / 2 . 'px 0;}' .

			'.gp-scrolling.gp-header-standard #gp-cart-button,.gp-scrolling.gp-header-standard #gp-search-button,.gp-scrolling.gp-header-standard #gp-profile-button{padding:' . ( ghostpool_option( 'desktop_scrolling_header_height', 'height' ) - 18 ) / 2 . 'px 0;}' .

			'.gp-header-standard #gp-secondary-main-nav .menu > li > a{padding:' . ( ghostpool_option( 'desktop_header_height', 'height' ) - ( 14 + ghostpool_option( 'secondary_nav_link_border_hover', 'border-top' ) ) ) / 2 . 'px 0;}' .

			'.gp-scrolling.gp-header-standard #gp-secondary-main-nav .menu > li > a{padding:' . ( ghostpool_option( 'desktop_scrolling_header_height', 'height' ) - ( 14 + ghostpool_option( 'secondary_nav_link_border_hover', 'border-top' ) ) ) / 2 . 'px 0;}' .

		'}' .

		'@media only screen and (max-width: 1023px) {' .

			'.gp-responsive #gp-main-header {height:' . ghostpool_option( 'mobile_header_height', 'height' ) . 'px;}' .

			'.gp-responsive #gp-logo {padding:' . ( ghostpool_option( 'mobile_header_height', 'height' ) - ghostpool_option( 'mobile_logo_dimensions', 'height' ) ) / 2 . 'px 0;}' .

			'.gp-responsive #gp-mobile-nav-button,.gp-responsive #gp-cart-button,.gp-responsive #gp-search-button,.gp-responsive #gp-profile-button{padding:' . ( ghostpool_option( 'mobile_header_height', 'height' ) - 18 ) / 2 . 'px 0;}' .

		'}';

		if ( ghostpool_option( 'custom_css' ) ) {
			$gp_custom_css .= ghostpool_option( 'custom_css' );
		}

		wp_add_inline_style( 'ghostpool-style', $gp_custom_css );

		wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/lib/scripts/modernizr.js', false, '', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		if ( ghostpool_option( 'smooth_scrolling' ) == 'gp-smooth-scrolling' ) {
			wp_enqueue_script( 'nicescroll', get_template_directory_uri() . '/lib/scripts/nicescroll.min.js', false, '', true );
		}

		wp_enqueue_script( 'selectivizr', get_template_directory_uri() . '/lib/scripts/selectivizr.min.js', false, '', true );

		wp_enqueue_script( 'placeholder', get_template_directory_uri() . '/lib/scripts/placeholders.min.js', false, '', true );

		if ( ghostpool_option( 'lightbox' ) != 'disabled' ) {
			wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/lib/scripts/prettyPhoto/js/jquery.prettyPhoto.js', array( 'jquery' ), '', true );
		}

		if ( ghostpool_option( 'back_to_top' ) != 'gp-no-back-to-top' ) {
			wp_enqueue_script( 'jquery-totop', get_template_directory_uri() . '/lib/scripts/jquery.ui.totop.min.js', array( 'jquery' ), '', true );
		}

		wp_enqueue_script( 'jquery-flexslider', get_template_directory_uri() . '/lib/scripts/jquery.flexslider-min.js', array( 'jquery' ), '', true );

		wp_enqueue_script( 'isotope', get_template_directory_uri() . '/lib/scripts/isotope.pkgd.min.js', false, '', true );

		wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/lib/scripts/imagesLoaded.min.js', false, '', true );

		wp_enqueue_script( 'jquery-stellar', get_template_directory_uri() . '/lib/scripts/jquery.stellar.min.js', array( 'jquery' ), '', true );

		wp_enqueue_script( 'ghostpool-video-header', get_template_directory_uri() . '/lib/scripts/jquery.video-header.js', array( 'jquery' ), '', true );

		if ( is_singular( 'post' ) ) {
			$gp_items_in_view = ghostpool_option( 'post_related_items_in_view' );
		} elseif ( is_singular( 'gp_portfolio_item' ) ) {
			$gp_items_in_view = ghostpool_option( 'portfolio_item_related_items_in_view' );
		} else {
			$gp_items_in_view = '';
		}

		wp_enqueue_script( 'ghostpool-custom-js', get_template_directory_uri() . '/lib/scripts/custom.js', array( 'jquery' ), '', true );

		wp_localize_script( 'ghostpool-custom-js', 'ghostpool_script', array(
			'lightbox' => ghostpool_option( 'lightbox' ),
			'related_items_in_view' => $gp_items_in_view
		) );

		// Add custom JavaScript code
		if ( ghostpool_option( 'js_code' ) ) {
			$gp_js_code = str_replace( array( '<script>', '</script>' ), '', ghostpool_option( 'js_code' ) );
			 wp_add_inline_script( 'ghostpool-custom-js', $gp_js_code );
		}

	}
}
add_action( 'wp_enqueue_scripts', 'ghostpool_scripts' );

/**
 * Enqueues admin scripts and styles.
 *
 */
if ( ! function_exists( 'ghostpool_enqueue_admin_styles' ) ) {
	function ghostpool_admin_scripts() {

		wp_enqueue_style( 'ghostpool-admin ', get_template_directory_uri() . '/lib/css/admin.css' );

		wp_enqueue_script( 'ghostpool-admin', get_template_directory_uri() . '/lib/scripts/admin.js', '', '', true );

	}
}
add_action( 'admin_enqueue_scripts', 'ghostpool_admin_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 */
if ( !function_exists( 'ghostpool_body_classes' ) ) {
	function ghostpool_body_classes( $gp_classes ) {
		global $post;
		$gp_classes[] = 'gp-theme';
		$gp_classes[] = 'gp-responsive';
		$gp_classes[] = ghostpool_option( 'theme_layout' );
		$gp_classes[] = ghostpool_option( 'retina', '', 'gp-retina' );
		$gp_classes[] = ghostpool_option( 'smooth_scrolling' );
		$gp_classes[] = ghostpool_option( 'back_to_top' );
		$gp_classes[] = ghostpool_option( 'fixed_header' );
		$gp_classes[] = ghostpool_option( 'header_layout' );
		$gp_classes[] = ghostpool_option( 'cart_button' );
		$gp_classes[] = ghostpool_option( 'search_button' );
		$gp_classes[] = ghostpool_option( 'profile_button' );
		$gp_classes[] = ghostpool_option( 'small_header' );
		$gp_classes[] = $GLOBALS['ghostpool_page_header'];
		$gp_classes[] = $GLOBALS['ghostpool_layout'];
		if ( is_page_template( 'homepage-template.php' ) ) {
			$gp_classes[] = 'gp-homepage';
		}
		if ( defined( 'TSS_VERSION' ) ) {
			$gp_classes[] = 'gp-sticky-sidebars';
		}
		return $gp_classes;
	}
}
add_filter( 'body_class', 'ghostpool_body_classes' );

/**
 * Content added to header
 *
 */
if ( ! function_exists( 'ghostpool_wp_header' ) ) {

	function ghostpool_wp_header() {

		// Title fallback for versions earlier than WordPress 4.1
		if ( ! function_exists( '_wp_render_title_tag' ) && ! function_exists( 'ghostpool_render_title' ) ) {
			function ghostpool_render_title() { ?>
				<title><?php wp_title( '|', true, 'right' ); ?></title>
			<?php }
		}

		// Initial variables - variables loaded only once at the top of the page
		ghostpool_init_variables();

	}
}
add_action( 'wp_head', 'ghostpool_wp_header' );

/**
 * Navigation user meta
 *
 */
if ( ! function_exists( 'ghostpool_nav_user_meta' ) ) {
	function ghostpool_nav_user_meta( $gp_user_id = NULL ) {

		// These are the metakeys we will need to update
		$GLOBALS['ghostpool_meta_key']['menus'] = 'metaboxhidden_nav-menus';
		$GLOBALS['ghostpool_meta_key']['properties'] = 'managenav-menuscolumnshidden';

		// So this can be used without hooking into user_register
		if ( ! $gp_user_id ) {
			$gp_user_id = get_current_user_id();
		}

		// Set the default hiddens if it has not been set yet
		if ( ! get_user_meta( $gp_user_id, $GLOBALS['ghostpool_meta_key']['menus'], true ) ) {
			$gp_meta_value = array( 'add-gp_slides', 'add-gp_slide' );
			update_user_meta( $gp_user_id, $GLOBALS['ghostpool_meta_key']['menus'], $gp_meta_value );
		}

		// Set the default properties if it has not been set yet
		if ( ! get_user_meta( $gp_user_id, $GLOBALS['ghostpool_meta_key']['properties'], true) ) {
			$gp_meta_value = array( 'link-target', 'xfn', 'description' );
			update_user_meta( $gp_user_id, $GLOBALS['ghostpool_meta_key']['properties'], $gp_meta_value );
		}

	}
}
add_action( 'admin_init', 'ghostpool_nav_user_meta' );

/**
 * Insert schema meta data
 *
 */
if ( ! function_exists( 'ghostpool_meta_data' ) ) {
	function ghostpool_meta_data( $gp_post_id ) {

		global $post;

		$gp_global = get_option( 'socialize' );

		// Get title
		if ( ! empty( $GLOBALS['ghostpool_custom_title'] ) ) {
			$gp_title = esc_attr( $GLOBALS['ghostpool_custom_title'] );
		} else {
			$gp_title = get_the_title( $gp_post_id );
		}

		// Meta data
		return '<meta itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" content="' . esc_url( get_permalink( $gp_post_id ) ) . '">
		<meta itemprop="headline" content="' . esc_attr( $gp_title ) . '">
		<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
			<meta itemprop="url" content="' . esc_url( wp_get_attachment_url( get_post_thumbnail_id( $gp_post_id ) ) ) . '">
			<meta itemprop="width" content="' .  absint( $GLOBALS['ghostpool_image_width'] ) . '">
			<meta itemprop="height" content="' . absint( $GLOBALS['ghostpool_image_height'] ) . '">
		</div>
		<meta itemprop="author" content="' . get_the_author_meta( 'display_name', $post->post_author ) . '">
		<meta itemprop="datePublished" content="' . get_the_time( 'Y-m-d' ) . '">
		<meta itemprop="dateModified" content="' . get_the_modified_date( 'Y-m-d' ) . '">
		<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
			<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
				<meta itemprop="url" content="' . esc_url( ghostpool_option( 'desktop_logo', 'url' ) ) . '">
				<meta itemprop="width" content="' . absint( ghostpool_option( 'desktop_logo_dimensions', 'width' ) ) . '">
				<meta itemprop="height" content="' . absint( ghostpool_option( 'desktop_logo_dimensions', 'height' ) ) . '">
			</div>
			<meta itemprop="name" content="' . get_bloginfo( 'name' ) . '">
		</div>';

	}
}

/**
 * Insert breadcrumbs
 *
 */
if ( ! function_exists( 'ghostpool_breadcrumbs' ) ) {
	function ghostpool_breadcrumbs() {

		if ( function_exists( 'yoast_breadcrumb' ) && ! is_front_page() ) {
			$gp_breadcrumbs = yoast_breadcrumb( '<div id="gp-breadcrumbs">', '</div>' );
		} else {
			$gp_breadcrumbs = '';
		}

	}
}

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 */

// Categories Widget
require_once( get_template_directory() . '/lib/widgets/categories.php' );

// Recent Comments Widget
require_once( get_template_directory() . '/lib/widgets/recent-comments.php' );

// Recent Posts Widget
require_once( get_template_directory() . '/lib/widgets/recent-posts.php' );

if ( ! function_exists( 'ghostpool_widgets_init' ) ) {
	function ghostpool_widgets_init() {

		// Sidebars
		register_sidebar( array(
			'name'          => esc_html__( 'Left Sidebar', 'socialize' ),
			'id'            => 'gp-left-sidebar',
			'description'   => esc_html__( 'Displayed on posts, pages and post categories.', 'socialize' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Right Sidebar', 'socialize' ),
			'id'            => 'gp-right-sidebar',
			'description'   => esc_html__( 'Displayed on posts, pages and post categories.', 'socialize' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Homepage Left Sidebar', 'socialize' ),
			'id'            => 'gp-homepage-left-sidebar',
			'description'   => esc_html__( 'Displayed on the homepage.', 'socialize' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Homepage Right Sidebar', 'socialize' ),
			'id'            => 'gp-homepage-right-sidebar',
			'description'   => esc_html__( 'Displayed on the homepage.', 'socialize' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 1', 'socialize' ),
			'id'            => 'gp-footer-1',
			'description'   => esc_html__( 'Displayed as the first column in the footer.', 'socialize' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 2', 'socialize' ),
			'id'            => 'gp-footer-2',
			'description'   => esc_html__( 'Displayed as the second column in the footer.', 'socialize' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 3', 'socialize' ),
			'id'            => 'gp-footer-3',
			'description'   => esc_html__( 'Displayed as the third column in the footer.', 'socialize' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 4', 'socialize' ),
			'id'            => 'gp-footer-4',
			'description'   => esc_html__( 'Displayed as the fourth column in the footer.', 'socialize' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 5', 'socialize' ),
			'id'            => 'gp-footer-5',
			'description'   => esc_html__( 'Displayed as the fifth column in the footer.', 'socialize' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

		// Deprecated since v1.1
		register_sidebar( array(
			'name'          => esc_html__( 'Standard Sidebar (Deprecated)', 'socialize' ),
			'id'            => 'gp-standard-sidebar',
			'description'   => esc_html__( 'Displayed on posts, pages and post categories.', 'socialize' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		) );

	}
}
add_action( 'widgets_init', 'ghostpool_widgets_init' );

/**
 * Change excerpt character length
 *
 */
if ( ! function_exists( 'ghostpool_excerpt_length' ) ) {
	function ghostpool_excerpt_length() {
		if ( function_exists( 'buddyboss_global_search_init' ) && is_search() ) {
			return 50;
		} else {
			return 10000;
		}
	}
}
add_filter( 'excerpt_length', 'ghostpool_excerpt_length' );

/**
 * Custom excerpt format
 *
 */
if ( ! function_exists( 'ghostpool_excerpt' ) ) {
	function ghostpool_excerpt( $gp_length ) {
		if ( isset( $GLOBALS['ghostpool_read_more_link'] ) && $GLOBALS['ghostpool_read_more_link'] == 'enabled' ) {
			$gp_more_text = '...<a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" class="gp-read-more" title="' . the_title_attribute( 'echo=0' ) . '">' . esc_html__( 'Read More', 'socialize' ) . '</a>';
		} else {
			$gp_more_text = '...';
		}

		if ( get_post_meta( get_the_ID(), 'video_description', true ) ) {
			$gp_excerpt = get_post_meta( get_the_ID(), 'video_description', true );
		} else {
			$gp_excerpt = get_the_excerpt();
		}

		$gp_excerpt = strip_tags( $gp_excerpt );
		if ( function_exists( 'mb_strlen' ) && function_exists( 'mb_substr' ) ) {
			if ( mb_strlen( $gp_excerpt ) > $gp_length ) {
				$gp_excerpt = mb_substr( $gp_excerpt, 0, $gp_length ) . $gp_more_text;
			}
		} else {
			if ( strlen( $gp_excerpt ) > $gp_length ) {
				$gp_excerpt = substr( $gp_excerpt, 0, $gp_length ) . $gp_more_text;
			}
		}
		return $gp_excerpt;
	}
}

/**
 * Prefix portfolio categories
 *
 */
if ( ! function_exists( 'ghostpool_add_prefix_to_terms' ) ) {
	function ghostpool_add_prefix_to_terms( $gp_term_id, $gp_tt_id, $gp_taxonomy ) {
		if ( $gp_taxonomy == 'gp_portfolios' && ghostpool_option( 'portfolio_cat_prefix_slug' ) ) {
			$gp_term = get_term( $gp_term_id, $gp_taxonomy );
			$gp_args = array( 'slug' => ghostpool_option( 'portfolio_cat_prefix_slug' ) . '-' . $gp_term->slug );
			wp_update_term( $gp_term_id, $gp_taxonomy, $gp_args );
		}
	}
}
add_action( 'created_term', 'ghostpool_add_prefix_to_terms', 10, 3 );

/**
 * Change password protect text
 *
 */
if ( ! function_exists( 'ghostpool_password_form' ) ) {
	function ghostpool_password_form() {
		global $post;
		$gp_label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
		$gp_o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
		<p>' . esc_html__( 'To view this protected post, enter the password below:', 'socialize' ) . '</p>
		<label for="' . $gp_label . '"><input name="post_password" id="' . $gp_label . '" type="password" size="20" maxlength="20" /></label> <input type="submit" class="pwsubmit" name="Submit" value="' .  esc_attr__( 'Submit', 'socialize' ) . '" />
		</form>
		';
		return $gp_o;
	}
}
add_filter( 'the_password_form', 'ghostpool_password_form' );

/**
 * Redirect empty search to search page
 *
 */
if ( ! function_exists( 'ghostpool_empty_search' ) ) {
	function ghostpool_empty_search( $gp_query ) {
		global $wp_query;
		if ( isset( $_GET['s'] ) && ( $_GET['s'] == '' ) ) {
			$wp_query->set( 's', ' ' );
			$wp_query->is_search = true;
		}
		return $gp_query;
	}
}
add_action( 'pre_get_posts', 'ghostpool_empty_search' );

/**
 * Alter category queries
 *
 */
if ( ! function_exists( 'ghostpool_category_queries' ) ) {
	function ghostpool_category_queries( $gp_query ) {
		if ( is_admin() OR ! $gp_query->is_main_query() ) {
			return;
		} else {
			if ( is_post_type_archive( 'gp_portfolio_item' ) OR is_tax( 'gp_portfolios' ) )  {
				$GLOBALS['ghostpool_orderby'] = ghostpool_option( 'portfolio_cat_orderby' );
				$GLOBALS['ghostpool_per_page'] = ghostpool_option( 'portfolio_cat_per_page' );
				$GLOBALS['ghostpool_date_posted'] = ghostpool_option( 'portfolio_cat_date_posted' );
				$GLOBALS['ghostpool_date_modified'] = ghostpool_option( 'portfolio_cat_date_modified' );
			} elseif ( is_author() ) {
				$GLOBALS['ghostpool_orderby'] = ghostpool_option( 'search_orderby' );
				$GLOBALS['ghostpool_per_page'] = ghostpool_option( 'search_per_page' );
				$GLOBALS['ghostpool_date_posted'] = ghostpool_option( 'search_date_posted' );
				$GLOBALS['ghostpool_date_modified'] = ghostpool_option( 'search_date_modified' );
			} elseif ( is_search() OR is_author() ) {
				$GLOBALS['ghostpool_orderby'] = ghostpool_option( 'search_orderby' );
				$GLOBALS['ghostpool_per_page'] = ghostpool_option( 'search_per_page' );
				$GLOBALS['ghostpool_date_posted'] = ghostpool_option( 'search_date_posted' );
				$GLOBALS['ghostpool_date_modified'] = ghostpool_option( 'search_date_modified' );
			} elseif ( is_home() OR is_archive() ) {
				$GLOBALS['ghostpool_orderby'] = ghostpool_option( 'cat_orderby' );
				$GLOBALS['ghostpool_per_page'] = ghostpool_option( 'cat_per_page' );
				$GLOBALS['ghostpool_date_posted'] = ghostpool_option( 'cat_date_posted' );
				$GLOBALS['ghostpool_date_modified'] = ghostpool_option( 'cat_date_modified' );
			}
			if ( isset( $GLOBALS['ghostpool_per_page'] ) ) {
				ghostpool_loop_variables();
				ghostpool_category_variables();
				$gp_query->set( 'posts_per_page', $GLOBALS['ghostpool_per_page'] );
				if ( ! is_search() ) {
					$gp_query->set( 'orderby', $GLOBALS['ghostpool_orderby_value'] );
					$gp_query->set( 'order', $GLOBALS['ghostpool_order'] );
					$gp_query->set( 'meta_key', $GLOBALS['ghostpool_meta_key'] );
				}
				$gp_query->set( 'date_query', array( $GLOBALS['ghostpool_date_posted_value'], $GLOBALS['ghostpool_date_modified_value'] ) );
				return;
			}
		}
	}
}
add_action( 'pre_get_posts', 'ghostpool_category_queries', 1 );

/**
 * Pagination
 *
 */
if ( ! function_exists( 'ghostpool_pagination' ) ) {
	function ghostpool_pagination( $gp_query ) {
		$gp_big = 999999999;
		if ( get_query_var( 'paged' ) ) {
			$gp_paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$gp_paged = get_query_var( 'page' );
		} else {
			$gp_paged = 1;
		}
		if ( $gp_query >  1 ) {
			return '<div class="gp-pagination gp-pagination-numbers gp-standard-pagination">' . paginate_links( array(
				'base'      => str_replace( $gp_big, '%#%', esc_url( get_pagenum_link( $gp_big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, $gp_paged ),
				'total'     => $gp_query,
				'type'      => 'list',
				'prev_text' => '',
				'next_text' => '',
				'end_size'  => 1,
				'mid_size'  => 1,
			) ) . '</div>';
		}
	}
}

if ( ! function_exists( 'ghostpool_get_previous_posts_page_link' ) ) {
	function ghostpool_get_previous_posts_page_link() {
		global $paged;
		$gp_nextpage = intval( $paged ) - 1;
		if ( $gp_nextpage < 1 ) {
			$gp_nextpage = 1;
		}
		if ( $paged > 1 ) {
			return '<a href="#" data-pagelink="' . esc_attr( $gp_nextpage ) . '" class="prev"></a>';
		} else {
			return '<span class="prev gp-disabled"></span>';
		}
	}
}

if ( ! function_exists( 'ghostpool_get_next_posts_page_link' ) ) {
	function ghostpool_get_next_posts_page_link( $gp_max_page = 0 ) {
		global $paged;
		if ( ! $paged ) {
			$paged = 1;
		}
		$gp_nextpage = intval( $paged ) + 1;
		if ( ! $gp_max_page || $gp_max_page >= $gp_nextpage ) {
			return '<a href="#" data-pagelink="' . esc_attr( $gp_nextpage ) . '" class="next"></a>';
		} else {
			return '<span class="next gp-disabled"></span>';
		}
	}
}

/**
 * Canonical, next and prev rel links on page templates
 *
 */
if ( ! function_exists( 'ghostpool_rel_prev_next' ) && function_exists( 'wpseo_auto_load' ) ) {
	function ghostpool_rel_prev_next() {
		if ( is_page_template( 'blog-template.php' ) OR is_page_template( 'portfolio-template.php' ) ) {

			global $paged;

			// Load page variables
			ghostpool_loop_variables();
			ghostpool_category_variables();

			if ( is_page_template( 'blog-template.php' ) ) {

				$gp_args = array(
					'post_status' 	      => 'publish',
					'post_type'           => explode( ',', $GLOBALS['ghostpool_post_types'] ),
					'tax_query'           => $GLOBALS['ghostpool_tax'],
					'orderby'             => $GLOBALS['ghostpool_orderby_value'],
					'order'               => $GLOBALS['ghostpool_order'],
					'meta_key'            => $GLOBALS['ghostpool_meta_key'],
					'posts_per_page'      => $GLOBALS['ghostpool_per_page'],
					'paged'               => $GLOBALS['ghostpool_paged'],
					'date_query'          => array( $GLOBALS['ghostpool_date_posted_value'], $GLOBALS['ghostpool_date_modified_value'] ),
				);

			} else {

				$gp_args = array(
					'post_status'         => 'publish',
					'post_type'           => 'gp_portfolio_item',
					'tax_query'           => $GLOBALS['ghostpool_tax'],
					'posts_per_page'      => $GLOBALS['ghostpool_per_page'],
					'orderby'             => $GLOBALS['ghostpool_orderby_value'],
					'order'               => $GLOBALS['ghostpool_order'],
					'paged'               => $GLOBALS['ghostpool_paged'],
					'date_query'          => array( $GLOBALS['ghostpool_date_posted_value'], $GLOBALS['ghostpool_date_modified_value'] ),
				);

			}

			// Contains query data
			$gp_query = new wp_query( $gp_args );

			// Get maximum pages from query
			$gp_max_page = $gp_query->max_num_pages;

			if ( ! $paged ) {
				$paged = 1;
			}

			// Prev rel link
			$gp_prevpage = intval( $paged ) - 1;
			if ( $gp_prevpage < 1 ) {
				$gp_prevpage = 1;
			}
			if ( $paged > 1 ) {
				echo '<link rel="prev" href="' . get_pagenum_link( $gp_prevpage ) . '">';
			}

			// Next rel link
			$gp_nextpage = intval( $paged ) + 1;
			if ( ! $gp_max_page OR $gp_max_page >= $gp_nextpage ) {
				echo '<link rel="next" href="' . get_pagenum_link( $gp_nextpage ) . '">';
			}

			// Meta noindex,follow on paginated page templates
			if ( ( is_page_template( 'blog-template.php' ) OR is_page_template( 'portfolio-template.php' ) ) && $paged > 1 ) {
				echo '<meta name="robots" content="noindex,follow">';
			}

		}
	}
	add_action( 'wp_head', 'ghostpool_rel_prev_next' );
}

if ( ! function_exists( 'ghostpool_canonical_link' ) && function_exists( 'wpseo_auto_load' ) ) {
	function ghostpool_canonical_link( $gp_canonical ) {
		if ( is_page_template( 'blog-template.php' ) OR is_page_template( 'portfolio-template.php' ) ) {
			global $paged;
			if ( ! $paged ) {
				$paged = 1;
			}
			return get_pagenum_link( $paged );
		} else {
			return $gp_canonical;
		}
	}
	add_filter( 'wpseo_canonical', 'ghostpool_canonical_link' );
}

/**
 * Exclude categories
 *
 */
if ( ! function_exists( 'ghostpool_exclude_cats' ) ) {
	function ghostpool_exclude_cats( $gp_post_id, $gp_no_link = false, $gp_loop ) {

		// Get categories for post
		$gp_cats = wp_get_object_terms( $gp_post_id, 'category', array( 'fields' => 'ids' ) );

		// Remove categories that are excluded
		if ( ghostpool_option( 'cat_exclude_cats' ) ) {
			$gp_excluded_cats = array_diff( $gp_cats, ghostpool_option( 'cat_exclude_cats' ) );
		} else {
			$gp_excluded_cats = $gp_cats;
		}

		// Construct new categories loop
		if ( ! empty( $gp_excluded_cats ) && ! is_wp_error( $gp_excluded_cats ) ) {
			$gp_cat_link = '';
			foreach( $gp_excluded_cats as $gp_excluded_cat ) {
				if ( has_term( $gp_excluded_cat, 'category', $gp_post_id ) ) {
					$gp_term = get_term( $gp_excluded_cat, 'category' );
					$gp_term_link = get_term_link( $gp_term, 'category' );
					if ( ! $gp_term_link OR is_wp_error( $gp_term_link ) ) {
						continue;
					}
					if ( $gp_no_link == true ) {
						$gp_cat_link .= esc_attr( $gp_term->name ) . ' / ';
					} else {
						$gp_cat_link .= '<a href="' . esc_url( $gp_term_link ) . '">' . esc_attr( $gp_term->name ) . '</a> / ';
					}
				}
			}
			if ( $gp_loop == true ) {
				return '<div class="gp-loop-cats">' . rtrim( $gp_cat_link, ' / ' ) . '</div>';
			} else {
				return '<div class="gp-entry-cats">' . rtrim( $gp_cat_link, ' / ' ) . '</div>';
			}
		}

	}
}

/**
 * Redirect wp-login.php to login form
 *
 */
if ( ! function_exists( 'ghostpool_login_redirect' ) ) {
	function ghostpool_login_redirect() {
		global $pagenow;
		if ( 'wp-login.php' == $pagenow && ghostpool_option( 'popup_box' ) == 'enabled' ) {

			if ( isset( $_GET['action'] ) && $_GET['action'] == 'register' ) {
				wp_redirect( esc_url( home_url( '#register/' ) ) ); // Open registration modal window
			} elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'lostpassword' ) {
				wp_redirect( esc_url( home_url( '#lost-password/' ) ) ); // Open lost password modal window
			} elseif ( isset( $_GET['action'] ) && $_GET['action'] == 'bpnoaccess' ) {
 				wp_redirect( esc_url( home_url( '#login/' ) ) ); // If there are specific actions open login modal window
			} elseif ( ! isset( $_POST['wp-submit'] ) && ! isset( $_GET['checkemail'] ) && ! isset( $_GET['action'] ) && ! isset( $_GET['reauth'] ) && ! isset( $_GET['interim-login'] ) ) {
				wp_redirect( esc_url( home_url( '#login/' ) ) ); // If there are no actions open login modal window
			} else {
				return;
			}

			exit();
		}
	}
}
add_action( 'init', 'ghostpool_login_redirect' );

/**
 * Add reset password success message to home page
 *
 */
if ( isset( $_GET['action'] ) && $_GET['action'] == 'reset_success' ) {
	if ( ! function_exists( 'ghostpool_reset_password_success' ) ) {
		function ghostpool_reset_password_success() {
			echo '<div id="gp-reset-message"><p>' . esc_html__( "You will receive an email with your new password.", "socialize" ) . '<span id="gp-close-reset-message"></span></p></div>';
		}
	}
	add_action( 'wp_footer', 'ghostpool_reset_password_success' );
}

/**
 * Update plugin before showing theme
 *
 */
if ( ! function_exists( 'ghostpool_socialize_plugin_update' ) ) {
	function ghostpool_install_plugin_header() {
		echo '<style>#gp-site-wrapper{display:none !important;}</style>';
	}
	add_action( 'wp_head', 'ghostpool_install_plugin_header' );
	function ghostpool_install_plugin_footer() {
		echo '<div class="gp-install-plugin-notice">' . esc_html__( 'Before you can see the theme please install the latest version of the Socialize Plugin by', 'socialize' ) . ' <a href="' . admin_url( '/themes.php?page=tgmpa-install-plugins' ) . '">' . esc_html__( 'clicking here', 'socialize' ) . '</a>.</div>';
	}
	add_action( 'wp_footer', 'ghostpool_install_plugin_footer' );
}

/**
 * Remove hentry tag from post loop
 *
 */
if ( ! function_exists( 'ghostpool_remove_hentry' ) ) {
	function ghostpool_remove_hentry( $gp_classes ) {
		$gp_classes = array_diff( $gp_classes, array( 'hentry' ) );
		return $gp_classes;
	}
}
add_filter( 'post_class', 'ghostpool_remove_hentry' );

/**
 * Add lightbox class to image links
 *
 */
if ( ! function_exists( 'ghostpool_lightbox_image_link' ) ) {
	function ghostpool_lightbox_image_link( $gp_content ) {
		global $post;
		if ( ghostpool_option( 'lightbox' ) != 'disabled' ) {
			if ( ghostpool_option( 'lightbox' ) == 'group_images' ) {
				$gp_group = '[image-' . $post->ID . ']';
			} else {
				$gp_group = '';
			}
			$gp_pattern = "/<a(.*?)href=('|\")(.*?).(jpg|jpeg|png|gif|bmp|ico)('|\")(.*?)>/i";
			preg_match_all( $gp_pattern, $gp_content, $gp_matches, PREG_SET_ORDER );
			foreach ( $gp_matches as $gp_val ) {
				$gp_pattern = '<a' . $gp_val[1] . 'href=' . $gp_val[2] . $gp_val[3] . '.' . $gp_val[4] . $gp_val[5] . $gp_val[6] . '>';
				$gp_replacement = '<a' . $gp_val[1] . 'href=' . $gp_val[2] . $gp_val[3] . '.' . $gp_val[4] . $gp_val[5] . ' data-rel="prettyPhoto' . $gp_group . '"' . $gp_val[6] . '>';
				$gp_content = str_replace( $gp_pattern, $gp_replacement, $gp_content );
			}
			return $gp_content;
		} else {
			return $gp_content;
		}
	}
}
add_filter( 'the_content', 'ghostpool_lightbox_image_link' );
add_filter( 'wp_get_attachment_link', 'ghostpool_lightbox_image_link' );
add_filter( 'bbp_get_reply_content', 'ghostpool_lightbox_image_link' );

/**
 * TGM Plugin Activation class
 *
 */
if ( version_compare( phpversion(), '5.2.4', '>=' ) ) {
	require_once( get_template_directory() . '/lib/inc/class-tgm-plugin-activation.php' );
}

if ( ! function_exists( 'ghostpool_register_required_plugins' ) ) {

	function ghostpool_register_required_plugins() {

		$gp_plugins = array(

			array(
				'name'               => esc_html__( 'Socialize Plugin', 'socialize' ),
				'slug'               => 'socialize-plugin',
				'source'             => get_template_directory() . '/lib/plugins/socialize-plugin.zip',
				'required'           => true,
				'version'            => '3.1.2',
				'force_activation'   => false,
				'force_deactivation' => false,
			),

			array(
				'name'               => esc_html__( 'WPBakery Visual Composer', 'socialize' ),
				'slug'               => 'js_composer',
				'source'             => get_template_directory() . '/lib/plugins/js_composer.zip',
				'required'           => true,
				'version'            => '5.0.1',
				'force_activation'	 => false,
				'force_deactivation' => false,
			),

			array(
				'name'               => esc_html__( 'Visual Sidebars Editor', 'socialize' ),
				'slug'               => 'visual-sidebars-editor',
				'source'             => get_template_directory() . '/lib/plugins/visual-sidebars-editor.zip',
				'required'           => true,
				'version'            => '1.1.1',
				'force_activation'	 => false,
				'force_deactivation' => false,
			),

			array(
				'name'   		     => esc_html__( 'Theia Sticky Sidebar', 'socialize' ),
				'slug'   		     => 'theia-sticky-sidebar',
				'source'   		     => get_template_directory() . '/lib/plugins/theia-sticky-sidebar.zip',
				'required'   		 => false,
				'version'   		 => '1.6.3',
				'force_activation'	 => false,
				'force_deactivation' => false,
			),

			array(
				'name'      => esc_html__( 'BuddyPress', 'socialize' ),
				'slug'      => 'buddypress',
				'required' 	=> false,
			),

			array(
				'name'      => esc_html__( 'bbPress', 'socialize' ),
				'slug'      => 'bbpress',
				'required' 	=> false,
			),

			array(
				'name'      => esc_html__( 'The Events Calendar', 'socialize' ),
				'slug'      => 'the-events-calendar	',
				'required' 	=> false,
			),

			array(
				'name'      => esc_html__( 'Contact Form 7', 'socialize' ),
				'slug'      => 'contact-form-7',
				'required' 	=> false,
			),

			array(
				'name'      => esc_html__( 'WordPress Social Login', 'socialize' ),
				'slug'      => 'wordpress-social-login',
				'required' 	=> false,
			),

			array(
				'name'      => esc_html__( 'Captcha', 'socialize' ),
				'slug'      => 'captcha',
				'required' 	=> false,
			),

			array(
				'name'      => esc_html__( 'Post Views Counters', 'socialize' ),
				'slug'      => 'post-views-counter',
				'required' 	=> false,
			),

			array(
				'name'      => esc_html__( 'Yoast SEO', 'socialize' ),
				'slug'      => 'wordpress-seo',
				'required' 	=> false,
				'is_callable' => 'wpseo_init',
			),

		);

		$gp_config = array(
			'id'           => 'socialize',            // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                     // Default absolute path to pre-packaged plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                   // Show admin notices or not.
			'dismissable'  => true,                   // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                     // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                  // Automatically activate plugins after installation or not.
			'message'      => '',                     // Message to output right before the plugins table.
		);

		tgmpa( $gp_plugins, $gp_config );

	}
}
add_action( 'tgmpa_register', 'ghostpool_register_required_plugins' );

/** Hans From here..
* Edit Howdy word
*/
function my_admin_bar_change_howdy_target( $wp_admin_bar ) {
        $user_id = get_current_user_id();
        $current_user = wp_get_current_user();
        $profile_url = get_edit_profile_url( $user_id );
        if (substr($profile_url, -5) == 'edit/') {
                $profile_url = substr($profile_url, 0, -5);
        }

        if ( 0 != $user_id ) {
                /* Add the "My Account" menu */
                $avatar = get_avatar( $user_id, 28 );
                $howdy = sprintf( __('Welcome, %1$s'), $current_user->display_name );
                $class = empty( $avatar ) ? '' : 'with-avatar';

                $wp_admin_bar->add_menu( array(
                        'id' => 'my-account',
                        'parent' => 'top-secondary',
                        'title' => $howdy . $avatar,
                        'href' => $profile_url,
                        'meta' => array(
                                'class' => $class,
                        ),
                ) );

        }
}
add_action( 'admin_bar_menu', 'my_admin_bar_change_howdy_target', 11 );

/** Hide toolbar for users not admin */

function hans_remove_admin_bar() {
	if( !is_super_admin() )
		add_filter( 'show_admin_bar', '__return_false' );
}
add_action('wp', 'hans_remove_admin_bar');
/** Redirect bbPress pages to registration page */
//function hans_page_template_redirect()
//{
    //if not logged in and on a bp page except registration or activation
  //  if( ! is_user_logged_in() && is_bbpress() ) {
  //      wp_redirect( home_url( '/register/' ) );
  //      exit();
  //  }
//}
//add_action( 'template_redirect', 'hans_page_template_redirect' );

/** Upload facebook avatar if the user has his/her facebook connected */

add_filter( 'bp_core_fetch_avatar', 'revert_to_default_wp_avatar', 80, 3 );//late load
function revert_to_default_wp_avatar( $img, $params, $item_id ){
	//we are concerned only with users
	if( $params['object']!='user' )
		return $img;

	//check if user has uploaded an avatar
	//if not then revert back to wordpress core get_avatar method
	//remove the filter first, or else it will go in infinite loop
	remove_filter( 'bp_core_fetch_avatar', 'revert_to_default_wp_avatar', 80, 3 );

	if( !emi_user_has_avatar( $item_id ) ){
		$width = $params['width'];
		// Set image width
		if ( false !== $width ) {
			$img_width = $width;
		} elseif ( 'thumb' == $width ) {
			$img_width = bp_core_avatar_thumb_width();
		} else {
			$img_width = bp_core_avatar_full_width();
		}
		$img = get_avatar( $item_id, $img_width );
	}

	//add the filter back again
	add_filter( 'bp_core_fetch_avatar', 'revert_to_default_wp_avatar', 80, 3 );
	return $img;
}

/**
* Check if the given user has an uploaded avatar
* @return boolean
*/
function emi_user_has_avatar( $user_id=false ) {
	if( !$user_id ){
		$user_id = bp_loggedin_user_id();
	}

	if ( bp_core_fetch_avatar( array( 'item_id' => $user_id, 'no_grav' => true,'html'=> false ) ) != bp_core_avatar_default( 'local' ) )
		return true;
	return false;
}

?>
