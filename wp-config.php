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
define('DB_NAME', 'buddypressdata');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         ']ew06qE1>Ar<L?u|og69Et89.2yn<vSv`^Uxo&vO1|9$l-L_4xp|@N_jyP#<CeUL');
define('SECURE_AUTH_KEY',  'I5Wzh?uK Ytp$4mh6}0@~iB`#!D@wRk:_#n!OW0sVQU8%b*P~p4xe]}.MT<WN.(9');
define('LOGGED_IN_KEY',    'v=5H|4~NMt-lL8 YUM|KG^SEZH*O%`Tw.%HI]PrDGge,*++UAzB0.(/ZGb3Ihgc<');
define('NONCE_KEY',        '-!;^}`T4V2i|G-#=L]CQU{EjFwK4%BeX8q[zatGABi2:k`9LNg9r*H-K-dzldAZ)');
define('AUTH_SALT',        '&Ty-2IO;>MQ}ERI]GTGq~VgwSfJB.wF.C}p~=>i?]tbk|e++1lFqW2FKWp^-*]RG');
define('SECURE_AUTH_SALT', 'Iu!,$t2|?siLr)5(P` L]*+<?|e3VR+&&/@ LQnyI)#!P0)f:Tb-Rt;ESLd-Ubb~');
define('LOGGED_IN_SALT',   'iWr0gTE+}rNY[ yj+<F@=, RoZt&K->JWtNs:GC_($NLMd~L4PW1QY>DFv5=Xh)L');
define('NONCE_SALT',       'R(zS/MHZ1)C<cPLzL-ot-pDOfxbH~b@+jz.+D/.i,5;z[|pIg+[Z !9qS?MD5>yj');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
