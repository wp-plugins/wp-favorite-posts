<?php
/*
Plugin Name: WP Favorite Posts
Plugin URI: http://birazkisisel.com/projects/wp-favorite-posts/
Description: Allows users to add favorite posts. This plugin use cookies for saving data so unregistered users can favorite a post. Put <code>&lt;?php wpfp_link(); ?&gt;</code> where ever you want on a single post. Then create a page which includes that text : <code>{{wp-favorite-posts}}</code> That's it!
Version: 1.1.2
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

function set_cookie($url, $post) {
    $expire = time()+60*60*24*30;
    return setcookie("wp-favorite-posts[$url]", $post, $expire, "/");
}

function clear_favorites() {
    if (isset($_COOKIE['wp-favorite-posts'])):
        foreach ($_COOKIE['wp-favorite-posts'] as $url => $post_title) {
            set_cookie($url, "");
        }
    endif;
}

function check_favorite($str) {
    if (isset($_COOKIE['wp-favorite-posts'])):
        foreach ($_COOKIE['wp-favorite-posts'] as $url => $post_title) {
            if ($url == $str) {
                return true;
            }
        }
    endif;
    return false;
}

function wpfp_link() {
    global $post;
    echo "<span id='wpfp-span'>";
    echo "<img id='wpfp-loading' src='".WPFP_PATH."/img/loading.gif' alt='Loading' title='Loading' class='wpfp-hideloading' />";
    $wpfp_options = get_option('wpfp_options');
    if (check_favorite($post->ID)):
        echo "<a id='wpfp-link' href='?favorite=remove&post=". $post->post_title ."&url=" . $post->ID ."' title='". $wpfp_options['remove_favorite'] ."'>". $wpfp_options['remove_favorite'] ."</a>";
    else:
        echo "<a id='wpfp-link' href='?favorite=add&post=". $post->post_title ."&url=". $post->ID . "' title='". $wpfp_options['add_favorite'] ."'>". $wpfp_options['add_favorite'] ."</a>";
    endif;
    echo "</span>";
}

function wp_favorite_posts() {
    $wpfp_options = get_option('wpfp_options');
    if ($_REQUEST['favorite'] == 'add') {
        set_cookie($_REQUEST['url'], $_REQUEST['post']);
        die($wpfp_options['added']);
    } else if ($_REQUEST['favorite'] == 'remove') {
        set_cookie($_REQUEST['url'], '');
        die($wpfp_options['removed']);
    } else if ($_REQUEST['favorite'] == 'clear') {
        clear_favorites();
        die($wpfp_options['cleared']);
    }
}

function add_js_script ( ) {
	echo '<link type="text/css" rel="stylesheet" href="' . WPFP_PATH . '/wpfp.css" />' . "\n";
	wp_enqueue_script( "wp-favroite-posts", path_join(WP_PLUGIN_URL, basename( dirname( __FILE__ ) )."/ajax.js"), array( 'jquery' ) );
}

function list_favorite_posts($before = "<li>", $after = "</li>") {
    $wpfp_options = get_option('wpfp_options');
    echo "<span id='wpfp-span'>";
    echo "<ul>";
    if (isset($_COOKIE['wp-favorite-posts'])):
        foreach ($_COOKIE['wp-favorite-posts'] as $url => $post_title) {
            echo $before;
            echo "<a href='".get_bloginfo('url')."/?p=$url'>" . $post_title . "</a> ";
            echo $after;
        }
    else:
        echo $before;
        echo $wpfp_options['favorites_empty'];
        echo $after;
    endif;
    echo "</ul>";

    echo "<img id='wpfp-loading' src='".WPFP_PATH."/img/loading.gif' alt='Loading' title='Loading' class='wpfp-hideloading' />";
    echo "<a id='wpfp-link' href='?favorite=clear'>". $wpfp_options['clear'] . "</a>";
    echo "</span>";
    echo "<p>".$wpfp_options['cookie_warning']."</p>";
}

function wpfp_content_filter($content) {
        if (strpos($content,'{{wp-favorite-posts}}')!== false) {
                return str_replace('{{wp-favorite-posts}}', list_favorite_posts(), $content);
        }
	return $content;
}
 
add_action('wp_print_scripts', 'add_js_script');
add_action('template_redirect', 'wp_favorite_posts');
add_filter('the_content','wpfp_content_filter',7);

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
	add_option('wpfp_options', $wpfp_options, 'Favorite Posts Options');
}
add_action('activate_wp-favorite-posts/wp-favorite-posts.php', 'wpfp_init');
add_action('admin_menu', 'wpfp_config_page');

function wpfp_config_page() {
	if ( function_exists('add_submenu_page') )
		add_submenu_page('plugins.php', __('Favorite Posts'), __('Favorite Posts'), 'manage_options', 'wp-favorite-posts', 'wpfp_config');

}

function wpfp_config() {
	include('wpfp-admin.php');
}
?>
