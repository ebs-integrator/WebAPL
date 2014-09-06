<?php if ($page->show_files && count($page->files) > 0) { ?>
    <div class="search_files">
        <?php if ($page->show_file_search) { ?>
            <div class="search">
                <input class="search_input" type="text" placeholder="Cauta modelul/formularul">
                <input class="search_start" type="button" value="Caută">
                <div class="clearfix"></div>
            </div>
        <?php } ?>
        <ul class="mda">
            <?php foreach ($page->files as $file) { ?>
            <li class="<?=$file->extension;?>">
                <span><?=$file->path;?></span><a href="<?=url($file->path);?>" target="_block" class="active"></a>
            </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>