<?php

/**
 * Adds Arouse_Social_Media_Widget widget.
 */
class Arouse_Social_Media_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'arouse_social_media_widget', // Base ID
			__( 'Arouse: Social Media Widget.', 'arouse' ), // Name
			array( 'description' => __( 'Adds social media icons to widget areas.', 'arouse' ), ) // Args
		);
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
		echo $args['before_widget'];
		
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'];
			echo apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			echo $args['after_title'];
		}
		
		?>

		<div class="arouse-social-links">
			<div class="ar-social-links-inner">
			<?php if ( ! empty( $instance['facebook_url'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['facebook_url'] ) ?>"><div class="facebook social-icon"><i class="fa fa-facebook"></i></div></a>
			<?php endif; ?>

			<?php if ( ! empty( $instance['twitter_url'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['twitter_url'] ) ?>"><div class="twitter social-icon"><i class="fa fa-twitter"></i></div></a>
			<?php endif; ?>

			<?php if ( ! empty( $instance['google_plus_url'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['google_plus_url'] ) ?>"><div class="googleplus social-icon"><i class="fa fa-google-plus"></i></div></a>
			<?php endif; ?>

			<?php if ( ! empty( $instance['youtube_url'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['youtube_url'] ) ?>"><div class="youtube social-icon"><i class="fa fa-youtube"></i></div></a>
			<?php endif; ?>			

			<?php if ( ! empty( $instance['instagram_url'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['instagram_url'] ) ?>"><div class="instagram social-icon"><i class="fa fa-instagram"></i></div></a>
			<?php endif; ?>

			<?php if ( ! empty( $instance['linkedin_url'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['linkedin_url'] ) ?>"><div class="linkedin social-icon"><i class="fa fa-linkedin"></i></div></a>
			<?php endif; ?>

			<?php if ( ! empty( $instance['pinterest_url'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['pinterest_url'] ) ?>"><div class="pinterest social-icon"><i class="fa fa-pinterest"></i></div></a>
			<?php endif; ?>

			<?php if ( ! empty( $instance['dribbble_url'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['dribbble_url'] ) ?>"><div class="dribbble social-icon"><i class="fa fa-dribbble"></i></div></a>
			<?php endif; ?>

			<?php if ( ! empty( $instance['rss_url'] ) ) : ?>
				<a href="<?php echo esc_url( $instance['rss_url'] ) ?>"><div class="rss social-icon"><i class="fa fa-rss"></i></div></a>
			<?php endif; ?>

			<?php if ( ! empty( $instance['email_address'] ) ) : ?>
				<a href="mailto:<?php echo sanitize_email( $instance['email_address'] ) ?>"><div class="email social-icon"><i class="fa fa-envelope"></i></div></a>
			<?php endif; ?>
			</div>
		</div>

		<?php
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'arouse' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'arouse' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<?php $facebook_url = ! empty( $instance['facebook_url'] ) ? $instance['facebook_url'] : ''; ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'facebook_url' ) ); ?>"><?php _e( 'Facebook Link', 'arouse' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook_url' ) ); ?>" type="text" value="<?php echo esc_attr( $facebook_url ); ?>">
		</p>

		<?php $twitter_url = ! empty( $instance['twitter_url'] ) ? $instance['twitter_url'] : ''; ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'twitter_url' ) ); ?>"><?php _e( 'Twitter Link', 'arouse' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter_url' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter_url ); ?>">
		</p>

		<?php $google_plus_url = ! empty( $instance['google_plus_url'] ) ? $instance['google_plus_url'] : ''; ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'google_plus_url' ) ); ?>"><?php _e( 'Google Plus Link', 'arouse' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'google_plus_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'google_plus_url' ) ); ?>" type="text" value="<?php echo esc_attr( $google_plus_url ); ?>">
		</p>

		<?php $youtube_url = ! empty( $instance['youtube_url'] ) ? $instance['youtube_url'] : ''; ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'youtube_url' ) ); ?>"><?php _e( 'Youtube Link', 'arouse' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube_url' ) ); ?>" type="text" value="<?php echo esc_attr( $youtube_url ); ?>">
		</p>

		<?php $instagram_url = ! empty( $instance['instagram_url'] ) ? $instance['instagram_url'] : ''; ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'instagram_url' ) ); ?>"><?php _e( 'Instagram Link', 'arouse' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram_url' ) ); ?>" type="text" value="<?php echo esc_attr( $instagram_url ); ?>">
		</p>

		<?php $linkedin_url = ! empty( $instance['linkedin_url'] ) ? $instance['linkedin_url'] : ''; ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'linkedin_url' ) ); ?>"><?php _e( 'LinkedIn Link', 'arouse' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linkedin_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linkedin_url' ) ); ?>" type="text" value="<?php echo esc_attr( $linkedin_url ); ?>">
		</p>

		<?php $pinterest_url = ! empty( $instance['pinterest_url'] ) ? $instance['pinterest_url'] : ''; ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'pinterest_url' ) ); ?>"><?php _e( 'Pinterest Link', 'arouse' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pinterest_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pinterest_url' ) ); ?>" type="text" value="<?php echo esc_attr( $pinterest_url ); ?>">
		</p>

		<?php $dribbble_url = ! empty( $instance['dribbble_url'] ) ? $instance['dribbble_url'] : ''; ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'dribbble_url' ) ); ?>"><?php _e( 'Dribbble Link', 'arouse' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'dribbble_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dribbble_url' ) ); ?>" type="text" value="<?php echo esc_attr( $dribbble_url ); ?>">
		</p>

		<?php $rss_url = ! empty( $instance['rss_url'] ) ? $instance['rss_url'] : ''; ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'rss_url' ) ); ?>"><?php _e( 'RSS Link', 'arouse' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'rss_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'rss_url' ) ); ?>" type="text" value="<?php echo esc_attr( $rss_url ); ?>">
		</p>

		<?php $email_address = ! empty( $instance['email_address'] ) ? $instance['email_address'] : ''; ?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'email_address' ) ); ?>"><?php _e( 'Email Address', 'arouse' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email_address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email_address' ) ); ?>" type="text" value="<?php echo sanitize_email( $email_address ); ?>">
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
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['facebook_url'] = ( ! empty( $new_instance['facebook_url'] ) ) ? esc_url_raw( $new_instance['facebook_url'] ) : '';
		$instance['twitter_url'] = ( ! empty( $new_instance['twitter_url'] ) ) ? esc_url_raw( $new_instance['twitter_url'] ) : '';
		$instance['google_plus_url'] = ( ! empty( $new_instance['google_plus_url'] ) ) ? esc_url_raw( $new_instance['google_plus_url'] ) : '';
		$instance['youtube_url'] = ( ! empty( $new_instance['youtube_url'] ) ) ? esc_url_raw( $new_instance['youtube_url'] ) : '';
		$instance['instagram_url'] = ( ! empty( $new_instance['instagram_url'] ) ) ? esc_url_raw( $new_instance['instagram_url'] ) : '';
		$instance['linkedin_url'] = ( ! empty( $new_instance['linkedin_url'] ) ) ? esc_url_raw( $new_instance['linkedin_url'] ) : '';
		$instance['pinterest_url'] = ( ! empty( $new_instance['pinterest_url'] ) ) ? esc_url_raw( $new_instance['pinterest_url'] ) : '';
		$instance['dribbble_url'] = ( ! empty( $new_instance['dribbble_url'] ) ) ? esc_url_raw( $new_instance['dribbble_url'] ) : '';
		$instance['rss_url'] = ( ! empty( $new_instance['rss_url'] ) ) ? esc_url_raw( $new_instance['rss_url'] ) : '';
		$instance['email_address'] = ( ! empty( $new_instance['email_address'] ) ) ? sanitize_email( $new_instance['email_address'] ) : '';

		return $instance;
	}

} // class Arouse_Social_Media_Widget

// register Arouse_Social_Media_Widget widget
function arouse_register_social_media() {
    register_widget( 'Arouse_Social_Media_Widget' );
}
add_action( 'widgets_init', 'arouse_register_social_media' );