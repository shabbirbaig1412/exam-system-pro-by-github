<?php defined('ABSPATH') || exit; ?>

<?php if (empty($rows)): ?>
    <tr class="esp-empty-row">
        <td colspan="7" style="text-align:center;padding:35px 20px;color:#646970;">
            <span class="dashicons dashicons-info" style="font-size:26px;width:26px;height:26px;color:#2271b1;vertical-align:middle;margin-right:6px;"></span>
            <span style="font-size:14px;font-weight:600;"><?php esc_html_e('No active students found in this class for the current academic session.', 'exam-system-pro'); ?></span>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($rows as $index => $row): 
        $val = $row['obtained'];
        $max = (float)($row['total_marks'] ?? 100);
        $passing = (float)($row['passing_marks'] ?? 40);
        $num_val = is_numeric($val) ? (float)$val : null;
        $status_text = '—';
        $status_class = 'esp-status-pending';
        if ($num_val !== null && $val !== '') {
            if ($num_val >= $passing) {
                $status_text = __('PASS', 'exam-system-pro');
                $status_class = 'esp-status-pass';
            } else {
                $status_text = __('FAIL', 'exam-system-pro');
                $status_class = 'esp-status-fail';
            }
        }
    ?>
        <tr data-student="<?php echo esc_attr($row['student_id']); ?>" data-row-index="<?php echo esc_attr($index); ?>">
            <td class="esp-col-roll" style="font-weight:700;color:#1d2327;">
                <?php echo esc_html($row['roll_no'] ?: '—'); ?>
            </td>
            <td class="esp-col-admission" style="color:#50575e;">
                <?php echo esc_html($row['admission_no'] ?? '—'); ?>
            </td>
            <td class="esp-col-name" style="font-weight:600;color:#1d2327;">
                <?php echo esc_html($row['student_name']); ?>
            </td>
            <td class="esp-col-mark">
                <input type="number" 
                       step="any" 
                       min="0" 
                       max="<?php echo esc_attr($max); ?>" 
                       class="esp-mark regular-text" 
                       style="width:110px;font-weight:700;font-size:14px;padding:4px 8px;text-align:right;"
                       data-subject="<?php echo esc_attr($row['subject_id']); ?>" 
                       data-max="<?php echo esc_attr($max); ?>" 
                       data-passing="<?php echo esc_attr($passing); ?>"
                       value="<?php echo esc_attr($val !== '' && $val !== null ? $val : ''); ?>"
                       placeholder="0"
                       <?php echo !empty($is_locked) ? 'disabled' : ''; ?>>
            </td>
            <td class="esp-col-max" style="color:#50575e;font-weight:600;">
                <?php echo esc_html($max); ?>
            </td>
            <td class="esp-col-status">
                <span class="esp-row-status <?php echo esc_attr($status_class); ?>" style="display:inline-block;padding:2px 8px;border-radius:10px;font-size:11px;font-weight:700;">
                    <?php echo esc_html($status_text); ?>
                </span>
            </td>
            <td class="esp-col-remarks">
                <input type="text" 
                       class="esp-remark regular-text" 
                       style="width:100%;max-width:260px;padding:4px 8px;font-size:13px;"
                       value="<?php echo esc_attr($row['remarks'] ?? ''); ?>" 
                       placeholder="<?php esc_attr_e('Optional remarks', 'exam-system-pro'); ?>"
                       <?php echo !empty($is_locked) ? 'disabled' : ''; ?>>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>

