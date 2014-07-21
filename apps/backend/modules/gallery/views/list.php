<h3>
    Gallery list:
</h3>

<table class="table table-bordered">
    <?php foreach ($list as $item) { ?>
    <tr>
        <td><?=$item->id;?></td>
        <td><?=$item->name;?></td>
        <td>
            <a class="btn btn-success" href="<?=url('gallery/edit/'.$item->id);?>">Edit</a> 
            <a class="btn btn-danger" href="<?=url('gallery/delete/'.$item->id);?>">Delete</a>
        </td>
    </tr>
    <?php } ?>
</table>

<form action="<?=url('gallery/create');?>" method="post">
    <input type="text" class="form-control col-xs-push-4" placeholder="Gallery name" name="name" />
    <div class="c10"></div>
    <input type="submit" class="btn btn-success" value="Create gallery" />
</form>