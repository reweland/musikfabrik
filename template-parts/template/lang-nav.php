<?php

$langs    = apply_filters( 'wpml_active_languages', '' );
$cur_lang = array_values( array_filter( $langs, function ( $l ) {
	return ! ! $l['active'];
} ) )[0];

?>
<li class="nav-meta-language">
	<ul>
		<?php
            foreach ( $langs as $lang ) {
                echo sprintf(
                    '<li class="%s"><a href="%s">%s</a></li>',
                    $lang == $cur_lang ? 'selected' : '',
                    esc_attr( $lang['url'] ),
                    $lang['language_code']
                );
            }
		?>
	</ul>
</li>