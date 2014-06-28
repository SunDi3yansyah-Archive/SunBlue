jQuery.noConflict()
jQuery(function($) {
var pmcontents = jQuery(".pm_notification").text();
	if(pmcontents == 0){
		$(".pm_notification").hide();
	} else { return false; };
});