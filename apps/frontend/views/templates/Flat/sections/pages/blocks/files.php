<?php if ($page->show_files && count($page->files) > 0) { ?>
    <div class="search_files">
        <?php if ($page->show_file_search) { ?>
            <div class="search">
                <input class="search_input" type="text" placeholder="<?= varlang('modelul-formularul'); ?>">
                <input class="search_start" type="submit" value="<?= varlang('search'); ?>">
                <div class="clearfix"></div>
            </div>
        <?php } ?>
        <ul class="docs">
            <?php foreach ($page->files as $file) { ?>
            <li class="<?=$file->extension;?>">
                <a href="<?=url($file->path);?>" target="_block"><?=$file->name;?><span></span></a>
            </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
