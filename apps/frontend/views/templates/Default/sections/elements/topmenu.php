<a href="<?= Language::url('/'); ?>"><img src="<?= res('assets/img/s_logo.png'); ?>" class="logo"></a>
<?php
if (isset($general_pages)) {
    foreach ($general_pages as $item) {
        ?>
        <div class="top_menu">
            <a href='<?= $item->url; ?>' class="<?= isset($parrents_ids) && in_array($item->id, $parrents_ids) ? 'active' : ''; ?>">
                <div class="left">
                    <?php if ($item->image_icon_active && isset($parrents_ids) && in_array($item->id, $parrents_ids)) { ?>
                        <img src="<?= url($item->image_icon_active->path); ?>">
                    <?php } elseif ($item->image_icon) { ?>
                        <img src="<?= url($item->image_icon->path); ?>">
                    <?php } ?>
                </div>
                <div class="left title third"><?= $item->title; ?></div></a>
        </div>
        <?php
    }
}
?>