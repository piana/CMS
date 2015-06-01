<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'pianka_cba_pl');

/** MySQL database username */
define('DB_USER', 'jjj_pianka');

/** MySQL database password */
define('DB_PASSWORD', 'piancur666');

/** MySQL hostname */
define('DB_HOST', 'mysql.cba.pl');

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
define('AUTH_KEY',         'Dglhh wX*yfn2X$*bNt56h3aA]GKTZTsy2JMPHT&||_?{+hO+2pgYsO&)Y(Cf9-5');
define('SECURE_AUTH_KEY',  'td:,kT?r.e]+>mSS8JxC!bU{sK8HFN=w[@|!./|0dkSL1JzKFS>C*1!;+1PhY5?_');
define('LOGGED_IN_KEY',    'd.-ilMS,b~$*BAk.;@-4hH(h3|i{c}ZdWaSM)j#|^nj.b]yR8;q|C6CYPOOEkg&!');
define('NONCE_KEY',        '+7,8fIEW-Q(!DOZq+~H2biX!|zYGgyp*ipr;pA<,Y8xaq9%/fQi6,MS_Z[,F}9e-');
define('AUTH_SALT',        ' K*+=+f6v${bD.vZ:|a!xXkZd Jm%wq3+cR.=Z7e@#.>T6+FpP+-2Zu9cur-(mg_');
define('SECURE_AUTH_SALT', 'b1XJ6|_<SC$Lzz8#w~>|^UPEE<xXyRc70C-x&Jb)/H5~ZIz;U*YhO5|!6@?>|3=]');
define('LOGGED_IN_SALT',   '_`GrRe|+JclT-/bv,-3H4Z=~c#QWVRZ%5TN+/&P ]BE^K/|@6U)WOq(Vs33+=7[p');
define('NONCE_SALT',       'iqJ+rlk+673F93|7Dg+GqkY+0,J]bmM&%G-n1M/FHdk-_ECdq=RyJa1)}&{FNAE)');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

define('FS_METHOD', 'direct');

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
