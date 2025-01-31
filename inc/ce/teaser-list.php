<?php

use Beck\Wordpress\ContentElements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

ContentElements::getInstance()->register(
	'teaser-list',
	'Teaserliste',
	[
		[
			'name'    => 'items',
			'type'    => 'repeater',
			'label'   => 'Teaser',
			'layout' => 'block',
			'sub_fields' => [
			    [
			        'name' => 'image',
                    'type' => 'image',
                    'label' => 'Bild',
                    'wrapper' => [ 'width' => '34']
                ],
				[
			        'name' => 'link',
                    'type' => 'link',
                    'label' => 'Link',
			        'wrapper' => [ 'width' => '33']
                ],
                [
	                'name'    => 'classes',
	                'type'    => 'checkbox',
	                'layout'  => 'horizontal',
	                'label'   => 'Darstellung',
	                'choices' => [
		                'gradient-bgr' => 'Verlauf auf dem Bild',
                        'gradient-border' => 'Rahmen um das Bild'
	                ],
	                'wrapper' => [ 'width' => '33' ]
                ],
				[
					'name' => 'title',
					'type' => 'text',
					'label' => 'Titel',
					'wrapper' => [ 'width' => '50']
				],
				[
					'name' => 'subtitle',
					'type' => 'text',
					'label' => 'Subtitel',
					'wrapper' => [ 'width' => '50']
				]
            ]
		]
	],
	80
);

if ( ContentElements::getInstance()->isInRegistration() ) {
	return;
}

?>
<div class="ce ce-teaser-list <?php echo implode( ' ', $element['_classes'] ) ?>">
    <div class="container">
        <div class="row">
            <?php foreach ( $element['items'] as $item ): ?>
                <div class="teaser-list-item <?php echo implode( ' ', $item['classes'] ); ?>">
                    <a href="<?php echo esc_attr( $item['link']['url'] ); ?>" target="<?php echo esc_attr( $item['link']['target'] ); ?>">
                        <figure>
                            <div class="img-wrapper">
                                <?php echo wp_get_attachment_image( $item['image']['ID'], 'full' ); ?>
                            </div>
                            <figcaption>
                                <?php if ( $item['title'] ): ?>
                                    <h2 class="teaser-title"><span class="bar-style"><?php echo esc_html( $item['title'] ); ?></span></h2>
                                <?php endif; ?>
                                <?php if ( $item['subtitle'] ): ?>
                                    <p class="teaser-subtitle"><span class="bar-style"><?php echo esc_html( $item['subtitle'] ); ?></span></p>
                                <?php endif; ?>
                            </figcaption>
                        </figure>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
