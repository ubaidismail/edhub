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
define('DB_NAME', 'wordpress-313733e523');

/** MySQL database username */
define('DB_USER', 'wordpress-313733e523');

/** MySQL database password */
define('DB_PASSWORD', '4b5b90e34ca3');

/** MySQL hostname */
define('DB_HOST', 'sdb-d.hosting.stackcp.net');

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
define('AUTH_KEY',         'rJDV0eEezin7XxKo6k8bfVYs6Ya8czvi');
define('SECURE_AUTH_KEY',  'KHHS0G1Uqzp2jvAcJ605elvSvn8t/7Xx');
define('LOGGED_IN_KEY',    'Zkk1clAHKCL3toNK/TircsvaVw3gEPUS');
define('NONCE_KEY',        'WnUmIhijdl+v25sG7gW7X3Pbx/nSSnVm');
define('AUTH_SALT',        'ep4eX1iFOLjoGnrKeydG054Rt0AQpmGR');
define('SECURE_AUTH_SALT', 'cJYR5xFizKu9aHOYJZtcj6+/l6ofZw8u');
define('LOGGED_IN_SALT',   'o3Cn8nkIKw7JWZ3yaZl+dWalVxlpua2B');
define('NONCE_SALT',       'VX1oQsYsO7AMJdMo7MOAWgahoKMQlqGS');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = '82_';

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
