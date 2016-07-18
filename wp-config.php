<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

/**
 * Section: The base dir for wordpress
 * =============================================================================
 * WordPress needs to know where it is installed. Normally one of the last
 * things that get defined in the standard wp-config.php file. However we have
 * moved it up the chain a little bit. So that we can use it ourselves.
 */

if (!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__).'/');


/**
 * Section: Environment Specific Configuration
 * =============================================================================
 * Here we define our database connection details and any other environment
 * specific configuration. We use some simple environment detection so that
 * we can easily define different values regardless of where we run.
 */

call_user_func(function()
{
	// This is where the magic happens
	$env = function($host)
	{
		// Do we have a direct match with the hostname of the OS
		if ($host == gethostname())
		{
			return true;
		}

		// NOTE: The HTTP_HOST can be spoofed, remove if super paranoid.
		if (isset($_SERVER['HTTP_HOST']))
		{
			if ($host == $_SERVER['HTTP_HOST'])
			{
				return true;
			}
		}

		// This next bit is stolen from Laravel's str_is helper
		$pattern = '#^'.str_replace('\*', '.*', preg_quote($host, '#')).'\z#';

		if ((bool) preg_match($pattern, gethostname()))
		{
			return true;
		}

		// NOTE: The HTTP_HOST can be spoofed, remove if super paranoid.
		if (isset($_SERVER['HTTP_HOST']))
		{
			if ((bool) preg_match($pattern, $_SERVER['HTTP_HOST']))
			{
				return true;
			}
		}

		// No match
		return false;
	};

	// Here you can define as many `cases` or environments as you like.
	// Here are the usual 3 for starters.

	switch(true)
	{
		// Irene Local
		case $env('nia-pc'):
		{
			define('FRUCTIFY_ENV', 'local');
			define('DOMAIN_CURRENT_SITE', 'irenesalomo.au.dev.k-d.com.au');
			define('DB_NAME', 'irenesal_wrdp1');
			define('DB_USER', 'root');
			define('DB_PASSWORD', 'root');
			define('DB_HOST', 'localhost');
			break;
		}
		
		// Irene Home Local
		case $env('Mack_Irene'):
		{
			define('FRUCTIFY_ENV', 'local');
			define('DOMAIN_CURRENT_SITE', 'http://localhost/IreneSalomo/');
			define('DB_NAME', 'irenesal_wrdp1');
			define('DB_USER', 'root');
			define('DB_PASSWORD', '');
			define('DB_HOST', 'localhost');
			break;
		}

		// Production
		default:
		{
			define('FRUCTIFY_ENV', 'production');
			define('DOMAIN_CURRENT_SITE', 'www.irenesalomo.com.au');
			define('DB_NAME', 'irenesal_wrdp1');
			define('DB_USER', 'irenesal_wrdp1');
			define('DB_PASSWORD', 'bJMy4vKiZM4G');
			define('DB_HOST', 'localhost');
			
		}
	}
});

/**
 * Section: Database Charset and Collate
 * =============================================================================
 * If this is different across your environments I think you have some issues...
 * Hence I have defined them outside of the above section.
 */

define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');


 
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '@j?ipQ1nR,yuuCW@Uirenesalomo.comAS-{%gQEpSr_+<dyb+>:Yd#nWbetyh~4rmMUap4Q6rZEcZy');
define('SECURE_AUTH_KEY',  '+hOIBXnJ~C;ftmT([CA|]_wDSirenesalomo.comG<K?#S8{H>//EaLy7]h:jhRfj.K=Usg#g&$9+ox');
define('LOGGED_IN_KEY',    'c8K?-u_wU{BZ2yHK_sbOo1@?!irenesalomo.com}H<`PM%7^l6VJTY,~DSOJ,zCtVI@Ym$WZi1@5x5');
define('NONCE_KEY',        's5,9YV+%:+HFX#l~ %RE`AZ/pirenesalomo.comUzn<&<R%71t-|[H-L+}AtN9/thH&dMcVM8WN|Q}');
define('AUTH_SALT',        'KUEIq@~d.Tk+~t>1:HS9$8G_*irenesalomo.comzG,jcuq2l=7l#KE[-1c)QW3a{LwGi-kwhRVP&]g');
define('SECURE_AUTH_SALT', ';0GoKVCGWIZh:YOa*h[]-T&Diirenesalomo.comnp=:iQ;z$>OkEYNi2@Y`|5-c|n:Jb #}97E?LX7');
define('LOGGED_IN_SALT',   'we3RP{hVolwbVh-((L%LEcHKlirenesalomo.com[IaA9<bDvi`h/M:3U7xK8S]A|.Q,2$|*jcOqWNB');
define('NONCE_SALT',       'fjodm3yzllndvmyzjintviodk0mjq4mjczzjjhzmfhnjgxzjuymwm0yzmwmgmwnz');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

# Disables all core updates. Added by SiteGround Autoupdate:
define( 'WP_AUTO_UPDATE_CORE', false );
