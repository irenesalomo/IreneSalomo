<?php
/**
 * @package WordPress
 * @subpackage magazine_obsession
 */

/* Get ID of the page, if this is current page */

function obwp_get_page_id () {
	global $wp_query;

	if ( !$wp_query->is_page )
		return -1;

	$page_obj = $wp_query->get_queried_object();

	if ( isset( $page_obj->ID ) && $page_obj->ID >= 0 )
		return $page_obj->ID;

	return -1;
}

/**
 * Get Meta post/pages value
 * $type = string|int
 */
function obwp_get_meta($var, $type = 'string', $count = 0)
{
	$value = stripslashes(get_option($var));
	
	if($type=='string')
	{
		return $value;
	}
	elseif($type=='int')
	{
		$value = intval($value);
		if( !is_int($value) || $value <=0 )
		{
			$value = $count;
		}
		
		return $value;
	}
	
	return NULL;
}

/**
 * Get custom field of the current page
 * $type = string|int
 */
function obwp_getcustomfield($filedname, $page_current_id = NULL)
{
	if($page_current_id==NULL)
		$page_current_id = obwp_get_page_id();

	$value = get_post_meta($page_current_id, $filedname, true);

	return $value;
}
function the_title_limited($length = false, $before = '', $after = '', $echo = true)
{
	$title = get_the_title();

	if ( $length && is_numeric($length) )
	{
		$title = substr( $title, 0, $length );
	}
	if ( strlen($title)> 0 )
	{
		$title = apply_filters('the_title2', $before . $title . $after, $before, $after);
		if ( $echo )
			echo $title;
		else
			return $title;
	}
}

function the_content_limit($max_char, $more_link_text = '', $use_p = false, $stripteaser = 0, $more_file = '')
{
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
	  if($use_p)
      	echo "<p>";
      echo $content;
	  if($use_p)
      	echo "</p>";
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
	  	if($use_p)
       		echo "<p>";
        echo $content;
        echo "...";
	  	if($use_p)
        	echo "</p>";
   }
   else {
	  if($use_p)
      	echo "<p>";
      echo $content;
	  if($use_p)
      	echo "</p>";
   }
}

 
function theme_ads_show()
{
	global $shortname;
	$count = obwp_get_meta(SHORTNAME."_count_banner_125_125",'int');

	if($count>0)
	{
		for($i=1; $i<=$count; $i++)
		{
			$banner_url = obwp_get_meta(SHORTNAME.'_banner_125_125_url_'.$i);
			$banner_img = obwp_get_meta(SHORTNAME.'_banner_125_125_img_'.$i);
			$banner_title = obwp_get_meta(SHORTNAME.'_banner_125_125_title_'.$i);

			if(!empty($banner_url) && !empty($banner_img))
			{
			?><div><a href="<?php echo $banner_url; ?>" title="<?php echo $banner_title; ?>"><img src="<?php echo $banner_img; ?>" alt="<?php echo $banner_title; ?>" /></a></div><?php
			}
		}
	}
}

function wp_list_pages2($args) {
	$defaults = array(
		'depth' => 0, 'show_date' => '',
		'date_format' => get_option('date_format'),
		'child_of' => 0, 'exclude' => '',
		'title_li' => __('Pages'), 'echo' => 1,
		'authors' => '', 'sort_column' => 'menu_order, post_title',
		'link_before' => '', 'link_after' => ''
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	$output = '';
	$current_page = 0;

	// sanitize, mostly to keep spaces out
	$r['exclude'] = preg_replace('/[^0-9,]/', '', $r['exclude']);

	// Allow plugins to filter an array of excluded pages
	$r['exclude'] = implode(',', apply_filters('wp_list_pages_excludes', explode(',', $r['exclude'])));

	// Query pages.
	$r['hierarchical'] = 0;
	$pages = get_pages($r);

	if ( !empty($pages) ) {
		if ( $r['title_li'] )
			$output .= '<li class="pagenav">' . $r['title_li'] . '<ul>';

		global $wp_query;
		if ( is_page() || $wp_query->is_posts_page )
			$current_page = $wp_query->get_queried_object_id();
		$output .= walk_page_tree($pages, $r['depth'], $current_page, $r);

		if ( $r['title_li'] )
			$output .= '</ul></li>';
	}

	$output = apply_filters('wp_list_pages', $output);

	if ( $r['echo'] )
		echo $output;
	else
		return $output;
}

function carousel_featured_posts($max_posts=5, $offset=0) {
	if(!function_exists('show_featured_posts'))
		return false;
		
	global $wpdb, $table_prefix;
	$table_name = $table_prefix."features";
	
	$sql = "SELECT * FROM $table_name ORDER BY date DESC LIMIT $offset, $max_posts";
	$posts = $wpdb->get_results($sql);
	
	$html = '';
	$coint_i = 0;
	foreach($posts as $post) {
		$coint_i++;
		$id = $post->id;
		$posts_table = $table_prefix.'posts'; 
		$sql_post = "SELECT * FROM $posts_table where id = $id";
		$rs_post = $wpdb->get_results($sql_post);
		$data = $rs_post[0];
		$post_title = stripslashes($data->post_title);
		$post_title = str_replace('"', '', $post_title);
		$post_content = stripslashes($data->post_content);
		$post_content = str_replace(']]>', ']]&gt;', $post_content);
		$post_content = strip_tags($post_content);
		$permalink = get_permalink($data->ID);
		$post_id = $data->ID;
		$html .= '<div class="board_item">
			<!-- board_item -->
			<p>';
			
		$thumbnail = get_post_meta($post_id, 'thumbnail', true);
		
		if( isset($thumbnail) && !empty($thumbnail) ):
			$html .= '<img src="'.$thumbnail.'" alt="'.$post_title.'" />';
		endif;
		
		$html .= '<strong><a href="'.$permalink.'">'.get_string_limit($post_title,50).'</a></strong> '.get_string_limit($post_content,200).'</p>
			<p class="more"><a href="'.$permalink.'">Read more</a></p>
			<!-- /board_item -->
		</div>';
	}
	echo $html;
	return $coint_i;
}

function get_string_limit($output, $max_char)
{
    $output = str_replace(']]>', ']]&gt;', $output);
    $output = strip_tags($output);

  	if ((strlen($output)>$max_char) && ($espacio = strpos($output, " ", $max_char )))
	{
        $output = substr($output, 0, $espacio).'...';
		return $output;
   }
   else
   {
      return $output;
   }
}
 
function obwp_ads_show()
{
	$count = obwp_get_meta(SHORTNAME."_count_banner_125_125",'int');

	if($count>0)
	{
		for($i=1; $i<=$count; $i++)
		{
			$banner_url = obwp_get_meta(SHORTNAME.'_banner_125_125_url_'.$i);
			$banner_img = obwp_get_meta(SHORTNAME.'_banner_125_125_img_'.$i);
			$banner_title = obwp_get_meta(SHORTNAME.'_banner_125_125_title_'.$i);

			if(!empty($banner_url) && !empty($banner_img))
			{
			?><div><a href="<?php echo $banner_url; ?>" title="<?php echo $banner_title; ?>"><img src="<?php echo $banner_img; ?>" alt="<?php echo $banner_title; ?>" /></a></div><?php
			}
		}
	}
}

function obwp_google_468_ads_show()
{
	$id = obwp_get_meta(SHORTNAME."_google_id");
	if(!empty($id))
	{
		echo $code = '<div class="banner"><script type="text/javascript"><!--
google_ad_client = "'.$id.'";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_type = "text"; 
google_color_border = "c5c5c5";
google_color_bg = "ffffff";
google_color_link = "9d080d";
google_color_url = "9d080d";
google_color_text = "000000"; 
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>';
	}
}

function obwp_google_300_ads_show()
{
	$id = obwp_get_meta(SHORTNAME."_google_id");
	if(!empty($id))
	{
		echo $code = '<div class="banner_left"><script type="text/javascript"><!--
google_ad_client = "'.$id.'";
google_ad_width = 300;
google_ad_height = 250;
google_ad_format = "300x250_as";
google_ad_type = "text"; 
google_color_border = "c5c5c5";
google_color_bg = "ffffff";
google_color_link = "9d080d";
google_color_url = "9d080d";
google_color_text = "000000"; 
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>';
	}
}

function theme_twitter_link_show()
{
	$id = obwp_get_meta(SHORTNAME."_twitter_id");
	if(!empty($id))
	{
		return 'http://twitter.com/'.$id;
	}
	else
	{
		return '#';
	}
}

function obwp_banner_468_ads_show()
{
	$img = trim(get_option(SHORTNAME.'_ads_img_468'));
	$link = trim(get_option(SHORTNAME.'_ads_link_468'));
	if(!empty($img) && !empty($link))
	{
		echo '<a href="'.$link.'"><img src="'.$img.'" alt="" /></a>';
	}
}



?>