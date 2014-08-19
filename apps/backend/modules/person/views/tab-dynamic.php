<?php
$list = isset($person->dynamic_fields) ? @unserialize($person->dynamic_fields) : array();
?>

<form class="ajax-auto-submit" action='<?= url('person/save_dynamic_fields'); ?>' method='post'>
    <input type='hidden' name='person_id' value='<?= isset($person->id) ? $person->id : 0; ?>' />

    <table id="fields_list" class="table table-bordered">
        <thead>
            <tr>
                <th>Drag</th>
                <th>Nume</th>
                <th>Lang</th>
                <th>Valoare</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($list) { ?>
                <?php foreach ($list as $item) { ?>
                    <tr>
                        <td>
                            <div type="button" class="dragbut btn btn-sm btn-info">DRAG</div>
                        </td>
                        <td>
                            <input type="text" name="field[][name]" class='form-control' value='<?= isset($item['name']) ? $item['name'] : ''; ?>' />
                        </td> 
                        <td>
                            <select name="field[][lang_id]" class='form-control'>
                                <option value="0">No lang</option>
                                <?php foreach (Language::getList()as $lang) { ?>
                                    <option value="<?= $lang->id; ?>" <?= isset($item['lang_id']) && $item['lang_id'] == $lang->id ? 'selected' : '' ?>><?= $lang->name; ?></option>
                                <?php } ?>
                            </select>
                        </td> 
                        <td>
                            <input type="text" name="field[][value]" class='form-control' value='<?= isset($item['value']) ? $item['value'] : ''; ?>' />
                        </td> 
                        <td>
                            <button type="button" class="delrow btn btn-sm btn-danger">x</button>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr class="multiplier">
                <td>
                    <div type="button" class="dragbut btn btn-sm btn-info">DRAG</div>
                </td>
                <td>
                    <input type="text" name="field[][name]" class='form-control' />
                </td> 
                <td>
                    <select name="field[][lang_id]" class='form-control'>
                        <option value="0">No lang</option>
                        <?php foreach (Language::getList()as $lang) { ?>
                            <option value="<?= $lang->id; ?>"><?= $lang->name; ?></option>
                        <?php } ?>
                    </select>
                </td> 
                <td>
                    <input type="text" name="field[][value]" class='form-control' />
                </td> 
                <td>
                    <button type="button" class="delrow btn btn-sm btn-danger">x</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>

<style>
    .multiplier .delrow, .multiplier .dragbut {
        display: none;
    }
</style>
<script>
    jQuery(document).ready(function() {
        $("body").on('click', '.multiplier', function() {
            $(this).closest('tbody').append($(this).closest('tr').clone());
            $(this).removeClass('multiplier');
        });

        $("body").on('click', '.delrow', function() {
            $(this).closest('tr:not(.multiplier)').remove();
            $(".multiplier input:first").change();
        });

        $("#fields_list tbody").sortable({
            items: 'tr:not(.multiplier)',
            update: function() {
                $(".multiplier input:first").change();
            }
        });
        $("#fields_list tbody").disableSelection();

    });
</script>