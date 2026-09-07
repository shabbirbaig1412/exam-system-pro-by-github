<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin esp-report-page">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:15px;">
        <div>
            <a href="<?php echo esc_url(add_query_arg(['page' => 'esp-reports', 'exam_id' => $exam_id], admin_url('admin.php'))); ?>" class="button" style="display:inline-flex;align-items:center;gap:4px;margin-bottom:8px;">
                <span class="dashicons dashicons-arrow-left-alt" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Back to Reports', 'exam-system-pro'); ?>
            </a>
            <h1 style="margin:0;">
                <span class="dashicons dashicons-chart-pie" style="font-size:26px;width:26px;height:26px;vertical-align:middle;color:#2271b1;"></span>
                <?php esc_html_e('All Classes Summary Report', 'exam-system-pro'); ?>
            </h1>
            <?php if (!empty($exam)): ?>
                <p class="description" style="margin:4px 0 0 0;font-size:14px;">
                    <strong><?php echo esc_html($exam['exam_name']); ?></strong>
                </p>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" onclick="window.print();" style="display:inline-flex;align-items:center;gap:4px;">
            <span class="dashicons dashicons-printer" style="font-size:16px;width:16px;height:16px;"></span>
            <?php esc_html_e('Print Report', 'exam-system-pro'); ?>
        </button>
    </div>

    <?php if (!empty($classes_data)): ?>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:0;overflow:hidden;border:1px solid #c3c4c7;">
            <div style="padding:14px 18px;background:#f6f7f7;border-bottom:1px solid #c3c4c7;">
                <strong style="font-size:14px;color:#1d2327;"><?php esc_html_e('Class-wise Performance Overview', 'exam-system-pro'); ?></strong>
            </div>
            <table class="widefat striped esp-admin-table" style="border:none;margin:0;">
                <thead>
                    <tr style="background:#f0f0f1;">
                        <th style="font-weight:700;"><?php esc_html_e('Class Name', 'exam-system-pro'); ?></th>
                        <th style="width:120px;text-align:right;font-weight:700;"><?php esc_html_e('Total Appeared', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Absents', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Passed', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Failed', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Pass %', 'exam-system-pro'); ?></th>
                        <th style="width:120px;text-align:center;font-weight:700;"><?php esc_html_e('Avg Grade', 'exam-system-pro'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($classes_data as $row): ?>
                    <tr>
                        <td style="font-weight:600;color:#1d2327;"><?php echo esc_html($row->class_name); ?></td>
                        <td style="text-align:right;font-weight:600;"><?php echo esc_html((int)$row->total_appeared); ?></td>
                        <td style="text-align:right;color:#d63638;"><?php echo esc_html((int)$row->absents); ?></td>
                        <td style="text-align:right;color:#1a7f37;font-weight:600;"><?php echo esc_html((int)$row->passed); ?></td>
                        <td style="text-align:right;color:#b32d2e;font-weight:600;"><?php echo esc_html((int)$row->failed); ?></td>
                        <td style="text-align:right;font-weight:600;"><?php echo esc_html(number_format((float)$row->pass_pct, 2)); ?>%</td>
                        <td style="text-align:center;font-weight:700;"><span style="background:#f0f0f1;padding:2px 8px;border-radius:4px;"><?php echo esc_html($row->average_grade ?: '—'); ?></span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="esp-card" style="text-align:center;padding:40px 20px;color:#646970;">
            <p style="font-size:15px;font-weight:600;margin-bottom:10px;"><?php esc_html_e('No results generated yet for this exam to build class summary.', 'exam-system-pro'); ?></p>
        </div>
    <?php endif; ?>
</div>
