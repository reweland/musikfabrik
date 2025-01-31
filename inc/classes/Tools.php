<?php

namespace Beck\Mufa;

class Tools {

	public static function format_artist_and_instruments( $artist_id, $instruments = '' ) {
		$artist = get_term( $artist_id, 'mufa_work_artist' );

		if ( $instruments ) {
			return sprintf( '%s (%s)', $artist->name, $instruments );
		} else {
			return $artist->name;
		}
	}

	public static function csterms( $taxonomy, $post_id = false ) {
		$terms = get_the_terms( $post_id, $taxonomy );

		if ( is_array( $terms ) ) {
			$term_names = wp_list_pluck( $terms, 'name' );

			return implode( ', ', $term_names );
		} else {
			return '';
		}
	}


}