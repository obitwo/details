<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package current
 */
 include('inc/vars.php');
?>

  	</div><!-- #content -->
  </div> 
    
  <!-- Footer -->
  <section class="footer-container">
    <footer class="footer container">
      <div class="footer-col">
  			<?php if ( ! dynamic_sidebar( 'footer-1' ) ) : endif; ?>
      </div>
      <div class="footer-col">
  			<?php if ( ! dynamic_sidebar( 'footer-2' ) ) : endif; ?>
      </div>
      <div class="footer-col">
  			<?php if ( ! dynamic_sidebar( 'footer-3' ) ) : endif; ?>
      </div>
    </footer>
    
    <?php if ($copyright): ?>
    <!-- Basement -->
    <div class="basement-container">
      <div class="container basement"><?php echo $copyright; ?></div>
    </div>
    <?php endif; ?>
  </section>
  <!-- end Footer -->
  
  
  </div>
  </div>
  <!-- end off canvas -->

  <?php if ($container_type == 'boxed'): ?>
  </div>
  <?php endif; ?>
  <!-- end boxed -->


<?php wp_footer(); ?>

</body>
</html>
