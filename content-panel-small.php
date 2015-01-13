<?php
global $count, $counter;
$src = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'thumb-list' );
$thumb = $src;
?> 

<?php if ($counter == 1): ?>
<ul class="panel-content">
<?php endif; ?>

    <li>
      <div class="thumb-list">
        <a href="<?php the_permalink(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/thumb-list.gif" data-interchange="[<?php echo $thumb[0]; ?>, (only screen and (min-width: 1px))]" class="attachment-thumb-list" height="<?php echo $thumb[2]; ?>" width="<?php echo $thumb[1]; ?>" alt="thumb-list" /></a>
        <div class="thumb-list-text">
          <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php current_subtitle(); ?></h4>
        </div>
        <div class="clearfix"></div>
      </div>
    </li>


<?php if ($counter == $count) :?>
</ul>
<?php endif; $counter++;?>