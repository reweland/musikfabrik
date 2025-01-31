<div class="ce ce-onecol pb-medium">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="publications">
					<?php while ( have_posts() ): the_post(); ?>
						<div class="publication-teaser">
							<a href="<?php the_permalink(); ?>">
								<figure>
									<div class="img-wrapper">
										<?php the_post_thumbnail( 'full' ); ?>
									</div>
									<figcaption>
										<h3 class="teaser-title"><?php the_title(); ?></h3>
										<h6 class="teaser-subtitle"><?php _e( 'Interpret*innen', 'mufa' ); ?>:</h6>
                                        <?php
                                            $artists = [];
                                            foreach ( get_field( 'artists' ) as $artist ) {
                                                $artists[] = \Beck\Mufa\Tools::format_artist_and_instruments( $artist['artist'], $artist['instruments'] );
                                            }
                                        ?>
										<p class="teaser-excerpt"><?php echo esc_html( implode( ', ', $artists ) ); ?></p>
									</figcaption>
								</figure>
							</a>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</div>