<script>
    jQuery(document).ready(function($) {
        filewidget.filelist('<?= $module_name; ?>', '<?= $module_id; ?>', '.files-<?= $module_name; ?>-<?= $module_id; ?>', <?= $num; ?>);
    });
</script>
<form action="<?= url('uploader/start'); ?>" method="post">
    <input type="hidden" name="module_name" value="<?= $module_name; ?>" />
    <input type="hidden" name="module_id" value="<?= $module_id; ?>" />
    <input type="hidden" name="num" value="<?= $num; ?>" />
    <input type="hidden" name="upath" value="<?= $path; ?>" />
    <input class="select_file button_<?= $module_name; ?>_<?= $module_id; ?> hidden" type="file" name="upload_file" />
</form>
<form action="<?= url('uploader/add'); ?>" method="post">
    <input type="hidden" name="module_name" value="<?= $module_name; ?>" />
    <input type="hidden" name="module_id" value="<?= $module_id; ?>" />
    <input type="hidden" name="num" value="<?= $num; ?>" />
    <input type="hidden" name="path" class="path_<?= $module_name; ?>_<?= $module_id; ?>" value="" />
</form>
<div class="files-<?= $module_name; ?>-<?= $module_id; ?>"></div>
