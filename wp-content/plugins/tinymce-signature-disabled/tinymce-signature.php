<?php
/*
Plugin Name: TinyMCE Signature
Plugin URI: http://www.keighl.com/plugins/tinymce-signature
Description: Automatically adds a signature to your posts. Configurable via TinyMCE on the profile page. 
Version: 0.6
Author: Kyle Truscott
Author URI: http://www.keighl.com
*/

/*  Copyright 2009 Kyle Truscott  (email : info@keighl.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$tinymce_signature = new TinyMCESignature();

class TinyMCESignature {

	function TinyMCESignature() {
		
		load_plugin_textdomain('tinymce-signature', false, 'tinymce-signature/languages');
		add_action('show_user_profile', array(&$this,'profile'));
        add_action('edit_user_profile', array(&$this,'profile'));
        add_action('personal_options_update', array(&$this,'update_options'));
        add_action('edit_user_profile_update', array(&$this,'update_options'));
		add_action('admin_menu', array(&$this,'add_override_box') );
		add_action('publish_post', array(&$this,'save_override') );
		add_action('write_post', array(&$this,'save_override') );
		add_action('edit_post', array(&$this,'save_override') );
		add_filter('the_content', array(&$this,'append_signature'));

	}
	
	function profile() {
		
		if ( rich_edit_exists() && user_can_richedit() ) :
		
			wp_tiny_mce(false, array(
				"editor_selector" => "tinymce_signature", 
				"height" => 150, 
			));
			
		
	    
			global $profileuser;
			
			$default = $profileuser->tinymce_signature_global_default;
			$page_default = $profileuser->tinymce_signature_global_page_default;
			$archive_default = $profileuser->tinymce_signature_global_archive_default;
			
			?>	
			
			<script type="text/javascript" charset="utf-8">
				
				function toggleEditor(id) {
					if (!tinyMCE.get(id))
						tinyMCE.execCommand('mceAddControl', false, id);
					else
						tinyMCE.execCommand('mceRemoveControl', false, id);
				}
				
				jQuery(document).ready(function($) {
		
					
					var id = 'tinymce_signature';

					$('a.toggleVisual').click(
						function() {
							tinyMCE.execCommand('mceAddControl', false, id);
						}
					);

					$('a.toggleHTML').click(
						function() {
							tinyMCE.execCommand('mceRemoveControl', false, id);
						}
					);
				

				});
				
		
				
			</script>
		
			<h3><?php _e('Signature', 'tinymce_signature'); ?></h3>
<p align="right">
	<a class="button toggleVisual"><?php _e('Visual', 'tinymce_signature'); ?></a>
	<a class="button toggleHTML"><?php _e('HTML', 'tinymce_signature'); ?></a>
</p>
			<div class="postbox">
				<textarea name="tinymce_signature" class="tinymce_signature" id="tinymce_signature" style="width:inherit; height:150px;"><?php echo trim($profileuser->tinymce_signature); ?></textarea>
			</div>
			
			<p><strong><?php _e('Include signature on all posts by default?', 'tinymce_signature'); ?></strong></p>
			<p>
				<input type="radio" name="tinymce_signature_global_default" value="yes" <?php if ($default == "yes" || $default == "") echo 'checked="checked"'; ?> /> Yes
				<input type="radio" name="tinymce_signature_global_default" value="no" <?php if ($default == "no") echo 'checked="checked"'; ?> /> No
			</p>
			
			<p><strong><?php _e('Include signature on all pages by default?', 'tinymce_signature'); ?></strong></p>
			<p>
				<input type="radio" name="tinymce_signature_global_page_default" value="yes" <?php if ($page_default == "yes" || $page_default == "") echo 'checked="checked"'; ?> /> <?php _e('Yes', 'tinymce_signature'); ?>
				<input type="radio" name="tinymce_signature_global_page_default" value="no" <?php if ($page_default == "no") echo 'checked="checked"'; ?> /> <?php _e('No', 'tinymce_signature'); ?>
			</p>
			
			<p><strong><?php _e('Include signature on archive pages?', 'tinymce_signature'); ?></strong></p>
			<p>
				<input type="radio" name="tinymce_signature_global_archive_default" value="yes" <?php if ($archive_default == "yes" || $archive_default == "") echo 'checked="checked"'; ?> /> <?php _e('Yes', 'tinymce_signature'); ?>
				<input type="radio" name="tinymce_signature_global_archive_default" value="no" <?php if ($archive_default == "no") echo 'checked="checked"'; ?> /> <?php _e('No', 'tinymce_signature'); ?>
			</p>
					
			<?php
			
		endif;
	}
	
	function update_options() {
		
		global $user_id;
	    
		update_usermeta($user_id, 'tinymce_signature', ( isset($_POST['tinymce_signature']) ? $_POST['tinymce_signature'] : '' ) );
		update_usermeta($user_id, 'tinymce_signature_global_default', ( isset($_POST['tinymce_signature_global_default']) ? $_POST['tinymce_signature_global_default'] : '' ) );
		update_usermeta($user_id, 'tinymce_signature_global_page_default', ( isset($_POST['tinymce_signature_global_page_default']) ? $_POST['tinymce_signature_global_page_default'] : '' ) );
		update_usermeta($user_id, 'tinymce_signature_global_archive_default', ( isset($_POST['tinymce_signature_global_archive_default']) ? $_POST['tinymce_signature_global_archive_default'] : '' ) );
	}
	
	function append_signature($content) {

		global $post;
		
		$post_pref = get_the_author_meta('tinymce_signature_global_default');
		$page_pref = get_the_author_meta('tinymce_signature_global_page_default');
		$archive_pref = get_the_author_meta('tinymce_signature_global_archive_default');
		$tinymce_signature_post_setting = get_post_meta($post_id , "tinymce_signature_post_setting", true);
		$signature = get_the_author_meta("tinymce_signature");
		
		$post_id = $post->ID;
		$type = $post->post_type;

		if (is_single() || is_page()) {
		
			if ($type == "post") {
				$pref = $post_pref;
			}
			
			if ($type == "page") {
				$pref = $page_pref;
			}
		
			
			if ($tinymce_signature_post_setting) {
				if ($tinymce_signature_post_setting == "yes") {
					$content = $content . $signature;
				} 
			} else {
				if ($pref == "yes") {
					$content =  $content . $signature;
				} 
			} 
		
		} else {
			
			if ($archive_pref == "yes") {
				$content =  $content . $signature;
			}
			
		}
		
		return $content;
			
	}

	function add_override_box() {
		
		add_meta_box(
	        'tinymce_signature_override',
	        'Display Signature?', 
	         array(&$this,'override_box'),
	        'post'
	    );
	
		add_meta_box(
	        'tinymce_signature_override',
	        'Display Signature?', 
	         array(&$this,'override_box'),
	        'page'
	    );
		
	}
	
	function override_box() {
		
		global $post;
		global $user_ID;
		
			$post_id = $post->ID;
			$type =  $post->post_type;
		
		if( current_user_can('edit_post', $post_id) ) :
			
			if ($type == "post") :

				if ($post_id == 0) :
					
					// if this is a new post, inherit the global display option from profile.
					
					$author = $user_ID;
					
					$post_pref = get_usermeta($author, "tinymce_signature_global_default");
					$page_pref = get_usermeta($author, "tinymce_signature_global_page_default");
					
					?>

					<input type="radio" name="tinymce_signature_post_setting" value="yes" <?php if ($post_pref == "yes" || $user_signature_default == "") echo 'checked="checked"'; ?> /> Yes
				
					<input type="radio" name="tinymce_signature_post_setting" value="no" <?php if ($post_pref == "no") echo 'checked="checked"'; ?> /> No
				
					<?php
					
				else :
				
					$post_author = $post->post_author;
					$post_pref = get_usermeta($post_author , 'tinymce_signature_global_default');
					$page_pref = get_usermeta($post_author , 'tinymce_signature_global_page_default');
					$tinymce_signature_post_setting = get_post_meta($post_id, "tinymce_signature_post_setting", true);
				
					if ($tinymce_signature_post_setting) :
						
						// where meta value already exists
						?>

						<input type="radio" name="tinymce_signature_post_setting" value="yes" <?php if ($tinymce_signature_post_setting == "yes") echo 'checked="checked"'; ?> /> Yes
				
						<input type="radio" name="tinymce_signature_post_setting" value="no" <?php if ($tinymce_signature_post_setting == "no") echo 'checked="checked"'; ?> /> No
				
						<?php
						
					else :
					
						// where meta value doesn't exists, use profile defaults. 
						?>
					
						<input type="radio" name="tinymce_signature_post_setting" value="yes" <?php if ($post_pref == "yes" || $user_signature_default == "") echo 'checked="checked"'; ?> /> Yes

						<input type="radio" name="tinymce_signature_post_setting" value="no" <?php if ($post_pref == "no") echo 'checked="checked"'; ?> /> No

						<?php
				
					endif;
				
				endif;
				
			elseif ($type == "page") :
			
				if ($post_id == 0) :
					
					// if this is a new post, inherit the global display option from profile.
					
					$author = $user_ID;
					
					$post_pref = get_usermeta($author, "tinymce_signature_global_default");
					$page_pref = get_usermeta($author, "tinymce_signature_global_page_default");
					
					?>

					<input type="radio" name="tinymce_signature_post_setting" value="yes" <?php if ($page_pref == "yes" || $user_signature_default == "") echo 'checked="checked"'; ?> /> Yes
				
					<input type="radio" name="tinymce_signature_post_setting" value="no" <?php if ($page_pref == "no") echo 'checked="checked"'; ?> /> No
				
					<?php
					
				else :
				
					$post_author = $post->post_author;
				 	$post_pref = get_usermeta($post_author , 'tinymce_signature_global_default');
					$page_pref = get_usermeta($post_author , 'tinymce_signature_global_page_default');
					$tinymce_signature_post_setting = get_post_meta($post_id, "tinymce_signature_post_setting", true);
				
					if ($tinymce_signature_post_setting) :
						
						// where meta value already exists
						?>

						<input type="radio" name="tinymce_signature_post_setting" value="yes" <?php if ($tinymce_signature_post_setting == "yes") echo 'checked="checked"'; ?> /> Yes
				
						<input type="radio" name="tinymce_signature_post_setting" value="no" <?php if ($tinymce_signature_post_setting == "no") echo 'checked="checked"'; ?> /> No
				
						<?php
						
					else :
					
						// where meta value doesn't exists, use profile defaults. 
						?>
					
						<input type="radio" name="tinymce_signature_post_setting" value="yes" <?php if ($page_pref == "yes" || $user_signature_default == "") echo 'checked="checked"'; ?> /> Yes

						<input type="radio" name="tinymce_signature_post_setting" value="no" <?php if ($page_pref == "no") echo 'checked="checked"'; ?> /> No

						<?php
				
					endif;
				
				endif;
			
			else :
			
			endif;
			
		endif;
		
	}
	
	function save_override() {
		
		global $wpdb;
				
		if( !isset( $id ) )
	      $id = $_REQUEST[ 'post_ID' ];
	
		update_post_meta( $id , 'tinymce_signature_post_setting' , $wpdb->prepare($_POST['tinymce_signature_post_setting'] ) );
				
	}

}

// Template Tag

function tinymce_signature() {
			
	echo get_the_author_meta("tinymce_signature");
	
}

?>