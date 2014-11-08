<ul class="l_a m_t_n">
    <?php foreach ($posts as $item) { ?>
        <li>
            <a href="<?= $page_url; ?>?item=<?= $item->uri; ?>">
                <?php if (strtotime($item->created_at)) { ?>
                    <span><?= date('d-m-Y', strtotime($item->created_at)); ?> </span>
                <?php } ?>
                <p><?= $item->title; ?></p>
            </a>
        </li>
    <?php } ?>
</ul>

<?php
if (method_exists($posts, 'links')) {
    echo $posts->links();
}
?>