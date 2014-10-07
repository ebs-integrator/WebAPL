
<h2><?= varlang('module-1'); ?></h2>

<table class="table table-bordered">
    <tr>
        <th><?= varlang('name-4'); ?></th>
        <th class="col-sm-2"><?= varlang('state-1'); ?></th>
    </tr>
    <?php foreach ($modules as $module) { ?>
        <tr>
            <td><?= $module->name; ?></td>
            <td>
                <?php if ($module->enabled === 1) { ?>
                    <?php if ($module->settings_page) { ?>
                    [ <?= HTML::link($module->settings_page, 'Edit'); ?> ] 
                    <?php } ?>
                    [ <?= HTML::link("module/disable/{$module->id}", varlang('disable')); ?> ]
                <?php } else { ?>
                    [ <?= HTML::link("module/enable/{$module->id}", varlang('enabled-3')); ?> ]
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>

<!--
<form action="<?= url('module/install'); ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="module" onchange="this.form.submit()" class="pull-left btn-success btn" />
</form>-->
