<ul class="prom">
    <?php foreach ($posts as $item) { ?>
        <li>
            <a href="<?= $item['url']; ?>">
                <p class="ttl"><?= $item->title; ?></p>
                <p class="info"><?= Str::words(strip_tags(WebAPL\Shortcodes::strip($item->text)), 40); ?></p>
            </a>
        </li>
    <?php } ?>
</ul>

<div class="clearfix"></div>
