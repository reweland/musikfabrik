<?php

if (!defined('ABSPATH')) exit;

add_action('init', function () {
	register_post_type( 'mufa_gallery', [
		'labels'    => [
			'name'      => 'Galerien',
			'singular_name' => 'Galerie',
			'menu_name' => 'Galerien',
			'add_new_item' => 'Neue Galerie'
		],
		'public'    => false,
		'show_ui'   => true,
		'menu_position' => 34,
		'supports'  => [ 'title' ]
	]);
});

add_filter( 'manage_mufa_gallery_posts_columns', function ( $columns ) {
	$new_columns = [];

	foreach ( $columns as $id => $label ) {
		$new_columns[$id] = $label;

		if ( $id == 'title' ) {
			$new_columns['thumbnails'] = 'Bilder';
		}
	}

	return $new_columns;
}, 1000);

add_action( 'manage_mufa_gallery_posts_custom_column', function ( $column, $post_id ) {
	switch ( $column ) {
		case 'thumbnails':
			foreach ( get_field( 'images' ) as $image ) {
				echo wp_get_attachment_image( $image['ID'], [ 90, 90 ] ) . ' ';
			}
			break;
	}
}, 10, 2);
