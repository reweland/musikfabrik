<div class="posts posts-digital">
	<div class="container">
		<div class="row">
			<?php while ( have_posts() ): the_post(); ?>
				<div class="post-teaser">
					<a href="<?php the_permalink(); ?>">
						<figure>
							<div class="img-wrapper">
								<?php the_post_thumbnail( 'full' ); ?>
							</div>
							<figcaption>
								<h3 class="teaser-title"><?php the_title(); ?></h3>
								<div class="teaser-excerpt"><?php the_excerpt(); ?></div>
							</figcaption>
						</figure>
					</a>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
</div>