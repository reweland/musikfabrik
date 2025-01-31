<?php

use Beck\Wordpress\ContentElements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'nb/ce/post_register_element/accordion-start', function ( $element ) {
	$element['sub_fields']['classes_select']['choices']['accordion-large'] = 'große Headline';

	return $element;
} );

ContentElements::getInstance()->register(
	'accordion-start',
	'Neuer Akkordeonreiter',
	[
		[
			'name'  => 'headline',
			'label' => 'Überschrift',
			'type'  => 'textarea',
			'rows'  => 2
		]
	],
	100
);

add_filter( 'nb/ce/post_render_elements', function ( $content ) {
	ob_start();
	include 'accordion-stop.php';
	$content .= ob_get_clean();

	return $content;
} );

if ( ContentElements::getInstance()->isInRegistration() ) {
	return;
}

if ( isset( $GLOBALS['in_accordion'] ) && $GLOBALS['in_accordion'] ) {
	echo '</div></div></div>';
} else {
	$classes = implode( ' ', $element['_classes'] );
	echo <<<EOF
<div class="ce ce-accordion ${classes}">
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="accordion">
EOF;
}

$GLOBALS['in_accordion'] = true;

?>
<div class="accordion-panel" data-panel-id="<?php echo sanitize_title( $element['headline'] ) ?>">
    <div class="accordion-headline">
        <div class="accordion-headline-inner">
            <h4><?php echo nl2br( esc_html( $element['headline'] ) ) ?><span class="accordion-toggle-btn"></span></h4>
        </div>
    </div>
    <div class="accordion-content">
        <div class="accordion-content-inner">