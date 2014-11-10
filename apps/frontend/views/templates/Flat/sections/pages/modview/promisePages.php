<?php foreach ($posts as $item) { ?>
    <nav>
        <a href="<?= $item['url']; ?>">
            <p><?= $item->title; ?></p>
            <span><?= Str::words(strip_tags(WebAPL\Shortcodes::strip($item->text)), 40); ?></span>
            <div class="more"></div>
        </a>
    </nav>
<?php } ?>
<div class="clearfix"></div>
