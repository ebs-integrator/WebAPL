
<?php if ($list) { ?>
<?php foreach ($list as $item) {
        if ($item->status == 1) {?>
    <div class="partners-img">

        <?php

            $url = $item->name;
            if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
                $url3 = $url;
            } else {
                $url3 = "";
            }
            if ($url3) {
                ?>
                <a target="_blank" href="<?= url($url3) ?>">
            <?php } else { ?><a><?php } ?>
            <img src="<?= url($item->path); ?>">
            </a>
        </div>
        <?php } ?>
    <?php } ?>
<?php } ?>
