<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'mce_buttons_2', function ( $buttons ) {
	array_unshift( $buttons, 'styleselect' );

	return $buttons;
} );

add_filter( 'tiny_mce_before_init', function ( $init_array ) {
	$style_formats               = array(
		[ 'selector' => 'p', 'classes' => 'lead', 'title' => 'Einleitungstext' ],
		[ 'selector' => 'p', 'classes' => 'twocol', 'title' => 'Zweispalter' ],
		[ 'selector' => 'a', 'classes' => 'btn-cta', 'title' => 'CTA-Button' ],
		[ 'selector' => 'a', 'classes' => 'home-link', 'title' => 'Home-Link' ],
		[ 'selector' => 'img', 'classes' => 'borderless-img', 'title' => 'randlos' ]
	);
	$init_array['style_formats'] = json_encode( $style_formats );

	return $init_array;
} );

add_action( 'admin_init', function () {
	add_editor_style( 'dist/css/rte.css' );
} );
