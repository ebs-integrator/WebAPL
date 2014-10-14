<ul class="prom">
    <?php foreach ($posts as $item) { ?>
    <li>
        <p class="ttl"><?=$item->title;?></p>
        <p class="info"><?=  strip_tags($item->text);?></p>
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