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
define( 'WPCACHEHOME', '/home/savemar/public_html/savemari.co.za/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('WP_CACHE', true); //Added by WP-Cache Manager
define('DB_NAME', 'savemar_wrdp4');

/** MySQL database username */
define('DB_USER', 'savemar_wrdp4');

/** MySQL database password */
define('DB_PASSWORD', 'xHdZ(GG=L8zi');

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
define('AUTH_KEY',         '8Y1V7$9DUp1rRU?M:k\`owf$uT\`4)LK3?CdOSK$WE@JuUAl(J2qbc>KmS0LFquHY=/G?P^Hw1ODmiU*mBiWNrRRf');
define('SECURE_AUTH_KEY',  '/\`jtlzg?fW6$w|=@B\`4_^tm1!K1p$*cpYuL872X(teMST=)|f=R-;iGY9Gjq@x$-N~hRYVMsU');
define('LOGGED_IN_KEY',    'kn0xblM1mvo_QR#CuZ2Q6JTeiSS@aO@JL$6aM3dfA$6X||Q|!KRhyp~jbI@\`it5DS?W2u\`OK=wYAC');
define('NONCE_KEY',        'Ls0^;G*9S$wt50BA(F\`40Enp-Vq=)#Y;6AL~@ZS_q(GLJy4*oIx*UAo#W1bdT\`6)2TdXSSD4');
define('AUTH_SALT',        'pxlSWM)sx\`n(DDdg~OJ?x3BgB;L$vU>x2ViCk\`C4P8#g@jZkt#sIH-_cL4JWaD!ZCqhABy53^');
define('SECURE_AUTH_SALT', 'v^JmhGA7xX3UpXvuTZ)MfOE~EZ|O7(0ToPpD$VmKc;6s;68Y_9K/Iq8(J');
define('LOGGED_IN_SALT',   'YO=vZAD#(=L<<JC\`cOIwqa?!h7KvkO\`gxCDcz~zr_~A2MeyU_H87Nhc?1F:=(Z6$migu3ZQ');
define('NONCE_SALT',       'LQuHrbw>e|a>LbTP<3ALz<TNdWf7y3ZgDDB-W#nPAY7^3z6NNjXl~CLF9M6$jrr3ls8Fi|');

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
