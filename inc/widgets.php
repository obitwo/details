<?php
 /*
 * Defines widgets for the Current theme
 *
 * @package current
 */
 
class Featured_Posts extends WP_Widget {

	public function __construct() {
		// widget actual processes
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'featured-posts-widget', 'description' => __('Create your own loops and display.', 'counter') );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'featured-posts' );

		/* Create the widget. */
		$this->WP_Widget( 'featured-posts', __('Featured Posts', 'current'), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$subtitle = $instance['subtitle'];
		$style = $instance['style'];
		$type = $instance['type'];
		$tax = $instance['tax'];
		$term = $instance['term'];
		$counts = $instance['count'];
		$popular = $instance['popular'];
		
		if ($subtitle):
			$subtitle = '<span class="sub-title">' . $subtitle . '</span>';		
		else:
			$subtitle = null;
		endif;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $subtitle . $after_title;
			
		//Style Options	
			
		/* Loop for featured posts widget */

    global $post, $count, $counter, $wp_query;

		$args = array();
		$args['ignore_sticky_posts'] = 1;
		
		if ($popular):
		
			$args['meta_key'] = 'view_count';
			$args['orderby'] = 'meta_value_num';
			$args['order'] = 'DESC';
			//$args['date_query'] = array( 'column' => 'post_date_gmt', 'before' => '1 week ago' );

		endif;
		
		
		if ($counts): $args['posts_per_page'] = $counts; endif;
		if ($type): $args['post_type'] = $type; endif;
		if ($term): 
			$args['tax_query'] = array( 
				array(
					'taxonomy' => $tax,
					'field' => 'id',
					'terms' => $term
				) 
			); 
		endif;
		
	    $loop2 = new WP_Query( $args );
      $count = $loop2->post_count;
      $counter = 1;
		
	    if ($loop2->have_posts()) : while ($loop2->have_posts()) :
	    $loop2->the_post();
	    $do_not_duplicate = $post->ID;
	    	
			get_template_part( 'content', $style );
	    	
	    endwhile; else: endif; wp_reset_query();


		/* After widget (defined by themes). */
		echo $after_widget;
	}

 	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Featured Posts', 'current'), 'count' => '5', 'style' => 'widget-featured', 'type' => '', 'tax' => '', 'term' => '', 'popular' => false );
		$instance = wp_parse_args( (array) $instance, $defaults );

		// outputs the options form on admin
		$post_types = get_post_types( array( 'public' => true), 'objects' );
		$taxonomies = get_taxonomies( array( 'public' => true), 'objects' );

		if($instance['tax']):
			$terms = get_terms( $instance['tax'] );
		endif;
		
		 ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Widget SubTitle: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e('Sub-title:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" style="width:100%;" />
		</p>


		<!-- Widget Posts Per Page -->
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Posts Per Page:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" />
		</p>

		<!-- Widget Style -->
		<p>
	   	<label><?php _e( 'Display Type', 'current' ); ?></label><br />
	   	<select name="<?php echo $this->get_field_name( 'style' ); ?>">
		    <option <?php if ( $instance['style'] == 'widget-featured' ): echo 'selected'; endif; ?> value="<?php echo 'widget-featured'; ?>"><?php echo 'Small Thumbnail'; ?></option>
		    <option <?php if ( $instance['style'] == 'widget-full-list' ): echo 'selected'; endif; ?> value="<?php echo 'widget-full-list'; ?>"><?php echo 'Wide Thumbnail'; ?></option>
		    <option <?php if ( $instance['style'] == 'widget-link' ): echo 'selected'; endif; ?> value="<?php echo 'widget-link'; ?>"><?php echo 'Post Links'; ?></option>
		    <option <?php if ( $instance['style'] == 'widget-slider' ): echo 'selected'; endif; ?> value="<?php echo 'widget-slider'; ?>"><?php echo 'Slider'; ?></option>
	   	</select>
		</p>


		<!-- Widget Post Type -->
		<p>
	   	<label><?php _e( 'Post Type', 'current' ); ?></label><br />
	   	<select name="<?php echo $this->get_field_name( 'type' ); ?>">
		    <option value=""><?php _e( 'None', 'current' ); ?></option>	    
		    <?php foreach($post_types as $post_type): ?>
		    <option <?php if ( $instance['type'] == $post_type->name ): echo 'selected'; endif; ?> value="<?php echo $post_type->name; ?>"><?php echo $post_type->label; ?></option>
		    <?php endforeach; ?>
	   	</select>
		</p>


		<!-- Widget Taxonomy -->
		<p>
	   	<label><?php _e( 'Taxonomy  (select and save to load terms)', 'current' ); ?></label><br />
	   	<select name="<?php echo $this->get_field_name( 'tax' ); ?>">
		    <option value=""><?php _e( 'None', 'current' ); ?></option>	    
		    <?php foreach($taxonomies as $tax): ?>
		    <option <?php if ( $instance['tax'] == $tax->name ): echo 'selected'; endif; ?> value="<?php echo $tax->name; ?>"><?php echo $tax->label; ?></option>
		    <?php endforeach; ?>
	   	</select>
		</p>
		
		
		<?php if($instance['tax']): ?>
		<!-- Widget Terms -->
		<p>
	   	<label><?php _e( 'Term', 'current' ); ?></label><br />
	   	<div>
		   	<select name="<?php echo $this->get_field_name( 'term' ); ?>">
				    <option value=""><?php _e( 'Select a term', 'current' ); ?></option>	    
			    <?php foreach($terms as $term): ?>
			    <option <?php if ( $instance['term'] == $term->term_id ): echo 'selected'; endif; ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
			    <?php endforeach; ?>
		   	</select>
	   	</div>
		</p>
		<?php endif; ?>
		
		
		<!-- Sort by Popular -->
		<p>
	   	<label><?php _e( 'Sort by most popular?', 'current' ); ?></label><br />
	    <input type="checkbox" name="<?php echo $this->get_field_name( 'popular' ); ?>" <?php if ( $instance['popular'] ): echo 'checked'; endif; ?> />
		</p>


		<?php
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['subtitle'] = strip_tags( $new_instance['subtitle'] );
		$instance['count'] = strip_tags( $new_instance['count'] );

		$instance['style'] = $new_instance['style'];
		$instance['type'] = $new_instance['type'];
		$instance['tax'] = $new_instance['tax'];
		$instance['term'] = $new_instance['term'];
		$instance['popular'] = $new_instance['popular'];

		return $instance;
	}
}

add_action('widgets_init',
     create_function('', 'return register_widget("Featured_Posts");')
);

class Highest_Rated extends WP_Widget {

	public function __construct() {
		// widget actual processes
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'highest-rated-posts', 'description' => __('Display highest rated posts.', 'counter') );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'highest-rated' );

		/* Create the widget. */
		$this->WP_Widget( 'highest-rated', __('Highest Rated', 'current'), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$subtitle = $instance['subtitle'];
		$tax = $instance['tax'];
		$term = $instance['term'];
		$count = $instance['count'];

		if ($subtitle):
			$subtitle = '<span class="sub-title">' . $subtitle . '</span>';		
		else:
			$subtitle = null;
		endif;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $subtitle . $after_title;

		/* Loop for featured posts widget */

		$args = array();
		
		
		$args['post_type'] = 'post';
		$args['meta_key'] = 'overall_rating';
		$args['orderby'] = 'meta_value_num';
		$args['order'] = 'DESC';
		$args['ignore_sticky_posts'] = 1;
		$args['meta_query'] = array(
			array(
				'key' => 'use_rating',
				'value' => 'on'
				
			)
		);
		if ($count): $args['posts_per_page'] = $count; endif;
		if ($term): 
			$args['tax_query'] = array( 
				array(
					'taxonomy' => $tax,
					'field' => 'id',
					'terms' => $term
				) 
			); 
		endif;
		
	    $loop = new WP_Query( $args );

		
	    if ($loop->have_posts()) : while ($loop->have_posts()) :
	    $loop->the_post();
	    $do_not_duplicate = $post->ID;
	    	
			get_template_part( 'content', 'widget-rating' );
	    	
	    endwhile; else: endif; wp_reset_query();


		/* After widget (defined by themes). */
		echo $after_widget;
	}

 	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Highest Rated', 'current'), 'count' => '5', 'tax' => '', 'term' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		// outputs the options form on admin
		$post_types = get_post_types( array( 'public' => true), 'objects' );
		$taxonomies = get_taxonomies( array( 'public' => true), 'objects' );

		if($instance['tax']):
			$terms = get_terms( $instance['tax'] );
		endif;
		
		 ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Widget SubTitle: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e('Sub-title:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" style="width:100%;" />
		</p>


		<!-- Widget Posts Per Page -->
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Posts Per Page:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $instance['count']; ?>" />
		</p>

		<!-- Widget Taxonomy -->
		<p>
	   	<label><?php _e( 'Taxonomy (select and save to load terms)', 'current' ); ?></label><br />
	   	<select name="<?php echo $this->get_field_name( 'tax' ); ?>">
		    <option value=""><?php _e( 'None', 'current' ); ?></option>	    
		    <?php foreach($taxonomies as $tax): ?>
		    <option <?php if ( $instance['tax'] == $tax->name ): echo 'selected'; endif; ?> value="<?php echo $tax->name; ?>"><?php echo $tax->label; ?></option>
		    <?php endforeach; ?>
	   	</select>
		</p>
		
		
		<?php if($instance['tax']): ?>
		<!-- Widget Terms -->
		<p>
	   	<label><?php _e( 'Term', 'current' ); ?></label><br />
	   	<div>
		   	<select name="<?php echo $this->get_field_name( 'term' ); ?>">
				    <option value=""><?php _e( 'Select a term', 'current' ); ?></option>	    
			    <?php foreach($terms as $term): ?>
			    <option <?php if ( $instance['term'] == $term->term_id ): echo 'selected'; endif; ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
			    <?php endforeach; ?>
		   	</select>
	   	</div>
		</p>
		<?php endif; ?>
		
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['subtitle'] = strip_tags( $new_instance['subtitle'] );
		$instance['count'] = strip_tags( $new_instance['count'] );

		$instance['tax'] = $new_instance['tax'];
		$instance['term'] = $new_instance['term'];

		return $instance;
	}
}

add_action('widgets_init',
     create_function('', 'return register_widget("Highest_Rated");')
);

class Author_List extends WP_Widget {

	public function __construct() {
		// widget actual processes
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'author-list-widget', 'description' => __('Display author avatars.', 'counter') );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'author-list' );

		/* Create the widget. */
		$this->WP_Widget( 'author-list', __('Author List', 'current'), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$subtitle = $instance['subtitle'];
		$display_admins = $instance['display_admins'];
		$role = $instance['role'];
		$order_by = $instance['order_by'];
		$hide_empty = $instance['hide_empty'];

		if ($subtitle):
			$subtitle = '<span class="sub-title">' . $subtitle . '</span>';		
		else:
			$subtitle = null;
		endif;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $subtitle . $after_title;
			
		?>
		
		<div class="author-list">
		<?php
		/*
		$display_admins = true;
		$order_by = 'display_name'; // 'nicename', 'email', 'url', 'registered', 'display_name', or 'post_count'
		$role = ''; // 'subscriber', 'contributor', 'editor', 'author' - leave blank for 'all'
		$hide_empty = true; // hides authors with zero posts
		*/
		$avatar_size = 120;
		
		if(!empty($display_admins)) {
			$blogusers = get_users('orderby='.$order_by.'&role='.$role);
		} else {
			$admins = get_users('role=administrator');
			$exclude = array();
			foreach($admins as $ad) {
				$exclude[] = $ad->ID;
			}
			$exclude = implode(',', $exclude);
			$blogusers = get_users('exclude='.$exclude.'&orderby='.$order_by.'&role='.$role);
		}
		$authors = array();
		
		foreach ($blogusers as $bloguser) {
			$user = get_userdata($bloguser->ID);
			if(!empty($hide_empty)) {
				$numposts = count_user_posts($user->ID);
				if($numposts < 1) continue;
			}
			$authors[] = (array) $user;
		}
		
		echo '<ul class="author-list">';
		foreach($authors as $author) {
			$display_name = $author['display_name'];
			$description = $author['description'];
			$avatar = get_avatar($author['ID']);
			$author_profile_url = get_author_posts_url($author['ID']);
		
			echo '<li><a href="', $author_profile_url, '">', $avatar , '</a></li>';
		}
		echo '</ul>';
		?>
		</div>

		<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

 	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Authors', 'current'), 'display_admins' => true, 'role' => '', 'order_by' => 'display_name', 'hide_empty' => true );
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		
		
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Widget SubTitle: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e('Sub-title:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" style="width:100%;" />
		</p>


		<!-- Display Admins? -->
		<p>
	   	<label><?php _e( 'Display Admins?', 'current' ); ?></label><br />
	    <input type="checkbox" name="<?php echo $this->get_field_name( 'display_admins' ); ?>" <?php if ( $instance['display_admins'] ): echo 'checked'; endif; ?> />
		</p>


		<!-- User Role -->
		<p>
	   	<label><?php _e( 'User Role', 'current' ); ?></label><br />
	   	<select name="<?php echo $this->get_field_name( 'role' ); ?>">
		    <option value=""><?php _e( 'All', 'current' ); ?></option>	    
		    <?php 
		    $roles = array('subscriber', 'contributor', 'editor', 'author');
		    foreach($roles as $role): 
		    ?>
		    <option <?php if ( $instance['role'] == $role ): echo 'selected'; endif; ?> value="<?php echo $role; ?>"><?php _e( $role, 'current' ); ?></option>
		    <?php endforeach; ?>
	   	</select>
		</p>
		
		
		<!-- Order by -->
		<p>
	   	<label><?php _e( 'Order By', 'current' ); ?></label><br />
	   	<select name="<?php echo $this->get_field_name( 'order_by' ); ?>">
		    <?php 
		    $orders = array('display_name', 'nicename', 'email', 'url', 'registered', 'post_count');
		    foreach($orders as $order): 
		    ?>
		    <option <?php if ( $instance['order_by'] == $order ): echo 'selected'; endif; ?> value="<?php echo $order; ?>"><?php _e( $order, 'current' ); ?></option>
		    <?php endforeach; ?>
	   	</select>
		</p>


		<!-- Hide Empty? -->
		<p>
	   	<label><?php _e( 'Hide Empty?', 'current' ); ?></label><br />
	    <input type="checkbox" name="<?php echo $this->get_field_name( 'hide_empty' ); ?>" <?php if ( $instance['hide_empty'] ): echo 'checked'; endif; ?> />
		</p>


		<?php
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['subtitle'] = strip_tags( $new_instance['subtitle'] );

		$instance['display_admins'] = $new_instance['display_admins'];
		$instance['role'] = $new_instance['role'];
		$instance['order_by'] = $new_instance['order_by'];
		$instance['hide_empty'] = $new_instance['hide_empty'];

		return $instance;
	}
}

add_action('widgets_init',
     create_function('', 'return register_widget("Author_List");')
);


class Ad_300x250 extends WP_Widget {

	public function __construct() {
		// widget actual processes
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'ad-300-widget', 'description' => __('300 x 250 pixel ad unit.', 'counter') );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'ad-300' );

		/* Create the widget. */
		$this->WP_Widget( 'ad-300', __('Ad 300x150', 'current'), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$ad_type = $instance['ad_type'];
		$ad_img = $instance['ad_img'];
		$ad_link = $instance['ad_link'];
		$ad_code = $instance['ad_code'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
			
		?>
		
		<div class="ad-300-container">
		<?php if ($ad_type == 'image'): ?>
			<a href="<?php echo $ad_link; ?>" target="_blank"><img alt="adv300" src="<?php if (empty($ad_img)): echo get_template_directory_uri().'/img/adv/adv-300.png'; else: echo $ad_img; endif; ?>" /></a>
		<?php 
		elseif ($ad_type == 'code'):
			 echo $ad_code;
		endif; 
		?>
		</div>
		
		<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

 	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Adversisement', 'current'), 'ad_type' => 'image', 'ad_img' => '', 'ad_link' => '#', 'ad_code' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		 ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Ad Type -->
		<p>
	   	<label><?php _e( 'Ad type', 'current' ); ?></label><br />
	   	<select name="<?php echo $this->get_field_name( 'ad_type' ); ?>">
		    <?php 
		    $types = array('image', 'code');
		    foreach($types as $type): 
		    ?>
		    <option <?php if ( $instance['ad_type'] == $type ): echo 'selected'; endif; ?> value="<?php echo $type; ?>"><?php _e( $type, 'current' ); ?></option>
		    <?php endforeach; ?>
	   	</select>
		</p>
		
		
		<!-- Ad Image URL -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_img' ); ?>"><?php _e('Ad Image URL:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_img' ); ?>" name="<?php echo $this->get_field_name( 'ad_img' ); ?>" value="<?php echo $instance['ad_img']; ?>" style="width:100%;" />
		</p>


		<!-- Ad Link URL -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_link' ); ?>"><?php _e('Ad Link URL:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'ad_link' ); ?>" name="<?php echo $this->get_field_name( 'ad_link' ); ?>" value="<?php echo $instance['ad_link']; ?>" style="width:100%;" />
		</p>


		<!-- Ad Code -->
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_code' ); ?>"><?php _e('Ad Code:', 'current'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'ad_code' ); ?>" name="<?php echo $this->get_field_name( 'ad_code' ); ?>" style="width:100%;"><?php echo $instance['ad_code']; ?></textarea>
		</p>


		<?php
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['ad_img'] = $new_instance['ad_img'];
		$instance['ad_link'] = strip_tags( $new_instance['ad_link'] );

		$instance['ad_type'] = $new_instance['ad_type'];
		$instance['ad_code'] = $new_instance['ad_code'];

		return $instance;
	}
}

add_action('widgets_init',
     create_function('', 'return register_widget("Ad_300x250");')
);


class Flex_Video extends WP_Widget {

	public function __construct() {
		// widget actual processes
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'flex-video-widget', 'description' => __('A responsive Video Widget.', 'counter') );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'flex-video' );

		/* Create the widget. */
		$this->WP_Widget( 'flex-video', __('Responsive Video Widget', 'current'), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$subtitle = $instance['subtitle'];
		$video_title = $instance['video_title'];
		$video_embed_type = $instance['video_embed_type'];
		$video_widescreen = $instance['video_widescreen'];
		$video_embed_code = $instance['video_embed_code'];

		if ($subtitle):
			$subtitle = '<span class="sub-title">' . $subtitle . '</span>';		
		else:
			$subtitle = null;
		endif;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $subtitle . $after_title;
			
		?>
		
		<h4><?php echo $video_title; ?></h4>
		<div class="flex-video<?php if ($video_embed_type == 'youtube' || $video_embed_type == 'vimeo'): echo ' '.$video_embed_type; endif; if ($video_widescreen == 'yes'): echo ' widescreen'; endif;  ?>">
			<?php echo $video_embed_code; ?>
		</div>
		
		<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

 	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Featured Video', 'current'), 'video_title' => '', 'video_embed_type' => 'youtube', 'video_widescreen' => 'yes', 'video_embed_code' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );

		 ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Widget SubTitle: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'subtitle' ); ?>"><?php _e('Sub-title:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'subtitle' ); ?>" name="<?php echo $this->get_field_name( 'subtitle' ); ?>" value="<?php echo $instance['subtitle']; ?>" style="width:100%;" />
		</p>


		<!-- Video Title -->
		<p>
			<label for="<?php echo $this->get_field_id( 'video_title' ); ?>"><?php _e('Video Title:', 'current'); ?></label>
			<input id="<?php echo $this->get_field_id( 'video_title' ); ?>" name="<?php echo $this->get_field_name( 'video_title' ); ?>" value="<?php echo $instance['video_title']; ?>" style="width:100%;" />
		</p>


		<!-- Video Type -->
		<p>
	   	<label><?php _e( 'Video Embed Type', 'current' ); ?></label><br />
	   	<select name="<?php echo $this->get_field_name( 'video_embed_type' ); ?>">
		    <?php 
		    $types = array('youtube', 'vimeo', 'other');
		    foreach($types as $type): 
		    ?>
		    <option <?php if ( $instance['video_embed_type'] == $type ): echo 'selected'; endif; ?> value="<?php echo $type; ?>"><?php _e( $type, 'current' ); ?></option>
		    <?php endforeach; ?>
	   	</select>
		</p>
		
		
		<!-- Enable video_widescreen -->
		<p>
	   	<label><?php _e( 'Enable widescreen?', 'current' ); ?></label><br />
	   	<select name="<?php echo $this->get_field_name( 'video_widescreen' ); ?>">
		    <?php 
		    $types = array('yes', 'no');
		    foreach($types as $type): 
		    ?>
		    <option <?php if ( $instance['video_widescreen'] == $type ): echo 'selected'; endif; ?> value="<?php echo $type; ?>"><?php _e( $type, 'current' ); ?></option>
		    <?php endforeach; ?>
	   	</select>
		</p>


		<!-- Video Embed Code -->
		<p>
			<label for="<?php echo $this->get_field_id( 'video_embed_code' ); ?>"><?php _e('Video Embed Code', 'current'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'video_embed_code' ); ?>" name="<?php echo $this->get_field_name( 'video_embed_code' ); ?>" style="width:100%;"><?php echo $instance['video_embed_code']; ?></textarea>
		</p>


		<?php
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['subtitle'] = strip_tags( $new_instance['subtitle'] );
		$instance['video_title'] = strip_tags( $new_instance['video_title'] );

		$instance['video_embed_type'] = $new_instance['video_embed_type'];
		$instance['video_widescreen'] = $new_instance['video_widescreen'];
		$instance['video_embed_code'] = $new_instance['video_embed_code'];

		return $instance;
	}
}

add_action('widgets_init',
     create_function('', 'return register_widget("Flex_Video");')
);



class Site_Info extends WP_Widget {

	public function __construct() {
		// widget actual processes
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'site-desc-widget', 'description' => __('Website description and information.', 'counter') );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'site-desc' );

		/* Create the widget. */
		$this->WP_Widget( 'site-desc', __('Site information', 'current'), $widget_ops, $control_ops );
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );

		/* Our variables from the widget settings. */
		$site_desc = $instance['site_desc'];

		/* Before widget (defined by themes). */
		echo $before_widget;

			
		?>
		
		<div class="site-logo">
  		<a href="<?php bloginfo('url') ?>"><?php if($nav_logo_upload['url']): ?><img src="<?php echo $nav_logo_upload['url']; ?>" alt="small logo" <?php if($nav_logo_size): echo ' width="'.$nav_logo_size.'"'; endif; ?> /><?php else: bloginfo('name'); endif; ?></a>
		</div>
		
		<div class="site-desc"><?php echo $site_desc; ?></div>
		
		<ul class="site-social-media">
		  <?php current_social_links(); ?>
		</ul>
		
		<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

 	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Site Info', 'current'), 'site_desc' => '');
		$instance = wp_parse_args( (array) $instance, $defaults );

		 ?>

		<!-- Site Description -->
		<p>
			<label for="<?php echo $this->get_field_id( 'site_desc' ); ?>"><?php _e('Site Description', 'current'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'site_desc' ); ?>" name="<?php echo $this->get_field_name( 'site_desc' ); ?>" style="width:100%;"><?php echo $instance['site_desc']; ?></textarea>
		</p>


		<?php
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;

		$instance['site_desc'] = $new_instance['site_desc'];

		return $instance;
	}
}

add_action('widgets_init',
     create_function('', 'return register_widget("Site_Info");')
);



?>