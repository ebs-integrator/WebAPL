<h3><?= varlang('template-set'); ?></h3>

<?php
$message = Session::get('message');
$type = Session::get('message_type');
if ($message) {
    ?>
    <div class="alert <?= $type ? $type : 'alert-info'; ?>" role="alert"><?= $message; ?></div>
<?php } ?>


<form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

    <table class="table table-bordered table-hover">

        <tr>
            <th><?= varlang('template-2'); ?></th>
            <td>
                <table class="table">
                    <?php foreach (\WebAPL\Template::getTemplates('frontend') as $template) { ?>
                        <tr>
                            <td class="col-lg-1"><input class="make-switch" id="tpl<?= $template; ?>" type="radio" name="set[template_frontend]" value='<?= $template; ?>' <?= isset($setts['template_frontend']) && $setts['template_frontend'] == $template ? 'checked' : ''; ?>></td>
                            <td><label for="tpl<?= $template; ?>"><?= $template; ?></label></td>
                            <?php if (User::has('template-delete')) { ?>
                                <td class="col-lg-1"><a href="<?= url('template/delete/frontend/' . $template); ?>" onclick="return confirm('<?= varlang('confirm-tpl'); ?>');" class="btn btn-sm btn-danger">x</a></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>

        <tr>
            <th><?= varlang('template-b'); ?></th>
            <td>
                <table class="table">
                    <?php foreach (\WebAPL\Template::getTemplates('backend') as $template) { ?>
                        <tr>
                            <td class="col-lg-1"><input class="make-switch" id="tpl<?= $template; ?>" type="radio" name="set[template_backend]" value='<?= $template; ?>' <?= isset($setts['template_backend']) && $setts['template_backend'] == $template ? 'checked' : ''; ?>></td>
                            <td><label for="tpl<?= $template; ?>"><?= $template; ?></label></td>
                            <?php if (User::has('template-delete')) { ?>
                                <td class="col-lg-1"><a href="<?= url('template/delete/backend/' . $template); ?>" onclick="return confirm('<?= varlang('confirm-tpl'); ?>');" class="btn btn-sm btn-danger">x</a></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>

    </table>

</form>

<?php if (User::has('template-install')) { ?>
    <h3><?= varlang('upload-new-template'); ?></h3>
    <form action="<?= url('template/install'); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="template" onchange="this.form.submit()" class="pull-left btn-success btn" />
    </form>
<?php } ?>