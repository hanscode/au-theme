<?php

if ( ! function_exists( 'ghostpool_recent_posts' ) ) {
	function ghostpool_recent_posts() {
		register_widget( 'GhostPool_Recent_Posts' );
	}
}
add_action( 'widgets_init', 'ghostpool_recent_posts' );

class GhostPool_Recent_Posts extends WP_Widget {
	
	function __construct() {
		$gp_widget_ops = array( 'classname' => 'gp-recent-posts', 'description' => esc_html__( 'Your site\'s most recent posts with thumbnails.', 'socialize' ) );
		parent::__construct( 'gp-recent-posts-widget', esc_html__( 'GP Recent Posts', 'socialize' ), $gp_widget_ops );
	}

	function widget( $gp_args, $gp_instance ) {
		
		global $date_range;
		extract( $gp_args );
		$gp_title = apply_filters( 'widget_title', empty( $gp_instance['title'] ) ? esc_html__( 'Recent Posts', 'socialize' ) : $gp_instance['title'] );
        $gp_posts = empty( $gp_instance['posts'] ) ? '5' : $gp_instance['posts'];
        $gp_show_date = $gp_instance['show_date'] ? '1' : '0';
        $gp_show_views = $gp_instance['show_views'] ? '1' : '0';
	
		echo html_entity_decode( $before_widget );	
			
		?>

		<?php if ( $gp_title ) { echo html_entity_decode( $before_title . $gp_title . $after_title ); } ?>
	
		<?php 

		$gp_args = array( 
			'post_type'           => 'post',
			'posts_per_page'      => $gp_posts,
			'ignore_sticky_posts' => true,
		);

		$gp_query = new wp_query( $gp_args ); ?>
					
		<div class="gp-blog-wrapper gp-blog-standard">
		
			<?php if ( $gp_query->have_posts() ) : ?>
			
				<div class="gp-inner-loop">
			
					<?php while ( $gp_query->have_posts() ) : $gp_query->the_post(); ?>
	
						<section <?php post_class( 'gp-post-item' ); ?>>

							<?php if ( has_post_thumbnail() ) { ?>
										
								<div class="gp-post-thumbnail">
								
									<div class="gp-image-align-left">
								
										<?php $gp_image = aq_resize( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ), 100, 80, true, false, true ); ?>
										<?php if ( ghostpool_option( 'retina' ) == 'gp-retina' ) {
											$gp_retina = aq_resize( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ), 100 * 2, 80 * 2, true, true, true );
										} else {
											$gp_retina = '';
										} ?>
									
										<a href="<?php if ( get_post_format() == 'link' ) { echo esc_url( get_post_meta( get_the_ID(), 'link', true ) ); } else { the_permalink(); } ?>" title="<?php the_title_attribute(); ?>"<?php if ( get_post_format() == 'link' ) { ?> target="<?php echo get_post_meta( get_the_ID(), 'link_target', true ); ?>"<?php } ?>>

											<img src="<?php echo esc_url( $gp_image[0] ); ?>" data-rel="<?php echo esc_url( $gp_retina );; ?>" width="<?php echo absint( $gp_image[1] ); ?>" height="<?php echo absint( $gp_image[2] ); ?>" alt="<?php if ( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ) { echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); } else { the_title_attribute(); } ?>" class="gp-post-image" />
										
										</a>
									
									</div>
																
								</div>		

							<?php } ?>

							<div class="gp-loop-content">
														
								<h3 class="gp-loop-title" itemprop="headline"><a href="<?php if ( get_post_format() == 'link' ) { echo esc_url( get_post_meta( get_the_ID(), 'link', true ) ); } else { the_permalink(); } ?>" title="<?php the_title_attribute(); ?>"<?php if ( get_post_format() == 'link' ) { ?> target="<?php echo get_post_meta( get_the_ID(), 'link_target', true ); ?>"<?php } ?>><?php the_title(); ?></a></h3>

								<?php if ( $gp_show_date OR $gp_show_views ) { ?>
									<div class="gp-loop-meta">
										<?php if ( $gp_show_date ) { ?><time class="gp-post-meta gp-meta-date" itemprop="datePublished" datetime="<?php echo get_the_date( 'c' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time><?php } ?>
										<?php if ( function_exists( 'pvc_get_post_views' ) && $gp_show_views ) { ?><span class="gp-post-meta gp-meta-views"><?php echo pvc_get_post_views(); ?> <?php esc_html_e( 'views', 'socialize' ); ?></span><?php } ?>	
									</div>
								<?php } ?>
							
							</div>
													
						</section>

					<?php endwhile; ?>
					
				</div>
		
			<?php else : ?>

				<strong class="gp-no-items-found"><?php esc_html_e( 'No items found.', 'socialize' ); ?></strong>

			<?php endif; wp_reset_postdata(); ?>
							
		</div>

		<?php echo html_entity_decode( $after_widget );

	}

	function update( $gp_new_instance, $gp_old_instance ) {
		$gp_instance = $gp_old_instance;
		$gp_instance['title'] = strip_tags( $gp_new_instance['title'] );
		$gp_instance['posts'] = $gp_new_instance['posts'];
		$gp_instance['show_date'] = $gp_new_instance['show_date'];	
		$gp_instance['show_views'] = $gp_new_instance['show_views'];						
		return $gp_instance;
	}

	function form( $gp_instance ) {
		
		$gp_defaults = array( 
			'title'     => 'Recent Posts',
			'posts'     => 5,
			'show_date' => 1,
			'show_views' => 0,
		 ); $gp_instance = wp_parse_args( ( array ) $gp_instance, $gp_defaults ); ?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'socialize' ); ?></label>
			<br/><input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $gp_instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'socialize' ); ?></label> <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts' ) ) ?>" value="<?php echo esc_attr( $gp_instance['posts'] ); ?>" size="3" />
		</p>
			
		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" value="1" <?php checked( $gp_instance['show_date'], 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Display post date?', 'socialize' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_views' ) ); ?>" value="1" <?php checked( $gp_instance['show_views'], 1 ); ?> /><label for="<?php echo esc_attr( $this->get_field_id( 'show_views' ) ); ?>"><?php esc_html_e( 'Display post views?', 'socialize' ); ?></label>
		</p>
							
		<input type="hidden" name="widget-options" id="widget-options" value="1" />

		<?php

	}
}

?>