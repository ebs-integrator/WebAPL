<tr>
    <th><?= varlang('event-group'); ?></th>
    <td>
        <form id="attach_page_calendar">
            <input type="hidden" name="page_id" value="<?=$post['id'];?>" />
            <select id="attach_cgroup" name="calendar_groups[]" class="form-control chzn-select" style="width: 200px;" multiple>
                <option value="0">---</option>
                <?php foreach ($calendar_groups as $pgroup) { ?>
                <option value="<?= $pgroup['id']; ?>" <?= in_array($pgroup['id'], $selected_groups) ? 'selected' : '' ?>><?= $pgroup['name']; ?></option>
                <?php } ?>
            </select>
        </form>
        
        <script>
            jQuery(document).ready(function($) {
                $('body').on('change', '#attach_cgroup', function() {
                    $.post('<?= url('calendar/save_post_attach'); ?>', $("#attach_page_calendar").serialize(), function(data) {

                    });
                });
            });
        </script>
    </td>
</tr>