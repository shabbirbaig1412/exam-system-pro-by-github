<?php

defined('ABSPATH') || exit;

class ESP_BackupService {

    public function backup(): bool {

        return

            ESP_Backup::create();

    }

    public function restore(

        string $file

    ): bool {

        return

            ESP_Backup::restore(

                $file

            );

    }

}