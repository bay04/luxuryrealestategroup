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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'luxuryu1_lreg');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'dh|U?Xox+?Wsrj,D3`bppm>&?B=T-),J}8}mHru)P)gNT7+%BvWCL^6;H#Nra}d/');
define('SECURE_AUTH_KEY',  'umsRhxx#aMb6HRhL]LHx/T*g5QV,hWR&`;CV}+=T4.B)V}q;>:Gew1Wry# d^wZ`');
define('LOGGED_IN_KEY',    'WxF4 r%FcW0]8yTfjsI&!]1$_Wp@geREu%^O:u|GJGc#P)Nn#<;mA`aeJfMA^&1V');
define('NONCE_KEY',        'LHDln-S2#vmA-|`.iihk3R}nki0S[GDPJ9[/a,5&!s,~;xZ*B.%9YTy?}(jEYQJ]');
define('AUTH_SALT',        '>LWp_D1uXOzW&z1E!2s;?3-BxIeO*MI(YP9Z<&a!(SQiL=*mU0MaQubGm9-bkhQ$');
define('SECURE_AUTH_SALT', 'oBT.(7ssnnu^X*qS5W~V6ii7G!^b]%?GB2O/$qp,}kwrFjEq,;`AQvg:r^}&(#d:');
define('LOGGED_IN_SALT',   '.3?56S}~W9b6.ypmxD]`3Onq_F{n4GA,5;.;sHA-;G@B6`*0(a:!=;Dw(!&kW#nk');
define('NONCE_SALT',       'n$/B^Ag]yLa= ,eW(P?-Gn1A8H+Z5yBv%6OdMf@rHj2x sZ.~ 36x[=Ejd*:+W3`');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'lreg_wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
