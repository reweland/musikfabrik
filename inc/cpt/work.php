<?php

if (!defined('ABSPATH')) exit;

add_action('init', function () {
	register_post_type( 'mufa_work', [
		'labels'    => [
			'name'      => 'Werke',
			'singular_name' => 'Werk',
			'menu_name' => 'Label',
			'add_new_item' => 'Neues Werk'
		],
		'public'    => true,
		'has_archive' => true,
		'show_ui'   => true,
		'menu_position' => 32,
		'supports'  => [ 'title', 'thumbnail', 'excerpt' ],
		'rewrite' => [
			'slug' => 'label/work',
			'with_front' => false
		]
	]);

	register_taxonomy( 'mufa_work_composer', 'mufa_work', [
		'labels'    => [
			'name'      => 'Komponisten',
			'singular_name' => 'Komponist'
		],
		'query_var' => 'work-composer',
		'show_admin_column' => true,
		'hierarchical' => true,
		'rewrite' => [
			'slug' => 'label/composer',
			'with_front' => false
		]
	]);

	register_taxonomy( 'mufa_work_artist', 'mufa_work', [
		'labels'    => [
			'name'      => 'Interpret*innen',
			'singular_name' => 'Interpret*in'
		],
		'query_var' => 'work-artist',
		// 'show_admin_column' => true,
		'hierarchical' => true,
		'meta_box_cb' => false,
		'rewrite' => [
			'slug' => 'label/artist',
			'with_front' => false
		]
	]);
});

add_filter( 'manage_mufa_work_posts_columns', function ( $columns ) {
	$new_columns = [];

	foreach ( $columns as $id => $label ) {
		if ( $id == 'date' ) {
			$new_columns['artists'] = 'Interpret*innen';
		}

		$new_columns[$id] = $label;

		if ( $id == 'cb' ) {
			$new_columns['thumbnail'] = 'Teaserbild';
		}
	}

	return $new_columns;
}, 1000);

add_action( 'manage_mufa_work_posts_custom_column', function ( $column, $post_id ) {
	switch ( $column ) {
		case 'thumbnail':
			echo get_the_post_thumbnail( $post_id, [ 120, 120 ] );
			break;

		case 'artists':
			foreach ( get_field( 'artists' ) as $artist ) {
				echo esc_html( \Beck\Mufa\Tools::format_artist_and_instruments( $artist['artist'], $artist['instruments'] ) ) . "<br>";
			}
			break;
	}
}, 10, 2);
