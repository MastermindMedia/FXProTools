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
define('DB_NAME', 'db_fxprotools');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'ba$c0Lz0}1HE(S^kjl[0g[Un=cgf*3pj^a#fL.9~;p?f??dTTDIV~k1/5i8#@kpP');
define('SECURE_AUTH_KEY',  '*6W>YC13)SJx(04{Wp#f(7lw7x|4?}K)-fF]6T;UDj$CRBt+)</us2f`= Tw8e/A');
define('LOGGED_IN_KEY',    'cGIjVwop!`GU9phpFDfeAQ9<-2mxDS!r+2+z@XEweT&K[Hyp9J1Ue5AyM{t16wV!');
define('NONCE_KEY',        'g1)ixkoq{o}!F!|tk#Q~SY`$6O` y8lc;aYUa) *Kzhd*GAs9)YqMbU;@e(ln)F.');
define('AUTH_SALT',        'W++QS/t@q`]5wBXVU>#Jr#QF(:Q!G!PYfM<LVyk:FSH>~vC@z.O8;}G9(*NWJWnT');
define('SECURE_AUTH_SALT', '6a2}K?;t?[)abu6b6!We89V@zyr-vbCo+{q|}Ff0mg:3YdC%`!6bGJ4c&Y@x:f@O');
define('LOGGED_IN_SALT',   'ylG7ek}O*miORv-UGDjPK/f*G/K/M>}m#W1=u,(~8uFIOB!CiHa#5kgL8NxN`Gdc');
define('NONCE_SALT',       'XsixA}A9lC-sqwdouR^|O#a[ikGjf-/!jXEiktw>?(Z`EM@e1b?LzbLE:2 Y9e1p');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
define('WP_DEBUG', true); // Set False for production

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

