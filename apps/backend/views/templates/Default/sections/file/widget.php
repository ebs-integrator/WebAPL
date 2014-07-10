<script>
    jQuery(document).ready(function($) {
        filewidget.filelist('<?= $module_name; ?>', '<?= $module_id; ?>', '.files-<?= $module_name; ?>-<?= $module_id; ?>', <?=$num;?>);
    });
</script>
<form action="<?= url('uploader/start'); ?>" method="post">
    <input type="hidden" name="module_name" value="<?= $module_name; ?>" />
    <input type="hidden" name="module_id" value="<?= $module_id; ?>" />
    <input type="hidden" name="num" value="<?= $num; ?>" />
    <input class="select_file button_<?= $module_name; ?>_<?= $module_id; ?> hidden" type="file" name="upload_file" />
</form>
<div class="files-<?= $module_name; ?>-<?= $module_id; ?>"></div>