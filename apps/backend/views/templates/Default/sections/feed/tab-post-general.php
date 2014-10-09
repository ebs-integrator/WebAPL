<form class="ajax-auto-submit" action='<?= url('feed/postsave'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($post->id) ? $post->id : 0; ?>' />

    <table class="table table-bordered">
        <tr>
            <th><?= varlang('date-3'); ?>: </th>
            <td>
                <input type="text" name="post[created_at]" class='form-control datetimepicker' data-date-format="YYYY-MM-DD hh:mm:ss" value='<?= isset($post->created_at) ? $post->created_at : ''; ?>' />
            </td>
        </tr>

        <tr>
            <th><?= varlang('to-home-page'); ?>: </th>
            <td>
                <input type="checkbox" name="post[to_home]" class='make-switch' <?= isset($post->to_home) && $post->to_home ? 'checked' : ''; ?> />
            </td>
        </tr>
        
        <tr>
            <th><?= varlang('allow-pcomment'); ?>: </th>
            <td>
                <input type="checkbox" name="post[show_pcomment]" class='make-switch' <?= isset($post->show_pcomment) && $post->show_pcomment ? 'checked' : ''; ?> />
            </td>
        </tr>
        
        <tr>
            <th><?= varlang('hovecomments'); ?>: </th>
            <td>
                <input type="checkbox" name="post[have_comments]" class='make-switch' <?= isset($post->have_comments) && $post->have_comments ? 'checked' : ''; ?> />
            </td>
        </tr>
        
        <tr>
            <th><?= varlang('havesocials'); ?>: </th>
            <td>
                <input type="checkbox" name="post[have_socials]" class='make-switch' <?= isset($post->have_socials) && $post->have_socials ? 'checked' : ''; ?> />
            </td>
        </tr>
        
        <tr>
            <th><?= varlang('feeds-1'); ?>: </th>
            <td>
                <input name='feed_post[]' value='0' type='hidden' />
                <select name='feed_post[]' multiple='multiple' class='col-sm-12 chzn-select'>
                    <option></option>
                    <?php foreach ($feeds as $feed) { ?>
                        <option value='<?= $feed->id; ?>' <?= in_array($feed->id, $post_feeds) ? 'selected' : '' ?>><?= $feed->name; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>

        <?php foreach ($fields as $field) { ?>
            <tr>
                <th><?= $field->title; ?>: </th>
                <td> 
                    <?= dinamic_field($field, isset($post->id) ? $post->id : 0, false, array('{name}' => "dinamic_post[{$field->id}]", '{value}' => $field->value, '{class}' => 'form-control')); ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</form>

<table class="table table-bordered">
    <?php foreach ($fields_out as $field) { ?>
        <tr>
            <th><?= $field->title; ?>: </th>
            <td> 
                <?= dinamic_field($field, isset($post) ? $post : array(), false, array('{name}' => "dinamic_post[{$field->id}]", '{value}' => $field->value, '{class}' => 'form-control')); ?>
            </td>
        </tr>
    <?php } ?>
</table>

<?php
    Core\APL\Actions::call('feed_post_bottom', isset($post) ? $post : []);
?>