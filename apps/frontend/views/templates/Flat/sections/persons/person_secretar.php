<?php
foreach ($groups as $group) {
    foreach ($group['persons'] as $person) {
        ?>

        <div class="sec_details">
            <?php if (isset($person->path) && $person->path) { ?>
                <img alt="<?= $person->first_name; ?> <?= $person->last_name; ?>" title="<?= $person->first_name; ?> <?= $person->last_name; ?>" src='<?= url($person->path); ?>'>
            <?php } else { ?>
                <img alt="" src="<?= res('assets/img/nophoto.png'); ?>">
            <?php } ?>
            <div class="sec_label">
                <table>
                    <tr><td><?= varlang('name-last-name'); ?>:</td><td><p class="sec_name"><?= $person->first_name; ?> <?= $person->last_name; ?></p></td></tr>
                    <tr><td><?= varlang('data-nasterii'); ?>:</td><td><?= $person->date_birth; ?></td></tr>
                    <tr><td><?= varlang('studii'); ?>:</td><td><?= $person->studies; ?></td></tr>
                    <tr><td><?= varlang('contact'); ?>:  </td><td>
                            <p><?= $person->phone; ?></p>
                            <p><?= $person->email; ?></p>
                        </td>
                    </tr>
                    <?php
                    $fields = @unserialize($person->dynamic_fields);
                    if (is_array($fields)) {
                        foreach ($fields as $field) {
                            if ($field['lang_id'] == 0 || $field['lang_id'] == WebAPL\Language::getId()) {
                                ?>
                                <tr><td><?= $field['name']; ?>:</td><td><?= $field['value']; ?></td></tr>
                                <?php
                            }
                        }
                    }
                    ?>
                </table>
            </div>

        </div>

        <div class="clearfix20"></div>
        <ul class="dcr">
            <?php foreach ($person->posts as $folder) { ?>
                <li><a href='javascript:;'><?= $folder->title; ?><span class="more"></span></a>
                    <div class='dcr_box'>
                        <ul>
                            <?php foreach ($folder->docs as $doc) { ?>
                                <li class="xls">
                                    <a href="<?= url($doc->path); ?>"><?= $doc->name; ?><span class="dcr_dwnl"></span></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <div class="clearfix20"></div>
        <?= $person->text; ?>

        <?php
    }
}
?>