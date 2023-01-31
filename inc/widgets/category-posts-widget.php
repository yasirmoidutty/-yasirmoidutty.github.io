<?php

/**
 * Displays latest or category wised posts list.
 *
 */

class Arouse_Sidebar_Posts extends WP_Widget {

	/* Register Widget with WordPress*/
	function __construct() {
		parent::__construct(
			'sidebar_posts', // Base ID
			__( 'Arouse: Sidebar Posts', 'arouse' ), // Name
			array( 'description' => __( 'Displays latest posts or posts from a choosen category.Use this widget in the main sidebars.', 'arouse' ), ) // Args
		);
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */

	public function form( $instance ) {
		//print_r($instance);
		$defaults = array(
			'title'		=>	__( 'Latest Posts', 'arouse' ),
			'category'	=>	'all',
			'number_posts'	=> 5,
			'sticky_posts' => true,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		$number_posts   = isset( $instance['number_posts'] ) ? absint( $instance['number_posts'] ) : 3;

	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'arouse' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>"/>
		</p>
		<p>
			<label><?php _e( 'Select a post category', 'arouse' ); ?></label>
			<?php wp_dropdown_categories( array( 'name' => $this->get_field_name('category'), 'selected' => $instance['category'], 'show_option_all' => 'Show all posts' ) ); ?>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number_posts' ); ?>"><?php _e( 'Number of posts:', 'arouse' ); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'number_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_posts' );?>" value="<?php echo $number_posts; ?>" size="3"/> 
		</p>
		<p>
			<input type="checkbox" <?php checked( $instance['sticky_posts'], true ) ?> class="checkbox" id="<?php echo $this->get_field_id('sticky_posts'); ?>" name="<?php echo $this->get_field_name('sticky_posts'); ?>" />
			<label for="<?php echo $this->get_field_id('sticky_posts'); ?>"><?php _e( 'Hide sticky posts.', 'arouse' ); ?></label>
		</p>

	<?php

	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = sanitize_text_field( $new_instance[ 'title' ] );	
		$instance[ 'category' ]	= absint( $new_instance[ 'category' ] );
		$instance[ 'number_posts' ] = (int)$new_instance[ 'number_posts' ];
		$instance[ 'sticky_posts' ] = (bool)$new_instance[ 'sticky_posts' ];
		return $instance;
	}


	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	
	public function widget( $args, $instance ) {
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';	
		$category = ( ! empty( $instance['category'] ) ) ? $instance['category'] : 0;
		$number_posts = ( ! empty( $instance['number_posts'] ) ) ? absint( $instance['number_posts'] ) : 5; 
		$sticky_posts = ( isset( $instance['sticky_posts'] ) ) ? $instance['sticky_posts'] : false;

		// Latest Posts
		$latest_posts = new WP_Query( 
			array(
				'cat' 					=>	$category,
				'posts_per_page' 		=>	$number_posts,
				'ignore_sticky_posts' 	=>  $sticky_posts
			)
		);	

		echo $before_widget; ?>
		<div class="arouse-category-posts">
		<?php
			if ( ! empty( $instance['title'] ) ) {
				echo $args['before_title'];
				echo apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
				echo $args['after_title'];
			}
		?>

		
		<?php if( $latest_posts -> have_posts() ) : ?>	
			<?php while ( $latest_posts -> have_posts() ) : $latest_posts -> the_post(); ?>
					<div class="ar-cat-post">
						<?php if ( has_post_thumbnail() ) { ?>
							<div class="ar-cat-thumb">
								<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">	
									<?php the_post_thumbnail( 'arouse-featured-thumbnail' ); ?>
								</a>
							</div>
						<?php } ?>
						<div class="ar-cat-details">
							<?php the_title( sprintf( '<h3 class="ar-cat-title"><a href="%s" rel="bookmark">', esc_url_raw( get_permalink() ) ), '</a></h3>' ); ?>
							<p class="ar-cat-meta"><?php the_time('F j, Y'); ?></p>
						</div>
					</div><!-- .ar-cat-post -->
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
        
        </div><!-- .arouse-category-posts -->


	<?php
		echo $after_widget;
	}

}

// Register single category posts widget
function arouse_register_sidebar_posts() {
    register_widget( 'Arouse_Sidebar_Posts' );
}
add_action( 'widgets_init', 'arouse_register_sidebar_posts' );