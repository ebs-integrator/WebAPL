<h3><?= varlang('edit-feed'); ?>: <?=$feed->name;?></h3>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li><a href="#general" role="tab" data-toggle="tab"><?= varlang('edit-feed'); ?></a></li>
    <li class="active"><a href="#posts" role="tab" data-toggle="tab"><?= varlang('post-list'); ?></a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane" id="general">
        <form class="ajax-auto-submit" action="<?=url('feed/save');?>" method="post">
            <input type="hidden" value="<?=$feed->id;?>" name="id" />
            <?= View::make('sections.feed.block-form', array('feed'=>$feed)); ?>
        </form>
        
    </div>

    <div class="tab-pane active" id="posts">
        <div class="c10"></div>
        <a href="<?=url('feed/newpost/'.$feed->id);?>" class="btn btn-success"><?= varlang('create-new-post'); ?></a>
        <div class="c10"></div>
        <?= View::make('sections.feed.block-posts')->with('feed',$feed); ?>
    </div>
</div>
