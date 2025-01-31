<?php if ( ! is_user_logged_in() ): ?>
    <h2><?php _e( 'Passwort vergessen', 'mufa' ); ?></h2>
    <?php if ( isset( $_POST['lostpassword'] ) ): ?>
        <p><?php _e( 'Ihr Passwort wurde zurückgesetzt. Bitte folgenden Sie den Anweisungen in der E-Mail, die wir Ihnen geschickt haben.', 'mufa' ); ?></p>
    <?php endif; ?>
    <form action="<?php the_permalink(); ?>" method="POST">
        <div class="form-row">
            <input type="text" name="user_login" id="user_login" placeholder="<?php _e( 'Benutzername oder E-Mail-Adresse', 'mufa' ); ?>" size="40" required>
        </div>
        <div class="form-row">
            <input type="submit" name="lostpassword" value="<?php _e( 'Absenden', 'mufa' ); ?>">
        </div>
    </form>
<?php endif;