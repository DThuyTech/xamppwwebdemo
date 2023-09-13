<?php
namespace iFolders;

defined('ABSPATH') || exit;

class App extends Singleton {
    private $ajax = [
        'get_template' => 'ifolders_get_template',
        'get_app_data' => 'ifolders_get_app_data',
        'update_app_data' => 'ifolders_update_app_data',
        'get_settings_data' => 'ifolders_get_settings_data',
        'update_settings_data' => 'ifolders_update_settings_data'
    ];
    private $access = false;

    public static function activate() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $table = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';
        $sql = "CREATE TABLE {$table} (
			id bigint UNSIGNED NOT NULL AUTO_INCREMENT,
			title varchar(255) DEFAULT NULL,
	        parent bigint UNSIGNED NOT NULL DEFAULT 0,
	        type varchar(20) NOT NULL DEFAULT 'attachment',
	        color varchar(7) DEFAULT NULL,
			user_id bigint UNSIGNED NOT NULL DEFAULT 0,
			group_id bigint UNSIGNED NOT NULL DEFAULT 0,
			count bigint UNSIGNED NOT NULL DEFAULT 0,
			sort bigint UNSIGNED NOT NULL DEFAULT 0,
			created datetime NOT NULL,
			modified datetime NOT NULL,
			PRIMARY KEY id (id)
		) {$charset_collate};";
        dbDelta($sql);

        $table = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_attachments';
        $sql = "CREATE TABLE {$table} (
            folder_id bigint UNSIGNED NOT NULL,
            attachment_id bigint UNSIGNED NOT NULL,
            PRIMARY KEY id (folder_id,attachment_id)
        ) {$charset_collate};";
        dbDelta($sql);

        $table = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_groups';
        $sql = "CREATE TABLE {$table} (
            id bigint UNSIGNED NOT NULL AUTO_INCREMENT,
            title varchar(255) DEFAULT NULL,
            enabled tinyint NOT NULL DEFAULT 1,
            shared tinyint NOT NULL DEFAULT 1,
            created datetime NOT NULL,
			modified datetime NOT NULL,
            PRIMARY KEY id (id)
        ) {$charset_collate};";
        dbDelta($sql);

        $table = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_rights';
        $sql = "CREATE TABLE {$table} (
            user_id bigint UNSIGNED NOT NULL,
            group_id bigint UNSIGNED NOT NULL,
            c tinyint NOT NULL DEFAULT 1,
            v tinyint NOT NULL DEFAULT 1,
            e tinyint NOT NULL DEFAULT 1,
            d tinyint NOT NULL DEFAULT 1,
            a tinyint NOT NULL DEFAULT 1,
            PRIMARY KEY id (user_id,group_id)
        ) {$charset_collate};";
        dbDelta($sql);

        $table = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_access';
        $sql = "CREATE TABLE {$table} (
            type varchar(20) NOT NULL,
            group_id bigint UNSIGNED NOT NULL,
            PRIMARY KEY id (type,group_id)
        ) {$charset_collate};";
        dbDelta($sql);

        $table = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folder_types';
        $sql = "CREATE TABLE {$table} (
            type varchar(20) NOT NULL,
            title varchar(255) DEFAULT NULL,
            enabled tinyint NOT NULL DEFAULT 1,
            predefined tinyint NOT NULL DEFAULT 0,
            sort bigint UNSIGNED NOT NULL DEFAULT 999999999,
            PRIMARY KEY id (type)
        ) {$charset_collate};";
        dbDelta($sql);

        App::activate_db();
        App::activate_options();
    }

    public static function activate_db() {
        global $wpdb;
        $tableFolderTypes = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folder_types';
        $tableGroups = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_groups';
        $tableRights = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_rights';
        $tableAccess = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_access';

        $sets = array(
            ['type' => 'attachment',  'title' => 'Media',                'enabled' => 1, 'predefined' => 1, 'sort' => 0],
            ['type' => 'page',        'title' => 'Pages',                'enabled' => 1, 'predefined' => 1, 'sort' => 1],
            ['type' => 'post',        'title' => 'Posts',                'enabled' => 0, 'predefined' => 1, 'sort' => 2],
            ['type' => 'users',       'title' => 'Users',                'enabled' => 0, 'predefined' => 1, 'sort' => 3],
            ['type' => 'product',     'title' => 'WooCommerce Products', 'enabled' => 0, 'predefined' => 1, 'sort' => 4],
            ['type' => 'shop_coupon', 'title' => 'WooCommerce Coupons',  'enabled' => 0, 'predefined' => 1, 'sort' => 5],
            ['type' => 'shop_order',  'title' => 'WooCommerce Orders',   'enabled' => 0, 'predefined' => 1, 'sort' => 6]
        );
        foreach($sets as $set) {
            $sql = $wpdb->prepare("INSERT IGNORE INTO {$tableFolderTypes} (type,title,enabled,predefined) VALUES (%s,%s,%d,%d)", $set['type'], $set['title'], $set['enabled'], $set['predefined']);
            $wpdb->query($sql);
        }
        foreach($sets as $set) {
            $sql = $wpdb->prepare("UPDATE {$tableFolderTypes} SET title=%s, sort=%d, predefined=%d WHERE type=%s", $set['title'], $set['sort'], $set['predefined'], $set['type']);
            $wpdb->query($sql);
        }

        $sql = "SELECT COUNT(id) FROM {$tableGroups}";
        $count = intval($wpdb->get_var($sql), 10);

        if($count == 0) {
            $result = $wpdb->insert(
                $tableGroups,
                [
                    'title' => 'Main',
                    'enabled' => true,
                    'shared' => false,
                    'created' => current_time('mysql', 1),
                    'modified' => current_time('mysql', 1)
                ]
            );

            if($result) {
                $group_id = $wpdb->insert_id;
                $result = $wpdb->insert(
                    $tableRights,
                    [
                        'group_id' => $group_id,
                        'user_id' => get_current_user_id(),
                        'c' => true,
                        'v' => true,
                        'e' => true,
                        'd' => true,
                        'a' => true
                    ]
                );

                if ($result) {
                    $sql = $wpdb->prepare("INSERT IGNORE INTO {$tableAccess} (type,group_id) VALUES (%s,%d)", 'attachment', $group_id);
                    $wpdb->query($sql);

                    $sql = $wpdb->prepare("INSERT IGNORE INTO {$tableAccess} (type,group_id) VALUES (%s,%d)", 'page', $group_id);
                    $wpdb->query($sql);
                }
            }
        }

        $key = 'ifolders_state';
        $options = App::get_options($key);
        if($options == NULL) {
        }
    }

    public static function activate_options() {
        $key = 'ifolders_state';
        $options = App::get_options($key);
        if($options == NULL) {
            $options = [];
            $options['first_activation'] = time();
        }
        $options['plugin_version'] = IFOLDERS_PLUGIN_VERSION;
        $options['db_version'] = IFOLDERS_PLUGIN_DB_VERSION;
        App::set_options($key, $options);

        $key = 'ifolders_settings';
        $options = App::get_options($key);
        if($options == NULL) {
            $options = [
                'roles' => ['administrator'],
                'default_color' => NULL,
                'disable_counter' => false,
                'disable_ajax' => false,
                'infinite_scrolling' => false
            ];
            App::set_options($key, $options);
        }
    }

    public static function deactivate() {
    }

    public static function get_options($key) {
        $option_value = get_option($key);
        if($option_value) {
            return unserialize($option_value);
        }
        return NULL;
    }

    public static function set_options($key, $options) {
        $option_value = serialize($options);

        if(get_option($key) == false) {
            $deprecated = null;
            $autoload = 'no';
            return add_option($key, $option_value, $deprecated, $autoload);
        } else {
            $old_value = get_option($key);
            if($old_value === $option_value) {
                return true;
            } else {
                return update_option($key, $option_value);
            }
        }
    }

    public function initialization() {
        add_action('init', array($this, 'init'));
    }

    public function init() {
        $config = $this->get_config_data();
        if(isset($config->infinite_scrolling) && $config->infinite_scrolling) {
            add_filter('media_library_infinite_scrolling', '__return_true');
        }

        add_filter('plugin_action_links_' . IFOLDERS_PLUGIN_BASE_NAME, [$this, 'plugin_action_links'], 10, 4);
        add_action('admin_notices', [$this, 'admin_notices']);
        add_action('admin_head', [$this, 'admin_head']);
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_footer', [$this, 'admin_footer']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);

        if(defined('AVADA_VERSION')) {
            add_action('fusion_enqueue_live_scripts', [$this, 'enqueue_scripts']);
        } else if(defined('ELEMENTOR_VERSION')) {
            add_action('elementor/editor/before_enqueue_scripts', [$this, 'enqueue_scripts']);
        } else {
            add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        }

        add_action('in_admin_header', [$this, 'in_admin_header']);
        add_action('delete_post', [$this, 'delete_post']);
        add_action('add_attachment', [$this, 'add_attachment']);
        add_action('pre_get_users', [$this, 'redirect_to_main']);
        add_filter('pre_user_query', [$this, 'pre_user_query']);
        add_action('pre_get_posts', [$this, 'redirect_to_main']);
        add_filter('posts_clauses', [$this, 'posts_clauses']);

        add_action('wp_ajax_' . $this->ajax['get_template'], [$this, 'ajax_get_template']);
        add_action('wp_ajax_' . $this->ajax['get_app_data'], [$this, 'ajax_get_app_data']);
        add_action('wp_ajax_' . $this->ajax['update_app_data'], [$this, 'ajax_update_app_data']);
        add_action('wp_ajax_' . $this->ajax['get_settings_data'], [$this, 'ajax_get_settings_data']);
        add_action('wp_ajax_' . $this->ajax['update_settings_data'], [$this, 'ajax_update_settings_data']);

        $this->register_gutenberg_blocks();
    }

    public function register_gutenberg_blocks() {
    }

    public function plugin_action_links($actions) {
        $links = [];
        $links['settings'] = '<a href="' . network_admin_url('options-general.php?page=ifolders-settings') . '">Settings</a>';

        if(!$this->get_ticket()) {
            $links['gopro'] = '<a href="https://1.envato.market/getifolders" target="_blank" >Go Pro</a>';
        }

        return array_merge($actions, $links);
    }

    public function admin_notices() {
        if(get_option('ifolders_dismiss_first_use_notification', false) || (get_current_screen() && get_current_screen()->base === 'upload')) {
            return;
        }

        $classes = [
            'notice',
            'notice-info',
            'is-dismissible',
        ];
        $msg = sprintf(
            '<span>' . esc_html__('Thanks for start using the iFolders plugin. Let\'s create first folders. %s', 'ifolders') . '</span>',
            '<a href="' . esc_url(admin_url('/upload.php')) . '">' . esc_html__('Go to WordPress Media Library.', 'ifolders') . '</a>'
        );
        printf('<div id="ifolders-first-use-notification" class="%s"><p>%s</p></div>', trim(implode(' ',$classes)), $msg);
    }

    public function admin_head() {
        echo '<style>#screen-meta-links {position: absolute; right: 0;} .wrap {margin-top: 15px;}</style>';
    }

    public function admin_menu() {
        $slug = 'ifolders-settings';

        add_submenu_page(
            'options-general.php',
            'iFolders Settings',
            'iFolders',
            'manage_options',
            $slug,
            [$this, 'admin_menu_page_settings']
        );
    }

    public function admin_footer() {
        if(get_current_screen() && get_current_screen()->base !== 'plugins') {
            return;
        }

        $globals = [
            'token' => $this->get_token(),
            'ajax' => [
                'url' => IFOLDERS_FEEDBACK_URL
            ]
        ];

        wp_enqueue_style('ifolders-feedback-css', IFOLDERS_PLUGIN_URL . 'assets/css/feedback.css', [], IFOLDERS_PLUGIN_VERSION);
        wp_enqueue_script('ifolders-feedback-js', IFOLDERS_PLUGIN_URL . 'assets/js/feedback.js', ['jquery'], IFOLDERS_PLUGIN_VERSION, false);
        wp_localize_script('ifolders-feedback-js', 'ifolders_feedback_globals', $globals);

        require_once(plugin_dir_path(dirname(__FILE__)) . 'templates/feedback.php');
    }

    private function get_config_data() {
        $config = $this->get_options('ifolders_settings');
        if($config) {
            return (object) $config;
        }
        return (object) [
            'roles' => [],
            'default_color' => NULL,
            'disable_counter' => false,
            'disable_ajax' => false,
            'infinite_scrolling' => false
        ];
    }

    private function set_config_data($config) {
        return $this->set_options('ifolders_settings', (array) $config);
    }

    private function get_messages($extra = false): array {
        $messages = [
            'success' => esc_html__('The operation completed successfully', 'ifolders'),
            'failed' => esc_html__('The operation failed', 'ifolders'),
            'upgrade' => esc_html__('Upgrade to PRO and unlock all features', 'ifolders'),
            'parent_folder' => esc_html__('Parent Folder', 'ifolders'),
        ];
        if($extra) {
            $messages['status'] = [
                '400' => esc_html__('The license is already registered for other domain', 'ifolders'),
                '401' => esc_html__('Failed to connect to license server', 'ifolders'),
                '402' => esc_html__('The personal token is invalid or has been deleted', 'ifolders'),
                '403' => esc_html__('The personal token is missing the required permission for license server', 'ifolders'),
                '404' => esc_html__('Invalid purchase code', 'ifolders'),
                '405' => esc_html__('Something goes wrong, try again shortly', 'ifolders'),
                '406' => esc_html__('Parsing error, try again shortly', 'ifolders'),
                '407' => esc_html__('Error updating license data', 'ifolders'),
            ];
        }

        return $messages;
    }

    private function get_admin_globals(): array {
        $globals = [ // nested array supports boolean type
            'data' => [
                'version' => IFOLDERS_PLUGIN_VERSION
            ],
            'ajax' => [
                'url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ifolders-ajax-nonce'),
                'actions' => [
                    'get_data' => $this->ajax['get_settings_data'],
                    'update_data' => $this->ajax['update_settings_data']
                ]
            ]
        ];
        return $globals;
    }

    private function get_globals(): array {
        $post_type = $this->get_post_type();
        $rights = $this->get_rights($post_type);
        $config = $this->get_config_data();

        $globals = [ // nested array supports boolean type
            'data' => [
                'version' => IFOLDERS_PLUGIN_VERSION,
                'rights' => $rights ?
                    [
                    'shared' => $rights['shared'],
                    'c' => $rights['c'],
                    'v' => $rights['v'],
                    'e' => $rights['e'],
                    'd' => $rights['d'],
                    'a' => $rights['a']
                    ] : null,
                'meta' => $this->get_meta($post_type),
                'default_color' => $config->default_color,
                'disable_counter' => $config->disable_counter,
                'disable_ajax' => $config->disable_ajax,
                'type' => $post_type,
                'ticket' => $this->get_ticket() ? true : false
            ],
            'msg' => $this->get_messages(),
            'ajax' => [
                'url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('ifolders-ajax-nonce'),
                'actions' => [
                    'get_template' => $this->ajax['get_template'],
                    'get_data' => $this->ajax['get_app_data'],
                    'update_data' => $this->ajax['update_app_data']
                ]
            ]
        ];
        return $globals;
    }

    private function get_rights($type) {
        global $wpdb;
        $tableAccess = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_access';
        $tableGroups = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_groups';
        $tableRights = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_rights';

        $sql = $wpdb->prepare("
            SELECT R.user_id, R.group_id, R.c, R.v, R.e, R.d, R.a, G.shared 
            FROM {$tableAccess} AS A
            LEFT JOIN {$tableGroups} AS G
            ON G.id = A.group_id AND G.enabled
            LEFT JOIN {$tableRights} AS R
            ON R.user_id=%d AND R.group_id=G.id
            WHERE A.type=%s
            ORDER BY G.title
            LIMIT 1",
            get_current_user_id(), $type
        );
        $rights = $wpdb->get_row($sql, 'ARRAY_A');

        if($rights) {
            return [
                'user_id' => $rights['user_id'],
                'group_id' => $rights['group_id'],
                'shared' => boolval($rights['shared']),
                'c' => boolval($rights['c']),
                'v' => boolval($rights['v']),
                'e' => boolval($rights['e']),
                'd' => boolval($rights['d']),
                'a' => boolval($rights['a'])
            ];
        }
        return NULL;
    }

    private function get_meta($type) {
        $user_id = get_current_user_id();
        $meta_default = [
            'folder' => -1, // All items
            'collapsed' => null,
            'sort' => [
                'items' => null
            ]
        ];
        $user_meta = (array)get_user_meta($user_id, 'ifolders_states', true);
        $meta = isset($user_meta['types'][$type]) ? array_replace_recursive($meta_default, $user_meta['types'][$type]) : $meta_default;
        return $meta;
    }

    private function get_ticket() {
        $key = 'ifolders_state';
        $options = App::get_options($key);
        if($options && array_key_exists('token', $options)) {
            return $options['token'];
        }
        return null;
    }

    private function get_post_type() {
        global $typenow;

        $page = basename($_SERVER['PHP_SELF']);
        $type = 'attachment';

        switch($page) {
            case 'users.php': $type = 'users'; break;
            case 'edit.php': $type = $typenow; break;
        }
        return $type;
    }

    private function has_access(): bool {
        $config = $this->get_config_data();

        $user_id = get_current_user_id();
        $user = get_user_by('id', $user_id);
        $exist = false;
        if($user) {
            foreach($user->roles as $user_role) {
                foreach($config->roles as $role) {
                    if($role == $user_role) {
                        $exist = true;
                        break;
                    }
                }
            }
        }

        if(!$exist) {
            return false;
        }

        $type = $this->get_post_type();
        $type = $type ? $type : 'attachment';

        global $wpdb;
        $tableFolderTypes = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folder_types';

        $sql = $wpdb->prepare("
            SELECT enabled 
            FROM {$tableFolderTypes}
            WHERE type=%s",
            $type
        );
        $enabled = boolval($wpdb->get_var($sql));

        if($enabled) {
            $rights = $this->get_rights($type);
            if($rights && ($rights['c'] || $rights['v'])) {
                return true;
            }
        }
        return false;
    }

    public function admin_menu_page_settings() {
        $page = filter_input(INPUT_GET, 'page', FILTER_DEFAULT);
        if($page === 'ifolders-settings') {
            $globals = [
                'version' => IFOLDERS_PLUGIN_VERSION,
                'token' => $this->get_token(), //???
                'msg' => $this->get_messages(true),
                'ajax' => [
                    'license_url' => IFOLDERS_LICENSE_URL,
                    'url' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('ifolders-ajax-nonce'),
                    'actions' => [
                        'get_template' => $this->ajax['get_template'],
                        'get_data' => $this->ajax['get_settings_data'],
                        'update_data' => $this->ajax['update_settings_data']
                    ]
                ]
            ];

            wp_enqueue_style('ifolders-settings-css', IFOLDERS_PLUGIN_URL . 'assets/css/settings.css', [], IFOLDERS_PLUGIN_VERSION);
            wp_enqueue_style('ifolders-notify-css', IFOLDERS_PLUGIN_URL . 'assets/css/notify.css', [], IFOLDERS_PLUGIN_VERSION);
            wp_enqueue_style('ifolders-colorpicker-css', IFOLDERS_PLUGIN_URL . 'assets/css/colorpicker.css', [], IFOLDERS_PLUGIN_VERSION);
            wp_enqueue_style('ifolders-misc-css', IFOLDERS_PLUGIN_URL . 'assets/css/misc.css', [], IFOLDERS_PLUGIN_VERSION);
            wp_enqueue_script('ifolders-cookies-js', IFOLDERS_PLUGIN_URL . 'assets/js/cookies.js', [], IFOLDERS_PLUGIN_VERSION, false);
            wp_enqueue_script('ifolders-notify-js', IFOLDERS_PLUGIN_URL . 'assets/js/notify.js', ['jquery'], IFOLDERS_PLUGIN_VERSION, false);
            wp_enqueue_script('ifolders-colorpicker-js', IFOLDERS_PLUGIN_URL . 'assets/js/colorpicker.js', ['jquery'], IFOLDERS_PLUGIN_VERSION, false);
            wp_enqueue_script('ifolders-settings-js', IFOLDERS_PLUGIN_URL . 'assets/js/settings.js', ['jquery'], IFOLDERS_PLUGIN_VERSION, false );
            wp_enqueue_script('ifolders-angular-light-js', IFOLDERS_PLUGIN_URL . 'assets/js/lib/angular-light/angular-light.js', ['jquery'], IFOLDERS_PLUGIN_VERSION, false );
            wp_localize_script('ifolders-settings-js', 'ifolders_settings_globals', $globals);

            require_once(plugin_dir_path( dirname(__FILE__) ) . 'templates/settings.php');
        }
    }

    public function enqueue_scripts() {
        wp_enqueue_style('ifolders-admin-css', IFOLDERS_PLUGIN_URL . 'assets/css/admin.css', [], IFOLDERS_PLUGIN_VERSION);
        wp_enqueue_script('ifolders-admin-js', IFOLDERS_PLUGIN_URL . 'assets/js/admin.js', ['jquery'], IFOLDERS_PLUGIN_VERSION, false);
        wp_localize_script('ifolders-admin-js', 'ifolders_admin_globals', $this->get_admin_globals());

        if($this->has_access()) {
            wp_enqueue_style('ifolders-notify-css', IFOLDERS_PLUGIN_URL . 'assets/css/notify.css', [], IFOLDERS_PLUGIN_VERSION);
            wp_enqueue_style('ifolders-colorpicker-css', IFOLDERS_PLUGIN_URL . 'assets/css/colorpicker.css', [], IFOLDERS_PLUGIN_VERSION);
            wp_enqueue_style('ifolders-app-css', IFOLDERS_PLUGIN_URL . 'assets/css/app.css', [], IFOLDERS_PLUGIN_VERSION);
            wp_enqueue_style('ifolders-misc-css', IFOLDERS_PLUGIN_URL . 'assets/css/misc.css', [], IFOLDERS_PLUGIN_VERSION);
            wp_enqueue_script('ifolders-cookies-js', IFOLDERS_PLUGIN_URL . 'assets/js/cookies.js', [], IFOLDERS_PLUGIN_VERSION, false);
            wp_enqueue_script('ifolders-notify-js', IFOLDERS_PLUGIN_URL . 'assets/js/notify.js', ['jquery'], IFOLDERS_PLUGIN_VERSION, false);
            wp_enqueue_script('ifolders-colorpicker-js', IFOLDERS_PLUGIN_URL . 'assets/js/colorpicker.js', ['jquery'], IFOLDERS_PLUGIN_VERSION, false);
            wp_enqueue_script('ifolders-tree-js', IFOLDERS_PLUGIN_URL . 'assets/js/tree.js', ['jquery'], IFOLDERS_PLUGIN_VERSION, false);
            wp_enqueue_script('ifolders-app-js', IFOLDERS_PLUGIN_URL . 'assets/js/app.js', ['jquery'], IFOLDERS_PLUGIN_VERSION, false);
            wp_localize_script('ifolders-app-js', 'ifolders_globals', $this->get_globals());
        }
    }

    public function in_admin_header() {
        $page = filter_input(INPUT_GET, 'page', FILTER_DEFAULT);

        if($page === 'ifolders-settings') {
            remove_all_actions('admin_notices');
            remove_all_actions('all_admin_notices');
            add_action('admin_notices', [$this, 'admin_notices']);
        }
    }

    public function delete_post($post_id) {
        global $wpdb;
        $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';
        $tableAttachments = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_attachments';

        // folders to refresh after the update
        $sql = $wpdb->prepare("SELECT DISTINCT folder_id as id FROM {$tableAttachments} WHERE attachment_id=%d", $post_id);
        $folders = $wpdb->get_results($sql, 'ARRAY_A');

        $folders_to_refresh = [];
        foreach($folders as $folder) {
            $folders_to_refresh[] = $folder['id'];
        }

        // remove a post from the attachments table
        $sql = $wpdb->prepare("DELETE FROM {$tableAttachments} WHERE attachment_id=%d", $post_id);
        $wpdb->query($sql);

        // update the attachment count
        if(sizeof($folders_to_refresh)) {
            $ids = implode(',', array_map('absint', $folders_to_refresh));
            $sql = $wpdb->prepare("
                UPDATE {$tableFolders} AS F 
                SET count = (SELECT COUNT(folder_id) FROM {$tableAttachments} AS A WHERE A.folder_id = F.id) 
                WHERE id IN(%1s)",
                $ids
            );
            $wpdb->query($sql);
        }
    }

    public function add_attachment($attachment_id) {
        if (isset($_REQUEST['folder'])) {
            $folder_id = intval(sanitize_text_field($_REQUEST['folder']), 10);

            global $wpdb;
            $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';
            $tableAttachments = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_attachments';

            // add new attachments
            $wpdb->insert(
                $tableAttachments,
                [
                    'folder_id' => $folder_id,
                    'attachment_id' => $attachment_id
                ]
            );

            // update the attachment count
            $sql = $wpdb->prepare("
                UPDATE {$tableFolders} AS F 
                SET count = (SELECT COUNT(folder_id) FROM {$tableAttachments} AS A WHERE A.folder_id = F.id) 
                WHERE id=%d",
                $folder_id
            );
            $wpdb->query($sql);
        }
    }

    public function redirect_to_main() {
        $this->access = $this->has_access();
    }

    public function pre_user_query($query) {
        if($this->access) {
            global $wpdb;
            $tableAttachments = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_attachments';
            $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';

            $type = $this->get_post_type();
            $meta = $this->get_meta($type);
            $rights = $this->get_rights($type);
            $folder = $meta['folder'];

            if($folder > 0) {
                $query->query_from .= " LEFT JOIN $tableAttachments AS ATTACHMENTS ON ($wpdb->users.ID = ATTACHMENTS.attachment_id)"; //????
                $query->query_where .= " AND (ATTACHMENTS.folder_id = $folder)";
            } else if($folder == -2) { // uncategorized
                if($rights['shared']) {
                    $group_id = $rights['group_id'];
                    $query->query_where .= " AND ($wpdb->users.ID NOT IN (SELECT ATTACHMENTS.attachment_id FROM $tableAttachments AS ATTACHMENTS LEFT JOIN $tableFolders AS FOLDERS ON FOLDERS.id=ATTACHMENTS.folder_id WHERE FOLDERS.group_id=$group_id))";
                } else {
                    $user_id = $rights['user_id'];
                    $group_id = $rights['group_id'];
                    $query->query_where .= " AND ($wpdb->users.ID NOT IN (SELECT ATTACHMENTS.attachment_id FROM $tableAttachments AS ATTACHMENTS LEFT JOIN $tableFolders AS FOLDERS ON FOLDERS.id=ATTACHMENTS.folder_id WHERE FOLDERS.group_id=$group_id AND FOLDERS.user_id=$user_id))";
                }
            }
        }
        return $query;
    }

    public function posts_clauses($clauses) {
        if($this->access && $this->get_post_type() && strpos($clauses['where'], $this->get_post_type()) !== false) {
            if($this->get_ticket() == null) {
                $action = filter_input(INPUT_POST, 'action', FILTER_DEFAULT);
                $mode = filter_input(INPUT_POST, 'ifolders_mode', FILTER_DEFAULT);
                if ($action === 'query-attachments' && $mode !== 'grid') {
                    return $clauses;
                }
            }

            global $wpdb;
            $tableAttachments = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_attachments';
            $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';

            $type = $this->get_post_type();
            $meta = $this->get_meta($type);
            $rights = $this->get_rights($type);
            $folder = $meta['folder'];

            if ($folder > 0) {
                $clauses['join'] .= " LEFT JOIN $tableAttachments AS ATTACHMENTS ON ($wpdb->posts.ID = ATTACHMENTS.attachment_id)";
                $clauses['where'] = " AND (ATTACHMENTS.folder_id = $folder) " . $clauses['where'];
            } else if ($folder == -2) { // uncategorized
                if ($rights['shared']) {
                    $group_id = $rights['group_id'];
                    $clauses['where'] .= " AND ($wpdb->posts.ID NOT IN (SELECT ATTACHMENTS.attachment_id FROM $tableAttachments AS ATTACHMENTS LEFT JOIN $tableFolders AS FOLDERS ON FOLDERS.id=ATTACHMENTS.folder_id WHERE FOLDERS.group_id=$group_id))";
                } else {
                    $user_id = $rights['user_id'];
                    $group_id = $rights['group_id'];
                    $clauses['where'] .= " AND ($wpdb->posts.ID NOT IN (SELECT ATTACHMENTS.attachment_id FROM $tableAttachments AS ATTACHMENTS LEFT JOIN $tableFolders AS FOLDERS ON FOLDERS.id=ATTACHMENTS.folder_id WHERE FOLDERS.group_id=$group_id AND FOLDERS.user_id=$user_id))";
                }
            }

            switch($meta['sort']['items']) {
                case 'name-asc': {
                    $clauses['orderby'] = " $wpdb->posts.post_title ASC, " . $clauses['orderby'];
                } break;
                case 'name-desc': {
                    $clauses['orderby'] = " $wpdb->posts.post_title DESC, " . $clauses['orderby'];
                } break;
                case 'date-asc': {
                    $clauses['orderby'] = " $wpdb->posts.post_date ASC, " . $clauses['orderby'];
                } break;
                case 'date-desc': {
                    $clauses['orderby'] = " $wpdb->posts.post_date DESC, " . $clauses['orderby'];
                } break;
                case 'mod-asc': {
                    $clauses['orderby'] = " $wpdb->posts.post_modified ASC, " . $clauses['orderby'];
                } break;
                case 'mod-desc': {
                    $clauses['orderby'] = " $wpdb->posts.post_modified DESC, " . $clauses['orderby'];
                } break;
                case 'author-asc': {
                    $clauses['orderby'] = " $wpdb->posts.post_author ASC, " . $clauses['orderby'];
                } break;
                case 'author-desc': {
                    $clauses['orderby'] = " $wpdb->posts.post_author DESC, " . $clauses['orderby'];
                } break;
            }
        }
        return $clauses;
    }

    private function flat_to_tree(array &$folders, $parent = 0): array {
        $branch = [];
        foreach($folders as $key => $folder) {
            if ($folder['parent'] == $parent) {
                $children = $this->flat_to_tree($folders, $folder['id']);

                if($children) {
                    $folder['items'] = $children;
                }

                if(array_key_exists('items', $folder) && $folder['items']) {
                    $branch[] = [
                        'id' => $folder['id'],
                        'own' => $folder['own'],
                        'title' => $folder['title'],
                        'items' => $folder['items'],
                        'color' => $folder['color'],
                        'count' => intval($folder['count'], 10)
                    ];
                } else {
                    $branch[] = [
                        'id' => $folder['id'],
                        'own' => $folder['own'],
                        'title' => $folder['title'],
                        'color' => $folder['color'],
                        'count' => intval($folder['count'], 10)
                    ];
                }
                unset($folders[$key]);
            }
        }
        return $branch;
    }

    private function get_child_folders($parent, &$out) {
        global $wpdb;
        $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';

        $sql = $wpdb->prepare("SELECT id FROM {$tableFolders} WHERE parent=%d ORDER BY sort", $parent);
        $items = $wpdb->get_results($sql, 'ARRAY_A');

        if($items) {
            foreach($items as $item) {
                $out[] = $item['id'];
                $this->get_child_folders($item['id'], $out);
            }
        }
    }

    private function get_parent_and_child_folders_for_copy($parent, $level, &$out ) {
        global $wpdb;
        $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';

        $sql = $wpdb->prepare("SELECT id, title, type, color, user_id, group_id, sort FROM {$tableFolders} WHERE id=%d ORDER BY sort", $parent);
        $items = $wpdb->get_results($sql, 'ARRAY_A');

        if($items) {
            foreach($items as $item) {
                $item['level'] = $level;
                $out[] = (object)$item;
                $this->get_child_folders_for_copy($item['id'], $level + 1, $out);
            }
        }
    }

    private function get_child_folders_for_copy($parent, $level, &$out ) {
        global $wpdb;
        $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';

        $sql = $wpdb->prepare("SELECT id, title, type, color, user_id, group_id, sort FROM {$tableFolders} WHERE parent=%d ORDER BY sort", $parent);
        $items = $wpdb->get_results($sql, 'ARRAY_A');

        if($items) {
            foreach($items as $item) {
                $item['level'] = $level;
                $out[] = (object)$item;
                $this->get_child_folders_for_copy($item['id'], $level + 1, $out);
            }
        }
    }

    private function get_token() {
        global $wp_version;
        $current_user = wp_get_current_user();

        $data = [
            'plugin_name' => IFOLDERS_PLUGIN_NAME,
            'plugin_version' => IFOLDERS_PLUGIN_VERSION,
            'wordpress' => $wp_version,
            'php' => PHP_VERSION,
            'email' => $current_user->user_email,
            'site' => trim(str_replace(['http://', 'https://'], '', get_site_url()), '/')
        ];
        return base64_encode(json_encode($data));
    }

    /**
     * Ajax methods
     */
    public function ajax_get_template() {
        $data = null;
        $result = false;

        if(check_ajax_referer('ifolders-ajax-nonce', 'nonce', false)) {
            $template = filter_input(INPUT_POST, 'template', FILTER_DEFAULT);
            $file = plugin_dir_path(dirname(__FILE__)) . 'templates/' . $template . '.php';

            if(file_exists($file)) {
                ob_start(); // turn on buffering
                require_once($file);
                $data = ob_get_contents(); // get the buffered content into a var
                ob_end_clean(); // clean buffer
                $result = true;
            }
        }

        $result ? wp_send_json_success($data) : wp_send_json_error($data);
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function ajax_get_app_data() {
        $data = null;
        $result = false;

        if(check_ajax_referer('ifolders-ajax-nonce', 'nonce', false)) {
            $inputData = filter_input(INPUT_POST, 'data', FILTER_DEFAULT);
            $jsonData = json_decode($inputData);

            $rights = $this->get_rights($jsonData->type);

            if($rights) {
                switch ($jsonData->target) {
                    case 'meta': {
                        $meta = $this->get_meta($jsonData->type);

                        if($meta) {
                            $data = $meta;
                            $result = true;
                        }
                    } break;
                    case 'rights': {
                        $data['rights'] = [
                            'c' => $rights['c'],
                            'v' => $rights['v'],
                            'e' => $rights['e'],
                            'd' => $rights['d'],
                            'a' => $rights['a']
                        ];
                        $result = true;
                    } break;
                    case 'folders': {
                        global $wpdb;
                        $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';

                        if ($rights['shared'] && $rights['v']) {
                            $sql = $wpdb->prepare("
                                SELECT id, title, parent, color, IF(user_id=%d, 1, 0) as own, count 
                                FROM {$tableFolders}
                                WHERE type=%s AND group_id=%d 
                                ORDER BY sort, created",
                                $rights['user_id'], $jsonData->type, $rights['group_id']
                            );
                            $folders = $wpdb->get_results($sql, 'ARRAY_A');

                            if (!$wpdb->last_error) {
                                foreach($folders as $key => $folder) {
                                    $folders[$key]['own'] = boolval($folder['own']);
                                }
                                $data['folders'] = $this->flat_to_tree($folders);
                                $result = true;
                            }
                        } else if ($rights['v']) {
                            $sql = $wpdb->prepare("
                                SELECT id, title, parent, color, IF(user_id=%d, 1, 0) as own, count 
                                FROM {$tableFolders} 
                                WHERE type=%s AND group_id=%d AND user_id=%d
                                ORDER BY sort, created",
                                $rights['user_id'], $jsonData->type, $rights['group_id'], $rights['user_id']
                            );
                            $folders = $wpdb->get_results($sql, 'ARRAY_A');

                            if (!$wpdb->last_error) {
                                foreach ($folders as $key => $folder) {
                                    $folders[$key]['own'] = boolval($folder['own']);
                                }
                                $data['folders'] = $this->flat_to_tree($folders);
                                $result = true;
                            }
                        }
                    } break;
                    case 'attach_count': {
                        global $wpdb;
                        $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';
                        $tableAttachments = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_attachments';

                        if($rights['v']) {
                            // folders to refresh after the update
                            $folders = [];
                            if(property_exists($jsonData, 'folders') && $jsonData->folders) {
                                $ids = implode(',', array_map('absint', $jsonData->folders));
                                $sql = $wpdb->prepare("
                                    SELECT id, count 
                                    FROM {$tableFolders} 
                                    WHERE type=%s AND id IN(%1s)",
                                    $jsonData->type, $ids
                                );
                                $folders = $wpdb->get_results($sql, 'ARRAY_A');

                                foreach ($folders as $key => $folder) {
                                    $folders[$key]['count'] = intval($folder['count'], 10);
                                }
                            }

                            if($jsonData->type == 'users') {
                                $sql = "SELECT COUNT(id) FROM $wpdb->users";
                                $count = intval($wpdb->get_var($sql), 10);
                                $folders[] = ['id' => '-1', 'count' => $count]; // All files
                            } else {
                                $sql = $wpdb->prepare("
                                    SELECT COUNT(id) 
                                    FROM $wpdb->posts 
                                    WHERE post_type=%s AND post_status!=%s",
                                    $jsonData->type, 'auto-draft'
                                );
                                $count = intval($wpdb->get_var($sql), 10);
                                $folders[] = ['id' => '-1', 'count' => $count]; // All files
                            }

                            if($jsonData->type == 'users') {
                                if($rights['shared']) {
                                    $sql = $wpdb->prepare("
                                        SELECT COUNT(id) 
                                        FROM $wpdb->users 
                                        WHERE id NOT IN (SELECT attachment_id FROM $tableAttachments AS A LEFT JOIN $tableFolders AS F ON F.id = A.folder_id WHERE F.type=%s AND F.group_id=%d)",
                                        $jsonData->type, $rights['group_id']
                                    );
                                } else {
                                    $sql = $wpdb->prepare("
                                        SELECT COUNT(id) 
                                        FROM $wpdb->users 
                                        WHERE id NOT IN (SELECT attachment_id FROM $tableAttachments AS A LEFT JOIN $tableFolders AS F ON F.id = A.folder_id WHERE F.type=%s AND F.group_id=%d AND F.user_id=%d)",
                                        $jsonData->type, $rights['group_id'], $rights['user_id']
                                    );
                                }
                                $count = intval($wpdb->get_var($sql), 10);
                                $folders[] = ['id' => '-2', 'count' => $count]; // Uncategorized
                            } else {
                                if($rights['shared']) {
                                    $sql = $wpdb->prepare("
                                        SELECT COUNT(id) 
                                        FROM $wpdb->posts 
                                        WHERE post_type=%s AND post_status!=%s AND id NOT IN (SELECT attachment_id FROM $tableAttachments AS A LEFT JOIN $tableFolders AS F ON F.id = A.folder_id WHERE F.group_id=%d)",
                                        $jsonData->type, 'auto-draft', $rights['group_id']
                                    );
                                } else {
                                    $sql = $wpdb->prepare("
                                        SELECT COUNT(id) 
                                        FROM $wpdb->posts 
                                        WHERE post_type=%s AND post_status!=%s AND id NOT IN (SELECT attachment_id FROM $tableAttachments AS A LEFT JOIN $tableFolders AS F ON F.id = A.folder_id WHERE F.group_id=%d AND F.user_id=%d)",
                                        $jsonData->type, 'auto-draft', $rights['group_id'], $rights['user_id']
                                    );
                                }
                                $count = intval($wpdb->get_var($sql), 10);
                                $folders[] = array('id' => '-2', 'count' => $count); // Uncategorized
                            }

                            if(!$wpdb->last_error) {
                                $data['folders'] = $folders;
                                $result = true;
                            }
                        }
                    } break;
                    case 'contextmenu': {
                        $data = [
                            [
                                'id' => 'color',
                                'right' => 'e',
                                'title' => esc_html__('Color', 'ifolders'),
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d=" M 1.313 12 L 9.197 19.875 L 18.197 10.875 L 10.322 3 L 1.313 12 L 1.313 12 Z  M 6.384 9.75 L 10.316 5.677 L 14.298 9.75 L 6.384 9.75 Z  M 19.312 12 C 21.562 14.508 22.687 16.382 22.687 17.625 C 22.687 19.489 21.176 21 19.312 21 C 17.449 21 15.937 19.489 15.937 17.625 C 15.937 16.382 17.063 14.508 19.312 12 L 19.312 12 Z " /></svg>'
                            ],
                            [
                                'id' => 'rename',
                                'right' => 'e',
                                'title' => esc_html__('Rename', 'ifolders'),
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d=" M 6.774 8.994 L 4.887 12.768 C 4.868 12.8 4.851 12.833 4.837 12.868 L 4.084 14.373 C 3.991 14.56 3.975 14.77 4.037 14.972 C 4.107 15.167 4.247 15.33 4.426 15.416 C 4.613 15.509 4.823 15.525 5.026 15.463 C 5.22 15.393 5.384 15.253 5.469 15.074 L 6.033 13.945 L 8.967 13.945 L 8.967 13.945 L 9.531 15.074 C 9.616 15.253 9.78 15.393 9.974 15.463 C 10.177 15.525 10.387 15.509 10.574 15.416 C 10.753 15.33 10.893 15.167 10.963 14.972 C 11.025 14.77 11.009 14.56 10.916 14.373 L 8.193 8.926 C 8.107 8.747 7.944 8.607 7.749 8.537 C 7.547 8.475 7.337 8.491 7.15 8.584 C 6.981 8.665 6.847 8.814 6.774 8.994 Z  M 8.189 12.389 L 7.5 11.012 L 6.811 12.389 L 8.189 12.389 L 8.189 12.389 L 8.189 12.389 Z " fill-rule="evenodd" /><path d=" M 14 7.004 L 21 7 L 21 7 L 21 17 L 14 17.004 L 14 7.004 L 14 7.004 Z  M 12 7 L 3.098 7 L 3 17 L 12 17 L 12 7 L 12 7 L 12 7 Z  M 12 19 L 1.786 19 L 1.786 19 C 1.352 19 1 18.648 1 18.214 L 1 5.795 C 1 5.361 1.352 5.009 1.786 5.01 L 12 5.005 L 12 2.996 L 11 2.996 L 11 1.996 L 15 2 L 15 2.996 L 14 2.996 L 14 5.004 L 22.214 5 C 22.648 5 23 5.352 23 5.786 L 23 18.214 C 23 18.648 22.648 19 22.214 19 L 14 19.004 L 14 21 L 15 21 L 15 22 L 14 22 L 14 22 L 12 21.996 L 12 21.996 L 11 21.996 L 11 20.996 L 12 20.996 L 12 19 Z " fill-rule="evenodd" /></svg>'
                            ],
                            [
                                'id' => 'copy',
                                'right' => 'e',
                                'title' => esc_html__('Duplicate', 'ifolders'),
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d=" M 21 8 L 17 8 L 17 8 L 17 8 L 15 8 L 15 8 L 15 8 L 9.098 8 L 9 8 L 9 18 L 9 21 L 21 21 L 21 8 Z  M 15 6.005 L 7.786 6.01 C 7.352 6.009 7 6.361 7 6.795 L 7 16 L 3 16 L 3.098 3 L 15 3 L 15 3 L 15 6.005 L 15 6.005 Z  M 17 6.004 L 22.214 6 C 22.648 6 23 6.352 23 6.786 L 23 22.214 C 23 22.648 22.648 23 22.214 23 L 7.786 23 L 7.786 23 C 7.352 23 7 22.648 7 22.214 L 7 18 L 1.786 18 L 1.786 18 C 1.352 18 1 17.648 1 17.214 L 1 1.795 C 1 1.361 1.352 1.009 1.786 1.01 L 16.214 1 C 16.648 1 17 1.352 17 1.786 L 17 6.004 L 17 6.004 Z " fill-rule="evenodd" /></svg>'
                            ],
                            [
                                'id' => 'delete',
                                'right' => 'd',
                                'title' => esc_html__('Delete', 'ifolders'),
                                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d=" M 10.423 3 C 10.01 3 9.588 3.145 9.289 3.444 C 8.99 3.742 8.846 4.164 8.846 4.577 L 8.846 5.366 L 4.114 5.366 L 4.114 6.943 L 4.902 6.943 L 4.902 19.561 C 4.902 20.858 5.971 21.927 7.268 21.927 L 16.732 21.927 C 18.029 21.927 19.098 20.858 19.098 19.561 L 19.098 6.943 L 19.886 6.943 L 19.886 5.366 L 15.154 5.366 L 15.154 4.577 C 15.154 4.164 15.01 3.742 14.711 3.444 C 14.412 3.145 13.99 3 13.577 3 L 10.423 3 Z  M 10.423 4.577 L 13.577 4.577 L 13.577 5.366 L 10.423 5.366 L 10.423 4.577 Z  M 6.48 6.943 L 17.52 6.943 L 17.52 19.561 C 17.52 19.998 17.169 20.35 16.732 20.35 L 7.268 20.35 C 6.831 20.35 6.48 19.998 6.48 19.561 L 6.48 6.943 Z  M 8.057 9.309 L 8.057 17.984 L 9.634 17.984 L 9.634 9.309 L 8.057 9.309 Z  M 11.211 9.309 L 11.211 17.984 L 12.789 17.984 L 12.789 9.309 L 11.211 9.309 Z  M 14.366 9.309 L 14.366 17.984 L 15.943 17.984 L 15.943 9.309 L 14.366 9.309 Z "/></svg>'
                            ]
                        ];
                        $result = true;
                    } break;
                }
            }
        }

        $result ? wp_send_json_success($data) : wp_send_json_error($data);
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function ajax_update_app_data() {
        $data = null;
        $result = false;

        if(check_ajax_referer('ifolders-ajax-nonce', 'nonce', false)) {
            $inputData = filter_input(INPUT_POST, 'data', FILTER_DEFAULT);
            $jsonData = json_decode($inputData);

            $rights = $this->get_rights($jsonData->type);

            if($rights) {
                switch($jsonData->target) {
                    case 'folders': {
                        global $wpdb;
                        $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';
                        $tableAttachments = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_attachments';

                        switch($jsonData->action) {
                            case 'create': {
                                if($rights['c']) {
                                    $folders = [];

                                    foreach ($jsonData->names as $name) {
                                        $wpdb->insert(
                                            $tableFolders,
                                            [
                                                'title' => $name,
                                                'parent' => $jsonData->parent,
                                                'type' => $jsonData->type,
                                                'color' => $jsonData->color,
                                                'group_id' => $rights['group_id'],
                                                'user_id' => $rights['user_id'],
                                                'created' => current_time('mysql', 1),
                                                'modified' => current_time('mysql', 1),
                                                'sort' => PHP_INT_MAX
                                            ]
                                        );

                                        if (!$wpdb->last_error) {
                                            $folders[] = ['id' => strval($wpdb->insert_id), 'title' => $name, 'color' => $jsonData->color];
                                        } else {
                                            break;
                                        }
                                    }

                                    if (!$wpdb->last_error) {
                                        $data['folders'] = $folders;
                                        $result = true;
                                    }
                                }
                            } break;
                            case 'rename': {
                                if($rights['e']) {
                                    if($rights['shared']) {
                                        $sql = $wpdb->prepare("
                                            UPDATE {$tableFolders} 
                                            SET title=%s, modified=%s 
                                            WHERE id=%d AND group_id=%d",
                                            $jsonData->name, current_time('mysql', 1), $jsonData->folder, $rights['group_id']
                                        );
                                    } else {
                                        $sql = $wpdb->prepare("
                                            UPDATE {$tableFolders} 
                                            SET title=%s, modified=%s 
                                            WHERE id=%d AND group_id=%d AND user_id=%d",
                                            $jsonData->name, current_time('mysql', 1), $jsonData->folder, $rights['group_id'], $rights['user_id']
                                        );
                                    }
                                    $wpdb->query($sql); // $rows = $wpdb->query($sql); UPDATE will return 0 if a field value is equal to a new value

                                    if(!$wpdb->last_error) {
                                        $data['folder'] = $jsonData->folder;
                                        $data['name'] = $jsonData->name;
                                        $result = true;
                                    }
                                }
                            } break;
                            case 'copy': {
                                if($rights['c'] && $rights['e']) {
                                    $out = [];
                                    $folders = [];
                                    $this->get_parent_and_child_folders_for_copy($jsonData->folder, 0, $folders);
                                    $folders_length = count($folders);

                                    $folder_parents[] = intval($jsonData->parent, 10);
                                    $level = 0;
                                    foreach($folders as $key => $folder) {
                                        $wpdb->insert(
                                            $tableFolders,
                                            [
                                                'title' => $folder->title,
                                                'parent' => $folder_parents[$level],
                                                'type' => $folder->type,
                                                'color' => $folder->color,
                                                'group_id' => $folder->group_id,
                                                'user_id' => $folder->user_id,
                                                'created' => current_time('mysql', 1),
                                                'modified' => current_time('mysql', 1),
                                                'sort' => PHP_INT_MAX //$level == 0 ? PHP_INT_MAX : $folder->sort
                                            ]
                                        );

                                        if(!$wpdb->last_error) {
                                            $out[] = [
                                                'id' => strval($wpdb->insert_id),
                                                'title' => $folder->title,
                                                'parent' => $folder_parents[$level],
                                                'color' => $folder->color,
                                                'own' => $folder->user_id == $rights['user_id'] ? 1 : 0,
                                                'count' => 0
                                            ];
                                        } else {
                                            break;
                                        }

                                        $next = $key + 1;
                                        if($next < $folders_length) {
                                            $folder_next = $folders[$next];

                                            if($folder_next->level > $level) {
                                                array_push($folder_parents, $wpdb->insert_id);
                                                $level++;
                                            } else if($folder_next->level < $level) {
                                                array_pop($folder_parents);
                                                $level--;
                                            }
                                        }
                                    }

                                    if(!$wpdb->last_error) {
                                        $data['folders'] = $this->flat_to_tree($out, $folder_parents[0]);
                                        $result = true;
                                    }
                                } else {
                                    $data['msg'] = esc_html__('You do not have permissions to duplicate folders', 'ifolders');
                                }
                            } break;
                            case 'color': {
                                if($rights['e']) {
                                    if($rights['shared']) {
                                        $ids = implode(',', array_map('absint', $jsonData->folders));
                                        $sql = $wpdb->prepare("
                                            SELECT id 
                                            FROM {$tableFolders} 
                                            WHERE id IN(%1s) AND group_id=%d",
                                            $ids, $rights['group_id']
                                        );
                                        $folders = $wpdb->get_results($sql, 'ARRAY_A');

                                        $folders_to_color = [];
                                        foreach ($folders as $folder) {
                                            $folders_to_color[] = $folder['id'];
                                        }
                                    } else {
                                        $ids = implode(',', array_map('absint', $jsonData->folders));
                                        $sql = $wpdb->prepare("
                                            SELECT id 
                                            FROM {$tableFolders} 
                                            WHERE id IN(%1s) AND group_id=%d AND user_id=%d",
                                            $ids, $rights['group_id'], $rights['user_id']
                                        );
                                        $folders = $wpdb->get_results($sql, 'ARRAY_A');

                                        $folders_to_color = [];
                                        foreach($folders as $folder) {
                                            $folders_to_color[] = $folder['id'];
                                        }
                                    }

                                    if(!empty($folders_to_color)) {
                                        $ids = implode(',', array_map('absint', $folders_to_color));
                                        if($jsonData->color) {
                                            $sql = $wpdb->prepare("
                                                UPDATE {$tableFolders} 
                                                SET color=%s, modified=%s 
                                                WHERE id IN(%1s)",
                                                $jsonData->color, current_time('mysql', 1), $ids
                                            );
                                        } else {
                                            $sql = $wpdb->prepare("
                                                UPDATE {$tableFolders} 
                                                SET color=NULL, modified=%s 
                                                WHERE id IN(%1s)",
                                                current_time('mysql', 1), $ids
                                            );
                                        }
                                        $wpdb->query($sql);

                                        if (!$wpdb->last_error) {
                                            $data['folders'] = $folders_to_color;
                                            $data['color'] = $jsonData->color;
                                            $result = true;
                                        }
                                    }
                                }
                            } break;
                            case 'move': {
                                if($rights['e']) {
                                    if($rights['shared']) {
                                        $folder_parent = $jsonData->parent;
                                        if($folder_parent != 0) {
                                            $sql = $wpdb->prepare("
                                                SELECT id, user_id 
                                                FROM {$tableFolders} 
                                                WHERE id=%d AND group_id=%d",
                                                $folder_parent, $rights['group_id']
                                            );
                                            $obj = $wpdb->get_row($sql, 'OBJECT');

                                            $folder_parent = $obj->id;
                                            $user_id_parent = $obj->user_id;
                                        }

                                        $ids = implode(',', array_map('absint', $jsonData->folders));
                                        $sql = $wpdb->prepare("
                                            SELECT id 
                                            FROM {$tableFolders} 
                                            WHERE id IN(%1s) AND group_id=%d",
                                            $ids, $rights['group_id']
                                        );
                                        $folders = $wpdb->get_results($sql, 'ARRAY_A');

                                        $folders_to_move = [];
                                        foreach($folders as $folder) {
                                            $folders_to_move[] = $folder['id'];
                                        }
                                    } else {
                                        $folder_parent = $jsonData->parent;
                                        if($folder_parent != 0) {
                                            $sql = $wpdb->prepare("
                                                SELECT id 
                                                FROM {$tableFolders} 
                                                WHERE id=%d AND group_id=%d AND user_id=%d",
                                                $folder_parent, $rights['group_id'], $rights['user_id']
                                            );
                                            $folder_parent = $wpdb->get_var($sql);
                                        }

                                        $ids = implode(',', array_map('absint', $jsonData->folders));
                                        $sql = $wpdb->prepare("
                                            SELECT id 
                                            FROM {$tableFolders} 
                                            WHERE id IN(%1s) AND group_id=%d AND user_id=%d",
                                            $ids, $rights['group_id'], $rights['user_id']
                                        );
                                        $folders = $wpdb->get_results($sql, 'ARRAY_A');

                                        $folders_to_move = [];
                                        foreach ($folders as $folder) {
                                            $folders_to_move[] = $folder['id'];
                                        }
                                    }

                                    if(!empty($folders_to_move) && isset($folder_parent)) {
                                        $ids = implode(',', array_map('absint', $folders_to_move));

                                        if(isset($user_id_parent)) {
                                            $sql = $wpdb->prepare("
                                                UPDATE {$tableFolders}
                                                SET parent=%d, user_id=%d
                                                WHERE id IN(%1s)",
                                                $folder_parent, $user_id_parent, $ids
                                            );
                                        } else {
                                            $sql = $wpdb->prepare("
                                                UPDATE {$tableFolders} 
                                                SET parent=%d 
                                                WHERE id IN(%1s)",
                                                $folder_parent, $ids
                                            );
                                        }
                                        $wpdb->query($sql);

                                        $sort = 0; //!!!
                                        foreach ($jsonData->sorting as $id) {
                                            $sql = $wpdb->prepare("
                                                UPDATE {$tableFolders} 
                                                SET sort=%d 
                                                WHERE id=%d",
                                                $sort++, $id
                                            );
                                            $wpdb->query($sql);
                                        }

                                        if(!$wpdb->last_error) {
                                            unset($data['msg']);
                                            $data['folders'] = $folders_to_move;
                                            $data['parent'] = $folder_parent;
                                            $data['user_parent'] = $user_id_parent;
                                            $result = true;
                                        }
                                    }
                                } else {
                                    $data['msg'] = esc_html__('You do not have permissions to move folders', 'ifolders');
                                }
                            } break;
                            case 'delete': {
                                if($rights['d']) {
                                    if($rights['shared']) {
                                        $ids = implode(',', array_map('absint', $jsonData->folders));
                                        $sql = $wpdb->prepare("
                                            SELECT id 
                                            FROM {$tableFolders} 
                                            WHERE id IN(%1s) AND group_id=%d",
                                            $ids, $rights['group_id']
                                        );
                                        $folders = $wpdb->get_results($sql, 'ARRAY_A');

                                        $folders_to_delete = [];
                                        foreach($folders as $folder) {
                                            $folders_to_delete[] = $folder['id'];
                                        }
                                    } else {
                                        $ids = implode(',', array_map('absint', $jsonData->folders));
                                        $sql = $wpdb->prepare("
                                            SELECT id 
                                            FROM {$tableFolders} 
                                            WHERE id IN(%1s) AND group_id=%d AND user_id=%d",
                                            $ids, $rights['group_id'], $rights['user_id']
                                        );
                                        $folders = $wpdb->get_results($sql, 'ARRAY_A');

                                        $folders_to_delete = [];
                                        foreach ($folders as $folder) {
                                            $folders_to_delete[] = $folder['id'];
                                        }
                                    }

                                    if(!empty($folders_to_delete)) {
                                        $folders = [];
                                        foreach ($folders_to_delete as $id) {
                                            $folders[] = $id;
                                            $this->get_child_folders($id, $folders);
                                        }
                                        $folders = array_values(array_unique($folders));

                                        $ids = implode(',', array_map('absint', $folders));
                                        $sql = $wpdb->prepare("DELETE FROM {$tableAttachments} WHERE folder_id IN(%1s)", $ids);
                                        $wpdb->query($sql);

                                        $sql = $wpdb->prepare("DELETE FROM {$tableFolders} WHERE id IN(%1s)", $ids);
                                        $wpdb->query($sql);

                                        if(!$wpdb->last_error) {
                                            $data['folders'] = $folders;
                                            $result = true;
                                        }
                                    }
                                }
                            } break;
                            case 'attach': {
                                $data['msg'] = esc_html__('You do not have permissions to attach items to a folder', 'ifolders');

                                if($rights['a']) {
                                    if($rights['shared']) {
                                        $folder_dest = $jsonData->dest;
                                        if(!($folder_dest == -1 || $folder_dest == -2)) {
                                            $sql = $wpdb->prepare("
                                                SELECT id 
                                                FROM {$tableFolders} 
                                                WHERE id=%d AND group_id=%d",
                                                $folder_dest, $rights['group_id']
                                            );
                                            $folder_dest = $wpdb->get_var($sql);
                                        }

                                        if(isset($folder_dest)) {
                                            // folders to refresh after the update
                                            $ids = implode(',', array_map('absint', $jsonData->attachments));
                                            $sql = $wpdb->prepare("
                                                SELECT DISTINCT A.folder_id as id 
                                                FROM {$tableAttachments} AS A 
                                                LEFT JOIN {$tableFolders} AS F 
                                                ON F.id=A.folder_id AND F.group_id=%d
                                                WHERE A.attachment_id IN(%1s)",
                                                $rights['group_id'], $ids
                                            );
                                            $folders = $wpdb->get_results($sql, 'ARRAY_A');

                                            $folders_to_refresh = array($folder_dest);
                                            foreach($folders as $folder) {
                                                if($folder['id'] != $folder_dest) {
                                                    $folders_to_refresh[] = $folder['id'];
                                                }
                                            }

                                            // delete previous attachments
                                            $sql = $wpdb->prepare("
                                                DELETE A.* 
                                                FROM {$tableAttachments} AS A 
                                                LEFT JOIN {$tableFolders} AS F 
                                                ON F.id=A.folder_id AND F.group_id=%d
                                                WHERE A.attachment_id IN(%1s)",
                                                $rights['group_id'], $ids
                                            );
                                            $wpdb->query($sql);

                                            // add new attachments
                                            if(!($folder_dest == -1 || $folder_dest == -2)) {
                                                foreach($jsonData->attachments as $attachment) {
                                                    $wpdb->insert(
                                                        $tableAttachments,
                                                        [
                                                            'folder_id' => $folder_dest,
                                                            'attachment_id' => $attachment
                                                        ]
                                                    );
                                                }
                                            }

                                            // update the attachment count
                                            if(sizeof($folders_to_refresh)) {
                                                $ids = implode(',', array_map('absint', $folders_to_refresh));
                                                $sql = $wpdb->prepare("
                                                    UPDATE {$tableFolders} AS F 
                                                    SET count = (SELECT COUNT(folder_id) FROM {$tableAttachments} AS A WHERE A.folder_id=F.id) 
                                                    WHERE id IN(%1s)",
                                                    $ids
                                                );
                                                $wpdb->query($sql);
                                            }

                                            if(!$wpdb->last_error) {
                                                unset($data['msg']);
                                                $data['folders'] = $folders_to_refresh;
                                                $data['attachments'] = $jsonData->attachments;
                                                $result = true;
                                            }
                                        }
                                    } else {
                                        $folder_dest = $jsonData->dest;
                                        if(!($folder_dest == -1 || $folder_dest == -2)) {
                                            $sql = $wpdb->prepare("
                                                SELECT id 
                                                FROM {$tableFolders} 
                                                WHERE id=%d AND group_id=%d AND user_id=%d",
                                                $folder_dest, $rights['group_id'], $rights['user_id']
                                            );
                                            $folder_dest = $wpdb->get_var($sql);
                                        }

                                        if(isset($folder_dest)) {
                                            // folders to refresh after the update
                                            $ids = implode(',', array_map('absint', $jsonData->attachments));
                                            $sql = $wpdb->prepare("
                                                SELECT DISTINCT A.folder_id as id 
                                                FROM {$tableAttachments} AS A 
                                                LEFT JOIN {$tableFolders} AS F 
                                                ON F.id=A.folder_id AND F.group_id=%d AND F.user_id=%d
                                                WHERE A.attachment_id IN(%1s)",
                                                $rights['group_id'], $rights['user_id'], $ids
                                            );
                                            $folders = $wpdb->get_results($sql, 'ARRAY_A');

                                            $folders_to_refresh = array($folder_dest);
                                            foreach($folders as $folder) {
                                                if($folder['id'] != $folder_dest) {
                                                    $folders_to_refresh[] = $folder['id'];
                                                }
                                            }

                                            // delete previous attachments
                                            $sql = $wpdb->prepare("
                                                DELETE A.* 
                                                FROM {$tableAttachments} AS A 
                                                LEFT JOIN {$tableFolders} AS F 
                                                ON F.id=A.folder_id AND F.group_id=%s AND F.user_id=%s
                                                WHERE A.attachment_id IN(%1s)",
                                                $rights['group_id'], $rights['user_id'], $ids
                                            );
                                            $wpdb->query($sql);

                                            // add new attachments
                                            if(!($folder_dest == -1 || $folder_dest == -2)) {
                                                foreach ($jsonData->attachments as $attachment) {
                                                    $wpdb->insert(
                                                        $tableAttachments,
                                                        [
                                                            'folder_id' => $folder_dest,
                                                            'attachment_id' => $attachment
                                                        ]
                                                    );
                                                }
                                            }

                                            // update the attachment count
                                            if(sizeof($folders_to_refresh)) {
                                                $ids = implode(',', array_map('absint', $folders_to_refresh));
                                                $sql = $wpdb->prepare("
                                                    UPDATE {$tableFolders} AS F 
                                                    SET count = (SELECT COUNT(folder_id) FROM {$tableAttachments} AS A WHERE A.folder_id=F.id) 
                                                    WHERE id IN(%1s)",
                                                    $ids
                                                );
                                                $wpdb->query($sql);
                                            }

                                            if(!$wpdb->last_error) {
                                                unset($data['msg']);
                                                $data['folders'] = $folders_to_refresh;
                                                $data['attachments'] = $jsonData->attachments;
                                                $result = true;
                                            }
                                        }
                                    }
                                }
                            } break;
                        }
                    } break;
                    case 'meta': {
                        $meta['folder'] = $jsonData->meta->folder;
                        $meta['collapsed'] = $jsonData->meta->collapsed;
                        $meta['sort'] = [
                            'items' => $jsonData->meta->sort->items
                        ];

                        $user_meta = (array)get_user_meta($rights['user_id'], 'ifolders_states', true);
                        $user_meta['types'][$jsonData->type] = $meta;
                        update_user_meta($rights['user_id'], 'ifolders_states', $user_meta);

                        $result = true;
                    } break;
                }
            }
        }

        $result ? wp_send_json_success($data) : wp_send_json_error($data);
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function ajax_get_settings_data() {
        $data = null;
        $result = false;

        if(check_ajax_referer('ifolders-ajax-nonce', 'nonce', false)) {
            $inputData = filter_input(INPUT_POST, 'data', FILTER_DEFAULT);
            $jsonData = json_decode($inputData);

            switch($jsonData->target) {
                case 'folders': {
                    global $wpdb;
                    $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';
                    $tableGroups = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_groups';
                    $tableFolderTypes = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folder_types';
                    $tableUsers = $wpdb->users;

                    switch($jsonData->type) {
                        case 'total': {
                            $sql = "SELECT COUNT(*) as total FROM {$tableFolders}";
                            $total = $wpdb->get_var($sql);

                            if(!$wpdb->last_error) {
                                $data['total'] = intval($total, 10);
                                $result = true;
                            }
                        } break;
                        case 'list': {
                            $page = intval($jsonData->page, 10);
                            $count = intval($jsonData->itemsperpage, 10);
                            $columns = array('title', 'type', 'owner', 'group_title', 'attachments', 'created', 'modified');
                            $order_column = in_array($jsonData->order->column, $columns) ? $jsonData->order->column : 'modified';
                            $orders = array('asc', 'desc');
                            $order_type = in_array($jsonData->order->type, $orders) ? $jsonData->order->type : 'desc';
                            $offset = ($page - 1) * $count;


                            $sql = "SELECT COUNT(*) as total FROM {$tableFolders}";
                            $total = $wpdb->get_var($sql);

                            $sql = $wpdb->prepare("
                                SELECT F.id, F.title, F.color, T.title AS type, G.title AS 'group_title', U.display_name AS owner, F.count as attachments, F.created, F.modified 
                                FROM {$tableFolders} AS F
                                LEFT JOIN {$tableGroups} AS G ON G.id = F.group_id
                                LEFT JOIN {$tableUsers} AS U ON U.id = F.user_id
                                LEFT JOIN {$tableFolderTypes} AS T ON T.type = F.type
                                ORDER BY {$order_column} {$order_type} 
                                LIMIT %d, %d",
                                $offset, $count
                            );
                            $list = $wpdb->get_results($sql, 'ARRAY_A');

                            if(!$wpdb->last_error) {
                                foreach($list as $key => $item) {
                                    $list[$key]['attachments'] = intval($item['attachments'], 10);
                                    $list[$key]['created'] = date("d.m.Y", strtotime($item['created']));
                                    $list[$key]['modified'] = date("d.m.Y", strtotime($item['modified']));
                                }

                                $data['test'] = $order_column;
                                $data['total'] = intval($total, 10);
                                $data['list'] = $list;
                                $result = true;
                            }
                        } break;
                    }
                } break;
                case 'groups': {
                    global $wpdb;
                    $tableGroups = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_groups';
                    $tableRights = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_rights';

                    switch($jsonData->type) {
                        case 'total': {
                            $sql = "SELECT COUNT(*) as total FROM {$tableGroups}";
                            $total = $wpdb->get_var($sql);

                            if(!$wpdb->last_error) {
                                $data['total'] = intval($total, 10);
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                        case 'list': {
                            $page = intval($jsonData->page, 10);
                            $count = intval($jsonData->itemsperpage, 10);
                            $offset = ($page - 1) * $count;

                            $sql = "SELECT COUNT(*) as total FROM {$tableGroups}";
                            $total = $wpdb->get_var($sql);

                            $sql = $wpdb->prepare("
                                SELECT id, title, enabled, shared, created, modified 
                                FROM {$tableGroups} 
                                ORDER BY title 
                                LIMIT %d, %d",
                                $offset, $count
                            );
                            $list = $wpdb->get_results($sql, 'ARRAY_A');

                            if(!$wpdb->last_error) {
                                foreach($list as $key => $item) {
                                    $list[$key]['enabled'] = boolval($item['enabled']);
                                    $list[$key]['shared'] = boolval($item['shared']);
                                    $list[$key]['created'] = date('d.m.Y', strtotime($item['created']));
                                    $list[$key]['modified'] = date('d.m.Y', strtotime($item['modified']));
                                }
                                $data['total'] = intval($total, 10);
                                $data['list'] = $list;
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                        case 'item': {
                            $id = intval($jsonData->id, 10);

                            $sql = $wpdb->prepare("
                                SELECT id, title, enabled, shared, created, modified 
                                FROM {$tableGroups} 
                                WHERE id=%d",
                                $id
                            );
                            $item = $wpdb->get_row($sql, 'ARRAY_A');

                            $sql = $wpdb->prepare("
                                SELECT R.user_id, U.display_name as user, R.c, R.v, R.e, R.d, R.a 
                                FROM {$tableRights} AS R 
                                LEFT JOIN $wpdb->users AS U ON U.id = R.user_id 
                                WHERE R.group_id=%d
                                ORDER BY user",
                                $id
                            );
                            $rights = $wpdb->get_results($sql, 'ARRAY_A');

                            if(!$wpdb->last_error) {
                                foreach($rights as $key => $right) {
                                    $rights[$key]['c'] = boolval($right['c']);
                                    $rights[$key]['v'] = boolval($right['v']);
                                    $rights[$key]['e'] = boolval($right['e']);
                                    $rights[$key]['d'] = boolval($right['d']);
                                    $rights[$key]['a'] = boolval($right['a']);
                                }
                                $item['enabled'] = boolval($item['enabled']);
                                $item['shared'] = boolval($item['shared']);
                                $item['created'] = date('d.m.Y', strtotime($item['created']));
                                $item['modified'] = date('d.m.Y', strtotime($item['modified']));
                                $item['rights'] = $rights;

                                $data['item'] = $item;
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                    }
                } break;
                case 'foldertypes': {
                    global $wpdb;
                    $tableFolderTypes = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folder_types';
                    $tableAccess = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_access';
                    $tableGroups = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_groups';

                    $woo_types = ['product', 'shop_coupon', 'shop_order'];
                    $post_types = get_post_types(['public' => true, '_builtin' => false], 'names', 'and');
                    $woo = false;
                    foreach($post_types  as $post_type) {
                        if(in_array($post_type, $woo_types)) {
                            $woo = true;
                            break;
                        }
                    }

                    switch($jsonData->type) {
                        case 'total': {
                            $sql = $woo ? "SELECT COUNT(*) as total FROM {$tableFolderTypes}" : "SELECT COUNT(*) as total FROM {$tableFolderTypes} WHERE type NOT IN ('product', 'shop_coupon', 'shop_order')";
                            $total = $wpdb->get_var($sql);

                            if(!$wpdb->last_error) {
                                $data['total'] = intval($total, 10);
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                        case 'list': {
                            $page = intval($jsonData->page, 10);
                            $count = intval($jsonData->itemsperpage, 10);
                            $offset = ($page - 1) * $count;

                            $sql = $woo ? "SELECT COUNT(*) as total FROM {$tableFolderTypes}" : "SELECT COUNT(*) as total FROM {$tableFolderTypes} WHERE type NOT IN ('product', 'shop_coupon', 'shop_order')";
                            $total = $wpdb->get_var($sql);

                            if($woo) {
                                $sql = $wpdb->prepare("
                                SELECT FT.type, FT.title, FT.enabled, FT.predefined, GROUP_CONCAT(G.title ORDER BY G.title DESC SEPARATOR ', ') AS attached_groups
                                FROM {$tableFolderTypes} AS FT
                                LEFT JOIN {$tableAccess} AS A
                                ON A.type = FT.type
                                LEFT JOIN {$tableGroups} AS G
                                ON G.id = A.group_id
                                GROUP BY type
                                ORDER BY sort, title 
                                LIMIT %d, %d",
                                    $offset, $count
                                );
                            } else {
                                $sql = $wpdb->prepare("
                                SELECT FT.type, FT.title, FT.enabled, FT.predefined, GROUP_CONCAT(G.title ORDER BY G.title DESC SEPARATOR ', ') AS attached_groups
                                FROM {$tableFolderTypes} AS FT
                                LEFT JOIN {$tableAccess} AS A
                                ON A.type = FT.type
                                LEFT JOIN {$tableGroups} AS G
                                ON G.id = A.group_id
                                WHERE FT.type NOT IN ('product', 'shop_coupon', 'shop_order')
                                GROUP BY type
                                ORDER BY sort, title 
                                LIMIT %d, %d",
                                    $offset, $count
                                );
                            }
                            $list = $wpdb->get_results($sql, 'ARRAY_A');

                            if(!$wpdb->last_error) {
                                foreach($list as $key => $item) {
                                    $list[$key]['enabled'] = boolval($item['enabled']);
                                    $list[$key]['predefined'] = boolval($item['predefined']);
                                }
                                $data['total'] = intval($total, 10);
                                $data['list'] = $list;
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                        case 'item': {
                            $id = $jsonData->id;

                            $sql = $wpdb->prepare("
                                SELECT type, title, enabled, predefined
                                FROM {$tableFolderTypes} 
                                WHERE type=%s",
                                $id
                            );
                            $item = $wpdb->get_row($sql, 'ARRAY_A');

                            $sql = $wpdb->prepare("
                                SELECT G.id, G.title
                                FROM {$tableAccess} AS A
                                LEFT JOIN {$tableGroups} AS G ON  A.group_id = G.id
                                WHERE type=%s",
                                $id
                            );
                            $groups = $wpdb->get_results($sql, 'ARRAY_A');

                            if(!$wpdb->last_error) {
                                $item['enabled'] = boolval($item['enabled']);
                                $item['predefined'] = boolval($item['predefined']);
                                $item['groups'] = $groups;

                                $data['item'] = $item;
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                    }
                } break;
                case 'usersinfo': {
                    global $wpdb;
                    $tableUsers = $wpdb->users;
                    $tableGroups = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_groups';
                    $tableRights = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_rights';
                    $tableAccess = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_access';
                    $tableFolderTypes = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folder_types';

                    switch($jsonData->type) {
                        case 'total': {
                            $sql = "SELECT COUNT(*) as total FROM {$tableUsers}";
                            $total = $wpdb->get_var($sql);

                            if(!$wpdb->last_error) {
                                $data['total'] = intval($total, 10);
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                        case 'list': {
                            $page = intval($jsonData->page, 10);
                            $count = intval($jsonData->itemsperpage, 10);
                            $offset = ($page - 1) * $count;

                            $sql = "SELECT COUNT(*) as total FROM {$tableUsers}";
                            $total = $wpdb->get_var($sql);

                            $sql = $wpdb->prepare("
                                SELECT U.id, U.display_name as name, GROUP_CONCAT(DISTINCT FT.title ORDER BY FT.title DESC SEPARATOR ', ') AS access
                                FROM {$tableUsers} U
                                LEFT JOIN {$tableRights} AS R
                                ON U.id = R.user_id 
                                LEFT JOIN {$tableGroups} AS G
                                ON R.group_id = G.id AND G.enabled
                                LEFT JOIN {$tableAccess} AS A
                                ON G.id = A.group_id
                                LEFT JOIN {$tableFolderTypes} AS FT
                                ON A.type = FT.type AND FT.enabled
                                GROUP BY U.id
                                ORDER BY name
                                LIMIT %d, %d",
                                $offset, $count
                            );
                            $list = $wpdb->get_results($sql, 'ARRAY_A');

                            if(!$wpdb->last_error) {
                                $data['total'] = intval($total, 10);
                                $data['list'] = $list;
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                    }
                } break;
                case 'users': {
                    global $wpdb;
                    $tableUsers = $wpdb->users;

                    switch($jsonData->data) {
                        case 'total': {
                            $sql = "SELECT COUNT(*) as total FROM {$tableUsers}";
                            $total = $wpdb->get_var($sql);

                            if(!$wpdb->last_error) {
                                $data['total'] = intval($total, 10);
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                        case 'list': {
                            $page = intval($jsonData->page, 10);
                            $count = intval($jsonData->itemsperpage, 10);
                            $offset = ($page - 1) * $count;

                            $sql = "SELECT COUNT(*) as total FROM {$tableUsers}";
                            $total = $wpdb->get_var($sql);

                            $sql = $wpdb->prepare("
                                SELECT id, display_name as name
                                FROM {$tableUsers}
                                ORDER BY name DESC
                                LIMIT %d, %d",
                                $offset, $count
                            );
                            $list = $wpdb->get_results($sql, 'ARRAY_A');

                            if(!$wpdb->last_error) {
                                $data['total'] = intval($total, 10);
                                $data['list'] = $list;
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                    }
                } break;
                case 'posttypes': {
                    $data['list'] = array();
                    $result = true;

                    $post_types = get_post_types(['public' => true, '_builtin' => false], 'objects');
                    foreach($post_types as $post_type) {
                        $data['list'][] = array('id' => $post_type->name, 'name' => translate_user_role($post_type->labels->singular_name));
                    }
                } break;
                case 'roles': {
                    $data['list'] = array();
                    $result = true;

                    $roles = wp_roles()->roles;
                    foreach ($roles as $key => $role) {
                        if (array_key_exists('read', $role['capabilities'])) {
                            $data['list'][] = array('id' => $key, 'name' => translate_user_role($role['name']));
                        }
                    }
                } break;
                case 'config': {
                    $data['config'] = $this->get_config_data();
                    $result = true;
                } break;
                case 'token': {
                    $key = 'ifolders_state';
                    $options = App::get_options($key);

                    if($options && array_key_exists('token', $options)) {
                        $data['token'] = $options['token'];
                        $result = true;
                    }
                } break;
            }
        }

        $result ? wp_send_json_success($data) : wp_send_json_error($data);
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function ajax_update_settings_data() {
        $data = null;
        $result = false;

        if(check_ajax_referer('ifolders-ajax-nonce', 'nonce', false)) {
            $inputData = filter_input(INPUT_POST, 'data', FILTER_DEFAULT);
            $jsonData = json_decode($inputData);

            switch($jsonData->target) {
                case 'groups': {
                    global $wpdb;
                    $tableGroups = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_groups';
                    $tableRights = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_rights';
                    $tableAccess = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_access';
                    $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';
                    $tableAttachments = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_attachments';

                    switch($jsonData->action) {
                        case 'insert': {
                            $result = $wpdb->insert(
                                $tableGroups,
                                [
                                    'title' => $jsonData->data->title,
                                    'enabled' => $jsonData->data->enabled,
                                    'shared' => $jsonData->data->shared,
                                    'created' => current_time('mysql', 1),
                                    'modified' => current_time('mysql', 1)
                                ]
                            );

                            if(!$wpdb->last_error) {
                                if ($result) {
                                    $group_id = $wpdb->insert_id;
                                    $rights = $jsonData->data->rights;
                                    foreach ($rights as $right) {
                                        $wpdb->insert(
                                            $tableRights,
                                            [
                                                'group_id' => $group_id,
                                                'user_id' => $right->user_id,
                                                'c' => $right->c,
                                                'v' => $right->v,
                                                'e' => $right->e,
                                                'd' => $right->d,
                                                'a' => $right->a
                                            ]
                                        );
                                    }
                                }
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }

                            if(!$wpdb->last_error) {
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                        case 'update': {
                            $wpdb->update(
                                $tableGroups,
                                [
                                    'title' => $jsonData->data->title,
                                    'enabled' => $jsonData->data->enabled,
                                    'shared' => $jsonData->data->shared,
                                    'modified' => current_time('mysql', 1)
                                ],
                                ['id' => $jsonData->data->id]
                            );

                            if(!$wpdb->last_error) {
                                $group_id = $jsonData->data->id;
                                $rights = $jsonData->data->rights;

                                $sql = $wpdb->prepare("DELETE FROM {$tableRights} WHERE group_id=%d", $group_id);
                                $wpdb->query($sql);

                                foreach($rights as $right) {
                                    $wpdb->insert(
                                        $tableRights,
                                        [
                                            'group_id' => $group_id,
                                            'user_id' => $right->user_id,
                                            'c' => $right->c,
                                            'v' => $right->v,
                                            'e' => $right->e,
                                            'd' => $right->d,
                                            'a' => $right->a
                                        ]
                                    );
                                }
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }

                            if(!$wpdb->last_error) {
                                $result = true;
                            } else {
                                $data['msg'] = $wpdb->last_error;
                            }
                        } break;
                        case 'delete': {
                            switch($jsonData->type) {
                                case 'list': {
                                    $groups = array_values(array_unique($jsonData->list));
                                    $ids = implode(',', array_map('absint', $groups));

                                    $sql = $wpdb->prepare("DELETE FROM {$tableAttachments} WHERE folder_id IN(SELECT id FROM {$tableFolders} WHERE group_id IN (%1s))", $ids);
                                    $wpdb->query($sql);

                                    $sql = $wpdb->prepare("DELETE FROM {$tableFolders} WHERE group_id IN(%1s)", $ids);
                                    $wpdb->query($sql);

                                    $sql = $wpdb->prepare("DELETE FROM {$tableRights} WHERE group_id IN (%1s)", $ids);
                                    $wpdb->query($sql);

                                    $sql = $wpdb->prepare("DELETE FROM {$tableAccess} WHERE group_id IN (%1s)", $ids);
                                    $wpdb->query($sql);

                                    $sql = $wpdb->prepare("DELETE FROM {$tableGroups} WHERE id IN (%1s)", $ids);
                                    $wpdb->query($sql);

                                    if(!$wpdb->last_error) {
                                        $result = true;
                                    } else {
                                        $data['msg'] = $wpdb->last_error;
                                    }
                                } break;
                            }
                        } break;
                    }
                } break;
                case 'foldertypes': {
                    global $wpdb;
                    $tableFolderTypes = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folder_types';
                    $tableAccess = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_access';
                    $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';

                    switch($jsonData->action) {
                        case 'insert': {
                            $sql = $wpdb->prepare("SELECT COUNT(type) FROM {$tableFolderTypes} WHERE type=%s", $jsonData->data->type);
                            $count = intval($wpdb->get_var($sql), 10);

                            if($count > 0) {
                                $data['msg'] = esc_html__('Cannot create: item with the same folder type already exists.', 'ifolders');;
                            } else {
                                $result = $wpdb->insert(
                                    $tableFolderTypes,
                                    [
                                        'type' => $jsonData->data->type,
                                        'title' => $jsonData->data->title,
                                        'enabled' => $jsonData->data->enabled,
                                        'predefined' => false
                                    ]
                                );

                                if(!$wpdb->last_error) {
                                    if($result && $jsonData->data->groups) {
                                        $type = $jsonData->data->type;
                                        $groups = $jsonData->data->groups;

                                        $sql = $wpdb->prepare("DELETE FROM {$tableAccess} WHERE type=%s", $type);
                                        $wpdb->query($sql);

                                        foreach ($groups as $group) {
                                            $wpdb->insert(
                                                $tableAccess,
                                                [
                                                    'type' => $type,
                                                    'group_id' => $group->id
                                                ]
                                            );
                                        }
                                    }
                                } else {
                                    $data['msg'] = $wpdb->last_error;
                                }

                                if(!$wpdb->last_error) {
                                    $result = true;
                                } else {
                                    $data['msg'] = $wpdb->last_error;
                                }
                            }
                        } break;
                        case 'update': {
                            switch($jsonData->type) {
                                case 'state': {
                                    $wpdb->update(
                                        $tableFolderTypes,
                                        ['enabled' => $jsonData->data->enabled],
                                        ['type' => $jsonData->data->type]
                                    );

                                    if(!$wpdb->last_error) {
                                        $result = true;
                                    } else {
                                        $data['msg'] = $wpdb->last_error;
                                    }
                                } break;
                                case 'item': {
                                    $flag = false;
                                    if($jsonData->data->type != $jsonData->data->type_before) {
                                        $sql = $wpdb->prepare("SELECT COUNT(type) FROM {$tableFolderTypes} WHERE type=%s", $jsonData->data->type);
                                        $count = intval($wpdb->get_var($sql), 10);

                                        if($count > 0) {
                                            $data['msg'] = esc_html__('Cannot update: item with the same folder type already exists.', 'ifolders');;
                                        } else {
                                            $sql = "DELETE FROM {$tableAccess} WHERE type NOT IN(SELECT DISTINCT type FROM {$tableFolderTypes})";
                                            $wpdb->query($sql);

                                            $wpdb->update(
                                                $tableFolderTypes,
                                                ['type' => $jsonData->data->type],
                                                ['type' => $jsonData->data->type_before]
                                            );

                                            $wpdb->update(
                                                $tableAccess,
                                                ['type' => $jsonData->data->type],
                                                ['type' => $jsonData->data->type_before]
                                            );

                                            $wpdb->update(
                                                $tableFolders,
                                                ['type' => $jsonData->data->type],
                                                ['type' => $jsonData->data->type_before]
                                            );

                                            if(!$wpdb->last_error) {
                                                $flag = true;
                                            } else {
                                                $data['msg'] = $wpdb->last_error;
                                            }
                                        }
                                    } else {
                                        $flag = true;
                                    }

                                    if($flag) {
                                        $wpdb->update(
                                            $tableFolderTypes,
                                            ['title' => $jsonData->data->title, 'enabled' => $jsonData->data->enabled],
                                            ['type' => $jsonData->data->type]
                                        );

                                        if(!$wpdb->last_error) {
                                            if($jsonData->data->groups) {
                                                $type = $jsonData->data->type;
                                                $groups = $jsonData->data->groups;

                                                $sql = $wpdb->prepare("DELETE FROM {$tableAccess} WHERE type=%s", $type);
                                                $wpdb->query($sql);

                                                foreach ($groups as $group) {
                                                    $wpdb->insert(
                                                        $tableAccess,
                                                        [
                                                            'type' => $type,
                                                            'group_id' => $group->id
                                                        ]
                                                    );
                                                }
                                            } else {
                                                $type = $jsonData->data->type;

                                                $sql = $wpdb->prepare("DELETE FROM {$tableAccess} WHERE type=%s", $type);
                                                $wpdb->query($sql);
                                            }
                                        } else {
                                            $data['msg'] = $wpdb->last_error;
                                        }

                                        if(!$wpdb->last_error) {
                                            $result = true;
                                        } else {
                                            $data['msg'] = $wpdb->last_error;
                                        }
                                    }
                                }
                            }
                        } break;
                        case 'delete': {
                            switch($jsonData->type) {
                                case 'list': {
                                    $types = array_values(array_unique($jsonData->list));
                                    $types = "'" . implode("','", $types) . "'";

                                    $sql = "DELETE FROM {$tableFolderTypes} WHERE NOT predefined AND type IN ({$types})";
                                    $wpdb->query($sql);

                                    $sql = "DELETE FROM {$tableAccess} WHERE type IN(SELECT type FROM {$tableFolderTypes} WHERE NOT predefined AND type IN ({$types}))";
                                    $wpdb->query($sql);

                                    if(!$wpdb->last_error) {
                                        $result = true;
                                    } else {
                                        $data['msg'] = $wpdb->last_error;
                                    }
                                } break;
                            }
                        } break;
                    }
                } break;
                case 'folders': {
                    global $wpdb;
                    $tableFolders = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_folders';
                    $tableAttachments = $wpdb->prefix . IFOLDERS_PLUGIN_DB_TABLE_PREFIX . '_attachments';

                    switch($jsonData->action) {
                        case 'delete': {
                            switch($jsonData->type) {
                                case 'list': {
                                    $folders = [];
                                    foreach($jsonData->list as $id) {
                                        $folders[] = $id;
                                        $this->get_child_folders($id, $folders);
                                    }
                                    $folders = array_values(array_unique($folders));

                                    $ids = implode(',', array_map('absint', $folders));
                                    $sql = $wpdb->prepare("DELETE FROM {$tableAttachments} WHERE folder_id IN(%1s)", $ids);
                                    $result = $wpdb->query($sql);

                                    $sql = $wpdb->prepare("DELETE FROM {$tableFolders} WHERE id IN(%1s)", $ids);
                                    $result = $wpdb->query($sql);

                                    if($result !== false) {
                                        $data['msg'] = esc_html__('The operation completed successfully', 'ifolders');
                                        $result = true;
                                    } else {
                                        $data['msg'] = esc_html__('The operation failed', 'ifolders');
                                        $result = false;
                                    }
                                } break;
                                case 'all': {
                                    $sql = "DELETE FROM {$tableAttachments}";
                                    $result = $wpdb->query($sql);

                                    $sql = "DELETE FROM {$tableFolders}";
                                    $result = $wpdb->query($sql);

                                    if($result !== false) {
                                        $data['msg'] = esc_html__('The operation completed successfully', 'ifolders');
                                        $result = true;
                                    } else {
                                        $data['msg'] = esc_html__('The operation failed', 'ifolders');
                                        $result = false;
                                    }
                                } break;
                            }
                        } break;
                    }
                } break;
                case 'config': {
                    $config = $jsonData->config;
                    $result = $this->set_config_data($config);
                } break;
                case 'dismiss-first-use-notification': {
                    $result = update_option('ifolders_dismiss_first_use_notification', true, false);
                } break;
                case 'token': {
                    $key = 'ifolders_state';
                    $options = App::get_options($key);

                    if($options) {
                        switch($jsonData->action) {
                            case 'insert': {
                                $options = array_merge($options, ['token' => $jsonData->token]);
                                App::set_options($key, $options);
                                $result = true;
                            } break;
                            case 'delete': {
                                unset($options['token']);
                                App::set_options($key, $options);
                                $result = true;
                            } break;
                        }
                    }
                } break;
            }
        }

        $result ? wp_send_json_success($data) : wp_send_json_error($data);
        wp_die(); // this is required to terminate immediately and return a proper response
    }
}