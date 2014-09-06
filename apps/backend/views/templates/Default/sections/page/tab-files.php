<div class='c20'></div>

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