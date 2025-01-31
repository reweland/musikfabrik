<div class="ce ce-headline pb-medium pt-medium">
	<div class="container">
		<div class="row">
			<div class="col">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</div>

<div class="ce ce-onecol layout-9 pb-medium">
	<div class="container">
		<div class="row">
			<div class="col">

				<?php while ( have_posts() ): the_post(); ?>
					<div class="search-result">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<p><?php the_excerpt(); ?></p>
					</div>
				<?php endwhile; ?>

			</div>
		</div>
	</div>
</div>

<div class="ce ce-onecol pagination">
	<div class="container">
		<div class="row">
			<div class="col">
				<hr>
				<?php the_posts_pagination(); ?>
			</div>
		</div>
	</div>
</div>