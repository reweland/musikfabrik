<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {

	acf_add_local_field_group( [
		'key'        => 'group_event',
		'title'      => 'Event',
		'fields'     => [
			[
				'key'   => 'field_event_city',
				'name'  => 'city',
				'type'  => 'text',
				'label' => 'Ort',
				'wrapper' => [ 'width' => '20' ]
			],
			[
				'key'   => 'field_event_location',
				'name'  => 'location',
				'type'  => 'text',
				'label' => 'Location',
				'wrapper' => [ 'width' => '20' ]
			],
			[
				'key'   => 'field_event_location_link',
				'name'  => 'location_link',
				'type'  => 'link',
				'label' => 'Location-Link',
				'wrapper' => [ 'width' => '20' ]
			],
			[
				'key'   => 'field_event_ticket_link',
				'name'  => 'ticket_link',
				'type'  => 'link',
				'label' => 'Ticket-Link',
				'wrapper' => [ 'width' => '20' ]
			],
			[
				'key'   => 'field_event_is_nrw',
				'name'  => 'is_nrw',
				'type'  => 'true_false',
				'label' => 'NRW',
				'wrapper' => [ 'width' => '20' ]
			],
			[
				'key'               => 'field_event_dates',
				'name'              => 'dates',
				'type'              => 'repeater',
				'min'               => 1,
				'label'             => 'Termine',
				'sub_fields' => [
					[
						'key'   => 'field_event_date_date_time',
						'name'  => 'date_time',
						'type'  => 'date_time_picker',
						'label' => 'Datum/Uhrzeit',
						'required' => true,
						'display_format' => 'd.m.Y, H:i',
						'return_format' => 'U',
						'first_day' => 1,
						'wrapper' => [ 'width' => '33' ]
					],
					[
						'key'   => 'field_event_date_type',
						'name'  => 'type',
						'type'  => 'text',
						'label' => 'Art der Aufführung',
						'wrapper' => [ 'width' => '33' ]
					],
					[
						'key'   => 'field_event_date_image',
						'name'  => 'image',
						'type'  => 'image',
						'label' => 'Alternatives Bild',
						'wrapper' => [ 'width' => '33' ]
					]
				]
			]
		],
		'location'   => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'mufa_event'
				]
			]
		],
		'menu_order' => 90,
		'position' => 'acf_after_title'
	] );

} );