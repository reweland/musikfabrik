<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', function () {
	remove_menu_page( 'edit-comments.php' );
} );

add_filter( 'show_admin_bar', '__return_false' );

// allow svg upload

add_filter( 'upload_mimes', function ( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
} );

add_filter( 'wp_check_filetype_and_ext', function ( $checked, $file, $filename, $mimes ) {
	if ( ! $checked['type'] ) {
		$wp_filetype     = wp_check_filetype( $filename, $mimes );
		$ext             = $wp_filetype['ext'];
		$type            = $wp_filetype['type'];
		$proper_filename = $filename;

		if ( $type && 0 === strpos( $type, 'image/' ) && $ext !== 'svg' ) {
			$ext = $type = false;
		}

		$checked = compact( 'ext', 'type', 'proper_filename' );
	}

	return $checked;
}, 10, 4 );


add_filter( 'image_downsize', function ( $out, $id ) {
	$image_url = wp_get_attachment_url( $id );
	$file_ext  = pathinfo( $image_url, PATHINFO_EXTENSION );

	if ( ! is_admin() || 'svg' !== $file_ext ) {
		return false;
	}

	return array( $image_url, null, null, false );
}, 10, 2 );