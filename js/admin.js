function wpdt_delete_plugin(id)
{
  jQuery('#delete_plugin').val(id);
  document.delete_plugin_form.submit();
}

function wpdt_setTab(tab) {
  jQuery("a.nav-tab-active").toggleClass("nav-tab-active");
  if (tab == 1)
  {
    jQuery("#what_new").show();
    jQuery("#changelog").hide();
    jQuery("#tab_1").toggleClass("nav-tab-active");
  }
  if (tab == 2)
  {
    jQuery("#what_new").hide();
    jQuery("#changelog").show();
    jQuery("#tab_2").toggleClass("nav-tab-active");
  }
}
