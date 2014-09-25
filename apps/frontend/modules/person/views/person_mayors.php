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
                    <p class="name"><?=$person->first_name;?></p>
                    <p class="p_name"><?=$person->last_name;?></p>
                    <p class="tel"><?=$person->phone;?></p>
                    <p class="email"><a href="mailto:<?=$person->email;?>" target="_blank"><?=$person->email;?></a></p>
                    <button class="chat_button <?=$person->for_audience? 'active firechat-start-with':'';?>" data-personid="<?=$person->person_id;?>">
                        <span class="green">Chat</span><span class="violet">-online</span>
                        <span class="g_dot"></span>
                    </button>
                </div>
            </li>
            <?php
        }
    }
    ?>
</ul>