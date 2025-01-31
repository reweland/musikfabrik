<?php

if (!defined('ABSPATH')) exit;

add_action('init', function () {
	register_post_type( 'mufa_cd', [
		'labels'    => [
			'name'      => 'CDs',
			'singular_name' => 'CD',
			'menu_name' => 'CDs',
			'add_new_item' => 'Neue CD'
		],
		'public'    => true,
		'has_archive' => true,
		'show_ui'   => true,
		'menu_position' => 31,
		'supports'  => [ 'title', 'thumbnail', 'excerpt' ],
		'rewrite' => [
			'slug' => 'klang-bild/cds',
			'with_front' => false
		]
	]);

	register_taxonomy( 'mufa_cd_composer', 'mufa_cd', [
		'labels'    => [
			'name'      => 'Komponisten',
			'singular_name' => 'Komponist'
		],
		'hierarchical' => true,
		'query_var' => 'cd-composer',
		'show_admin_column' => true,
		'rewrite' => [
			'slug' => 'klang-bild/composer',
			'with_front' => false
		]
	]);

	register_taxonomy( 'mufa_cd_edition', 'mufa_cd', [
		'labels'    => [
			'name'      => 'Editionen',
			'singular_name' => 'Edition'
		],
		'hierarchical' => true,
		'query_var' => 'cd-edition',
		'show_admin_column' => true,
		'rewrite' => [
			'slug' => 'klang-bild/edition',
			'with_front' => false
		]
	]);
});

add_filter( 'manage_mufa_cd_posts_columns', function ( $columns ) {
	$new_columns = [];

	foreach ( $columns as $id => $label ) {
		$new_columns[$id] = $label;

		if ( $id == 'cb' ) {
			$new_columns['thumbnail'] = 'Teaserbild';
		}
	}

	return $new_columns;
}, 1000);

add_action( 'manage_mufa_cd_posts_custom_column', function ( $column, $post_id ) {
	switch ( $column ) {
		case 'thumbnail':
			echo get_the_post_thumbnail( $post_id, [ 120, 120 ] );
			break;
	}
}, 10, 2);
