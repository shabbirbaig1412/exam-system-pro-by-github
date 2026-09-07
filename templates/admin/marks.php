<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin-wrap esp-marks-page">
    <div class="esp-header-title">
        <h1 class="wp-heading-inline">
            <span class="dashicons dashicons-edit-page" style="font-size:28px;width:28px;height:28px;vertical-align:middle;margin-right:6px;color:#2271b1;"></span>
            <?php esc_html_e('Marks Entry & Grading', 'exam-system-pro'); ?>
        </h1>
        <p class="description">
            <?php esc_html_e('Record, validate, and lock exam marks for students. Keyboard navigation enabled (Enter to jump to next row, Ctrl+S to save).', 'exam-system-pro'); ?>
        </p>
    </div>

    <?php if (empty($has_teacher_profile)): ?>
        <div class="notice notice-warning inline" style="margin:15px 0;">
            <p><strong><?php esc_html_e('No Teacher Profile Found:', 'exam-system-pro'); ?></strong> <?php esc_html_e('Your WordPress user account is not linked to an active teacher in the current campus.', 'exam-system-pro'); ?></p>
        </div>
    <?php endif; ?>

    <!-- Feedback Notice Box -->
    <div id="esp_marks_notice" class="notice" style="display:none;margin:15px 0 10px 0;"><p></p></div>

    <!-- Filters & Selectors Card -->
    <div class="esp-card esp-marks-selector-card" style="background:#fff;padding:16px 20px;border-radius:6px;border:1px solid #c3c4c7;box-shadow:0 1px 3px rgba(0,0,0,0.04);margin-bottom:15px;">
        <div style="display:flex;align-items:flex-end;gap:15px;flex-wrap:wrap;">
            
            <!-- Exam Selector -->
            <div class="esp-control-group" style="flex:1;min-width:200px;">
                <label for="esp_exam" style="display:block;font-weight:600;margin-bottom:5px;">
                    <?php esc_html_e('1. Select Exam', 'exam-system-pro'); ?> <span class="esp-required" style="color:#d63638;">*</span>
                </label>
                <select id="esp_exam" style="width:100%;max-width:100%;">
                    <option value=""><?php esc_html_e('-- Choose Exam --', 'exam-system-pro'); ?></option>
                    <?php foreach ($exams as $exam): ?>
                        <option value="<?php echo esc_attr($exam['id']); ?>">
                            <?php echo esc_html($exam['exam_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Class Selector -->
            <div class="esp-control-group" style="flex:1;min-width:180px;">
                <label for="esp_class" style="display:block;font-weight:600;margin-bottom:5px;">
                    <?php esc_html_e('2. Class', 'exam-system-pro'); ?> <span class="esp-required" style="color:#d63638;">*</span>
                </label>
                <select id="esp_class" style="width:100%;max-width:100%;" disabled>
                    <option value=""><?php esc_html_e('-- Choose Class --', 'exam-system-pro'); ?></option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo esc_attr($class['id']); ?>" data-exam-ids="<?php
                            $exam_ids = [];
                            foreach ($schedules as $schedule) {
                                if ((int) $schedule['class_id'] === (int) $class['id']) {
                                    $exam_ids[] = (int) $schedule['exam_id'];
                                }
                            }
                            echo esc_attr(wp_json_encode(array_values(array_unique($exam_ids))));
                        ?>">
                            <?php echo esc_html($class['class_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Subject Selector -->
            <div class="esp-control-group" style="flex:1;min-width:180px;">
                <label for="esp_subject" style="display:block;font-weight:600;margin-bottom:5px;">
                    <?php esc_html_e('3. Subject', 'exam-system-pro'); ?> <span class="esp-required" style="color:#d63638;">*</span>
                </label>
                <select id="esp_subject" style="width:100%;max-width:100%;">
                    <option value=""><?php esc_html_e('-- Choose Subject --', 'exam-system-pro'); ?></option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?php echo esc_attr($subject['id']); ?>" 
                                data-max="<?php echo esc_attr($subject['total_marks'] ?? 100); ?>"
                                data-passing="<?php echo esc_attr($subject['passing_marks'] ?? 40); ?>">
                            <?php echo esc_html($subject['subject_name']); ?> (Max: <?php echo esc_html((float)($subject['total_marks'] ?? 100)); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Action: Load Marks -->
            <div class="esp-control-group" style="margin-bottom:1px;">
                <button type="button" class="button button-primary button-large" id="esp_load_marks" style="display:inline-flex;align-items:center;gap:5px;">
                    <span class="dashicons dashicons-update" style="font-size:18px;width:18px;height:18px;line-height:18px;"></span>
                    <span class="esp-btn-text"><?php esc_html_e('Load Marks Sheet', 'exam-system-pro'); ?></span>
                </button>
            </div>

        </div>
    </div>

    <!-- Active Sheet Toolbar -->
    <div class="esp-card esp-sheet-toolbar-card" style="background:#f6f7f7;padding:12px 18px;border-radius:6px;border:1px solid #c3c4c7;margin-bottom:15px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        
        <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
            <!-- Student search -->
            <div class="esp-search-box" style="position:relative;">
                <input type="search" id="esp_student_search" class="regular-text" placeholder="<?php esc_attr_e('Filter student / roll no…', 'exam-system-pro'); ?>" style="padding-left:28px;height:32px;">
                <span class="dashicons dashicons-search" style="position:absolute;left:6px;top:7px;color:#8c8f94;font-size:18px;"></span>
            </div>

            <!-- Progress Indicator -->
            <div class="esp-progress-wrapper" style="display:inline-flex;align-items:center;gap:8px;font-size:13px;">
                <span style="font-weight:600;color:#50575e;"><?php esc_html_e('Filled:', 'exam-system-pro'); ?></span>
                <span id="esp_progress" style="font-weight:700;color:#2271b1;">0%</span>
                <span id="esp_progress_count" style="color:#646970;font-size:12px;">(0/0)</span>
            </div>

            <!-- Status Badges -->
            <span id="esp_sheet_status_badge" class="esp-badge" style="display:none;padding:3px 10px;border-radius:12px;font-size:12px;font-weight:600;"></span>
            <span id="esp_subject_info_badge" class="esp-badge" style="display:none;background:#e7f5ea;color:#135e2b;padding:3px 10px;border-radius:12px;font-size:12px;font-weight:600;"></span>
        </div>

        <!-- Action Buttons -->
        <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
            <button type="button" class="button" id="esp_export_excel" style="display:inline-flex;align-items:center;gap:4px;">
                <span class="dashicons dashicons-download" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Export Excel', 'exam-system-pro'); ?>
            </button>

            <button type="button" class="button" style="display:inline-flex;align-items:center;gap:4px;position:relative;overflow:hidden;cursor:pointer;">
                <span class="dashicons dashicons-upload" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Import Excel', 'exam-system-pro'); ?>
                <input type="file" id="esp_import_file" accept=".csv" style="position:absolute;top:0;left:0;margin:0;padding:0;cursor:pointer;opacity:0;width:100%;height:100%;">
            </button>

            <button type="button" class="button button-primary" id="esp_save_marks" disabled style="display:inline-flex;align-items:center;gap:4px;">
                <span class="dashicons dashicons-saved" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Save Marks (Ctrl+S)', 'exam-system-pro'); ?>
            </button>

            <button type="button" class="button button-secondary" id="esp_submit_marks" disabled style="display:inline-flex;align-items:center;gap:4px;color:#b32d2e;border-color:#b32d2e;">
                <span class="dashicons dashicons-lock" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Submit & Lock Sheet', 'exam-system-pro'); ?>
            </button>

            <button type="button" class="button button-secondary" id="esp_request_resubmit" style="display:none;align-items:center;gap:4px;">
                <span class="dashicons dashicons-unlock" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Request Resubmission', 'exam-system-pro'); ?>
            </button>
        </div>

    </div>

    <!-- Marks Table Card -->
    <div class="esp-card esp-table-card" style="background:#fff;border-radius:6px;border:1px solid #c3c4c7;box-shadow:0 1px 3px rgba(0,0,0,0.04);overflow:hidden;">
        <div class="esp-table-wrapper" style="overflow-x:auto;">
            <table id="esp_marks_table" class="widefat striped esp-marks-grid-table" style="border:none;margin:0;">
                <thead>
                    <tr id="esp_marks_header" style="background:#f0f0f1;">
                        <th style="width:100px;font-weight:700;"><?php esc_html_e('Roll No.', 'exam-system-pro'); ?></th>
                        <th style="font-weight:700;min-width:180px;"><?php esc_html_e('Student Name', 'exam-system-pro'); ?></th>
                        <th style="width:150px;font-weight:700;"><?php esc_html_e('Obtained Marks', 'exam-system-pro'); ?></th>
                        <th style="width:100px;font-weight:700;"><?php esc_html_e('Total Marks', 'exam-system-pro'); ?></th>
                        <th style="width:110px;font-weight:700;"><?php esc_html_e('Result Status', 'exam-system-pro'); ?></th>
                        <th style="min-width:180px;font-weight:700;"><?php esc_html_e('Remarks', 'exam-system-pro'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="esp-initial-prompt">
                        <td colspan="6" style="text-align:center;padding:40px 20px;color:#646970;">
                            <span class="dashicons dashicons-arrow-up-alt" style="font-size:32px;width:32px;height:32px;color:#2271b1;margin-bottom:8px;display:block;margin-left:auto;margin-right:auto;"></span>
                            <strong style="font-size:15px;"><?php esc_html_e('Select an Exam, Class, and Subject above, then click "Load Marks Sheet"', 'exam-system-pro'); ?></strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script type="text/javascript">
window.ESP_MARKS_INIT = {
    exams: <?php echo wp_json_encode($exams); ?>,
    schedules: <?php echo wp_json_encode($schedules ?? []); ?>,
    classes: <?php echo wp_json_encode($classes); ?>,
    subjects: <?php echo wp_json_encode($subjects); ?>,
    class_subject_map: <?php echo wp_json_encode($class_subject_map ?? []); ?>,
    is_admin: <?php echo $is_admin ? 'true' : 'false'; ?>
};
</script>
