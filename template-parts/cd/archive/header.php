<?php

if ( $qoi = get_queried_object_id() ) {
	$queried_term_slug = get_term( $qoi )->slug;
} else {
	$queried_term_slug = '';
}

if ( is_tax( 'mufa_cd_edition' ) ) {
    $edition_checked = 'checked';
	$edition_url = get_post_type_archive_link( 'mufa_cd' );
} else {
    $edition_checked = '';
	$edition_url = get_term_link( 'edition-musikfabrik', 'mufa_cd_edition' );
}

?>
<div class="filter filter-publications filter-cds">
	<div class="container">
		<div class="row">
			<div class="col">
				<h1><?php _e( 'CD’s', 'mufa' ); ?></h1>
				<div class="filter-items">

					<div class="filter-item filter-item-checkbox">
						<form action="<?php echo esc_attr( $edition_url ); ?>" method="get">
							<input type="checkbox" name="cd-edition" value="edition-musikfabrik" id="filter-edition" <?php echo $edition_checked; ?>>
							<label for="filter-edition"><?php _e( 'Edition Musikfabrik', 'mufa' ); ?></label>
						</form>
					</div>

					<div class="filter-item filter-item-select">
						<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" data-archive-url="<?php echo esc_attr( get_post_type_archive_link( 'mufa_cd' ) ); ?>">
							<?php wp_dropdown_categories( [ 'taxonomy' => 'mufa_cd_composer', 'name' => 'cd-composer', 'value_field' => 'slug', 'selected' => $queried_term_slug, 'show_option_all' => __( 'Alle Komponist*innen', 'mufa' ) ] ); ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>