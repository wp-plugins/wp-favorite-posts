jQuery(document).ready( function($) {
  $(".wpfp-link").click( function() {
    $(this).prepend($("wpfp-loading"));
    $("#wpfp-loading").removeClass("wpfp-hideloading");
    $("#wpfp-loading").addClass("wpfp-showloading");
    url = document.location.href;
    params = $(this).attr("href");
    params = params.replace("?", "");
    $.get(url, params, function(data) {
	    $("#wpfp-loading").removeClass("wpfp-showloading");
	    $("#wpfp-loading").addClass("wpfp-hideloading");
            $("#wpfp-span").html(data);
        }
    );
    return false;
  });
});
