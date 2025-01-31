<div class="ce ce-onecol pb-medium">
	<div class="container">
		<div class="row">
			<div class="col">
				<ul class="post-footer">
					<li><?php _e( 'Autor', 'mufa' ); ?>: <?php echo \Beck\Mufa\Tools::csterms( 'mufa_post_author' ); ?></li>
					<li>Kategorien: <?php the_category(', '); ?></li>
					<li>Schlagworte: <?php the_tags( '' ); ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>