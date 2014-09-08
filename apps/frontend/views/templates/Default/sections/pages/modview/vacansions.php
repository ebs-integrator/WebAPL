<div class='ldmbox'>
    <p class='title'>
        <?= $post->title; ?>
    </p>
    <div class='data'>
        <p><?= date('d-m-Y, H:i', strtotime($post->created_at)); ?></p>
    </div>
    <div class='p_i ldm_li'><?= Core\APL\Shortcodes::execute($post->text, array('post' => $post)); ?></div>
    <div class='clearfix'></div>
    <div class='socials'>
        <div id="vk_like"></div>
        <div id="ok_shareWidget"></div>
        <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="125" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
        <div class="clearfix"></div>
    </div>
    <div class="hr_grey"></div>
</div>

<ul class="l_a">
    <?php foreach ($posts as $item) { ?>
        <li>
            <a href="<?= $page_url; ?>?item=<?= $item->uri; ?>">
                <span><?= date("d-m-Y", strtotime($item->created_at)); ?> <img src="<?= res('assets/img/v_arrow_l.png'); ?>"></span>
                <p><?= $item->title; ?></p>
            </a>
        </li>
    <?php } ?>
</ul>

<div class="clearfix"></div>
<?php echo $posts->links(); ?>
<div class="clearfix"></div>