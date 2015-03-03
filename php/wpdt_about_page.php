<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
  * This class is the main class of the plugin
  *
  * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
  *
  * @since 0.1.0
  */
class WPDTAboutPage
{
    /**
  	  * Main Construct Function
  	  *
  	  * Call functions within class
  	  *
  	  * @since 0.1.0
  	  * @uses WPDTAboutPage::load_dependencies() Loads required filed
  	  * @uses WPDTAboutPage::add_hooks() Adds actions to hooks and filters
  	  * @return void
  	  */
    function __construct()
    {
      $this->load_dependencies();
      $this->add_hooks();
    }

    /**
  	  * Load File Dependencies
  	  *
  	  * @since 0.1.0
  	  * @return void
  	  */
    public function load_dependencies()
    {

    }

    /**
  	  * Add Hooks
  	  *
  	  * Adds functions to relavent hooks and filters
  	  *
  	  * @since 0.1.0
  	  * @return void
  	  */
    public function add_hooks()
    {

    }

    /**
     * Generates The About/Update Page
     *
     * @since 0.1.0
     */
    public static function generate_page()
    {
      global $mlwWPDeveloperToolkit;
    	$version = $mlwWPDeveloperToolkit->version;
    	wp_enqueue_script( 'jquery' );
      wp_enqueue_style( 'wpdt_admin_style', plugins_url( '../css/admin.css' , __FILE__ ) );
      wp_enqueue_script( 'wpdt_admin_script', plugins_url( '../js/admin.js' , __FILE__ ) );
      ?>
    	<div class="wrap about-wrap">
      	<h1><?php _e('Welcome To WordPress Developer Toolkit', 'wordpress-developer-toolkit'); ?></h1>
      	<div class="about-text"><?php _e('Thank you for updating!', 'wordpress-developer-toolkit'); ?></div>
      	<h2 class="nav-tab-wrapper">
      		<a href="javascript:wpdt_setTab(1);" id="tab_1" class="nav-tab nav-tab-active">
      			<?php _e("What's New!", 'wordpress-developer-toolkit'); ?></a>
      		<a href="javascript:wpdt_setTab(2);" id="tab_2" class="nav-tab">
      			<?php _e('Changelog', 'wordpress-developer-toolkit'); ?></a>
      	</h2>
      	<div id="what_new">
          <h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">New Refresh Button</h2>
        	<p style="text-align: center;">On the admin page, you will now find a new refresh now button which allows you to refresh the data immediately instead of waiting for the next scheduled cron time.</p>
        	<br />
          <h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">New Bar Graph</h2>
        	<p style="text-align: center;">On the stats page, there is a new bar graph comparing the downloads of all your plugins.</p>
        	<br />
          <h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">This Plugin Is Now Translation Ready!</h2>
        	<p style="text-align: center;">For those who wish to assist in translating, you can find the POT in the languages folder. If you do not know what that is, feel free to contact me and I will assist you with it.</p>
        	<br />
          <hr />
          <h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">For Developers:</h2>
        	<br />
          <h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">New Shortcode Hook</h2>
        	<p style="text-align: center;">If you are extending this plugin, you can now hook into the wpdt_extra_shortcodes hook to display your added shortcodes to the list of shortcodes.</p>
        	<br />
          <h2 style="margin: 1.1em 0 .2em;font-size: 2.4em;font-weight: 300;line-height: 1.3;text-align: center;">We Are On GitHub</h2>
        	<p style="text-align: center;">WordPress Developer Toolkit is on GitHub! I would love for you to add suggestions/feedback by creating issues. Feel free to fork and create pull requests too. Be sure to <a href="https://github.com/fpcorso/wordpress-developer-toolkit">check out the repository</a>.</p>
        	<br />
      	</div>
      	<div id="changelog" style="display: none;">
          <h3><?php echo $version; ?> (March 3, 2015)</h3>
        	<ul>
            <li>Added Refresh Now Button <a href="https://github.com/fpcorso/wordpress-developer-toolkit/issues/4">Issue #4</a></li>
            <li>Added Bar Graph Comparing Plugin Downloads <a href="https://github.com/fpcorso/wordpress-developer-toolkit/issues/3">Issue #3</a></li>
            <li>Bug Fix: Fixed Bug Affecting Cron <a href="https://github.com/fpcorso/wordpress-developer-toolkit/issues/5">Issue #5</a></li>
          </ul>
      	</div>

    	</div>
      <?php
    }
}
?>
