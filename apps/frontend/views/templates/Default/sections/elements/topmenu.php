<?php if (Files::extract('website_logo_sm_' . WebAPL\Language::ext(), 1, 'path')) { ?>
<a href="<?= Language::url('/'); ?>">
    <img src="<?= url(Files::extract('website_logo_sm_' . WebAPL\Language::ext(), 1, 'path')); ?>" title="<?= Files::extract('website_logo_sm_' . WebAPL\Language::ext(), 1, 'name'); ?>" alt="<?= Files::extract('website_logo_sm_' . WebAPL\Language::ext(), 1, 'name'); ?>" class="logo">
</a>
<?php } ?>
<?php
if (isset($general_pages)) {
    foreach ($general_pages as $item) {
        ?>
        <div class="top_menu">
            <a href='<?= $item->url; ?>#hm' class="<?= isset($parrents_ids) && in_array($item->id, $parrents_ids) ? 'active' : ''; ?>">
                <div class="left">
                    <?php if ($item->image_icon_active && isset($parrents_ids) && in_array($item->id, $parrents_ids)) { ?>
                        <img alt="<?=$item->title;?>" title="<?=$item->title;?>" src="<?= url($item->image_icon_active->path); ?>">
                    <?php } elseif ($item->image_icon) { ?>
                        <img alt="<?=$item->title;?>" title="<?=$item->title;?>" src="<?= url($item->image_icon->path); ?>">
                    <?php } ?>
                </div>
                <div class="left title third"><?= strtok($item->title, " "); ?> <span><?= ltrim($item->title, strtok($item->title, " ")); ?></span></div></a>
        </div>
        <?php
    }
}
?>