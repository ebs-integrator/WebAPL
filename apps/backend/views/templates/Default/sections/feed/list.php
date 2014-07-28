<h2>Feeds</h2>

<table class="table table-bordered">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>State</th>
        <th>Action</th>
    </tr>
    <?php foreach ($list as $item) { ?>
        <tr>
            <td><?= $item->id; ?></td>
            <td><?= $item->name; ?></td>
            <td>
                <?php if ($item->enabled) { ?>
                <span class="label label-success">Active</span>
                <?php } else { ?>
                <span class="label label-danger">Inactive</span>
                <?php } ?>
            </td>
            <td>
                <a href="<?=url('feed/edit/'.$item->id);?>" class="btn btn-success">Manage</a>
            </td>
        </tr>
    <?php } ?>
</table>

<div class="c20"></div>

<a href="<?=url('feed/create');?>" class="btn btn-success">Create new feed</a>