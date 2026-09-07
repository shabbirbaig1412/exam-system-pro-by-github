<?php

defined('ABSPATH') || exit;

class ESP_AdminRecordForm {

    public static function records_toolbar(string $entity, string $label): void {
        echo '<div class="esp-saved-toolbar"><h2>' . esc_html($label) . ' <span class="esp-record-count" data-count-for="' . esc_attr($entity) . '"></span></h2><label class="screen-reader-text" for="esp-search-' . esc_attr($entity) . '">' . esc_html__('Search saved records', 'exam-system-pro') . '</label><input type="search" id="esp-search-' . esc_attr($entity) . '" class="esp-record-search" data-record-search="' . esc_attr($entity) . '" placeholder="' . esc_attr__('Search saved records…', 'exam-system-pro') . '"></div>';
    }

    public static function saved_table(string $entity, array $rows, array $columns): void {
        $pages = ['classes'=>'esp-classes','teachers'=>'esp-teachers','students'=>'esp-students','subjects'=>'esp-subjects','exams'=>'esp-exams','exam_schedules'=>'esp-exam-schedules','allocations'=>'esp-allocations'];
        echo '<table class="widefat striped esp-admin-table esp-saved-data-table"><thead><tr>';
        foreach ($columns as $key => $label) echo '<th>' . esc_html($label) . '</th>';
        echo '<th>' . esc_html__('Actions', 'exam-system-pro') . '</th></tr></thead><tbody>';
        foreach ($rows as $row) {
            $row = is_object($row) ? get_object_vars($row) : (array) $row;
            echo '<tr>';
            foreach ($columns as $key => $label) {
                $value = $row[$key] ?? '';
                if (in_array($key, ['status', 'is_active'], true)) $value = !empty($value) ? __('Active', 'exam-system-pro') : __('Inactive', 'exam-system-pro');
                echo '<td>' . esc_html((string) $value) . '</td>';
            }
            $id = absint($row['id'] ?? 0);
            echo '<td><a class="button button-small" href="' . esc_url(add_query_arg(['page' => $pages[$entity] ?? '', 'edit_id' => $id], admin_url('admin.php'))) . '">' . esc_html__('Edit', 'exam-system-pro') . '</a> ';
            self::delete_form($entity, $id);
            echo '</td></tr>';
        }
        if (!$rows) echo '<tr><td colspan="' . esc_attr(count($columns) + 1) . '">' . esc_html__('No saved records found.', 'exam-system-pro') . '</td></tr>';
        echo '</tbody></table>';
    }

    public static function render(string $entity, array $fields): void {

        $id = absint($_GET['edit_id'] ?? 0);
        $record = [];
        $definitions = ESP_AdminRecordHandler::definitions();

        if ($id && isset($definitions[$entity])) {
            global $wpdb;
            $where = ' WHERE id=%d';
            $args = [$id];
            if (in_array($entity, ['classes', 'teachers', 'students', 'subjects', 'exams', 'exam_schedules', 'marks', 'allocations'], true)) {
                $where .= ' AND campus_id=%d';
                $args[] = ESP_CampusContext::id();
            }
            $record = (array) $wpdb->get_row($wpdb->prepare(
                'SELECT * FROM ' . $wpdb->prefix . $definitions[$entity]['table'] . $where,
                ...$args
            ));
        }

        $status = sanitize_key($_GET['esp_status'] ?? '');
        if ($status === 'updated' || $status === 'deleted') {
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('records updated successfully', 'exam-system-pro') . '</p></div>';
        } elseif ($status === 'error') {
            $error = sanitize_text_field(wp_unslash($_GET['esp_error'] ?? ''));
            echo '<div class="notice notice-error"><p>' . esc_html__('The record could not be saved.', 'exam-system-pro') . ' ' . esc_html($error) . '</p></div>';
        }
        ?>
        <form id="esp-record-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="esp-record-form esp-card">
            <h2><?php echo esc_html($id ? __('Edit record', 'exam-system-pro') : __('Add record', 'exam-system-pro')); ?></h2>
            <input type="hidden" name="action" value="esp_save_record">
            <input type="hidden" name="entity" value="<?php echo esc_attr($entity); ?>">
            <input type="hidden" name="id" value="<?php echo esc_attr($id); ?>">
            <?php wp_nonce_field('esp_admin_record'); ?>
            <?php foreach ($fields as $name => $label):
                $value = $record[$name] ?? '';
                $type = in_array($name, ['start_date', 'end_date', 'exam_date'], true) ? 'date' : 'text';
                if (in_array($name, ['id', 'class_id', 'session_id', 'exam_id', 'student_id', 'subject_id', 'teacher_id', 'sort_order', 'is_active', 'status'], true)) {
                    $type = 'number';
                }
                $required = in_array($name, ['name', 'session_name', 'class_name', 'teacher_name', 'student_name', 'subject_name', 'exam_name', 'class_id', 'subject_id', 'teacher_id'], true);
                $is_textarea = in_array($name, ['address', 'remarks'], true);
                $is_gender = $name === 'gender';
                $options = self::options($name);
                ?>
                <p>
                    <label for="esp-<?php echo esc_attr($entity . '-' . $name); ?>"><strong><?php echo esc_html($label); ?></strong><?php if ($required): ?> <span aria-hidden="true" class="esp-required">*</span><?php endif; ?></label><br>
                    <?php if ($is_gender): ?>
                        <label style="display:inline-block;margin-right:20px;">
                            <input type="radio" name="<?php echo esc_attr($name); ?>" value="Male" <?php checked($value, 'Male'); ?>> 
                            <?php echo esc_html(__('Male', 'exam-system-pro')); ?>
                        </label>
                        <label style="display:inline-block;">
                            <input type="radio" name="<?php echo esc_attr($name); ?>" value="Female" <?php checked($value, 'Female'); ?>> 
                            <?php echo esc_html(__('Female', 'exam-system-pro')); ?>
                        </label>
                    <?php elseif ($options): ?><select id="esp-<?php echo esc_attr($entity . '-' . $name); ?>" name="<?php echo esc_attr($name); ?>" <?php echo $required ? 'required' : ''; ?>><option value=""><?php esc_html_e('Select an option', 'exam-system-pro'); ?></option><?php foreach ($options as $option): ?><option value="<?php echo esc_attr($option['id']); ?>" <?php selected($value, $option['id']); ?>><?php echo esc_html($option['label']); ?></option><?php endforeach; ?></select>
                    <?php elseif ($is_textarea): ?><textarea id="esp-<?php echo esc_attr($entity . '-' . $name); ?>" class="large-text" rows="3" name="<?php echo esc_attr($name); ?>" <?php echo $required ? 'required' : ''; ?>><?php echo esc_textarea($value); ?></textarea>
                    <?php else: ?><input id="esp-<?php echo esc_attr($entity . '-' . $name); ?>" class="regular-text" type="<?php echo esc_attr($type); ?>" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value); ?>" <?php echo $required ? 'required' : ''; ?> <?php echo in_array($name, ['email'], true) ? 'autocomplete="email"' : ''; ?> <?php echo $name === 'status' || $name === 'is_active' ? 'min="0" max="1"' : ''; ?>><?php endif; ?>
                </p>
            <?php endforeach; ?>
            <?php submit_button($id ? __('Update record', 'exam-system-pro') : __('Save record', 'exam-system-pro'), 'primary', 'submit', false); ?>
            <?php if ($id): ?>
                <a class="button" href="<?php echo esc_url(remove_query_arg('edit_id')); ?>"><?php esc_html_e('Cancel edit', 'exam-system-pro'); ?></a>
            <?php endif; ?>
        </form>
        <?php
    }

    public static function delete_form(string $entity, int $id): void {
        ?>
        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="esp-inline-form">
            <input type="hidden" name="action" value="esp_delete_record">
            <input type="hidden" name="entity" value="<?php echo esc_attr($entity); ?>">
            <input type="hidden" name="id" value="<?php echo esc_attr($id); ?>">
            <?php wp_nonce_field('esp_admin_record'); ?>
            <button type="submit" class="button-link-delete" onclick="return confirm('<?php echo esc_js(__('Delete this record?', 'exam-system-pro')); ?>');"><?php esc_html_e('Delete', 'exam-system-pro'); ?></button>
        </form>
        <?php
    }

    private static function options(string $field): array {
        global $wpdb;
        $map = [
            'class_id' => ['esp_classes', 'class_name'],
            'session_id' => ['esp_sessions', 'session_name'],
            'exam_id' => ['esp_exams', 'exam_name'],
            'subject_id' => ['esp_subjects', 'subject_name'],
            'teacher_id' => ['esp_teachers', 'teacher_name'],
            'student_id' => ['esp_students', 'student_name'],
        ];
        if (!isset($map[$field])) return [];
        [$table, $label] = $map[$field];
        $where = in_array($field, ['class_id', 'exam_id', 'subject_id', 'teacher_id', 'student_id'], true) ? $wpdb->prepare(' WHERE campus_id=%d', ESP_CampusContext::id()) : '';
        $rows = $wpdb->get_results("SELECT id, {$label} FROM {$wpdb->prefix}{$table}{$where} ORDER BY {$label}", ARRAY_A);
        return array_map(static fn($row) => ['id' => $row['id'], 'label' => $row[$label]], $rows ?: []);
    }
}
