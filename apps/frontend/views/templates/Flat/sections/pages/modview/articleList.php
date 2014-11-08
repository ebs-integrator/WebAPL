<?php foreach ($posts as $item) { ?>
    <div class="a_box">
        <p class="title"><a href="<?= $page_url; ?>?item=<?= $item->uri; ?>"><?= $item->title; ?></a></p>
        <?php if (strtotime($item->created_at)) { ?>
            <p class="data"><?= date("d-m-Y, H:i", strtotime($item->created_at)); ?></p>
        <?php } ?>
        <div class="hr_dbl"></div>
        <div class="left">
            <div class="img">
                <?php if ($item->cover) { ?>
                    <img title="<?= $item->title; ?>" alt="<?= $item->title; ?>" src="<?= url($item->cover['path']); ?>" width="347">
                <?php } ?>
            </div>

        </div>
        <div class="right">
            <p class="info"><?= Str::words(strip_tags($item->text), 55); ?></p>
        </div>
        <a href="<?= $page_url; ?>?item=<?= $item->uri; ?>" class="more"></a>
        <div class="clearfix"></div>
    </div>
<?php } ?>



<?php
if (method_exists($posts, 'links')) {
    echo $posts->links();
}
?>