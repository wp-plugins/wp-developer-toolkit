<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* This class refreshes the information stored for the plugins
*
* When loaded, it loads the included plugin files and add functions to hooks or filters.
*
* @since 0.2.0
*/
class WPDTRefresh
{
    /**
  	  * Main Construct Function
  	  *
  	  * Call functions within class
  	  *
  	  * @since 0.2.0
  	  * @uses WPDTRefresh::load_dependencies() Loads required filed
  	  * @uses WPDTRefresh::add_hooks() Adds actions to hooks and filters
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
  	  * @since 0.2.0
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
  	  * @since 0.2.0
  	  * @return void
  	  */
    public function add_hooks()
    {

    }

    /**
  	  * Refreshes the plugin information stored in the custom post type 'plugin'
  	  *
  	  * @since 0.2.0
  	  * @return void
  	  */
    public function refresh()
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
      wp_reset_postdata();
      foreach($plugins_list as $plugin)
      {
        $slug = $plugin["slug"];
        $id = $plugin["id"];
        $response = wp_remote_get( "http://api.wordpress.org/plugins/info/1.0/$slug" );
        $plugin_info = unserialize( $response['body'] );
        $ratings = round(($plugin_info->rating/20), 1);
        update_post_meta( $id, 'average_review', $ratings );
        update_post_meta( $id, 'downloads', $plugin_info->downloaded );
        update_post_meta( $id, 'version', $plugin_info->version );
        update_post_meta( $id, 'last_updated', $plugin_info->last_updated );
        update_post_meta( $id, 'description', $plugin_info->sections["description"] );
        update_post_meta( $id, 'download_link', $plugin_info->download_link );
      }
    }
}
?>
