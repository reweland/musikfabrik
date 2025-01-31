<?php

global $wpdb;

$gallery_post_ids = $wpdb->get_col( sprintf(
    'SELECT ID FROM %s WHERE post_type = "mufa_gallery" AND post_title LIKE "%s"',
    $wpdb->posts,
    esc_sql( $atts['name'] )
) );

if ( empty( $gallery_post_ids ) ) {
    return;
}

$images = get_field( 'images', $gallery_post_ids[0] );

?>
<div class="img-slider">
	<div class="swiper-container">
		<div class="swiper-wrapper">
            <?php foreach ( $images as $image): ?>
                <div class="swiper-slide">
                    <figure>
                        <div class="img-wrapper">
                            <?php echo wp_get_attachment_image( $image['ID'], 'full' ); ?>
                        </div>
                        <?php if ( $caption = wp_get_attachment_caption( $image['ID'] ) ): ?>
                            <figcaption>
                                <?php echo nl2br( esc_html ( $caption ) ); ?>
                            </figcaption>
                        <?php endif; ?>
                    </figure>
                </div>
            <?php endforeach; ?>
		</div>
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>
</div>