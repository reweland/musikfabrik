<?php

while ( have_posts() ) {

	the_post();

	get_template_part( 'template-parts/cd/detail/header' );

	get_template_part( 'template-parts/cd/detail/contents' );
}