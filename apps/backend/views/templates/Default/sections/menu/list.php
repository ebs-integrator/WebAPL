<table class="table table-bordered table-hovered">
    
    <tr>
        <th>Name</th>
        <th>Active</th>
        <th>Action</th>
    </tr>
    
    <?php foreach ($items as $item) { ?>
    <tr>
        <td><?=$item->name;?></td>
        <td><?=$item->enabled;?>
            <?php if ($item->enabled) { ?>
            <span class="label label-success">Enabled</span>
            <?php } else { ?>
            <span class="label label-danger">Disabled</span>
            <?php } ?>
        </td>
        <td>
            <a href="<?=url('manu/open/'.$item->id);?>" class="btn btn-success">Edit</a>
        </td>
        
    </tr>
    <?php } ?>
    
</table>

<a href="<?=url('menu/add');?>" class="btn btn-success">Create menu</a>