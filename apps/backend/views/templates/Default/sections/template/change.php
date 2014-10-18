<h3><?= varlang('template-set'); ?></h3>

<?php
$message = Session::get('message');
$type = Session::get('message_type');
if ($message) {
    ?>
    <div class="alert <?= $type ? $type : 'alert-info'; ?>" role="alert"><?= $message; ?></div>
<?php } ?>


<form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

    <table class="table table-bordered">

        <tr>
            <th><?= varlang('template-2'); ?></th>
            <td>
                <select class='form-control' name="set[template_frontend]">
                    <?php foreach (\Core\APL\Template::getTemplates('frontend') as $template) { ?>
                        <option value='<?= $template; ?>' <?= isset($setts['template_frontend']) && $setts['template_frontend'] == $template ? 'selected' : ''; ?>><?= $template; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>

        <tr>
            <th><?= varlang('template-b'); ?></th>
            <td>
                <select class='form-control' name="set[template_backend]">
                    <?php foreach (\Core\APL\Template::getTemplates('backend') as $template) { ?>
                        <option value='<?= $template; ?>' <?= isset($setts['template_backend']) && $setts['template_backend'] == $template ? 'selected' : ''; ?>><?= $template; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>

    </table>

</form>


<form action="<?= url('template/install'); ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="template" onchange="this.form.submit()" class="pull-left btn-success btn" />
</form>