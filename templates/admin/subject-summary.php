<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin esp-report-page">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:15px;">
        <div>
            <a href="<?php echo esc_url(add_query_arg(['page' => 'esp-reports', 'exam_id' => $exam_id], admin_url('admin.php'))); ?>" class="button" style="display:inline-flex;align-items:center;gap:4px;margin-bottom:8px;">
                <span class="dashicons dashicons-arrow-left-alt" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Back to Reports', 'exam-system-pro'); ?>
            </a>
            <h1 style="margin:0;">
                <span class="dashicons dashicons-book-alt" style="font-size:26px;width:26px;height:26px;vertical-align:middle;color:#007074;"></span>
                <?php esc_html_e('Subject Performance Summary', 'exam-system-pro'); ?>
            </h1>
            <?php if (!empty($exam)): ?>
                <p class="description" style="margin:4px 0 0 0;font-size:14px;">
                    <strong><?php echo esc_html($exam['exam_name']); ?></strong><?php if (!empty($exam['class_name'])): ?> &bull; <?php echo esc_html($exam['class_name']); ?><?php endif; ?>
                </p>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" onclick="window.print();" style="display:inline-flex;align-items:center;gap:4px;">
            <span class="dashicons dashicons-printer" style="font-size:16px;width:16px;height:16px;"></span>
            <?php esc_html_e('Print Subject Summary', 'exam-system-pro'); ?>
        </button>
    </div>

    <?php if (!empty($subjects)): ?>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:0;overflow:hidden;border:1px solid #c3c4c7;">
            <table class="widefat striped esp-admin-table" style="border:none;margin:0;">
                <thead>
                    <tr style="background:#f0f0f1;">
                        <th style="font-weight:700;min-width:180px;"><?php esc_html_e('Subject Name', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Total Marks', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Pass Marks', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:center;font-weight:700;"><?php esc_html_e('Students', 'exam-system-pro'); ?></th>
                        <th style="width:110px;text-align:right;font-weight:700;"><?php esc_html_e('Highest Marks', 'exam-system-pro'); ?></th>
                        <th style="width:110px;text-align:right;font-weight:700;"><?php esc_html_e('Average Marks', 'exam-system-pro'); ?></th>
                        <th style="width:110px;text-align:right;font-weight:700;"><?php esc_html_e('Lowest Marks', 'exam-system-pro'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($subjects as $subject): ?>
                    <tr>
                        <td style="font-weight:600;color:#1d2327;">
                            <?php echo esc_html($subject->subject_name); ?>
                            <?php if (!empty($subject->subject_code)): ?>
                                <span style="font-size:12px;color:#646970;font-weight:normal;">(<?php echo esc_html($subject->subject_code); ?>)</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:right;color:#646970;"><?php echo esc_html((float)$subject->total_marks); ?></td>
                        <td style="text-align:right;color:#646970;"><?php echo esc_html((float)$subject->passing_marks); ?></td>
                        <td style="text-align:center;font-weight:600;"><?php echo esc_html((int)$subject->students); ?></td>
                        <td style="text-align:right;font-weight:700;color:#1a7f37;"><?php echo esc_html((float)$subject->highest); ?></td>
                        <td style="text-align:right;font-weight:700;color:#2271b1;"><?php echo esc_html(number_format((float)$subject->average, 2)); ?></td>
                        <td style="text-align:right;font-weight:700;color:#d63638;"><?php echo esc_html((float)$subject->lowest); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:40px 20px;text-align:center;color:#646970;border:1px solid #c3c4c7;">
            <p style="font-size:15px;font-weight:600;margin:0;"><?php esc_html_e('No subject data found for this exam.', 'exam-system-pro'); ?></p>
        </div>
    <?php endif; ?>
</div>