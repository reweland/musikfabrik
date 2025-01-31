<div class="posts">
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
                                <p class="teaser-date">
                                    <span class="date-day"><?php echo get_the_date( 'd' ); ?></span>
                                    <span class="date-month"><?php echo get_the_date( 'm' ); ?></span>
                                    <span class="date-year"><?php echo get_the_date( 'Y' ); ?></span>
                                </p>
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