<?php

while ( have_posts() ) {

	the_post();

	get_template_part( 'template-parts/event/detail/contents' );

}
