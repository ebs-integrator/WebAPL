<?php if (count($files) < $num || $num == 0) { ?>
    <button type="button" class="click-trigger btn btn-success" data-for=".button_<?= $module_name; ?>_<?= $module_id; ?>"><i class="fa fa-upload"></i> Select file</button>
<?php } ?>
<br><br>
<table class="table table-bordered">
    <tr>
        <th>Icon</th>
        <th>Name</th>
        <th>Type</th>
        <th>Size</th>
        <th>Action</th>
    </tr>
    <?php if (count($files)) { ?>
        <?php foreach ($files as $file) { ?>
            <tr>
                <td>
                    <?php if ($file->type == 'image') { ?>
                        <img src="/<?= $file->path; ?>" width="35" />
                    <?php } ?>
                </td>
                <td><input type="text" value="<?= $file->name; ?>" data-id="<?=$file->id;?>" class="file_name_edit form-control" /></td>
                <td><?= $file->type; ?></td>
                <td><?= humanFileSize($file->size); ?></td>
                <td><a class="btn btn-danger delete_file" data-id="<?= $file->id; ?>" data-module_name="<?= $file->module_name; ?>" data-module_id="<?= $file->module_id; ?>" data-update=".files-<?= $module_name; ?>-<?= $module_id; ?>"><i class="fa fa-trash-o"></i></a></td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="5">No files</td>
        </tr>
    <?php } ?>
</table>