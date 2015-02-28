<?php
function wpdt_update()
{
  global $mlwWPDeveloperToolkit;
  $data = $mlwWPDeveloperToolkit->version;
  if ( ! get_option('wpdt_version'))
  {
    add_option('wpdt_version' , $data);
  }
  elseif (get_option('wpdt_version') != $data)
  {
    update_option('wpdt_version' , $data);
    /*
    if(!isset($_GET['activate-multi']))
    {
      wp_safe_redirect( admin_url( 'index.php?page=wpdt_about' ) );
      exit;
    }
    */
  }
}
?>
