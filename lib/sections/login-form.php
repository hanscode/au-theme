<?php if ( ! is_user_logged_in() ) { ?>

	<div id="login">
		
		<div id="gp-login-modal">
			
			<div id="gp-login-close"></div>
			
			<h3 class="gp-login-title"><?php esc_html_e( 'Login', 'socialize' ); ?></h3>
			<h3 class="gp-lost-password-title"><?php esc_html_e( 'Lost Password', 'socialize' ); ?></h3>
			<h3 class="gp-register-title"><?php esc_html_e( 'Register', 'socialize' ); ?></h3>

			<?php echo do_shortcode( '[login]' ); ?>
		
		</div>
			
	</div>
	
<?php } ?>