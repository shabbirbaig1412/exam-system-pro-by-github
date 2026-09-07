<?php
defined('ABSPATH') || exit;
class ESP_AdminPromotionPage {
    public static function render(): void {
        ESP_Capability::admin(); global $wpdb;
        $campus=ESP_CampusContext::id(); $session=ESP_SessionContext::id();
        $students=(array)$wpdb->get_results($wpdb->prepare("SELECT st.id,st.student_name,st.roll_no,c.class_name FROM {$wpdb->prefix}esp_students st LEFT JOIN {$wpdb->prefix}esp_classes c ON c.id=st.class_id WHERE st.campus_id=%d AND st.session_id=%d ORDER BY st.roll_no,st.student_name",$campus,$session),ARRAY_A);
        $classes=(new ESP_ClassRepository())->all(); $sessions=(new ESP_SessionRepository())->all();
        ESP_View::render('admin/promotion',compact('students','classes','sessions'));
    }
}
