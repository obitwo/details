<?php
/**
 * The template for displaying search forms in current
 *
 * @package current
 */
 
 include('inc/vars.php');
?>

	<!-- Search Form -->
  <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="search-container">
      <div class="search-input">
        <input type="text" placeholder="<?php echo esc_attr_x( $placeholder_text, 'placeholder', 'current' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php _ex( 'Search for:', 'label', 'current' ); ?>" />
      </div>
      <div class="search-button">
        <button type="submit" class="button postfix"><i class="fa fa-search"></i></button>
      </div>
      <div class="clearfix"></div>
    </div>
  </form>

