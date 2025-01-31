<?php

use Beck\Wordpress\ContentElements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'nb/ce/post_register_element/hero', function ( $element ) {
	$element['sub_fields']['classes_select']['choices']['gradient-bgr'] = 'Verlauf auf dem Bild';

	return $element;
} );

ContentElements::getInstance()->register(
	'hero',
	'Hero',
	[
		[
			'name'    => 'image',
			'type'    => 'image',
			'label'   => 'Bild',
			'wrapper' => [ 'width' => '50' ]
		],
		[
			'name'    => 'caption',
			'type'    => 'textarea',
			'rows'    => 2,
			'label'   => 'Bildunterschrift',
			'wrapper' => [ 'width' => '50' ]
		]
	],
	5
);

if ( ContentElements::getInstance()->isInRegistration() ) {
	return;
}

?>
<div class="ce ce-hero <?php echo implode( ' ', $element['_classes'] ) ?>" <?php echo $element['_effect_atts'] ?>">
    <figure>
        <div class="img-wrapper">
	        <?php echo wp_get_attachment_image( $element['image']['ID'], 'full' ); ?>
        </div>
	    <?php if ( $element['caption'] ): ?>
            <figcaption>
                <div class="ce-hero-caption">
                    <span class="bar-style"><?php echo nl2br( esc_html( $element['caption'] ) ); ?></span>
                </div>
            </figcaption>
        <?php endif; ?>
    </figure>
</div>
