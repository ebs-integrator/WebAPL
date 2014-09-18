<div class='c20'></div>

<?php if (isset($page['general_node']) && $page['general_node']) { ?>
    <h3>Icon big</h3>
    <?= Files::widget('page_icon_big', $page->id, 1); ?>
    <h3>Icon</h3>
    <?= Files::widget('page_icon', $page->id, 1); ?>
    <h3>Icon activ</h3>
    <?= Files::widget('page_icon_active', $page->id, 1); ?>
    <h3>Background</h3>
    <?= Files::widget('page_bg', $page->id, 1); ?>
<?php } ?>

<br><br>

<form class="ajax-auto-submit" action='<?= url('page/savefilesdata'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($page['id']) ? $page['id'] : 0; ?>' />

    <table class="table table-bordered">
        <tr>
            <th>Afisare fisiere: </th>
            <td>
                <input type="checkbox" name="data[show_files]" class='make-switch' <?= isset($page->show_files) && $page->show_files ? 'checked' : ''; ?> />
            </td>
        </tr>
        <tr>
            <th>Afisare cautare: </th>
            <td>
                <input type="checkbox" name="data[show_file_search]" class='make-switch' <?= isset($page->show_file_search) && $page->show_file_search ? 'checked' : ''; ?> />
            </td>
        </tr>
    </table>
</form>

<?= Files::widget('page', $page->id); ?>
