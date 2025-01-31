<?php

use Beck\Wordpress\ContentElements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'nb/ce/post_register_element/twocol-teaser-list', function ( $element ) {
	$element['sub_fields']['classes_select']['choices']['twocol-md'] = 'MD+: zweispaltig';
	$element['sub_fields']['classes_select']['choices']['swap-columns-md'] = 'MD+: Spalten tauschen';

	$element['sub_fields']['layout']['choices']['layout-4-8'] = '4 : 8';
	$element['sub_fields']['layout']['choices']['layout-8-4'] = '8 : 4';
	$element['sub_fields']['layout']['choices']['layout-5-7'] = '5 : 7';
	$element['sub_fields']['layout']['choices']['layout-7-5'] = '7 : 5';
	$element['sub_fields']['layout']['choices']['layout-5-6'] = '5 : 6';
	$element['sub_fields']['layout']['choices']['layout-6-5'] = '6 : 5';

	return $element;
} );

ContentElements::getInstance()->register(
	'twocol-teaser-list',
	'Zweispalter/Teaserliste links',
	[
		[
			'name'    => 'items',
			'type'    => 'repeater',
            'min'     => 2,
            'max'     => 2,
			'label'   => 'Teaser',
			'layout' => 'block',
            'wrapper' => [ 'width' => '50' ],
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
		                /*'gradient-bgr' => 'Verlauf auf dem Bild',*/
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
		],
		[
			'name'    => 'content_right',
			'type'    => 'wysiwyg',
			'label'   => 'Inhalt rechts',
			'wrapper' => [ 'width' => '50' ]
		]
	],
	85
);

if ( ContentElements::getInstance()->isInRegistration() ) {
	return;
}

?>
<div class="ce ce-twocol <?php echo implode( ' ', $element['_classes'] ) ?>">
    <div class="container">
        <div class="row">
            <div class="col col-custom-1">
                <div class="teaser-list-home">
	                <?php foreach ( $element['items'] as $item ): ?>
                        <div class="teaser-list-item <?php echo implode( ' ', $item['classes'] ); ?>">
                            <a href="<?php echo esc_attr( $item['link']['url'] ); ?>">
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
            <div class="col col-custom-2">
	            <?php echo $element['content_right'] ?>
            </div>
        </div>
    </div>
</div>
