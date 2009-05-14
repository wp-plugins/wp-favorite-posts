<?php
$wpfp_options = get_option('wpfp_options');
if ( isset($_POST['submit']) ) {
	if ( function_exists('current_user_can') && !current_user_can('manage_options') )
		die(__('Cheatin&#8217; uh?'));
	$wpfp_options['add_favorite'] = addslashes($_POST['add_favorite']);
	$wpfp_options['added'] = addslashes($_POST['added']);
	$wpfp_options['remove_favorite'] = addslashes($_POST['remove_favorite']);
	$wpfp_options['removed'] = addslashes($_POST['removed']);
	$wpfp_options['clear'] = addslashes($_POST['clear']);
	$wpfp_options['cleared'] = addslashes($_POST['cleared']);
	$wpfp_options['favorites_empty'] = addslashes($_POST['favorites_empty']);
	$wpfp_options['rem'] = addslashes($_POST['rem']);
	$wpfp_options['cookie_warning'] = addslashes($_POST['cookie_warning']);
	$wpfp_options['opt_only_registered'] = addslashes($_POST['opt_only_registered']);
	$wpfp_options['text_only_registered'] = addslashes($_POST['text_only_registered']);
	$wpfp_options['statics'] = addslashes($_POST['statics']);

	update_option('wpfp_options', $wpfp_options);
}
?>
<?php if ( !empty($_POST ) ) : ?>
<div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<?php screen_icon(); ?>
<h2><?php _e('Favorite Posts Configuration', 'wp-favorite-posts'); ?></h2>
<div style="float: right; background: #FFFFCC; border: 1px solid #ccc; padding: 1em; width:auto;">
    <img src="../wp-content/plugins/wp-favorite-posts/img/icon_beer.png" alt="buy me a beer" style="float:right; margin: 5px;" />
    <p>If you like this plugin, <br /><strong>buy <a href="http://birazkisisel.com/?f=wpfp">me</a> a beer</strong> !</p>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
        ">
        <input type="image" src="../wp-content/plugins/wp-favorite-posts/img/donate.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
    </form>
    <h4 style="margin-bottom:5px">Last Donors;</h4>
    <iframe frameborder="0" scrolling="no" src="http://nxsn.com/projects/wp-favorite-posts/donorlist/" style="height: 50px; width:200px;" allowtransparency="yes" border="0"></iframe>
</div>
<form action="" method="post" style="float: left;">
<table class="form-table">
	<tr>
		<th><?php _e("Text for add link", "wp-favorite-posts") ?></th><td><input type="text" name="add_favorite" value="<?php echo stripslashes($wpfp_options['add_favorite']); ?>" /></td>
	</tr>
	<tr>
		<th><?php _e("Text for added", "wp-favorite-posts") ?></th><td><input type="text" name="added" value="<?php echo stripslashes($wpfp_options['added']); ?>" /></td>
	</tr>
	<tr>
		<th><?php _e("Text for remove link", "wp-favorite-posts") ?></th><td><input type="text" name="remove_favorite" value="<?php echo stripslashes($wpfp_options['remove_favorite']); ?>" /></td>
	</tr>
	<tr>
		<th><?php _e("Text for removed", "wp-favorite-posts") ?></th><td><input type="text" name="removed" value="<?php echo stripslashes($wpfp_options['removed']); ?>" /></td>
	</tr>
	<tr>
		<th><?php _e("Text for clear link", "wp-favorite-posts") ?></th><td><input type="text" name="clear" value="<?php echo stripslashes($wpfp_options['clear']); ?>" /></td>
	</tr>
	<tr>
		<th><?php _e("Text for cleared", "wp-favorite-posts") ?></th><td><input type="text" name="cleared" value="<?php echo stripslashes($wpfp_options['cleared']); ?>" /></td>
	</tr>
	<tr>
		<th><?php _e("Text for favorites are empty", "wp-favorite-posts") ?></th><td><input type="text" name="favorites_empty" value="<?php echo stripslashes($wpfp_options['favorites_empty']); ?>" /></td>
	</tr>
	<tr>
		<th><?php _e("Text for [remove] link", "wp-favorite-posts") ?></th><td><input type="text" name="rem" value="<?php echo stripslashes($wpfp_options['rem']); ?>" /></td>
	</tr>
	<tr>
		<th><?php _e("Text for favorites saved to cookies", "wp-favorite-posts") ?></th><td><textarea name="cookie_warning" rows="3" cols="35"><?php echo stripslashes($wpfp_options['cookie_warning']); ?></textarea></td>
	</tr>
	<tr>
        <th><?php _e("Text for \"only registered users can favorite\" error message", "wp-favorite-posts") ?></th><td><textarea name="text_only_registered" rows="2" cols="35"><?php echo stripslashes($wpfp_options['text_only_registered']); ?></textarea></td>
	</tr>
	<tr>
		<th><?php _e("Only <strong>registered users</strong> can favorite", "wp-favorite-posts") ?></th><td><input type="checkbox" name="opt_only_registered" value="1" <?php if (stripslashes($wpfp_options['opt_only_registered']) == "1") echo "checked='checked'"; ?> /></td>
    </tr>
	<tr>
        <th><?php _e("Most favorited posts statics", "wp-favorite-posts") ?>*</th>
        <td>
            <label for="stats-enabled"><input type="radio" name="statics" id="stats-enabled" value="1" <?php if ($wpfp_options['statics']) echo "checked='checked'" ?> /> Enabled</label>
            <label for="stats-disabled"><input type="radio" name="statics" id="stats-disabled" value="0" <?php if (!$wpfp_options['statics']) echo "checked='checked'" ?> /> Disabled</label>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p>* If statics enabled plugin will count how much a post added to favorites.<br />
                You can show this statics with <a href="widgets.php" title="Go to widgets">"Most Favorited Posts" widget</a>.</p>
        </td>
    </tr>
	<tr>
        <th></th>
        <td>
            <input type="submit" name="submit" class="button" value="<?php _e('Update options &raquo;'); ?>" />
        </td>
    </tr>
</table>
</form>
</div>
</div>
