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
define('DB_NAME', 'zaivia');
//define('DB_NAME', 'zaivia-v2');

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
define('AUTH_KEY',         'M:C(@;|^rU,F2(.={gr>naAK`#,EB;Dr~;T6w&m4__5Z)ePjmS>ipt{~Kf~L1~0R');
define('SECURE_AUTH_KEY',  'OOLlgseg;28t0EpjB6I#@zNq@cUPRaoUThiw<vmqDPC@BZZWk5QFQ/vE+m]5WnzQ');
define('LOGGED_IN_KEY',    '.;1h;iS^{<^f;cF9`@XVX5zC0F#3;uBr)4DRC:V*+HP?9iu88o,tj[a17ZH~B Jn');
define('NONCE_KEY',        '@ Rl?iA_8He]3!pq8#d88xb&j 2Mk(8@RZl*{ I/BsSiIolT4O<+gwkV!Yl-Oo|9');
define('AUTH_SALT',        'f,tI0|RR10hvuG%QrS69(~a151uh]su {4ZaHExjF;}[Tdx}k?I`K3.34Fy;RKmE');
define('SECURE_AUTH_SALT', 'Ul&hE!sjtu{k-N<wj,bMiIWI5%azlJ*H(,07II}>|M[&g=[Gx@Vn)c|_ ysr+c2]');
define('LOGGED_IN_SALT',   '#px12o<N;^ojD4R~jt<]z:s^w?}Hy:Mm)c>=qUz1bLy=S_&2&q8zYiHBWjFGNoJS');
define('NONCE_SALT',       'DF>q{FacsGEkmZv r#t]oB!NuJk&)fqI/>jzh1C0!GU<BblC*<$9e5d9iC:sefU ');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
