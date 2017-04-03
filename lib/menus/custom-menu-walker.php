<?php

if ( ! class_exists( 'Ghostpool_Custom_Menu' ) ) {

	class Ghostpool_Custom_Menu extends Walker_Nav_Menu {

		// Start level (add classes to ul sub-menus)
		function start_lvl( &$gp_output, $gp_depth = 0, $gp_args = array() ) {
		
			// Depth dependent classes
			$gp_indent = ( $gp_depth > 0  ? str_repeat( "\t", $gp_depth ) : '' ); // code indent
			$gp_display_depth = ( $gp_depth + 1 ); // because it counts the first submenu as 0
			$gp_classes = array(
				'sub-menu',
				( $gp_display_depth % 2  ? 'menu-odd' : 'menu-even' ),
				( $gp_display_depth >=2 ? 'sub-sub-menu' : '' ),
				'menu-depth-' . $gp_display_depth
				);
			$gp_class_names = implode( ' ', $gp_classes );

			// Build html
			$gp_output .= "\n" . $gp_indent . '<ul class="' . $gp_class_names . '">' . "\n";
			
		}
  
		// Start element (add main/sub classes to li's and links)
		function start_el( &$gp_output, $gp_item, $gp_depth = 0, $gp_args = array(), $id = 0 ) {
			global $wp_query;
	
			$gp_indent = ( $gp_depth > 0 ? str_repeat( "\t", $gp_depth ) : '' ); // code indent

			// Depth dependent classes
			$gp_depth_classes = array(
				( $gp_depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
				( $gp_depth >=2 ? 'sub-sub-menu-item' : '' ),
				( $gp_depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
				'menu-item-depth-' . $gp_depth
			);
			$gp_depth_class_names = esc_attr( implode( ' ', $gp_depth_classes ) );

			// Depth dependent classes
			$gp_display_depth = ( $gp_depth + 1); // because it counts the first submenu as 0
			$gp_sub_menu_classes = array(
				'sub-menu',
				( $gp_display_depth % 2  ? 'menu-odd' : 'menu-even' ),
				( $gp_display_depth >=2 ? 'sub-sub-menu' : '' ),
				'menu-depth-' . $gp_display_depth
				);
			$gp_submenu_depth_class_names = implode( ' ', $gp_sub_menu_classes );
			
			// Parsed classes
			$gp_classes = empty( $gp_item->classes ) ? array() : (array) $gp_item->classes;
			$gp_class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $gp_classes ), $gp_item ) ) );

			// Build html
			
			$gp_menu_type = get_post_meta( $gp_item->ID, 'menu-item-gp-menu-type', true ) ? get_post_meta( $gp_item->ID, 'menu-item-gp-menu-type', true ) : 'gp-standard-menu';
			
			// Profile class
			if ( $gp_menu_type == 'gp-profile-link' ) {
				$gp_profile_class = 'gp-standard-menu';
			} else {
				$gp_profile_class = '';
			}	
			
			if ( ( is_user_logged_in() && get_post_meta( $gp_item->ID, 'menu-item-gp-user-display', true ) != 'gp-show-logged-out' ) OR ( ! is_user_logged_in() && get_post_meta( $gp_item->ID, 'menu-item-gp-user-display', true ) != 'gp-show-logged-in' ) ) {
			
				if ( ( is_user_logged_in() && ( $gp_menu_type == 'gp-login-link' OR $gp_menu_type == 'gp-register-link' ) ) ) {
				
					$gp_output .= '';
				
				} elseif ( ( ! is_user_logged_in() && ( $gp_menu_type == 'gp-logout-link' OR $gp_menu_type == 'gp-profile-link' ) ) ) {
				
					$gp_output .= '';

				} else {
						
					$gp_output .= $gp_indent . '<li id="nav-menu-item-'. $gp_item->ID . '" class="' . $gp_menu_type . ' ' . $gp_profile_class . ' ' . get_post_meta( $gp_item->ID, 'menu-item-gp-columns', true ) . ' ' . get_post_meta( $gp_item->ID, 'menu-item-gp-content', true ) . ' ' . get_post_meta( $gp_item->ID, 'menu-item-gp-display', true ) . ' ' . $gp_depth_class_names . ' ' . get_post_meta( $gp_item->ID, 'menu-item-gp-hide-nav-label', true ) . ' ' . $gp_class_names . '">';

					// Link attributes
					$gp_attributes  = ! empty( $gp_item->attr_title ) ? ' title="'  . esc_attr( $gp_item->attr_title ) .'"' : '';
					$gp_attributes .= ! empty( $gp_item->target )     ? ' target="' . esc_attr( $gp_item->target     ) .'"' : '';
					$gp_attributes .= ! empty( $gp_item->xfn )        ? ' rel="'    . esc_attr( $gp_item->xfn        ) .'"' : '';
				
					// Menu type
					if ( $gp_menu_type == 'gp-login-link' ) {			
						$gp_item_link = '#login';
					} elseif ( $gp_menu_type == 'gp-register-link' ) {
						if ( function_exists( 'bp_is_active' ) ) {
							$gp_item_link = bp_get_signup_page( false );
						} else {
							$gp_item_link = '#register';
						}	
					} elseif ( $gp_menu_type == 'gp-logout-link' ) {	
						$gp_item_link = wp_logout_url( apply_filters( 'gp_logout_redirect', get_home_url( '/' ) ) );
					} elseif ( $gp_menu_type == 'gp-profile-link' ) {	
						if ( function_exists( 'bp_is_active' ) ) {
							global $bp;
							$gp_item_link = $bp->loggedin_user->domain; 
						} else {
							$gp_current_user = wp_get_current_user();
							$gp_item_link = get_author_posts_url( $gp_current_user->ID );
						}								
					} else {
						$gp_item_link = $gp_item->url;
					}
				
					$gp_attributes .= ! empty( $gp_item_link ) ? ' href="' . esc_attr( $gp_item_link ) .'"' : '';
				
					$gp_attributes .= ' class="menu-link ' . ( $gp_depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
			
					// Tab content menu
					if ( $gp_menu_type == 'gp-tab-content-menu' OR $gp_menu_type == 'gp-content-menu' ) {

						// Default variables
						$GLOBALS['ghostpool_menu'] = true;
						$GLOBALS['ghostpool_cats'] = $gp_item->object_id;
					
						// Load page variables
						ghostpool_category_variables();
						
						// Posts per page depending on menu type
						if ( $gp_menu_type == 'gp-content-menu' ) {
							$GLOBALS['ghostpool_menu_per_page'] = 5;
						} else {
							$GLOBALS['ghostpool_menu_per_page'] = 4;
						}
								
						$query_args = array(
							'post_status' 	      => 'publish',
							'post_type'           => array( 'post', 'page' ),
							'tax_query'           => $GLOBALS['ghostpool_tax'],
							'orderby'             => 'date',
							'order'           	  => 'desc',
							'posts_per_page'      => $GLOBALS['ghostpool_menu_per_page'],
							'paged'               => 1,
						);

						$gp_query = new wp_query( $query_args ); 

						if ( function_exists( 'ghostpool_data_properties' ) ) {
							$gp_data_properties = ghostpool_data_properties( 'menu' ); 
						} else {
							$gp_data_properties = '';
						}
				
						$gp_dropdown = '<ul class="sub-menu ' . $gp_submenu_depth_class_names . '">
						<li id="nav-menu-item-'. $gp_item->ID . '" class="' . $gp_class_names . '"' . $gp_data_properties . '>';
					
							if ( $gp_query->have_posts() ) :
				
								if ( $gp_menu_type == 'gp-tab-content-menu' ) {

									$gp_taxonomies = get_taxonomies(); // Go through all taxonomies
									foreach ( $gp_taxonomies as $gp_taxonomy ) {
										$gp_term_args = array(
											'parent'  => $gp_item->object_id, // Get child categories
										);
										$gp_terms = get_terms( $gp_taxonomy, $gp_term_args );
										if ( ! empty( $gp_terms ) ) {
											$gp_dropdown .= '<ul class="gp-menu-tabs">
												<li id="' . $gp_item->object_id . '" class="gp-selected">' . esc_html__( 'All', 'socialize' ) . '</li>';		
												foreach( $gp_terms as $gp_term ) {
													if ( ! empty( $gp_terms ) && ! is_wp_error( $gp_terms ) ) {
														$gp_dropdown .= '<li id="' . $gp_term->term_id . '">' . $gp_term->name . '</li>';
													}
												}
											$gp_dropdown .= '</ul>';
										} 
									}
													
								}

								$gp_dropdown .= '<div class="gp-inner-loop ' . ghostpool_option( 'ajax' ) . '" >';
						
								while ( $gp_query->have_posts() ) : $gp_query->the_post();
															
									// Post link
									if ( get_post_format() == 'link' ) { 
										$gp_link = esc_url( get_post_meta( get_the_ID(), 'link', true ) );
										$gp_target = 'target="' . get_post_meta( get_the_ID(), 'link_target', true ) . '"';
									} else {
										$gp_link = get_permalink();
										$gp_target = '';
									}
														
									$gp_dropdown .= '<section class="' . implode( ' ' , get_post_class( 'gp-post-item' ) ) . '">';

										if ( has_post_thumbnail() ) {
																				
											$gp_image = aq_resize( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ), apply_filters( 'gp_menu_image_width', '270' ), apply_filters( 'gp_menu_image_width', '140' ), true, false, true );
											if ( ghostpool_option( 'retina' ) == 'gp-retina' ) {
												$gp_retina = aq_resize( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ), apply_filters( 'gp_menu_image_width', '270' ) * 2, apply_filters( 'gp_menu_image_width', '140' ) * 2, true, true, true );
											} else {
												$gp_retina = '';
											}
									
											$gp_dropdown .= '<div class="gp-post-thumbnail"><div class="gp-image-above">
												<a href="' . $gp_link . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '"' . $gp_target . '>
													<img src="' . $gp_image[0] . '" data-rel="' . $gp_retina . '" width="' . $gp_image[1] . '" height="' . $gp_image[2] . '" alt="' . the_title_attribute( array( 'echo' => false ) ) . '" class="gp-post-image" />
												</a>
											</div></div>';
							
										}
								
										$gp_dropdown .= '<h2 class="gp-loop-title"><a href="' . $gp_link . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '"'. $gp_target. '>' . get_the_title() . '</a></h2>
										
										<div class="gp-loop-meta"><time class="gp-post-meta gp-meta-date" datetime="' . get_the_date( 'c' ) . '">' . get_the_time( get_option( 'date_format' ) ) . '</time></div>
						
									</section>';
						
								endwhile; 
					
								$gp_dropdown .= '</div><div class="gp-pagination gp-standard-pagination gp-pagination-arrows">' . ghostpool_get_previous_posts_page_link( $gp_query->max_num_pages ) . ghostpool_get_next_posts_page_link( $gp_query->max_num_pages ) . '</div>';
											
							endif; wp_reset_postdata();
							$GLOBALS['ghostpool_menu'] = null;
							$GLOBALS['ghostpool_cats'] = null;

						$gp_dropdown .= '</li></ul>';

					} else {
					
						$gp_dropdown = '';
					
					}	
					
					// Navigation label
					if ( $gp_menu_type == 'gp-profile-link' ) {
						if ( function_exists( 'bp_notifications_get_notifications_for_user' ) ) { 
							$gp_notifications = bp_notifications_get_notifications_for_user( bp_loggedin_user_id(), 'object' );
							$gp_count = ! empty( $gp_notifications ) ? count( $gp_notifications ) : 0;
							$gp_count = '<a href="' . $bp->loggedin_user->domain . '/notifications" class="gp-notification-counter">' . $gp_count . '</a>';
						} else {
							$gp_count = '';
						} 
						$gp_current_user = wp_get_current_user();
						$gp_username = $gp_current_user->display_name;
						$gp_limit = apply_filters( 'gp_truncate_bp_username', 15 );
						if ( strlen( $gp_username ) > $gp_limit ) { 
							$gp_username = substr( $gp_username, 0, $gp_limit ) . '...';
						}
						$gp_nav_label = $gp_username;
						$gp_after = $gp_args->after . $gp_count;
					} elseif ( get_post_meta( $gp_item->ID, 'menu-item-gp-hide-nav-label', true ) == 'gp-hide-nav-label' ) {
						$gp_nav_label = '';
						$gp_after = $gp_args->after;
					} else {
						$gp_nav_label = $gp_item->title;
						$gp_after = $gp_args->after;
					}

					$gp_item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s%7$s',
						$gp_args->before,
						$gp_attributes,
						$gp_args->link_before,
						apply_filters( 'the_title', $gp_nav_label, $gp_item->ID ),
						$gp_args->link_after,
						$gp_after,
						$gp_dropdown
					);
			
					// Build html
					$gp_output .= apply_filters( 'walker_nav_menu_start_el', $gp_item_output, $gp_item, $gp_depth, $gp_args );
				}
				
			}
							
		}
		
		// End element (add closing li's)
		function end_el( &$gp_output, $gp_item, $gp_depth = 0, $gp_args = array(), $id = 0 ) {
		
			$gp_menu_type = get_post_meta( $gp_item->ID, 'menu-item-gp-menu-type', true ) ? get_post_meta( $gp_item->ID, 'menu-item-gp-menu-type', true ) : 'gp-standard-menu';

			if ( ( is_user_logged_in() && get_post_meta( $gp_item->ID, 'menu-item-gp-user-display', true ) != 'gp-show-logged-out' ) OR ( ! is_user_logged_in() && get_post_meta( $gp_item->ID, 'menu-item-gp-user-display', true ) != 'gp-show-logged-in' ) ) {
			
				if ( ( is_user_logged_in() && ( $gp_menu_type == 'gp-login-link' OR $gp_menu_type == 'gp-register-link' ) ) ) {
				
					$gp_output .= '';
				
				} elseif ( ( ! is_user_logged_in() && ( $gp_menu_type == 'gp-logout-link' OR $gp_menu_type == 'gp-profile-link' ) ) ) {
				
					$gp_output .= '';
				
				} else {
				
					$gp_output .= '</li>';

				}
			
			}
								
		}

	}
} 

?>