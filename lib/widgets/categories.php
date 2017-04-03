<?php

if ( ! function_exists( 'ghostpool_categories' ) ) {
	function ghostpool_categories() {
		register_widget( 'GhostPool_Categories' );
	}
}
add_action( 'widgets_init', 'ghostpool_categories' );

class GhostPool_Categories extends WP_Widget {

	function __construct() {
		$gp_widget_ops = array( 'classname' => 'gp-categories', 'description' => esc_html__( 'A list or dropdown of categories.', 'socialize' ) );
		parent::__construct( 'gp-categories-widget', esc_html__( 'GP Categories', 'socialize' ), $gp_widget_ops );
	}

    function widget( $gp_args, $gp_instance ) {
    
        extract( $gp_args );

        static  $gp_first_dropdown = true;
		
		$gp_title = apply_filters( 'widget_title', empty( $gp_instance['title'] ) ? esc_html__( 'Categories', 'socialize' ) : $gp_instance['title'], $gp_instance, $this->id_base );
		
		$gp_c = ! empty( $gp_instance['count'] ) ? '1' : '0';
		$gp_h = ! empty( $gp_instance['hierarchical'] ) ? '1' : '0';
		$gp_d = ! empty( $gp_instance['dropdown'] ) ? '1' : '0';
        $gp_exclude = $gp_instance['exclude'];
		
        echo html_entity_decode( $before_widget );
        
        
        ?>
        
		<?php if ( $gp_title ) { echo html_entity_decode( $before_title . $gp_title . $after_title ); } ?>

		<?php
		
		$gp_cat_args = array(
			'orderby'      => 'name',
			'show_count'   => $gp_c,
			'hierarchical' => $gp_h,
			'exclude' => $gp_exclude
		);


        if ( $gp_d ) {

			$gp_dropdown_id = ( $gp_first_dropdown ) ? 'cat' : "{$this->id_base}-dropdown-{$this->number}";		
			$gp_first_dropdown = false;
			
			echo '<label class="screen-reader-text" for="' . esc_attr( $gp_dropdown_id ) . '">' . $gp_title . '</label>';
			
			$gp_cat_args['show_option_none'] = esc_html__( 'Select Category', 'socialize' );
			$gp_cat_args['id'] = $gp_dropdown_id;

			wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $gp_cat_args ) ); ?>

			<script type='text/javascript'>
			/* <![CDATA[ */
			(function() {
				var dropdown = document.getElementById( "<?php echo esc_js( $gp_dropdown_id ); ?>" );
				function onCatChange() {
					if ( dropdown.options[ dropdown.selectedIndex ].value != '' ) {
						location.href = "<?php echo esc_url( home_url( '/' ) ); ?>?cat=" + dropdown.options[ dropdown.selectedIndex ].value;
					}
				}
				dropdown.onchange = onCatChange;
			})();
			/* ]]> */
			</script>

		<?php } else { ?>
		
			<ul>
				<?php
				$gp_cat_args['title_li'] = '';
				wp_list_categories( apply_filters( 'widget_categories_args', $gp_cat_args ) );
				?>
			</ul>
			
		<?php
		
        }

        echo html_entity_decode( $after_widget );
    }

    function update( $gp_new_instance, $gp_old_instance ) {
        $gp_instance = $gp_old_instance;
        $gp_instance['title'] = sanitize_text_field( $gp_new_instance['title'] );
		$gp_instance['count'] = ! empty( $gp_new_instance['count'] ) ? 1 : 0;
		$gp_instance['hierarchical'] = ! empty( $gp_new_instance['hierarchical'] ) ? 1 : 0;
		$gp_instance['dropdown'] = ! empty( $gp_new_instance['dropdown'] ) ? 1 : 0;
        $gp_instance['exclude'] = ! empty( $gp_new_instance['exclude'] ) ? $gp_new_instance['exclude'] : '';

        return $gp_instance;
    }

    function form( $gp_instance ) {
    
        // Defaults
        $gp_instance = wp_parse_args( ( array ) $gp_instance, array( 'title' => '' ) );
        $gp_title = esc_attr( $gp_instance['title'] );
        $gp_count = isset( $gp_instance['count'] ) ? (bool) $gp_instance['count'] : false;
        $gp_hierarchical = isset( $gp_instance['hierarchical'] ) ? (bool) $gp_instance['hierarchical'] : false;
        $gp_dropdown = isset( $gp_instance['dropdown'] ) ? (bool) $gp_instance['dropdown'] : false;
        $gp_exclude = isset( $gp_instance['exclude'] ) ? $gp_instance['exclude'] : '';

	?>

        <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'socialize' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $gp_title ); ?>" /></p>
				
        <p><input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'dropdown' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dropdown' ) ); ?>"<?php checked( $gp_dropdown ); ?> />
        <label for="<?php echo esc_attr( $this->get_field_id( 'dropdown' ) ); ?>"><?php esc_html_e( 'Show as dropdown', 'socialize' ); ?></label><br />

        <input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>"<?php checked( $gp_count ); ?> />
        <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Show post counts', 'socialize' ); ?></label><br />

        <input type="checkbox" class="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'hierarchical' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hierarchical' ) ); ?>"<?php checked( $gp_hierarchical ); ?> />
        <label for="<?php echo esc_attr( $this->get_field_id( 'hierarchical' ) ); ?>"><?php esc_html_e( 'Show hierarchy', 'socialize' ); ?></label></p>

        <p><label for="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>"><?php esc_html_e( 'Exclude:', 'socialize' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'exclude' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'exclude' ) ); ?>" type="text" value="<?php echo esc_attr( $gp_exclude ); ?>" />
		<br/><small><?php esc_html_e( 'Enter the ID numbers of the categories you want to exclude, separating each with a comma (e.g. 48,142).', 'socialize' ); ?></small></p>
                
<?php

    }

}

?>