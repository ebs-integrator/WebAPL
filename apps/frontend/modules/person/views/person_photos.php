<?php
foreach ($groups as $group) {
    foreach ($group['persons'] as $person) {
        ?>
        <div class='personal'>
            <div class='img'>
                <?php if (isset($person->path) && $person->path) { ?>
                    <img alt="<?= $person->first_name; ?> <?= $person->last_name; ?>" title="<?= $person->first_name; ?> <?= $person->last_name; ?>" src='<?= url($person->path); ?>'>
                <?php } else { ?>
                    <img alt="" src="<?= res('assets/img/nophoto.png'); ?>">
                <?php } ?>
            </div>
            <div class="left">
                <p class='name'><?= $person->first_name; ?></p>
                <p class="name"><?= $person->last_name; ?></p>
                <p class='function'><?= $person->function; ?></p>
                <p class="descr"><?= strip_tags($person->text); ?></p>
            </div>
        </div>
        <?php
    }
}
?>
<div class="clearfix"></div>
