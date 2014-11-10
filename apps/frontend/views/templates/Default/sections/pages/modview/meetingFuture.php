<ul class="sec_details left">
    <?php if (strtotime($post->created_at)) { ?>
        <li>
            <span class="sec_criteria"><?= varlang('data'); ?>: </span>
            <span class="crt_details"><?= date("d-m-Y", strtotime($post->created_at)); ?></span>
        </li>
    <?php } ?>
    <li>

        <span class="sec_criteria"><?= varlang('ora'); ?>: </span>
        <span class="crt_details"><?= $post->hours; ?></span>
    </li>
    <li>
        <span class="sec_criteria"><?= varlang('locatia'); ?>:</span>
        <span class="crt_details"><?= $post->location; ?></span>
    </li>                
</ul>
<div class="clearfix50"></div>
<?php if ($post->show_pcomment) { ?>
    <div class='live_comment' data-pid="news<?= $post->id; ?>">
        <?= WebAPL\Shortcodes::execute($post->text, [$post, ['post' => $post]]); ?>
    </div>
<?php } else { ?>
    <div><?= WebAPL\Shortcodes::execute($post->text, ['post' => $post]); ?></div>
<?php } ?>
<div class="clearfix50"></div>