<?php if (strtotime($post->created_at)) { ?>
    <div class="ag_line">  <span><?= varlang('data'); ?>:</span>  <p><?= date("d-m-Y", strtotime($post->created_at)); ?></p> </div>
<?php } ?>
<div class="ag_line">  <span><?= varlang('ora'); ?>:</span>  <p><?= $post->hours; ?></p> </div>
<div class="ag_line">  <span><?= varlang('locatia'); ?>:</span>  <p><?= $post->location; ?></p> </div>

<div class="t_block">
    <?= $post->text; ?>
</div>
<div class="clearfix50"></div>
