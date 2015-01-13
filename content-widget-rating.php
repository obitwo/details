<?php
/**
 * The template used for displaying page content in widgets *
 * @package current
 */
?>

	    <div class="highest-rated">
	    	
	    	<?php current_rating(); ?>
	    	
    		<div class="rating-list-text">
      		<h4 class="list-heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php current_subtitle(); ?></h4>
    		</div>
    		
	    </div>

