<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin esp-report-page">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:15px;">
        <div>
            <a href="<?php echo esc_url(add_query_arg(['page' => 'esp-reports', 'exam_id' => $exam_id], admin_url('admin.php'))); ?>" class="button" style="display:inline-flex;align-items:center;gap:4px;margin-bottom:8px;">
                <span class="dashicons dashicons-arrow-left-alt" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Back to Reports', 'exam-system-pro'); ?>
            </a>
            <h1 style="margin:0;">
                <span class="dashicons dashicons-businessperson" style="font-size:26px;width:26px;height:26px;vertical-align:middle;color:#1d2327;"></span>
                <?php esc_html_e('Teacher-Wise Subject Summary', 'exam-system-pro'); ?>
            </h1>
            <?php if (!empty($exam)): ?>
                <p class="description" style="margin:4px 0 0 0;font-size:14px;">
                    <strong><?php echo esc_html($exam['exam_name']); ?></strong><?php if (!empty($exam['class_name'])): ?> &bull; <?php echo esc_html($exam['class_name']); ?><?php endif; ?>
                </p>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" onclick="window.print();" style="display:inline-flex;align-items:center;gap:4px;">
            <span class="dashicons dashicons-printer" style="font-size:16px;width:16px;height:16px;"></span>
            <?php esc_html_e('Print Summary', 'exam-system-pro'); ?>
        </button>
    </div>

    <?php if (!empty($teacher_data)): ?>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:0;overflow:hidden;border:1px solid #c3c4c7;">
            <table class="widefat striped esp-admin-table" style="border:none;margin:0;">
                <thead>
                    <tr style="background:#f0f0f1;">
                        <th style="font-weight:700;min-width:150px;"><?php esc_html_e('Teacher Name', 'exam-system-pro'); ?></th>
                        <th style="font-weight:700;"><?php esc_html_e('Class Assigned', 'exam-system-pro'); ?></th>
                        <th style="font-weight:700;"><?php esc_html_e('Subject', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Total Stds', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:center;font-weight:700;"><?php esc_html_e('Avg Grade', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Pass %', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Highest', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Lowest', 'exam-system-pro'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $last_teacher = '';
                foreach ($teacher_data as $row): 
                    $is_new = $last_teacher !== $row->teacher_name;
                    $last_teacher = $row->teacher_name;
                ?>
                    <tr <?php if ($is_new) echo 'style="border-top:2px solid #c3c4c7;"'; ?>>
                        <td style="font-weight:600;color:#1d2327;">
                            <?php echo $is_new ? esc_html($row->teacher_name) : ''; ?>
                        </td>
                        <td style="color:#50575e;"><?php echo esc_html($row->class_name); ?></td>
                        <td style="font-weight:600;color:#2271b1;"><?php echo esc_html($row->subject_name); ?></td>
                        <td style="text-align:right;font-weight:600;"><?php echo esc_html((int)$row->total_appeared); ?></td>
                        <td style="text-align:center;font-weight:700;"><span style="background:#f0f0f1;padding:2px 8px;border-radius:4px;"><?php echo esc_html($row->average_grade ?: '—'); ?></span></td>
                        <td style="text-align:right;font-weight:600;"><?php echo esc_html(number_format((float)$row->pass_pct, 2)); ?>%</td>
                        <td style="text-align:right;color:#135e2b;font-weight:700;"><?php echo esc_html((float)$row->highest_marks); ?></td>
                        <td style="text-align:right;color:#b32d2e;font-weight:700;"><?php echo esc_html((float)$row->lowest_marks); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:40px 20px;text-align:center;color:#646970;border:1px solid #c3c4c7;">
            <p style="font-size:15px;font-weight:600;margin:0;"><?php esc_html_e('No teacher allocations or marks found for this exam.', 'exam-system-pro'); ?></p>
        </div>
    <?php endif; ?>
</div>