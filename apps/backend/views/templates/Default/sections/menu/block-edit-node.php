<?php foreach ($items_lang as $lang_item) { ?>
    <input type="text" name="nodelang[<?= $lang_item->id; ?>][title]" placeholder="Name" class="form-control" value="<?=$lang_item->title;?>" />
    <div class="c10"></div>
    <input type="text" name="nodelang[<?= $lang_item->id; ?>][href]" placeholder="http://" class="form-control" value="<?=$lang_item->title;?>" />
    <div class="c20"></div>
<?php } ?>