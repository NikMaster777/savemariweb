<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'WPCACHEHOME', '/home/savemar/public_html/savemari.co.tz/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('WP_CACHE', true); //Added by WP-Cache Manager
define('DB_NAME', 'savemar_wrdp3');

/** MySQL database username */
define('DB_USER', 'savemar_wrdp3');

/** MySQL database password */
define('DB_PASSWORD', 'W=,[Bc8TTx6*');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'z>yQdquj/l;grb3>X@F_(?YGQIFBq:a$q~riz1I$WI6LS;:EwP;IJOswIHs5hjb#0KV/|\`6RyO');
define('SECURE_AUTH_KEY',  'YWD9uJn;r;bdxALI#4v^D==;v)^-A_nE##K|ykyVE>O8b!umZY3OyWg1/QwL*rLh$bMj4y:~');
define('LOGGED_IN_KEY',    '603fMG\`XfD?a^:|<3>V=n8?8?o;^hZ(i1?X\`3N8k;Tsdr/*zPf57~2cQZI*lHH_W4Hy8cgS:nahL~Z3BB');
define('NONCE_KEY',        'zU\`U;lh@=VJ>iITG4$ja1UdVtYwKc^/Rz-f|-T>7_#E|Ce8?hdtW?OYU|zB#G7h!sOR:6OdZqI-!');
define('AUTH_SALT',        '<(hZq=bySj10xuYGLK=5BbaqD\`:LN_q$<p^j24>::hPWMI5T!k)Z<4*8Yp?Up$By~m^mu2eu^ONQUv;hzMiv');
define('SECURE_AUTH_SALT', 'WYT3ea-Nq|@Ux5DBQZ^MM:faOA_#JRvaiPG)|X-ICch!ELT*bkzOy6\`*W*:9D6aIS66t55*|0Dpi');
define('LOGGED_IN_SALT',   'XX8ZiD:_=)/(~4<=qbnx7:tCTE/QEcOzZ>NHzsZK^iFftLFkIp$6$xS:5x)?v78AE6/^ztq');
define('NONCE_SALT',       'Vc2_|E?f*Xj!ccOhHIn?J^>6x0Qtl16x5|*(/WL:p3:*P<EJjeYvQ(S6cQc|S4JVF');

/**#@-*/
define('AUTOSAVE_INTERVAL', 600 );
define('WP_POST_REVISIONS', 1);
define( 'WP_CRON_LOCK_TIMEOUT', 120 );
define( 'WP_AUTO_UPDATE_CORE', true );
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_theme', '__return_true' );
