<?php
/**
 * current functions and definitions
 *
 * @package current
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 811; /* pixels */
}

if ( ! function_exists( 'current_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function current_setup() {

	if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/redux/ReduxCore/framework.php' ) ) {
		require_once( dirname( __FILE__ ) . '/redux/ReduxCore/framework.php' );
	}
	if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/redux/config.php' ) ) {
		require_once( dirname( __FILE__ ) . '/redux/config.php' );
	}

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on current, use a find and replace
	 * to change 'current' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'current', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'current' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Woocommerce support
	add_theme_support( 'woocommerce' );
	
	// Excerpt Length
  function custom_excerpt_length( $length ) {
  	return 20;
  }
  add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

	include('inc/vars.php');
	
	if ($enable_retina != 1):
	
	//Curent Events custom image sizes
	add_image_size( 'feature', 822, 407, true ); // Small thumbnails, retina
	add_image_size( 'sub-feature', 413, 201, true ); // Small thumbnails, retina
	add_image_size( 'slider-feature', 306, 199, true ); // Small thumbnails, retina
	add_image_size( 'half', 396, 257, true ); // Small thumbnails, retina
	add_image_size( 'half-fullscreen', 603, 392, true ); // Small thumbnails, retina
	add_image_size( 'thumb-list', 90, 60, true ); // Small thumbnails, retina
	add_image_size( 'showcase', 811, 9999, false ); // Small thumbnails, retina
	add_image_size( 'showcase-fullscreen', 1240, 9999, false ); // Small thumbnails, retina
	add_image_size( 'full-phone', 480, 360, true ); // Small thumbnails, retina

  else:
  
	//Curent Events custom image sizes
	add_image_size( 'feature', 1644, 814, true ); // Small thumbnails, retina
	add_image_size( 'sub-feature', 826, 402, true ); // Small thumbnails, retina
	add_image_size( 'slider-feature', 612, 398, true ); // Small thumbnails, retina
	add_image_size( 'half', 792, 514, true ); // Small thumbnails, retina
	add_image_size( 'half-fullscreen', 1206, 784, true ); // Small thumbnails, retina
	add_image_size( 'thumb-list', 180, 120, true ); // Small thumbnails, retina
	add_image_size( 'showcase', 1622, 9999, false ); // Small thumbnails, retina
	add_image_size( 'showcase-fullscreen', 2480, 9999, false ); // Small thumbnails, retina
	add_image_size( 'full-phone', 960, 720, true ); // Small thumbnails, retina
  
  endif;

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'current_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );
}
endif; // current_setup
add_action( 'after_setup_theme', 'current_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */

function current_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'current' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Shop', 'current' ),
		'id'            => 'shop',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );


	register_sidebar( array(
		'name'          => __( 'Footer #1', 'current' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer #2', 'current' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer #3', 'current' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

}
add_action( 'widgets_init', 'current_widgets_init' );


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load theme widgets.
 */
require get_template_directory() . '/inc/widgets.php';


/**
 * Load theme helper functions.
 */
require get_template_directory() . '/inc/helper.php';


/**
 * Load theme meta boxes.
 */
require get_template_directory() . '/inc/meta-boxes.php';



require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins() {
 
    /**
     * Array of plugin arrays. Required keys are name, slug and required.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
 
        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name'      => 'BuddyPress',
            'slug'      => 'buddypress',
            'required'  => false,
        ),
 
        array(
            'name'      => 'bbPress',
            'slug'      => 'bbpress',
            'required'  => false,
        ),

        array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => false,
        ),

        array(
            'name'      => 'Regenerate Thumbnails',
            'slug'      => 'regenerate-thumbnails',
            'required'  => false,
        ),


        array(
            'name'      => 'WP User Avatar',
            'slug'      => 'wp-user-avatar',
            'required'  => false,
        ),
    );
 
    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'current';
 
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'            => $theme_text_domain,           // Text domain - likely want to be the same as your theme.
        'default_path'      => '',                           // Default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'themes.php',         // Default parent menu slug
        'parent_url_slug'   => 'themes.php',         // Default parent URL slug
        'menu'              => 'install-required-plugins',   // Menu slug
        'has_notices'       => true,                         // Show admin notices or not
        'is_automatic'      => false,            // Automatically activate plugins after installation or not
        'message'           => '',               // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                                => __( 'Install Required Plugins', $theme_text_domain ),
            'menu_title'                                => __( 'Install Plugins', $theme_text_domain ),
            'installing'                                => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
            'oops'                                      => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
            'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                                    => __( 'Return to Required Plugins Installer', $theme_text_domain ),
            'plugin_activated'                          => __( 'Plugin activated successfully.', $theme_text_domain ),
            'complete'                                  => __( 'All plugins installed and activated successfully. %s', $theme_text_domain ) // %1$s = dashboard link
        )
    );
 
    tgmpa( $plugins, $config );
 
}

/**
 * Load custom scripts and styles
 */

function current_scripts() {

  include('inc/vars.php');

	// Enqueue styles
	wp_enqueue_style( 'current-style', get_stylesheet_uri() );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:900,700,600,400,300|Pacifico', array(), '' );
	wp_enqueue_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.1/css/font-awesome.css' );
	wp_enqueue_style( 'main', get_template_directory_uri().'/css/main.css' );
	wp_enqueue_style( 'prettyPhoto', get_template_directory_uri().'/css/prettyPhoto.css' );
	

  // Enqueue scripts
	wp_enqueue_script( 'modernizr', get_template_directory_uri().'/js/modernizr.js' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'foundation', get_template_directory_uri().'/js/foundation.min.js', array(), '' ,true );
	wp_enqueue_script( 'foundation-interchange', get_template_directory_uri().'/js/foundation.interchange.js', array(), '' ,true );
	wp_enqueue_script( 'prettyPhoto', get_template_directory_uri().'/js/jquery.prettyPhoto.js', array(), '' ,true );
	wp_enqueue_script( 'main', get_template_directory_uri().'/js/main.js', array(), '' ,true );
	
	wp_enqueue_script( 'current-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'current-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'current-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
		
		
		
	}
	
	if ($enable_preview != 0):
  	wp_enqueue_style( 'current-preview-css', get_template_directory_uri() . '/css/preview.css' );
  	wp_enqueue_script( 'current-preview-js', get_template_directory_uri() . '/js/preview.js', array(), '' ,true );
	endif;

}
add_action( 'wp_enqueue_scripts', 'current_scripts' );

function load_custom_wp_admin_style() {
	wp_enqueue_script( 'jquery-ui-sortable' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment( $fragments ) 
{
    global $woocommerce;
    ob_start(); ?>

    <a href="<?php global $woocommerce; echo $woocommerce->cart->get_cart_url(); ?>" class="button cart-contents"><?php echo sprintf(_n('(%d)', '(%d)', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> <i class="fa fa-shopping-cart"></i><?php if($woocommerce->cart->cart_contents_count > 0): echo ' - '.$woocommerce->cart->get_cart_total(); endif; ?> <span class="icon-label">Shopping Cart</span></a>

    <?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}




add_shortcode('gallery', 'my_gallery_shortcode');    
function my_gallery_shortcode($attr) {
    $post = get_post();

static $instance = 0;
$instance++;

if ( ! empty( $attr['ids'] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty( $attr['orderby'] ) )
        $attr['orderby'] = 'post__in';
    $attr['include'] = $attr['ids'];
}

// Allow plugins/themes to override the default gallery template.
$output = apply_filters('post_gallery', '', $attr);
if ( $output != '' )
    return $output;

// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
if ( isset( $attr['orderby'] ) ) {
    $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
    if ( !$attr['orderby'] )
        unset( $attr['orderby'] );
}

extract(shortcode_atts(array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post->ID,
    'itemtag'    => 'li',
    'icontag'    => 'dt',
    'captiontag' => 'dd',
    'columns'    => 3,
    'size'       => 'thumbnail',
    'include'    => '',
    'exclude'    => ''
), $attr));

$id = intval($id);
if ( 'RAND' == $order )
    $orderby = 'none';

if ( !empty($include) ) {
    $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
        $attachments[$val->ID] = $_attachments[$key];
    }
} elseif ( !empty($exclude) ) {
    $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
} else {
    $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
}

if ( empty($attachments) )
    return '';

if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment )
        $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
    return $output;
}

$itemtag = tag_escape($itemtag);
$captiontag = tag_escape($captiontag);
$icontag = tag_escape($icontag);
$valid_tags = wp_kses_allowed_html( 'post' );
if ( ! isset( $valid_tags[ $itemtag ] ) )
    $itemtag = 'li';
if ( ! isset( $valid_tags[ $captiontag ] ) )
    $captiontag = 'dd';
if ( ! isset( $valid_tags[ $icontag ] ) )
    $icontag = 'dt';

$columns = intval($columns);
$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
$float = is_rtl() ? 'right' : 'left';

$selector = "gallery-{$instance}";

$gallery_style = $gallery_div = '';
if ( apply_filters( 'use_default_gallery_style', true ) )
    $gallery_style = "";
$size_class = sanitize_html_class( $size );
$gallery_div = "<ul id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

$i = 0;
foreach ( $attachments as $id => $attachment ) {
    $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
    
    if (isset($attr['link']) && 'file' == $attr['link']): $link = preg_replace("/<a/","<a rel=\"prettyPhoto[slides]\"",$link,1); endif;
    $link = preg_replace("/<a/","<a class=\"th\"",$link,1);
    if ( $captiontag && trim($attachment->post_excerpt) ) {
        $link = preg_replace("/<a/","<a title=\"".wptexturize($attachment->post_excerpt)."\"",$link,1);
    }
    $output .= "<{$itemtag} class='gallery-item'>";
    $output .= $link;
    $output .= "</{$itemtag}>";
}

$output .= "
    </ul>\n";

return $output;
}

