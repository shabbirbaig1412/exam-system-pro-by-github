<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin esp-reports-page">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:15px;">
        <h1 style="margin:0;">
            <span class="dashicons dashicons-analytics" style="font-size:28px;width:28px;height:28px;vertical-align:middle;margin-right:6px;color:#2271b1;"></span>
            <?php esc_html_e('Exam Reports & Analytics Hub', 'exam-system-pro'); ?>
        </h1>
    </div>

    <form method="get" class="esp-card" style="background:#fff;padding:16px 20px;border-radius:6px;border:1px solid #c3c4c7;margin-bottom:20px;">
        <input type="hidden" name="page" value="esp-reports">
        <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
            <label for="esp-report-exam" style="font-weight:600;font-size:14px;"><?php esc_html_e('Select Exam:', 'exam-system-pro'); ?></label>
            <select id="esp-report-exam" name="exam_id" required style="min-width:280px;height:36px;">
                <option value=""><?php esc_html_e('-- Choose Exam to Generate Reports --', 'exam-system-pro'); ?></option>
                <?php foreach ($exams as $exam): ?>
                    <option value="<?php echo esc_attr($exam['id']); ?>" <?php selected(absint($_GET['exam_id'] ?? 0), $exam['id']); ?>>
                        <?php echo esc_html($exam['exam_name']); ?><?php if (!empty($exam['class_name'])): ?> (<?php echo esc_html($exam['class_name']); ?>)<?php endif; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button class="button button-primary button-large" style="display:inline-flex;align-items:center;gap:5px;">
                <span class="dashicons dashicons-dashboard" style="font-size:16px;width:16px;height:16px;"></span>
                <?php esc_html_e('Open Report Hub', 'exam-system-pro'); ?>
            </button>
        </div>
    </form>

    <?php $exam_id = absint($_GET['exam_id'] ?? 0); if ($exam_id): ?>
        <?php
        $reports_list = [
            'class-summary' => [
                'title' => __('Class Summary', 'exam-system-pro'),
                'desc' => __('Overall pass/fail ratios, total students, average, and highest score.', 'exam-system-pro'),
                'icon' => 'dashicons-chart-pie',
                'color' => '#2271b1'
            ],
            'all-classes-summary' => [
                'title' => __('All Classes Summary', 'exam-system-pro'),
                'desc' => __('Class-wise performance overview showing appeared, absents, pass percentage, and average grade.', 'exam-system-pro'),
                'icon' => 'dashicons-chart-pie',
                'color' => '#2271b1'
            ],
            'merit-list' => [
                'title' => __('Merit List & Top Ranks', 'exam-system-pro'),
                'desc' => __('Ranked student leaderboard sorted by percentage and position.', 'exam-system-pro'),
                'icon' => 'dashicons-awards',
                'color' => '#d63638'
            ],
            'report-card' => [
                'title' => __('Student Report Cards', 'exam-system-pro'),
                'desc' => __('Individual printable progress report cards for each student.', 'exam-system-pro'),
                'icon' => 'dashicons-id-alt',
                'color' => '#135e2b'
            ],
            'statistics' => [
                'title' => __('Detailed Statistics', 'exam-system-pro'),
                'desc' => __('Grade distribution, highest/lowest marks, and average metrics.', 'exam-system-pro'),
                'icon' => 'dashicons-chart-bar',
                'color' => '#8c5e00'
            ],
            'class-result' => [
                'title' => __('Class Tabulation Sheet', 'exam-system-pro'),
                'desc' => __('Full comprehensive result sheet showing all students and grades.', 'exam-system-pro'),
                'icon' => 'dashicons-list-view',
                'color' => '#4f3494'
            ],
            'subject-summary' => [
                'title' => __('Subject-Wise Summary', 'exam-system-pro'),
                'desc' => __('Subject averages, max/min marks, and enrolled student counts.', 'exam-system-pro'),
                'icon' => 'dashicons-book-alt',
                'color' => '#007074'
            ],
            'teacher-summary' => [
                'title' => __('Teacher Allocations', 'exam-system-pro'),
                'desc' => __('Teacher allocated subject and class workload breakdown.', 'exam-system-pro'),
                'icon' => 'dashicons-businessperson',
                'color' => '#1d2327'
            ],
            'failed-students' => [
                'title' => __('Failed Students Report', 'exam-system-pro'),
                'desc' => __('Filtered list of students requiring remedial attention or re-exam.', 'exam-system-pro'),
                'icon' => 'dashicons-warning',
                'color' => '#b32d2e'
            ],
        ];
        ?>

        <h2 style="font-size:16px;font-weight:700;margin:20px 0 12px 0;color:#1d2327;">
            <?php esc_html_e('Available Reports for Selected Exam', 'exam-system-pro'); ?>
        </h2>

        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(270px, 1fr));gap:16px;margin-bottom:25px;">
            <?php foreach ($reports_list as $key => $info): ?>
                <a href="<?php echo esc_url(add_query_arg(['page' => 'esp-reports', 'exam_id' => $exam_id, 'report' => $key], admin_url('admin.php'))); ?>" 
                   class="esp-card esp-report-tile" 
                   style="background:#fff;border-radius:8px;padding:18px;border:1px solid #c3c4c7;text-decoration:none;display:flex;flex-direction:column;gap:8px;box-shadow:0 1px 3px rgba(0,0,0,0.04);transition:transform 0.15s ease, box-shadow 0.15s ease;">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <span class="dashicons <?php echo esc_attr($info['icon']); ?>" style="font-size:24px;width:24px;height:24px;color:<?php echo esc_attr($info['color']); ?>;"></span>
                        <strong style="font-size:15px;color:#1d2327;"><?php echo esc_html($info['title']); ?></strong>
                    </div>
                    <p style="margin:0;color:#646970;font-size:13px;line-height:1.4;">
                        <?php echo esc_html($info['desc']); ?>
                    </p>
                    <span style="margin-top:auto;font-size:12px;font-weight:600;color:#2271b1;display:inline-flex;align-items:center;gap:4px;">
                        <?php esc_html_e('View Report', 'exam-system-pro'); ?> &rarr;
                    </span>
                </a>
            <?php endforeach; ?>
        </div>

        <?php
        $results = (new ESP_ResultRepository())->exam_results($exam_id);
        if (!empty($results)): ?>
            <div class="esp-card" style="background:#fff;border-radius:8px;padding:0;overflow:hidden;border:1px solid #c3c4c7;">
                <div style="padding:14px 18px;background:#f6f7f7;border-bottom:1px solid #c3c4c7;display:flex;justify-content:space-between;align-items:center;">
                    <strong style="font-size:14px;color:#1d2327;"><?php esc_html_e('Quick Exam Overview', 'exam-system-pro'); ?></strong>
                    <span style="font-size:12px;color:#646970;"><?php printf(esc_html__('Total Students: %d', 'exam-system-pro'), count($results)); ?></span>
                </div>
                <table class="widefat striped esp-admin-table" style="border:none;margin:0;">
                    <thead>
                        <tr style="background:#f0f0f1;">
                            <th style="width:70px;font-weight:700;text-align:center;"><?php esc_html_e('Rank', 'exam-system-pro'); ?></th>
                            <th style="width:90px;font-weight:700;"><?php esc_html_e('Roll No.', 'exam-system-pro'); ?></th>
                            <th style="font-weight:700;"><?php esc_html_e('Student Name', 'exam-system-pro'); ?></th>
                            <th style="width:110px;text-align:right;font-weight:700;"><?php esc_html_e('Obtained', 'exam-system-pro'); ?></th>
                            <th style="width:100px;text-align:right;font-weight:700;"><?php esc_html_e('Percentage', 'exam-system-pro'); ?></th>
                            <th style="width:80px;text-align:center;font-weight:700;"><?php esc_html_e('Grade', 'exam-system-pro'); ?></th>
                            <th style="width:100px;text-align:center;font-weight:700;"><?php esc_html_e('Status', 'exam-system-pro'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach (array_slice($results, 0, 10) as $row): 
                        $status_str = strtoupper($row->status ?? '');
                        $is_pass = ($status_str === 'PASS');
                    ?>
                        <tr>
                            <td style="text-align:center;font-weight:700;color:#2271b1;">#<?php echo esc_html($row->position ?: '—'); ?></td>
                            <td style="font-weight:600;"><?php echo esc_html($row->roll_no ?: ('#' . $row->student_id)); ?></td>
                            <td style="font-weight:600;color:#1d2327;"><?php echo esc_html($row->student_name ?? ('Student #' . $row->student_id)); ?></td>
                            <td style="text-align:right;font-weight:700;"><?php echo esc_html((float)$row->obtained_marks); ?></td>
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
    <?php endif; ?>
</div>

