<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package current
 */

if ( ! function_exists( 'current_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @return void
 */
function current_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav"><i class="fa fa-angle-left"></i></span>&nbsp; Older posts', 'current' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts &nbsp;<span class="meta-nav"><i class="fa fa-angle-right"></i></span>', 'current' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'current_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @return void
 */
function current_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav"><i class="fa fa-angle-left"></i></span>&nbsp; %title', 'Previous post link', 'current' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title &nbsp;<span class="meta-nav"><i class="fa fa-angle-right"></i></span>', 'Next post link',     'current' ) );
			?>
		</div><!-- .nav-links -->
		<div class="clearfix"></div>
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'current_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function current_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">Posted on %1$s</span><span class="byline"> by %2$s</span>', 'current' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 */
function current_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so current_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so current_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in current_categorized_blog.
 */
function current_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'current_category_transient_flusher' );
add_action( 'save_post',     'current_category_transient_flusher' );


if ( ! function_exists( 'current_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function current_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'current' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'current' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

				<div class="comment-author vcard">
					<?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
					<?php printf( __( '%s', 'current' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author -->
				
				<div class="comment-content-block">
				
					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>">
								<?php printf( _x( '%1$s at %2$s', '1: date, 2: time', 'current' ), get_comment_date(), get_comment_time() ); ?>
							</time>
						</a>
						<?php edit_comment_link( __( 'Edit', 'current' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .comment-metadata -->
					
					<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'current' ); ?></p>
					<?php endif; ?>
					
	
					<div class="comment-content">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->
		
					<?php
						comment_reply_link( array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
						) ) );
					?>

				</div>

				<div class="clearfix"></div>

		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for current_comment()


if ( ! function_exists( 'current_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 */
function current_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'current_attachment_size', array( 1200, 1200 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the
	 * URL of the next adjacent image in a gallery, or the first image (if
	 * we're looking at the last image in a gallery), or, in a gallery of one,
	 * just the link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;



/**
 * Display the subtitle
 */
function current_subtitle(){
	
	if ( get_post_meta(get_the_ID(), 'subheading', true) ):
	?>
	
			<span class="sub-title">
				<?php echo get_post_meta(get_the_ID(), 'subheading', true); ?>
			</span>
	
	<?php
	endif;
}


/**
 * Display the byline
 */
function current_byline(){

	//$hide_byline = get_post_meta(get_the_ID(), 'hide_byline', true);

	//if (!$hide_byline):
	?>
		<div class="byline">
			<i class="fa fa-pencil"></i> <span class="author-name"><?php _e( 'by', 'current' ); ?> <?php the_author_posts_link(); ?></span>
      <span class="entry-divider">|</span>
      <i class="fa fa-clock-o"></i> <span class="date"><?php the_time(get_option('date_format')); ?></span>
      <span class="entry-divider">|</span>
      <i class="fa fa-comments"></i>  <a href="<?php comments_link(); ?>"><?php echo get_comments_number(); ?></a>
      <?php current_post_format_display(); ?>
      <?php the_category(); ?>
			<div class="clearfix"></div>
		</div>
	<?php
	//endif;
}


/**
 * Display the short byline
 */
function current_short_byline(){

	//$hide_byline = get_post_meta(get_the_ID(), 'hide_byline', true);

	//if (!$hide_byline):
	?>
	
<div class="entry-meta"><i class="fa fa-pencil"></i> <?php _e( 'by', 'current' ); ?> <?php the_author_posts_link(); ?> <span class="entry-divider">|</span> <i class="fa fa-comments"></i>  <a href="<?php comments_link(); ?>"><?php echo get_comments_number(); ?></a></div>

	<?php
	//endif;
}


/**
 * Display the post information for thumbnail boxes
 */
function current_post_info(){

	$overall_rating = get_post_meta(get_the_ID(), 'overall_rating', true);
  $use_rating = get_post_meta(get_the_ID(), 'use_rating', true);
  
	if ($overall_rating <= 100 & is_numeric($overall_rating) & !empty($overall_rating)):
		$overall_rating = intval($overall_rating);
	else:
		$overall_rating = 'NR';
	endif;


	?>
          <div class="thumb-stats">
            <?php if ($use_rating): ?><a href="<?php the_permalink(); ?>#rating" class="rating-small"><?php echo $overall_rating; if (is_numeric($overall_rating)): ?>%<?php endif; ?></a><?php endif; ?>
            <?php current_post_format_display(); ?>
            <?php the_category(); ?>
          </div>
	<?php
	//endif;
}



/**
 * Display the post format icon
 */
function current_post_format_display(){
	
	$format = get_post_format(get_the_ID());
	
	$format_icon = array(
		'aside' => 'file',
		'chat' => 'comments',
		'gallery' => 'th-large',
		'link' => 'chain',
		'image' => 'picture-o',
		'quote' => 'quote-right',
		'status' => 'refresh',
		'video' => 'play-circle',
		'audio' => 'headphones',
		
	); 
	
	if($format):
	?>
	
	<a href="<?php echo get_post_format_link($format); ?>" class="post-format-icon"><i class="fa fa-<?php echo $format_icon[$format]; ?>"></i></a>
	
	<?php
	endif;
}


/**
 * Display the full rating
 */
function current_full_rating(){
	
	$overall_rating = get_post_meta(get_the_ID(), 'overall_rating', true);
	$rating_title = get_post_meta(get_the_ID(), 'rating_title', true);
	$sub_rating_name = get_post_meta(get_the_ID(), 'sub_rating_name', true);
	$sub_rating = get_post_meta(get_the_ID(), 'sub_rating', true);

	$rating_max_count = $opts['rating_max_count'];
	
	if ($rating_max_count):
		$max_ratings = $rating_max_count;
	else:
		$max_ratings = 10;
	endif;


	if ($overall_rating <= 100 & is_numeric($overall_rating) & !empty($overall_rating)):
		$overall_rating = intval($overall_rating);
	else:
		$overall_rating = 'NR';
	endif;
	
	?>
	
	<div id="rating" class="rating-container">
		
		<?php if ($rating_title): ?><h4 class="section-title"><?php echo $rating_title; ?></h4><?php endif; ?>
		
		<div class="rating-large">
			<?php if (is_numeric($overall_rating)): ?><div class="rating-fill" style="height: <?php echo $overall_rating; ?>%;"></div><?php endif; ?>
			<span class="rating-number"><?php echo $overall_rating; if (is_numeric($overall_rating)): ?><sup>%</sup><?php endif; ?></span>
		</div>
		
		<?php for($x = 1; $x <= $max_ratings; $x++): ?>
		<?php if ($sub_rating_name[$x]): ?>
		<h6 class="rating-title"><?php echo $sub_rating_name[$x]; ?></h6>
		
		<?php if ($sub_rating[$x] && is_numeric($sub_rating[$x]) && intval($sub_rating[$x]) <= 100): ?>
		<div class="rating-bar-container"><div class="rating-bar" style="width: <?php echo intval($sub_rating[$x]); ?>%;"></div></div>
		<?php endif; ?>
		
		
		<?php endif; ?>
		<?php endfor; ?>
		
	</div>
	
	<?php
}


/**
 * Display the rating
 */
function current_rating(){
	$overall_rating = get_post_meta(get_the_ID(), 'overall_rating', true);

	if ($overall_rating <= 100 & is_numeric($overall_rating) & !empty($overall_rating)):
		$overall_rating = intval($overall_rating);
	else:
		$overall_rating = 'NR';
	endif;
	
	?>
	
	<a href="<?php the_permalink(); ?>#rating" class="rating">
		<?php if (is_numeric($overall_rating)): ?><span class="rating-fill" style="height: <?php echo $overall_rating; ?>%;"></span><?php endif; ?>
		<span class="rating-number"><?php echo $overall_rating; if (is_numeric($overall_rating)): ?><sup>%</sup><?php endif; ?></span>
	</a>
	
	<?php

}


/**
 * Add author fields
 */
function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['twitter'] = 'Twitter Username';
	$profile_fields['facebook'] = 'Facebook URL';
	$profile_fields['gplus'] = 'Google+ URL';
	$profile_fields['youtube'] = 'Youtube URL';
	$profile_fields['instagram'] = 'Instagram Username';

	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');


/**
 * Display the author info
 */
function current_author_info(){
	?>

	<div class="author-info-page">

    <h2 class="author-title"><?php echo "About " . get_the_author(); ?>
      <div class="author-social">
      <?php if (get_the_author_meta( 'twitter' )): ?><a href="http://twitter.com/<?php echo get_the_author_meta( 'twitter' ); ?>" target="_blank"><i class="fa fa-twitter"></i></a>&nbsp;<?php endif; ?>
      <?php if (get_the_author_meta( 'facebook' )): ?><a href="<?php echo get_the_author_meta( 'facebook' ); ?>" target="_blank"><i class="fa fa-facebook"></i></a>&nbsp;<?php endif; ?>
      <?php if (get_the_author_meta( 'gplus' )): ?><a href="<?php echo get_the_author_meta( 'gplus' ); ?>" target="_blank"><i class="fa fa-google-plus"></i></a>&nbsp;<?php endif; ?>
      <?php if (get_the_author_meta( 'youtube' )): ?><a href="<?php echo get_the_author_meta( 'youtube' ); ?>" target="_blank"><i class="fa fa-youtube"></i></a>&nbsp;<?php endif; ?>
      <?php if (get_the_author_meta( 'instagram' )): ?><a href="http://instagram.com/<?php echo get_the_author_meta( 'instagram' ); ?>" target="_blank"><i class="fa fa-instagram"></i></a>&nbsp;<?php endif; ?>
      </div>
      <div class="clearfix"></div>
    </h2>


	    <div class="author-avatar">
	        <?php echo get_avatar(get_the_author_id()); ?>
	    </div><!--end #author-avatar-->
	    <div class="author-desc">
	        <?php the_author_meta( 'description' ); ?>
	         
	    </div><!--end #author-desc-->  
	    <div class="clearfix"></div>
	    
	    <?php if(is_single()): echo '<div><a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'" class="button author-button">View all posts by '.get_the_author().'</a></div>'; endif; ?>
	    
	</div><!-- #author-info -->

	<?php
}

/**
 * Sidebar Position
 */
function current_sidebar_position(){
  
  // Load variables
  
  include('vars.php'); 
  
  if( is_singular() ): 
		$show_sidebar = get_post_meta(get_the_id(), 'show_sidebar', true); 
	endif;

  if ( class_exists( 'WooCommerce' ) ):
  
  	if (is_shop() || is_product_category() || is_product_tag() || is_404()):
  		$show_sidebar = 'hide';
  	endif;

  else:
  
  	if ( is_404() ):
  		$show_sidebar = 'hide';
  	endif;

  endif;
	?>
	
	<style type="text/css">
	
	@media (min-width: 992px){
		
		<?php if($sidebar_position == 'left' && $show_sidebar != "hide"): ?>
		.container .content .content-area{float: right!important; padding-right: 0!important; padding-left:0.9375rem!important;}
		.container .content .sidebar-container{padding-left: 0!important; padding-right:0.9375rem!important;}
		<?php endif; ?>
		<?php if ($show_sidebar == "hide" || ($sidebar_position == 'none' && empty($show_sidebar))): ?>
		.content-area{width: 100%!important; float: none!important; padding-right: 0!important;}
		<?php endif; ?>
	}
	
	</style>
	
	<?
	
	
}

/**
 * Display panels
 */
function current_display_panel($x){

	global $post, $show_panel_byline, $show_panel_attr;

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
	
	$show_panel_byline = $panel_byline[$x];
	$show_panel_attr = $panel_attr[$x];
	
	
	?>
	
	<?php if ($panel_title[$x]): ?><h4 class="section-title<?php if ($panel_style[$x] == 'panel-slider'): ?> slider-feature-title orbit-container<?php endif; ?>"><?php echo $panel_title[$x]; if ($panel_subtitle[$x]): ?><span class="sub-title"><?php echo $panel_subtitle[$x]; ?></span><?php endif; ?><?php if ($panel_style[$x] == 'panel-slider'): ?><a class="orbit-prev"></a><a class="orbit-next"></a><?php endif; ?></h4><?php endif; ?>


	<?php
	
	
	global $count, $counter, $wp_query, $panel_sidebar;
	
	include('vars.php');
	$panel_sidebar = ( current_show_sidebar() ? true : false );
	
	$counter = 1;
	$args = array();
	
	
	if ($panel_type[$x]): $args['post_type'] = $panel_type[$x]; else: $args['post_type'] = 'post'; endif;
	if ($panel_count[$x]): $args['posts_per_page'] = $panel_count[$x]; endif;
	if ($panel_term[$x]): 
		$args['tax_query'] = array( 
			array(
				'taxonomy' => $panel_tax[$x],
				'field' => 'id',
				'terms' => $panel_term[$x]
			) 
		); 
	endif;
	if ($offset[$x]): $args['offset'] = $offset[$x]; endif;
	
    $loop = new WP_Query( $args );
    $count = $loop->post_count;

	if ($panel_style[$x] == 'page'): $loop = $wp_query; endif;

    		        
    if ($loop->have_posts()) : while ($loop->have_posts()) :
    $loop->the_post();
    $do_not_duplicate = $post->ID;
    
    	
		get_template_part( 'content', $panel_style[$x] );
    
		// If comments are open or we have at least one comment, load up the comment template
		if ( (comments_open() || '0' != get_comments_number()) && $panel_style[$x] == 'page' )
			comments_template();

    endwhile; else: endif; wp_reset_query();
	
}


/**
 * Display slider feature
 */
function current_slider_feature(){

	global $post, $count, $counter, $wp_query, $show_panel_byline, $show_panel_attr;

	$show_feature = get_post_meta($post->ID, 'show_feature', true);
	$feature_title = get_post_meta($post->ID, 'feature_title', true);
	$feature_subtitle = get_post_meta($post->ID, 'feature_subtitle', true);
	$feature_type = get_post_meta($post->ID, 'feature_type', true);
	$feature_tax = get_post_meta($post->ID, 'feature_tax', true);
	$feature_term = get_post_meta($post->ID, 'feature_term', true);
	$feature_count = get_post_meta($post->ID, 'feature_count', true);
	$feature_attr = get_post_meta($post->ID, 'feature_attr', true);
	$feature_byline = get_post_meta($post->ID, 'feature_byline', true);
	
	$show_panel_byline = $feature_byline;
	$show_panel_attr = $feature_attr;
	

	if ($show_feature):

		$counter = 1;
		$args = array();
		
		if ($feature_type): $args['post_type'] = $feature_type; else: $args['post_type'] = 'post'; endif;
		if ($feature_count): $args['posts_per_page'] = $feature_count; endif;
		if ($feature_term): 
			$args['tax_query'] = array( 
				array(
					'taxonomy' => $feature_tax,
					'field' => 'id',
					'terms' => $feature_term
				) 
			); 
		endif;
	
    $loop = new WP_Query( $args );
    $count = $loop->post_count;


	?>

  <div class="container slider-feature-container">

	<?php if ($feature_title): ?><h4 class="section-title slider-feature-title orbit-container"><?php echo $feature_title; if ($feature_subtitle): ?><span class="sub-title"><?php echo $feature_subtitle; ?></span><?php endif; ?><a class="orbit-prev"></a><a class="orbit-next"></a></h4><?php endif; ?>
	

		<?php
	    		      		      
	    		        
	    if ($loop->have_posts()) : while ($loop->have_posts()) :
		    $loop->the_post();
		    $do_not_duplicate = $post->ID;
	    


			get_template_part( 'content', 'feature-slider' );

	    endwhile; else: endif; wp_reset_query(); ?>

	</div>
	<?php
	endif;
}


/**
 * Display main feature
 */
function current_main_feature(){

	global $post, $count, $counter, $wp_query;

	$show_slider = get_post_meta($post->ID, 'show_slider', true);
	$slider_type = get_post_meta($post->ID, 'slider_type', true);
	$slider_tax = get_post_meta($post->ID, 'slider_tax', true);
	$slider_term = get_post_meta($post->ID, 'slider_term', true);
	$slider_count = get_post_meta($post->ID, 'slider_count', true);
	
	if ($show_slider):
	?>
	
				<?php
				
				$args = array();
						
				if ($slider_type): $args['post_type'] = $slider_type; else: $args['post_type'] = 'post'; endif;
				if ($slider_count): $args['posts_per_page'] = $slider_count; endif;
				if ($slider_term): 
					$args['tax_query'] = array( 
						array(
							'taxonomy' => $slider_tax,
							'field' => 'id',
							'terms' => $slider_term
						) 
					); 
				endif;
				$counter = 1;
			
	    $loop = new WP_Query( $args );
	    $count = $loop->post_count;
	    		      		      
	    		        
	    if ($loop->have_posts()) : while ($loop->have_posts()) :
		    $loop->the_post();
		    $do_not_duplicate = $post->ID;


			get_template_part( 'content', 'feature' );

	    endwhile; else: endif; wp_reset_query(); ?>
	
	
	<?php
	endif;
}

/**
 * Display Ticker
 */
function current_ticker(){

	global $post, $count, $counter, $wp_query;

  // Load variables  
  include('vars.php'); 
  
  if ($disable_ticker != '0'):
  	$args = array();
  	
  			
    if ($ticker_count): $args['posts_per_page'] = $ticker_count; endif;
    if ($ticker_type): $args['post_type'] = $ticker_type; endif;
  	if ($ticker_cat): $args['cat'] = $ticker_cat; endif;
  	if ($ticker_tag): $args['tag_id'] = $ticker_tag; endif;
  	$counter = 1;
  	  
    $loop = new WP_Query( $args );
    $count = $loop->post_count;
  
  
    if ($loop->have_posts()) : while ($loop->have_posts()) :
      $loop->the_post();
      $do_not_duplicate = $post->ID;
    
    
      get_template_part( 'content', 'ticker' );
      
    
    endwhile; else: endif; wp_reset_query();
    
  endif;
}


/**
 * Checks if sidebar show be shown (returns true or false)
 */
function current_show_sidebar(){

  include('vars.php');
  
  if ( ($show_sidebar != 'hide' && $sidebar_position != 'none') || $show_sidebar == 'show'):
    return true;
  else:
    return false;
  endif;
  

}


/**
 * Displays post thumbnail on single page
 */
function current_show_feature(){
  
  $show_featured = get_post_meta( get_the_ID() , 'show_featured', true);
  
  if (current_show_sidebar()):
    $src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'showcase' );
    $showcase = $src;
  else:
    $src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'showcase-fullscreen' );
    $showcase = $src;
  endif;
  
  $src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full-phone' );
  $full_phone = $src;

  if ($show_featured && has_post_thumbnail()):
  ?>
  
  <img src="<?php echo get_template_directory_uri(); ?>/img/slider-feature.gif" data-interchange="[<?php echo $full_phone[0]; ?>, (only screen and (min-width: 1px))], [<?php echo $showcase[0]; ?>, (only screen and (min-width: 480px))]" class="attachment-showcase" height="<?php echo $showcase[2]; ?>"  width="<?php echo $showcase[1]; ?>" alt="showcase"/>
  
  <?php
  endif;
  
}


/**
 * Displays 728 ad
 */
function current_ad_728(){
	
  include('vars.php');
	
	?>

	<div class="ad-728-container">
	<?php if ($type_ad_728 == 'image'): ?>
		<a href="<?php echo $link_ad_728; ?>" target="_blank"><img src="<?php if (empty($image_ad_728['url'])): echo get_template_directory_uri().'/img/adv/adv-728.png'; else: echo $image_ad_728['url']; endif; ?>" alt="ad728" /></a>
	<?php 
	elseif ($type_ad_728 == 'code'):
		 echo $code_ad_728;
	endif; 
	?>
	</div>
	<?php
}




/**
 * Displays theme preview tool
 */
function current_show_preview() {

  include('vars.php');
  
  if ($enable_preview != 0):
	?>
	<div class="preview-container">
		
		
			<a class="toggle-preview"><i class="fa fa-cog"></i></a>
			
			<div class="preview-options">
			
				<form method="post" class="preview-form">
				
						
							<label><?php _e( 'Sample Color Styles', 'current' ); ?></label>
							<select class="theme-style" name="theme_style">
								<option value="light"><?php _e( 'Default', 'current' ); ?></option>
								<option value="style1"><?php _e( 'Style 1', 'current' ); ?></option>
								<option value="style2"><?php _e( 'Style 2', 'current' ); ?></option>
							</select>

							<label><?php _e( 'Container Type', 'current' ); ?></label>
							<select class="container-type" name="container_type">
								<option value="normal"><?php _e( 'Normal (Default)', 'current' ); ?></option>
								<option value="boxed"><?php _e( 'Boxed', 'current' ); ?></option>
							</select>

							<label><?php _e( 'Hide/Show Header', 'current' ); ?></label>
							<select class="hide-logo-area">
								<option value="show"><?php _e( 'Show (Default)', 'current' ); ?></option>
								<option value="hide"><?php _e( 'Hide', 'current' ); ?></option>
							</select>

							<label><?php _e( 'Hide/Show Navigation Logo', 'current' ); ?></label>
							<select class="enable-nav-logo">
								<option value="show"><?php _e( 'Show (Default)', 'current' ); ?></option>
								<option value="hide"><?php _e( 'Hide', 'current' ); ?></option>
							</select>

							<label><?php _e( 'Fixed Navigation', 'current' ); ?></label>
							<select class="disable-fixed" name="disable_fixed">
								<option value="fixed"><?php _e( 'Fixed (Default)', 'current' ); ?></option>
								<option value="fluid"><?php _e( 'Fluid', 'current' ); ?></option>
							</select>
						
					
				</form>
				
			</div>
		
		
	</div>
	<?php
	endif;
}

/**
 * Displays social media button in navigation
 */
function current_social_links(){

  include('vars.php');
  ?>
  
          <!-- Social Media Links -->
          <?php if ($facebook_url): ?>
          <li><a href="<?php echo $facebook_url; ?>" target="_blank"><i class="fa fa-facebook"></i><span class="icon-label">Facebook</span></a></li>
          <?php endif; ?>
          <?php if ($twitter_url): ?>
          <li><a href="<?php echo $twitter_url; ?>" target="_blank"><i class="fa fa-twitter"></i><span class="icon-label">Twitter</span></a></li>
          <?php endif; ?>
          <?php if ($google_url): ?>
          <li><a href="<?php echo $google_url; ?>" target="_blank"><i class="fa fa-google-plus"></i><span class="icon-label">Google +</span></a></li>
          <?php endif; ?>
          <?php if ($linkedin_url): ?>
          <li><a href="<?php echo $linkedin_url; ?>" target="_blank"><i class="fa fa-linkedin"></i><span class="icon-label">LinkedIn</span></a></li>
          <?php endif; ?>
          <?php if ($instagram_url): ?>
          <li><a href="<?php echo $instagram_url; ?>" target="_blank"><i class="fa fa-instagram"></i><span class="icon-label">Instagram</span></a></li>
          <?php endif; ?>
          <?php if ($youtube_url): ?>
          <li><a href="<?php echo $youtube_url; ?>" target="_blank"><i class="fa fa-youtube"></i><span class="icon-label">Youtube</span></a></li>
          <?php endif; ?>
          <?php if ($pinterest_url): ?>
          <li><a href="<?php echo $pinterest_url; ?>" target="_blank"><i class="fa fa-pinterest"></i><span class="icon-label">Pinterest</span></a></li>
          <?php endif; ?>
          <?php if ($tumblr_url): ?>
          <li><a href="<?php echo $tumblr_url; ?>" target="_blank"><i class="fa fa-tumblr"></i><span class="icon-label">Tubmlr</span></a></li>
          <?php endif; ?>
  
  <?php
}