<tr>
    <th><?= varlang('person-groups'); ?>:</th>
    <td>
        <form id="attach_page_group">
            <input type="hidden" name="page_id" value="<?=$post['id'];?>" />
            <select id="attach_pgroup" name="groups[]" class="form-control chzn-select-deselect" style="width: 200px;" multiple>
                <option value="0">---</option>
                <?php foreach ($person_groups as $pgroup) { ?>
                <option value="<?= $pgroup['id']; ?>" <?= in_array($pgroup['id'], $selected_groups) ? 'selected' : '' ?>><?= $pgroup['name']; ?></option>
                <?php } ?>
            </select>
        </form>
        
        <script>
            jQuery(document).ready(function($) {
                $('body').on('change', '#attach_pgroup', function() {
                    $.post('<?= url('person/save_post_attach'); ?>', $("#attach_page_group").serialize(), function(data) {

                    });
                });
            });
        </script>
    </td>
</tr>