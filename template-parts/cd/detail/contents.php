<div class="publication-detail">
	<div class="container">
		<div class="row">
			<div class="col col-custom-1">
				<h1 class="publication-title"><?php the_title(); ?></h1>
				<?php if ( $audio = get_field( 'audio_file' ) ): ?>
					<audio controls src="<?php echo esc_attr( $audio['url'] ); ?>"></audio>
                    <?php if ( $audio['title'] ): ?>
                        <p class="audio-title"><?php echo esc_html( $audio['title'] ); ?></p>
                    <?php endif; ?>
				<?php endif; ?>
				<?php if ( ! empty( $links = get_field( 'links' ) ) ): ?>
                    <?php foreach ( $links as $link ): ?>
                        <p><a href="<?php echo esc_attr( $link['link']['url'] ); ?>" target="<?php echo esc_attr( $link['link']['target'] ); ?>" class="btn-cta"><?php echo esc_html( $link['link']['title'] ?: __( 'Zum Shop', 'mufa' ) ); ?></a></p>
                    <?php endforeach; ?>
                <?php endif; ?>

				<h6 class="publication-subtitle"><?php _e( 'Komponist*innen', 'mufa' ); ?>:</h6>
				<p class="publication-excerpt"><?php the_terms( false, 'mufa_cd_composer' ); ?></p>
			</div>
			<div class="col col-custom-2">
				<?php the_post_thumbnail( 'full' ); ?>
			</div>
		</div>
	</div>
</div>

<?php the_content();