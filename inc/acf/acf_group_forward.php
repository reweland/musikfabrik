<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {

	acf_add_local_field_group( [
		'key'        => 'group_forward',
		'title'      => 'Weiterleitung',
		'fields'     => [
			[
				'key'     => 'field_forward_mode',
				'name'    => 'forward_mode',
				'type'    => 'select',
				'label'   => 'Weiterleitung',
				'choices' => [
					'none'        => 'Keine',
					'first_child' => 'Erste Unterseite',
					'page'        => 'Seite',
					'url'         => 'URL'
				]
			],
			[
				'key'               => 'field_forward_target_page',
				'name'              => 'forward_target_page',
				'type'              => 'page_link',
				'label'             => 'Zielseite',
				'post_type'         => [ 'page' ],
				'conditional_logic' => [
					[
						[
							'field'    => 'field_forward_mode',
							'operator' => '==',
							'value'    => 'page'
						]
					]
				]
			],
			[
				'key'               => 'field_forward_target_url',
				'name'              => 'forward_target_url',
				'type'              => 'url',
				'label'             => 'Ziel-URL',
				'conditional_logic' => [
					[
						[
							'field'    => 'field_forward_mode',
							'operator' => '==',
							'value'    => 'url'
						]
					]
				]
			]
		],
		'location'   => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page'
				]
			]
		],
		'menu_order' => 1000,
		'position'   => 'side'
	] );

} );