<?php

/**
	ReduxFramework Sample Config File
	For full documentation, please visit http://reduxframework.com/docs/
**/


/**
 
	Most of your editing will be done in this section.

	Here you can override default values, uncomment args and change their values.
	No $args are required, but they can be overridden if needed.
	
**/
$args = array();


// For use with a tab example below
$tabs = array();

ob_start();

$ct = wp_get_theme();
$theme_data = $ct;
$item_name = $theme_data->get('Name'); 
$tags = $ct->Tags;
$screenshot = $ct->get_screenshot();
$class = $screenshot ? 'has-screenshot' : '';

$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','current' ), $ct->display('Name') );

?>
<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
	<?php if ( $screenshot ) : ?>
		<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
		<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
			<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
		</a>
		<?php endif; ?>
		<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
	<?php endif; ?>

	<h4>
		<?php echo $ct->display('Name'); ?>
	</h4>

	<div>
		<ul class="theme-info">
			<li><?php printf( __('By %s','current'), $ct->display('Author') ); ?></li>
			<li><?php printf( __('Version %s','current'), $ct->display('Version') ); ?></li>
			<li><?php echo '<strong>'.__('Tags', 'current').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
		</ul>
		<p class="theme-description"><?php echo $ct->display('Description'); ?></p>
		<?php if ( $ct->parent() ) {
			printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
				__( 'http://codex.wordpress.org/Child_Themes','current' ),
				$ct->parent()->display( 'Name' ) );
		} ?>
		
	</div>

</div>

<?php
$item_info = ob_get_contents();
    
ob_end_clean();

$sampleHTML = '';
if( file_exists( dirname(__FILE__).'/info-html.html' )) {
	/** @global WP_Filesystem_Direct $wp_filesystem  */
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once(ABSPATH .'/wp-admin/includes/file.php');
		WP_Filesystem();
	}  		
	$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
}

// BEGIN Sample Config

// Setting dev mode to true allows you to view the class settings/info in the panel.
// Default: true
$args['dev_mode'] = true;

// Set the icon for the dev mode tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: info-sign
//$args['dev_mode_icon'] = 'info-sign';

// Set the class for the dev mode tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['dev_mode_icon_class'] = 'icon-large';

// Set a custom option name. Don't forget to replace spaces with underscores!
$args['opt_name'] = 'opts';

// Setting system info to true allows you to view info useful for debugging.
// Default: false
//$args['system_info'] = true;


// Set the icon for the system info tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: info-sign
//$args['system_info_icon'] = 'info-sign';

// Set the class for the system info tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['system_info_icon_class'] = 'icon-large';

$theme = wp_get_theme();

$args['display_name'] = $theme->get('Name');
//$args['database'] = "theme_mods_expanded";
$args['display_version'] = $theme->get('Version');

// If you want to use Google Webfonts, you MUST define the api key.
$args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

// Define the starting tab for the option panel.
// Default: '0';
//$args['last_tab'] = '0';

// Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
// Default: 'standard'
//$args['admin_stylesheet'] = 'standard';

// Setup custom links in the footer for share icons
/*
$args['share_icons']['twitter'] = array(
    'link' => 'http://twitter.com/ghost1227',
    'title' => 'Follow me on Twitter', 
    'img' => ReduxFramework::$_url . 'assets/img/social/Twitter.png'
);
$args['share_icons']['linked_in'] = array(
    'link' => 'http://www.linkedin.com/profile/view?id=52559281',
    'title' => 'Find me on LinkedIn', 
    'img' => ReduxFramework::$_url . 'assets/img/social/LinkedIn.png'
);
*/

// Enable the import/export feature.
// Default: true
//$args['show_import_export'] = false;

// Set the icon for the import/export tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: refresh
//$args['import_icon'] = 'refresh';

// Set the class for the import/export tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['import_icon_class'] = 'icon-large';

/**
 * Set default icon class for all sections and tabs
 * @since 3.0.9
 */
$args['default_icon_class'] = 'icon-large';


// Set a custom menu icon.
//$args['menu_icon'] = '';

// Set a custom title for the options page.
// Default: Options
$args['menu_title'] = __('Options', 'current');

// Set a custom page title for the options page.
// Default: Options
$args['page_title'] = __('Options', 'current');

// Set a custom page slug for options page (wp-admin/themes.php?page=***).
// Default: redux_options
$args['page_slug'] = 'redux_options';

$args['default_show'] = true;
$args['default_mark'] = '*';

// Set a custom page capability.
// Default: manage_options
//$args['page_cap'] = 'manage_options';

// Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
// Default: menu
//$args['page_type'] = 'submenu';

// Set the parent menu.
// Default: themes.php
// A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'options_general.php';

// Set a custom page location. This allows you to place your menu where you want in the menu order.
// Must be unique or it will override other items!
// Default: null
//$args['page_position'] = null;

// Set a custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';

// Set the icon type. Set to "iconfont" for Elusive Icon, or "image" for traditional.
// Redux no longer ships with standard icons!
// Default: iconfont
//$args['icon_type'] = 'image';

// Disable the panel sections showing as submenu items.
// Default: true
//$args['allow_sub_menu'] = false;
    
// Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.

/*
$args['help_tabs'][] = array(
    'id' => 'redux-opts-1',
    'title' => __('Theme Information 1', 'current'),
    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'current')
);
$args['help_tabs'][] = array(
    'id' => 'redux-opts-2',
    'title' => __('Theme Information 2', 'current'),
    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'current')
);

// Set the help sidebar for the options page.                                        
$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'current');
*/

// Add HTML before the form.
/*if (!isset($args['global_variable']) || $args['global_variable'] !== false ) {
	if (!empty($args['global_variable'])) {
		$v = $args['global_variable'];
	} else {
		$v = str_replace("-", "_", $args['opt_name']);
	}
	$args['intro_text'] = sprintf( __('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'current' ), $v );
} else {
	$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'current');
}
*/

// Add content after the form.
/*
$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'current');
*/

// Set footer/credit line.
//$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'current');


$sections = array();              

//Background Patterns Reader
$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
$sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
$sample_patterns      = array();

if ( is_dir( $sample_patterns_path ) ) :
	
  if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
  	$sample_patterns = array();

    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

      if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
      	$name = explode(".", $sample_patterns_file);
      	$name = str_replace('.'.end($name), '', $sample_patterns_file);
      	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
      }
    }
  endif;
endif;





$sections[] = array(
	'icon' => 'cogs',
	'icon_class' => 'icon-large',
    'title' => __('General Settings', 'current'),
	'fields' => array(
	
	


		array(
			'id'=>'enable_nav_logo',
			'type' => 'switch', 
			'title' => __('Enable navigation logo', 'current'),
			'subtitle'=> __('Switch to use a logo in the navigation.', 'current'),
			'on' => 'Enable',
			'off' => 'Disable',
			'default' => 1,
			),	


		array(
			'id'=>'nav_logo_upload',
			'type' => 'media', 
			'url'=> true,
			'title' => __('Navigation Logo Image Upload', 'current'),
			'compiler' => 'true',
			'subtitle'=> __('Upload navigation logo image. If an image is not loaded the blog title will be displayed in a text format. ', 'current'),
			),


		array(
			'id'=>'hide_logo_area',
			'type' => 'switch', 
			'title' => __('Hide site large title/logo', 'current'),
			'subtitle'=> __('Switch to hide/show site title/logo.', 'current'),
			'on' => 'Show',
			'off' => 'Hide',
			'default' => 0,
			),	


		array(
			'id'=>'logo_upload',
			'type' => 'media', 
			'url'=> true,
			'title' => __('Large Logo Image Upload', 'current'),
			'compiler' => 'true',
			'subtitle'=> __('Upload large main logo image. If an image is not loaded the blog title will be displayed in a text format.', 'current'),
			),


		array(
			'id'=>'fav_icon_upload',
			'type' => 'media', 
			'url'=> true,
			'title' => __('Favicon Image Upload', 'current'),
			'compiler' => 'true',
			'desc'=> __('Upload favicon png image.', 'current'),
			),


		array(
			'id'=>'disable_fixed',
			'type' => 'switch', 
			'title' => __('Disable Fixed Navigation', 'current'),
			'subtitle'=> __('Check box to disable a fixed navigation bar and allow navigation to flow with site content', 'current'),
			'on' => 'Enabled',
			'off' => 'Disabled',
			'default' => 1,
			),	


		array(
			'id'=>'container_type',
			'type' => 'button_set',
			'title' => __('Content Container Type', 'current'),
			'subtitle'=> __('Normal or boxed content container.', 'current'),
			'options' => array('normal' => 'Normal','boxed' => 'Boxed'),//Must provide key => value pairs for radio options
			),	



		array(
			'id'=>'sidebar_position',
			'type' => 'image_select',
			'compiler'=>true,
			'title' => __('Sidebar Position', 'current'), 
			'subtitle' => __('Set the global position of the sidebar. Can be overridden by individual posts and pages.', 'current'),
			'options' => array(
					'none' => array('alt' => '1 Column', 'img' => ReduxFramework::$_url.'assets/img/1col.png'),
					'left' => array('alt' => '2 Column Left', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
					'right' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url.'assets/img/2cr.png')
				),
			'default' => 'right'
			),

		array(
			'id'=>'enable_retina',
			'type' => 'switch', 
			'title' => __('Retina Display', 'current'),
			'subtitle'=> __('Enable retina display for post thumbnails and image logos', 'current'),
			'on' => 'Enabled',
			'off' => 'Disabled',
			'default' => 1,
			),	


		array(
			'id'=>'disable_search',
			'type' => 'switch', 
			'title' => __('Disable Navigation Search Box', 'current'),
			'subtitle'=> __('Check box to disable search box in top navigation bar.', 'current'),
			'on' => 'Enabled',
			'off' => 'Disabled',
			'default' => 1,
			),	


		array(
			'id'=>'archive_format',
			'type' => 'radio',
			'title' => __('Archive List Display Format'), 
			'subtitle' => __('Sets how search, archive, category, and tag listings are displayed. Choose a format.', 'current'),
			'options' => array(
			  '' => __('Blog (Default)','current'), 
			  'panel-excerpt' => __('Image with Excerpt','current'), 
			  //'panel-slider' => __('2 columns slider','current'), 
			  'panel-half' => __('2 columns full','current'), 
			  'panel-small' => __('2 columns small','current'), 
			  'panel-half-small' => __('2 columns wide + small','current')
      ),//Must provide key => value pairs for radio options
			'default' => ''
			),


		array(
			'id'=>'placeholder_text',
			'type' => 'text',
			'title' => __('Search placeholder text', 'current'),
			'subtitle' => __('Set the placeholder text to display for the search field', 'current'),
			'default' => __('Search Site'),
			),				


		array(
			'id'=>'rating_max_count',
			'type' => 'text',
			'title' => __('Number of available ratings', 'current'),
			'subtitle' => __('Set the number of available ratings on a post', 'current'),
			'validate' => 'numeric',
			'default' => '10',
			),				


		array(
			'id'=>'panel_max_count',
			'type' => 'text',
			'title' => __('Number of available panels', 'current'),
			'subtitle' => __('Set the number of available panels for the page builder', 'current'),
			'validate' => 'numeric',
			'default' => '10',
			),				




		array(
			'id'=>'copyright',
			'type' => 'text',
			'title' => __('Copyright Text', 'current'),
			'subtitle' => __('Enter copyright text to be placed in footer', 'current'),
			),				



		array(
			'id'=>'enable_preview',
			'type' => 'switch', 
			'title' => __('Enable Front End Preview', 'current'),
			'subtitle'=> __('Allows front end users to preview certain theme options. Not recommended for live sites.', 'current'),
			"default" 		=> 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
			'default' => 0,
			),	
	)
);


$sections[] = array(
	'icon' => 'font',
	'icon_class' => 'icon-large',
	'title' => __('Typography Options', 'current'),
	'fields' => array(


		array(
			'id'=>'disable_type',
			'type' => 'switch', 
			'title' => __('Disable custom typography', 'current'),
			'subtitle'=> __('Switch to endable/disable any custom typography settings made below.', 'current'),
			"default" 		=> 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),	


		array(
			'id'=>'body_font',
			'type' => 'typography', 
			'title' => __('Gloabl Base Font', 'current'),
			'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup'=>true, // Select a backup non-google font in addition to a google font
			'subsets'=>false, // Only appears if google is true and subsets not set to false
			'line-height'=>false,
			'font-size'=>false,
			'color'=>false,
			'units'=>'', // Defaults to px
			'subtitle'=> __('Typography for global body font', 'current'),
		),


		array(
			'id'=>'logo_font',
			'type' => 'typography', 
			'title' => __('Logo Font (if text logo)', 'current'),
			'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup'=>true, // Select a backup non-google font in addition to a google font
			'subsets'=>false, // Only appears if google is true and subsets not set to false
			'line-height'=>false,
			'font-size'=>false,
			'color'=>false,
			'units'=>'', // Defaults to px
			'subtitle'=> __('Typography for global body font', 'current'),
		),


		array(
			'id'=>'heading_font',
			'type' => 'typography', 
			'title' => __('Heading Base Font', 'current'),
			'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup'=>true, // Select a backup non-google font in addition to a google font
			'subsets'=>false, // Only appears if google is true and subsets not set to false
			'line-height'=>false,
			'font-size'=>false,
			'color'=>false,
			'units'=>'', // Defaults to px
			'subtitle'=> __('Typography for heading fonts (e.g. - h1, h2, h3, ...). Font size not taken into consideration', 'current'),
		),


		array(
			'id'=>'subtitle_font',
			'type' => 'typography', 
			'title' => __('Subtitle Font', 'current'),
			'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup'=>true, // Select a backup non-google font in addition to a google font
			'subsets'=>false, // Only appears if google is true and subsets not set to false
			'line-height'=>false,
			'font-size'=>false,
			'color'=>false,
			'units'=>'', // Defaults to px
			'subtitle'=> __('Typography for heading fonts (e.g. - h1, h2, h3, ...). Font size not taken into consideration', 'current'),
		),



		array(
			'id'=>'nav_font',
			'type' => 'typography', 
			'title' => __('Navigation Base Font', 'current'),
			'google'=>true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup'=>true, // Select a backup non-google font in addition to a google font
			'subsets'=>false, // Only appears if google is true and subsets not set to false
			'line-height'=>false,
			'font-size'=>false,
			'color'=>false,
			'units'=>'', // Defaults to px
			'subtitle'=> __('Typography for top navigation', 'current'),
		),
	)
);

$sections[] = array(
	'icon' => 'website',
	'icon_class' => 'icon-large',
	'title' => __('Color Options', 'current'),
	'fields' => array(


		array(
			'id'=>'disable_style',
			'type' => 'switch', 
			'title' => __('Disable custom styling', 'current'),
			'subtitle'=> __('Switch to enable/disable any custom styling settings made below.', 'current'),
			"default" 		=> 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),	







		array(
			'id'=>'general_color_heading',
			'type' => 'info',
			'title' => __('Global Colors', 'current'), 
        ),


		array(
			'id'=>'site_link_color',
			'type' => 'color',
			'title' => __('Site Link Color', 'current'), 
			'subtitle' => __('Color for global links', 'current'),
			'validate' => 'color',
			),


		array(
			'id'=>'site_hover_color',
			'type' => 'color',
			'title' => __('Site Link Hover Color', 'current'), 
			'subtitle' => __('Color for global hovered links', 'current'),
			'validate' => 'color',
			),
			
			

		array(
			'id'=>'header_heading',
			'type' => 'info',
			'title' => __('Header (hidden by default)', 'current'), 
        ),


		array(
			'id'=>'header_bg_color',
			'type' => 'color',
			'title' => __('Site Logo Background Color', 'current'), 
			'subtitle' => __('Background color for site logo area', 'current'),
			'validate' => 'color',
			),


		array(
			'id'=>'logo_header_color',
			'type' => 'color',
			'title' => __('Header Logo Font Color', 'current'), 
			'subtitle' => __('Font color for the site title', 'current'),
			'validate' => 'color',
			),


		array(
			'id'=>'nav_heading',
			'type' => 'info',
			'title' => __('Navigation', 'current'), 
        ),


		array(
			'id'=>'menu_bg_color',
			'type' => 'color',
			'title' => __('Navigation Background Color', 'current'), 
			'subtitle' => __('Background color for site navigation', 'current'),
			'validate' => 'color',
			),




		array(
			'id'=>'ticker_heading',
			'type' => 'info',
			'title' => __('Ticker Color', 'current'), 
        ),

		array(
			'id'=> 'ticker_title_bg',
			'type' => 'color',
			'title' => __('Ticker Title Background Color', 'current'), 
			'subtitle' => __('Background color for ratings', 'current'),
			'validate' => 'color',
			),


		array(
			'id'=> 'ticker_title_font',
			'type' => 'color',
			'title' => __('Ticker Title Font Color', 'current'), 
			'subtitle' => __('Background color for ratings', 'current'),
			'validate' => 'color',
			),




		array(
			'id'=>'button_heading',
			'type' => 'info',
			'title' => __('Buttons & Form Inputs', 'current'), 
        ),


		array(
			'id'=>'btn_text_color',
			'type' => 'color',
			'title' => __('Button Font Color', 'current'), 
			'subtitle' => __('Button text color (note: background color uses global link color)', 'current'),
			'validate' => 'color',
			),



		array(
			'id'=>'input_btn_bg_color',
			'type' => 'color',
			'title' => __('Input Button Background Color', 'current'), 
			'subtitle' => __('Input (e.g. text or textarea) button background color', 'current'),
			'validate' => 'color',
			),



		array(
			'id'=>'input_btn_text_color',
			'type' => 'color',
			'title' => __('Input Button Font Color', 'current'), 
			'subtitle' => __('Input (e.g. text or textarea) button font color', 'current'),
			'validate' => 'color',
			),
	)
);
	

$sections[] = array(
	'icon' => 'list-alt',
	'icon_class' => 'icon-large',
	'title' => __('Ticker Options', 'current'),
	'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'current'),
	'fields' => array(
		array(
			'id'=>'disable_ticker',
			'type' => 'switch', 
			'title' => __('Disable/Enable ticker', 'current'),
			'subtitle'=> __('Switch to enable/disable ticker.', 'current'),
			"default" 		=> 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),	
		array(
			'id'=>'ticker_title',
			'type' => 'text',
			'title' => __('Ticker Title', 'current'),
			'subtitle' => __('Enter copyright text to be placed in footer', 'current'),
			'default' => 'Recent News'
			),				
		array(
			'id'=>'ticker_count',
			'type' => 'text',
			'title' => __('Ticker Count', 'current'),
			'subtitle' => __('This must be numeric.', 'current'),
			'validate' => 'numeric',
			'default' => '5',
			'class' => 'small-text'
			),				
		array(
			'id'=>'ticker_type',
			'type' => 'select',
			'data' => 'post_type',
			'title' => __('Post Type Select Option', 'current'), 
			'subtitle' => __('No validation can be done on this field type', 'current'),
			'desc' => __('This is the description field, again good for additional info.', 'current'),
			),
		array(
			'id'=>'ticker_cat',
			'type' => 'select',
			'data' => 'categories',
			'title' => __('Categories Select Option', 'current'), 
			'subtitle' => __('No validation can be done on this field type', 'current'),
			'desc' => __('This is the description field, again good for additional info.', 'current'),
			),
		array(
			'id'=>'ticker_tag',
			'type' => 'select',
			'data' => 'tags',
			'title' => __('Tags Select Option', 'current'), 
			'subtitle' => __('No validation can be done on this field type', 'current'),
			'desc' => __('This is the description field, again good for additional info.', 'current'),
			),
		)
	);
		


$sections[] = array(
	'icon' => 'group',
	'icon_class' => 'icon-large',
	'title' => __('Social Media Options', 'current'),
	'fields' => array(
		
		array(
			'id'=>'facebook_url',
			'type' => 'text',
			'title' => __('Facebook', 'current'),
			'subtitle' => __('Enter your Facebook URL', 'current'),
			),				


		array(
			'id'=>'twitter_url',
			'type' => 'text',
			'title' => __('Twitter', 'current'),
			'subtitle' => __('Enter your Twitter URL', 'current'),
			),				


		array(
			'id'=>'google_url',
			'type' => 'text',
			'title' => __('Google +', 'current'),
			'subtitle' => __('Enter your Google Plus URL', 'current'),
			),				


		array(
			'id'=>'youtube_url',
			'type' => 'text',
			'title' => __('Youtube', 'current'),
			'subtitle' => __('Enter your Youtube URL', 'current'),
			),				


		array(
			'id'=>'instagram_url',
			'type' => 'text',
			'title' => __('Instagram', 'current'),
			'subtitle' => __('Enter your Instgram URL', 'current'),
			),				


		array(
			'id'=>'pinterest_url',
			'type' => 'text',
			'title' => __('Pinterest', 'current'),
			'subtitle' => __('Enter your Pinterest URL', 'current'),
			),				


		array(
			'id'=>'linkedin_url',
			'type' => 'text',
			'title' => __('LinkedIn', 'current'),
			'subtitle' => __('Enter your LinkedIn URL', 'current'),
			),				


		array(
			'id'=>'tumblr_url',
			'type' => 'text',
			'title' => __('Tumblr', 'current'),
			'subtitle' => __('Enter your Tumblr URL', 'current'),
			),				
	)
);


$sections[] = array(
	'icon' => 'bullhorn',
	'icon_class' => 'icon-large',
	'title' => __('Advertisements', 'current'),
	'fields' => array(
		
		array(
			'id'=>'hide_ad_728',
			'type' => 'switch', 
			'title' => __('Hide/Show 728 x 190 pixel ad', 'current'),
			'subtitle'=> __('Switch to hide/show 728 x 190 pixel advertisement.', 'current'),
			'on' => 'Show',
			'off' => 'Hide',
			'default' => 0,
			),	


		array(
			'id'=>'type_ad_728',
			'type' => 'button_set',
			'title' => __('Type of 728 x 190 pixel ad', 'current'),
			'subtitle'=> __('Use a custom image and link or code (ie. Google Adsense code) for the 728 x 190 pixel advertisement.', 'current'),
			'options' => array('image' => 'Image + Link','code' => 'Code'),//Must provide key => value pairs for radio options
			'default' => 'image'
			),	


		array(
			'id'=>'image_ad_728',
			'type' => 'media', 
			'url'=> true,
			'title' => __('Image for 728 x 190 pixel ad', 'current'),
			'compiler' => 'true',
			'subtitle'=> __('Image for the 728 x 190 pixel advertisement.', 'current'),
			),


		array(
			'id'=>'link_ad_728',
			'type' => 'text',
			'title' => __('Link for 728 x 190 pixel ad', 'current'),
			'subtitle'=> __('Link for the 728 x 190 pixel advertisement.', 'current'),
			),				


		array(
			'id'=>'code_ad_728',
			'type' => 'textarea',
			'title' => __('Code for 728 x 190 pixel ad', 'current'),
			'subtitle'=> __('Code (i.e. Google Adsense code) for the 728 x 190 pixel advertisement.', 'current'),
			),


	)
);


		

if (function_exists('wp_get_theme')){
$theme_data = wp_get_theme();
$theme_uri = $theme_data->get('ThemeURI');
$description = $theme_data->get('Description');
$author = $theme_data->get('Author');
$version = $theme_data->get('Version');
$tags = $theme_data->get('Tags');
}else{
$theme_data = wp_get_theme(trailingslashit(get_stylesheet_directory()).'style.css');
$theme_uri = $theme_data['URI'];
$description = $theme_data['Description'];
$author = $theme_data['Author'];
$version = $theme_data['Version'];
$tags = $theme_data['Tags'];
}	

$theme_info = '<div class="redux-framework-section-desc">';
$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'current').'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'current').$author.'</p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'current').$version.'</p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$description.'</p>';
if ( !empty( $tags ) ) {
	$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'current').implode(', ', $tags).'</p>';	
}
$theme_info .= '</div>';

if(file_exists(dirname(__FILE__).'/README.md')){
$tabs['theme_docs'] = array(
			'icon' => ReduxFramework::$_url.'assets/img/glyphicons/glyphicons_071_book.png',
			'title' => __('Documentation', 'current'),
			'content' => file_get_contents(dirname(__FILE__).'/README.md')
			);
}//if





$tabs['item_info'] = array(
	'icon' => 'info-sign',
	'icon_class' => 'icon-large',
    'title' => __('Theme Information', 'current'),
    'content' => $item_info
);

if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
    $tabs['docs'] = array(
		'icon' => 'book',
		'icon_class' => 'icon-large',
        'title' => __('Documentation', 'current'),
        'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
    );
}

global $ReduxFramework;
$ReduxFramework = new ReduxFramework($sections, $args, $tabs);

// END Sample Config


/**
 
 	Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 	Simply include this function in the child themes functions.php file.
 
 	NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
 	so you must use get_template_directory_uri() if you want to use any of the built in icons
 
 **/
function add_another_section($sections){
    //$sections = array();
    $sections[] = array(
        'title' => __('A Section added by hook', 'current'),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'current'),
		'icon' => 'paper-clip',
		'icon_class' => 'icon-large',
        // Leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}
add_filter('redux-opts-sections-redux-sample', 'add_another_section');


/**

	Custom function for filtering the args array given by a theme, good for child themes to override or add to the args array.

**/
function change_framework_args($args){
    //$args['dev_mode'] = false;
    
    return $args;
}
//add_filter('redux-opts-args-redux-sample-file', 'change_framework_args');





/** 

	Custom function for the callback referenced above

 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

/**
 
	Custom function for the callback validation referenced above

**/
function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value =  'just testing';
    /*
    do your validation
    
    if(something) {
        $value = $value;
    } elseif(something else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
    }
    */
    
    $return['value'] = $value;
    if($error == true) {
        $return['error'] = $field;
    }
    return $return;
}

/**

	This is a test function that will let you see when the compiler hook occurs. 
	It only runs if a field	set with compiler=>true is changed.

**/
function testCompiler() {
	//echo "Compiler hook!";
}
add_action('redux-compiler-redux-sample-file', 'testCompiler');



/**

	Use this code to hide the activation notice telling users about a sample panel.

**/
if ( class_exists('ReduxFrameworkPlugin') ) {
	//remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );	
}

/**

	Use this code to hide the demo mode link from the plugin page. Only used when Redux is a plugin.

**/
function removeDemoModeLink() {
	if ( class_exists('ReduxFrameworkPlugin') ) {
		remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2 );
	}
}
//add_action('init', 'removeDemoModeLink');




