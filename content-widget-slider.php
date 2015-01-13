<?php
global $count, $counter;

$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'half' );
$half = $src;
$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full-phone' );
$full_phone = $src;

?> 

<?php if ($counter == 1): ?>
        <ul data-orbit data-options="animation: fade; slide_number: false; timer: false; bullets: false; variable_height: true">
<?php endif; ?>

    <li data-orbit-slide="widget-slide-<?php echo $counter; ?>">
      <div class="thumb-box">
        <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/panel-slider.gif" data-interchange="[<?php echo $full_phone[0]; ?>, (only screen and (min-width: 1px))], [<?php echo $half[0]; ?>, (only screen and (min-width: 480px))]" class="attachment-half" height="<?php echo $half[2]; ?>" width="<?php echo $half[1]; ?>" alt="widget-slider" /></a>
        <div class="caption">
          <h4 class="caption-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          <div class="caption-content">
            <?php current_subtitle(); ?>
            <?php current_short_byline(); ?>
          </div>
        </div>
        <?php current_post_info(); ?>
      </div>
    </li>


<?php if ($counter == $count) :?>
        </ul>
<?php endif; $counter++;?>