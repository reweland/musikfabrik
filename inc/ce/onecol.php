<?php

use Beck\Wordpress\ContentElements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'nb/ce/post_register_element/onecol', function ( $element ) {
	$element['sub_fields']['layout']['choices']['layout-6'] = 'LG+: 6 Spalten';
	$element['sub_fields']['layout']['choices']['layout-8'] = 'LG+: 8 Spalten';
	$element['sub_fields']['layout']['choices']['layout-9'] = 'LG+: 9 Spalten';

	$element['sub_fields']['layout']['choices']['align-center'] = 'zentriert';
	$element['sub_fields']['layout']['choices']['align-right'] = 'rechtsbündig';

	return $element;
} );

ContentElements::getInstance()->register(
	'onecol',
	'Einspaltiger Inhalt',
	[
		[
			'name'  => 'content',
			'type'  => 'wysiwyg',
			'label' => 'Inhalt'
		]
	],
	20
);

if ( ContentElements::getInstance()->isInRegistration() ) {
	return;
}

?>
<div class="ce ce-onecol <?php echo implode( ' ', $element['_classes'] ) ?>" <?php echo $element['_effect_atts'] ?>>
    <div class="container">
        <div class="row">
            <div class="col">
				<?php echo $element['content'] ?>
            </div>
        </div>
    </div>
</div>
