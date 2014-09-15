<?php foreach ($posts as $item) { ?>
    <div class="a_box g_g">
        <p class="title"><?= $item->title; ?></p>
        <div class="hr_dbl"></div>
        <div class="left">
            <div class="img">
                <?php if (isset($item['cover']->path)) { ?>
                <img src="<?= url($item['cover']->path); ?>" width="347" />
                <?php } ?>
            </div>
            <div class="details">
                <p class="data"><?= date("d-m-Y, H:i", strtotime($item->created_at)); ?>
                    <img src='<?= res("assets/img/gr_arrow.png"); ?>' class='arrow'>
                </p>
                <p class='cont'></p>
            </div>
        </div>
        <div class="right">
            <p class="info"><?= strip_tags($item->text); ?></p>
        </div>
        <a href="<?=$page_url;?>?item=<?=$item->uri;?>" class="more"></a>
        <div class="clearfix"></div>
    </div>
<?php } ?>



<?php
if (method_exists($posts, 'links')) {
    echo $posts->links();
}
?>