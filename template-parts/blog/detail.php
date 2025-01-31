<?php

while ( have_posts() ) {

	the_post();

	get_template_part( 'template-parts/blog/detail/header' );

	the_content();

	get_template_part( 'template-parts/blog/detail/footer' );

}

