<?php if (isset($posts)) { ?>
    <?php foreach ($posts as $item) { ?>
        <div class="a_box g_g">
            <p class="title"><a href="<?= $page_url; ?>?item=<?= $item->uri; ?>"><?= $item->title ? $item->title : varlang('sedinta-din-data-de-') . date("d-m-Y", strtotime($item->created_at)); ?></a></p>
            <div class="hr_dbl"></div>

            <p class="info"><?= Str::words(strip_tags($item->text), 55); ?></p>

            <a href="<?= $page_url; ?>?item=<?= $item->uri; ?>" class="more"></a>
            <div class="clearfix"></div>
        </div>
    <?php } ?>

    <?php
    if (method_exists($posts, 'links')) {
        echo $posts->appends(array('year' => $current_year, 'month' => $current_month))->links();
    }
    ?>
<?php } ?>