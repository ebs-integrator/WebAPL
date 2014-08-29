<?php foreach ($groups as $group) { ?>
    <div class="com_box">
        <p class="title"><?=$group->name;?></p>
        <p class="subtitle"><?=$group->description;?></p>
        
        <?php if ($group['persons']) { ?>
        <div class="com_list">
            <p class="ul_title">
                <span class="nr">NR.</span>
                <span class="name">Nume pRENUME</span>
                <span class="fun">Functia</span>
                <span class="soc">Apartenenta politică</span>
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