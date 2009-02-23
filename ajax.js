jQuery(document).ready( function($) {
  $("#wpfp-link").click( function() {
    $("#wpfp-loading").removeClass("wpfp-hideloading");
    $("#wpfp-loading").addClass("wpfp-showloading");
    url = document.location.href;
    params = $(this).attr("href");
    params = params.replace("?", "");
    params = params.split("&");
    fav = params[0].split("=")[1];
    post = params[1].split("=")[1];
    url = params[2].split("=")[1];
    $.get(url, {
            favorite: fav,
            post: post,
            url: url
        }, function(data) {
	    $("#wpfp-loading").removeClass("wpfp-showloading");
	    $("#wpfp-loading").addClass("wpfp-hideloading");
            $("#wpfp-span").html(data);
        }
    );
    return false;
  });
});
