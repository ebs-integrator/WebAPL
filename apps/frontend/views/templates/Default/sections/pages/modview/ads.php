<?php if (isset($post) && $post) { ?>
<div class="a_box v_g m_an">
    <p class="title"><?=$post->title;?></p>
    <div class="hr_dbl"></div>
    <div class="left">
        <div class="img">
            <?php if ($post->cover) { ?>
            <img src="<?= url($post->cover['path']); ?>">
            <?php } ?>
        </div>
        <div class="details">
            <p class="data"><?= date("d-m-Y, H:i", strtotime($post->created_at)); ?>
                <img src="<?= res('assets/img/v_arrow.png'); ?>" class='arrow'>
            </p>
            <p class='cont'></p>
        </div>
    </div>
    <div class="right">
        <p class="info"><?=$post->text;?></p>
    </div>
    <div class="clearfix"></div>
</div>
<?php } ?>

<?php if (isset($posts) && count($posts)) { ?>
    <div class='list'>
        <ul class='a_n'>
            <?php foreach ($posts as $item) { ?>
                <li><a href='<?= $page_url; ?>?item=<?= $item->uri; ?>'>
                        <span><?= date('d-m-Y', strtotime($item->created_at)); ?> <img src="<?= res('assets/img/d_arrow.png'); ?>"></span>
                        <p><?= $item->title; ?></p>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <?php
    if (method_exists($posts, 'links')) {
        echo $posts->appends(array('year' => $current_year, 'month' => $current_month))->links();
    }
    ?>
<?php } ?>

<?php if (!isset($post) && !isset($posts)) { ?>
    Nu sunt articole
<?php } ?>