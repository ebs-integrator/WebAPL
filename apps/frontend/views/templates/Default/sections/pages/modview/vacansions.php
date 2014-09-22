<div class='ldmbox'>
    <p class='title'>
        <?= $post->title; ?>
    </p>
    <div class='data'>
        <p class="nr"><?= date('d-m-Y, H:i', strtotime($post->created_at)); ?></p>
        <p class="term"><span>Termen limita de aplicare a CV-ului :</span> <?= date('d-m-Y, H:i', strtotime($post->date_point)); ?> </p>

    </div>
    <div class='p_i ldm_li'><?= Core\APL\Shortcodes::execute($post->text, array('post' => $post)); ?></div>
    <div class="ldm_middle">
        <p class="tda">
            Termen limita de aplicare : <span><?= date('d-m-Y, H:i', strtotime($post->date_point)); ?></span>
        </p>
    </div>
    <hr>
    <?=Core\APL\Actions::call('cv_form', array('post'=>$post));?>
    <div class='clearfix'></div>
    <?= View::make('sections.elements.socials'); ?>
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
<?php
if (method_exists($posts, 'links')) {
    echo $posts->links();
}
?>
<div class="clearfix"></div>