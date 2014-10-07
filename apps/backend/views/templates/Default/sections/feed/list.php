<h2><?= varlang('feeds-1'); ?></h2>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#posts" role="tab" data-toggle="tab"><?= varlang('post-list'); ?></a></li>
    <li><a href="#feeds" role="tab" data-toggle="tab"><?= varlang('list-1'); ?></a></li>
    <li><a href="#trash" role="tab" data-toggle="tab"><?= varlang('trash-post'); ?></a></li>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="posts">
        <div class="c20"></div>
        <?= View::make('sections/feed/allposts'); ?>
    </div>
    <div class="tab-pane" id="feeds">
        <div class="c20"></div>
        <a href="<?= url('feed/create'); ?>" class="btn btn-success"><?= varlang('create-new-post'); ?></a>
        <div class="c20"></div>
        <table class="table table-bordered">
            <tr>
                <th><?= varlang('name-3'); ?></th>
                <th><?= varlang('state'); ?></th>
                <th><?= varlang('action'); ?></th>
            </tr>
            <?php foreach ($list as $item) { ?>
                <tr>
                    <td><?= $item->name; ?></td>
                    <td>
                        <?php if ($item->enabled) { ?>
                            <span class="label label-success"><?= varlang('active'); ?></span>
                        <?php } else { ?>
                            <span class="label label-danger"><?= varlang('inactive'); ?></span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="<?= url('feed/edit/' . $item->id); ?>" class="btn btn-success">Manage</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div class="tab-pane" id="trash">
        <div class="c20"></div>
        <?= View::make('sections/feed/alltrash'); ?>
    </div>
</div>