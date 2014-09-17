<div class='map_cont'>
    <?php foreach ($tree as $item) { ?>
    <p class='map_sub'><?=$item->title;?></p>
    <ul class='h_list'>
        <?php foreach ($item['list'] as $sitem) { ?>
        <li>
            <p><a href='javascript:;'><?=$sitem->title;?></a></p>
            <ul>
                <?php foreach ($sitem['list'] as $titem) { ?>
                <li><a href='javascript:;'><?=$titem->title;?></a></li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
    </ul>
    <?php } ?>
</div>