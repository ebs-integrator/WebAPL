
<h2><?= varlang('module-1'); ?></h2>

<table class="table table-bordered table-hover">
    <tr>
        <th><?= varlang('name-4'); ?></th>
        <th class="col-sm-2"><?= varlang('state-1'); ?></th>
    </tr>
    <?php foreach ($modules as $module) { ?>
        <tr>
            <td><?= $module->name; ?></td>
            <td>
                <?php if ($module->enabled == 1) { ?>
                    <?php if ($module->settings_page) { ?>
                    [ <?= HTML::link($module->settings_page, varlang('module-edit')); ?> ] 
                    <?php } ?>
                    [ <?= HTML::link("module/disable/{$module->id}", varlang('disable')); ?> ]
                <?php } else { ?>
                    [ <?= HTML::link("module/enable/{$module->id}", varlang('enabled-3')); ?> ]
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>
