<p class='det_news'><?= $post->title; ?></p>
<div class='hr_dbl'></div>
<div class='u_a'>
    <?php if (isset($post['cover']->path)) { ?>
        <img alt="<?= $post->title; ?>" title="<?= $post->title; ?>" src="<?= url($post['cover']->path); ?>" width="870" />
    <?php } ?>
    <?php if (strtotime($post->created_at)) { ?>
        <div class="details">
            <p class="data"><?= date("d-m-Y, H:i", strtotime($post->created_at)); ?></p>
            <p class="cont"></p>
        </div>
    <?php } ?>
</div>                
<div class="clearfix"></div>

<?php Event::fire('post_top_container', $post); ?>

<?php if ($post->show_pcomment) { ?>
    <div class='live_comment' data-pid="news<?= $post->id; ?>"><?= WebAPL\Shortcodes::execute($post->text, ['post' => $post]); ?></div>
<?php } else { ?>
    <div><?= WebAPL\Shortcodes::execute($post->text, ['post' => $post]); ?></div>
<?php } ?>

<?php if ($post->have_socials) { ?>
    <?= View::make('sections.elements.socials'); ?>
    <div class='c20'></div>
<?php } ?>

<?php Event::fire('post_bottom_container', $post); ?>

<div class="hr_grey"></div>

<?php if ($post->have_comments) { ?>
    <?= View::make('sections.elements.comments'); ?>
<?php } ?>