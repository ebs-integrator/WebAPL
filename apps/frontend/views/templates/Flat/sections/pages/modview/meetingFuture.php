<?php if (strtotime($post->created_at)) { ?>
    <div class="ag_line">  <span><?= varlang('data'); ?>:</span>  <p><?= date("d-m-Y", strtotime($post->created_at)); ?></p> </div>
<?php } ?>
<div class="ag_line">  <span><?= varlang('ora'); ?>:</span>  <p><?= $post->hours; ?></p> </div>
<div class="ag_line">  <span><?= varlang('locatia'); ?>:</span>  <p><?= $post->location; ?></p> </div>

<div class="t_block">
    <?php if ($post->show_pcomment) { ?>
        <div class='live_comment' data-pid="news<?= $post->id; ?>">
            <?= WebAPL\Shortcodes::execute($post->text, [$post, ['post' => $post]]); ?>
        </div>
    <?php } else { ?>
        <div><?= WebAPL\Shortcodes::execute($post->text, ['post' => $post]); ?></div>
    <?php } ?>
</div>
<div class="clearfix50"></div>
