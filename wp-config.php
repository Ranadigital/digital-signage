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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'edigital_signage2' );

/** Database username */
define( 'DB_USER', 'edigital_signage' );

/** Database password */
define( 'DB_PASSWORD', 'edigitalsignage!Q@W#E$R%T^Y&U*I(O)P' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'jrebybgdr8rmyczcaxki1vlxqirk09hayja0ohrd6t3t9lapwgbxcpomphj4yp0f' );
define( 'SECURE_AUTH_KEY',  'gj0zfemze9qzsfv5eki5llse0hspgb5k0jyivi4kep5x1uadwu0ssf79mxosnbye' );
define( 'LOGGED_IN_KEY',    'j1ghddwldub3dgh1dojmskrwbbir4m6pmdrjvwkrwbom1qzow8illsf8ktu3hfbh' );
define( 'NONCE_KEY',        'ty95ie1kbhhnooteo2d3frcgpizhbboh8qdqlrfzjzt1bbulmqdqzkm6tsstovl4' );
define( 'AUTH_SALT',        '0ih4u1ckpf6wgeg3nmjowzxrmeusgbko639mxnmlg7mkcc3s0eeqde0wjezpaits' );
define( 'SECURE_AUTH_SALT', 'lnkmxm966h4cxxzvwsbdlzyshoppbckko8groehvzpby6xa0upwnslbvcuuqwwfg' );
define( 'LOGGED_IN_SALT',   '6yxe5qsbnrl996wmkel0lz0mnop6l7llj1ocel8t1kdb5egwmmnlvdvbjtaxe1xh' );
define( 'NONCE_SALT',       'cao0m18rjuesoi4nm6ydfhtuoihb0qcwb7pnrokpajusajfqlxcuhutfrtsswgg8' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp1o_';

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
define( 'WP_DEBUG', false );

define( 'AUTOSAVE_INTERVAL', 300 );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 7 );
define( 'WP_CRON_LOCK_TIMEOUT', 120 );
/* Add any custom values between this line and the "stop editing" line. */



define( 'AUTOSAVE_INTERVAL', 300 );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 7 );
define( 'WP_CRON_LOCK_TIMEOUT', 120 );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
	define( 'WP_MEMORY_LIMIT', '6056M' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
