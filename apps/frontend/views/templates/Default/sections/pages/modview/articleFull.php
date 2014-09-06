<p class='det_news'><?= $post->title; ?></p>
<div class='hr_dbl'></div>
<div class='u_a'>
    <?php if (isset($post['cover']->path)) { ?>
        <img src="<?= url($post['cover']->path); ?>" width="870" />
    <?php } ?>
    <div class="details">
        <p class="data"><?= date("d-m-Y, H:i", strtotime($post->created_at)); ?>
            <img src="<?= res('assets/img/gr_arrow.png'); ?>" class="arrow">
        </p>
        <p class="cont"></p>
    </div>
</div>                
<div class="clearfix"></div>
<div class='cont'><?= Core\APL\Shortcodes::execute($post->text); ?></div>