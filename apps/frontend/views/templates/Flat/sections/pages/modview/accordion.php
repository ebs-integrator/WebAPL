<ul class='faq'>
    <?php
    $nr = 0;
    foreach ($feedPosts as $item) {
        $nr++;
        ?>
        <li>
            <a href="javascript:;"><span><?= $nr; ?>.</span> <?= $item['title']; ?></a>
            <?= $item->text; ?>
        </li>
    <?php } ?>
</ul>