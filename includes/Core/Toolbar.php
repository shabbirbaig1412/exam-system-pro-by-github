<?php

defined('ABSPATH') || exit;

class ESP_Toolbar {

    public static function search(): void {

        ?>

        <input

        type="search"

        id="esp-search"

        placeholder="Search...">

        <?php

    }

    public static function addButton(

        string $label,

        string $id='esp-add'

    ): void {

        ?>

        <button

        id="<?php echo esc_attr($id); ?>"

        class="button button-primary">

        <?php echo esc_html($label); ?>

        </button>

        <?php

    }

}