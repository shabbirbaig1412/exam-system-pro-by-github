<?php

defined('ABSPATH') || exit;

/**
 * Single non-destructive schema authority for Exam System Pro.
 * dbDelta adds missing columns/indexes without removing existing data.
 */
class ESP_Database {

    public static function table(string $table): string {
        global $wpdb;
        $name = sanitize_key($table);
        $prefix = sanitize_key($wpdb->prefix);

        // Accept both logical names (exams) and already-qualified names
        // without ever applying the WordPress prefix twice.
        if (strpos($name, $prefix) === 0) {
            $name = substr($name, strlen($prefix));
        }
        if (strpos($name, 'esp_') === 0) {
            $name = substr($name, 4);
        }

        return $wpdb->prefix . 'esp_' . $name;
    }

    public static function db() {
        global $wpdb;
        return $wpdb;
    }

    public static function install(): void {
        global $wpdb;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $charset = $wpdb->get_charset_collate();
        $p = $wpdb->prefix . 'esp_';
        $tables = [
            "CREATE TABLE {$p}campuses (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, name VARCHAR(150) NOT NULL, code VARCHAR(50) NOT NULL, address TEXT, phone VARCHAR(40), email VARCHAR(150), status TINYINT NOT NULL DEFAULT 1, created_at DATETIME, updated_at DATETIME, PRIMARY KEY (id), UNIQUE KEY code (code)) {$charset};",
            "CREATE TABLE {$p}sessions (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, session_name VARCHAR(100) NOT NULL, start_date DATE NULL, end_date DATE NULL, is_active TINYINT NOT NULL DEFAULT 0, created_at DATETIME, updated_at DATETIME, PRIMARY KEY (id), UNIQUE KEY session_name (session_name)) {$charset};",
            "CREATE TABLE {$p}classes (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, class_name VARCHAR(120) NOT NULL, sort_order INT NOT NULL DEFAULT 0, status TINYINT NOT NULL DEFAULT 1, created_at DATETIME, updated_at DATETIME, PRIMARY KEY (id), KEY campus_id (campus_id)) {$charset};",
            "CREATE TABLE {$p}teachers (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, wp_user_id BIGINT UNSIGNED NOT NULL DEFAULT 0, teacher_name VARCHAR(150) NOT NULL, employee_no VARCHAR(50), designation VARCHAR(120), mobile VARCHAR(40), email VARCHAR(150), status TINYINT NOT NULL DEFAULT 1, created_at DATETIME, updated_at DATETIME, PRIMARY KEY (id), KEY campus_user (campus_id, wp_user_id)) {$charset};",
            "CREATE TABLE {$p}students (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, admission_no VARCHAR(60), roll_no VARCHAR(30), student_name VARCHAR(150) NOT NULL, father_name VARCHAR(150), gender VARCHAR(20), class_id BIGINT UNSIGNED NOT NULL DEFAULT 0, session_id BIGINT UNSIGNED NOT NULL DEFAULT 0, mobile VARCHAR(40), address TEXT, status TINYINT NOT NULL DEFAULT 1, created_at DATETIME, updated_at DATETIME, PRIMARY KEY (id), KEY campus_session (campus_id, session_id), KEY class_id (class_id)) {$charset};",
            "CREATE TABLE {$p}subjects (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, subject_name VARCHAR(150) NOT NULL, subject_code VARCHAR(50), total_marks DECIMAL(10,2) NOT NULL DEFAULT 100, passing_marks DECIMAL(10,2) NOT NULL DEFAULT 40, status TINYINT NOT NULL DEFAULT 1, created_at DATETIME, updated_at DATETIME, PRIMARY KEY (id), KEY campus_id (campus_id)) {$charset};",
            "CREATE TABLE {$p}allocations (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, session_id BIGINT UNSIGNED NOT NULL DEFAULT 0, class_id BIGINT UNSIGNED NOT NULL, subject_id BIGINT UNSIGNED NOT NULL, teacher_id BIGINT UNSIGNED NOT NULL, created_at DATETIME, updated_at DATETIME, PRIMARY KEY (id), UNIQUE KEY allocation (campus_id, session_id, class_id, subject_id, teacher_id), KEY teacher_scope (teacher_id, campus_id, session_id)) {$charset};",
            "CREATE TABLE {$p}exams (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, exam_name VARCHAR(150) NOT NULL, status TINYINT NOT NULL DEFAULT 1, created_at DATETIME, updated_at DATETIME, PRIMARY KEY (id), KEY campus_id (campus_id)) {$charset};",
            "CREATE TABLE {$p}exam_schedules (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, exam_id BIGINT UNSIGNED NOT NULL, class_id BIGINT UNSIGNED NOT NULL, exam_date DATE NULL, start_time TIME NULL, end_time TIME NULL, remarks VARCHAR(255) NULL, status TINYINT NOT NULL DEFAULT 1, created_at DATETIME, updated_at DATETIME, PRIMARY KEY (id), UNIQUE KEY exam_class (campus_id, exam_id, class_id), KEY exam_id (exam_id), KEY class_id (class_id), KEY campus_id (campus_id)) {$charset};",
            "CREATE TABLE {$p}marks (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, exam_id BIGINT UNSIGNED NOT NULL, student_id BIGINT UNSIGNED NOT NULL, subject_id BIGINT UNSIGNED NOT NULL, obtained_marks DECIMAL(10,2) NOT NULL DEFAULT 0, remarks VARCHAR(255), submitted_by BIGINT UNSIGNED NOT NULL DEFAULT 0, submitted_at DATETIME NULL, locked_at DATETIME NULL, created_at DATETIME, updated_at DATETIME, PRIMARY KEY (id), UNIQUE KEY mark_scope (campus_id, exam_id, student_id, subject_id), KEY exam_scope (exam_id, campus_id)) {$charset};",
            "CREATE TABLE {$p}results (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, exam_id BIGINT UNSIGNED NOT NULL, student_id BIGINT UNSIGNED NOT NULL, total_marks DECIMAL(10,2), obtained_marks DECIMAL(10,2), percentage DECIMAL(6,2), grade VARCHAR(20), remarks VARCHAR(100), status VARCHAR(20), position INT NOT NULL DEFAULT 0, published TINYINT NOT NULL DEFAULT 0, published_at DATETIME NULL, created_at DATETIME, updated_at DATETIME, PRIMARY KEY (id), UNIQUE KEY result_scope (campus_id, exam_id, student_id), KEY exam_scope (exam_id, campus_id)) {$charset};",
            "CREATE TABLE {$p}settings (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, setting_key VARCHAR(150) NOT NULL, setting_value LONGTEXT, PRIMARY KEY (id), UNIQUE KEY setting_scope (campus_id, setting_key)) {$charset};",
            "CREATE TABLE {$p}logs (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, log_level VARCHAR(20), message LONGTEXT, user_id BIGINT UNSIGNED NOT NULL DEFAULT 0, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, ip_address VARCHAR(45), created_at DATETIME, PRIMARY KEY (id), KEY created_at (created_at), KEY campus_id (campus_id)) {$charset};",
            "CREATE TABLE {$p}mark_resubmits (id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0, session_id BIGINT UNSIGNED NOT NULL DEFAULT 0, exam_id BIGINT UNSIGNED NOT NULL, class_id BIGINT UNSIGNED NOT NULL DEFAULT 0, subject_id BIGINT UNSIGNED NOT NULL DEFAULT 0, teacher_id BIGINT UNSIGNED NOT NULL, granted_by BIGINT UNSIGNED NOT NULL DEFAULT 0, used_at DATETIME NULL, created_at DATETIME, PRIMARY KEY (id), UNIQUE KEY grant_scope (campus_id, exam_id, class_id, subject_id, teacher_id), KEY teacher_scope (teacher_id, campus_id, exam_id)) {$charset};",
        ];
        foreach ($tables as $sql) {
            dbDelta($sql);
        }
        self::repair_columns();
        update_option('esp_db_version', ESP_DB_VERSION);
    }

    /** Compatibility repair hook used by the existing upgrade runner. */
    public static function ensure_campus_columns(): void {
        self::ensure_schema();
    }

    /** Repair every column used by the active admin forms and services. */
    public static function ensure_schema(): void {
        global $wpdb;
        foreach (['campuses','sessions','classes','teachers','students','subjects','allocations','exams','exam_schedules','marks','results','settings','logs','mark_resubmits'] as $name) {
            if (!$wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', self::table($name)))) {
                // Older installs may have marked the database current without
                // ever creating all required tables. dbDelta creates them safely.
                self::install();
                return;
            }
        }
        self::repair_columns();
    }

    private static function repair_columns(): void {
        global $wpdb;
        $columns = [
            'campuses' => ['name'=>'VARCHAR(150) NULL','code'=>'VARCHAR(50) NULL','address'=>'TEXT NULL','phone'=>'VARCHAR(40) NULL','email'=>'VARCHAR(150) NULL','status'=>'TINYINT NOT NULL DEFAULT 1','created_at'=>'DATETIME NULL','updated_at'=>'DATETIME NULL'],
            'sessions' => ['session_name'=>'VARCHAR(100) NULL','start_date'=>'DATE NULL','end_date'=>'DATE NULL','is_active'=>'TINYINT NOT NULL DEFAULT 0','created_at'=>'DATETIME NULL','updated_at'=>'DATETIME NULL'],
            'classes' => ['campus_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','class_name'=>'VARCHAR(120) NULL','sort_order'=>'INT NOT NULL DEFAULT 0','status'=>'TINYINT NOT NULL DEFAULT 1','created_at'=>'DATETIME NULL','updated_at'=>'DATETIME NULL'],
            'teachers' => ['campus_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','wp_user_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','teacher_name'=>'VARCHAR(150) NULL','employee_no'=>'VARCHAR(50) NULL','designation'=>'VARCHAR(120) NULL','mobile'=>'VARCHAR(40) NULL','email'=>'VARCHAR(150) NULL','status'=>'TINYINT NOT NULL DEFAULT 1','created_at'=>'DATETIME NULL','updated_at'=>'DATETIME NULL'],
            'students' => ['campus_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','admission_no'=>'VARCHAR(60) NULL','roll_no'=>'VARCHAR(30) NULL','student_name'=>'VARCHAR(150) NULL','father_name'=>'VARCHAR(150) NULL','gender'=>'VARCHAR(20) NULL','class_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','session_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','mobile'=>'VARCHAR(40) NULL','address'=>'TEXT NULL','status'=>'TINYINT NOT NULL DEFAULT 1','created_at'=>'DATETIME NULL','updated_at'=>'DATETIME NULL'],
            'subjects' => ['campus_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','subject_name'=>'VARCHAR(150) NULL','subject_code'=>'VARCHAR(50) NULL','total_marks'=>'DECIMAL(10,2) NOT NULL DEFAULT 100','passing_marks'=>'DECIMAL(10,2) NOT NULL DEFAULT 40','status'=>'TINYINT NOT NULL DEFAULT 1','created_at'=>'DATETIME NULL','updated_at'=>'DATETIME NULL'],
            'allocations' => ['campus_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','session_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','class_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','subject_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','teacher_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','created_at'=>'DATETIME NULL','updated_at'=>'DATETIME NULL'],
            'exams' => ['campus_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','exam_name'=>'VARCHAR(150) NULL','status'=>'TINYINT NOT NULL DEFAULT 1','created_at'=>'DATETIME NULL','updated_at'=>'DATETIME NULL'],
            'exam_schedules' => ['campus_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','exam_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','class_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','exam_date'=>'DATE NULL','start_time'=>'TIME NULL','end_time'=>'TIME NULL','remarks'=>'VARCHAR(255) NULL','status'=>'TINYINT NOT NULL DEFAULT 1','created_at'=>'DATETIME NULL','updated_at'=>'DATETIME NULL'],
            'marks' => ['campus_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','exam_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','student_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','subject_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','obtained_marks'=>'DECIMAL(10,2) NOT NULL DEFAULT 0','remarks'=>'VARCHAR(255) NULL','submitted_by'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','submitted_at'=>'DATETIME NULL','locked_at'=>'DATETIME NULL','created_at'=>'DATETIME NULL','updated_at'=>'DATETIME NULL'],
            'results' => ['campus_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','exam_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','student_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','total_marks'=>'DECIMAL(10,2) NULL','obtained_marks'=>'DECIMAL(10,2) NULL','percentage'=>'DECIMAL(6,2) NULL','grade'=>'VARCHAR(20) NULL','remarks'=>'VARCHAR(100) NULL','status'=>'VARCHAR(20) NULL','position'=>'INT NOT NULL DEFAULT 0','published'=>'TINYINT NOT NULL DEFAULT 0','published_at'=>'DATETIME NULL','created_at'=>'DATETIME NULL','updated_at'=>'DATETIME NULL'],
            'settings' => ['setting_key'=>'VARCHAR(150) NULL','setting_value'=>'LONGTEXT NULL'],
            'logs' => ['log_level'=>'VARCHAR(20) NULL','message'=>'LONGTEXT NULL','user_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','campus_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','ip_address'=>'VARCHAR(45) NULL','created_at'=>'DATETIME NULL'],
            'mark_resubmits' => ['campus_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','session_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','exam_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','class_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','subject_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','teacher_id'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','granted_by'=>'BIGINT UNSIGNED NOT NULL DEFAULT 0','used_at'=>'DATETIME NULL','created_at'=>'DATETIME NULL'],
        ];
        foreach ($columns as $name => $required) {
            $table = self::table($name);
            foreach ($required as $column => $definition) {
                if (!$wpdb->get_var($wpdb->prepare("SHOW COLUMNS FROM {$table} LIKE %s", $column))) {
                    $wpdb->query("ALTER TABLE {$table} ADD {$column} {$definition}");
                }
            }
        }

        $schedule_table = self::table('exam_schedules');
        $index_columns = $wpdb->get_col("SHOW INDEX FROM {$schedule_table} WHERE Key_name = 'exam_class'", 4);
        if ($index_columns !== ['campus_id', 'exam_id', 'class_id']) {
            if ($index_columns) {
                $wpdb->query("ALTER TABLE {$schedule_table} DROP INDEX exam_class");
            }
            $wpdb->query("ALTER TABLE {$schedule_table} ADD UNIQUE KEY exam_class (campus_id, exam_id, class_id)");
        }
    }
}
