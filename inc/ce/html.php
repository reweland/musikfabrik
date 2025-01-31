<?php

if (!defined('ABSPATH')) exit;

add_filter('nb/ce/post_register_element/html', function ($element) {
	unset($element['sub_fields']['classes_select']);
	unset($element['sub_fields']['classes_custom']);
	unset($element['sub_fields']['indentation']);
	unset($element['sub_fields']['background_color']);
	unset($element['sub_fields']['bottom_spacer']);
	unset($element['sub_fields']['top_spacer']);
	unset($element['sub_fields']['layout']);

	return $element;
});

\Beck\Wordpress\ContentElements::getInstance()->register(
	'html',
	'HTML-Code',
	[
		[
			'name'      => 'content',
			'type'      => 'textarea',
			'label'     => 'HTML code'
		]
	],
	130
);

if (\Beck\Wordpress\ContentElements::getInstance()->isInRegistration())
{
	return;
}

?>
<?php echo do_shortcode($element['content']);