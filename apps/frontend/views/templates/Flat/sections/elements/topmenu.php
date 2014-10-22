<?php if (isset($logo_home_sm) && $logo_home_sm) { ?>
<a href="<?= Language::url('/'); ?>">
    <img  alt="" src="<?= url($logo_home_sm->path); ?>" title="<?= $logo_home_sm->name; ?>" alt="<?= $logo_home_sm->name; ?>" class="logo">
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