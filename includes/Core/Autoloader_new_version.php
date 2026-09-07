<?php
defined('ABSPATH') || exit;
class ESP_Autoloader {
    public static function register(): void { spl_autoload_register([self::class, 'load']); }
    public static function load(string $class): void {
        if (strpos($class, 'ESP_') !== 0) return;
        $special = [
            'ESP_Database' => ESP_PATH . 'includes/Database/Database_new_version.php',
            'ESP_CampusContext' => ESP_PATH . 'includes/Core/CampusContext_new_version.php',
            'ESP_CampusBootstrap' => ESP_PATH . 'includes/Core/CampusBootstrap_new_version.php',
            'ESP_SessionContext' => ESP_PATH . 'includes/Core/SessionContext_new_version.php',
            'ESP_AdminHeadHook' => ESP_PATH . 'includes/Hooks/AdminHeadHook_new_version.php',
            'ESP_ProfileHook' => ESP_PATH . 'includes/Hooks/ProfileHook_new_version.php',
            'ESP_Ajax_Marks' => ESP_PATH . 'includes/Ajax/AjaxMarks_new_version.php',
            'ESP_Ajax_Resubmit' => ESP_PATH . 'includes/Ajax/AjaxResubmit_new_version.php',
        ];
        $files = isset($special[$class]) ? [$special[$class]] : [];
        $name = substr($class, 4);
        $files[] = ESP_PATH . 'includes/' . str_replace('_', DIRECTORY_SEPARATOR, $name) . '.php';

        // Preserve the existing plugin's directory conventions. Several
        // active classes use names such as ESP_AdminMenu while living in
        // includes/Admin/AdminMenu.php.
        $directories = [
            'Core', 'Hooks', 'Assets', 'Controllers', 'Repositories',
            'Services', 'Helpers', 'Admin', 'Admin/Widgets', 'Admin/ListTables',
            'Menu', 'Ajax', 'Database', 'Traits', 'Models', 'Contracts',
            'Reports', 'Providers', 'Observers', 'Policies', 'Support',
            'Notifications', 'Security', 'Installer', 'Listeners', 'Logs',
            'PDF', 'ResultEngine', 'Results', 'Settings', 'System', 'Events',
        ];
        foreach ($directories as $directory) {
            $files[] = ESP_PATH . 'includes/' . $directory . '/' . $name . '.php';
        }

        // Historical AJAX filenames omit the underscore in the filename.
        if (strpos($name, 'Ajax_') === 0) {
            $files[] = ESP_PATH . 'includes/Ajax/' . str_replace('Ajax_', 'Ajax', $name) . '.php';
        }
        foreach ($files as $file) {
            if (is_readable($file)) { require_once $file; if (class_exists($class, false)) return; }
        }
    }
}
