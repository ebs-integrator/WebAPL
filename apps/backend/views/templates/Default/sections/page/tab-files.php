<div class='c20'></div>

<form class="ajax-auto-submit" action='<?= url('page/savefilesdata'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($page['id']) ? $page['id'] : 0; ?>' />

    <table class="table table-bordered table-hover">
        <tr>
            <th><?= varlang('afisare-fisiere-'); ?></th>
            <td>
                <input type="checkbox" name="data[show_files]" class='make-switch' <?= isset($page->show_files) && $page->show_files ? 'checked' : ''; ?> />
            </td>
        </tr>
        <tr>
            <th><?= varlang('afisare-cautare-'); ?></th>
            <td>
                <input type="checkbox" name="data[show_file_search]" class='make-switch' <?= isset($page->show_file_search) && $page->show_file_search ? 'checked' : ''; ?> />
            </td>
        </tr>
    </table>
</form>

<?= Files::widget('page', $page->id); ?>

<br><br>

<?php if ($page->general_node && Config::get('template.page_icon_big')) { ?>
    <h3><?= varlang('icon-big'); ?></h3>
    <?= Files::widget('page_icon_big', $page->id, 1); ?>
<?php } ?>

<?php if ($page->general_node && Config::get('template.page_icon')) { ?>
    <h3><?= varlang('icon-2'); ?></h3>
    <?= Files::widget('page_icon', $page->id, 1); ?>
<?php } ?>

<?php if ($page->general_node && Config::get('template.page_icon_active')) { ?>
    <h3><?= varlang('icon-activ'); ?></h3>
    <?= Files::widget('page_icon_active', $page->id, 1); ?>
<?php } ?> 

<?php if (($page->general_node && Config::get('template.page_bg')) || Config::get('template.page_bg_all')) { ?>
    <h3><?= varlang('background'); ?></h3>
    <?= Files::widget('page_bg', $page->id, 1); ?>
<?php } ?>
