<div class="dirs_menu">
    <div class="wrap">
        <?php
        $breadcrumbs = Core\APL\Template::getBreadCrumbs();
        ?>
        <?php foreach ($breadcrumbs as $k => $item) { ?>
            <?php
            $current = $k == (count($breadcrumbs) - 1);
            ?>
            <a href="<?= $item['url']; ?>#hm">
                <?php if ($current) { ?>
                    <span><?= $item['name']; ?></span>
                <?php } else { ?>
                    <?= $item['name']; ?> » 
                <?php } ?>
            </a>
        <?php } ?>
    </div>
</div>