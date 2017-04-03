<?php
/**
 * Category options
 *
 * @since Socialize 2.9
 */
if ( ! function_exists( 'ghostpool_category_options' ) ) {
	function ghostpool_category_options() {

		global $gp_options;
		
		// Category Options	
		$gp_options[] = array( 
			'id'      => 'page_header',
			'name'    => esc_html__( 'Page Header', 'socialize' ),
			'desc'    => esc_html__( 'The page header on the page.', 'socialize' ),
			'type'    => 'select',
			'tax'     => array( 'category', 'post_tag', 'product_cat', 'product_tag', 'gp_portfolios' ),
			'options' => array( 
				'default' => esc_html__( 'Default', 'socialize' ), 
				'gp-standard-page-header' => esc_html__( 'Standard', 'socialize' ), 
				'gp-large-page-header' => esc_html__( 'Large', 'socialize' ), 
				'gp-fullwidth-page-header' => esc_html__( 'Fullwidth', 'socialize' ), 
				'gp-full-page-page-header' => esc_html__( 'Full Page', 'socialize' ),
			),
			'default' => 'default',
		);

		$gp_options[] = array( 
			'id'      => 'bg_image',
			'name'    => esc_html__( 'Page Header Background', 'socialize' ),
			'desc'    => esc_html__( 'The background of the page header. Enter an image URL that must be uploaded to the Media Library.', 'socialize' ),
			'type'    => 'text',
			'tax'     => array( 'category', 'post_tag', 'product_cat', 'product_tag', 'gp_portfolios' ),
			'default' => '',
		);

		$gp_options[] = array( 
			'id'      => 'layout',
			'name'    => esc_html__( 'Page Layout', 'socialize' ),
			'desc'    => esc_html__( 'The page header on the page.', 'socialize' ),
			'type'    => 'select',
			'tax'     => array( 'category', 'post_tag', 'product_cat', 'product_tag', 'gp_portfolios' ),
			'options' => array( 
				'default' => esc_html__( 'Default', 'socialize' ), 
				'gp-left-sidebar' => esc_html__( 'Left Sidebar', 'socialize' ), 
				'gp-right-sidebar' => esc_html__( 'Right Sidebar', 'socialize' ), 
				'gp-both-sidebars' => esc_html__( 'Both Sidebars', 'socialize' ), 
				'gp-no-sidebar' => esc_html__( 'No Sidebars', 'socialize' ), 
				'gp-fullwidth' => esc_html__( 'Fullwidth', 'socialize' ),
			),
			'default' => 'default',
		);

		$gp_options[] = array( 
			'id'      => 'left_sidebar',
			'name'    => esc_html__( 'Left Sidebar', 'socialize' ),
			'desc'    => esc_html__( 'The left sidebar to display.', 'socialize' ),
			'type'    => 'sidebars',
			'tax'     => array( 'category', 'post_tag', 'product_cat', 'product_tag', 'gp_portfolios' ),
			'options' => array( 
				'default' => esc_html__( 'Default', 'socialize' ),
			),
			'default' => 'default',
		);

		$gp_options[] = array( 
			'id'      => 'right_sidebar',
			'name'    => esc_html__( 'Right Sidebar', 'socialize' ),
			'desc'    => esc_html__( 'The right sidebar to display.', 'socialize' ),
			'type'    => 'sidebars',
			'tax'     => array( 'category', 'post_tag', 'product_cat', 'product_tag', 'gp_portfolios' ),
			'options' => array( 
				'default' => esc_html__( 'Default', 'socialize' ),
			),
			'default' => 'default',
		);

		$gp_options[] = array( 
			'id'      => 'format',
			'name'    => esc_html__( 'Format', 'socialize' ),
			'desc'    => esc_html__( 'The format to display the items in.', 'socialize' ),
			'type'    => 'select',
			'tax'     => array( 'category', 'post_tag' ),
			'options' => array( 
				'default' => esc_html__( 'Default', 'socialize' ), 
				'gp-blog-large' => esc_html__( 'Large', 'socialize' ), 
				'gp-blog-standard' => esc_html__( 'Standard', 'socialize' ), 
				'gp-blog-columns-1' => esc_html__( '1 Column', 'socialize' ),
				'gp-blog-columns-2' => esc_html__( '2 Columns', 'socialize' ), 
				'gp-blog-columns-3' => esc_html__( '3 Columns', 'socialize' ), 
				'gp-blog-columns-4' => esc_html__( '4 Columns', 'socialize' ), 
				'gp-blog-columns-5' => esc_html__( '5 Columns', 'socialize' ), 
				'gp-blog-columns-6' => esc_html__( '6 Columns', 'socialize' ), 
				'gp-blog-masonry' => esc_html__( 'Masonry', 'socialize' ), 
			),
			'default' => 'default',
		);

		$gp_options[] = array( 
			'id'      => 'format',
			'name'    => esc_html__( 'Format', 'socialize' ),
			'desc'    => esc_html__( 'The format to display the items in.', 'socialize' ),
			'type'    => 'select',
			'tax'     => array( 'gp_portfolios' ),
			'options' => array( 
				'default' => esc_html__( 'Default', 'socialize' ),
				'gp-portfolio-columns-2' => esc_html__( '2 Columns', 'socialize' ), 
				'gp-portfolio-columns-3' => esc_html__( '3 Columns', 'socialize' ), 
				'gp-portfolio-columns-4' => esc_html__( '4 Columns', 'socialize' ), 
				'gp-portfolio-columns-5' => esc_html__( '5 Columns', 'socialize' ), 
				'gp-portfolio-columns-6' => esc_html__( '6 Columns', 'socialize' ), 
				'gp-portfolio-masonry' => esc_html__( 'Masonry', 'socialize' ), 
			),
			'default' => 'default',
		); 
		
 	}
}
add_action( 'after_setup_theme', 'ghostpool_category_options', 11 );

// New category options 
if ( ! function_exists( 'ghostpool_add_tax_fields' ) ) {
	function ghostpool_add_tax_fields( $gp_tag ) {		

		global $gp_options;
		
		// Get current screen
		$gp_screen = get_current_screen();

		// Get category option
		if ( isset( $gp_tag->term_id ) ) {
			$gp_term_id = $gp_tag->term_id;
			$gp_term_meta = get_option( "taxonomy_$gp_term_id" );
		} else {
			$gp_term_meta = null;
		}
		
		// Run category options through filter to add custom options
		$gp_options = apply_filters( 'gp_custom_category_options', $gp_options );

		foreach ( $gp_options as $gp_option ) {
		
			switch( $gp_option['type'] ) {
			
				case 'select' :
				
					// Checking what category pages to show this option on
					$gp_add_field = false;
					foreach ( $gp_option['tax'] as $type ) {
						if ( $gp_screen->taxonomy == $type ) {
							$gp_add_field = true;
						}
					}

					if ( $gp_add_field == true ) { ?>
		
						<div class="form-field">
							<label for="category-<?php echo esc_attr( $gp_option['id'] ); ?>"><?php echo esc_attr( $gp_option['name'] ); ?></label>
							<select id="gp_term_meta_<?php echo esc_attr( $gp_option['id'] ); ?>" name="gp_term_meta[<?php echo esc_attr( $gp_option['id'] ); ?>]">
								<?php foreach ( $gp_option['options'] as $key => $option ) { ?>
									<?php if ( $gp_term_meta[$gp_option['id']] != '' ) { ?>
										<option value="<?php echo esc_attr( $key ); ?>" <?php if ( $gp_term_meta[$gp_option['id']] == $key ) { echo ' selected="selected"'; } ?>><?php echo esc_attr( $option ); ?></option>
									<?php } else { ?>
										<option value="<?php echo esc_attr( $key ); ?>" <?php if ( $gp_option['default'] == $key ) { echo ' selected="selected"'; } ?>><?php echo esc_attr( $option ); ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<p class="description"><?php echo esc_attr( $gp_option['desc'] ); ?></p>
						</div>
			
					<?php }
					
				break;

				case 'sidebars' :
			
					// Checking what category pages to show this option on
					$gp_add_field = false;
					foreach ( $gp_option['tax'] as $type ) {
						if ( $gp_screen->taxonomy == $type ) {
							$gp_add_field = true;
						}
					}

					if ( $gp_add_field == true ) { ?>
	
						<div class="form-field">
							<label for="category-<?php echo esc_attr( $gp_option['id'] ); ?>"><?php echo esc_attr( $gp_option['name'] ); ?></label>
							<select id="gp_term_meta_<?php echo esc_attr( $gp_option['id'] ); ?>" name="gp_term_meta[<?php echo esc_attr( $gp_option['id'] ); ?>]">
								
								<?php foreach ( $gp_option['options'] as $key => $option ) { ?>
									<?php if ( $gp_term_meta[$gp_option['id']] != '' ) { ?>
										<option value="<?php echo esc_attr( $key ); ?>" <?php if ( $gp_term_meta[$gp_option['id']] == $key ) { echo ' selected="selected"'; } ?>><?php echo esc_attr( $option ); ?></option>
									<?php } else { ?>
										<option value="<?php echo esc_attr( $key ); ?>" <?php if ( $gp_option['default'] == $key ) { echo ' selected="selected"'; } ?>><?php echo esc_attr( $option ); ?></option>
									<?php } ?>
								<?php } ?>
								
								<?php foreach ( $GLOBALS['wp_registered_sidebars'] as $gp_sidebar ) { ?>
									<option value="<?php echo sanitize_title( $gp_sidebar['id'] ); ?>"<?php if ( isset( $gp_term_meta[$gp_option['id']] ) && $gp_term_meta[$gp_option['id']] == $gp_sidebar['id'] ) { ?>selected="selected"<?php } ?>>
										<?php echo ucwords( $gp_sidebar['name'] ); ?>
									</option>
								<?php } ?>
							</select>
							<p class="description"><?php echo esc_attr( $gp_option['desc'] ); ?></p>
						</div>
		
					<?php } 
					
				break;
				
				case 'text' :
			
					// Checking what category pages to show this option on
					$gp_add_field = false;
					foreach ( $gp_option['tax'] as $type ) {
						if ( $gp_screen->taxonomy == $type ) {
							$gp_add_field = true;
						}
					}

					if ( $gp_add_field == true ) { ?>
	
						<div class="form-field">
							<label for="category-<?php echo esc_attr( $gp_option['id'] ); ?>"><?php echo esc_attr( $gp_option['name'] ); ?></label>
							<input name="gp_term_meta[<?php echo esc_attr( $gp_option['id'] ); ?>]" id="gp_term_meta_<?php echo esc_attr( $gp_option['id'] ); ?>" type="text" value="<?php echo esc_url( $gp_term_meta[$gp_option['id']] ? $gp_term_meta[$gp_option['id']] : '' ); ?>" />
							<p class="description"><?php echo esc_attr( $gp_option['desc'] ); ?></p>
						</div>
		
					<?php }
					
				break;

			}
						
		}
		
	}
}
add_action( 'category_add_form_fields', 'ghostpool_add_tax_fields' );	
add_action( 'post_tag_add_form_fields', 'ghostpool_add_tax_fields' );
add_action( 'gp_portfolios_add_form_fields', 'ghostpool_add_tax_fields' );		

// Edit category options
if ( ! function_exists( 'ghostpool_edit_tax_fields' ) ) {
	function ghostpool_edit_tax_fields( $gp_tag ) {

		global $gp_options;

		// Get current screen
		$gp_screen = get_current_screen();

		// Get category option
		if ( isset( $gp_tag->term_id ) ) {
			$gp_term_id = $gp_tag->term_id;
			$gp_term_meta = get_option( "taxonomy_$gp_term_id" );
		} else {
			$gp_term_meta = null;
		}
		
		// Run category options through filter to add custom options
		$gp_options = apply_filters( 'gp_custom_category_options', $gp_options );
		
		foreach ( $gp_options as $gp_option ) {
		
			switch( $gp_option['type'] ) {
			
				case 'select' :
				
					// Checking what category pages to show this option on
					$gp_add_field = false;
					foreach ( $gp_option['tax'] as $type ) {
						if ( $gp_screen->taxonomy == $type ) {
							$gp_add_field = true;
						}
					}

					if ( $gp_add_field == true ) { ?>
		
						<tr class="form-field">
							<th scope="row" valign="top">
								<label for="category-<?php echo esc_attr( $gp_option['id'] ); ?>"><?php echo esc_attr( $gp_option['name'] ); ?></label>
							</th>
							<td>	
								<select id="gp_term_meta_<?php echo esc_attr( $gp_option['id'] ); ?>" name="gp_term_meta[<?php echo esc_attr( $gp_option['id'] ); ?>]">
									<?php foreach ( $gp_option['options'] as $key => $option ) { ?>
										<?php if ( $gp_term_meta[$gp_option['id']] != '' ) { ?>
											<option value="<?php echo esc_attr( $key ); ?>" <?php if ( $gp_term_meta[$gp_option['id']] == $key ) { echo ' selected="selected"'; } ?>><?php echo esc_attr( $option ); ?></option>
										<?php } else { ?>
											<option value="<?php echo esc_attr( $key ); ?>" <?php if ( $gp_option['default'] == $key ) { echo ' selected="selected"'; } ?>><?php echo esc_attr( $option ); ?></option>
										<?php } ?>
									<?php } ?>
								</select>
								<p class="description"><?php echo esc_attr( $gp_option['desc'] ); ?></p>
							</td>
						</tr>
			
					<?php }
					
				break;

				case 'sidebars' :
			
					// Checking what category pages to show this option on
					$gp_add_field = false;
					foreach ( $gp_option['tax'] as $type ) {
						if ( $gp_screen->taxonomy == $type ) {
							$gp_add_field = true;
						}
					}

					if ( $gp_add_field == true ) { ?>
	
						<tr class="form-field">
							<th scope="row" valign="top">
								<label for="category-<?php echo esc_attr( $gp_option['id'] ); ?>"><?php echo esc_attr( $gp_option['name'] ); ?></label>
							</th>
							<td>	
								<select id="gp_term_meta_<?php echo esc_attr( $gp_option['id'] ); ?>" name="gp_term_meta[<?php echo esc_attr( $gp_option['id'] ); ?>]">
								
									<?php foreach ( $gp_option['options'] as $key => $option ) { ?>
										<?php if ( $gp_term_meta[$gp_option['id']] != '' ) { ?>
											<option value="<?php echo esc_attr( $key ); ?>" <?php if ( $gp_term_meta[$gp_option['id']] == $key ) { echo ' selected="selected"'; } ?>><?php echo esc_attr( $option ); ?></option>
										<?php } else { ?>
											<option value="<?php echo esc_attr( $key ); ?>" <?php if ( $gp_option['default'] == $key ) { echo ' selected="selected"'; } ?>><?php echo esc_attr( $option ); ?></option>
										<?php } ?>
									<?php } ?>
								
									<?php foreach ( $GLOBALS['wp_registered_sidebars'] as $gp_sidebar ) { ?>
										<option value="<?php echo sanitize_title( $gp_sidebar['id'] ); ?>"<?php if ( isset( $gp_term_meta[$gp_option['id']] ) && $gp_term_meta[$gp_option['id']] == $gp_sidebar['id'] ) { ?>selected="selected"<?php } ?>>
											<?php echo ucwords( $gp_sidebar['name'] ); ?>
										</option>
									<?php } ?>
								</select>
								<p class="description"><?php echo esc_attr( $gp_option['desc'] ); ?></p>
							</td>
						</tr>
		
					<?php } 
					
				break;
				
				case 'text' :
			
					// Checking what category pages to show this option on
					$gp_add_field = false;
					foreach ( $gp_option['tax'] as $type ) {
						if ( $gp_screen->taxonomy == $type ) {
							$gp_add_field = true;
						}
					}

					if ( $gp_add_field == true ) { ?>
	
						<tr class="form-field">
							<th scope="row" valign="top">
								<label for="category-<?php echo esc_attr( $gp_option['id'] ); ?>"><?php echo esc_attr( $gp_option['name'] ); ?></label>
							</th>
							<td>
								<input name="gp_term_meta[<?php echo esc_attr( $gp_option['id'] ); ?>]" id="gp_term_meta_<?php echo esc_attr( $gp_option['id'] ); ?>" type="text" value="<?php echo esc_url( $gp_term_meta[$gp_option['id']] ? $gp_term_meta[$gp_option['id']] : '' ); ?>" />
								<p class="description"><?php echo esc_attr( $gp_option['desc'] ); ?></p>
							</td>
						</tr>
		
					<?php }
					
				break;
								
			}
			
		}	
	
	}
}
add_action( 'edit_category_form_fields', 'ghostpool_edit_tax_fields' );	
add_action( 'post_tag_edit_form_fields', 'ghostpool_edit_tax_fields' );
add_action( 'gp_portfolios_edit_form_fields', 'ghostpool_edit_tax_fields' );

// Save category options
if ( ! function_exists( 'ghostpool_save_tax_fields' ) ) {	
	function ghostpool_save_tax_fields( $gp_term_id ) {
		if ( isset( $_POST['gp_term_meta'] ) ) {
			$gp_term_id = $gp_term_id;
			$gp_term_meta = get_option( "taxonomy_$gp_term_id" );
			$gp_cat_keys = array_keys( $_POST['gp_term_meta'] );
				foreach ( $gp_cat_keys as $gp_key ) {
				if ( isset( $_POST['gp_term_meta'][$gp_key] ) ) {
					$gp_term_meta[$gp_key] = $_POST['gp_term_meta'][$gp_key];
				}
			}
			update_option( "taxonomy_$gp_term_id", $gp_term_meta );
		}
	}			
}
add_action( 'created_category', 'ghostpool_save_tax_fields' );		
add_action( 'edit_category', 'ghostpool_save_tax_fields' );
add_action( 'created_post_tag', 'ghostpool_save_tax_fields' ); 
add_action( 'edited_post_tag', 'ghostpool_save_tax_fields' );
add_action( 'created_gp_portfolios', 'ghostpool_save_tax_fields' );	
add_action( 'edited_gp_portfolios', 'ghostpool_save_tax_fields' );			

?>