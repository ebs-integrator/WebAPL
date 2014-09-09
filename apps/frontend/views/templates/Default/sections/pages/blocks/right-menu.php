
<?php if ($colevels) { ?>
    <ul class='right_menu'>
        <?php foreach ($colevels as $item) { ?>
            <li class='<?= $active_page_id == $item['id'] ? 'active' : ''; ?>'><a href='<?= $item['url']; ?>'><?= $item['title']; ?></a></li>
        <?php } ?>
    </ul>
<?php } ?>