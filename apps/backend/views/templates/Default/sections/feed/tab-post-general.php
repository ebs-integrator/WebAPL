<form class="ajax-auto-submit" action='<?= url('feed/postsave'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($post->id) ? $post->id : 0; ?>' />

    <table class="table table-bordered table-hover">
        <tr>
            <th class="col-lg-4"><?= varlang('date-3'); ?>: </th>
            <td>
                <input type="text" name="post[created_at]" class='form-control datetimepicker' data-date-format="YYYY-MM-DD HH:mm:ss" value='<?= isset($post->created_at) ? $post->created_at : ''; ?>' />
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
            <th><?= varlang('is-alert'); ?>: </th>
            <td>
                <input type="checkbox" name="post[is_alert]" class='make-switch' <?= isset($post->is_alert) && $post->is_alert ? 'checked' : ''; ?> />
            </td>
        </tr>

        <tr>
            <th><?= varlang('data-expirarii-alertei'); ?>: </th>
            <td>
                <input type="text" name="post[alert_expire]" class='form-control datetimepicker' data-date-format="YYYY-MM-DD HH:mm:ss" value='<?= isset($post->alert_expire) ? $post->alert_expire : ''; ?>' />
            </td>
        </tr>

        <tr>
            <th><?= varlang('grupa-de-postari'); ?></th>
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
                    <?= dinamic_field($field, isset($post) ? $post : array(), false, array('{name}' => "dinamic_post[{$field->id}]", '{value}' => isset($field->value) ? $field->value : '', '{class}' => 'form-control')); ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</form>

<table class="table table-bordered table-hover">
    <?php foreach ($fields_out as $field) { ?>
        <tr>
            <th><?= $field->title; ?>: </th>
            <td> 
                <?= dinamic_field($field, isset($post) ? $post : array(), false, array('{name}' => "dinamic_post[{$field->id}]", '{value}' => isset($field->value) ? $field->value : '', '{class}' => 'form-control')); ?>
            </td>
        </tr>
    <?php } ?>
</table>

<?php
Event::fire('feed_post_bottom', (isset($post) ? $post : []));
?>