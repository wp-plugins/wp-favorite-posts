=== WP Favorite Posts ===
Contributors: Huseyin Berberoglu
Donate link: http://nxsn.com.com/my-projects/wp-favorite-posts-plugin
Tags: favorite posts, favorite, favourite, posts, favorites,
wp-favorite-posts, reading list, post list, post lists, lists
Requires at least: 2.0.2
Tested up to: 3.0.3
Stable tag: 1.5.4

Allows visitors to add favorite posts. This plugin use cookies for saving data so
unregistered users can favorite a post.

== Description ==

Allows users to add favorite posts. This plugin use cookies and database for
saving data.

- If a user logged in then favorites data will saved in database instead of cookies.
- If user not logged in data will saved in cookies.

You can choose "only registered users can favorite a post" option, if you want.
Also there is a widget named "Most Favorited Posts". And you can use this template
tag for listing most favorited posts;

<h2>Most Favorited Posts</h2>
<?php wpfp_list_most_favorited(5); ?>

If you use WP Super Cache you must add page (which you show favorites) URI to "Accepted Filenames &
Rejected URIs".

See [more details about
plugin](http://nxsn.com/my-projects/wp-favorite-posts/)

== Installation ==

1. Unzip into your `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php if (function_exists('wpfp_link')) { wpfp_link(); } ?>` in your
single.php or page.php template file. Then favorite this post link will appear in all posts.
1. OR if you DO NOT want the favorite link to appear in every post/page, DO NOT
use the code above. Just type in [wpfp-link] into the selected post/page
content and it will embed the print link into that post/page only.
1. Create a page e.g. "Your Favorites" and insert `{{wp-favorite-posts}}`
text into content section. This page will contain users favorite posts.
1. That's it :)

== Screenshots ==
1. Options
2. Label Settings
3. Advanced Settings

== Changelog ==
= 1.5.4 =
2011-11-23 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* BUGFIX: Thanks to @spectrus http://wordpress.org/support/topic/plugin-wp-favorite-posts-major-bug-getting-user-favourites?replies=1#post-2465141
	
= 1.5.3 =
2011-11-23 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* NEW FEATURE: Added don't load js/css file option. If you don't 
	want to load wp favorite post's js/css file, use these options. 
	
= 1.5.2 =
2010-12-27 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* FIX: Change the user's favorites wigdet title bug fixed.

= 1.5.1 =
2010-06-04 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Little JS fix. Thanks to Heather Wallace.

= 1.4.3.2 =
2010-04-23 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Show only published posts on most favorited posts widget

= 1.4.3 =
2010-04-13 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Admin can write html codes to label settings (on admin page)
	* Added "wpfp_link_html" and "wpfp_remove_favorite_link" filters.

= 1.4.3 =
2010-04-09 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Fix: same remove link for all posts on index
	* better wpfp.js: remove li which on favorites page.

= 1.4.1 =
2010-04-05 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* code refactor, add do_action for add and remove to list (#225575)
	* update admin page

2010-03-29 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Fix plugin path, fixes image loading problems (#222902)

= 1.4 =
2010-03-20 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Override page template if wpfp-page-template.php exists on template
	directory.
	* Add [wp-favorite-posts] shortcode. Use shortcode instead of
	{{wp-favorite-posts}}

= 1.3.5 =
2010-03-17 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Fix meta key issue.

= 1.3.4 =
2010-03-16 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Fix wpfp-span issue

= 1.3.3 =
2010-03-16 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Fixed regression: if javascript doesn't work change to non-ajax mode.
	This fixes 'only text' pages. 

2010-02-15 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* If user logged in don't show cookie warning at "your favorites" page.
	* Added "show remove link" and "show add link" options. 
	You can show remove link when someone add a favorite.
	Similary You can show add link when someone remove a favorite.

= 1.3.1 =
2009-06-10 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Added Before Link Image feature.
	* Refactor code and imporve DRY
	* Fixed bug: Most favorite list's string sorting problem 2 > 11
	* Fixed bug: Clear link not updating post's favorited count

= 1.3 =
2009-05-31 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Fixed bug: Plugin was working wrong in pages with links includes # character.
	* Added template tag for Most Favorite Posts. There was already a widget for this.

= 1.2.1 =
2009-05-14 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Added "Most Favorited Posts" widget.

2009-04-30 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Added "buy me a beer" section to admin page.
	* Added favorite statistic feature.

= 1.2 =
2009-04-26 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Added database integration. 
		- If a user logged in then favorites data will save to database instead of cookies.
		- If user not logged in data will save to cookies.
	* Added "only registered users can favorite" option.

= 1.1.7 =
2009-03-10 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Fixed duplicate loading image problem
	* Added [wpfp-link] feature;
		You can show favorite link only in preferred posts with writing
		[wpfp-link] to the post content.

= 1.1.6 =
2009-03-05 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Fixed ajax problem.

= 1.1.5 =
2009-03-02 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Added rel="nofollow" to links.
	* Favorite posts title language problem solved.
	* ajax.js file renamed to wpfp.js

2009-03-02 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Use XHTML valid links.
	* Use class instead of id for html elements.
	* Use more unique function names. All functions starts with wpfp.

= 1.2.1 =
2009-05-14 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Added "Most Favorited Posts" widget.

2009-04-30 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Added "buy me a beer" section to admin page.
	* Added favorite statistic feature.

= 1.2 =
2009-04-26 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Added database integration. 
		- If a user logged in then favorites data will save to database instead of cookies.
		- If user not logged in data will save to cookies.
	* Added "only registered users can favorite" option.

= 1.1.7 =
2009-03-10 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Fixed duplicate loading image problem
	* Added [wpfp-link] feature;
		You can show favorite link only in preferred posts with writing
		[wpfp-link] to the post content.

= 1.1.6 =
2009-03-05 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Fixed ajax problem.

= 1.1.5 =
2009-03-02 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Added rel="nofollow" to links.
	* Favorite posts title language problem solved.
	* ajax.js file renamed to wpfp.js

2009-03-02 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Use XHTML valid links.
	* Use class instead of id for html elements.
	* Use more unique function names. All functions starts with wpfp.

= 1.1.4 =
2009-02-24 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Use permalinks favorite links.
	* Users can remove a single favorite post from favorite posts page.

= 1.1.3 =
2009-02-24 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Clear Favorites now works.
	* Favorite list is xhtml valid now.

= 1.1.2 =
2009-02-24 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Save button fixed which in options page.

= 1.1.1 =
2009-02-24 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Cleared wrong code.

= 1.1 =
2009-02-24 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* Fixed permalink problem. Now works with all types of permalink.

= 1.0 =
2009-02-23 Hüseyin Berberoğlu <hberberoglu@gmail.com>
	* First Release of WP-Favorite Posts
