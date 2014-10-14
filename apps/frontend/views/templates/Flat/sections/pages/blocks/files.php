<?php if ($page->show_files && count($page->files) > 0) { ?>
    <div class="search_files">
        <?php if ($page->show_file_search) { ?>
            <div class="search">
                <input class="search_input" type="text" placeholder="<?= varlang('modelul-formularul'); ?>">
                <input class="search_start" type="button" value="<?= varlang('search'); ?>">
                <div class="clearfix"></div>
            </div>
        <?php } ?>
        <ul class="mda">
            <?php foreach ($page->files as $file) { ?>
            <li class="<?=$file->extension;?>">
                <span><a href="<?=url($file->path);?>" target="_block"><?=$file->name;?></a></span><a href="<?=url($file->path);?>" target="_block" class="active"></a>
            </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>