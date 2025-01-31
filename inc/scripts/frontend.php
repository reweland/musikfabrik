<?php

use Beck\Wordpress\ContentElements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'document_title_separator', function ( $sep ) {
	return '|';
} );

add_action( 'wp_print_scripts', function () {
	wp_dequeue_script( 'wp-embed' );
} );

add_action( 'enqueue_block_assets', function () {
	wp_dequeue_style( 'wp-block-library' );
}, PHP_INT_MAX );

add_action( 'init', function () {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
} );

add_filter( 'body_class', function ( $classes ) {
	if ( is_singular() && ( $class = get_field( 'pageproperties_bodyclass' ) ) ) {
		$classes[] = $class;
	}

	return $classes;
} );

add_filter( 'the_content', function ( $content ) {
	if ( ! post_password_required() ) {
		$content = Beck\Wordpress\ContentElements::getInstance()->render() . $content;
	}

	return $content;
} );

add_filter( 'acf_the_content', function ( $content ) {
	$content = preg_replace( '/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '<figure>\2</figure>', $content );
	$content = preg_replace_callback( '/<img\s*(?:class\s*\=\s*[\'\"](.*?)[\'\"].*?\s*|src\s*\=\s*[\'\"](.*?)[\'\"].*?\s*|alt\s*\=\s*[\'\"](.*?)[\'\"].*?\s*|width\s*\=\s*[\'\"](.*?)[\'\"].*?\s*|height\s*\=\s*[\'\"](.*?)[\'\"].*?\s*)+.*?>/si', function ( $match ) {
		if ( preg_match( '/\blazy\b/', $match[1] ) ) {
			return str_replace( 'src="', 'src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src="', $match[0] );
		} else {
			return $match[0];
		}
	}, $content );

	return $content;
}, 100 );

add_filter( 'acf_the_content', function ( $content ) {
	list ( $intro, $more ) = explode( '<p><!--more--></p>', $content, 2 );

	if ( $more ) {
		$more = sprintf( '<div class="toggle-content">%s</div>', $more );
	}

	return $intro . $more;
}, 110 );

add_shortcode( 'video', function ( $atts, $content ) {
	$atts['preload'] = 'auto';

	return wp_video_shortcode( $atts, $content );
} );

add_filter( 'wp_video_shortcode', function ( $output, $atts, $video, $post_id, $library ) {
	$output = preg_replace( '/style="width:\s*\d+px;"/', '', $output );
	$output = preg_replace( '/(width|height)=\"\d*\"\s/', '', $output );

	return $output;
}, 10, 5 );

function nb_oembed_handler( $code ) {
	if ( strpos( $code, 'youtu.be' ) !== false || strpos( $code, 'youtube.com' ) !== false || strpos( $code, 'vimeo' ) !== false ) {
		$html = preg_replace( "@src=(['\"])?([^'\">\s]*)@", "src=$1$2&showinfo=0", $code );

		return '<div class="responsive-video">' . $html . '</div>';
	}

	return $code;
}

add_filter( 'embed_handler_html', 'nb_oembed_handler' );
add_filter( 'embed_oembed_html', 'nb_oembed_handler' );

if ( function_exists( 'eae_encode_emails' ) ) {
	add_filter( 'eae_method', function () {
		return 'antispambot';
	} );
	add_filter( 'acf/format_value/type=wysiwyg', 'eae_encode_emails' );
}

add_filter( 'img_caption_shortcode_width', '__return_zero' );

add_filter( 'wp_nav_menu_objects', function ( $items, $args ) {
	foreach ( $items as $index => $item ) {
		if ( get_post_status( $item->object_id ) == 'private' ) {
			unset( $items[ $index ] );
		}
	}

	return $items;
}, 10, 2 );
