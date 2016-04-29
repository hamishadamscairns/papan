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
define('DB_NAME', 'pain_local');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'password');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

define('FS_METHOD', 'direct');

define( 'WP_MEMORY_LIMIT', '256M' );

define( 'WP_MAX_MEMORY_LIMIT', '256M' );


define('AUTH_KEY',         '1g0|89PP&oR.p[6GH82H ;;eLY|@^>M@JNi(N?z+H+|laZBZ~7AyP6QF<4UAiyyQ');
define('SECURE_AUTH_KEY',  'Y DHgH<,#Vs]u|2J%|(ES4?3!+@IM:q`!}3!]I0L2QtNPwMu KhC=A|*^g1qe:zT');
define('LOGGED_IN_KEY',    '#y7#XoU>|3N<pGGRsf{iU_8-PG2CKPg60`G`0sxm8(V2 ]J8v,ZuSTQmZ-NgvEzg');
define('NONCE_KEY',        'g8D4@u)2+}/gT9o@*!u.Z%@*xx5|cvL.`aPR<+!LE`&~y5:T_6kv?0hTA;u+8|=f');
define('AUTH_SALT',        'QZz+G8K}|a0Z^G`g%I=f&]=Yo2hzJ[P[AwJ+%tJg9IGA#+]o:@$FKOsqx+G8se~R');
define('SECURE_AUTH_SALT', '#6UAq-S=GCJTdCw]*XFN}&ZE6cbVv5WnQmd~)D@U9W9.X_*eww;X+K+{t!4%>glC');
define('LOGGED_IN_SALT',   'DhPzFG6caUnRKfO*:UJi=OGxTvs51z0j<$b%1ly-4h$|-d{6~c,X{]o$!!~S<Coh');
define('NONCE_SALT',       'mvYvD&=?qq[$2Anhc-U{2FojkX/KW3@AWikAB>c}O%^Q+%^g|72OSAU}mnbBR?e7');

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
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

