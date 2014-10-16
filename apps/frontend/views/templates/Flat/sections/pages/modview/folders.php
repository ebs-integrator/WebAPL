<ul class="dcr">
    <?php foreach ($posts as $item) { ?>
        <li><a href='javascript:;'><?= $item->title; ?><span class="more_dot"></span></a>
            <div class='dcr_box' style="display: none;">
                <?= $item->text; ?>
                <ul>
                    <?php foreach ($item->docs as $file) { ?>
                        <li class="<?= $file->extension; ?>">
                            <a href="<?=url($file->path);?>"><?= $file->name; ?> <span class="dcr_dwnl"></span></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </li>
    <?php } ?>
</ul>
