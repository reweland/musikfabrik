<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'template_redirect', function () {
	switch ( get_field( 'forward_mode' ) ) {
		case 'page':
			if ( $pid = get_field( 'forward_target_page' ) ) {
				wp_redirect( $pid, 301 );
				exit();
			}
			break;

		case 'first_child':
			$children = get_pages( array(
				'parent'       => get_the_ID(),
				'hierarchical' => false,
				'sort_column'  => 'menu_order',
				'number'       => 1
			) );

			if ( is_array( $children ) && count( $children ) ) {
				wp_redirect( get_permalink( $children[0] ), 301 );
				exit();
			}
			break;

		case 'url':
			if ( $url = get_field( 'forward_target_url' ) ) {
				wp_redirect( $url, 301 );
				exit();
			}
			break;
	}
} );