<?php
    echo "<span class='wpfp-span'>";
    echo "<ul>";
    if ($favorite_post_ids):
        foreach ($favorite_post_ids as $post_id) {
            $p = get_post($post_id);
            echo $before;
            echo "<a href='".get_permalink($post_id)."' title='". $p->post_title ."'>" . $p->post_title . "</a> ";
            echo "[<a class='wpfp-link' href='?wpfpaction=remove&amp;page=1&amp;postid=". $post_id ."' title='".$wpfp_options['rem']."' rel='nofollow'>".$wpfp_options['rem']."</a>]";
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
    if (!is_user_logged_in()):
        echo "<p>".$wpfp_options['cookie_warning']."</p>";
    endif;
