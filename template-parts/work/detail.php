<?php

while ( have_posts() ) {

	the_post();

	get_template_part( 'template-parts/work/detail/header' );

	get_template_part( 'template-parts/work/detail/contents' );
}