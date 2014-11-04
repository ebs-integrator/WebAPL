<h3><a href="<?= url('person/list'); ?>"><?= varlang('persons'); ?></a> / <?= varlang('edit-person-group'); ?></h3>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <?php foreach (Language::getList() as $lang) { ?>
        <li><a href="#lang<?= $lang->id; ?>" role="tab" data-toggle="tab"><?= $lang->name; ?></a></li>
    <?php } ?>
</ul>


<div class="tab-content">
    <?php
    $first = true;
    foreach (Language::getList() as $lang) {
        ?>
        <div class="tab-pane <?= $first ? 'active' : ''; ?>" id="lang<?= $lang->id; ?>">
            <form class="ajax-auto-submit" action="<?= url('person/savegroup'); ?>" method="post">
                <input type="hidden" name="id" value="<?= isset($group->id) ? $group->id : 0; ?>" />
                <input type="hidden" name="lang_id" value="<?= isset($lang->id) ? $lang->id : 0; ?>" />
                <input type="hidden" name="glang_id" value="<?= isset($group_lang[$lang->id]->id) ? $group_lang[$lang->id]->id : 0; ?>" />

                <table class="table table-bordered table-hover">
                    <tr>
                        <th><?= varlang('gname'); ?></th>
                        <td>
                            <input type="text" name="lang[name]" class="form-control" value="<?= isset($group_lang[$lang->id]->name) ? $group_lang[$lang->id]->name : ''; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th><?= varlang('gdescription'); ?></th>
                        <td>
                            <textarea name="lang[description]" class="form-control"><?= isset($group_lang[$lang->id]->description) ? $group_lang[$lang->id]->description : ''; ?></textarea>
                        </td>
                    </tr>
                </table>
                
            </form>
        </div>
        <?php
        $first = false;
    }
    ?>

</div>