<form class="ajax-auto-submit" action='<?= url('feed/postsave'); ?>' method='post'>

    <table class="table table-bordered">
        <tr>
            <th>Title: </th>
            <td>
                <input type="text" name="postlang[<?=$post_lang->id;?>][title]" class='form-control' value='<?= isset($post_lang->title) ? $post_lang->title : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th>Text: </th>
            <td>
                <textarea name="postlang[<?=$post_lang->id;?>][text]" class='form-control'><?= isset($post_lang->text) ? $post_lang->text : ''; ?></textarea>
            </td>
        </tr>
        <tr>
            <th>Enabled: </th>
            <td>
                <input type="checkbox" name="postlang[<?= $post_lang->id; ?>][enabled]" class='make-switch' <?= isset($post_lang->enabled) && $post_lang->enabled ? 'checked' : ''; ?> />
            </td>
        </tr>
    </table>

</form>