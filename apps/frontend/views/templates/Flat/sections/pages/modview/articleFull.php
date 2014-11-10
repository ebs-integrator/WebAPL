<p class="det_news"><?= $post->title; ?></p>
<?php if (strtotime($post->created_at)) { ?>
    <p class="p_data"><?= date("d-m-Y, H:i", strtotime($post->created_at)); ?>    </p>
<?php } ?>
<div class="hr_dbl"></div>
<div class="u_a">
    <?php if ($post->cover) { ?>
        <img alt="<?= $post->title; ?>" title="<?= $post->title; ?>" src="<?= url($post->cover['path']); ?>">
    <?php } ?>
</div>
<div class='conten'>

    <?php Event::fire('post_top_container', $post); ?>

    <?php if ($post->show_pcomment) { ?>
        <div class='live_comment' data-pid="news<?= $post->id; ?>">
            <?= WebAPL\Shortcodes::execute($post->text); ?>
        </div>
    <?php } else { ?>
        <div><?= WebAPL\Shortcodes::execute($post->text); ?></div>
    <?php } ?>

    <?php Event::fire('post_bottom_container', $post); ?>

    <?php if ($post->have_socials) { ?>
        <?= View::make('sections.elements.socials'); ?>
    <?php } ?>

    <div class="hr_grey"></div>

    <?php if ($post->have_comments) { ?>
        <?= View::make('sections.elements.comments'); ?>
    <?php } ?>
</div>
