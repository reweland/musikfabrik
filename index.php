<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( is_search() ) {

	get_template_part( 'template-parts/search/results' );

} else if ( is_404() ) {

	get_template_part( 'template-parts/misc/404' );

} else if ( is_home() || is_post_type_archive( 'post' ) || is_category() || is_tag() || is_year() ) {

	get_template_part( 'template-parts/blog/archive' );

} else if ( is_singular( 'post' ) ) {

	get_template_part( 'template-parts/blog/detail' );

} else if ( is_post_type_archive( 'mufa_digital_issue' ) ) {

	get_template_part( 'template-parts/digital-issue/archive' );

} else if ( is_singular( 'mufa_digital_issue' ) ) {

	get_template_part( 'template-parts/digital-issue/detail' );

} else if ( is_post_type_archive( 'mufa_cd' ) || is_tax( 'mufa_cd_edition' ) || is_tax( 'mufa_cd_composer' ) ) {

	get_template_part( 'template-parts/cd/archive' );

} else if ( is_singular( 'mufa_cd' ) ) {

	get_template_part( 'template-parts/cd/detail' );

} else if ( is_post_type_archive( 'mufa_work' ) || is_tax( 'mufa_work_composer' ) || is_tax( 'mufa_work_artist' ) ) {

	get_template_part( 'template-parts/work/archive' );

} else if ( is_singular( 'mufa_work' ) ) {

	get_template_part( 'template-parts/work/detail' );

} else if ( is_singular( 'mufa_event' ) ) {

	get_template_part( 'template-parts/event/detail' );

} else {

	while ( have_posts() ) {
		the_post();
		the_content();
	}

}

get_footer();