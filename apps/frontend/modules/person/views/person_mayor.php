<?php
foreach ($groups as $group) {
    foreach ($group['persons'] as $person) {
        ?>
        <div class="bgr">
            <div class="img">
                <?php if (isset($person->path) && $person->path) { ?>
                    <img src='<?= url($person->path); ?>'>
                <?php } ?>
                <p class="nm_prim"><?= $person->first_name; ?> <?= $person->last_name; ?></p>
            </div>
            <span class='quote'><?= $person->motto; ?></span>
            <div class='clearfix'></div>
        </div>
        <div class="bgr">
            <div class='info'> 
                <ul>
                    <li>
                        <div class="left">Data nasterii:</div>
                        <div class="right"><?= $person->date_birth; ?></div>
                    </li>
                    <li>
                        <div class="left">Starea civila:</div>
                        <div class="right"><?= $person->civil_state; ?></div>
                    </li>
                    <li>
                        <div class="left">Studii:</div>
                        <div class="right"><?= $person->studies; ?></div>
                    </li>
                    <li>
                        <div class="left">Activitate politica</div>
                        <div class="right"><?= $person->activity; ?></div>
                    </li>
                    <?php
                    $fields = @unserialize($person->dynamic_fields);
                    if (is_array($fields)) {
                        foreach ($fields as $field) {
                            if ($field['lang_id'] == 0 || $field['lang_id'] == Core\APL\Language::getId()) {
                            ?>
                            <li>
                                <div class="left"><?=$field['name'];?></div>
                                <div class="right list"><?=$field['value'];?></div>
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