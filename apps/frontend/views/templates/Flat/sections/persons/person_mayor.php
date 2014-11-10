<?php
foreach ($groups as $group) {
    foreach ($group['persons'] as $person) {
        ?>
        <div class="bgr">
            <div class="img">
                <?php if (isset($person->path) && $person->path) { ?>
                    <img alt="<?= $person->first_name; ?> <?= $person->last_name; ?>" title="<?= $person->first_name; ?> <?= $person->last_name; ?>" src='<?= url($person->path); ?>'>
                <?php } else { ?>
                    <img alt="" src="<?= res('assets/img/nophoto.png'); ?>">
                <?php } ?>
            </div>
            <p class="subt"><?= $person->first_name; ?> <?= $person->last_name; ?></p>
            <span class="quote"><?= $person->motto; ?></span>

            <?php if ($person->for_audience) { ?>
                <button class="home_chat firechat-start <?= $person->for_audience ? 'active firechat-start-with' : ''; ?>" data-personid="<?= $person->person_id; ?>" >
                    <div class="pct">
                        <p><?= varlang('discuta'); ?> <span><?= varlang('online'); ?></span></p>
                    </div>
                </button>
            <?php } ?>
            <div class='clearfix'></div>
        </div>

        <div class="clearfix50"></div>

        <ul class="dcr">
            <?php foreach ($person->posts as $folder) { ?>
                <li><a href='javascript:;'><?= $folder->title; ?><span class="more"></span></a>
                    <div class='dcr_box'>
                        <ul>
                            <?php foreach ($folder->docs as $doc) { ?>
                                <li class="<?= $doc->extension; ?>">
                                    <a href="<?= url($doc->path); ?>"><?= $doc->name; ?> <span class="dcr_dwnl"></span></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>
        </ul>

        <div class="bgr">
            <div class='info'> 
                <ul>
                    <li>
                        <div class="left"><?= varlang('data-nasterii'); ?>:</div>
                        <div class="right"><?= $person->date_birth; ?></div>
                    </li>
                    <li>
                        <div class="left"><?= varlang('starea-civila'); ?>:</div>
                        <div class="right"><?= $person->civil_state; ?></div>
                    </li>
                    <li>
                        <div class="left"><?= varlang('studii'); ?>:</div>
                        <div class="right"><?= $person->studies; ?></div>
                    </li>
                    <li>
                        <div class="left"><?= varlang('activitate-politica'); ?>:</div>
                        <div class="right"><?= $person->activity; ?></div>
                    </li>
                    <?php
                    $fields = @unserialize($person->dynamic_fields);
                    if (is_array($fields)) {
                        foreach ($fields as $field) {
                            if ($field['lang_id'] == 0 || $field['lang_id'] == WebAPL\Language::getId()) {
                                ?>
                                <li>
                                    <div class="left"><?= $field['name']; ?></div>
                                    <div class="right list"><?= $field['value']; ?></div>
                                </li>
                                <?php
                            }
                        }
                    }
                    ?>
                </ul>
            </div>

        </div>
        <?php
    }
}
?>
