<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
  * This class is the main class of the plugin
  *
  * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
  *
  * @since 0.1.0
  */
class WPDTPluginPage
{
    /**
  	  * Main Construct Function
  	  *
  	  * Call functions within class
  	  *
  	  * @since 0.1.0
  	  * @uses WPDTPluginPage::load_dependencies() Loads required filed
  	  * @uses WPDTPluginPage::add_hooks() Adds actions to hooks and filters
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
     * Generates The Content For The Admin Page
     *
     * @since 0.1.0
     */
    public static function generate_page()
    {
      if ( !current_user_can('moderate_comments') ) {
        echo __("You do not have proper authority to access this page",'wordpress-developer-toolkit');
        return '';
      }
      wp_enqueue_style( 'wpdt_admin_style', plugins_url( '../css/admin.css' , __FILE__ ) );
      wp_enqueue_script( 'wpdt_admin_script', plugins_url( '../js/admin.js' , __FILE__ ) );
      if (isset($_POST["refresh_plugins_form"]) && wp_verify_nonce( $_POST['refresh_plugins_nonce'], 'refresh_plugins'))
      {
        $refresh = new WPDTRefresh();
        $refresh->refresh();
      }

      if (isset($_POST["new_plugin"]) && wp_verify_nonce( $_POST['add_plugin_nonce'], 'add_plugin'))
      {
        $new_plugin = sanitize_text_field($_POST["new_plugin"]);
        $response = wp_remote_get( "http://api.wordpress.org/plugins/info/1.0/$new_plugin" );
        $plugin_info = unserialize( $response['body'] );
        $ratings = round(($plugin_info->rating/20), 1);
        global $current_user;
  			get_currentuserinfo();
  			$new_plugin_args = array(
  			  'post_title'    => $plugin_info->name,
  			  'post_content'  => "",
  			  'post_status'   => 'publish',
  			  'post_author'   => $current_user->ID,
  			  'post_type' => 'plugin'
  			);
  			$new_plugin_id = wp_insert_post( $new_plugin_args );
  			add_post_meta( $new_plugin_id, 'plugin_slug', $new_plugin, true );
        add_post_meta( $new_plugin_id, 'average_review', $ratings, true );
        add_post_meta( $new_plugin_id, 'downloads', $plugin_info->downloaded, true );
        add_post_meta( $new_plugin_id, 'version', $plugin_info->version, true );
        add_post_meta( $new_plugin_id, 'last_updated', $plugin_info->last_updated, true );
        add_post_meta( $new_plugin_id, 'description', $plugin_info->sections["description"], true );
        add_post_meta( $new_plugin_id, 'download_link', $plugin_info->download_link, true );
        do_action('wpdt_new_plugin', $plugin_info);
      }

      if (isset($_POST["delete_plugin"]) && wp_verify_nonce( $_POST['delete_plugin_nonce'], 'delete_plugin'))
      {
        $plugin_id = intval($_POST["delete_plugin"]);
        $my_query = new WP_Query( array('post_type' => 'plugin', 'p' => $plugin_id) );
  			if( $my_query->have_posts() )
  			{
  			  while( $my_query->have_posts() )
  				{
  			    $my_query->the_post();
  					$my_post = array(
  				      'ID'           => get_the_ID(),
  				      'post_status' => 'trash'
  				  );
  					wp_update_post( $my_post );
  			  }
  			}
        wp_reset_postdata();
        do_action('wpdt_delete_plugin', $plugin_id);
      }
      $plugin_array = array();
      $my_query = new WP_Query( array('post_type' => 'plugin') );
    	if( $my_query->have_posts() )
    	{
    	  while( $my_query->have_posts() )
    		{
    	    $my_query->the_post();
          $plugin_array[] = array(
            'id' => get_the_ID(),
            'name' => get_the_title(),
            'slug' => get_post_meta( get_the_ID(), 'plugin_slug', true ),
            'permalink' => get_the_permalink(),
            'average_review' => get_post_meta( get_the_ID(), 'average_review', true ),
            'downloads' => get_post_meta( get_the_ID(), 'downloads', true ),
            'last_updated' => get_post_meta( get_the_ID(), 'last_updated', true ),
            'version' => get_post_meta( get_the_ID(), 'version', true ),
          );
    	  }
    	}
    	wp_reset_postdata();
      ?>
      <div class="wrap">
          <h2>WordPress Developer Toolkit</h2>
          <section class="info_section">
            <h3 class="info_section_title"><?php _e('Available Shortcodes','wordpress-developer-toolkit'); ?></h3>
            <div class="info_section_content">
              <div class="templates">
          			<div class="templates_shortcode">
          				<span class="templates_name">[plugin_desc id=?]</span> - <?php _e("Outputs the plugin's description where ? is the id of the plugin below", 'wordpress-developer-toolkit'); ?>
          			</div>
                <div class="templates_shortcode">
          				<span class="templates_name">[plugin_link id=? link=?]</span> - <?php _e("Outputs the link to download the plugin where ? is the id of the plugin below and the text for the link", 'wordpress-developer-toolkit'); ?>
          			</div>
                <div class="templates_shortcode">
          				<span class="templates_name">[plugin_download_count id=?]</span> - <?php _e("Outputs the amount of times the plugin has been downloaded where ? is the id of the plugin below", 'wordpress-developer-toolkit'); ?>
          			</div>
                <div class="templates_shortcode">
          				<span class="templates_name">[plugin_version id=?]</span> - <?php _e("Outputs the version of the plugin where ? is the id of the plugin below", 'wordpress-developer-toolkit'); ?>
          			</div>
                <div class="templates_shortcode">
          				<span class="templates_name">[plugin_rating id=?]</span> - <?php _e("Outputs the average rating of the plugin where ? is the id of the plugin below", 'wordpress-developer-toolkit'); ?>
          			</div>
                <div class="templates_shortcode">
          				<span class="templates_name">[plugin_updated id=?]</span> - <?php _e("Outputs the date of the last time the plugin was updated where ? is the id of the plugin below", 'wordpress-developer-toolkit'); ?>
          			</div>
                <?php do_action('wpdt_extra_shortcodes'); ?>
              </div>
            </div>
          </section>
          <section class="info_section">
            <h3 class="info_section_title"><?php _e('Your Plugins','wordpress-developer-toolkit'); ?><a href="#" onclick="document.refresh_form.submit();" class="add-new-h2">Refresh Now</a></h3>
            <div class="info_section_content">
              <form action="" name="refresh_form" method="post">
                <input type="hidden" name="refresh_plugins_form" value="confirmation" />
                <?php wp_nonce_field('refresh_plugins','refresh_plugins_nonce'); ?>
              </form>
              <table class="widefat">
                <thead>
                  <tr>
                    <th><?php _e('ID','wordpress-developer-toolkit'); ?></th>
                    <th><?php _e('Plugin','wordpress-developer-toolkit'); ?></th>
                    <th><?php _e('Average Rating','wordpress-developer-toolkit'); ?></th>
                    <th><?php _e('Downloads','wordpress-developer-toolkit'); ?></th>
                    <th><?php _e('Version','wordpress-developer-toolkit'); ?></th>
                    <th><?php _e('Last Updated','wordpress-developer-toolkit'); ?></th>
                  </tr>
                </thead>
                <tbody id="the-list">
                  <?php
                  $alternate = "";
                  foreach($plugin_array as $plugin)
                  {
                    if($alternate) $alternate = "";
        						else $alternate = " class=\"alternate\"";
                    echo "<tr{$alternate}>";
                    echo "<td>".$plugin["id"]."</td>";
                    echo "<td>";
                      echo $plugin["name"];
                      echo "<div class=\"row-actions\">
          						      <a class='linkOptions linkDelete' onclick=\"jQuery('#want_to_delete_".$plugin["id"]."').show();\" href='#'>".__('Delete', 'wordpress-developer-toolkit')."</a>
                            <div id='want_to_delete_".$plugin["id"]."' style='display:none;'>
                              <span class='table_text'>".__('Are you sure?','wordpress-developer-toolkit')."</span> <a href='#' onclick=\"wpdt_delete_plugin(".$plugin["id"].");\">".__('Yes','wordpress-developer-toolkit')."</a> | <a href='#' onclick=\"jQuery('#want_to_delete_".$plugin["id"]."').hide();\">".__('No','wordpress-developer-toolkit')."</a>
                            </div>
          						</div>";
                    echo "</td>";
                    echo "<td>".$plugin["average_review"]."</td>";
                    echo "<td>".$plugin["downloads"]."</td>";
                    echo "<td>".$plugin["version"]."</td>";
                    echo "<td>".$plugin["last_updated"]."</td>";
                    echo "</tr>";
                  }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th><?php _e('ID','wordpress-developer-toolkit'); ?></th>
                    <th><?php _e('Plugin','wordpress-developer-toolkit'); ?></th>
                    <th><?php _e('Average Rating','wordpress-developer-toolkit'); ?></th>
                    <th><?php _e('Downloads','wordpress-developer-toolkit'); ?></th>
                    <th><?php _e('Version','wordpress-developer-toolkit'); ?></th>
                    <th><?php _e('Last Updated','wordpress-developer-toolkit'); ?></th>
                  </tr>
                </tfoot>
              </table>
              <form action="" method="post" class="new_plugin_form">
                <h3><?php _e('Add One Of You Plugins','wordpress-developer-toolkit'); ?></h3>
                <label class="new_plugin_form_label"><?php _e("Your Plugin's Slug",'wordpress-developer-toolkit'); ?></label>
                <input type="text" name="new_plugin" class="new_plugin_form_input"/><br />
                <input type="submit" value="<?php _e('Add My Plugin','wordpress-developer-toolkit'); ?>" class="button-primary new_plugin_form_button"/>
                <?php wp_nonce_field('add_plugin','add_plugin_nonce'); ?>
              </form>
              <form action="" method="post" name="delete_plugin_form" style="display:none;">
                <input type="hidden" name="delete_plugin" id="delete_plugin" value="" />
                <?php wp_nonce_field('delete_plugin','delete_plugin_nonce'); ?>
              </form>
            </div>
          </section>
      </div>
      <?php
    }
}
?>
