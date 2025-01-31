<?php

if (!defined('ABSPATH')) exit;

add_action('init', function () {
	register_post_type( 'mufa_event', [
		'labels'    => [
			'name'      => 'Veranstaltungen',
			'singular_name' => 'Veranstaltung',
			'menu_name' => 'Kalender',
			'add_new_item' => 'Neue Veranstaltung'
		],
		'public'    => true,
		'has_archive' => false,
		'show_ui'   => true,
		'menu_position' => 33,
		'supports'  => [ 'title', 'thumbnail', 'excerpt' ],
		'rewrite' => [
			'slug' => 'kalender',
			'with_front' => false
		]
	]);

	register_taxonomy( 'mufa_event_type', 'mufa_event', [
		'labels'    => [
			'name'      => 'Veranstaltungsarten',
			'singular_name' => 'Veranstaltungsart'
		],
		'show_admin_column' => true,
		'hierarchical' => true
	]);
});

\Beck\Mufa\Event::init_hooks();

add_filter( 'manage_mufa_event_posts_columns', function ( $columns ) {
	$new_columns = [];

	foreach ( $columns as $id => $label ) {
		$new_columns[$id] = $label;

		if ( $id == 'cb' ) {
			$new_columns['thumbnail'] = 'Teaserbild';
		} else if ( $id == 'title' ) {
			$new_columns['dates'] = 'Aufführungen';
		}
	}

	return $new_columns;
}, 1000);

add_action( 'manage_mufa_event_posts_custom_column', function ( $column, $post_id ) {
	switch ( $column ) {
		case 'thumbnail':
			echo get_the_post_thumbnail( $post_id, [ 120, 120 ] );
			break;

		case 'dates':
			$dates = [];
			foreach ( get_field( 'dates', $post_id ) as $date ) {
				$dates[] = sprintf(
					'%s %s',
					date( 'd.m.Y, H:i', $date['date_time'] ) . ' Uhr',
					$date['type'] ? '(' . esc_html( $date['type'] ) . ')' : ''
				);
			}
			echo implode( '<br>', $dates );
			break;
	}
}, 10, 2);
