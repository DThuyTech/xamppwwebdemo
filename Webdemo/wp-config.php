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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost:8088' );


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
define( 'AUTH_KEY',         '!$Y4Z9>O2h^9XW7KO?V:kc|A5Wydp,cRHFo#::R4*eU}f&6oat2-r-sjQ{n2g5Nu' );
define( 'SECURE_AUTH_KEY',  '22uFvz9Txp^JX6i|K`s}SSPhVU9Ke,eRUi]EV&ssNjxHt?Xk$QoTN;kW:Poi6Ud)' );
define( 'LOGGED_IN_KEY',    'kR2V@<RR9.-#6,?<$R0lkG>h,jNU?bMhb2f;qi}(ox-:t.REe-[qySLYlc3qNp`)' );
define( 'NONCE_KEY',        '=Sn:c!OPAuf=qW*YDb-RcIY)p ?56`kN@x$HL^u=~{=b:Gw+pXZ~%bL,^6u@Fx0z' );
define( 'AUTH_SALT',        'BxAcb$YOLs*=/cGbp}IT@NfvwQDN2-HA*-~t+Wf)PL}jnSYu9 U7tK1|*xA&DVA@' );
define( 'SECURE_AUTH_SALT', 'F%DhFTV:E#du Z$e$KK>i%p8[m1g{Dp&>}QClRVNp>CSAYa>,s.cNHGNtg,YXMhe' );
define( 'LOGGED_IN_SALT',   '~8j0&%s{figP<j8qN<%/sXx+m[3JvFmDxVhE~e3(;SzI?8e<EsGa1oKD11/CN|r$' );
define( 'NONCE_SALT',       'Td0(M*WTT.ZeBwfoAyPx@%LirWpLIGVx),~b6<SE^BYgatnSGyF:0@ox!%g`F0*G' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'tp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
