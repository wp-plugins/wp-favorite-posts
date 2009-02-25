=== WP Favorite Posts ===
Contributors: Hüseyin Berberoğlu
Donate link: http://birazkisisel.com/projects/wp-favorite-posts
Tags: favorite, posts, favorites, cookie, wp-favorite-posts
Requires at least: 2.0.2
Tested up to: 2.7.1
Stable tag: 1.1.4

Allows visitors to add favorite posts. This plugin use cookies for saving data so
unregistered users can favorite a post.

== Description ==

Allows users to add favorite posts. This plugin use cookies for saving data so
unregistered users can favorite a post. There is no register requirement.

If you use WP Super Cache you must add page (which you show favorites) URI to "Accepted Filenames &
Rejected URIs".

See [ChangeLog](http://svn.wp-plugins.org/wp-favorite-posts/trunk/ChangeLog.txt
"ChangeLog.txt") to learn what's different between versions.

== Installation ==

1. Unzip into your `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php wpfp_link(); ?>` in your single.php template
file. Then favorite this post link will appear in all posts.
1. Create a page e.g. "Your Favorites" and insert `{{wp-favorite-posts}}`
text into content section. This page will contain users favorite posts.
1. That's it :)
