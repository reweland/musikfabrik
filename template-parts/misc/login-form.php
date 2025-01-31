<?php if ( is_user_logged_in() ): ?>
	<p><?php _e( 'Angemeldet als', 'mufa' ); ?> <?php echo esc_html( wp_get_current_user()->user_login ); ?></p>
	<p><a href="<?php echo wp_logout_url( get_permalink() ); ?>"><?php _e( 'Abmelden', 'mufa' ); ?></a></p>
<?php else: ?>
	<?php if ( isset( $_POST['fe_login'] ) ): ?>
        <p><?php _e( 'Die angegebenen Zugangsdaten sind nicht korrekt.', 'mufa' ); ?></p>
    <?php endif; ?>
    <h2><?php _e( 'Login', 'mufa' ); ?></h2>
    <form action="<?php the_permalink(); ?>" method="POST">
		<div class="form-row">
			<input type="text" name="log" id="log" placeholder="<?php _e( 'Benutzername', 'mufa' ); ?>" size="40" required>
		</div>
		<div class="form-row">
			<input type="password" name="pwd" id="pwd" placeholder="<?php _e( 'Passwort', 'mufa' ); ?>" size="40" required>
		</div>
		<div class="form-row">
			<input type="submit" name="fe_login" value="<?php _e( 'Absenden', 'mufa' ); ?>">
		</div>
	</form>
<?php endif;