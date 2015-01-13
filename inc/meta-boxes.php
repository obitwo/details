<?php 
/**
 * Defines meta boxes for the Current theme
 *
 * @package current
 */


/**************************************************************************
META BOXES
**************************************************************************/

add_action( 'add_meta_boxes', 'ce_meta_boxes' );

function ce_meta_boxes() {

	$args=array(
	  'public'   => true,
	); 
	$output = 'names'; // names or objects, note names is the default
	$operator = 'and'; // 'and' or 'or'
	$post_types=get_post_types($args,$output,$operator); 
	foreach ($post_types  as $post_type ) { 

		add_meta_box(
			'general-options',
			__( 'General Display Options'), 
			'general_options',
			$post_type
		);

	}
	
	add_meta_box(
		'carousel-options',
		__( 'Carousel Options'), 
		'display_carousel_options',
		'page'
	);

	add_meta_box(
		'feature-options',
		__( 'Feature Options'), 
		'display_feature_options',
		'page'
	);
	
	add_meta_box(
		'panel-options',
		__( 'Page Builder Options'), 
		'display_panel_options',
		'page'
	);
	
	add_meta_box(
		'ratings-options',
		__( 'Ratings Options'), 
		'display_ratings_options',
		'post'
	);

}


/*************************************************
GENERAL OPTIONS
**************************************************

Prints the box content */

function general_options( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
  $subheading = get_post_meta($post->ID, 'subheading', true);
  $show_sidebar = get_post_meta($post->ID, 'show_sidebar', true);
  $show_featured = get_post_meta($post->ID, 'show_featured', true);
  $hide_byline = get_post_meta($post->ID, 'hide_byline', true);

  ?>
	<!-- Subheading -->
	  
   	<p>
   	<p><label><?php _e( 'Sub-Heading', 'current' ); ?></label></p>
    <input class="cu-input" type="text" name="subheading" value="<?php echo $subheading; ?>" />
   	</p>

	<!-- Show Sidebar -->
	
	<p>
   	<p><label><?php _e( 'Show sidebar', 'current' ); ?></label></p>
	   	<select name="show_sidebar" style="width:100%;">
		    <option <?php if ( empty($show_sidebar) ): echo 'selected'; endif; ?> value=""><?php _e( 'Default', 'current' ); ?></option>
		    <option <?php if ( $show_sidebar == 'show' ): echo 'selected'; endif; ?> value="show"><?php _e( 'Show Sidebar', 'current' ); ?></option>
		    <option <?php if ( $show_sidebar == 'hide' ): echo 'selected'; endif; ?> value="hide"><?php _e( 'Hide Sidebar', 'current' ); ?></option>
		    
	   	</select>
	</p>
	
	<!-- Show Featured Image -->
	
	<p>
	    <input type="checkbox" name="show_featured" <?php if ( $show_featured ): echo 'checked'; endif; ?> />
	   	<label><?php _e( 'Show Featured Image', 'current' ); ?></label>
	</p>
	
	<!-- Hide byline -->

   	<p>
	    <input type="checkbox" name="hide_byline" <?php if ( $hide_byline ): echo 'checked'; endif; ?> />
	   	<label><?php _e( 'Hide byline (applies to posts only)', 'current' ); ?></label>
   	</p>

  <?
}

/* When the post is saved, saves our custom data */
function save_general_options( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

  // OK, we're authenticated: we need to find and save the data

	$subheading = $_POST['subheading'];
	update_post_meta($post_id, 'subheading', $subheading);
	$show_sidebar = $_POST['show_sidebar'];
	update_post_meta($post_id, 'show_sidebar', $show_sidebar);
	$show_featured = $_POST['show_featured'];
	update_post_meta($post_id, 'show_featured', $show_featured);
	$hide_byline = $_POST['hide_byline'];
	update_post_meta($post_id, 'hide_byline', $hide_byline);
}

add_action( 'save_post', 'save_general_options' );


/*************************************************
FEATURE OPTIONS
**************************************************

Prints panel display options */

function display_feature_options( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
	
	$show_feature = get_post_meta($post->ID, 'show_feature', true);
	$feature_title = get_post_meta($post->ID, 'feature_title', true);
	$feature_subtitle = get_post_meta($post->ID, 'feature_subtitle', true);
	$feature_type = get_post_meta($post->ID, 'feature_type', true);
	$feature_tax = get_post_meta($post->ID, 'feature_tax', true);
	$feature_term = get_post_meta($post->ID, 'feature_term', true);
	$feature_count = get_post_meta($post->ID, 'feature_count', true);
	$feature_byline = get_post_meta($post->ID, 'feature_byline', true);
	$feature_attr = get_post_meta($post->ID, 'feature_attr', true);

	$post_types = get_post_types( array( 'public' => true), 'objects' );
	$taxonomies = get_taxonomies( array( 'public' => true), 'objects' );
	
	
	if($feature_tax):
		$terms = get_terms( $feature_tax );
	endif;
	if($_GET['temp_tax0']):
		$terms = get_terms( $_GET['temp_tax0'] );
	endif;
	?>
	
		<!-- Show Feature? -->

		<p>
	   		<input type="checkbox" name="show_feature" <?php if ( $show_feature ): echo 'checked'; endif; ?> />
	   		<label><?php _e( 'Show features?', 'current' ); ?></label>
		</p>
		
			
		<!-- Feature Title -->

		<p>
		   	<p><label><?php _e( 'Feature Title', 'current' ); ?></label></p>
		    <input class="cu-input" type="text" name="feature_title" value="<?php echo $feature_title; ?>" />
		</p>	    


		<!-- Feature SubTitle -->

		<p>
		   	<p><label><?php _e( 'Feature Subtitle', 'current' ); ?></label></p>
		    <input class="cu-input" type="text" name="feature_subtitle" value="<?php echo $feature_subtitle; ?>" />
		</p>	    


		<!-- Feature Post Type -->

		<p>
		   	<p><label><?php _e( 'Feature Post Type', 'current' ); ?></label></p>
		   	<select name="feature_type" style="width:100%;" class="feature_type cu-input">
			    <option value=""><?php _e( 'None', 'current' ); ?></option>	    
			    <?php foreach($post_types as $post_type): ?>
			    <option <?php if ( $feature_type == $post_type->name ): echo 'selected'; endif; ?> value="<?php echo $post_type->name; ?>"><?php echo $post_type->label; ?></option>
			    <?php endforeach; ?>
		   	</select>
		</p>
	   	
		
		<!-- Feature Taxonomy -->
		<p>
		   	<p><label><?php _e( 'Feature Taxonomy', 'current' ); ?></label></p>
		   	<select name="feature_tax" class="tax0">
			    <option value=""><?php _e( 'None', 'current' ); ?></option>	    
			    <?php foreach($taxonomies as $tax): ?>
			    <option <?php if ( $feature_tax == $tax->name ): echo 'selected'; endif; ?> value="<?php echo $tax->name; ?>"><?php echo $tax->label; ?></option>
			    <?php endforeach; ?>
		   	</select>
		</p>
	

		<!-- Feature Terms -->
		<p>
		   	<p><label><?php _e( 'Feature Terms', 'current' ); ?></label></p>
		   	<div class="term0">
			   	<select name="feature_term">
				    <option value=""><?php _e( 'Select a term', 'current' ); ?></option>	    
				    <?php foreach($terms as $term): ?>
				    <option <?php if ( $feature_term == $term->term_id ): echo 'selected'; endif; ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
				    <?php endforeach; ?>
			   	</select><span class="term-spinner0 spinner"></span>
		   	</div>
		</p>


		<!-- Feature Post Count -->
		<p>
		   	<p><label><?php _e( 'Feature Count', 'current' ); ?></label></p>
		    <input type="text" name="feature_count" value="<?php echo $feature_count; ?>" />
		</p>



		<!-- Show post format and category? -->
		<p>
		    <input type="checkbox" name="feature_attr" <?php if ( $feature_attr ): echo 'checked'; endif; ?> />
		   	<p><label><?php _e( 'Show feature format and category?', 'current' ); ?></label></p>
		</p>
	
	
		<!-- Show post format and category? -->
		<p>
		    <input type="checkbox" name="feature_byline" <?php if ( $feature_byline ): echo 'checked'; endif; ?> />
		   	<label><?php _e( 'Show feature author and date?', 'current' ); ?></label>
		</p>


  <?
}

/* When the post is saved, saves our custom data */
function save_feature_options( $post_id ) {
  // verify if this is an auto save routine. 
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

  // OK, we're authenticated: we need to find and save the data


  $show_feature = $_POST['show_feature'];
  update_post_meta($post_id, 'show_feature', $show_feature);
  $feature_title = $_POST['feature_title'];
  update_post_meta($post_id, 'feature_title', $feature_title);
  $feature_subtitle = $_POST['feature_subtitle'];
  update_post_meta($post_id, 'feature_subtitle', $feature_subtitle);
  $feature_type = $_POST['feature_type'];
  update_post_meta($post_id, 'feature_type', $feature_type);
  $feature_tax = $_POST['feature_tax'];
  update_post_meta($post_id, 'feature_tax', $feature_tax);
  $feature_term = $_POST['feature_term'];
  update_post_meta($post_id, 'feature_term', $feature_term);
  $feature_count = $_POST['feature_count'];
  update_post_meta($post_id, 'feature_count', $feature_count);
  $feature_attr = $_POST['feature_attr'];
  update_post_meta($post_id, 'feature_attr', $feature_attr);
  $feature_byline = $_POST['feature_byline'];
  update_post_meta($post_id, 'feature_byline', $feature_byline);
}

add_action( 'save_post', 'save_feature_options' );


/*************************************************
CAROUSEL OPTIONS
**************************************************

Prints carousel options */

function display_carousel_options( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
	
	$show_slider = get_post_meta($post->ID, 'show_slider', true);
	$slider_type = get_post_meta($post->ID, 'slider_type', true);
	$slider_tax = get_post_meta($post->ID, 'slider_tax', true);
	$slider_term = get_post_meta($post->ID, 'slider_term', true);
	$slider_count = get_post_meta($post->ID, 'slider_count', true);

	$post_types = get_post_types( array( 'public' => true), 'objects' );
	$taxonomies = get_taxonomies( array( 'public' => true), 'objects' );
	
	
	if($slider_tax):
		$terms = get_terms( $slider_tax );
	endif;
	if($_GET['temp_tax1']):
		$terms = get_terms( $_GET['temp_tax1'] );
	endif;
	?>
	
		
		<!-- Show carousel? -->
	   	<p>
	   	<p><label><?php _e( 'Show carousel?', 'current' ); ?></label></p>
	    <input type="checkbox" name="show_slider" <?php if ( $show_slider ): echo 'checked'; endif; ?> />
	   	</p>

		<!-- Carousel Post Type -->

		<p>
		   	<p><label><?php _e( 'Carousel Post Type', 'current' ); ?></label></p>
		   	<select name="slider_type" style="width:100%;" class="slider_type">
			    <option value=""><?php _e( 'None', 'current' ); ?></option>	    
			    <?php foreach($post_types as $post_type): ?>
			    <option <?php if ( $slider_type == $post_type->name ): echo 'selected'; endif; ?> value="<?php echo $post_type->name; ?>"><?php echo $post_type->label; ?></option>
			    <?php endforeach; ?>
		   	</select>
		</p>
	   	
		
		<!-- Carousel Taxonomy -->
		<p>
		   	<p><label><?php _e( 'Carousel Taxonomy', 'current' ); ?></label></p>
		   	<select name="slider_tax"  class="tax1">
			    <option value=""><?php _e( 'None', 'current' ); ?></option>	    
			    <?php foreach($taxonomies as $tax): ?>
			    <option <?php if ( $slider_tax == $tax->name ): echo 'selected'; endif; ?> value="<?php echo $tax->name; ?>"><?php echo $tax->label; ?></option>
			    <?php endforeach; ?>
		   	</select>
		</p>
	

		<!-- Carousel Terms -->
		<p>
		   	<p><label><?php _e( 'Carousel Terms', 'current' ); ?></label></p>
		   	<div class="term1">
			   	<select name="slider_term">
				    <option value=""><?php _e( 'Select a term', 'current' ); ?></option>	    
				    <?php foreach($terms as $term): ?>
				    <option <?php if ( $slider_term == $term->term_id ): echo 'selected'; endif; ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
				    <?php endforeach; ?>
			   	</select><span class="term-spinner1 spinner"></span>
		   	</div>
		</p>

		<!-- Slider Post Count -->
		<p>
		   	<p><label><?php _e( 'Carousel Post Count', 'current' ); ?></label></p>
		    <input type="text" name="slider_count" value="<?php echo $slider_count; ?>" />
		</p>
	    



  <?
}

/* When the post is saved, saves our custom data */
function save_carousel_options( $post_id ) {
  // verify if this is an auto save routine. 
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

  // OK, we're authenticated: we need to find and save the data

  $show_slider = $_POST['show_slider'];
  update_post_meta($post_id, 'show_slider', $show_slider);
  $slider_type = $_POST['slider_type'];
  update_post_meta($post_id, 'slider_type', $slider_type);
  $slider_tax = $_POST['slider_tax'];
  update_post_meta($post_id, 'slider_tax', $slider_tax);
  $slider_term = $_POST['slider_term'];
  update_post_meta($post_id, 'slider_term', $slider_term);
  $slider_count = $_POST['slider_count'];
  update_post_meta($post_id, 'slider_count', $slider_count);
}

add_action( 'save_post', 'save_carousel_options' );



/*************************************************
PAGE BUILDER OPTIONS
**************************************************

Prints panel display options */

function display_panel_options( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
	
	$use_panels = get_post_meta($post->ID, 'use_panels', true);
	
	$show_panel = get_post_meta($post->ID, 'show_panel', true);
	$panel_title = get_post_meta($post->ID, 'panel_title', true);
	$panel_subtitle = get_post_meta($post->ID, 'panel_subtitle', true);
	$panel_style = get_post_meta($post->ID, 'panel_style', true);
	$panel_type = get_post_meta($post->ID, 'panel_type', true);
	$panel_tax = get_post_meta($post->ID, 'panel_tax', true);
	$panel_term = get_post_meta($post->ID, 'panel_term', true);
	$panel_count = get_post_meta($post->ID, 'panel_count', true);
	$panel_byline = get_post_meta($post->ID, 'panel_byline', true);
	$panel_attr = get_post_meta($post->ID, 'panel_attr', true);
	$offset = get_post_meta($post->ID, 'offset', true);
	
	global $opts;
	$panel_max_count = $opts['panel_max_count'];
	
	if ($panel_max_count):
		$max_panels = $panel_max_count;
	else:
		$max_panels = 10;
	endif;
	
	
	$post_types = get_post_types( array( 'public' => true), 'objects' );
	$taxonomies = get_taxonomies( array( 'public' => true), 'objects' );
	
	
	for($x = 2; $x <= $max_panels + 2; $x++):
	
		if($panel_tax[$x]):
			$terms[$x] = get_terms( $panel_tax[$x] );
		endif;
	
		if($_GET['temp_tax'.$x]):
			$terms[$x] = get_terms( $_GET['temp_tax'.$x] );
		endif;
	
	endfor;
	?>
	
	<!-- Enable Panels -->
	<p>
    <input type="checkbox" name="use_panels" <?php if ( $use_panels ): echo 'checked'; endif; ?> />
   	<label><?php _e( 'Enable panels?', 'current' ); ?></label>
	</p>
	
	<!-- Panel Loop -->
	
	<ul id="admin-sortable">
	<?php for($x = 2; $x <= $max_panels + 2; $x++): ?>
	<li class="ce-half ui-state-default">
	<div class="ce-half-padding">
		<h3 class="panel-sort-title">
			
			<span class="panel-toggle">+</span>
			<span class="panel-number"><?php echo $x - 1; ?></span>
			<span class="panel-name"></span>
			<span class="panel-style"></span>
			<span class="panel-status">Disabled</span>
		
		</h3>
		
		<div class="panel-inputs">
			<p>
		    <input class="sort-show" type="checkbox" name="show_panel[<?php echo $x; ?>]" <?php if ( $show_panel[$x] ): echo 'checked'; endif; ?> />
		   	<label><?php _e( 'Show this panel?', 'current' ); ?></label>
			</p>
			
			<!-- Panel Title -->
	
			<p>
		   	<p><label><?php _e( 'Panel Title', 'current' ); ?></label></p>
		    <input class="sort-title cu-input" type="text" name="panel_title[<?php echo $x; ?>]" value="<?php echo $panel_title[$x]; ?>" />
			</p>	    
		    
			<!-- Panel SubTitle -->
	
			<p>
		   	<p><label><?php _e( 'Panel Subtitle', 'current' ); ?></label></p>
		    <input class="sort-subtitle cu-input" type="text" name="panel_subtitle[<?php echo $x; ?>]" value="<?php echo $panel_subtitle[$x]; ?>" />
			</p>	    
	
			<!-- Panel Style -->
	
			<p>
		   	<p><label><?php _e( 'Panel Style', 'current' ); ?></label></p>
		   	<select class="sort-style" name="panel_style[<?php echo $x; ?>]" style="width:100%;">
			    <option <?php if ( empty($panel_style[$x]) ): echo 'selected'; endif; ?> value=""><?php _e( 'Default', 'current' ); ?></option>
			    <option <?php if ( $panel_style[$x] == 'panel-excerpt' ): echo 'selected'; endif; ?> value="panel-excerpt"><?php _e( 'Image + Excerpt', 'current' ); ?></option>
			    <option <?php if ( $panel_style[$x] == 'panel-slider' ): echo 'selected'; endif; ?> value="panel-slider"><?php _e( 'Slider', 'current' ); ?></option>
			    <option <?php if ( $panel_style[$x] == 'panel-half' ): echo 'selected'; endif; ?> value="panel-half"><?php _e( 'Half Thumbnail', 'current' ); ?></option>
			    <option <?php if ( $panel_style[$x] == 'panel-small' ): echo 'selected'; endif; ?> value="panel-small"><?php _e( 'Small thumbnail', 'current' ); ?></option>
			    <option <?php if ( $panel_style[$x] == 'panel-half-small' ): echo 'selected'; endif; ?> value="panel-half-small"><?php _e( 'Half + Small Thumbnails', 'current' ); ?></option>
			    <option <?php if ( $panel_style[$x] == 'panel-half-feature-small' ): echo 'selected'; endif; ?> value="panel-half-feature-small"><?php _e( 'Half feature + Small Thumbnails', 'current' ); ?></option>
			    <option <?php if ( $panel_style[$x] == 'page' ): echo 'selected'; endif; ?> value="page"><?php _e( 'Original Page Content', 'current' ); ?></option>
			    
		   	</select>
			</p>
		
			<!-- Panel Post Type -->
	
			<p>
		   	<p><label><?php _e( 'Panel Post Type (defaults to "post")', 'current' ); ?></label></p>
		   	<select name="panel_type[<?php echo $x; ?>]" style="width:100%;" class="slider_type sort-type">
			    <option <?php if ( empty($panel_type[$x]) ): echo 'selected'; endif; ?> value=""><?php _e( 'None', 'current' ); ?></option>	    
			    <?php foreach($post_types as $post_type): ?>
			    <option <?php if ( $panel_type[$x] == $post_type->name ): echo 'selected'; endif; ?> value="<?php echo $post_type->name; ?>"><?php echo $post_type->label; ?></option>
			    <?php endforeach; ?>
		   	</select>
			</p>
		   	
			
			<!-- Panel Taxonomy -->
			<p>
			   	<p><label><?php _e( 'Panel Taxonomy (select to load terms)', 'current' ); ?></label></p>
			   	<select name="panel_tax[<?php echo $x; ?>]"  class="tax<?php echo $x; ?> sort-tax">
				    <option <?php if ( empty($panel_tax[$x]) ): echo 'selected'; endif; ?> value=""><?php _e( 'None', 'current' ); ?></option>	    
				    <?php foreach($taxonomies as $tax): ?>
				    <option <?php if ( $panel_tax[$x] == $tax->name ): echo 'selected'; endif; ?> value="<?php echo $tax->name; ?>"><?php echo $tax->label; ?></option>
				    <?php endforeach; ?>
			   	</select>
			   	
			</p>
		
	
			<!-- Panel Terms -->
			<p>
			   	<p><label><?php _e( 'Panel Terms', 'current' ); ?></label></p>
			   	<div class="term<?php echo $x; ?>">
				   	<select class="sort-term" name="panel_term[<?php echo $x; ?>]">
					    <option <?php if ( empty($panel_term[$x]) ): echo 'selected'; endif; ?> value=""><?php _e( 'Select a term', 'current' ); ?></option>	    
					    <?php foreach($terms[$x] as $term): ?>
					    <option <?php if ( $panel_term[$x] == $term->term_id ): echo 'selected'; endif; ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
					    <?php endforeach; ?>
				   	</select><span class="term-spinner<?php echo $x; ?> spinner"></span>
			   	</div>
			</p>
	
			<!-- Panel Post Count -->
	
			<p>
			   	<p><label><?php _e( 'Panel Count', 'current' ); ?></label></p>
			    <input class="sort-count" type="text" name="panel_count[<?php echo $x; ?>]" value="<?php echo $panel_count[$x]; ?>" />
			</p>
		    
			<!-- Panel Post Offset -->
	
			<p>
			   	<p><label><?php _e( 'Panel Offest', 'current' ); ?></label></p>
			    <input class="sort-offset" type="text" name="offset[<?php echo $x; ?>]" value="<?php echo $offset[$x]; ?>" />
		    </p>
	
	
			<!-- Show post format and category? -->
			<p>
			    <input class="sort-attr" type="checkbox" name="panel_attr[<?php echo $x; ?>]" <?php if ( $panel_attr[$x] ): echo 'checked'; endif; ?> />
			   	<label><?php _e( 'Show post format and category?', 'current' ); ?></label>
			</p>
		
		
			<!-- Show post byline? -->
			<p>
			    <input class="sort-byline" type="checkbox" name="panel_byline[<?php echo $x; ?>]" <?php if ( $panel_byline[$x] ): echo 'checked'; endif; ?> />
			   	<label><?php _e( 'Show post author and date?', 'current' ); ?></label>
			</p>
			
		</div>

	</div>
	</li>
	
	
	<?php endfor; ?>
	
	</ul>
	<div class="clearfix"></div>
  <?
}

/* When the post is saved, saves our custom data */
function save_panel_options( $post_id ) {
  // verify if this is an auto save routine. 
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

  // OK, we're authenticated: we need to find and save the data



  $use_panels = $_POST['use_panels'];
  update_post_meta($post_id, 'use_panels', $use_panels);
  $show_title = $_POST['show_title'];
  update_post_meta($post_id, 'panel_title', $panel_title);
  $show_panel = $_POST['show_panel'];
  update_post_meta($post_id, 'show_panel', $show_panel);
  $panel_style = $_POST['panel_style'];
  update_post_meta($post_id, 'panel_style', $panel_style);

  $panel_title = $_POST['panel_title'];
  update_post_meta($post_id, 'panel_title', $panel_title);
  $panel_subtitle = $_POST['panel_subtitle'];
  update_post_meta($post_id, 'panel_subtitle', $panel_subtitle);
  $panel_type = $_POST['panel_type'];
  update_post_meta($post_id, 'panel_type', $panel_type);
  $panel_tax = $_POST['panel_tax'];
  update_post_meta($post_id, 'panel_tax', $panel_tax);
  $panel_term = $_POST['panel_term'];
  update_post_meta($post_id, 'panel_term', $panel_term);
  $panel_count = $_POST['panel_count'];
  update_post_meta($post_id, 'panel_count', $panel_count);
  $offset = $_POST['offset'];
  update_post_meta($post_id, 'offset', $offset);
  $panel_attr = $_POST['panel_attr'];
  update_post_meta($post_id, 'panel_attr', $panel_attr);
  $panel_byline = $_POST['panel_byline'];
  update_post_meta($post_id, 'panel_byline', $panel_byline);
}

add_action( 'save_post', 'save_panel_options' );


/*************************************************
RATINGS OPTIONS
**************************************************

Prints the box content */

function display_ratings_options( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
	
	$use_rating = get_post_meta($post->ID, 'use_rating', true);
	$rating_title = get_post_meta($post->ID, 'rating_title', true);
	$overall_rating = get_post_meta($post->ID, 'overall_rating', true);
	$sub_rating_name = get_post_meta($post->ID, 'sub_rating_name', true);
	$sub_rating = get_post_meta($post->ID, 'sub_rating', true);
	
	global $opts;
	$rating_max_count = $opts['rating_max_count'];
	
	if ($rating_max_count):
		$max_ratings = $rating_max_count;
	else:
		$max_ratings = 10;
	endif;
	
	?>
	
	<!-- Enable Ratings -->
	<p>
	    <input type="checkbox" name="use_rating" <?php if ( $use_rating ): echo 'checked'; endif; ?> />
	   	<label><?php _e( 'Enable ratings?', 'current' ); ?></label>
	</p>


	<!-- Rating Title -->

	<p>
	   	<p><label><?php _e( 'Rating Title', 'current' ); ?></label></p>
	    <input class="cu-input" type="text" name="rating_title" value="<?php echo $rating_title; ?>" />
	</p>	    


	<!-- Overall Rating -->

	<p>
	   	<p><label><?php _e( 'Overall Rating', 'current' ); ?></label></p>
	    <input type="text" name="overall_rating" value="<?php echo $overall_rating; ?>" size="5" />
	</p>	    
	
	<ul class="admin-sortable">
	<?php for($x = 1; $x <= $max_ratings; $x++): ?>
	<li class="ce-half">
	<div class="ce-half-padding">
		<h3 class="panel-sort-title">
			
			<span class="panel-toggle">+</span>
			<span class="panel-number"><?php _e( 'Rating #'.$x , 'current' ); ?></span>
			<span class="panel-name"></span>
		</h3>

		<!-- Panel Title -->

		<div class="panel-inputs">
			<p>
			   	<p><label><?php _e( 'Rating #'.$x.' Name', 'current' ); ?></label></p>
			    <input class="cu-input sort-rating" type="text" name="sub_rating_name[<?php echo $x; ?>]" value="<?php echo $sub_rating_name[$x]; ?>" />
			</p>	    
	
			<!-- Panel Post Count -->
	
			<p>
			   	<p><label><?php _e( 'Rating #'.$x.' Value', 'current' ); ?></label></p>
			    <input type="text" name="sub_rating[<?php echo $x; ?>]" value="<?php echo $sub_rating[$x]; ?>" size="5" />
			</p>
		</div>
		
	</div>
	</li>
	
	<?php endfor; ?>
	
	</ul>
	
  <?
}

/* When the post is saved, saves our custom data */
function save_ratings_options( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;

  // OK, we're authenticated: we need to find and save the data


	$rating_title = $_POST['rating_title'];
	update_post_meta($post_id, 'rating_title', $rating_title);
	$use_rating = $_POST['use_rating'];
	update_post_meta($post_id, 'use_rating', $use_rating);
	$overall_rating = $_POST['overall_rating'];
	update_post_meta($post_id, 'overall_rating', $overall_rating);
	$sub_rating_name = $_POST['sub_rating_name'];
	update_post_meta($post_id, 'sub_rating_name', $sub_rating_name);
	$sub_rating = $_POST['sub_rating'];
	update_post_meta($post_id, 'sub_rating', $sub_rating);
}

add_action( 'save_post', 'save_ratings_options' );


?>
