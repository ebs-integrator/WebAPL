<ul class="prom">
    <?php foreach ($posts as $item) { ?>
    <li>
        <p class="ttl"><?=$item->title;?></p>
        <p class="info"><?= Str::words(strip_tags(WebAPL\Shortcodes::strip($item->text)), 40);?></p>
        <a href="<?=$page_url;?>?item=<?=$item['uri'];?>"></a>
    </li>
    <?php } ?>
</ul>

<div class="clearfix"></div>


<?php
if (method_exists($posts, 'links')) {
    echo $posts->links();
}
?>