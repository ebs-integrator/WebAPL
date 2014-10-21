<div class='left city'>
    <?php foreach ($feedPosts as $item) { ?>
        <div class='city_box'>
            <div class='img'>
                <?php if (isset($item['cover']->path)) { ?>
                    <img alt="<?= $item->title; ?>" title="<?= $item->title; ?>" src="<?= url($item['cover']->path); ?>" />
                <?php } ?>
            </div>
            <div class='city_info'>
                <p class="title"><?= $item->title; ?></p>
                <p class='info'><?= $item->address_one; ?></p>
            </div>
            <p class="city_link"><a href="<?= $item->website; ?>"><?= $item->website; ?></a></p>
        </div>
    <?php } ?>
    <div class="clearfix"></div>
</div>

<?php
if (method_exists($feedPosts, 'links')) {
    echo $feedPosts->links();
}
?>