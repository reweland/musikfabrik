<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

foreach ( glob( get_template_directory() . '/inc/classes/*.php' ) as $filename ) {
	require $filename;
}

foreach ( glob( get_template_directory() . '/inc/cpt/*.php' ) as $filename ) {
	require $filename;
}

foreach ( glob( get_template_directory() . '/inc/acf/*.php' ) as $filename ) {
	require $filename;
}

foreach ( glob( get_template_directory() . '/inc/shortcodes/*.php' ) as $filename ) {
	$path     = explode( '/', $filename );
	$filename = array_pop( $path );
	$basename = substr( $filename, 0, strlen( $filename ) - 4 );

	add_shortcode( $basename, function ( $atts, $content, $shortcode ) {
		ob_start();
		include get_template_directory() . '/inc/shortcodes/' . $shortcode . '.php';

		return ob_get_clean();
	} );
}

require 'inc/scripts/forward.php';
require 'inc/scripts/frontend.php';
require 'inc/scripts/backend.php';
require 'inc/scripts/content_elements.php';
require 'inc/scripts/rte.php';

add_action( 'after_setup_theme', function () {
	add_theme_support( 'html5', [ 'gallery', 'caption' ] );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus( [
		'meta_nav'    => 'Metanavigation',
		'main_nav'    => 'Hauptnavigation',
		'footer_nav'  => 'Footernavigation'
	] );
} );

add_action( 'wp_enqueue_scripts', function () {
	// head
	wp_enqueue_style( 'app', get_template_directory_uri() . '/dist/css/app.css' );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/dist/js/modernizr.min.js' );

	// footer
	if ( true ) {
		wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/src/js/vendor/jquery.easing.1.3.min.js', [ 'jquery-core' ], false, true );
		wp_enqueue_script( 'swiper', get_template_directory_uri() . '/src/js/vendor/swiper-bundle.min.js', [ 'jquery-core' ], false, true );
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/src/js/vendor/jquery.fancybox.min.js', [ 'jquery-core' ], false, true );
        wp_enqueue_script( 'vh-check', get_template_directory_uri() . '/src/js/vendor/vh-check.min.js', [ 'jquery-core' ], false, true );
		wp_enqueue_script( 'app', get_template_directory_uri() . '/src/js/app.js', [ 'jquery-core' ], false, true );
	} else {
		wp_enqueue_script( 'app-min', get_template_directory_uri() . '/dist/js/app.min.js', [ 'jquery-core' ], false, true );
	}
} );

add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'event-type';
	$vars[] = 'event-year';

	$vars[] = 'post-cat';
	$vars[] = 'post-tag';
	$vars[] = 'post-year';

	return $vars;
} );

add_action( 'template_redirect', function () {
	if ( is_singular( 'mufa_event' ) && isset( $_GET['ical'] ) ) {
		$event_id = get_queried_object_id();
		$event = get_post( $event_id );
		$index = intval( $_GET['ical'] );
		$dates = get_field( 'dates', $event_id, false );

		if ( isset( $dates[ $index ] ) ) {
			\Beck\Mufa\Event::render_ical_download( $event, $dates[ $index ][ 'field_event_date_date_time' ] );
		}
	}
} );

add_filter( 'big_image_size_threshold', '__return_false' );

add_filter( 'body_class', function ( $classes ) {
	$classes[] = basename( get_page_template(), '.php' );

	if ( is_home() || is_archive() || is_singular( [ 'post', 'mufa_event', 'mufa_digital_issue', 'mufa_cd', 'mufa_work' ] ) ) {
		$classes[] = 'bgr-black';
	}

	return $classes;
} );

add_filter( 'nav_menu_css_class', function ( $classes, $item ) {
	if (
		( is_post_type_archive() || is_tax() || is_singular( [ 'mufa_event', 'mufa_digital_issue', 'mufa_cd', 'mufa_work' ] ) ) &&
		in_array( 'blog', $classes )
	) {
		$classes = array_diff( $classes, [ 'current-page-parent', 'current_page_parent' ] );
	}

	if ( is_post_type_archive( 'mufa_cd' ) || is_tax( 'mufa_cd_edition' ) || is_tax( 'mufa_cd_composer' ) || is_singular( 'mufa_cd' ) ) {
		if ( in_array( 'sound-image', $classes ) ) {
			$classes[] = 'current_page_parent';
		} else if ( in_array( 'cds', $classes ) ) {
			$classes[] = 'current-menu-item';
		};
	} else if ( is_post_type_archive( 'mufa_work' ) || is_tax( 'mufa_work_composer' ) || is_tax( 'mufa_work_artist' ) || is_singular( 'mufa_work' ) ) {
		if ( in_array( 'works', $classes ) ) {
			$classes[] = 'current-menu-item';
		}
	} else if ( is_singular( 'mufa_event' ) ) {
		if ( in_array( 'events', $classes ) ) {
			$classes[] = 'current-menu-item';
		}
	} else if ( is_singular( 'mufa_digital_issue' ) ) {
		if ( in_array( 'digital_issues', $classes ) ) {
			$classes[] = 'current-menu-item';
		}
	}

	return $classes;
}, 10, 2 );

// password protected area code

// redirect to login page if requested page is a descendant of it
add_action( 'template_redirect', function () {
	if ( ! is_user_logged_in() && is_singular( [ 'page' ] ) ) {
		$login_page_id = apply_filters( 'wpml_object_id', get_page_by_title( 'Login' )->ID, 'page' );

		$requested_page = get_post();
		$requested_page_ancestors = get_post_ancestors( $requested_page );

		if ( in_array( $login_page_id, $requested_page_ancestors ) ) {
			// requested page is a descendant of the login page and no user is logged in, so redirect to login page
			nocache_headers();
			wp_redirect( get_permalink( $login_page_id ), 302, 'template_redirect' );
			exit;
		}
	}
} );

// deny dashboard access for subscribers
add_action( 'init', function () {
	if ( is_admin() && ! wp_doing_ajax() && current_user_can( 'subscriber' ) ) {
		nocache_headers();
		wp_redirect( home_url(), 302, 'init' );
		exit;
	}
} );

// redirect logged in subscribers to first child of login page
add_filter( 'login_redirect', function ( $redirect_to, $requested_redirect_to, $user ) {
	if ( is_a( $user, 'WP_User' ) && in_array( 'subscriber', $user->roles ) ) {
		$redirect_to = get_permalink( nb_get_default_protected_page() );
	}

	return $redirect_to;
}, 10, 3 );

// handle login and lost password requests
// see shortcodes/login-form.php and shortcodes/lost-password-form.php
add_action( 'init', function () {
	if ( isset( $_POST['fe_login'] ) ) {
		$user = wp_signon();

		if ( ! is_wp_error( $user ) ) {
			nb_redirect_to_protected_page( 'init2' );
		}
	} else if ( isset( $_POST['lostpassword'] ) ) {
		retrieve_password();
	}
} );

// redirect to first child of login page
function nb_redirect_to_protected_page ( $redirected_by = '' ) {
	$target_page = nb_get_default_protected_page();

	if ( $target_page ) {
		nocache_headers();
		wp_redirect( get_permalink( $target_page ), 302, $redirected_by );
		exit;
	}
}

function nb_get_default_protected_page() {
	$login_page_id = apply_filters( 'wpml_object_id', get_page_by_title( 'Login' )->ID, 'page' );
	$subpages = get_pages( [
		'child_of' => $login_page_id,
		'order'    => 'menu_order'
	] );

	if ( count( $subpages ) ) {
		return $subpages[0];
	}

	return false;
}

// replace login item url with protected page url if user is logged in
add_filter( 'wp_nav_menu_objects', function ( $items, $args ) {
	if ( is_user_logged_in() && $args->theme_location === 'footer_nav' ) {
		$items = array_map( function ( $item ) {
			if ( $item->title === 'Login' ) {
				$item->url = get_permalink( nb_get_default_protected_page() );
			}
			return $item;
		}, $items);
	}
	return $items;
}, 10, 2 );