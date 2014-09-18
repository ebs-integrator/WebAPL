<ul class="dcr">
    <?php foreach ($posts as $item) { ?>
        <li><a href='javascript:;'><?= $item->title; ?></a>
            <div class='dcr_box'>
                <?= $item->text; ?>
                <ul>
                    <?php foreach ($item->docs as $file) { ?>
                        <li class="<?= $file->extension; ?>">
                            <span><a href="<?=url($file->path);?>"><?= $file->name; ?></a></span>
                            <a href="<?=url($file->path);?>" class="dcr_dwnl"></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </li>
    <?php } ?>
</ul>