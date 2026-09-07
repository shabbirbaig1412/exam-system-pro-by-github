<?php defined('ABSPATH') || exit; ?>

<div class="wrap">

<h1 class="wp-heading-inline">

Students

</h1>

<button
class="button button-primary"
id="esp-new-student">

Add Student

</button>

<hr>

<?php 
$student_id = absint($_GET['edit_id'] ?? 0);
$student = [];
if ($student_id) {
    global $wpdb;
    $student = (array) $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}esp_students WHERE id=%d AND campus_id=%d",
        $student_id,
        ESP_CampusContext::id()
    ));
}
?>

<form id="esp-record-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="esp-record-form esp-card">
    <h2><?php echo esc_html($student_id ? __('Edit record', 'exam-system-pro') : __('Add record', 'exam-system-pro')); ?></h2>
    <input type="hidden" name="action" value="esp_save_record">
    <input type="hidden" name="entity" value="students">
    <input type="hidden" name="id" value="<?php echo esc_attr($student_id); ?>">
    <?php wp_nonce_field('esp_admin_record'); ?>
    
    <p>
        <label for="esp-students-student-name"><strong><?php echo esc_html(__('Student name', 'exam-system-pro')); ?></strong> <span aria-hidden="true" class="esp-required">*</span></label><br>
        <input id="esp-students-student-name" class="regular-text" type="text" name="student_name" value="<?php echo esc_attr($student['student_name'] ?? ''); ?>" required>
    </p>

    <p>
        <label for="esp-students-roll-no"><strong><?php echo esc_html(__('Roll number', 'exam-system-pro')); ?></strong></label><br>
        <input id="esp-students-roll-no" class="regular-text" type="text" name="roll_no" value="<?php echo esc_attr($student['roll_no'] ?? ''); ?>">
    </p>

    <p>
        <label for="esp-students-father-name"><strong><?php echo esc_html(__('Father name', 'exam-system-pro')); ?></strong></label><br>
        <input id="esp-students-father-name" class="regular-text" type="text" name="father_name" value="<?php echo esc_attr($student['father_name'] ?? ''); ?>">
    </p>

    <p>
        <strong><?php echo esc_html(__('Gender', 'exam-system-pro')); ?></strong><br>
        <label style="display:inline-block;margin-right:20px;">
            <input type="radio" name="gender" value="Male" <?php checked($student['gender'] ?? '', 'Male'); ?>> 
            <?php echo esc_html(__('Male', 'exam-system-pro')); ?>
        </label>
        <label style="display:inline-block;">
            <input type="radio" name="gender" value="Female" <?php checked($student['gender'] ?? '', 'Female'); ?>> 
            <?php echo esc_html(__('Female', 'exam-system-pro')); ?>
        </label>
    </p>

    <p>
        <label for="esp-students-class-id"><strong><?php echo esc_html(__('Class', 'exam-system-pro')); ?></strong> <span aria-hidden="true" class="esp-required">*</span></label><br>
        <select id="esp-students-class-id" name="class_id" required>
            <option value=""><?php esc_html_e('Select a class', 'exam-system-pro'); ?></option>
            <?php 
            global $wpdb;
            $classes = $wpdb->get_results($wpdb->prepare(
                "SELECT id, class_name FROM {$wpdb->prefix}esp_classes WHERE campus_id=%d AND status=1 ORDER BY sort_order, class_name",
                ESP_CampusContext::id()
            ), ARRAY_A);
            foreach ($classes as $class):
                ?>
                <option value="<?php echo esc_attr($class['id']); ?>" <?php selected($student['class_id'] ?? '', $class['id']); ?>>
                    <?php echo esc_html($class['class_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label for="esp-students-mobile"><strong><?php echo esc_html(__('Mobile', 'exam-system-pro')); ?></strong></label><br>
        <input id="esp-students-mobile" class="regular-text" type="text" name="mobile" value="<?php echo esc_attr($student['mobile'] ?? ''); ?>">
    </p>

    <p>
        <label for="esp-students-address"><strong><?php echo esc_html(__('Address', 'exam-system-pro')); ?></strong></label><br>
        <textarea id="esp-students-address" class="large-text" rows="3" name="address"><?php echo esc_textarea($student['address'] ?? ''); ?></textarea>
    </p>

    <p>
        <label for="esp-students-status"><strong><?php echo esc_html(__('Active', 'exam-system-pro')); ?></strong></label><br>
        <input id="esp-students-status" type="number" name="status" value="<?php echo esc_attr($student['status'] ?? 1); ?>" min="0" max="1">
    </p>

    <?php submit_button($student_id ? __('Update record', 'exam-system-pro') : __('Save record', 'exam-system-pro'), 'primary', 'submit', false); ?>
    <?php if ($student_id): ?>
        <a class="button" href="<?php echo esc_url(remove_query_arg('edit_id')); ?>"><?php esc_html_e('Cancel edit', 'exam-system-pro'); ?></a>
    <?php endif; ?>
</form>

<div class="esp-saved-records">
<?php ESP_AdminRecordForm::records_toolbar('students', __('Saved students', 'exam-system-pro')); ?>
<?php ESP_AdminRecordForm::saved_table('students', (new ESP_StudentRepository())->all(), ['roll_no' => __('Roll no.', 'exam-system-pro'), 'student_name' => __('Student', 'exam-system-pro'), 'class_id' => __('Class ID', 'exam-system-pro'), 'gender' => __('Gender', 'exam-system-pro')]); ?>
</div>

</div>

