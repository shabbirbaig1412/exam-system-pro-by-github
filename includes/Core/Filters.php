<?php

defined('ABSPATH') || exit;

class ESP_Filters {

    public static function classDropdown(

        array $classes,

        int $selected=0

    ): void {

        ?>

        <select name="class_id">

            <option value="">All Classes</option>

            <?php foreach($classes as $class): ?>

            <option

            value="<?php echo (int)$class->id; ?>"

            <?php selected($selected,$class->id); ?>>

            <?php echo esc_html($class->class_name); ?>

            </option>

            <?php endforeach; ?>

        </select>

        <?php

    }

}