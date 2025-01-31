<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	register_taxonomy( 'mufa_post_author', 'post', [
		'labels'       => [
			'name'          => 'Autoren',
			'singular_name' => 'Autor'
		],
		'hierarchical' => true,
		'public'       => false,
		'show_ui'      => true
	] );
} );

add_action( 'pre_get_posts', function ( WP_Query $query ) {
	if (
		! is_admin() &&
		$query->is_home() &&
		$query->is_main_query()
	) {
		$cat = get_query_var( 'post-cat' );
		$tag = get_query_var( 'post-tag' );
		$year = get_query_var( 'post-year' );

		if ( $cat && $cat !== '0' ) {
			$query->set( 'category_name', $cat );
		}

		if ( $tag && $tag !== '0' ) {
			$query->set( 'tag', $tag );
		}

		if ( $year && $year !== '0' ) {
			$query->set( 'year', $year );
		}
	}
} );