<div id="search-overlay" class="bgr-black">
	<div class="search-overlay-inner">
		<form action="<?php echo esc_url( home_url() ) ?>" class="searchform" method="GET">
			<input type="text" name="s" id="searchstring" placeholder="<?php _e( 'Suchbegriff eingeben', 'mufa' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" size="40">
			<input type="submit" value="<?php _e( 'Suchen', 'mufa' ); ?>">
		</form>
	</div>
</div>
