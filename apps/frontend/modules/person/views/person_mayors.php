<ul class="vice">
    <?php
    foreach ($groups as $group) {
        foreach ($group['persons'] as $person) {
            ?>
            <li>
                <div class="img">
                    <?php if (isset($person->path) && $person->path) { ?>
                        <img width="210" src='<?= url($person->path); ?>'>
                    <?php } ?>
                </div>
                <div class="left">
                    <p class="name"><?= $person->first_name; ?></p>
                    <p class="p_name"><?= $person->last_name; ?></p>
                    <p class="tel"><?= $person->phone; ?></p>
                    <p class="email"><a href="mailto:<?= $person->email; ?>" target="_blank"><?= $person->email; ?></a></p>
                    <button class="home_chat firechat-start <?= $person->for_audience ? 'active firechat-start-with' : ''; ?>" data-personid="<?= $person->person_id; ?>">
                        <div class="pot"></div>
                        <div class="pct">
                            <p><?= varlang('discuta'); ?> <span><?= varlang('online'); ?></span></p>
                            <span><?= $person->for_audience ? varlang('online') : varlang('offline'); ?></span>
                        </div>
                    </button>
                </div>
            </li>
            <?php
        }
    }
    ?>
</ul>