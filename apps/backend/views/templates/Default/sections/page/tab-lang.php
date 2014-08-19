<form class="ajax-auto-submit" action='<?= url('page/save'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($page['id']) ? $page['id'] : 0; ?>' />

    <table class="table table-bordered">
        <tr>
            <th>Title: </th>
            <td>
                <input type="text" name="lang[<?= $plang->id; ?>][title]" class='form-control' value='<?= isset($plang->title) ? $plang->title : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th>Uri: </th>
            <td>
                <input type="text" name="lang[<?= $plang->id; ?>][uri]" class='form-control' value='<?= isset($plang->uri) ? $plang->uri : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th>Text: </th>
            <td>
                <textarea name="lang[<?= $plang->id; ?>][text]" class='ckeditor'><?= isset($plang->text) ? $plang->text : ''; ?></textarea>
            </td>
        </tr>
        <tr>
            <th>Enabled: </th>
            <td>
                <input type="checkbox" name="lang[<?= $plang->id; ?>][enabled]" class='make-switch' <?= isset($plang->enabled) && $plang->enabled ? 'checked' : ''; ?> />
            </td>
        </tr>
    </table>
</form>