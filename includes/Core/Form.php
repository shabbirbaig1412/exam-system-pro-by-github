<?php

defined('ABSPATH') || exit;

class ESP_Form {

    public static function open(

        string $action,

        string $class='esp-ajax-form'

    ): void {

        ?>

        <form

        method="post"

        class="<?php echo esc_attr($class); ?>">

        <input

        type="hidden"

        name="action"

        value="<?php echo esc_attr($action); ?>">

        <?php

        ESP_Nonce::field();

    }

    public static function close(): void {

        ?>

        </form>

        <?php

    }

}