<div class='ldmbox'>
    <p class='title'>
        <?= $post->title; ?>
    </p>
    <?php if (strtotime($post->created_at)) { ?>
        <div class='data'>
            <p class="nr"><?= date('d-m-Y, H:i', strtotime($post->created_at)); ?></p>
        </div>
    <?php } ?>
    <div class='p_i ldm_li'><?= WebAPL\Shortcodes::execute($post->text, array('post' => $post)); ?></div>
    <?php if (strtotime($post->date_point)) { ?>
    <div class="ldm_middle">
        <p class="tda">
            <?= varlang('termen-limita'); ?> : <span><?= date('d-m-Y, H:i', strtotime($post->date_point)); ?></span>
        </p>
    </div>
    <?php } ?>
    <hr>
    <?= Event::fire('cv_form', array('post' => $post), true); ?>
    <div class='clearfix'></div>
    <?= View::make('sections.elements.socials'); ?>
    <div class="hr_grey"></div>
</div>

<ul class="l_a">
    <?php foreach ($posts as $item) { ?>
        <li>
            <a href="<?= $page_url; ?>?item=<?= $item->uri; ?>">
                <?php if (strtotime($item->created_at)) { ?>
                    <span><?= date("d-m-Y", strtotime($item->created_at)); ?> </span>
                <?php } ?>
                <p><?= $item->title; ?></p>
            </a>
        </li>
    <?php } ?>
</ul>

<div class="clearfix"></div>
<?php
if (method_exists($posts, 'links')) {
    echo $posts->links();
}
?>
<div class="clearfix"></div>