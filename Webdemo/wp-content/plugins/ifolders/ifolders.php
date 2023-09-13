<?php
/**
 * Plugin Name: iFolders
 * Plugin URI: https://1.envato.market/getifolders
 * Description: A better way to organize WordPress media library, posts, pages, users & custom post types in a logical way. Just drag & drop items into folders you and use them easely.
 * Version: 1.4.15
 * Requires at least: 4.6
 * Requires PHP: 7.0
 * Author: Avirtum
 * Author URI: https://1.envato.market/avirtum
 * License: GPLv3
 * Text Domain: ifolders
 * Domain Path: /languages
 */
namespace iFolders;

defined('ABSPATH') || exit;

define('IFOLDERS_PLUGIN_NAME', 'ifolders');
define('IFOLDERS_PLUGIN_VERSION', '1.4.15');
define('IFOLDERS_PLUGIN_DB_VERSION', '1.1.0');
define('IFOLDERS_PLUGIN_DB_TABLE_PREFIX', 'ifolders');
define('IFOLDERS_PLUGIN_SHORTCODE_NAME', 'ifolders');
define('IFOLDERS_PLUGIN_BASE_NAME', plugin_basename(__FILE__));
define('IFOLDERS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('IFOLDERS_PLUGIN_REST_URL', 'ifolders/v1');
define('IFOLDERS_PLUGIN_PUBLIC_REST_URL', 'ifolders/public/v1');
define('IFOLDERS_FEEDBACK_URL', 'https://avirtum.com/api/feedback/');
define('IFOLDERS_LICENSE_URL', 'https://avirtum.com/api/license/');

class Plugin {
    protected static function autoloader() {
        spl_autoload_register(function ($class) {
            $prefix = __NAMESPACE__;
            $base = __DIR__ . '/includes/';

            // does the class use the namespace prefix?
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                // no, move to the next registered autoloader
                return;
            }

            // get the relative class name
            $relative_class = substr($class, $len);

            // replace the namespace prefix with the base directory, replace namespace
            // separators with directory separators in the relative class name, append
            // with .php
            $file = $base . str_replace('\\', DIRECTORY_SEPARATOR, $relative_class) . '.php';

            if (file_exists($file)) {
                require $file;
            }
        });
    }

    public static function run() {
        self::autoloader();

        add_action('plugins_loaded', ['iFolders\\Plugin', 'loaded']);
        add_action('activated_plugin', ['iFolders\\Plugin', 'activated_plugin']);
        register_activation_hook(__FILE__, ['iFolders\\App', 'activate']);
        register_deactivation_hook(__FILE__, ['iFolders\\App', 'deactivate']);
    }

    public static function loaded() {
        load_plugin_textdomain('ifolders', false, dirname(plugin_basename(__FILE__)) . '/languages/');
        App::getInstance();
    }

    public static function activated_plugin($plugin) {
        if($plugin == plugin_basename(__FILE__)) {
            exit(wp_redirect(admin_url('options-general.php?page=ifolders-settings')));
        }
    }
}
Plugin::run();