<?php
foreach ($groups as $group) {
    foreach ($group['persons'] as $person) {
        ?>
        <div class="bgr">
            <div class="img">
                <?php if (isset($person->path) && $person->path) { ?>
                    <img src='<?= url($person->path); ?>'>
                <?php } ?>
            </div>
            <p class="vp_name"><?= $person->first_name; ?> <?= $person->last_name; ?></p>
            <span class='quote'><?= $person->motto; ?></span>
            <button class="vice_button">
                <span class="green">Chat</span><span class="violet">-online</span>
                <span class="g_dot"></span>
            </button>
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
        <ul class="dcr">
            <?php foreach ($person->posts as $folder) { ?>
                <li><a href='javascript:;'><?= $folder->title; ?><span class="more"></span></a>
                    <div class='dcr_box'>
                        <ul>
                            <?php foreach ($folder->docs as $doc) { ?>
                            <li class="<?=$doc->extension;?>">
                                <span><a href="<?=url($doc->path);?>"><?= $doc->name; ?></a></span>
                                <a href="<?=url($doc->path);?>" class="dcr_dwnl"></a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <?php
    }
}
?>