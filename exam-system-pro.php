<?php
/**
 * Plugin Name: Exam System Pro
 * Plugin URI: https://example.com/exam-system-pro
 * Description: School ERP plugin providing exams, results, reports and admin tools.
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: esp
 */

defined('ABSPATH') || exit;

if (!defined('ESP_PLUGIN_FILE')) {
    define('ESP_PLUGIN_FILE', __FILE__);
}

if (!defined('ESP_PATH')) {
    define('ESP_PATH', plugin_dir_path(ESP_PLUGIN_FILE));
}

if (!defined('ESP_TEMPLATE')) {
    define('ESP_TEMPLATE', ESP_PATH . 'templates/');
}

if (!defined('ESP_URL')) {
    define('ESP_URL', plugin_dir_url(ESP_PLUGIN_FILE));
}

if (!defined('ESP_VERSION')) {
    define('ESP_VERSION', '1.0.0');
}

if (!defined('ESP_DB_VERSION')) {
    define('ESP_DB_VERSION', '2.0.1');
}

// Register autoloader
require_once ESP_PATH . 'includes/Core/Autoloader_new_version.php';
ESP_Autoloader::register();

// Load core helper functions
if (file_exists(ESP_PATH . 'includes/Helpers/security.php')) {
    require_once ESP_PATH . 'includes/Helpers/security.php';
}
if (file_exists(ESP_PATH . 'includes/Helpers/helpers.php')) {
    require_once ESP_PATH . 'includes/Helpers/helpers.php';
}

add_action('init', ['ESP_CampusBootstrap', 'init'], 0);

// Register core hooks. Use class_exists with autoload to trigger the autoloader when needed.
$hooks = [
    'ESP_ActivationHook',
    'ESP_DeactivationHook',
    'ESP_PluginLoadedHook',
    'ESP_InitHook',
    'ESP_InitSessionHook',
    'ESP_LocalizationHook',
    'ESP_AssetsHook',
    'ESP_AjaxHook',
    'ESP_ShortcodeHook',
    'ESP_AdminHook',
    'ESP_AdminHeadHook',
    'ESP_AdminFooterHook',
    'ESP_AdminNoticeHook',
    'ESP_TemplateRedirectHook',
    'ESP_ShutdownHook',
    'ESP_UpgradeHook',
    'ESP_CronHook',
    'ESP_CapabilityHook',
    'ESP_SavePostHook',
    'ESP_UserHook',
    'ESP_LoginHook',
    'ESP_LogoutHook',
    'ESP_DeleteUserHook',
    'ESP_ProfileHook',
];

foreach ($hooks as $hookClass) {
    if (class_exists($hookClass, true)) {
        $hookClass::register();
    }
}

// The hook classes are optional in older installs, so run the schema check
// directly as well. dbDelta is non-destructive and creates any missing tables.
add_action('plugins_loaded', function() {
    if (class_exists('ESP_Migration', true)) {
        ESP_Migration::run();
    }
});

// Admin-post requests need their callbacks registered as soon as the plugin is
// loaded; registering only during admin_init can miss a submission on some
// WordPress setups.
if (class_exists('ESP_AdminRecordHandler', true)) {
    ESP_AdminRecordHandler::register();
}

// Register one menu implementation. ESP_Menu is a legacy implementation whose
// callbacks reference templates/constants that are no longer part of the plugin.
add_action('admin_menu', function() {
    if (class_exists('ESP_AdminMenu', true)) {
        ESP_AdminMenu::menus();
    }
});

do_action('esp_bootstrapped');
