<?php
foreach ($groups as $group) {
    foreach ($group['persons'] as $person) {
        ?>
        <div class="sec_img">
            <?php if (isset($person->path) && $person->path) { ?>
                <img src='<?= url($person->path); ?>'>
            <?php } ?>
        </div>
        <ul class="sec_details">
            <li>
                <span class="sec_criteria">Nume, prenume:</span>
                <span class="crt_details"><?= $person->first_name; ?> <?= $person->last_name; ?></span>
            </li>
            <li>
                <span class="sec_criteria">Data nasterii:</span>
                <span class="crt_details"><?= $person->date_birth; ?></span>
            </li>
            <li>
                <span class="sec_criteria">Studii:</span>
                <span class="crt_details"><?= $person->studies; ?></span></li>
            <li>
                <span class="sec_criteria">Date de contact:  </span>
                <span class="crt_details">
                    <span><?= $person->phone; ?></span>
                    <span><?= $person->email; ?></span>
                </span>
            </li>
            <?php
            $fields = @unserialize($person->dynamic_fields);
            if (is_array($fields)) {
                foreach ($fields as $field) {
                    if ($field['lang_id'] == 0 || $field['lang_id'] == Core\APL\Language::getId()) {
                        ?>
                        <li>
                            <span class="sec_criteria"><?= $field['name']; ?></span>
                            <span class="crt_details"><?= $field['value']; ?></span>
                        </li>
                        <?php
                    }
                }
            }
            ?>
        </ul>
        <div class="clearfix50"></div>
        <?= $person->text; ?>
        <div class="clearfix50"></div>
        <ul class="dcr">
            <?php foreach ($person->posts as $folder) { ?>
                <li><a href='javascript:;'><?= $folder->title; ?></a>
                    <div class='dcr_box'>
                        <p class="ul_title"> <span>Nume fisier</span>Actualizat</p>
                        <ul>
                            <?php foreach ($folder->docs as $doc) { ?>
                                <li class="word">
                                    <span><?= $doc->name; ?></span>
                                    <span><?= date('d/m/Y', strtotime($doc->date_uploaded)); ?></span>
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