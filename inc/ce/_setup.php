<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'nb/ce/pre_register_element', function ( $element ) {
	$element['sub_fields'] = [
		[
			'name'  => 'tab1',
			'type'  => 'tab',
			'label' => 'Inhalte'
		]
	];

	return $element;
} );

add_filter( 'nb/ce/post_register_element', function ( $element ) {
	$element['sub_fields'] = array_merge( $element['sub_fields'], [
		[
			'name'  => 'tab2',
			'type'  => 'tab',
			'label' => 'Darstellung'
		],
		[
			'name'    => 'hidden',
			'type'    => 'true_false',
			'label'   => 'verborgen',
			'wrapper' => [ 'width' => '25' ]
		],
		'classes_select'   => [
			'name'    => 'classes_select',
			'type'    => 'checkbox',
			'layout'  => 'horizontal',
			'label'   => 'Darstellung',
			'choices' => [
				'fullwidth' => 'volle Breite'
			],
			'wrapper' => [ 'width' => '25' ]
		],
		'classes_custom'   => [
			'name'    => 'classes_custom',
			'type'    => 'text',
			'label'   => 'CSS-Klassen',
			'wrapper' => [ 'width' => '50' ]
		],
		'layout'            => [
			'name'          => 'layout',
			'type'          => 'select',
			'label'         => 'Layout',
			'choices'       => [
			],
			'allow_null'  => true,
			'wrapper'     => [ 'width' => '25' ],
			'placeholder' => ' '
		],
		'background_color' => [
			'name'        => 'background_color',
			'type'        => 'select',
			'label'       => 'Hintergrundfarbe',
			'choices'     => [
				'bgr-yellow' => 'gelb',
				'bgr-black'  => 'schwarz',
				'bgr-white'  => 'weiß'
			],
			'allow_null'  => true,
			'wrapper'     => [ 'width' => '25' ],
			'placeholder' => ' '
		],
		'top_spacer'       => [
			'name'        => 'top_spacer',
			'type'        => 'select',
			'label'       => 'Abstand oben',
			'choices'     => [
				'pt-small'  => 'klein',
				'pt-medium' => 'mittel',
				'pt-large'  => 'groß',
				'pt-xlarge' => 'extra groß'
			],
			'wrapper'     => [ 'width' => '25' ],
			'allow_null'  => true,
			'placeholder' => ' '
		],
		'bottom_spacer'    => [
			'name'        => 'bottom_spacer',
			'type'        => 'select',
			'label'       => 'Abstand unten',
			'choices'     => [
				'pb-small'  => 'klein',
				'pb-medium' => 'mittel',
				'pb-large'  => 'groß',
				'pb-xlarge' => 'extra groß'
			],
			'wrapper'     => [ 'width' => '25' ],
			'allow_null'  => true,
			'placeholder' => ' '
		]
	] );

	return $element;
} );

add_filter( 'nb/ce/pre_render_elements', function ( $elements ) {
	for ( $i = 0; $i < count( $elements ); $i ++ ) {
		if ( isset( $elements[ $i ]['hidden'] ) && $elements[ $i ]['hidden'] ) {
			array_splice( $elements, $i, 1 );
			$i --;
		} else if ( $elements[ $i ]['acf_fc_layout'] == 'include' ) {
			$subst = get_field( 'content_elements', $elements[ $i ]['post'] );
			if ( ! is_array( $subst ) ) {
				$subst = [];
			}
			array_splice( $elements, $i, 1, $subst );

			$i --;
		}
	}

	return $elements;
}, 10 );

add_filter( 'nb/ce/pre_render_elements', function ( $elements ) {
	for ( $i = 0; $i < count( $elements ); $i ++ ) {
		$classes = [];

		foreach (
			array(
				'classes_select',
				'classes_custom',
				'indentation',
				'background_color',
				'bottom_spacer',
				'top_spacer',
				'layout'
			) as $field
		) {
			$value = isset( $elements[ $i ][ $field ] ) ? $elements[ $i ][ $field ] : '';

			if ( is_array( $value ) ) {
				$classes = array_merge( $classes, $value );
			} else if ( $value ) {
				$classes = array_merge( $classes, explode( ' ', $value ) );
			}
		}

		$elements[ $i ]['_classes'] = array_filter( $classes );

		$elements[ $i ]['_effect_atts'] = '';
		if ( $elements[ $i ]['effect_type'] ) {
			$effect_atts = [ sprintf( 'data-aos="%s"', $elements[ $i ]['effect_type'] ) ];

			if ( $elements[ $i ]['effect_duration'] ) {
				$effect_atts[] = sprintf( 'data-aos-duration="%d"', $elements[ $i ]['effect_duration'] );
			}

			if ( $elements[ $i ]['effect_delay'] ) {
				$effect_atts[] = sprintf( 'data-aos-delay="%d"', $elements[ $i ]['effect_delay'] );
			}

			$elements[ $i ]['_effect_atts'] = implode( ' ', $effect_atts );
		}
	}

	return $elements;
}, 30 );

add_filter( 'nb/ce/post_render_elements', function ( $content ) {
	if ( function_exists( 'eae_encode_emails' ) ) {
		$content = eae_encode_emails( $content );
	}

	return $content;
} );