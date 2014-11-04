<table class="table table-bordered table-hover">
    <tr>
        <th><?= varlang('name'); ?></th>
        <td><input type="text" class="form-control" name="general[name]" value="<?= isset($feed->name) ? $feed->name : ''; ?>" /></td>
    </tr>
    <tr>
        <th><?= varlang('enabled'); ?></th>
        <td><input type="checkbox" class="make-switch" name="general[enabled]" <?= isset($feed->enabled) && $feed->enabled ? 'checked' : ''; ?> /></td>
    </tr>
    <tr>
        <th><?= varlang('limit-type'); ?></th>
        <td>
            <?= Form::select('general[limit_type]', array('none' => 'none', 'pagination' => varlang('pagination'), 'strictlimit' => varlang('strict-limit')), isset($feed->limit_type) ? $feed->limit_type : '', array('class' => 'form-control')); ?>
        </td>
    </tr>
    <tr>
        <th><?= varlang('limit'); ?></th>
        <td><input type="text" class="form-control" name="general[limit_value]" value="<?= isset($feed->limit_value) ? $feed->limit_value : ''; ?>" /></td>
    </tr>
    <tr>
        <th><?= varlang('order-type'); ?></th>
        <td>
            <?= Form::select('general[order_type]', array('none' => varlang('none'), 'asc' => varlang('ascendent'), 'desc' => varlang('descendent')), isset($feed->order_type) ? $feed->order_type : '', array('class' => 'form-control')); ?>
        </td>
    </tr>
    <tr>
        <th><?= varlang('order-by'); ?></th>
        <td>
            <?= Form::select('general[order_by]', array('none' => varlang('none'), 'created_at' => varlang('date-1'), 'title' => varlang('title-2'), 'views' => varlang('views')), isset($feed->order_by) ? $feed->order_by : '', array('class' => 'form-control')); ?>
        </td>
    </tr>
</table>