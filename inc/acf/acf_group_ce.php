<?php

use Beck\Wordpress\ContentElements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {
	ContentElements::getInstance()->registerElements( get_template_directory() . '/inc/ce/' );

	acf_add_local_field_group( [
		'key'            => 'group_ce',
		'title'          => 'Inhalt',
		'fields'         => [
			[
				'key'                 => 'field_ce_elements',
				'name'                => 'content_elements',
				'type'                => 'flexible_content',
				'label'               => 'Inhaltselemente',
				'wpml_cf_preferences' => 3,
				'layouts'             => ContentElements::getInstance()->getLayouts(),
				'button_label'        => 'Inhaltselement hinzufügen'
			]
		],
		'location'       => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page'
				]
			],
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post'
				]
			],
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mufa_digital_issue'
				]
			],
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mufa_cd'
				]
			],
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mufa_work'
				]
			],
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mufa_event'
				]
			]
		],
		'menu_order'     => 100,
		'style'          => 'seamless',
		'position'       => 'acf_after_title',
		'hide_on_screen' => [ 'the_content' ]
	] );
} );