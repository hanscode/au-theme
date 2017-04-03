<?php
/*
Template Name: Link
*/
get_header(); ?>

<?php if ( have_posts() ) : the_post();
	
	$gp_link = ghostpool_option( 'link_template_link' );
	
	if ( ! preg_match( '/^http:\/\//', $gp_link ) ) {
		$gp_link = 'http://' . $gp_link;
	}

	esc_url_raw( wp_redirect( $gp_link ) );
	exit();

endif; ?>

<?php get_footer(); ?>