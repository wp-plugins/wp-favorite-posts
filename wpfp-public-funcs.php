<?php
function wpfp_link($return = 0) {
    global $post;
    $str = "<span class='wpfp-span'>";
    $str .= wpfp_before_link_img();
    $str .= wpfp_loading_img();
    $wpfp_options = wpfp_get_options();
    if (wpfp_check_favorited($post->ID)):
        $str .= "<a class='wpfp-link' href='?wpfpaction=remove&amp;postid=" . $post->ID ."' title='". $wpfp_options['remove_favorite'] ."' rel='nofollow'>". $wpfp_options['remove_favorite'] ."</a>";
    else:
        $str .= "<a class='wpfp-link' href='?wpfpaction=add&amp;postid=". $post->ID . "' title='". $wpfp_options['add_favorite'] ."' rel='nofollow'>". $wpfp_options['add_favorite'] ."</a>";
    endif;
    $str .= "</span>";
    if ($return) { return $str; } else { echo $str; }
}

function wpfp_list_favorite_posts($before = "<li>", $after = "</li>") {
    $wpfp_options = wpfp_get_options();
    $favorite_post_ids = array();

    # collect favorites from cookie and if user is logged in from database.
    if (is_user_logged_in()):
        $favorite_post_ids = wpfp_get_user_meta();
    endif;

    if (wpfp_get_cookie()):
        foreach (wpfp_get_cookie() as $post_id => $post_title) {
            array_push($favorite_post_ids, $post_id);
        }
    endif;
    # list favorites
    echo "<span class='wpfp-span'>";
    echo "<ul>";
    if ($favorite_post_ids):
        foreach ($favorite_post_ids as $post_id) {
            $p = get_post($post_id);
            echo $before;
            echo "<a href='".get_permalink($post_id)."' title='". $p->post_title ."'>" . $p->post_title . "</a> ";
            echo "[<a class='wpfp-link' href='?wpfpaction=remove&amp;postid=". $post_id ."' title='".$wpfp_options['rem']."' rel='nofollow'>".$wpfp_options['rem']."</a>]";
            echo $after;
        }
    else:
        echo $before;
        echo $wpfp_options['favorites_empty'];
        echo $after;
    endif;
    echo "</ul>";
    echo wpfp_before_link_img();
    echo wpfp_loading_img();
    echo "<a class='wpfp-link' href='?wpfpaction=clear' rel='nofollow'>". $wpfp_options['clear'] . "</a>";
    echo "</span>";
    echo "<p>".$wpfp_options['cookie_warning']."</p>";
}
function wpfp_clear_favorites() {
    if (wpfp_get_cookie()):
        foreach (wpfp_get_cookie() as $post_id => $val) {
            wpfp_set_cookie($post_id, "");
            wpfp_update_post_meta($post_id, -1);
        }
    endif;
    if (is_user_logged_in()) {
        $favorite_post_ids = wpfp_get_user_meta();
        if ($favorite_post_ids):
            foreach ($favorite_post_ids as $post_id) {
                wpfp_update_post_meta($post_id, -1);
            }
        endif;
        if (!delete_usermeta(wpfp_get_current_user_id(), WPFP_META_KEY)) {
            return false;
        }
    }
    return true;
}
function wpfp_remove_favorite($post_id) {
    $a = true;
    if (is_user_logged_in()) {
        $user_favorites = wpfp_get_user_meta();
        $user_favorites = array_diff($user_favorites, array($post_id));
        $user_favorites = array_values($user_favorites);
        $a = wpfp_update_user_meta($user_favorites);
    }
    if ($a) $a = wpfp_set_cookie($_REQUEST['postid'], "");
    return $a;
}

