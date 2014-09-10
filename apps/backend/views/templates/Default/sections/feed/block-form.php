<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <td><input type="text" class="form-control" name="general[name]" value="<?= isset($feed->name) ? $feed->name : ''; ?>" /></td>
    </tr>
    <tr>
        <th>Enabled</th>
        <td><input type="checkbox" class="make-switch" name="general[enabled]" <?= isset($feed->enabled) && $feed->enabled ? 'checked' : ''; ?> /></td>
    </tr>
    <tr>
        <th>Limit type</th>
        <td>
            <?= Form::select('general[limit_type]', array('none' => 'none', 'pagination' => 'Pagination', 'strictlimit' => 'Strict limit'), isset($feed->limit_type) ? $feed->limit_type : '', array('class' => 'form-control')); ?>
        </td>
    </tr>
    <tr>
        <th>Limit:</th>
        <td><input type="text" class="form-control" name="general[limit_value]" value="<?= isset($feed->limit_value) ? $feed->limit_value : ''; ?>" /></td>
    </tr>
    <tr>
        <th>Order type</th>
        <td>
            <?= Form::select('general[order_type]', array('none' => 'none', 'asc' => 'ASCENDENT', 'desc' => 'DESCENDENT'), isset($feed->order_type) ? $feed->order_type : '', array('class' => 'form-control')); ?>
        </td>
    </tr>
    <tr>
        <th>Order by</th>
        <td>
            <?= Form::select('general[order_by]', array('none' => 'none', 'created_at' => 'Date', 'title' => 'Title', 'views' => 'Views'), isset($feed->order_by) ? $feed->order_by : '', array('class' => 'form-control')); ?>
        </td>
    </tr>
</table>