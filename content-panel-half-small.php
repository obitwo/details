<?php
global $count, $counter, $panel_sidebar;

if ($panel_sidebar):
  $src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'half' );
  $half = $src;
else:
  $src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'half-fullscreen' );
  $half = $src;
endif;
$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full-phone' );
$full_phone = $src;

?> 

<?php if ($counter == 1): ?>
<ul class="panel-content half-small-container">
    <li>
      <div class="thumb-box thumb-img">
        <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/panel-slider.gif" data-interchange="[<?php echo $full_phone[0]; ?>, (only screen and (min-width: 1px))], [<?php echo $half[0]; ?>, (only screen and (min-width: 480px))]" class="attachment-half" height="<?php echo $half[2]; ?>" width="<?php echo $half[1]; ?>" alt="panel-half" /></a>
        <?php current_post_info(); ?>
      </div>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?><?php current_subtitle(); ?></a></h3>
        <?php current_short_byline(); ?>
    </li>
<?php endif; ?>

<?php if ($counter == 2): ?>
    <li>
<?php endif; ?>
    
<?php if ($counter > 1 && $counter < 6): ?>
      <div class="thumb-list">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumb-list'); ?></a>
        <div class="thumb-list-text">
          <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php current_subtitle(); ?></h4>
        </div>
        <div class="clearfix"></div>
      </div>
      
  <?php if ($counter == 5 || $counter == $count): ?>
    </li>
  <?php endif; ?>

<?php endif; ?>

<?php if ($counter > 5): ?>
    <li>
      <div class="thumb-list">
        <?php the_post_thumbnail('thumb-list'); ?>
        <div class="thumb-list-text">
          <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php current_subtitle(); ?></h4>
        </div>
        <div class="clearfix"></div>
      </div>
    </li>

<?php endif; ?>


<?php if ($counter == $count) :?>
</ul>
<?php endif; $counter++;?>