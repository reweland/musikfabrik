<div class="filter filter-posts">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Blog</h1>
                <div class="filter-items">
                    <form action="<?php echo esc_attr( get_post_type_archive_link( 'post' ) ); ?>" method="get">
                        <div class="filter-item filter-item-select">
							<?php
							wp_dropdown_categories( [
								'show_option_all' => __( 'Alle Kategorien', 'mufa' ),
								'value_field'     => 'slug',
								'name'            => 'post-cat',
								'selected'        => get_query_var( 'post-cat' )
							] );
							?>
                        </div>
                        <div class="filter-item filter-item-select">
							<?php
							wp_dropdown_categories( [
								'taxonomy'        => 'post_tag',
								'show_option_all' => __( 'Alle Schlagworte', 'mufa' ),
								'value_field'     => 'slug',
								'name'            => 'post-tag',
								'selected'        => get_query_var( 'post-tag' )
							] );
							?>
                        </div>
                        <div class="filter-item filter-item-select">
                            <select name="post-year">
                                <option value="0"><?php _e( 'Alle Jahre', 'mufa' ); ?></option>
								<?php
                                $options = wp_get_archives( [
                                    'type' => 'yearly',
                                    'format' => 'option',
                                    'echo' => false
                                ] );
								$options = preg_replace( "|<option\s+value='.+'>\s*(\d+)\s*</option>|U", '<option value="\\1">\\1</option>', $options );
								$options = str_replace(
									sprintf( 'value="%s"', get_query_var( 'post-year' ) ),
									sprintf( 'value="%s" selected', get_query_var( 'post-year' ) ),
                                    $options
								);
								echo $options;
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
