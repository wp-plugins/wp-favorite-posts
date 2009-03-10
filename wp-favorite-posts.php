<?php
/*
Plugin Name: WP Favorite Posts
Plugin URI: http://birazkisisel.com/projects/wp-favorite-posts/
Description: Allows users to add favorite posts. This plugin use cookies for saving data so unregistered users can favorite a post. Put <code>&lt;?php wpfp_link(); ?&gt;</code> where ever you want on a single post. Then create a page which includes that text : <code>{{wp-favorite-posts}}</code> That's it!
Version: 1.1.7
Author: Hüseyin Berberoğlu
Author URI: http://birazkisisel.com

*/


/*
    Copyright (c) 2009 Hüseyin Berberoğlu (hberberoglu@gmail.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

define('WPFP_PATH', get_settings('home') . '/wp-content/plugins/wp-favorite-posts');

function wpfp_set_cookie($post_id, $str) {
    $expire = time()+60*60*24*30;
    return setcookie("wp-favorite-posts[$post_id]", $str, $expire, "/");
}

function wpfp_check_favorite($cid) {
    if (isset($_COOKIE['wp-favorite-posts'])):
        foreach ($_COOKIE['wp-favorite-posts'] as $post_id => $val) {
            if ($post_id == $cid) {
                return true;
            }
        }
    endif;
    return false;
}

function wpfp_link($return = 0) {
    global $post;
    $str = "<span class='wpfp-span'>";
    $str .= wpfp_loading_img();
    $wpfp_options = get_option('wpfp_options');
    if (wpfp_check_favorite($post->ID)):
        $str .= "<a class='wpfp-link' href='?wpfpaction=remove&amp;postid=" . $post->ID ."' title='". $wpfp_options['remove_favorite'] ."' rel='nofollow'>". $wpfp_options['remove_favorite'] ."</a>";
    else:
        $str .= "<a class='wpfp-link' href='?wpfpaction=add&amp;postid=". $post->ID . "' title='". $wpfp_options['add_favorite'] ."' rel='nofollow'>". $wpfp_options['add_favorite'] ."</a>";
    endif;
    $str .= "</span>";
    if ($return) { return $str; } else { echo $str; }
}

function wpfp_list_favorite_posts($before = "<li>", $after = "</li>") {
    $wpfp_options = get_option('wpfp_options');
    echo "<span class='wpfp-span'>";
    echo "<ul>";
    if (isset($_COOKIE['wp-favorite-posts'])):
        foreach ($_COOKIE['wp-favorite-posts'] as $post_id => $post_title) {
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
    echo wpfp_loading_img();
    echo "<a class='wpfp-link' href='?wpfpaction=clear' rel='nofollow'>". $wpfp_options['clear'] . "</a>";
    echo "</span>";
    echo "<p>".$wpfp_options['cookie_warning']."</p>";
}

function wpfp_loading_img() {
    return "<img src='".WPFP_PATH."/img/loading.gif' alt='Loading' title='Loading' class='wpfp-hideloading wpfp-loading' />";
}

function wp_favorite_posts() {
    $wpfp_options = get_option('wpfp_options');

    if ($_REQUEST['wpfpaction'] == 'add') {
        $a = wpfp_set_cookie($_REQUEST['postid'], "added");
        if ($a) die($wpfp_options['added']);

    } else if ($_REQUEST['wpfpaction'] == 'remove') {
        $a = wpfp_set_cookie($_REQUEST['postid'], "");
        if ($a) die($wpfp_options['removed']);

    } else if ($_REQUEST['wpfpaction'] == 'clear') {
        if (isset($_COOKIE['wp-favorite-posts'])):
            foreach ($_COOKIE['wp-favorite-posts'] as $post_id => $val) {
                wpfp_set_cookie($post_id, "");
            }
        endif;
        die($wpfp_options['cleared']);
    }
}
add_action('template_redirect', 'wp_favorite_posts');

function wpfp_content_filter($content) {
    if (is_page()):
        if (strpos($content,'{{wp-favorite-posts}}')!== false) {
            return str_replace('{{wp-favorite-posts}}', wpfp_list_favorite_posts(), $content);
        }
    endif;
    #if (is_single()):
        if (strpos($content,'[wpfp-link]')!== false) {
            return str_replace('[wpfp-link]', wpfp_link(1), $content);
        }
    #endif;
    return $content;
}
add_filter('the_content','wpfp_content_filter',7);

function wpfp_add_js_script ( ) {
    echo '<link type="text/css" rel="stylesheet" href="' . WPFP_PATH . '/wpfp.css" />' . "\n";
    wp_enqueue_script( "wp-favroite-posts", WPFP_PATH . "/wpfp.js", array( 'jquery' ) );
}
add_action('wp_print_scripts', 'wpfp_add_js_script');

function wpfp_init() {
    $wpfp_options = array();
    $wpfp_options['add_favorite'] = "Add to favorites";
    $wpfp_options['added'] = "Added to favorites!";
    $wpfp_options['remove_favorite'] = "Remove from favorites";
    $wpfp_options['removed'] = "Removed from favorites!";
    $wpfp_options['clear'] = "Clear favorites";
    $wpfp_options['cleared'] = "<p>Favorites cleared!</p>";
    $wpfp_options['favorites_empty'] = "Favorite list is empty.";
    $wpfp_options['cookie_warning'] = "Your favorite posts saved to your browsers cookies. If you clear cookies also favorite posts will be deleted.";
    $wpfp_options['rem'] = "remove";
    add_option('wpfp_options', $wpfp_options, 'Favorite Posts Options');
}
add_action('activate_wp-favorite-posts/wp-favorite-posts.php', 'wpfp_init');

function wpfp_config() { include('wpfp-admin.php'); }

function wpfp_config_page() {
    if ( function_exists('add_submenu_page') )
        add_submenu_page('plugins.php', __('Favorite Posts'), __('Favorite Posts'), 'manage_options', 'wp-favorite-posts', 'wpfp_config');
}
add_action('admin_menu', 'wpfp_config_page');

?>
