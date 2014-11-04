<form class="ajax-auto-submit" action='<?= url('feed/langpostsave'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($post->id) ? $post->id : 0; ?>' />
    <input type='hidden' name='lang_id' value='<?= isset($post_lang->lang_id) ? $post_lang->lang_id : 0; ?>' />

    <table class="table table-bordered table-hover">
        <tr>
            <th><?= varlang('frontend-link'); ?>: </th>
            <td>
                <?php
                $link = "/" . (Language::getItem($post_lang->lang_id)->ext) . "/topost/" . (isset($post['id']) ? $post['id'] : 0) . '?is_admin=1';
                ?>
                <a href="<?=$link;?>" target="_blank"><?=$link;?></a>
            </td>
        </tr>
        <tr>
            <th><?= varlang('title-3'); ?>: </th>
            <td>
                <input type="text" name="postlang[<?= $post_lang->id; ?>][title]" class='form-control' value='<?= isset($post_lang->title) ? $post_lang->title : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('uri'); ?>: </th>
            <td>
                <input type="text" name="postlang[<?= $post_lang->id; ?>][uri]" class='form-control' value='<?= isset($post_lang->uri) ? $post_lang->uri : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('enabled-1'); ?>: </th>
            <td>
                <input type="checkbox" name="postlang[<?= $post_lang->id; ?>][enabled]" class='make-switch' <?= isset($post_lang->enabled) && $post_lang->enabled ? 'checked' : ''; ?> />
            </td>
        </tr>
        <tr>
            <th><?= varlang('text'); ?>: </th>
            <td>
                <textarea name="postlang[<?= $post_lang->id; ?>][text]" class='ckeditor-run'><?= isset($post_lang->text) ? $post_lang->text : ''; ?></textarea>
            </td>
        </tr>
        <?php foreach ($post_lang['fields'] as $field) { ?>
            <tr>
                <th><?= $field->title; ?>: </th>
                <td>
                    <?= dinamic_field($field, isset($post_lang) ? $post_lang : array(), true, array('{name}' => "dinamic_lang[".(isset($post_lang->lang_id) ? $post_lang->lang_id : 0)."][{$field->id}]", '{value}' => $field->value, '{class}' => 'form-control')); ?>
                </td>
            </tr>
        <?php } ?>
    </table>

</form>

<table class="table table-bordered table-hover">
    <?php foreach ($post_lang['fields_out'] as $field) { ?>
        <tr>
            <th><?= $field->title; ?>: </th>
            <td>
                <?= dinamic_field($field, isset($post_lang) ? $post_lang : array(), true, array('{name}' => "dinamic_lang[{$field->id}]", '{value}' => $field->value, '{class}' => 'form-control')); ?>
            </td>
        </tr>
    <?php } ?>
</table>