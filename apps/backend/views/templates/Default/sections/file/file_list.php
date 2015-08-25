<?php if ((count($files) < $num || $num == 0) && User::has('file-upload')) { ?>
    <button type="button" class="click-trigger btn btn-success"
            data-for=".button_<?= $module_name; ?>_<?= $module_id; ?>"><i
            class="glyphicon glyphicon-upload"></i> <?= varlang('-select-file-from-computer'); ?></button>
    <button type="button" class="click-trigger-sv btn btn-success"
            data-for=".path_<?= $module_name; ?>_<?= $module_id; ?>"><i
            class="glyphicon glyphicon-upload"></i> <?= varlang('-select-file-from-server'); ?></button>
<?php } ?>
<br><br>

<table class="table table-bordered table-hover">
    <tr>
        <th><?= varlang('icon'); ?></th>
        <?php if ($module_name == 'partners_logo') {
        ?>

            <th><?= varlang('access-link'); ?></th>
            <?php
        }else{
        ?>
            <th><?= varlang('name1'); ?></th>
            <?php
        }
        ?>
        <th><?= varlang('type'); ?></th>
        <th><?= varlang('size'); ?></th>
        <?php if ($module_name == 'partners_logo') {
            ?>
            <th><?= varlang('order-2'); ?></th>
            <th><?= varlang('status'); ?></th>
            <?php
        }
        ?>
        <th><?= varlang('action-1'); ?></th>
    </tr>
    <?php if (count($files)) { ?>
        <?php foreach ($files as $file) { ?>
            <tr>
                <td>
                    <a href="/<?= $file->path; ?>" target="_blank">
                        <?php if ($file->type == 'image') { ?>
                            <img src="/<?= $file->path; ?>" width="35"/>
                        <?php } else { ?>
                            <i class="glyphicon glyphicon-paperclip btn-lg"></i>
                        <?php } ?>
                    </a>
                </td>
                <td><input type="text" value="<?= $file->name; ?>" data-id="<?= $file->id; ?>"
                           class="file_name_edit form-control"/></td>
                <td><?= $file->type; ?></td>
                <td><?= humanFileSize($file->size); ?></td>
                <?php if ($file->module_name == 'partners_logo') { ?>
                    <td>
                        <form class="ajax-auto-submit" action='<?= url('home/postsaveord'); ?>' method="post"><input
                                type="number" name="order" class="form-control" value="<?= $file->ord ?>">
                            <input type="hidden" name="id" value='<?= $file->id ?>'>
                        </form>
                    </td>
                    <?php
                }
                ?>
                <?php if ($file->module_name == 'partners_logo') { ?>
                    <td>
                        <form class="ajax-auto-submit" action='<?= url('home/postsavepart'); ?>' method="post">
                            <?php
                            if ($file->module_name == 'partners_logo') {
                                ?>
                                <input type="hidden" name="switch" value='<?= $file->id ?>'>
                                <input type="checkbox"
                                    <?= isset($file->status) && $file->status ? 'checked' : ''; ?> />
                                <?php
                            }
                            ?>
                        </form>
                    </td>
                    <?php
                }
                ?>
                <td>
                    <?php if (User::has('file-delete')) { ?>
                        <a class="btn btn-danger delete_file" data-id="<?= $file->id; ?>"
                           data-module_name="<?= $file->module_name; ?>" data-module_id="<?= $file->module_id; ?>"
                           data-update=".files-<?= $module_name; ?>-<?= $module_id; ?>"><i
                                class="glyphicon glyphicon-trash"></i></a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="7"><?= varlang('no-files'); ?></td>
        </tr>
    <?php } ?>
</table>

