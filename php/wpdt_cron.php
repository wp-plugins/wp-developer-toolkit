<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
  * This class is the main class of the plugin
  *
  * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
  *
  * @since 0.1.0
  */
class WPDTCron
{
    /**
  	  * Main Construct Function
  	  *
  	  * Call functions within class
  	  *
  	  * @since 0.1.0
  	  * @uses WPDTCron::load_dependencies() Loads required filed
  	  * @uses WPDTCron::add_hooks() Adds actions to hooks and filters
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
      add_action( 'plugins_loaded', array($this, 'cron_check') );
      add_action( 'wpdt_nightly_event', array($this,'cron') );
    }

    /**
     * Checks To See If Cron Is Already Schedule. If Not Schedules Cron
     *
     * @since 0.1.0
     */
    public function cron_check()
    {
      if ( ! wp_next_scheduled( 'wpdt_nightly_event' ) ) {
    		wp_schedule_event( current_time('timestamp'), 'daily', 'wpdt_nightly_event');
    	}
    }

    /**
     * Updates The Plugin Information With The Latest From The Repository
     *
     * @since 0.1.0
     */
    public function cron()
    {
      $refresh = new WPDTRefresh();
      $refresh->refresh();
    }
}

?>
