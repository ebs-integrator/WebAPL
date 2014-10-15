
<?php if ($colevels) { ?>
    <ul class='right_menu'>
        <?php
        foreach ($colevels as $item) {
            if ($active_page_id != $item['id']) {
                ?>
                <li class="<?= in_array('hide_on_mobile', $item['properties']) ? 'hide_on_mobile' : ''; ?>"><a href='<?= $item['url']; ?>'><?= $item['title']; ?></a></li>
                <?php
            }
        }
        ?>
    </ul>
<?php } ?>