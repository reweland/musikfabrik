<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {

	acf_add_local_field_group( [
		'key'        => 'group_cd',
		'title'      => 'CD',
		'fields'     => [
			[
				'key'     => 'field_cd_audio_file',
				'name'    => 'audio_file',
				'type'    => 'file',
				'label'   => 'Audiodatei',
				'mime_types' => 'mp3'
			],
			[
				'key'               => 'field_cd_links',
				'name'              => 'links',
				'type'              => 'repeater',
				'label'             => 'Shop-Links',
				'sub_fields' => [
					[
						'key'   => 'field_cd_link',
						'name'  => 'link',
						'type'  => 'link',
						'label' => 'Link'
					]
				]
			]
		],
		'location'   => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mufa_cd'
				]
			]
		],
		'menu_order' => 90,
		'position' => 'acf_after_title'
	] );

} );