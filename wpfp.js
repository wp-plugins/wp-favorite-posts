jQuery(document).ready( function($) {
  $('.wpfp-link').live('click', function() {
    dis = $(this);
    dataBack = dis.parent();
    loadingImg = dis.prev();
    beforeImg = dis.prev().prev();
    beforeImg.addClass('wpfp-hide');
    loadingImg.removeClass('wpfp-hide');
    loadingImg.addClass('wpfp-showloading');
    url = document.location.href.split('#')[0];
    params = dis.attr('href').replace('?', '') + '&ajax=1';
    $.get(url, params, function(data) {
            loadingImg.removeClass('wpfp-showloading');
            dataBack.html(data);
        }
    );
    if (dis.hasClass('remove-parent')) {
        dis.parent().fadeOut();
    }
    return false;
  });
});
