<?php
foreach ($groups as $group) {
    foreach ($group['persons'] as $person) {
        ?>
        <div class="sec_img">
            <?php if (isset($person->path) && $person->path) { ?>
                <img src='<?= url($person->path); ?>'>
            <?php } else { ?>
                <img alt="" src="<?= res('assets/img/nophoto.png'); ?>">
            <?php } ?>
        </div>
        <ul class="sec_details">
            <li>
                <span class="sec_criteria"><?= varlang('name-last-name'); ?>:</span>
                <span class="crt_details"><?= $person->first_name; ?> <?= $person->last_name; ?></span>
            </li>
            <li>
                <span class="sec_criteria"><?= varlang('data-nasterii'); ?>:</span>
                <span class="crt_details"><?= $person->date_birth; ?></span>
            </li>
            <li>
                <span class="sec_criteria"><?= varlang('studii'); ?>:</span>
                <span class="crt_details"><?= $person->studies; ?></span></li>
            <li>
                <span class="sec_criteria"><?= varlang('contact'); ?>:  </span>
                <span class="crt_details">
                    <span><?= $person->phone; ?></span>
                    <span><?= $person->email; ?></span>
                </span>
            </li>
            <?php
            $fields = @unserialize($person->dynamic_fields);
            if (is_array($fields)) {
                foreach ($fields as $field) {
                    if ($field['lang_id'] == 0 || $field['lang_id'] == WebAPL\Language::getId()) {
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
                <li><a href='javascript:;'><?= $folder->title; ?><span class="more"></span></a>
                    <div class='dcr_box'>
                        <ul>
                            <?php foreach ($folder->docs as $doc) { ?>
                                <li class="<?= $doc->extension; ?>">
                                    <span><a href="<?= url($doc->path); ?>"><?= $doc->name; ?></a></span>
                                    <a href="<?= url($doc->path); ?>" class="dcr_dwnl"></a>
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