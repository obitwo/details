<?php
/**
 * The template used for displaying page content in widgets *
 * @package current
 */
?>

	    <div class="featured-posts thumb-list">
	    	
			<?php if(has_post_thumbnail()): ?>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb-list'); ?></a>
			<div class="thumb-list-text">
			<?php endif; ?>
	    		<h4 class="list-heading">
	    			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	    			<?php current_subtitle(); ?>
	    		</h4>

	    	<?php if(has_post_thumbnail()): ?>
	    	</div>
	    	<div class="clearfix"></div>
	    	<?php endif; ?>
	    </div>

