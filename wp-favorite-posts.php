<?php
/*
Plugin Name: WP Favorite Posts
Plugin URI: http://nxsn.com/my-projects/wp-favorite-posts-plugin/
Description: Allows users to add favorite posts. This plugin use cookies for saving data so unregistered users can favorite a post. Put <code>&lt;?php wpfp_link(); ?&gt;</code> where ever you want on a single post. Then create a page which includes that text : <code>{{wp-favorite-posts}}</code> That's it!
Version: 1.3.1
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

include('wpfp-config.php');
include('wpfp-public-funcs.php');

add_action('template_redirect', 'wp_favorite_posts');
add_filter('the_content','wpfp_content_filter',7);
add_action('wp_print_scripts', 'wpfp_add_js_script');
add_action('activate_wp-favorite-posts/wp-favorite-posts.php', 'wpfp_init');
add_action('admin_menu', 'wpfp_config_page');
add_action('widgets_init', 'wpfp_widget_init');

function wp_favorite_posts() {
    $wpfp_options = wpfp_get_options();

    if (isset($_REQUEST['wpfpaction'])):
        if ($_REQUEST['wpfpaction'] == 'add') {
            if ($wpfp_options['opt_only_registered'] && !is_user_logged_in() ):
                die($wpfp_options['text_only_registered']);
            else:
                if (is_user_logged_in()) {
                    $a = wpfp_add_to_usermeta($_REQUEST['postid']);
                } else {
                    $a = wpfp_set_cookie($_REQUEST['postid'], "added");
                }
                if ($a) {
                    if ($wpfp_options['statics']) wpfp_update_post_meta($_REQUEST['postid'], 1);
                    die($wpfp_options['added']);
                }
                else die("ERROR");
            endif;
        } else if ($_REQUEST['wpfpaction'] == 'remove') {
            if (wpfp_remove_favorite($_REQUEST['postid'])) {
                if ($wpfp_options['statics']) wpfp_update_post_meta($_REQUEST['postid'], -1);
                die($wpfp_options['removed']);
            }
            else die("ERROR");
        } else if ($_REQUEST['wpfpaction'] == 'clear') {
            if (wpfp_clear_favorites()) die($wpfp_options['cleared']);
            else die("ERROR");
        }
    endif;
}

function wpfp_add_to_usermeta($post_id) {
    $wpfp_favorites = array();
    $wpfp_favorites = wpfp_get_user_meta();
    $wpfp_favorites[] = $post_id;
    wpfp_update_user_meta($wpfp_favorites);
    return true;
}

function wpfp_check_favorited($cid) {
    if (is_user_logged_in()):
        $favorite_post_ids = wpfp_get_user_meta();
        if ($favorite_post_ids)
            foreach ($favorite_post_ids as $fpost_id)
                if ($fpost_id == $cid) return true;
    endif;
    if (wpfp_get_cookie()):
        foreach (wpfp_get_cookie() as $fpost_id => $val)
            if ($fpost_id == $cid) return true;
    endif;
    return false;
}

function wpfp_loading_img() {
    return "<img src='".WPFP_PATH."/img/loading.gif' alt='Loading' title='Loading' class='wpfp-hide wpfp-img' />";
}
function wpfp_before_link_img() {
    $options = wpfp_get_options();
    $option = $options['before_image'];
    if ($option == '') {
        return "";
    } else if ($option == 'custom') {
        return "<img src='" . $options['custom_before_image'] . "' alt='Favorite' title='Favorite' class='wpfp-img' />";
    } else {
        return "<img src='". WPFP_PATH . "/img/" . $option . "' alt='Favorite' title='Favorite' class='wpfp-img' />";
    }
}

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

function wpfp_add_js_script ( ) {
    echo '<link type="text/css" rel="stylesheet" href="' . WPFP_PATH . '/wpfp.css" />' . "\n";
    wp_enqueue_script( "wp-favroite-posts", WPFP_PATH . "/wpfp.js", array( 'jquery' ) );
}

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
    $wpfp_options['text_only_registered'] = "Only registered users can favorite!";
    $wpfp_options['statics'] = 1;
    $wpfp_options['widget_title'] = '';
    $wpfp_options['widget_limit'] = 5;
    $wpfp_options['before_image'] = 'star.png';
    $wpfp_options['custom_before_image'] = '';
    add_option('wpfp_options', $wpfp_options, 'Favorite Posts Options');
}


function wpfp_config() { include('wpfp-admin.php'); }

function wpfp_config_page() {
    if ( function_exists('add_submenu_page') )
        add_submenu_page('plugins.php', __('Favorite Posts'), __('Favorite Posts'), 'manage_options', 'wp-favorite-posts', 'wpfp_config');
}

function wpfp_update_user_meta($arr) {
    return update_usermeta(wpfp_get_current_user_id(),WPFP_META_KEY,$arr);
}

function wpfp_update_post_meta($post_id, $val) {
    $val = wpfp_get_post_meta($post_id) + $val;
    return add_post_meta($post_id, WPFP_META_KEY, $val, true) or update_post_meta($post_id, WPFP_META_KEY, $val);
}

function wpfp_delete_post_meta($post_id) {
    return delete_post_meta($post_id, WPFP_META_KEY);
}
function wpfp_list_most_favorited($limit=5) {
    global $wpdb;
    $query = "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key='".WPFP_META_KEY."' AND meta_value > 0 ORDER BY CAST(meta_value AS DECIMAL) DESC LIMIT 0, $limit";
    $results = $wpdb->get_results($query);
    if ($results) {
        echo "<ul>";
        foreach ($results as $o):
            echo "<li>";
            $p = get_post($o->post_id);
            echo "<a href='".get_permalink($o->post_id)."' title='". $p->post_title ."'>" . $p->post_title . "</a> ($o->meta_value)";
            echo "</li>";
            echo $post->post_id;
        endforeach;
        echo "</ul>";
    }
}
function wpfp_widget_init() {
    function wpfp_widget_view($args) {
        extract($args);
        $options = wpfp_get_options();
        if (isset($options['widget_limit'])) {
            $limit = $options['widget_limit'];
        }
        $title = empty($options['widget_title']) ? 'Most Favorited Posts' : $options['widget_title'];
        echo $before_widget;
        echo $before_title
             . $title
             . $after_title;
        wpfp_list_most_favorited($limit);
        echo $after_widget;
    }
    function wpfp_widget_control() {
        $options = wpfp_get_options();
        if (isset($_POST["wpfp-widget-submit"])):
            $options['widget_title'] = strip_tags(stripslashes($_POST['wpfp-title']));
            $options['widget_limit'] = strip_tags(stripslashes($_POST['wpfp-limit']));
            update_option("wpfp_options", $options);
        endif;
        $title = $options['widget_title'];
        $limit = $options['widget_limit'];
    ?>
        <p>
            <label for="wpfp-title">
                <?php _e('Title:'); ?> <input type="text" value="<?php echo $title; ?>" class="widefat" id="wpfp-title" name="wpfp-title" />
            </label>
        </p>
        <p>
            <label for="wpfp-limit">
                <?php _e('Number of posts to show:'); ?> <input type="text" value="<?php echo $limit; ?>" style="width: 28px; text-align:center;" id="wpfp-limit" name="wpfp-limit" />
            </label>
        </p>
        <?php if (!$options['statics']) { ?>
        <p>
            You must enable statics from favorite posts <a href="plugins.php?page=wp-favorite-posts" title="Favorite Posts Configuration">configuration page</a>.
        </p>
        <?php } ?>
        <input type="hidden" name="wpfp-widget-submit" value="1" />
    <?php
    }
    register_sidebar_widget('Most Favorited Posts', 'wpfp_widget_view');
    register_widget_control('Most Favorited Posts', 'wpfp_widget_control' );
}

//---\\
function wpfp_get_cookie() {
    return $_COOKIE[WPFP_COOKIE_KEY];
}

function wpfp_get_options() {
   return get_option('wpfp_options');
}

function wpfp_get_current_user_id() {
    global $current_user;
    get_currentuserinfo();
    return $current_user->ID;
}

function wpfp_get_user_meta() {
    return get_usermeta(wpfp_get_current_user_id(), WPFP_META_KEY);
}

function wpfp_get_post_meta($post_id) {
    $val = get_post_meta($post_id, WPFP_META_KEY, true);
    if ($val < 0) $val = 0;
    return $val;
}

function wpfp_set_cookie($post_id, $str) {
    $expire = time()+60*60*24*30;
    return setcookie("wp-favorite-posts[$post_id]", $str, $expire, "/");
}
