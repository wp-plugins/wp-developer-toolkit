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
      $plugins_list = array();
      $my_query = new WP_Query( array('post_type' => 'plugin') );
    	if( $my_query->have_posts() )
    	{
    	  while( $my_query->have_posts() )
    		{
    	    $my_query->the_post();
          $plugins_list[] = array(
            'slug' => get_post_meta( get_the_ID(), 'plugin_slug', true ),
            'id' => get_the_ID()
          );
    	  }
    	}
      foreach($plugins_list as $plugin)
      {
        $slug = $plugin["slug"];
        $id = $plugin["id"];
        $response = wp_remote_get( "http://api.wordpress.org/plugins/info/1.0/$slug" );
        $plugin_info = unserialize( $response['body'] );
        $ratings = round(($plugin_info->rating/20), 1);
        add_post_meta( $id, 'average_review', $ratings );
        add_post_meta( $id, 'downloads', $plugin_info->downloaded );
        add_post_meta( $id, 'version', $plugin_info->version );
        add_post_meta( $id, 'last_updated', $plugin_info->last_updated );
        add_post_meta( $id, 'description', $plugin_info->sections["description"] );
        add_post_meta( $id, 'download_link', $plugin_info->download_link );
      }
    }
}

?>
