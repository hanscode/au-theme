<?php if ( ! is_user_logged_in() && ghostpool_option( 'popup_box' ) == 'enabled' ) {

	global $wpdb;

	/*--------------------------------------------------------------
	Login
	--------------------------------------------------------------*/

	if ( isset( $_POST['action'] ) && $_POST['action'] == 'ghostpool_login' ) {

		$gp_username = esc_sql( $_REQUEST['log'] );
		$gp_password = esc_sql( $_REQUEST['pwd'] );
		$gp_remember = esc_sql( $_REQUEST['rememberme'] );

		if ( $gp_remember ) { 
			$gp_remember = 'true'; 
		} else {
			$gp_remember = 'false'; 
		}
		
		$gp_login_data = array();
		
		$gp_captcha = apply_filters( 'cptch_verify', true );

		if ( true === $gp_captcha OR ! has_filter( 'cptch_verify' ) ) {
			$gp_login_data['user_login'] = $gp_username;
			$gp_login_data['user_password'] = $gp_password;
			$gp_login_data['remember'] = $gp_remember;
			$gp_user_verify = wp_signon( $gp_login_data, false ); 
		}					
	
		if ( empty( $_POST['log'] ) && empty( $_POST['pwd'] ) ) {
			echo "<span class='error'>" . esc_html__( 'Please enter your username and password.', 'socialize' ) . "</span>";
			exit();
		} elseif ( empty( $_POST['log'] ) ) {
			echo "<span class='error'>" . esc_html__( 'Please enter your username.', 'socialize' ) . "</span>";
			exit();
		} elseif ( empty( $_POST['pwd'] ) ) {
			echo "<span class='error'>" . esc_html__( 'Please enter your password.', 'socialize' ) . "</span>";
			exit();
		}
		
		// Get user data from username
		$gp_user_data = get_user_by( 'login', $gp_username );
		
		// If username does not exists, look for email login instead
		if ( empty( $gp_user_data ) ) { 
			$gp_user_data = get_user_by( 'email', $gp_username ); 
		}
		
		if ( true !== $gp_captcha && has_filter( 'cptch_verify' ) ) {
			echo "<span class='error'>" . esc_html__( 'Please complete the CAPTCHA.', 'socialize' ) . "</span>";	
			exit();
		} elseif ( empty( $gp_user_data ) && is_wp_error( $gp_user_verify ) ) {
			echo "<span class='error'>" . esc_html__( 'Invalid username and password.', 'socialize' ) . "</span>";
			exit();
		} elseif ( ! empty( $gp_user_data ) && is_wp_error( $gp_user_verify ) ) {
			echo "<span class='error'>" . esc_html__( 'Invalid password.', 'socialize' ) . "</span>";
			exit();   
		} else {	
			echo apply_filters( 'gp_redirect_filter', '<script data-cfasync="false" type="text/javascript">window.location.reload();</script>', $gp_user_data );
			exit();
		}

	}
	

	/*--------------------------------------------------------------
	Register
	--------------------------------------------------------------*/

	if ( isset( $_POST['action'] ) && $_POST['action'] == 'ghostpool_register' ) {

		$gp_info = array();
		$gp_info['user_nicename'] = $gp_info['nickname'] = $gp_info['display_name'] = $gp_info['first_name'] = $gp_info['user_login'] = sanitize_user( $_POST['user_login'] );
		$gp_info['user_pass'] = sanitize_text_field( $_POST['user_pass'] );
		$gp_info['user_email'] = sanitize_email( $_POST['user_email'] );

		$gp_captcha = apply_filters( 'cptch_verify', true );

		if ( empty( $_POST['user_login'] ) OR empty( $_POST['user_pass'] ) OR empty( $_POST['user_confirm_pass'] ) OR empty( $_POST['user_email'] ) ) {
			$gp_user_register = '';
			echo "<span class='error'>" . esc_html__( 'Please complete all fields.', 'socialize' ) . "</span>";
			exit();
		} elseif ( true !== $gp_captcha && has_filter( 'cptch_verify' ) ) {
			$gp_user_register = '';
			echo "<span class='error'>" . esc_html__( 'Please complete the CAPTCHA.', 'socialize' ) . "</span>";
			exit();
		} elseif ( $_POST['user_pass'] !== $_POST['user_confirm_pass'] ) {
			$gp_user_register = '';
			echo "<span class='error'>" . esc_html__( 'Your passwords do not match.', 'socialize' ) . "</span>";
			exit();
		} else {
			$gp_user_register = wp_insert_user( $gp_info );
		}
	
 		if ( is_wp_error( $gp_user_register ) ) {	
			$gp_error = $gp_user_register->get_error_codes();
			if ( in_array( 'empty_user_login', $gp_error ) ) {
				echo "<span class='error'>" . $gp_user_register->get_error_message( 'empty_user_login' ) . "</span>";	
				exit();
			} elseif ( in_array( 'existing_user_login', $gp_error ) ) {
				echo "<span class='error'>" . esc_html__( 'This username is already registered.', 'socialize' ) . "</span>";	
				exit();
			} elseif ( in_array( 'existing_user_email', $gp_error ) ) {
				echo "<span class='error'>" . esc_html__( 'This email address is already registered.', 'socialize' ) . "</span>";	
				exit(); 
			}
		} else {
			wp_new_user_notification( $gp_user_register, null, 'both' );
			echo "<span class='gp-success'>" . esc_html__( 'An email has been sent with your details.', 'socialize' ) . "</span>";	
			exit(); 
		}

	}
	
		
	/*--------------------------------------------------------------
	Lost Password
	--------------------------------------------------------------*/

	// Determine whether URL uses ? or &
	function ghostpool_validate_url() {
		global $post;
		$gp_page_url = esc_url( home_url() );
		$gp_urlget = strpos( $gp_page_url, '?' );
		if ( $gp_urlget === false ) {
			$gp_concate = "?";
		} else {
			$gp_concate = "&";
		}
		return $gp_page_url . $gp_concate;
	}
	
	if ( isset( $_GET['key'] ) && isset( $_GET['action'] ) && $_GET['action'] == 'reset_pwd' ) {
	
		$gp_reset_key = $_GET['key'];
		$gp_user_login = $_GET['login'];
		$gp_user_data = $wpdb->get_row( $wpdb->prepare( "SELECT ID, user_login, user_email FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $gp_reset_key, $gp_user_login ) );
	
		$gp_user_login = $gp_user_data->user_login;
		$gp_user_email = $gp_user_data->user_email;
	
		if ( ! empty( $gp_reset_key ) && ! empty( $gp_user_data ) ) {
		
			$gp_new_password = wp_generate_password( 7, false );
			wp_set_password( $gp_new_password, $gp_user_data->ID );
			$gp_message = esc_html__( 'Your new password for the account at:', 'socialize' ) . "\r\n\r\n";
			$gp_message .= get_option( 'siteurl' ) . "\r\n\r\n";
			$gp_message .= sprintf( esc_html__( 'Username: %s', 'socialize' ), $gp_user_login ) . "\r\n\r\n";
			$gp_message .= sprintf( esc_html__( 'Password: %s', 'socialize' ), $gp_new_password ) . "\r\n\r\n";
		
			if ( $gp_message && ! wp_mail( $gp_user_email, esc_html__( 'Your new password', 'socialize' ), $gp_message ) ) {
				echo "<span class='error'>" . esc_html__( 'Email failed to send for some unknown reason', 'socialize' ) . "</span>";
				exit();
			} else {
				$gp_redirect_to = home_url() . '?action=reset_success';
				wp_safe_redirect( $gp_redirect_to );
				exit();
			}
			
		} else {
		
			exit( 'Not a valid key.' );
			
		}
		
	}

	if ( isset( $_POST['action'] ) && $_POST['action'] == 'ghostpool_lost_password' ) {

		if ( ! wp_verify_nonce( $_POST['gp_pwd_nonce'], 'gp_pwd_nonce' ) ) {
			exit( 'No trick please' );
		}  

		if ( empty( $_POST['user_login'] ) ) {
			echo "<span class='error'>" . esc_html__( 'Please enter your username or email address', 'socialize' ) . "</span>";
			exit();
		}
	
		$gp_user_input = esc_sql( trim( $_POST['user_login'] ) );
	
		if ( strpos( $gp_user_input, '@' ) ) {
			$gp_user_data = get_user_by( 'email', $gp_user_input );
			if ( empty( $gp_user_data ) ) {
				echo "<span class='error'>" . esc_html__( 'Invalid email address', 'socialize' ) . "</span>";
				exit();
			}
		} else {
			$gp_user_data = get_user_by( 'login', $gp_user_input );
			if ( empty( $gp_user_data ) ) {
				echo "<span class='error'>" . esc_html__( 'Invalid username', 'socialize' )."</span>";
				exit();
			}
		}
	
		$gp_user_login = $gp_user_data->user_login;
		$gp_user_email = $gp_user_data->user_email;
	
		// Generate reset key
		$gp_key = $wpdb->get_var( $wpdb->prepare( "SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $gp_user_login ) );
		if ( empty( $gp_key ) ) {
			$gp_key = wp_generate_password( 20, false );
			$wpdb->update( $wpdb->users, array( 'user_activation_key' => $gp_key ), array( 'user_login' => $gp_user_login ) );	
		}
	
		// Send reset pasword email to the user
		$gp_message = esc_html__( 'Someone requested that the password be reset for the following account:', 'socialize' ) . "\r\n\r\n";
		$gp_message .= get_option( 'siteurl' ) . "\r\n\r\n";
		$gp_message .= sprintf( esc_html__( 'Username: %s', 'socialize' ), $gp_user_login ) . "\r\n\r\n";
		$gp_message .= esc_html__( 'If this was a mistake, just ignore this email and nothing will happen.', 'socialize' ) . "\r\n\r\n";
		$gp_message .= esc_html__( 'To reset your password, visit the following address:', 'socialize' ) . "\r\n\r\n";
		$gp_message .= ghostpool_validate_url() . "action=reset_pwd&key=$gp_key&login=" . rawurlencode( $gp_user_login ) . "\r\n\r\n";
		$gp_message .= esc_html__( 'You will receive another email with your new password.', 'socialize' ) . "\r\n"; 
		$gp_message = apply_filters( 'gp_retrieve_password_message', $gp_message, $gp_key, $gp_user_login, $gp_user_data );
	
		// Email sent or not sent notice
		if ( $gp_message && ! wp_mail( $gp_user_email, esc_html__( 'Password reset request', 'socialize' ), $gp_message ) ) {
			echo "<span class='error'>" . esc_html__( 'Email failed to send for some unknown reason.', 'socialize' ) . "</span>";
			exit();
		} else {
			echo "<span class='gp-success'>" . esc_html__( 'We have just sent you an email with instructions to reset your password.', 'socialize' ) . "</span>";
			exit();
		}
	
	}

}

?>