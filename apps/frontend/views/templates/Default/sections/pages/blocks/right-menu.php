
<?php if ($colevels) { ?>
    <ul class='right_menu'>
        <?php
        foreach ($colevels as $item) {
            if ($active_page_id != $item['id']) {
                ?>
                <li class="<?= in_array('hide_on_mobile', $item['properties']) ? 'hide_on_mobile' : ''; ?> <?= in_array('start-chat', $item['properties']) ? 'firechat-start' : ''; ?>"><a href='<?= $item['url']; ?>'><?= $item['title']; ?></a></li>
                <?php
            }
        }
        ?>
    </ul>
<?php } ?>