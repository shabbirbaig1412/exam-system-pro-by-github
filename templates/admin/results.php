<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:15px;">
        <h1 style="margin:0;"><?php esc_html_e('Class Tabulation Sheet', 'exam-system-pro'); ?></h1>
        <?php if (!empty($results)): ?>
            <button type="button" class="button" onclick="window.print();" style="display:inline-flex;align-items:center;gap:4px;">
                <span class="dashicons dashicons-printer" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Print Results', 'exam-system-pro'); ?>
            </button>
        <?php endif; ?>
    </div>

    <?php if (sanitize_key($_GET['esp_status'] ?? '') === 'updated'): ?>
        <div class="notice notice-success is-dismissible"><p><?php esc_html_e('Results generated and positions calculated successfully.', 'exam-system-pro'); ?></p></div>
    <?php endif; ?>

    <form method="get" class="esp-card" style="margin-bottom:15px;">
        <input type="hidden" name="page" value="esp-results">
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <label for="esp-result-exam" style="font-weight:600;"><?php esc_html_e('Select Exam:', 'exam-system-pro'); ?></label>
            <select id="esp-result-exam" name="exam_id" required style="min-width:260px;">
                <option value=""><?php esc_html_e('-- Choose Exam --', 'exam-system-pro'); ?></option>
                <?php foreach ($exams as $exam): ?>
                    <option value="<?php echo esc_attr($exam['id']); ?>" <?php selected($exam_id, $exam['id']); ?>>
                        <?php echo esc_html($exam['exam_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button class="button button-primary"><?php esc_html_e('View Results', 'exam-system-pro'); ?></button>
        </div>
    </form>

    <?php if ($exam_id): ?>
        <div class="esp-card" style="margin-bottom:15px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="margin:0;">
                <input type="hidden" name="action" value="esp_generate_results">
                <input type="hidden" name="exam_id" value="<?php echo esc_attr($exam_id); ?>">
                <?php wp_nonce_field('esp_admin_record'); ?>
                <button class="button button-primary" style="display:inline-flex;align-items:center;gap:4px;">
                    <span class="dashicons dashicons-calculator" style="font-size:16px;width:16px;height:16px;"></span>
                    <?php esc_html_e('Generate / Recalculate Results', 'exam-system-pro'); ?>
                </button>
            </form>
            <p class="description" style="margin:0;color:#646970;">
                <?php esc_html_e('Positions, grades, percentages, and remarks are computed automatically from saved marks.', 'exam-system-pro'); ?>
            </p>
        </div>

        <?php if (!empty($results)): ?>
            <div class="esp-card" style="padding:0;overflow:auto;">
                <table class="widefat striped esp-admin-table" style="border:none;margin:0;font-size:13px;">
                    <thead>
                        <tr style="background:#f0f0f1;">
                            <th style="width:60px;text-align:center;font-weight:700;"><?php esc_html_e('Rank', 'exam-system-pro'); ?></th>
                            <th style="width:70px;font-weight:700;"><?php esc_html_e('Roll No.', 'exam-system-pro'); ?></th>
                            <th style="font-weight:700;width:150px;padding:8px;white-space:nowrap;"><?php esc_html_e('Student Name', 'exam-system-pro'); ?></th>
                            
                            <?php foreach ($subject_map as $subject): ?>
                                <th style="width:60px;text-align:center;font-weight:700;padding:4px 2px;" title="<?php echo esc_attr($subject['name']); ?>">
                                    <?php echo esc_html(substr($subject['name'], 0, 10)); ?>
                                </th>
                            <?php endforeach; ?>
                            
                            <th style="width:80px;text-align:right;font-weight:700;"><?php esc_html_e('Total', 'exam-system-pro'); ?></th>
                            <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Obtained', 'exam-system-pro'); ?></th>
                            <th style="width:80px;text-align:right;font-weight:700;"><?php esc_html_e('Pct', 'exam-system-pro'); ?></th>
                            <th style="width:60px;text-align:center;font-weight:700;"><?php esc_html_e('Grade', 'exam-system-pro'); ?></th>
                            <th style="width:70px;text-align:center;font-weight:700;"><?php esc_html_e('Status', 'exam-system-pro'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    global $wpdb;
                    $campus = ESP_CampusContext::id();
                    foreach ($results as $result): 
                        $status_str = strtoupper($result->status ?? '');
                        $is_pass = ($status_str === 'PASS');
                    ?>
                        <tr>
                            <td style="text-align:center;font-weight:700;color:#2271b1;">
                                #<?php echo esc_html($result->position ?: '—'); ?>
                            </td>
                            <td style="font-weight:600;">
                                <?php echo esc_html($result->roll_no ?: ('#' . $result->student_id)); ?>
                            </td>
                            <td style="font-weight:600;color:#1d2327;padding:8px;white-space:nowrap;">
                                <?php echo esc_html($result->student_name ?? ('Student #' . $result->student_id)); ?>
                            </td>
                            
                            <?php 
                            // Load marks for this student for each subject
                            foreach ($subject_map as $subject):
                                $mark = $wpdb->get_row($wpdb->prepare(
                                    "SELECT m.obtained_marks, s.total_marks FROM {$wpdb->prefix}esp_marks m
                                     INNER JOIN {$wpdb->prefix}esp_subjects s ON s.id=m.subject_id
                                     WHERE m.exam_id=%d AND m.student_id=%d AND m.subject_id=%d AND m.campus_id=%d",
                                    $result->exam_id,
                                    $result->student_id,
                                    $subject['id'],
                                    $campus
                                ));
                                $obtained = $mark ? (float)$mark->obtained_marks : 0;
                            ?>
                                <td style="text-align:center;padding:4px 2px;">
                                    <?php echo esc_html(number_format($obtained, 2)); ?>
                                </td>
                            <?php endforeach; ?>
                            
                            <td style="text-align:right;color:#646970;">
                                <?php echo esc_html((float)$result->total_marks); ?>
                            </td>
                            <td style="text-align:right;font-weight:700;">
                                <?php echo esc_html((float)$result->obtained_marks); ?>
                            </td>
                            <td style="text-align:right;font-weight:600;">
                                <?php echo esc_html(number_format((float)$result->percentage, 2)); ?>%
                            </td>
                            <td style="text-align:center;font-weight:700;">
                                <span style="background:#f0f0f1;padding:2px 6px;border-radius:4px;font-size:12px;"><?php echo esc_html($result->grade ?: '—'); ?></span>
                            </td>
                            <td style="text-align:center;font-size:11px;">
                                <span style="display:inline-block;padding:2px 8px;border-radius:12px;font-weight:700;background:<?php echo $is_pass ? '#edfaef' : '#fcf0f1'; ?>;color:<?php echo $is_pass ? '#1a7f37' : '#b32d2e'; ?>;">
                                    <?php echo esc_html($status_str ?: '—'); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="esp-card" style="text-align:center;padding:40px 20px;color:#646970;">
                <p style="font-size:15px;font-weight:600;margin-bottom:10px;"><?php esc_html_e('No results generated yet for this exam.', 'exam-system-pro'); ?></p>
                <p><?php esc_html_e('Click the "Generate / Recalculate Results" button above to process entered marks.', 'exam-system-pro'); ?></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
