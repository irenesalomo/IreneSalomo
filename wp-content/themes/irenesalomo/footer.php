<div class="clear"></div>
</div>
<footer id="footer" role="contentinfo">
<div id="copyright">
<?php echo sprintf( __( '%1$s %2$s %3$s. All Rights Reserved.', 'irenesalomo' ), '&copy;', date( 'Y' ), esc_html( get_bloginfo( 'name' ) ) ); echo sprintf( __( ' Theme By: %1$s.', 'irenesalomo' ), '<a href="http://tidythemes.com/">TidyThemes</a>' ); 
$theme_uri = get_template_directory_uri();    
?>
</div>
</footer>
</div>
<script data-main="<?php _e($theme_uri) ?>/assets/js/main.min.js" src="<?php _e($theme_uri) ?>/assets/js/require.js"></script>
<script>
		window.baseurl = '/wp-content/themes/irenesalomo/assets/js/';

		require.config({
			urlArgs: 'v=<?php _e(THEME_VERSION) ?>',
			baseUrl: baseurl,
			paths: {
				// the left side is the module ID,
				// the right side is the path to
				// the jQuery file, relative to baseUrl.
				jquery: 'vendors/jquery-1.12.0.min'
			},
		});

		// always require jQuery
		require(['jquery'], function($) {});
	</script>
<?php wp_footer(); ?>
</body>
</html>
