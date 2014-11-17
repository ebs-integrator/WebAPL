<?php
if (isset($fvalue) && $fvalue) {
    $list = @unserialize($fvalue);
} else {
    $list = array();
}
?>

<input type="hidden" name="dinamic_post[<?= $field->id; ?>]" value="1" />

<table id="fields_list" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th><?= varlang('drag'); ?></th>
            <th><?= varlang('nume-3'); ?></th>
            <th><?= varlang('lang-2'); ?></th>
            <th><?= varlang('value'); ?></th>
            <th><?= varlang('delete-1'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if (is_array($list)) { ?> 
            <?php
            foreach ($list as $item) {
                $rowID = uniqid();
                ?>
                <tr>
                    <td>
                        <div type="button" class="dragbut btn btn-sm btn-info"><i class="glyphicon glyphicon-resize-vertical"></i> <?= varlang('drag-1'); ?></div>
                    </td>
                    <td>
                        <input type="text" name="field[][name]" class='form-control' value='<?= isset($item['name']) ? $item['name'] : ''; ?>' />
                    </td> 
                    <td>
                        <select name="field[][lang_id]" class='form-control'>
                            <option value="0"><?= varlang('no-lang'); ?></option>
                            <?php foreach (Language::getList()as $lang) { ?>
                                <option value="<?= $lang->id; ?>" <?= isset($item['lang_id']) && $item['lang_id'] == $lang->id ? 'selected' : '' ?>><?= $lang->name; ?></option>
                            <?php } ?>
                        </select>
                    </td> 
                    <td>
                        <button type="button" class="btn btn-primary edit-din-value" data-toggle="modal" data-target="#modal<?= $rowID; ?>"><i class="glyphicon glyphicon-pencil"></i></button>
                        <div class="modal fade modal-din" id="modal<?= $rowID; ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $rowID; ?>Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i></h4>
                                    </div>
                                    <div class="modal-body">
                                        <textarea type="text" name="field[][value]" class='form-control text-din'><?= isset($item['value']) ? $item['value'] : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td> 
                    <td>
                        <button type="button" class="delrow btn btn-sm btn-danger">x</button>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        <?php
        $rowID = uniqid();
        ?>
        <tr class="multiplier">
            <td>
                <div type="button" class="dragbut btn btn-sm btn-info"><i class="glyphicon glyphicon-resize-vertical"></i> <?= varlang('drag-1'); ?></div>
            </td>
            <td>
                <input type="text" name="field[][name]" class='form-control' />
            </td> 
            <td>
                <select name="field[][lang_id]" class='form-control'>
                    <option value="0"><?= varlang('no-lang'); ?></option>
                    <?php foreach (Language::getList()as $lang) { ?>
                        <option value="<?= $lang->id; ?>"><?= $lang->name; ?></option>
                    <?php } ?>
                </select>
            </td> 
            <td>
                <button type="button" class="btn btn-primary edit-din-value" data-toggle="modal" data-target="#modaldef"><i class="glyphicon glyphicon-pencil"></i></button>
                <div class="modal fade modal-din" id="modaldef" tabindex="-1" role="dialog" aria-labelledby="<?= $rowID; ?>Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i></h4>
                            </div>
                            <div class="modal-body">
                                <textarea type="text" name="field[][value]" class='form-control text-din'></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </td> 
            <td>
                <button type="button" class="delrow btn btn-sm btn-danger">x</button>
            </td>
        </tr>
    </tbody>
</table>

<style>
    .multiplier .delrow, .multiplier .dragbut {
        display: none;
    }
</style>
<script>
    jQuery(document).ready(function() {
        $("body").on('click', '.edit-din-value', function() {
            init_ckeditor($($(this).attr('data-target')).find(".text-din"));
        });

        $('body').on('hidden.bs.modal', '.modal-din', function() {
            var i = $(this).find(".text-din").attr('name');
            if (typeof CKEDITOR.instances[i] != 'undefined') {
                CKEDITOR.instances[i].destroy();
            }
        });

        $("body").on('click', '.multiplier', function() {
            $(this).closest('tbody').append($(this).closest('tr').clone());
            $(this).removeClass('multiplier');
            var tid = "modalw" + ($("#fields_list").length + 1);
            $(this).closest('tr').find(".modal").attr('id', tid);
            $(this).closest('tr').find(".edit-din-value").attr('data-target', "#" + tid);
        });

        $("body").on('click', '.delrow', function() {
            $(this).closest('tr:not(.multiplier)').remove();
            $(".multiplier input:first").change();
        });

        $("#fields_list tbody").sortable({
            items: 'tr:not(.multiplier)',
            handle: '.dragbut',
            update: function() {
                $(".multiplier input:first").change();
            }
        });
        $("#fields_list tbody").disableSelection();

    });
</script>