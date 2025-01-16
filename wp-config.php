<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'W>jaNNti7-|,`f&h(q`&/QO0#^}.94s%x*;twW~NJ|C(*kN6sHZFf~Q&h#Td/SgW' );
define( 'SECURE_AUTH_KEY',   ',77:xWN82YG)sED1gtz>iOwe7$[lB]^BeL{R#{.3v[Rq2TE%[g:aTo<&{@X4{}3=' );
define( 'LOGGED_IN_KEY',     '<66E(8H?+G--q.P(?mSyS^`T>LM`+wn5(!6)B7UC{ul5)&#u_M1VNrL_RuEANx(2' );
define( 'NONCE_KEY',         ' |nr` I(U$Z#Pdp$pTh.&H4|$q.PJP|i.bX!!`WO+|7)~uZyn8li/~1(HBbM-$t=' );
define( 'AUTH_SALT',         ')5j^.t&_$CeZ`Z&-y%dluO6G|5U_$yi>3e?LL{:b!q2(DR|*r8Mf~O}9Hj)-&MY^' );
define( 'SECURE_AUTH_SALT',  '@&k)&q]w8`3Bf,x^_T9J)#jTUi,<2T6Q(6K 6y vQ&FW9W-;r{6gD>u-ZYC4qyu)' );
define( 'LOGGED_IN_SALT',    '6Vtq|$aE.7X3OMfgmUEm#TyYXxv@2QpR>F%]!FAeu[nE>y#W[{>+r]3MH9Tu6,ba' );
define( 'NONCE_SALT',        'M$nI*wz34zAV~C3;;ZkRP8]b&g!F$xPL@itz TpDc3#[!Y<|a=UD~//tuWnO^?-@' );
define( 'WP_CACHE_KEY_SALT', 'X@cWH$]mGrb9n<,,7&ER8+i0fOM%|NSSF?GO<0pqx^ei!E8@3@O6<`Zk+R7G-Ziw' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
