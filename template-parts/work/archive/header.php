<?php

if ( $qoi = get_queried_object_id() ) {
	$queried_term_slug = get_term( $qoi )->slug;
} else {
	$queried_term_slug = '';
}

?>
<div class="filter filter-publications filter-works">
	<div class="container">
		<div class="row">
			<div class="col">
				<h1><?php _e( 'Label', 'mufa' ); ?></h1>
				<div class="filter-items">
					<div class="filter-item filter-item-select">
						<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" data-archive-url="<?php echo esc_attr( get_post_type_archive_link( 'mufa_work' ) ); ?>">
							<?php wp_dropdown_categories( [ 'taxonomy' => 'mufa_work_composer', 'name' => 'work-composer', 'value_field' => 'slug', 'selected' => $queried_term_slug, 'show_option_all' => __( 'Alle Komponist*innen', 'mufa' ) ] ); ?>
						</form>
					</div>
					<div class="filter-item filter-item-select">
						<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" data-archive-url="<?php echo esc_attr( get_post_type_archive_link( 'mufa_work' ) ); ?>">
							<?php wp_dropdown_categories( [ 'taxonomy' => 'mufa_work_artist', 'name' => 'work-artist', 'value_field' => 'slug', 'selected' => $queried_term_slug, 'show_option_all' => __( 'Alle Interpret*innen', 'mufa' ) ] ); ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>