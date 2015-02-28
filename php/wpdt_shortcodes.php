<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
  * This class is the main class of the plugin
  *
  * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
  *
  * @since 0.1.0
  */
class WPDTShortcodes
{
    /**
  	  * Main Construct Function
  	  *
  	  * Call functions within class
  	  *
  	  * @since 0.1.0
  	  * @uses WPDTShortcodes::load_dependencies() Loads required filed
  	  * @uses WPDTShortcodes::add_hooks() Adds actions to hooks and filters
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
      add_shortcode('plugin_desc', array($this, 'display_description'));
      add_shortcode('plugin_link', array($this, 'display_download_link'));
      add_shortcode('plugin_download_count', array($this, 'display_download_count'));
      add_shortcode('plugin_version', array($this, 'display_version'));
      add_shortcode('plugin_rating', array($this, 'display_rating'));
      add_shortcode('plugin_updated', array($this, 'display_updated'));
    }

    /**
     * Shortcode To Display Plugin Description
     *
     * @since 0.1.0
     * @return string The plugin description
     */
    public function display_description($atts)
    {
      extract(shortcode_atts(array(
  			'id' => 0
  		), $atts));

      $shortcode = '';
      $id = intval($id);

      $my_query = new WP_Query(array('post_type' => 'plugin', 'p' => $id));
			if( $my_query->have_posts() )
			{
			  while( $my_query->have_posts() )
				{
			    $my_query->the_post();
          $shortcode .= get_post_meta( get_the_ID(), 'description', true );
			  }
			}
			wp_reset_postdata();
      return $shortcode;
    }

    /**
     * Shortcode To Display Plugin Download Link
     *
     * @since 0.1.0
     * @return string The link to the plugin file
     */
    public function display_download_link($atts)
    {
      extract(shortcode_atts(array(
  			'id' => 0,
        'link' => __('Download','wordpress-developer-toolkit')
  		), $atts));

      $shortcode = '';
      $id = intval($id);

      $my_query = new WP_Query(array('post_type' => 'plugin', 'p' => $id));
			if( $my_query->have_posts() )
			{
			  while( $my_query->have_posts() )
				{
			    $my_query->the_post();
          $href = get_post_meta( get_the_ID(), 'download_link', true );
          $shortcode .= "<a href='$href'>".esc_html($link)."</a>";
			  }
			}
			wp_reset_postdata();
      return $shortcode;
    }

    /**
     * Shortcode To Display Plugin Download Count
     *
     * @since 0.1.0
     * @return string The download count
     */
    public function display_download_count($atts)
    {
      extract(shortcode_atts(array(
  			'id' => 0
  		), $atts));

      $shortcode = '';
      $id = intval($id);

      $my_query = new WP_Query(array('post_type' => 'plugin', 'p' => $id));
			if( $my_query->have_posts() )
			{
			  while( $my_query->have_posts() )
				{
			    $my_query->the_post();
          $shortcode .= get_post_meta( get_the_ID(), 'downloads', true );
			  }
			}
			wp_reset_postdata();
      return $shortcode;
    }

    /**
     * Shortcode To Display Plugin Version
     *
     * @since 0.1.0
     * @return string The pluign version
     */
    public function display_version($atts)
    {
      extract(shortcode_atts(array(
  			'id' => 0
  		), $atts));

      $shortcode = '';
      $id = intval($id);

      $my_query = new WP_Query(array('post_type' => 'plugin', 'p' => $id));
			if( $my_query->have_posts() )
			{
			  while( $my_query->have_posts() )
				{
			    $my_query->the_post();
          $shortcode .= get_post_meta( get_the_ID(), 'version', true );
			  }
			}
			wp_reset_postdata();
      return $shortcode;
    }

    /**
     * Shortcode To Display Plugin Average Rating
     *
     * @since 0.1.0
     * @return string The average rating
     */
    public function display_rating($atts)
    {
      extract(shortcode_atts(array(
  			'id' => 0
  		), $atts));

      $shortcode = '';
      $id = intval($id);

      $my_query = new WP_Query(array('post_type' => 'plugin', 'p' => $id));
			if( $my_query->have_posts() )
			{
			  while( $my_query->have_posts() )
				{
			    $my_query->the_post();
          $shortcode .= get_post_meta( get_the_ID(), 'average_review', true ).__(' out of 5 stars', 'wordpress-developer-toolkit');
			  }
			}
			wp_reset_postdata();
      return $shortcode;
    }

    /**
     * Shortcode To Display When Plugin Was Last Updated
     *
     * @since 0.1.0
     * @return string The date of the last update
     */
    public function display_updated($atts)
    {
      extract(shortcode_atts(array(
  			'id' => 0
  		), $atts));

      $shortcode = '';
      $id = intval($id);

      $my_query = new WP_Query(array('post_type' => 'plugin', 'p' => $id));
			if( $my_query->have_posts() )
			{
			  while( $my_query->have_posts() )
				{
			    $my_query->the_post();
          $shortcode .= get_post_meta( get_the_ID(), 'last_updated', true );
			  }
			}
			wp_reset_postdata();
      return $shortcode;
    }
}
$wpdtShortcodes = new WPDTShortcodes();
?>
