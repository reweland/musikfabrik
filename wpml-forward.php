<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require dirname( __FILE__ ) . '/../../../wp-load.php';

global $sitepress;
$default_lang = $sitepress->get_default_language();
$active_langs = $sitepress->get_active_languages();
$base_url     = preg_replace( '=/[^/]+$=', '', rtrim( get_home_url(), '/' ) ) . '/';

// if language cookie already set
if ( array_key_exists( $_COOKIE['_icl_current_language'], $active_langs ) ) {
	wp_redirect( $base_url . $_COOKIE['_icl_current_language'] . '/' );
} else {
	// ask user for desired language
	if ( isset( $_SERVER['HTTP_ACCEPT_LANGUAGE'] ) ) {
		$desired_lang = substr( $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2 );
	}

	// if preferred language available
	if ( array_key_exists( $desired_lang, $active_langs ) ) {
		wp_redirect( $base_url . $desired_lang . '/', 301 );
	} // load default language
	else {
		wp_redirect( $base_url . $active_langs[ $default_lang ]['url'] . '/', 301 );
	}

	exit();
}