<?php

defined('ABSPATH') || exit;

class ESP_CampusSelector {

    public static function render(

        array $campuses,

        int $selected

    ): void {

?>

<select id="esp-campus-selector">

<?php foreach($campuses as $campus): ?>

<option

value="<?=$campus['id']?>"

<?=$selected==$campus['id']?'selected':''?>>

<?=esc_html($campus['name'])?>

</option>

<?php endforeach; ?>

</select>

<?php

    }

}