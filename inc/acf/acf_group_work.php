<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {

	acf_add_local_field_group( [
		'key'        => 'group_work',
		'title'      => 'Werk',
		'fields'     => [
			[
				'key'       => 'field_work_description',
				'name'      => 'description',
				'type'      => 'textarea',
				'rows'      => 3,
				'label'     => 'Beschreibung'
			],
			[
				'key'     => 'field_work_audio_file',
				'name'    => 'audio_file',
				'type'    => 'file',
				'label'   => 'Audiodatei',
				'mime_types' => 'mp3'
			],
			[
				'key'               => 'field_work_links',
				'name'              => 'links',
				'type'              => 'repeater',
				'label'             => 'Shop-Links',
				'sub_fields' => [
					[
						'key'   => 'field_work_link',
						'name'  => 'link',
						'type'  => 'link',
						'label' => 'Link'
					]
				]
			],
			[
				'key'               => 'field_work_artists',
				'name'              => 'artists',
				'type'              => 'repeater',
				'label'             => 'Interpret*innen',
				'sub_fields' => [
					[
						'key'   => 'field_work_artist',
						'name'  => 'artist',
						'type'  => 'taxonomy',
						'taxonomy' => 'mufa_work_artist',
						'field_type' => 'select',
						'add_term' => true,
						'save_terms' => 1,
						'label' => 'Interpret*in',
						'wrapper' => [ 'width' => '50' ]
					],
					[
						'key'   => 'field_work_instruments',
						'name'  => 'instruments',
						'type'  => 'text',
						'label' => 'Instrument(e)',
						'wrapper' => [ 'width' => '50' ]
					]
				]
			]
		],
		'location'   => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mufa_work'
				]
			]
		],
		'menu_order' => 90,
		'position' => 'acf_after_title'
	] );

} );