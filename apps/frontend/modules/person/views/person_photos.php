<?php
foreach ($groups as $group) {
    foreach ($group['persons'] as $person) {
        ?>
        <div class='personal'>
            <div class='img'>
                <?php if (isset($person->path) && $person->path) { ?>
                <img src='<?= url($person->path); ?>'>
                <?php } ?>
            </div>
            <div class="left">
                <p class='name'><?=$person->first_name;?></p>
                <p class="name"><?=$person->last_name;?></p>
                <p class='function'><?=$person->function;?></p>
            </div>
        </div>
        <?php
    }
}
?>
<div class="clearfix"></div>
