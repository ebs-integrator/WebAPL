<table class="table table-bordered">
    <tr>
        <th><?= varlang('creeaza-eveniment-in-calendar'); ?> </th>
        <td>
            <input type="hidden" id="post_id" value="<?= $post['id']; ?>" />

            <select id="checkboxAttach" class="form-control">
                <option value="0"><?= varlang('nu-5'); ?></option>
                <option value="1" <?= $activated ? 'selected' : ''; ?>><?= varlang('da-15'); ?></option>
            </select>
            
            <script>
                jQuery(document).ready(function($) {
                    $('body').on('change', '#checkboxAttach', function() {
                        $.post('<?= url('calendar/save_post_cal_attach'); ?>', {check: $(this).val(), post_id: $("#post_id").val()}, function(data) {

                        });
                    });
                });
            </script>
            <br><br>
        </td>
    </tr>
</table>