<?php
/**
 * The template used for displaying page content in widgets *
 * @package current
 */
 
 global $wp_query;
?>

	    <div class="featured-posts thumb-list">
	    
	    	<?php if(has_post_thumbnail()): ?>
		    	
          <div class="thumb-box thumb-img">
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('half'); ?></a>
            <?php current_post_info(); ?>
          </div>
		    	
        <?php endif;?>
			
        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php current_subtitle(); ?></h4>

	    </div>

