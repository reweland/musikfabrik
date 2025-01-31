<div class="publication-detail">
    <div class="container">
        <div class="row">
            <div class="col col-custom-1">
                <h1 class="publication-title"><?php the_title(); ?></h1>
                <?php if ( $description = get_field( 'description' ) ): ?>
                    <p><?php echo nl2br( esc_html( $description ) ); ?></p>
                <?php endif; ?>
	            <?php if ( $audio = get_field( 'audio_file' ) ): ?>
                    <audio controls src="<?php echo esc_attr( $audio['url'] ); ?>"></audio>
	            <?php endif; ?>
                <h6 class="publication-subtitle"><?php _e( 'Komponist*in', 'mufa' ); ?>:</h6>
                <p class="publication-excerpt"><?php the_terms( false, 'mufa_work_composer' ); ?></p>
                <h6 class="publication-subtitle"><?php _e( 'Interpret*innen', 'mufa' ); ?>:</h6>
                <p class="publication-excerpt"><?php the_terms( false, 'mufa_work_artist' ); ?></p>
	            <?php if ( $links = get_field( 'links' ) ): ?>
                    <h3><?php _e( 'Streamen/kaufen', 'mufa' ); ?>:</h3>
                    <p>
                            <?php foreach ( $links as $link ): ?>
                                <a class="btn-cta-small" href="<?php echo esc_attr( $link['link']['url'] ); ?>" target="<?php echo esc_attr( $link['link']['target'] ); ?>" class="btn-cta"><?php echo esc_html( $link['link']['title'] ?: __( 'Zum Shop', 'mufa' ) ); ?></a>
                            <?php endforeach; ?>
                    </p>
	            <?php endif; ?>
            </div>
            <div class="col col-custom-2">
	            <?php the_post_thumbnail( 'full' ); ?>
            </div>
        </div>
    </div>
</div>
<?php the_content();