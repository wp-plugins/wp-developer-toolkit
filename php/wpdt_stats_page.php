<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
  * This class is the main class of the plugin
  *
  * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
  *
  * @since 0.1.0
  */
class WPDTStatsPage
{
    /**
  	  * Main Construct Function
  	  *
  	  * Call functions within class
  	  *
  	  * @since 0.1.0
  	  * @uses WPDTStatsPage::load_dependencies() Loads required filed
  	  * @uses WPDTStatsPage::add_hooks() Adds actions to hooks and filters
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
     * Genereate The Stats Page
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
      wp_enqueue_script( 'wpdt_chartjs_script', plugins_url( '../js/Chart.min.js' , __FILE__ ) );
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

      $downloads = 0;
      $ratings = 0;
      $rated = 0;
      $plugin_labels = "";
      $plugin_values = "";
      $total_plugins = count($plugin_array);
      foreach($plugin_array as $plugin)
      {
        $downloads += $plugin["downloads"];
        if ($plugin["average_review"] != 0)
        {
          $ratings += $plugin["average_review"];
          $rated += 1;
        }
        $plugin_labels .= '"'.$plugin["name"].'",';
        $plugin_values .= $plugin["downloads"].',';
      }
      $ratings = round($ratings/$rated, 2);
      $average_downloads = round($downloads/$total_plugins, 2);
      ?>
      <div class="wrap">
        <h2><?php _e('Your Stats','wordpress-developer-toolkit'); ?></h2>
        <div class="stat_section">
          <div class="stat_section_title"><?php _e('Total Plugins','wordpress-developer-toolkit'); ?></div>
          <div class="stat_section_count">
            <?php echo $total_plugins; ?>
          </div>
        </div>
        <div class="stat_section">
          <div class="stat_section_title"><?php _e('Average Downloads','wordpress-developer-toolkit'); ?></div>
          <div class="stat_section_count">
            <?php echo $average_downloads; ?>
          </div>
        </div>
        <div class="stat_section">
          <div class="stat_section_title"><?php _e('Average Rating','wordpress-developer-toolkit'); ?></div>
          <div class="stat_section_count">
            <?php echo $ratings; ?>
          </div>
        </div>
        <div class="stat_section">
          <div class="stat_section_title"><?php _e('Total Downloads','wordpress-developer-toolkit'); ?></div>
          <div class="stat_section_count">
            <?php echo $downloads; ?>
          </div>
        </div>
          <div class="stat_section">
            <div class="stat_section_title"><?php _e('Total Plugin Downloads','wordpress-developer-toolkit'); ?></div>
            <div class="stat_section_count">
              <canvas id="plugin_bar_graph" width="500" height="500"/>
            </div>
          </div>
        <div>

      	</div>
      	<script>
        var plugin_bar_data = {
            labels: [<?php echo $plugin_labels; ?>],
            datasets: [
                {
                    label: "My First dataset",
                    fillColor: "rgba(151,187,205,0.5)",
                    strokeColor: "rgba(151,187,205,0.8)",
                    highlightFill: "rgba(151,187,205,0.75)",
                    highlightStroke: "rgba(151,187,205,1)",
                    data: [<?php echo $plugin_values; ?>]
                },
            ]
        };
        window.onload = function(){
    			var plugin_bar_ctx = document.getElementById("plugin_bar_graph").getContext("2d");
    			window.plugin_bar_graph = new Chart(plugin_bar_ctx).Bar(plugin_bar_data, {
    				responsive: true
    			});
        }
      	</script>
      </div>
      <?php
     }
}

?>
