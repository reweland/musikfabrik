<?php

if ( $qoi = get_queried_object_id() ) {
    $queried_term_slug = get_term( $qoi )->slug;
} else {
    $queried_term_slug = '';
}

?>
<div class="filter filter-posts">
	<div class="container">
		<div class="row">
			<div class="col">
				<h1>Blog</h1>
				<div class="filter-items">
					<div class="filter-item filter-item-select">
                        <form class="category-select" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" data-archive-url="<?php echo esc_attr( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">
                            <?php wp_dropdown_categories( [ 'show_option_all' => __( 'Alle Kategorien', 'mufa' ) ] ); ?>
                        </form>
					</div>
					<div class="filter-item filter-item-select">
                        <form class="tag-select" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" data-archive-url="<?php echo esc_attr( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">
						    <?php wp_dropdown_categories( [ 'taxonomy' => 'post_tag', 'name' => 'tag', 'value_field' => 'slug', 'selected' => $queried_term_slug, 'show_option_all' => __( 'Alle Schlagworte', 'mufa' ) ] ); ?>
                        </form>
					</div>
					<div class="filter-item filter-item-select">
                        <form class="years-select" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
                            <select name="year">
                                <option value="<?php echo esc_attr( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php _e( 'Alle Jahre', 'mufa' ); ?></option>
                                <?php wp_get_archives( [ 'type' => 'yearly', 'format' => 'option' ] ); ?>
                            </select>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>