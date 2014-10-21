     
<ul class="culture">
    <?php foreach ($feedPosts as $item) { ?>
    <li>
        <div class="left img">
            <?php if (isset($item['cover']->path)) { ?>
            <img alt="<?=$item->title;?>" title="<?=$item->title;?>" src="<?= url($item['cover']->path); ?>" />
            <?php } ?>
        </div>
        <div class="right">
            <p><?=$item->title;?></p>
            <div class="box">
                <p><?=  isset($item->address_one) ? $item->address_one : '';?></p>
                <p><?=  isset($item->address_two) ? $item->address_two : '';?></p>
            </div>
            <div class="box">
                <p>tel: <?=  isset($item->phone_one) ? $item->phone_one : '';?></p>
                <p><?=  isset($item->phone_two) ? $item->phone_two : '';?></p>
            </div>
            <div class="box">
                <p>fax: <?=  isset($item->fax) ? $item->fax : '';?></p>
                <p>
                    <?php if (isset($item->website) && $item->website) { ?>
                    <a target="_blank" href="<?=$item->website;?>">web:  <?=$item->website;?></a>
                    <?php } ?>
                </p>
            </div>
        </div>
    </li>
    <?php } ?>
</ul>

<?php 
if (method_exists($feedPosts , 'links')) {
    echo $feedPosts->links(); 
}
?>