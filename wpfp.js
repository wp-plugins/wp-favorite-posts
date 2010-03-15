jQuery(document).ready( function($) {
  $(".wpfp-link").live('click', function() {
    dataBack = $(this).parent();
    loadingImg = $(this).prev();
    beforeImg = $(this).prev().prev();
    beforeImg.addClass("wpfp-hide");
    loadingImg.removeClass("wpfp-hide");
    loadingImg.addClass("wpfp-showloading");
    url = document.location.href.split('#')[0];
    params = $(this).attr("href").replace('?', '') + "&ajax=1";
    $.get(url, params, function(data) {
            loadingImg.removeClass("wpfp-showloading");
    //        loadingImg.addClass("wpfp-hide");
            dataBack.html(data);
        }
    );
    return false;
  });
});
