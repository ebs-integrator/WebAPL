<p class='det_news'><?= $post->title; ?></p>
<div class='hr_dbl'></div>
<div class='u_a'>
    <?php if ($post->cover) { ?>
        <img src="<?= url($post->cover['path']); ?>">
    <?php } ?>
    <div class="details">
        <p class="data"><?= date("d-m-Y, H:i", strtotime($post->created_at)); ?>
            <img src="<?= res('assets/img/gr_arrow.png'); ?>" class="arrow">
        </p>
        <p class="cont"></p>
    </div>
</div>                
<div class="clearfix"></div>
<div class='cont'><?=$post->text;?></div>

<?= View::make('sections.elements.socials'); ?>

<div class="hr_grey"></div>

<?= View::make('sections.elements.comments'); ?>