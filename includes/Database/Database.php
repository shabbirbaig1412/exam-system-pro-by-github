<?php

defined('ABSPATH') || exit;

class ESP_Database {

    public static function table(string $table): string {
        global $wpdb;
        $name = sanitize_key($table);
        $prefix = sanitize_key($wpdb->prefix);
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

        require_once ABSPATH.'wp-admin/includes/upgrade.php';

        $charset = $wpdb->get_charset_collate();

        $tables = [];

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_sessions(
            id BIGINT UNSIGNED AUTO_INCREMENT,
            session_name VARCHAR(100) NOT NULL,
            start_date DATE,
            end_date DATE,
            is_active TINYINT DEFAULT 0,
            created_at DATETIME,
            updated_at DATETIME,
            PRIMARY KEY(id)
        ) {$charset};";

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_classes(
            id BIGINT UNSIGNED AUTO_INCREMENT,
            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
            class_name VARCHAR(100) NOT NULL,
            sort_order INT DEFAULT 0,
            created_at DATETIME,
            updated_at DATETIME,
            PRIMARY KEY(id)
        ) {$charset};";

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_teachers(
            id BIGINT UNSIGNED AUTO_INCREMENT,
            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
            teacher_name VARCHAR(150),
            employee_no VARCHAR(50),
            designation VARCHAR(100),
            mobile VARCHAR(30),
            email VARCHAR(150),
            status TINYINT DEFAULT 1,
            created_at DATETIME,
            updated_at DATETIME,
            PRIMARY KEY(id)
        ) {$charset};";

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_students(
            id BIGINT UNSIGNED AUTO_INCREMENT,
            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
            admission_no VARCHAR(50),
            roll_no VARCHAR(50),
            student_name VARCHAR(150),
            father_name VARCHAR(150),
            gender VARCHAR(20),
            class_id BIGINT,
            session_id BIGINT,
            created_at DATETIME,
            updated_at DATETIME,
            PRIMARY KEY(id)
        ) {$charset};";

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_subjects(
            id BIGINT UNSIGNED AUTO_INCREMENT,
            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
            subject_name VARCHAR(150),
            subject_code VARCHAR(50),
            total_marks DECIMAL(8,2),
            passing_marks DECIMAL(8,2),
            created_at DATETIME,
            updated_at DATETIME,
            PRIMARY KEY(id)
        ) {$charset};";

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_allocations(
            id BIGINT UNSIGNED AUTO_INCREMENT,
            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
            class_id BIGINT,
            subject_id BIGINT,
            teacher_id BIGINT,
            created_at DATETIME,
            PRIMARY KEY(id)
        ) {$charset};";

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_exams(
            id BIGINT UNSIGNED AUTO_INCREMENT,
            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
            exam_name VARCHAR(150),
            status TINYINT NOT NULL DEFAULT 1,
            class_id BIGINT,
            session_id BIGINT,
            exam_date DATE,
            created_at DATETIME,
            updated_at DATETIME,
            PRIMARY KEY(id)
        ) {$charset};";

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_marks(
            id BIGINT UNSIGNED AUTO_INCREMENT,
            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
            exam_id BIGINT,
            student_id BIGINT,
            subject_id BIGINT,
            obtained_marks DECIMAL(8,2),
            remarks TEXT,
            created_at DATETIME,
            updated_at DATETIME,
            PRIMARY KEY(id)
        ) {$charset};";

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_exam_schedules(
            id BIGINT UNSIGNED AUTO_INCREMENT,
            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
            exam_id BIGINT UNSIGNED NOT NULL,
            class_id BIGINT UNSIGNED NOT NULL,
            exam_date DATE NULL,
            start_time TIME NULL,
            end_time TIME NULL,
            remarks VARCHAR(255) NULL,
            status TINYINT NOT NULL DEFAULT 1,
            created_at DATETIME,
            updated_at DATETIME,
            PRIMARY KEY(id)
        ) {$charset};";

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_results(
            id BIGINT UNSIGNED AUTO_INCREMENT,
            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
            exam_id BIGINT,
            student_id BIGINT,
            total_marks DECIMAL(8,2),
            obtained_marks DECIMAL(8,2),
            percentage DECIMAL(8,2),
            grade VARCHAR(10),
            remarks VARCHAR(100),
            status VARCHAR(20),
            position INT DEFAULT 0,
            PRIMARY KEY(id)
        ) {$charset};";

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_settings(
            setting_key VARCHAR(100) PRIMARY KEY,
            setting_value LONGTEXT
        ) {$charset};";

        $tables[] = "CREATE TABLE {$wpdb->prefix}esp_logs(
            id BIGINT UNSIGNED AUTO_INCREMENT,
            user_id BIGINT,
            action VARCHAR(255),
            created_at DATETIME,
            PRIMARY KEY(id)
        ) {$charset};";

        foreach($tables as $sql){

            dbDelta($sql);

        }

        self::ensure_campus_columns();

    }

    /**
     * Add campus ownership to tables created by older plugin versions.
     * dbDelta is normally sufficient, but this explicit check also repairs
     * installations whose database version was already marked as current.
     */
    public static function ensure_campus_columns(): void {

        global $wpdb;

        foreach ([
            'classes',
            'teachers',
            'students',
            'subjects',
            'allocations',
            'exams',
            'exam_schedules',
            'marks',
            'results',
        ] as $table) {

            $fullTable = $wpdb->prefix . 'esp_' . $table;

            $column = $wpdb->get_var(

                $wpdb->prepare(

                    "SHOW COLUMNS FROM {$fullTable} LIKE %s",

                    'campus_id'

                )

            );

            if (!$column) {

                $wpdb->query(

                    "ALTER TABLE {$fullTable} ADD campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0"

                );

            }

        }

    }

}
