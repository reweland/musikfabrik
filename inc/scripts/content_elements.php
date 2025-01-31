<?php

namespace Beck\Wordpress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ContentElements {
	public static $instance = null;

	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new ContentElements();
		}

		return self::$instance;
	}

	public $elements = [];

	public $enableRegistration = false;

	public function render( $post_id = false ) {
		ob_start();

		$elements = get_field( 'content_elements', $post_id );

		if ( is_array( $elements ) ) {
			$elements = apply_filters( 'nb/ce/pre_render_elements', $elements );

			foreach ( $elements as $element ) {
				$element = apply_filters( 'nb/ce/render_element', $element );
				$element = apply_filters( 'nb/ce/render_element/' . $element['acf_fc_layout'], $element );

				if ( $element ) {
					include get_template_directory() . '/inc/ce/' . $element['acf_fc_layout'] . '.php';
				}
			}
		}

		return apply_filters( 'nb/ce/post_render_elements', ob_get_clean() );
	}

	public function registerElements( $path ) {
		$this->enableRegistration = true;
		ob_start();

		foreach ( glob( $path . '*.php' ) as $filename ) {
			include $filename;
		}

		$this->enableRegistration = false;
		ob_end_clean();

		usort( $this->elements, function ( $a, $b ) {
			return $a['weight'] > $b['weight'] ? 1 : ( $a['weight'] < $b['weight'] ? - 1 : 0 );
		} );

		array_walk( $this->elements, function ( &$item, $index ) {
			unset( $item['weight'] );
		} );
	}

	public function register( $name, $label, $fields = [], $weight = 100 ) {
		if ( ! $this->enableRegistration ) {
			return false;
		}

		$element = [
			'key'        => 'layout_ce_' . $name,
			'name'       => $name,
			'label'      => $label,
			'sub_fields' => [],
			'weight'     => $weight
		];

		$element = apply_filters( 'nb/ce/pre_register_element', $element );
		$element = apply_filters( 'nb/ce/pre_register_element/' . $name, $element );

		$element['sub_fields'] = array_merge(
			$element['sub_fields'],
			$fields
		);

		$element = apply_filters( 'nb/ce/post_register_element', $element );
		$element = apply_filters( 'nb/ce/post_register_element/' . $name, $element );

		if ( is_array( $element ) && count( $element ) && ! isset( $this->elements[ $name ] ) ) {
			$this->elements[ $name ] = $element;
		}

		return true;
	}

	public function getLayouts() {
		$elements = $this->elements;

		foreach ( $elements as $elementIndex => $elementData ) {
			$elements[ $elementIndex ]['sub_fields'] = $this->prepareSubFields(
				$elements[ $elementIndex ]['sub_fields'],
				'field_ce_' . $elementData['name']
			);
		}

		return $elements;
	}

	protected function prepareSubFields( $fields, $keyPrefix ) {
		$fields = array_values( $fields );

		foreach ( $fields as $index => $data ) {
			$fields[ $index ]['key'] = $keyPrefix . '_' . $data['name'];
			$fields[ $index ]['wpml_cf_preferences'] = 3;

			if ( isset( $fields[ $index ]['sub_fields'] ) ) {
				$fields[ $index ]['sub_fields'] = $this->prepareSubFields( $fields[ $index ]['sub_fields'], $keyPrefix . '_' . $data['name'] );
			}
		}

		return $fields;
	}

	public function isInRegistration() {
		return $this->enableRegistration;
	}
}
