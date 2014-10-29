<tr>
    <th><?= varlang('gallery'); ?>: </th>
    <td>
        <input type="hidden" id="page_id" value="<?=$page['id'];?>" />
        <select id="attach_gallery" class="form-control">
            <option value="0">---</option>
            <?php foreach ($list as $gallery) { ?>
            <option value="<?= $gallery->id; ?>" <?=  isset($selected['gallery_id']) && $selected['gallery_id'] == $gallery->id ? 'selected' : '' ?>><?= $gallery->name; ?></option>
            <?php } ?>
        </select>
        <br>
        <a href="<?= url('gallery/list'); ?>" class="btn btn-info" target="_blank"><?= varlang('create-new-gallery'); ?></a>

        <script>
            jQuery(document).ready(function($) {
                $('body').on('change', '#attach_gallery', function() {
                    $.post('<?= url('gallery/save_post_attach'); ?>', {id: $(this).val(), post_id: $("#page_id").val()}, function(data) {

                    });
                });
            });
        </script>
        <br><br>
    </td>
</tr>