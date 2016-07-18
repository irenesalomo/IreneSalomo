<?php
/*
Plugin Name: FeatureMe
Plugin URI: http://www.bioxd.com/featureme
Description: FeatureMe allows you to manage a featured entries list for your blog
Version: 0.9
Author: Oscar Alcalá
Author URI: http://www.oscaralcala.com/
*/

/*

INSTRUCTIONS:

FeatureMe allows you to manage a list of your favourite entries. Just drop it on your plugins folder and you are good to go.

The plugin automatically adds a checkbox to the write and edit post page so you can easily add and remove entries from your list.

To display the featured posts just call show_featured_posts() on your sidebar or wherever you want them to appear.

If you have any cooments or ideas for the plugin please go to http://www.bioxd.com/featureme and leave a comment.

*/

//Installer
function install_featureme() {
	
	global $wpdb, $table_prefix;
	
	$table_name = $table_prefix.'features';
	
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE $table_name (
					id mediumint(9) NOT NULL AUTO_INCREMENT,
					date datetime NOT NULL,
					UNIQUE KEY id(id)
				);";
		$rs = $wpdb->query($sql);
	}
	
}


//Checks to see if a table exists
function table_exists($tablen) {
	global $wpdb;
	$exists = FALSE;
	$tables = mysql_list_tables($DB_NAME);
	foreach($tables as $table -> $table_name) {
		if ($table_name == $tablen) { $exists = TRUE; }
	}
	
	return $exists;
}


//Marks a post as featured
function add_featured_post($post_id) {
	global $wpdb, $table_prefix;
	
	if(isset($_POST['featured']) and $_POST['featured'] == "featured" and !featured($post_id)) {
		$table_name = $table_prefix.'features';
		$dt = date('Y-m-d H:i:s');
		$sql = "INSERT INTO $table_name (id, date) VALUES ($post_id, '$dt')";
		$wpdb->query($sql);
	}
}


//If we can add it we should be able to remove it ;)
function remove_featured_post($post_id) {
	global $wpdb, $table_prefix;
	$table_name = $table_prefix.'features';
	
	// authorization
	if (!current_user_can('edit_post', $post_id))
		return $post_id;
	// origination and intention
	if (!wp_verify_nonce($_POST['featureme-verify'], 'FeatureMe'))
		return $post_id;
	
	if(empty($_POST['featured']) and featured($post_id)) {
		$sql = "DELETE FROM $table_name where id = $post_id LIMIT 1";
		$wpdb->query($sql);
	}
} 


//Checks if the post is already featured
function featured($post_id) {
	global $wpdb, $table_prefix;
	$table_name = $table_prefix."features";
	$check = "SELECT id FROM $table_name WHERE id = $post_id";
	$result = $wpdb->query($check);
	if($result == 1) { return TRUE; }
	else { return FALSE; }
}

// Ultra cool checkbox
function add_featured_checkbox() {
	global $post;
	
	$extra = "";
	
	if(isset($post->ID)) {
		$post_id = $post->ID;
		if(featured($post_id)) { $extra = 'checked="checked"'; }
	}
	
	echo '<div id="featured_checkbox">
			<input type="checkbox" name="featured" value="featured" '.$extra.' />
			<label for="featured">This is a really cool entry, Feature it!</label>
			<input type="hidden" name="featureme-verify" id="featureme-verify" value="'.wp_create_nonce('FeatureMe').'" />
		  </div>';
}

//Ultra cool CSS for the ultra cool checkbox
function featureme_css() {
?>
	<style type="text/css" media="screen">
	#featured_checkbox {
		background-color: #247fab;
		margin: 5px 0 10px 0;
		padding: 3px;
	}
	
	#featured_checkbox label {
		color: #fff;
	}
	</style>
<?php	
}

// Display the featured posts list
function show_featured_posts($max_posts=5, $offset=0, $before='<li>', $after='</li>') {
	global $wpdb, $table_prefix;
	$table_name = $table_prefix."features";
	
	$sql = "SELECT * FROM $table_name ORDER BY date DESC LIMIT $offset, $max_posts";
	$posts = $wpdb->get_results($sql);
	
	$html = '';
	foreach($posts as $post) {
		
		$id = $post->id;
		$posts_table = $table_prefix.'posts'; 
		$sql_post = "SELECT * FROM $posts_table where id = $id";
		$rs_post = $wpdb->get_results($sql_post);
		$data = $rs_post[0];
		$post_title = stripslashes($data->post_title);
		$post_title = str_replace('"', '', $post_title);
		$permalink = get_permalink($data->ID);
		$post_id = $data->ID;
		$html .= $before .'<a href="'. $permalink .'" title="'. $post_title .'" id="destacado_'.$post_id.'">'. $post_title .'</a>'. $after;
	}
	echo $html;
}


// Now let´s make this bad girl work by adding some hooks
add_action('admin_head', 'featureme_css');
add_action('simple_edit_form', 'add_featured_checkbox');
add_action('edit_form_advanced', 'add_featured_checkbox');
add_action('publish_post', 'add_featured_post');
add_action('edit_post', 'add_featured_post');
add_action('publish_post', 'remove_featured_post');
add_action('edit_post', 'remove_featured_post');
add_action('activate_featureme/featureme.php', 'install_featureme');

?>