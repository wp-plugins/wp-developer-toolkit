<?php
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

      	</div>
      	<div id="changelog" style="display: none;">
          
      	</div>

    	</div>
      <?php
    }
}
?>
