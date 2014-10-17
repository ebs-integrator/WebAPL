<p class='det_news'><?= $post->title; ?></p>
<div class='hr_dbl'></div>
<div class='u_a'>
    <?php if (isset($post['cover']->path)) { ?>
        <img src="<?= url($post['cover']->path); ?>" width="870" />
    <?php } ?>
    <div class="details">
        <p class="data"><?= date("d-m-Y, H:i", strtotime($post->created_at)); ?></p>
        <p class="cont"></p>
    </div>
</div>                
<div class="clearfix"></div>

<?php if ($post->show_pcomment) { ?>
    <div class='cont live_comment' data-pid="news<?= $post->id; ?>"><?= Core\APL\Shortcodes::execute($post->text); ?></div>
<?php } else { ?>
    <div class='cont'><?= Core\APL\Shortcodes::execute($post->text); ?></div>
<?php } ?>

<?php if ($post->have_socials) { ?>
    <?= View::make('sections.elements.socials'); ?>
    <div class='c20'></div>
<?php } ?>
    
<div class="hr_grey"></div>

<?php if ($post->have_comments) { ?>
    <?= View::make('sections.elements.comments'); ?>
<?php } ?>