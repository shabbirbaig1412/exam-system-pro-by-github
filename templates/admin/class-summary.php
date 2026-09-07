<?php defined('ABSPATH') || exit; 
$total_st = (int)($statistics['students'] ?? 0);
$passed_st = (int)($statistics['passed'] ?? 0);
$failed_st = (int)($statistics['failed'] ?? 0);
$pass_pct = $total_st > 0 ? round(($passed_st / $total_st) * 100, 1) : 0;
?>

<div class="wrap esp-admin esp-report-page">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:15px;">
        <div>
            <a href="<?php echo esc_url(add_query_arg(['page' => 'esp-reports', 'exam_id' => $exam_id], admin_url('admin.php'))); ?>" class="button" style="display:inline-flex;align-items:center;gap:4px;margin-bottom:8px;">
                <span class="dashicons dashicons-arrow-left-alt" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Back to Reports', 'exam-system-pro'); ?>
            </a>
            <h1 style="margin:0;"><?php esc_html_e('Class Summary Report', 'exam-system-pro'); ?></h1>
            <?php if (!empty($exam)): ?>
                <p class="description" style="margin:4px 0 0 0;font-size:14px;">
                    <strong><?php echo esc_html($exam['exam_name']); ?></strong><?php if (!empty($exam['class_name'])): ?> &bull; <?php echo esc_html($exam['class_name']); ?><?php endif; ?>
                </p>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-primary" onclick="window.print();" style="display:inline-flex;align-items:center;gap:4px;">
            <span class="dashicons dashicons-printer" style="font-size:16px;width:16px;height:16px;"></span>
            <?php esc_html_e('Print Report', 'exam-system-pro'); ?>
        </button>
    </div>

    <!-- Stat Cards Grid -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));gap:14px;margin-bottom:20px;">
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:16px;border:1px solid #c3c4c7;border-left:4px solid #2271b1;">
            <span style="font-size:12px;font-weight:600;color:#646970;text-transform:uppercase;"><?php esc_html_e('Total Students', 'exam-system-pro'); ?></span>
            <div style="font-size:26px;font-weight:700;color:#1d2327;margin-top:4px;"><?php echo esc_html($total_st); ?></div>
        </div>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:16px;border:1px solid #c3c4c7;border-left:4px solid #1a7f37;">
            <span style="font-size:12px;font-weight:600;color:#646970;text-transform:uppercase;"><?php esc_html_e('Passed', 'exam-system-pro'); ?></span>
            <div style="font-size:26px;font-weight:700;color:#1a7f37;margin-top:4px;"><?php echo esc_html($passed_st); ?></div>
        </div>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:16px;border:1px solid #c3c4c7;border-left:4px solid #d63638;">
            <span style="font-size:12px;font-weight:600;color:#646970;text-transform:uppercase;"><?php esc_html_e('Failed', 'exam-system-pro'); ?></span>
            <div style="font-size:26px;font-weight:700;color:#d63638;margin-top:4px;"><?php echo esc_html($failed_st); ?></div>
        </div>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:16px;border:1px solid #c3c4c7;border-left:4px solid #8c5e00;">
            <span style="font-size:12px;font-weight:600;color:#646970;text-transform:uppercase;"><?php esc_html_e('Pass Percentage', 'exam-system-pro'); ?></span>
            <div style="font-size:26px;font-weight:700;color:#8c5e00;margin-top:4px;"><?php echo esc_html($pass_pct); ?>%</div>
        </div>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:16px;border:1px solid #c3c4c7;border-left:4px solid #007074;">
            <span style="font-size:12px;font-weight:600;color:#646970;text-transform:uppercase;"><?php esc_html_e('Highest Score', 'exam-system-pro'); ?></span>
            <div style="font-size:26px;font-weight:700;color:#007074;margin-top:4px;"><?php echo esc_html((float)($statistics['highest'] ?? 0)); ?></div>
        </div>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:16px;border:1px solid #c3c4c7;border-left:4px solid #4f3494;">
            <span style="font-size:12px;font-weight:600;color:#646970;text-transform:uppercase;"><?php esc_html_e('Average Score', 'exam-system-pro'); ?></span>
            <div style="font-size:26px;font-weight:700;color:#4f3494;margin-top:4px;"><?php echo esc_html(number_format((float)($statistics['average'] ?? 0), 2)); ?></div>
        </div>
    </div>

    <!-- Student Breakdown Table -->
    <?php if (!empty($results)): ?>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:0;overflow:hidden;border:1px solid #c3c4c7;">
            <div style="padding:14px 18px;background:#f6f7f7;border-bottom:1px solid #c3c4c7;">
                <strong style="font-size:14px;color:#1d2327;"><?php esc_html_e('Student Performance Breakdown', 'exam-system-pro'); ?></strong>
            </div>
            <table class="widefat striped esp-admin-table" style="border:none;margin:0;">
                <thead>
                    <tr style="background:#f0f0f1;">
                        <th style="width:70px;text-align:center;font-weight:700;"><?php esc_html_e('Rank', 'exam-system-pro'); ?></th>
                        <th style="width:90px;font-weight:700;"><?php esc_html_e('Roll No.', 'exam-system-pro'); ?></th>
                        <th style="font-weight:700;"><?php esc_html_e('Student Name', 'exam-system-pro'); ?></th>
                        <th style="width:110px;text-align:right;font-weight:700;"><?php esc_html_e('Obtained', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Total', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Percentage', 'exam-system-pro'); ?></th>
                        <th style="width:80px;text-align:center;font-weight:700;"><?php esc_html_e('Grade', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:center;font-weight:700;"><?php esc_html_e('Status', 'exam-system-pro'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $row): 
                    $status_str = strtoupper($row->status ?? '');
                    $is_pass = ($status_str === 'PASS');
                ?>
                    <tr>
                        <td style="text-align:center;font-weight:700;color:#2271b1;">#<?php echo esc_html($row->position ?: '—'); ?></td>
                        <td style="font-weight:600;"><?php echo esc_html($row->roll_no ?: ('#' . $row->student_id)); ?></td>
                        <td style="font-weight:600;color:#1d2327;"><?php echo esc_html($row->student_name ?? ('Student #' . $row->student_id)); ?></td>
                        <td style="text-align:right;font-weight:700;"><?php echo esc_html((float)$row->obtained_marks); ?></td>
                        <td style="text-align:right;color:#646970;"><?php echo esc_html((float)$row->total_marks); ?></td>
                        <td style="text-align:right;font-weight:600;"><?php echo esc_html(number_format((float)$row->percentage, 2)); ?>%</td>
                        <td style="text-align:center;font-weight:700;"><span style="background:#f0f0f1;padding:2px 8px;border-radius:4px;"><?php echo esc_html($row->grade ?: '—'); ?></span></td>
                        <td style="text-align:center;">
                            <span style="display:inline-block;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:700;background:<?php echo $is_pass ? '#edfaef' : '#fcf0f1'; ?>;color:<?php echo $is_pass ? '#1a7f37' : '#b32d2e'; ?>;">
                                <?php echo esc_html($status_str ?: '—'); ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>