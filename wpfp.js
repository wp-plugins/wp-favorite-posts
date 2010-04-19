jQuery(document).ready( function($) {
    $('.wpfp-link').live('click', function() {
        dhis = $(this);
        wpfp_do_js( dhis, 1 );
        // for favorite post listing page
        if (dhis.hasClass('remove-parent')) {
            dhis.parents("li").fadeOut();
        }
        return false;
    });
});

function wpfp_do_js( dhis, doAjax ) {
    loadingImg = dhis.prev();
    loadingImg.show();
    beforeImg = dhis.prev().prev();
    beforeImg.hide();
    url = document.location.href.split('#')[0];
    params = dhis.attr('href').replace('?', '') + '&ajax=1';
    if ( doAjax ) {
        jQuery.get(url, params, function(data) {
                dhis.parent().html(data);
                if(typeof wpfp_after_ajax == 'function') {
                    wpfp_after_ajax( dhis ); // use this like a wp action.                    
                }
                loadingImg.hide();
            }
        );
    }
}

function wpfp_after_ajax( dhis ) {
    params = dhis.attr('href').replace('?', '');     
    post_id = params.match(/postid=\d*/).toString();
    post_id = post_id.match(/\d*$/);
    jQuery.ajax({
        data: ({'wpfp_get_users' : '1', 'post_id': post_id}),
        success: function(msg) {
            jQuery('#wpfp_users_' + post_id).html(msg);
        }
    });
}
