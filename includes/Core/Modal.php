<?php

defined('ABSPATH') || exit;

class ESP_Modal {

    public static function open(

        string $id,

        string $title

    ): void {

        ?>

        <div

        id="<?php echo esc_attr($id); ?>"

        class="esp-modal"

        style="display:none;">

            <div class="esp-modal-content">

                <div class="esp-modal-header">

                    <h2>

                        <?php echo esc_html($title); ?>

                    </h2>

                    <span

                    class="esp-modal-close">

                    &times;

                    </span>

                </div>

                <div class="esp-modal-body">

        <?php

    }

    public static function close(): void {

        ?>

                </div>

            </div>

        </div>

        <?php

    }

}