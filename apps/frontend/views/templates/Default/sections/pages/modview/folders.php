<ul class="dcr">
    <?php foreach ($posts as $item) { ?>
    <li><a href='javascript:;'><?=$item->title;?></a>
        <div class='dcr_box'>
            <?=$item->text;?>
            <p class="ul_title"> <span>Nume fisier</span>Actualizat</p>
            <ul>
                <?php foreach ($item->docs as $file) { ?>
                <li class="<?=$item->extension;?>">
                    <span><?=$file->name;?></span>
                    <span><?=date("d/m/Y", strtotime($file->date_uploaded));?></span>
                </li>
                <?php } ?>
            </ul>
        </div>
    </li>
    <?php } ?>
</ul>