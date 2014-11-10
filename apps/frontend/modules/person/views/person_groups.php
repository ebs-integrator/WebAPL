<?php foreach ($groups as $group) { ?>
    <div class="com_box">
        <?php if (count($groups) > 1) { ?>
            <p class="title"><?= $group->name; ?></p>
        <?php } ?>
        <p class="subtitle"><?= $group->description; ?></p>

        <?php if ($group['persons']) { ?>
            <div class="com_list">
                <p class="ul_title">
                    <span class="nr"><?= varlang('nr'); ?></span>
                    <span class="name"><?= varlang('nume-prenume'); ?></span>
                    <span class="fun"><?= varlang('functia'); ?></span>
                    <span class="soc"><?= varlang('apartenenta-politica'); ?></span>
                </p>
                <ul>
                    <?php
                    $nr = 0;
                    foreach ($group['persons'] as $person) {
                        $nr++;
                        ?>
                        <li>
                            <span class="nr"><?= $nr; ?></span>
                            <span class="name"><?= $person->first_name; ?> <?= $person->last_name; ?>&nbsp;</span>
                            <span class="fun"><?= $person->function; ?>&nbsp;</span>
                            <span class="soc"><?= $person->activity; ?>&nbsp;</span>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        <?php } ?>
    </div>
<?php } ?>