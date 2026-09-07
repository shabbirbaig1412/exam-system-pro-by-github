<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin esp-report-page">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:15px;">
        <div>
            <a href="<?php echo esc_url(add_query_arg(['page' => 'esp-reports', 'exam_id' => $exam_id], admin_url('admin.php'))); ?>" class="button" style="display:inline-flex;align-items:center;gap:4px;margin-bottom:8px;">
                <span class="dashicons dashicons-arrow-left-alt" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Back to Reports', 'exam-system-pro'); ?>
            </a>
            <h1 style="margin:0;">
                <span class="dashicons dashicons-warning" style="font-size:26px;width:26px;height:26px;vertical-align:middle;color:#d63638;"></span>
                <?php esc_html_e('Failed Students & Remedial Attention List', 'exam-system-pro'); ?>
            </h1>
            <?php if (!empty($exam)): ?>
                <p class="description" style="margin:4px 0 0 0;font-size:14px;">
                    <strong><?php echo esc_html($exam['exam_name']); ?></strong><?php if (!empty($exam['class_name'])): ?> &bull; <?php echo esc_html($exam['class_name']); ?><?php endif; ?>
                </p>
            <?php endif; ?>
        </div>
        <?php if (!empty($results)): ?>
            <button type="button" class="button button-primary" onclick="window.print();" style="display:inline-flex;align-items:center;gap:4px;">
                <span class="dashicons dashicons-printer" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Print Remedial List', 'exam-system-pro'); ?>
            </button>
        <?php endif; ?>
    </div>

    <?php if (!empty($results)): ?>
        <div class="notice notice-warning" style="margin-bottom:15px;">
            <p><strong><?php printf(esc_html__('Found %d student(s) who did not meet the passing criteria for this exam.', 'exam-system-pro'), count($results)); ?></strong></p>
        </div>

        <div class="esp-card" style="background:#fff;border-radius:8px;padding:0;overflow:hidden;border:1px solid #c3c4c7;">
            <table class="widefat striped esp-admin-table" style="border:none;margin:0;">
                <thead>
                    <tr style="background:#f0f0f1;">
                        <th style="width:90px;font-weight:700;"><?php esc_html_e('Roll No.', 'exam-system-pro'); ?></th>
                        <th style="font-weight:700;min-width:180px;"><?php esc_html_e('Student Name', 'exam-system-pro'); ?></th>
                        <th style="width:140px;font-weight:700;"><?php esc_html_e('Father Name', 'exam-system-pro'); ?></th>
                        <th style="width:110px;text-align:right;font-weight:700;"><?php esc_html_e('Obtained', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Total Marks', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Percentage', 'exam-system-pro'); ?></th>
                        <th style="width:80px;text-align:center;font-weight:700;"><?php esc_html_e('Grade', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:center;font-weight:700;"><?php esc_html_e('Status', 'exam-system-pro'); ?></th>
                        <th style="width:120px;text-align:center;font-weight:700;"><?php esc_html_e('Report Card', 'exam-system-pro'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td style="font-weight:600;"><?php echo esc_html($row->roll_no ?: ('#' . $row->student_id)); ?></td>
                        <td style="font-weight:600;color:#1d2327;"><?php echo esc_html($row->student_name ?? ('Student #' . $row->student_id)); ?></td>
                        <td style="color:#50575e;"><?php echo esc_html($row->father_name ?? '—'); ?></td>
                        <td style="text-align:right;font-weight:700;color:#d63638;"><?php echo esc_html((float)$row->obtained_marks); ?></td>
                        <td style="text-align:right;color:#646970;"><?php echo esc_html((float)$row->total_marks); ?></td>
                        <td style="text-align:right;font-weight:600;color:#d63638;"><?php echo esc_html(number_format((float)$row->percentage, 2)); ?>%</td>
                        <td style="text-align:center;font-weight:700;"><span style="background:#fcf0f1;color:#b32d2e;padding:2px 8px;border-radius:4px;"><?php echo esc_html($row->grade ?: 'F'); ?></span></td>
                        <td style="text-align:center;">
                            <span style="display:inline-block;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:700;background:#fcf0f1;color:#b32d2e;">
                                <?php esc_html_e('FAIL', 'exam-system-pro'); ?>
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <a href="<?php echo esc_url(add_query_arg(['page' => 'esp-reports', 'exam_id' => $exam_id, 'report' => 'report-card', 'student_id' => $row->student_id], admin_url('admin.php'))); ?>" class="button button-small">
                                <?php esc_html_e('Report Card', 'exam-system-pro'); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:40px 20px;text-align:center;color:#1a7f37;border:1px solid #c3c4c7;">
            <span class="dashicons dashicons-yes-alt" style="font-size:40px;width:40px;height:40px;margin-bottom:10px;color:#1a7f37;"></span>
            <p style="font-size:16px;font-weight:600;margin:0;"><?php esc_html_e('Excellent! No students failed this exam.', 'exam-system-pro'); ?></p>
        </div>
    <?php endif; ?>
</div>
