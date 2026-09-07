<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin esp-report-page">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:15px;">
        <div>
            <a href="<?php echo esc_url(add_query_arg(['page' => 'esp-reports', 'exam_id' => $exam_id], admin_url('admin.php'))); ?>" class="button" style="display:inline-flex;align-items:center;gap:4px;margin-bottom:8px;">
                <span class="dashicons dashicons-arrow-left-alt" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Back to Reports', 'exam-system-pro'); ?>
            </a>
            <h1 style="margin:0;">
                <span class="dashicons dashicons-id-alt" style="font-size:26px;width:26px;height:26px;vertical-align:middle;color:#135e2b;"></span>
                <?php esc_html_e('Student Progress Report Card', 'exam-system-pro'); ?>
            </h1>
        </div>
        <button type="button" class="button button-primary" onclick="window.print();" style="display:inline-flex;align-items:center;gap:4px;">
            <span class="dashicons dashicons-printer" style="font-size:16px;width:16px;height:16px;"></span>
            <?php esc_html_e('Print Report Card', 'exam-system-pro'); ?>
        </button>
    </div>

    <!-- Student Switcher Bar (Screen only) -->
    <div class="esp-card esp-screen-only" style="background:#fff;padding:14px 18px;border-radius:6px;border:1px solid #c3c4c7;margin-bottom:20px;">
        <form method="get" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin:0;">
            <input type="hidden" name="page" value="esp-reports">
            <input type="hidden" name="exam_id" value="<?php echo esc_attr($exam_id); ?>">
            <input type="hidden" name="report" value="report-card">
            <label for="esp_report_student_select" style="font-weight:600;"><?php esc_html_e('Switch Student:', 'exam-system-pro'); ?></label>
            <select id="esp_report_student_select" name="student_id" onchange="this.form.submit();" style="min-width:280px;height:34px;">
                <?php foreach ($students as $st): ?>
                    <option value="<?php echo esc_attr($st->id); ?>" <?php selected($student_id, $st->id); ?>>
                        <?php if (!empty($st->roll_no)): ?>[Roll: <?php echo esc_html($st->roll_no); ?>] <?php endif; ?><?php echo esc_html($st->student_name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <noscript><button class="button"><?php esc_html_e('View', 'exam-system-pro'); ?></button></noscript>
        </form>
    </div>

    <?php if (!empty($student)): 
        $st_name = $student->student_name ?? '—';
        $roll_no = $student->roll_no ?? '—';
        $adm_no = $student->admission_no ?? '—';
        $father = $student->father_name ?? '—';
        $class_name = $student->class_name ?? ($exam['class_name'] ?? '—');
        $exam_name = $exam['exam_name'] ?? '—';
    ?>
        <div class="esp-printable-card" style="background:#fff;border-radius:8px;border:1px solid #c3c4c7;padding:24px;box-shadow:0 1px 4px rgba(0,0,0,0.05);margin-bottom:20px;">
            <!-- School / Exam Header -->
            <div style="text-align:center;border-bottom:2px solid #2271b1;padding-bottom:15px;margin-bottom:20px;">
                <h2 style="margin:0 0 5px 0;font-size:22px;color:#1d2327;"><?php echo esc_html(get_bloginfo('name')); ?></h2>
                <h3 style="margin:0 0 4px 0;font-size:16px;color:#2271b1;font-weight:600;"><?php echo esc_html($exam_name); ?></h3>
                <span style="font-size:13px;color:#646970;text-transform:uppercase;letter-spacing:0.5px;"><?php esc_html_e('Official Student Grade & Performance Report', 'exam-system-pro'); ?></span>
            </div>

            <!-- Student Profile Grid -->
            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));gap:12px;background:#f6f7f7;padding:16px;border-radius:6px;margin-bottom:20px;font-size:13px;">
                <div><strong style="color:#50575e;"><?php esc_html_e('Student Name:', 'exam-system-pro'); ?></strong> <span style="font-weight:700;color:#1d2327;"><?php echo esc_html($st_name); ?></span></div>
                <div><strong style="color:#50575e;"><?php esc_html_e('Roll No:', 'exam-system-pro'); ?></strong> <span style="font-weight:700;color:#1d2327;"><?php echo esc_html($roll_no); ?></span></div>
                <div><strong style="color:#50575e;"><?php esc_html_e('Admission No:', 'exam-system-pro'); ?></strong> <span><?php echo esc_html($adm_no); ?></span></div>
                <div><strong style="color:#50575e;"><?php esc_html_e('Father Name:', 'exam-system-pro'); ?></strong> <span><?php echo esc_html($father); ?></span></div>
                <div><strong style="color:#50575e;"><?php esc_html_e('Class:', 'exam-system-pro'); ?></strong> <span style="font-weight:600;"><?php echo esc_html($class_name); ?></span></div>
                <?php if (!empty($result_summary->position)): ?>
                    <div><strong style="color:#50575e;"><?php esc_html_e('Class Rank:', 'exam-system-pro'); ?></strong> <span style="font-weight:700;color:#2271b1;">#<?php echo esc_html($result_summary->position); ?></span></div>
                <?php endif; ?>
            </div>

            <!-- Marks Table -->
            <table class="widefat striped" style="border:1px solid #c3c4c7;margin-bottom:20px;">
                <thead>
                    <tr style="background:#f0f0f1;">
                        <th style="font-weight:700;"><?php esc_html_e('Subject', 'exam-system-pro'); ?></th>
                        <th style="width:110px;text-align:right;font-weight:700;"><?php esc_html_e('Total Marks', 'exam-system-pro'); ?></th>
                        <th style="width:110px;text-align:right;font-weight:700;"><?php esc_html_e('Pass Marks', 'exam-system-pro'); ?></th>
                        <th style="width:120px;text-align:right;font-weight:700;"><?php esc_html_e('Obtained Marks', 'exam-system-pro'); ?></th>
                        <th style="width:100px;text-align:center;font-weight:700;"><?php esc_html_e('Status', 'exam-system-pro'); ?></th>
                        <th style="min-width:140px;font-weight:700;"><?php esc_html_e('Remarks', 'exam-system-pro'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $sum_total = 0;
                $sum_obtained = 0;
                foreach ($subjects as $subject): 
                    $tot = (float)($subject->total_marks ?? 100);
                    $pass = (float)($subject->passing_marks ?? 40);
                    $obt = (float)($subject->obtained_marks ?? 0);
                    $sum_total += $tot;
                    $sum_obtained += $obt;
                    $is_sub_pass = ($obt >= $pass);
                ?>
                    <tr>
                        <td style="font-weight:600;color:#1d2327;"><?php echo esc_html($subject->subject_name); ?></td>
                        <td style="text-align:right;color:#646970;"><?php echo esc_html($tot); ?></td>
                        <td style="text-align:right;color:#646970;"><?php echo esc_html($pass); ?></td>
                        <td style="text-align:right;font-weight:700;color:#1d2327;"><?php echo esc_html($obt); ?></td>
                        <td style="text-align:center;">
                            <span style="display:inline-block;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:700;background:<?php echo $is_sub_pass ? '#edfaef' : '#fcf0f1'; ?>;color:<?php echo $is_sub_pass ? '#1a7f37' : '#b32d2e'; ?>;">
                                <?php echo $is_sub_pass ? esc_html__('PASS', 'exam-system-pro') : esc_html__('FAIL', 'exam-system-pro'); ?>
                            </span>
                        </td>
                        <td style="color:#646970;font-size:13px;"><?php echo esc_html($subject->remarks ?? '—'); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Overall Performance Summary -->
            <?php if (!empty($result_summary)): 
                $overall_pass = (strtoupper($result_summary->status ?? '') === 'PASS');
            ?>
                <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(160px, 1fr));gap:12px;background:#f6f7f7;padding:16px;border-radius:6px;border:1px solid #dcdcde;">
                    <div><strong style="color:#50575e;"><?php esc_html_e('Grand Total:', 'exam-system-pro'); ?></strong> <div style="font-size:18px;font-weight:700;color:#1d2327;margin-top:2px;"><?php echo esc_html((float)$result_summary->obtained_marks); ?> / <?php echo esc_html((float)$result_summary->total_marks); ?></div></div>
                    <div><strong style="color:#50575e;"><?php esc_html_e('Percentage:', 'exam-system-pro'); ?></strong> <div style="font-size:18px;font-weight:700;color:#2271b1;margin-top:2px;"><?php echo esc_html(number_format((float)$result_summary->percentage, 2)); ?>%</div></div>
                    <div><strong style="color:#50575e;"><?php esc_html_e('Overall Grade:', 'exam-system-pro'); ?></strong> <div style="font-size:18px;font-weight:700;color:#1d2327;margin-top:2px;"><?php echo esc_html($result_summary->grade ?: '—'); ?></div></div>
                    <div><strong style="color:#50575e;"><?php esc_html_e('Final Status:', 'exam-system-pro'); ?></strong> 
                        <div style="margin-top:2px;">
                            <span style="display:inline-block;padding:3px 12px;border-radius:12px;font-size:12px;font-weight:700;background:<?php echo $overall_pass ? '#edfaef' : '#fcf0f1'; ?>;color:<?php echo $overall_pass ? '#1a7f37' : '#b32d2e'; ?>;">
                                <?php echo esc_html(strtoupper($result_summary->status ?: '—')); ?>
                            </span>
                        </div>
                    </div>
                    <?php if (!empty($result_summary->remarks)): ?>
                        <div style="grid-column:1 / -1;margin-top:4px;"><strong style="color:#50575e;"><?php esc_html_e('Teacher Remarks:', 'exam-system-pro'); ?></strong> <span style="font-style:italic;color:#1d2327;"><?php echo esc_html($result_summary->remarks); ?></span></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Signature Footer -->
            <div style="display:flex;justify-content:space-between;margin-top:40px;padding-top:20px;font-size:13px;color:#50575e;">
                <div style="border-top:1px solid #8c8f94;width:180px;text-align:center;padding-top:5px;"><?php esc_html_e('Class Teacher Signature', 'exam-system-pro'); ?></div>
                <div style="border-top:1px solid #8c8f94;width:180px;text-align:center;padding-top:5px;"><?php esc_html_e('Principal / Controller', 'exam-system-pro'); ?></div>
            </div>
        </div>
    <?php else: ?>
        <div class="esp-card" style="background:#fff;border-radius:8px;padding:40px 20px;text-align:center;color:#646970;border:1px solid #c3c4c7;">
            <p style="font-size:15px;font-weight:600;margin:0;"><?php esc_html_e('No student marks available for this exam.', 'exam-system-pro'); ?></p>
        </div>
    <?php endif; ?>
</div>