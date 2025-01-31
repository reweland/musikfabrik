<?php

if (!defined('ABSPATH')) exit;

add_action('init', function () {
	register_post_type( 'mufa_digital_issue', [
		'labels'    => [
			'name'      => 'Videos',
			'singular_name' => 'Video',
			'menu_name' => 'Videos',
			'add_new_item' => 'Neues Video'
		],
		'public'    => true,
		'has_archive' => true,
		'show_ui'   => true,
		'menu_position' => 30,
		'supports'  => [ 'title', 'thumbnail', 'excerpt' ],
		'rewrite' => [
			'slug' => 'klang-bild/videos',
			'with_front' => false
		]
	]);
});
