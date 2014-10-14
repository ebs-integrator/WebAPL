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
                <span><?= varlang('statut'); ?></span>
                <span><?= varlang('oferte'); ?></span>
            </div>
        <?php } else { ?>
            <img src="<?= res('assets/img/stat_enable.png'); ?>" class="stat_active">
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
                            <li class="<?= $file->extension; ?>"><span><a href="<?= $file->path; ?>"><?= $file->name; ?></a></span></li>  
                        <?php } ?>
                    </ul>
                </div>
            </li>
        </ul>
    <?php } ?>

    <div class="acz_details">
        <?= $post->text; ?>

        <?= View::make('sections.elements.socials'); ?>
        <div class="hr_grey"></div>
        <?= View::make('sections.elements.comments'); ?>

    </div>
</div>