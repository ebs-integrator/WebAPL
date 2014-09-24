
<h2>Feeds</h2>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#posts" role="tab" data-toggle="tab">Posts</a></li>
    <li><a href="#feeds" role="tab" data-toggle="tab">Feeds</a></li>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="posts">

        <?= View::make('sections/feed/allposts'); ?>
        
    </div>
    <div class="tab-pane" id="feeds">


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
                        <a href="<?= url('feed/edit/' . $item->id); ?>" class="btn btn-success">Manage</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <div class="c20"></div>

        <a href="<?= url('feed/create'); ?>" class="btn btn-success">Create new feed</a>

    </div>
</div>