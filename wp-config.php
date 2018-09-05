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
define('DB_NAME', 'db322405_datab');

/** MySQL database username */
define('DB_USER', 'u322405_datab');

/** MySQL database password */
define('DB_PASSWORD', 'iD3zhm2rQ');

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
define('AUTH_KEY',         'v8ZqK4=92<rl-^xV2y_18}6-~&KvguN46Z)qpXb8HsJ<7(OU.mp]Y<8l=I7tqgf(');
define('SECURE_AUTH_KEY',  'jz2`;x:$Vl,O9s@1%cdS:Z/l~mJWB^&5rBETBr{(HDH?2K,!Y^s{gUNDm9,fmbbJ');
define('LOGGED_IN_KEY',    '+.++0(nuH1CcYYCul~fZTFg`z(h}eFs0aJ_hY`THSh~52AVjPmSZM<dQ)X(,o$EF');
define('NONCE_KEY',        'l^1ewf0}4OyFn]u}e&1ntQoS6SR,=XJB.K02T1-uEw}8R^aiyWa$m_m-uYtRv~}`');
define('AUTH_SALT',        '9#R# <d?S5&cKkjC-DdN,Y3Vx}RX80{R@3P+I-FeK7GVDAVgqL[Bq+YQ,jWHgo%$');
define('SECURE_AUTH_SALT', 'CNPo:6||MmoYIlcR!?WO`T(O`qLm[a|&*30kwr,Xmw_p4XLyVHr9O_So>?K!U/Oo');
define('LOGGED_IN_SALT',   'z75O-jYF$(%GWT|{LE5]C(-]* *NWxhr`Vd} 1;h49wKSl,_*M9?wPd lvcjO-=w');
define('NONCE_SALT',       '&k|B<48^#r>*AT)u7wdQ4C?YwqvQNV(`CJY>=xW8(= E.ofSE{hdknd;#F3[=cN$');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
