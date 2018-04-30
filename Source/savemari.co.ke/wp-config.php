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
define( 'WPCACHEHOME', '/home/savemar/public_html/savemari.co.ke/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('WP_CACHE', true); //Added by WP-Cache Manager
define('DB_NAME', 'savemar_wrdp2');

/** MySQL database username */
define('DB_USER', 'savemar_wrdp2');

/** MySQL database password */
define('DB_PASSWORD', 'fdQyym5-IeE[');

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
define('AUTH_KEY',         'R~tZaHx>Bk\`^|2lu~FfI?*D77_>x0$$Pp~ma0TnNjA;<W5S(g50UxgL*DEE2sKc)\`HMW-Ds0');
define('SECURE_AUTH_KEY',  'TEC?hQlFgeeU@?@Kz8)!pCn!^MPY~7IPI\`OZ54CQqGeqeL:$G^)jr~T6bmL3sf^;t;iIsI--M#s_Gq6O=:Fl?');
define('LOGGED_IN_KEY',    'N#MYG;EBc8n:bF2pJ!_#Y0UeG<c#f:;o5;T1hgCSQt4zQ;K!IlzVCL_|<NA:PT4m(w*cIUwXP>drG(');
define('NONCE_KEY',        'x(XFf1kxde@R-^ui\`j8/GMp4^auMMnDZ/<4yNXh>$ki?:O;h\`Fs|>~VX4|EG^~sb~7F$>a');
define('AUTH_SALT',        '0Aqu_IeRBYe\`D>z#d8Dfvbwjv8j|g!Fk~ts?rPPMBBo6kKP/6!0uV;n6(KUmzwvPe__nr^V!:d');
define('SECURE_AUTH_SALT', ':^Lf_Gmwir#=>tH|!LvKSBP|_zz\`$84eQ$zWRueqN$8?n>l(4^6dEAhXP2Ny8~r');
define('LOGGED_IN_SALT',   '<3a1g-TC#l@LUdP;5ZpN\`koufN/ymdcC17YwM!C~~BvafMKZtwe?JBy7cOhlr;cJqht-W~aE*=F:F<e/7');
define('NONCE_SALT',       '$P8~W(T$zEv@5haKK/z|kxDR5R?O-7HT68rb9EI=qBMC;XkdB#QBZv|@$XZMdD)4=<Nf0MZ');

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
