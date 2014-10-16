<?php foreach ($groups as $group) { ?>
    <div class="com_box">
        <p class="title"><?= $group->name; ?></p>
        <hr>
        <p class="subtitle"></p>
        <span><?= $group->description; ?></span>
        <?php if ($group['persons']) { ?>
            <table class="com_table">
                <thead>
                    <tr><td><?= varlang('nr'); ?></td><td><?= varlang('nume-prenume'); ?></td><td><?= varlang('functia'); ?></td><td><?= varlang('apartenenta-politica'); ?></td></tr>
                </thead>
                <tbody>
                    <?php
                    $nr = 0;
                    foreach ($group['persons'] as $person) {
                        $nr++;
                        ?>
                        <tr><td><?= $nr; ?></td><td><?= $person->first_name; ?> <?= $person->last_name; ?>&nbsp;</td><td><?= $person->function; ?>&nbsp;</td><td><?= $person->activity; ?>&nbsp;</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
<?php } ?>