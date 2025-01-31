<?php

$events = \Beck\Mufa\Event::get_upcoming_events( 4, true );

?>
<div class="calendar tiny-calendar">
	<?php foreach ( $events as $event ): ?>
		<div class="calendar-teaser">
			<a href="<?php the_permalink( $event['post'] ); ?>">
				<figure>
					<div class="img-wrapper">
						<?php if ( $image = $event['date']['image'] ): ?>
							<?php echo wp_get_attachment_image( $image['ID'], 'full' ); ?>
						<?php else: ?>
							<?php echo get_the_post_thumbnail( $event['post'], 'full' ); ?>
						<?php endif; ?>
					</div>
					<figcaption>
						<div class="caption-col caption-col-1">
							<p class="teaser-date">
								<span class="date-day"><?php echo date_i18n( 'D', $event['date']['date_time'] ); ?></span>
								<span class="date-month"><?php echo date_i18n( 'jM', $event['date']['date_time'] ); ?></span>
								<span class="date-year"><?php echo date_i18n( 'Y', $event['date']['date_time'] ); ?></span>
								<?php if ( count( get_field( 'dates', $event['post'] ) ) > 1 ): ?>
									<span class="additional-date-info"><?php _e( '+ weitere Termine', 'mufa' ); ?></span>
								<?php endif; ?>
							</p>
							<p class="teaser-location">
								<?php echo esc_html( get_field( 'city', $event['post'] ) ); ?>
								<?php if ( get_field( 'is_nrw', $event['post'] ) ): ?>
									<span class="teaser-location-extra"><?php _e( 'NRW', 'mufa' ); ?></span>
								<?php endif; ?>
							</p>
						</div>
						<div class="caption-col caption-col-2">
							<h3 class="teaser-title"><?php echo esc_html( get_the_title( $event['post'] ) ); ?></h3>
							<?php if ( $event['date']['type'] ): ?>
                                <p class="teaser-event-type"><?php echo esc_html( $event['date']['type'] ); ?></p>
                            <?php endif; ?>
							<p class="teaser-excerpt"><?php echo esc_html( $event['post']->post_excerpt ); ?></p>
						</div>
					</figcaption>
				</figure>
			</a>
		</div>
	<?php endforeach; ?>
</div>
