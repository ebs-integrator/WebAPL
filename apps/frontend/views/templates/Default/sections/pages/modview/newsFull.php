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
<div class='socials'>
    <div id="vk_like"></div>
    <div id="ok_shareWidget"></div>
    <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="125" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
    <div class="clearfix"></div>
</div>
<div class="hr_grey"></div>

<?= View::make('sections.elements.comments'); ?>