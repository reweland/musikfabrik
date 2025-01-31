<?php

while ( have_posts() ) {

	the_post();

	get_template_part( 'template-parts/digital-issue/detail/header' );

	the_content();

	get_template_part( 'template-parts/digital-issue/detail/footer' );

}

