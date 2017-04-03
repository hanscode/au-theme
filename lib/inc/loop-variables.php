<?php

if ( ! function_exists( 'ghostpool_loop_variables' ) ) {
	function ghostpool_loop_variables() {

		$gp_global = get_option( 'socialize' ); 

		
		/*--------------------------------------------------------------
		Portfolio Categories
		--------------------------------------------------------------*/

		if ( is_post_type_archive( 'gp_portfolio_item' ) OR is_tax( 'gp_portfolios' ) )  {

			// Get category option
			$gp_term_data = null;
			if ( isset( get_queried_object()->term_id ) ) {
				$gp_term_id = get_queried_object()->term_id;
				$gp_term_data = get_option( "taxonomy_$gp_term_id" );
			}
						
			$GLOBALS['ghostpool_format'] = ! isset( $gp_term_data['format'] ) || $gp_term_data['format'] == 'default' ? $gp_global['portfolio_cat_format'] : $gp_term_data['format'];
			
			$GLOBALS['ghostpool_orderby'] = $gp_global['portfolio_cat_orderby'];
			
			$GLOBALS['ghostpool_date_posted'] = $gp_global['portfolio_cat_date_posted'];
			
			$GLOBALS['ghostpool_date_modified'] = $gp_global['portfolio_cat_date_modified'];
			
			$GLOBALS['ghostpool_filter'] = $gp_global['portfolio_cat_filter'];
			
			$GLOBALS['ghostpool_per_page'] = $gp_global['portfolio_cat_per_page'];
			
			$GLOBALS['ghostpool_page_numbers'] = 'enabled';


		/*--------------------------------------------------------------
		Portfolio Page Template
		--------------------------------------------------------------*/

		} elseif ( is_page_template( 'portfolio-template.php' ) )  {

			$GLOBALS['ghostpool_cats'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_cats' ) ? implode( ',', redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_cats' ) ) : '';			
			
			$GLOBALS['ghostpool_format'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_format' ) ? redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_format' ) : '';
			
			$GLOBALS['ghostpool_orderby'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_orderby' ) ? redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_orderby' ) : '';
			
			$GLOBALS['ghostpool_date_posted'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_date_posted' ) ? redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_date_posted' ) : '';
			
			$GLOBALS['ghostpool_date_modified'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_date_modified' ) ? redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_date_modified' ) : '';

			$GLOBALS['ghostpool_filter'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_filter' ) ? redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_filter' ) : '';
						
			$GLOBALS['ghostpool_per_page'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_per_page' ) ? redux_post_meta( 'socialize', get_the_ID(), 'portfolio_template_per_page' ) : '';
			$GLOBALS['ghostpool_page_numbers'] = 'enabled';


		/*--------------------------------------------------------------
		Portfolio Items
		--------------------------------------------------------------*/

		} elseif ( is_singular( 'gp_portfolio_item' ) ) {
		
			$gp_image = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_item_image' );
			
			$GLOBALS['ghostpool_image_width'] = ! empty( $gp_image['width'] ) ? $gp_image['width'] : $gp_global['portfolio_item_image']['width'];
			
			$GLOBALS['ghostpool_image_height'] = ! empty( $gp_image['height'] ) ? $gp_image['height'] : $gp_global['portfolio_item_image']['height'];
			
			$GLOBALS['ghostpool_hard_crop'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_item_hard_crop' ) == 'default' ? $gp_global['portfolio_item_hard_crop'] : redux_post_meta( 'socialize', get_the_ID(), 'portfolio_item_hard_crop' );			
			
			$GLOBALS['ghostpool_type'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_item_type' ) == 'default' ? $gp_global['portfolio_item_type'] : redux_post_meta( 'socialize', get_the_ID(), 'portfolio_item_type' );
			
			$GLOBALS['ghostpool_image_size'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_item_image_size' ) == 'default' ? $gp_global['portfolio_item_image_size'] : redux_post_meta( 'socialize', get_the_ID(), 'portfolio_item_image_size' );
			
			$GLOBALS['ghostpool_link_target'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_item_link_target' ) == 'default' ? $gp_global['portfolio_item_link_target'] : redux_post_meta( 'socialize', get_the_ID(), 'portfolio_item_link_target' );
			
			$GLOBALS['ghostpool_link_text'] = redux_post_meta( 'socialize', get_the_ID(), 'portfolio_item_link_text' ) == '' ? $gp_global['portfolio_item_link_text'] : redux_post_meta( 'socialize', get_the_ID(), 'portfolio_item_link_text' );
			
			$GLOBALS['ghostpool_meta_author'] = $gp_global['portfolio_item_meta']['author'];
			
			$GLOBALS['ghostpool_meta_date'] = $gp_global['portfolio_item_meta']['date'];
			
			$GLOBALS['ghostpool_meta_comment_count'] = $gp_global['portfolio_item_meta']['comment_count'];
			
			$GLOBALS['ghostpool_meta_views'] = $gp_global['portfolio_item_meta']['views'];
			
			$GLOBALS['ghostpool_meta_cats'] = $gp_global['portfolio_item_meta']['cats'];
			
			$GLOBALS['ghostpool_meta_tags'] = $gp_global['portfolio_item_meta']['tags'];	


		/*--------------------------------------------------------------
		Search/Author Results
		--------------------------------------------------------------*/

		} elseif ( is_search() or is_author() ) {
		
			$GLOBALS['ghostpool_format'] = $gp_global['search_format'];
			
			$GLOBALS['ghostpool_orderby'] = $gp_global['search_orderby'];
			
			$GLOBALS['ghostpool_date_posted'] = $gp_global['search_date_posted'];
			
			$GLOBALS['ghostpool_date_modified'] = $gp_global['search_date_modified'];
			
			$GLOBALS['ghostpool_filter'] = $gp_global['search_filter'];

			$GLOBALS['ghostpool_filter_date'] = $gp_global['search_filter_options']['date'];
			
			$GLOBALS['ghostpool_filter_page_header'] = $gp_global['search_filter_options']['title'];
			
			$GLOBALS['ghostpool_filter_comment_count'] = $gp_global['search_filter_options']['comment_count'];
			
			$GLOBALS['ghostpool_filter_views'] = $gp_global['search_filter_options']['views'];
			
			$GLOBALS['ghostpool_filter_date_posted'] = $gp_global['search_filter_options']['date_posted'];
			
			$GLOBALS['ghostpool_filter_date_modified'] = $gp_global['search_filter_options']['date_modified'];
			
			$GLOBALS['ghostpool_per_page'] = $gp_global['search_per_page'];
			
			$GLOBALS['ghostpool_featured_image'] = $gp_global['search_featured_image'];
			
			$GLOBALS['ghostpool_image_width'] = $gp_global['search_image']['width'];
			
			$GLOBALS['ghostpool_image_height'] = $gp_global['search_image']['height'];
			
			$GLOBALS['ghostpool_hard_crop'] = $gp_global['search_hard_crop'];
			
			$GLOBALS['ghostpool_image_alignment'] = $gp_global['search_image_alignment'];
			
			$GLOBALS['ghostpool_content_display'] = $gp_global['search_content_display'];
			
			$GLOBALS['ghostpool_excerpt_length'] = $gp_global['search_excerpt_length'];
			
			$GLOBALS['ghostpool_meta_author'] = $gp_global['search_meta']['author'];
			
			$GLOBALS['ghostpool_meta_date'] = $gp_global['search_meta']['date'];
			
			$GLOBALS['ghostpool_meta_comment_count'] = $gp_global['search_meta']['comment_count'];
			
			$GLOBALS['ghostpool_meta_views'] = $gp_global['search_meta']['views'];
			
			$GLOBALS['ghostpool_meta_cats'] = $gp_global['search_meta']['cats'];
			
			$GLOBALS['ghostpool_meta_tags'] = $gp_global['search_meta']['tags'];
			
			$GLOBALS['ghostpool_read_more_link'] = $gp_global['search_read_more_link'];
			
			$GLOBALS['ghostpool_page_numbers'] = 'enabled';


		/*--------------------------------------------------------------
		Blog Page Template
		--------------------------------------------------------------*/

		} elseif ( is_page_template( 'blog-template.php' ) )  {

			$GLOBALS['ghostpool_cats'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_cats' ) ? implode( ',', redux_post_meta( 'socialize', get_the_ID(), 'blog_template_cats' ) ) : '';	
			
			$GLOBALS['ghostpool_post_types'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_post_types' ) ? implode( ',', redux_post_meta( 'socialize', get_the_ID(), 'blog_template_post_types' ) ) : '';
			
			$GLOBALS['ghostpool_format'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_format' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_format' ) : '';
			
			$GLOBALS['ghostpool_orderby'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_orderby' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_orderby' ) : '';				
			
			$GLOBALS['ghostpool_date_posted'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_date_posted' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_date_posted' ) : '';	
			
			$GLOBALS['ghostpool_date_modified'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_date_modified' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_date_modified' ) : '';
			
			$GLOBALS['ghostpool_filter'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_filter' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_filter' ) : '';
			$filter_options = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_filter_options' );		
			
			$GLOBALS['ghostpool_filter_cats'] = isset( $filter_options['cats'] ) ? $filter_options['cats'] : '';	
			
			$GLOBALS['ghostpool_filter_date'] = isset( $filter_options['date'] ) ? $filter_options['date'] : '';	
			
			$GLOBALS['ghostpool_filter_title'] = isset( $filter_options['title'] ) ? $filter_options['title'] : '';	
			
			$GLOBALS['ghostpool_filter_comment_count'] = isset( $filter_options['comment_count'] ) ? $filter_options['comment_count'] : '';	
			
			$GLOBALS['ghostpool_filter_views'] = isset( $filter_options['views'] ) ? $filter_options['views'] : '';
			
			$GLOBALS['ghostpool_filter_date_posted'] = isset( $filter_options['date_posted'] ) ? $filter_options['date_posted'] : '';
			
			$GLOBALS['ghostpool_filter_date_modified'] = isset( $filter_options['date_modified'] ) ? $filter_options['date_modified'] : '';
			
			$GLOBALS['ghostpool_filter_cats_id'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_filter_cats_id' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_filter_cats_id' ) : '';				
			
			$GLOBALS['ghostpool_per_page'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_per_page' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_per_page' ) : '';
			
			$GLOBALS['ghostpool_featured_image'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_featured_image' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_featured_image' ) : '';
			$gp_image = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_image' );
			
			$GLOBALS['ghostpool_image_width'] = isset( $gp_image['width'] ) ? $gp_image['width'] : '';	
			
			$GLOBALS['ghostpool_image_height'] = isset( $gp_image['height'] ) ? $gp_image['height'] : '';	
			
			$GLOBALS['ghostpool_hard_crop'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_hard_crop' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_hard_crop' ) : '';	
			
			$GLOBALS['ghostpool_image_alignment'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_image_alignment' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_image_alignment' ) : '';
			
			$GLOBALS['ghostpool_content_display'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_content_display' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_content_display' ) : '';	
			
			$GLOBALS['ghostpool_excerpt_length'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_excerpt_length' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_excerpt_length' ) : 0;	
			$meta = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_meta' );
			
			$GLOBALS['ghostpool_meta_author'] = isset( $meta['author'] ) ? $meta['author'] : '';	
			
			$GLOBALS['ghostpool_meta_date'] = isset( $meta['date'] ) ? $meta['date'] : '';
			
			$GLOBALS['ghostpool_meta_comment_count'] = isset( $meta['comment_count'] ) ? $meta['comment_count'] : '';	
			
			$GLOBALS['ghostpool_meta_views'] = isset( $meta['views'] ) ? $meta['views'] : '';
			
			$GLOBALS['ghostpool_meta_cats'] = isset( $meta['cats'] ) ? $meta['cats'] : '';
			
			$GLOBALS['ghostpool_meta_tags'] = isset( $meta['tags'] ) ? $meta['tags'] : '';
			
			$GLOBALS['ghostpool_read_more_link'] = redux_post_meta( 'socialize', get_the_ID(), 'blog_template_read_more_link' ) ? redux_post_meta( 'socialize', get_the_ID(), 'blog_template_read_more_link' ) : '';					
			
			$GLOBALS['ghostpool_page_numbers'] = 'enabled';	
			
						
		/*--------------------------------------------------------------
		Post Categories, Archives & Tags
		--------------------------------------------------------------*/

		} elseif ( is_home() OR is_archive() ) {

			// Get category option
			$gp_term_data = null;
			if ( isset( get_queried_object()->term_id ) ) {
				$gp_term_id = get_queried_object()->term_id;
				$gp_term_data = get_option( "taxonomy_$gp_term_id" );
			}
			
			$GLOBALS['ghostpool_format'] = ! isset( $gp_term_data['format'] ) || $gp_term_data['format'] == 'default' ? $gp_global['cat_format'] : $gp_term_data['format'];
			
			$GLOBALS['ghostpool_filter'] = $gp_global['cat_filter'];
			
			$GLOBALS['ghostpool_orderby'] = $gp_global['cat_orderby'];
			
			$GLOBALS['ghostpool_date_posted'] = $gp_global['cat_date_posted'];
			
			$GLOBALS['ghostpool_date_modified'] = $gp_global['cat_date_modified'];
			
			$GLOBALS['ghostpool_filter_date'] = $gp_global['cat_filter_options']['date'];
			
			$GLOBALS['ghostpool_filter_page_header'] = $gp_global['cat_filter_options']['title'];
			
			$GLOBALS['ghostpool_filter_comment_count'] = $gp_global['cat_filter_options']['comment_count'];
			
			$GLOBALS['ghostpool_filter_views'] = $gp_global['cat_filter_options']['views'];
			
			$GLOBALS['ghostpool_filter_date_posted'] = $gp_global['cat_filter_options']['date_posted'];
			
			$GLOBALS['ghostpool_filter_date_modified'] = $gp_global['cat_filter_options']['date_modified'];
			
			$GLOBALS['ghostpool_per_page'] = $gp_global['cat_per_page'];

			$GLOBALS['ghostpool_featured_image'] = $gp_global['cat_featured_image'];
			
			$GLOBALS['ghostpool_image_width'] = $gp_global['cat_image']['width'];
			
			$GLOBALS['ghostpool_image_height'] = $gp_global['cat_image']['height'];
			
			$GLOBALS['ghostpool_hard_crop'] = $gp_global['cat_hard_crop'];
			
			$GLOBALS['ghostpool_image_alignment'] = $gp_global['cat_image_alignment'];
			
			$GLOBALS['ghostpool_content_display'] = $gp_global['cat_content_display'];
			
			$GLOBALS['ghostpool_excerpt_length'] = $gp_global['cat_excerpt_length'];
			
			$GLOBALS['ghostpool_meta_author'] = $gp_global['cat_meta']['author'];
			
			$GLOBALS['ghostpool_meta_date'] = $gp_global['cat_meta']['date'];
			
			$GLOBALS['ghostpool_meta_comment_count'] = $gp_global['cat_meta']['comment_count'];
			
			$GLOBALS['ghostpool_meta_views'] = $gp_global['cat_meta']['views'];
			
			$GLOBALS['ghostpool_meta_cats'] = $gp_global['cat_meta']['cats'];
			
			$GLOBALS['ghostpool_meta_tags'] = $gp_global['cat_meta']['tags'];
			
			$GLOBALS['ghostpool_read_more_link'] = $gp_global['cat_read_more_link'];
			
			$GLOBALS['ghostpool_page_numbers'] = 'enabled';
		
												
		/*--------------------------------------------------------------
		Posts
		--------------------------------------------------------------*/

		} elseif ( is_singular( 'post' ) ) {

			$GLOBALS['ghostpool_featured_image'] = redux_post_meta( 'socialize', get_the_ID(), 'post_featured_image' ) == 'default' ? $gp_global['post_featured_image'] : redux_post_meta( 'socialize', get_the_ID(), 'post_featured_image' );
			$gp_image = redux_post_meta( 'socialize', get_the_ID(), 'post_image' );
		
			$GLOBALS['ghostpool_image_width'] = ! empty( $gp_image['width'] ) ? $gp_image['width'] : $gp_global['post_image']['width'];
		
			$GLOBALS['ghostpool_image_height'] = ! empty( $gp_image['height'] ) ? $gp_image['height'] : $gp_global['post_image']['height'];
		
			$GLOBALS['ghostpool_hard_crop'] = redux_post_meta( 'socialize', get_the_ID(), 'post_hard_crop' ) == 'default' ? $gp_global['post_hard_crop'] : redux_post_meta( 'socialize', get_the_ID(), 'post_hard_crop' );
		
			$GLOBALS['ghostpool_image_alignment'] = redux_post_meta( 'socialize', get_the_ID(), 'post_image_alignment' ) == 'default' ? $gp_global['post_image_alignment'] : redux_post_meta( 'socialize', get_the_ID(), 'post_image_alignment' );
		
			$GLOBALS['ghostpool_meta_author'] = $gp_global['post_meta']['author'];
		
			$GLOBALS['ghostpool_meta_date'] = $gp_global['post_meta']['date'];
		
			$GLOBALS['ghostpool_meta_comment_count'] = $gp_global['post_meta']['comment_count'];
		
			$GLOBALS['ghostpool_meta_views'] = $gp_global['post_meta']['views'];
		
			$GLOBALS['ghostpool_meta_cats'] = $gp_global['post_meta']['cats'];
		
			$GLOBALS['ghostpool_meta_tags'] = $gp_global['post_meta']['tags'];

	
		/*--------------------------------------------------------------
		Pages
		--------------------------------------------------------------*/

		} elseif ( is_page() ) {
						
			$GLOBALS['ghostpool_featured_image'] = redux_post_meta( 'socialize', get_the_ID(), 'page_featured_image' ) == 'default' ? 
			$gp_global['page_featured_image'] : redux_post_meta( 'socialize', get_the_ID(), 'page_featured_image' );
			
			$gp_image = redux_post_meta( 'socialize', get_the_ID(), 'page_image' );
			
			$GLOBALS['ghostpool_image_width'] = ! empty( $gp_image['width'] ) ? $gp_image['width'] : $gp_global['page_image']['width'];
			
			$GLOBALS['ghostpool_image_height'] = ! empty( $gp_image['height'] ) ? $gp_image['height'] : 
			$gp_global['page_image']['height'];
			
			$GLOBALS['ghostpool_hard_crop'] = redux_post_meta( 'socialize', get_the_ID(), 'page_hard_crop' ) == 'default' ? 
			$gp_global['page_hard_crop'] : redux_post_meta( 'socialize', get_the_ID(), 'page_hard_crop' );
			
			$GLOBALS['ghostpool_image_alignment'] = redux_post_meta( 'socialize', get_the_ID(), 'page_image_alignment' ) == 'default' ? $gp_global['page_image_alignment'] : redux_post_meta( 'socialize', get_the_ID(), 'page_image_alignment' );

		}
		
		
		/*--------------------------------------------------------------
		Convert hard_crop option to true or false
		--------------------------------------------------------------*/

		if ( isset( $GLOBALS['ghostpool_hard_crop'] ) && $GLOBALS['ghostpool_hard_crop'] == 'enabled' ) {
			$GLOBALS['ghostpool_hard_crop'] = true;
		} elseif ( isset( $GLOBALS['ghostpool_hard_crop'] ) && $GLOBALS['ghostpool_hard_crop'] == 'disabled' ) {	
			$GLOBALS['ghostpool_hard_crop'] = false;
		}	
		
		
		/*--------------------------------------------------------------
		Add loop variables via your child theme using this function
		--------------------------------------------------------------*/

		if ( function_exists( 'ghostpool_custom_loop_variables' ) ) {
			ghostpool_custom_loop_variables();
		}
		
	}
} 

?>