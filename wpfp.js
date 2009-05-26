jQuery(document).ready( function($) {
  $(".wpfp-link").click( function() {
    dataBack = $(this).parent();
    loadingImg = $(this).prev();
    loadingImg.removeClass("wpfp-hideloading");
    loadingImg.addClass("wpfp-showloading");
    url = document.location.href.split('#')[0];
    params = $(this).attr("href").replace('?', '');
    $.get(url, params, function(data) {
            loadingImg.removeClass("wpfp-showloading");
            loadingImg.addClass("wpfp-hideloading");
            dataBack.html(data);
        }
    );
    return false;
  });
});
