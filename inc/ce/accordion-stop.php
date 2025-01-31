<?php

use Beck\Wordpress\ContentElements;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

ContentElements::getInstance()->register(
	'accordion-stop',
	'Ende des Akkordeons',
	[
	],
	101
);

if ( ContentElements::getInstance()->isInRegistration() ) {
	return;
}

if ( isset( $GLOBALS['in_accordion'] ) && $GLOBALS['in_accordion'] ) {
	echo '</div></div></div></div></div></div></div></div>';
	$GLOBALS['in_accordion'] = false;
}
