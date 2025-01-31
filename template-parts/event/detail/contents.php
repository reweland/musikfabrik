<div class="pagination">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav class="navigation">
                    <h2 class="screen-reader-text"><?php _e( 'Beitrags-Navigation', 'mufa' ); ?></h2>
                    <div class="nav-links">
                        <div class="nav-previous"><a href="javascript:history.back();"><?php _e( 'Zurück', 'mufa' ); ?></a></div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="calendar-detail">
	<div class="container">
		<div class="row">
			<div class="col col-custom-1">
				<h1><?php the_title(); ?></h1>
				<p><?php echo esc_html( get_post()->post_excerpt ); ?></p>
				<table class="calendar-detail-table">
					<?php foreach ( get_field( 'dates' ) as $index => $date ): ?>
                        <tr>
                            <td><?php echo date_i18n( 'D. d.m.Y', $date['date_time'] ); ?></td>
                            <td>
                                <?php $time = date_i18n( 'H:i', $date['date_time'] ); ?>
                                <?php if ( $time === '00:00' ): ?>
                                    n/n
                                <?php elseif ( ICL_LANGUAGE_CODE === 'de' ): ?>
	                                <?php echo $time; ?> <?php _e( 'Uhr', 'mufa' ); ?>
                                <?php else: ?>
                                    <?php echo date_i18n( 'g:i a', $date['date_time'] ); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ( $date['type'] ): ?>
                                    <span class="calendar-event-type"><?php echo esc_html( $date['type'] ); ?></span>
                                <?php endif; ?>
                                <a href="<?php echo add_query_arg( 'ical', $index ); ?>" class="calendar-event-export">ical</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
				</table>
				<p>
                    <?php if ( $location = get_field( 'location' ) ): ?>
                        <?php if ( $location_link = get_field( 'location_link' ) ): ?>
		                    <?php echo esc_html( get_field( 'city' ) ); ?>, <a href="<?php echo esc_attr( $location_link['url'] ); ?>" target="_blank"><?php echo esc_html( get_field( 'location' ) ); ?></a>
                        <?php else: ?>
		                    <?php echo esc_html( get_field( 'city' ) ); ?>, <?php echo esc_html( get_field( 'location' ) ); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </p>
				<?php if ( $ticket_link = get_field( 'ticket_link' ) ): ?>
                    <p><a href="<?php echo esc_attr( $ticket_link['url'] ); ?>" target="<?php echo esc_attr( $ticket_link['target'] ); ?>" class="btn-cta"><?php echo esc_html( $ticket_link['title'] ?: __( 'Tickets', 'mufa' ) ); ?></a></p>
                <?php endif; ?>
			</div>
			<div class="col col-custom-2">
				<?php the_post_thumbnail( 'full' ); ?>
			</div>
		</div>
	</div>
</div>
<?php the_content(); ?>

