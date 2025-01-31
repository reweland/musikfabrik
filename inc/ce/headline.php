<?php

use Beck\Wordpress\ContentElements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'nb/ce/post_register_element/headline', function ( $element ) {
	$element['sub_fields']['layout']['choices']['layout-6'] = 'LG+: 6 Spalten';
	$element['sub_fields']['layout']['choices']['layout-8'] = 'LG+: 8 Spalten';
	$element['sub_fields']['layout']['choices']['layout-9'] = 'LG+: 9 Spalten';

	$element['sub_fields']['layout']['choices']['align-center'] = 'zentriert';
	$element['sub_fields']['layout']['choices']['align-right'] = 'rechtsbündig';

	return $element;
} );

ContentElements::getInstance()->register(
	'headline',
	'Überschrift',
	[
		[
			'name'    => 'type',
			'type'    => 'select',
			'label'   => 'Typ',
			'choices' => [
				'h1' => 'H1',
				'h2' => 'H2',
				'h3' => 'H3',
				'h4' => 'H4'
			],
			'wrapper' => [ 'width' => '25' ]
		],
		[
			'name'    => 'headline',
			'label'   => 'Überschrift',
			'type'    => 'textarea',
			'rows'    => 2,
			'wrapper' => [ 'width' => '75' ]
		]
	],
	10
);

if ( ContentElements::getInstance()->isInRegistration() ) {
	return;
}

?>
<div class="ce ce-headline <?php echo implode( ' ', $element['_classes'] ) ?>">
    <div class="container">
        <div class="row">
            <div class="col">
				<?php printf( '<%s>%s</%s>', $element['type'], nl2br( esc_html( $element['headline'] ) ), $element['type'] ); ?>
            </div>
        </div>
    </div>
</div>
