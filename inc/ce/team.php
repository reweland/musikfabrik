<?php

use Beck\Wordpress\ContentElements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

ContentElements::getInstance()->register(
	'team',
	'Team',
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
                    'wrapper' => [ 'width' => '33']
                ],
				[
					'name' => 'title',
					'type' => 'text',
					'label' => 'Titel',
					'wrapper' => [ 'width' => '33']
				],
                [
                    'name' => 'email',
                    'type' => 'text',
                    'label' => 'E-Mail',
                    'wrapper' => [ 'width' => '34']
                ]
            ]
		]
	],
	90
);

if ( ContentElements::getInstance()->isInRegistration() ) {
	return;
}

?>
<div class="ce ce-team <?php echo implode( ' ', $element['_classes'] ) ?>">
    <div class="container">
        <div class="row">
            <?php foreach ( $element['items'] as $item ): ?>
                <div class="team-member">
                    <figure>
	                    <?php echo wp_get_attachment_image( $item['image']['ID'], 'full' ); ?>
                        <?php if ( $item['title'] ): ?>
                            <figcaption>
	                            <?php if ( $item['email'] ): ?>
                                    <a href="mailto:<?php echo esc_attr( $item['email'] ) ?>">
	                                    <?php echo esc_html( $item['title'] ); ?>
                                    </a>
                                <?php else: ?>
		                            <?php echo esc_html( $item['title'] ); ?>
                                <?php endif; ?>
                            </figcaption>
                        <?php endif; ?>
                    </figure>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
