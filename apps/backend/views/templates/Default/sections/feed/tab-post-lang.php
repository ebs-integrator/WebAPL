<form class="ajax-auto-submit" action='<?= url('feed/langpostsave'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($post->id) ? $post->id : 0; ?>' />
    <input type='hidden' name='lang_id' value='<?= isset($post_lang->lang_id) ? $post_lang->lang_id : 0; ?>' />

    <table class="table table-bordered">
        <tr>
            <th>Title: </th>
            <td>
                <input type="text" name="postlang[<?= $post_lang->id; ?>][title]" class='form-control' value='<?= isset($post_lang->title) ? $post_lang->title : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th>Text: </th>
            <td>
                <textarea name="postlang[<?= $post_lang->id; ?>][text]" class='ckeditor-run'><?= isset($post_lang->text) ? $post_lang->text : ''; ?></textarea>
            </td>
        </tr>
        <tr>
            <th>Enabled: </th>
            <td>
                <input type="checkbox" name="postlang[<?= $post_lang->id; ?>][enabled]" class='make-switch' <?= isset($post_lang->enabled) && $post_lang->enabled ? 'checked' : ''; ?> />
            </td>
        </tr>
        <?php foreach ($post_lang['fields'] as $field) { ?>
            <tr>
                <th><?= $field->title; ?>: </th>
                <td>
                    <?= dinamic_field($field, array('{name}' => "dinamic_lang[{$field->id}]", '{value}' => $field->value, '{class}' => 'form-control')); ?>
                </td>
            </tr>
        <?php } ?>
    </table>

</form>