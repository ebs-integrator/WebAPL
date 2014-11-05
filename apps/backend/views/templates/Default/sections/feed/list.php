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
        <?= View::make('sections/feed/allfeeds'); ?>
    </div>
    <div class="tab-pane" id="trash">
        <div class="c20"></div>
        <?= View::make('sections/feed/alltrash'); ?>
    </div>
</div>