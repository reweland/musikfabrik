<?php

use Beck\Wordpress\ContentElements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'nb/ce/post_register_element/twocol', function ( $element ) {
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
	'twocol',
	'Zweispaltiger Inhalt',
	[
		[
			'name'    => 'content_left',
			'type'    => 'wysiwyg',
			'label'   => 'Inhalt links',
			'wrapper' => [ 'width' => '50' ]
		],
		[
			'name'    => 'content_right',
			'type'    => 'wysiwyg',
			'label'   => 'Inhalt rechts',
			'wrapper' => [ 'width' => '50' ]
		]
	],
	30
);

if ( ContentElements::getInstance()->isInRegistration() ) {
	return;
}

?>
<div class="ce ce-twocol <?php echo implode( ' ', $element['_classes'] ) ?>" <?php echo $element['_effect_atts'] ?>>
    <div class="container">
        <div class="row">
            <div class="col col-custom-1">
				<?php echo $element['content_left'] ?>
            </div>
            <div class="col col-custom-2">
				<?php echo $element['content_right'] ?>
            </div>
        </div>
    </div>
</div>
