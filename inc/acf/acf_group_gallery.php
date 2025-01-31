<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {

	acf_add_local_field_group( [
		'key'        => 'group_gallery',
		'title'      => 'Galerie',
		'fields'     => [
			[
				'key'     => 'field_gallery_images',
				'name'    => 'images',
				'type'    => 'gallery',
				'label'   => 'Bilder'
			]
		],
		'location'   => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mufa_gallery'
				]
			]
		],
		'menu_order' => 90,
		'position' => 'acf_after_title'
	] );

} );