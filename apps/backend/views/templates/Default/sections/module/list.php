
<h2>Lista de module</h2>

<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th class="col-sm-2">State</th>
    </tr>
    <?php foreach ($modules as $module) { ?>
        <tr>
            <td><?= $module->name; ?></td>
            <td>
                <?php if ($module->enabled === 1) { ?>
                    <?php if ($module->settings_page) { ?>
                    [ <?= HTML::link($module->settings_page, 'Edit'); ?> ] 
                    <?php } ?>
                    [ <?= HTML::link("module/disable/{$module->id}", 'Disable'); ?> ]
                <?php } else { ?>
                    [ <?= HTML::link("module/enable/{$module->id}", 'Enable'); ?> ]
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>


<form action="<?= url('module/install'); ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="module" onchange="this.form.submit()" class="pull-left btn-success btn" />
</form>
