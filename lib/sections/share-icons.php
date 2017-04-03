<div id="gp-share-icons">

	<h3><?php esc_html_e( 'Share This Post', 'socialize' ); ?></h3>

	<div class="gp-share-icons">
	
		<a href="https://twitter.com/share?text=<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>&url=<?php echo urlencode( get_permalink( get_the_ID() ) ); ?>" title="<?php esc_attr_e( 'Tweet This Post', 'socialize' ); ?>" class="gp-share-twitter" onclick="window.open(this.href, 'gpwindow', 'left=50,top=50,width=600,height=350,toolbar=0'); return false;"></a>	
	
		<a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode( get_permalink( get_the_ID() ) ); ?>&t=<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>" title="<?php esc_attr_e( 'Share on Facebook', 'socialize' ); ?>" class="gp-share-facebook" onclick="window.open(this.href, 'gpwindow', 'left=50,top=50,width=600,height=350,toolbar=0'); return false;"></a>
	
		<a href="https://plusone.google.com/_/+1/confirm?hl=en-US&url=<?php echo urlencode( get_permalink( get_the_ID() ) ); ?>" title="<?php esc_attr_e( 'Share on Google+', 'socialize' ); ?>" class="gp-share-google-plus" onclick="window.open(this.href, 'gpwindow', 'left=50,top=50,width=600,height=350,toolbar=0'); return false;"></a>

		<?php if ( isset( $GLOBALS['ghostpool_page_header_bg_css'] ) OR ( has_post_thumbnail() && ( isset( $GLOBALS['ghostpool_featured_image'] ) && $GLOBALS['ghostpool_featured_image'] == 'enabled' ) )  ) {	
			if ( isset( $GLOBALS['ghostpool_page_header_bg_css'] ) && $GLOBALS['ghostpool_page_header_bg_css'] ) {
				preg_match_all( '~\bbackground(-image)?\s*:(.*?)\(\s*(\'|")?(?<image>.*?)\3?\s*\)~i', $GLOBALS['ghostpool_page_header_bg_css'], $gp_matches );
				$gp_image = $gp_matches['image'];
				$gp_pinterest_image = $gp_image[0];
			} else {
				$gp_pinterest_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
			} ?>
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink( get_the_ID() ) ); ?>&media=<?php echo esc_url( $gp_pinterest_image ); ?>&description=<?php echo esc_attr( get_the_title( get_the_ID() ) ); ?>" count-layout="vertical" class="gp-share-pinterest" target="_blank"></a>	
		<?php } ?>
	
	</div>
	
</div>