<?php
if ( isset($_POST['submit']) ) {
	if ( function_exists('current_user_can') && !current_user_can('manage_options') )
		die(__('Cheatin&#8217; uh?'));
	$wpfp_options = array();
	$wpfp_options['add_favorite'] = addslashes($_POST['add_favorite']);
	$wpfp_options['added'] = addslashes($_POST['added']);
	$wpfp_options['remove_favorite'] = addslashes($_POST['remove_favorite']);
	$wpfp_options['removed'] = addslashes($_POST['removed']);
	$wpfp_options['clear'] = addslashes($_POST['clear']);
	$wpfp_options['cleared'] = addslashes($_POST['cleared']);
	$wpfp_options['favorites_empty'] = addslashes($_POST['favorites_empty']);
	$wpfp_options['rem'] = addslashes($_POST['rem']);
	$wpfp_options['cookie_warning'] = addslashes($_POST['cookie_warning']);

	update_option('wpfp_options', $wpfp_options);
}
$wpfp_options = get_option('wpfp_options');
?>
<?php if ( !empty($_POST ) ) : ?>
<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', 'wpfp') ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
<?php screen_icon(); ?>
<h2><?php _e('Favorite Posts Configuration', 'wp-favorite-posts'); ?></h2>
<form action="" method="post">
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
		<th><?php _e("Text for [remove]", "wp-favorite-posts") ?></th><td><input type="text" name="rem" value="<?php echo stripslashes($wpfp_options['rem']); ?>" /></td>
	</tr>
	<tr>
		<th><?php _e("Text for favorites saved to cookies", "wp-favorite-posts") ?></th><td><textarea name="cookie_warning" rows="2" cols="40"><?php echo stripslashes($wpfp_options['cookie_warning']); ?></textarea></td>
	</tr>
	<tr>
		<th></th><td><input type="submit" name="submit" class="button" value="<?php _e("Save Changes", "wp-favorite-posts") ?>" /></td>
	</tr>
</table>
</form>
</div>
