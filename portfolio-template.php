<?php
/*
Template Name: Portfolio
*/
get_header();

// Load page variables		
ghostpool_loop_variables();
ghostpool_category_variables();

?>

<?php if ( $GLOBALS['ghostpool_page_header'] == 'gp-fullwidth-page-header' OR $GLOBALS['ghostpool_page_header'] == 'gp-full-page-page-header' ) { ghostpool_page_header( get_the_ID() ); } ?>

<div id="gp-content-wrapper" class="gp-container">

	<?php if ( $GLOBALS['ghostpool_page_header'] == 'gp-large-page-header' ) { ghostpool_page_header( get_the_ID() ); } ?>

	<div id="gp-inner-container">

		<div id="gp-left-column">
	
			<div id="gp-content">

				<?php ghostpool_breadcrumbs(); ?>
		
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>	

					<?php if ( $GLOBALS['ghostpool_title'] == 'enabled' ) { ?>	
						<header class="gp-entry-header">	

							<h1 class="gp-entry-title" itemprop="headline">
								<?php if ( ! empty( $GLOBALS['ghostpool_custom_title'] ) ) { echo esc_attr( $GLOBALS['ghostpool_custom_title'] ); } else { the_title(); } ?>
							</h1>

							<?php if ( ! empty( $GLOBALS['ghostpool_subtitle'] ) ) { ?>
								<h3 class="gp-subtitle"><?php echo esc_attr( $GLOBALS['ghostpool_subtitle'] ); ?></h3>
							<?php } ?>
			
						</header>
					<?php } ?>
					
					<?php the_content(); ?>
		
				<?php endwhile; endif; rewind_posts(); ?>			

				<?php
					
				$gp_args = array(
					'post_status'         => 'publish',
					'post_type'           => 'gp_portfolio_item',
					'tax_query'           => $GLOBALS['ghostpool_tax'],
					'posts_per_page'      => $GLOBALS['ghostpool_per_page'],
					'orderby'             => $GLOBALS['ghostpool_orderby_value'],
					'order'               => $GLOBALS['ghostpool_order'],
					'paged'               => $GLOBALS['ghostpool_paged'],
					'date_query'          => array( $GLOBALS['ghostpool_date_posted_value'], $GLOBALS['ghostpool_date_modified_value'] ),	
				);

				$gp_query = new wp_query( $gp_args ); ?>

				<div id="gp-portfolio" class="gp-portfolio-wrapper <?php echo sanitize_html_class( $GLOBALS['ghostpool_format'] ); ?>">		

					<?php if ( $gp_query->have_posts() ) : ?>

						<?php if ( $GLOBALS['ghostpool_filter'] == 'enabled' ) { ?>
							<div id="gp-portfolio-filters" class="gp-portfolio-filters">
								<ul>
								   <li><a href="#" data-filter="*" class="gp-active"><?php echo esc_html__( 'All', 'socialize' ); ?></a></li>
									<?php 
									$gp_terms = get_terms( 'gp_portfolios' );
									$gp_cat_array = explode( ',', $GLOBALS['ghostpool_cats'] );
									if ( !empty( $gp_terms ) ) {
										foreach ( $gp_terms as $gp_term ) {
											if ( ! empty( $gp_cat_array[0] ) ) {
												foreach( $gp_cat_array as $gp_cat ) {							
													if ( $gp_term->term_id == $gp_cat ) {
														echo '<li><a href="#" data-filter=".' . sanitize_title( $gp_term->slug ) . '">' . esc_attr( $gp_term->name ). '</a></li>';
													}	
												}
											} else {
												echo '<li><a href="#" data-filter=".' . sanitize_title( $gp_term->slug ) . '">' . esc_attr( $gp_term->name ). '</a></li>';
											}	
										}
									}
									?>
								</ul>
							</div>
						<?php } ?>
	
						<div class="gp-inner-loop">
							
							<div class="gp-gutter-size"></div>
								
							<?php while ( $gp_query->have_posts() ) : $gp_query->the_post(); ?>

								<?php get_template_part( 'portfolio', 'loop' ); ?>

							<?php endwhile; ?>
		
						</div>
					
						<?php echo ghostpool_pagination( $gp_query->max_num_pages ); ?>

					<?php else : ?>

						<strong class="gp-no-items-found"><?php esc_html_e( 'No items found.', 'socialize' ); ?></strong>

					<?php endif; wp_reset_postdata(); ?>
	
				</div>

			</div>
		
			<?php get_sidebar( 'left' ); ?>
		
		</div>	

		<?php get_sidebar( 'right' ); ?>
	
	</div>
	
	<div class="gp-clear"></div>

</div>

<?php get_footer(); ?>