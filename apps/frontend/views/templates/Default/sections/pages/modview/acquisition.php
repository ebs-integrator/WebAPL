<div class='ldmbox'>
    <div class="ath">
        <p><?= $post->title; ?></p>
    </div>

    <?php if (strtotime($post->created_at)) { ?>
        <div class='data'>
            <p class="nr"><?= date('d-m-Y, H:i', strtotime($post->created_at)); ?></p>                    
        </div>
    <?php } ?>

    <div class="stats">
        <?php if (time() < strtotime($post->date_point)) { ?> 
            <img src="<?= res('assets/img/stat_active.png'); ?>" class="stat_active" alt="" >
            <div class="stat_info">
                <span><?= varlang('statut'); ?></span>
                <span><?= varlang('oferte'); ?></span>
            </div>
        <?php } else { ?>
            <img src="<?= res('assets/img/stat_enable.png'); ?>" class="stat_active" alt="" >
            <div class="stat_info">
                <span><?= varlang('statut'); ?></span>
                <span><?= varlang('oferte-expirate'); ?></span>
            </div>
        <?php } ?>
        <div class="clearfix"></div>
    </div>

    <?php if ($post->docs) { ?>
        <ul class="dcr">
            <li><a href='javascript:;'><?= varlang('documente'); ?></a>
                <div class='dcr_box'>
                    <ul class="mda n_t">
                        <?php foreach ($post->docs as $file) { ?>
                            <li class="<?= $file->extension; ?>"><span><a href="<?= url($file->path); ?>"><?= $file->name; ?></a></span></li>  
                        <?php } ?>
                    </ul>
                </div>
            </li>
        </ul>
    <?php } ?>

    <div class="acz_details">
        <?php if ($post->show_pcomment) { ?>
            <div class='live_comment' data-pid="news<?= $post->id; ?>">
                <?= WebAPL\Shortcodes::execute($post->text, [$post, ['post' => $post]]); ?>
            </div>
        <?php } else { ?>
            <div><?= WebAPL\Shortcodes::execute($post->text, ['post' => $post]); ?></div>
        <?php } ?>

        <?= View::make('sections.elements.socials'); ?>
        <div class="hr_grey"></div>
        <?= View::make('sections.elements.comments'); ?>

    </div>
</div>