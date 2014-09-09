<div class='ldmbox'>
    <div class="ath">
        <p><?= $post->title; ?></p>
    </div>

    <div class='data'>
        <p class="nr"><?= date('d-m-Y, H:i', strtotime($post->created_at)); ?></p>                    
    </div>

    <div class="stats">
        <?php if (time() < strtotime($post->date_point)) { ?> 
            <img src="<?= res('assets/img/stat_active.png'); ?>" class="stat_active">
            <div class="stat_info">
                <span>Statut</span>
                <span>Primim oferte</span>
            </div>
        <?php } else { ?>
            <img src="<?= res('assets/img/stat_enable.png'); ?>" class="stat_active">
            <div class="stat_info">
                <span>Statut</span>
                <span>Oferta expirata</span>
            </div>
        <?php } ?>
        <div class="clearfix"></div>
    </div>

    <div class="acz_details"><?= $post->text; ?></div>

    <?php if ($post_files) { ?>
    <ul class="mda n_t">
        <?php foreach ($post_files as $file) { ?>
        <li class="word"><a href="<?=$file->path;?>"><span><?=$file->name;?></span></a></li>  
        <?php } ?>
    </ul>
    <?php } ?>
    
    <div class='clearfix50'></div>
    <div class='socials'>
        <div id="vk_like"></div>
        <div id="ok_shareWidget"></div>
        <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="125" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
        <div class="clearfix"></div>
    </div>
    <div class="hr_grey"></div>
    <div class="fb-comments" data-href="http://example.com/comments" data-width="785" data-numposts="2" data-colorscheme="light"></div>
</div>