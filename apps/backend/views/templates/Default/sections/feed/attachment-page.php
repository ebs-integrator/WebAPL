<tr>
    <th><?= varlang('feeds-1'); ?>: </th>
    <td>
        <input type="hidden" id="page_id" value="<?= $post['id']; ?>" />
        <select id="attach_feed" class="form-control">
            <option value="0">---</option>
            <?php foreach ($list as $feed) { ?>
                <option value="<?= $feed->id; ?>" <?= isset($post['feed_id']) && $post['feed_id'] == $feed->id ? 'selected' : '' ?>><?= $feed->name; ?></option>
            <?php } ?>
        </select>
        <br>
        <?php if (isset($post['feed_id']) && $post['feed_id']) { ?>
            <a href="<?= url('feed/edit/'.$post['feed_id']); ?>" class="btn btn-info" target="_blank"><?= varlang('current-feed'); ?></a>
        <?php } ?>

        <a href="<?= url('feed'); ?>" class="btn btn-info" target="_blank"><?= varlang('create-new-feed'); ?></a>

        <script>
            jQuery(document).ready(function($) {
                $('body').on('change', '#attach_feed', function() {
                    $.post('<?= url('feed/postattach'); ?>', {id: $(this).val(), post_id: <?=$post['id'];?>});
                });
            });
        </script>
    </td>
</tr>