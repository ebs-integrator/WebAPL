<h3><?= varlang('edit-post'); ?>:
    <?php if (isset($post_langs[WebAPL\Language::getId()])) { ?>
        <?= $post_langs[WebAPL\Language::getId()]->title; ?>
    <?php } else { ?>
        #<?= $general['post']->id; ?>
    <?php } ?>
    <?php if ($general['post']->is_trash) { ?>
        <a href='<?= url('feed/restore/' . $general['post']->id); ?>' onclick="return confirm('Restore this post?');" class='btn btn-success btn-sm'><?= varlang('restore'); ?></a>
    <?php } else { ?>
        <a href='<?= url('feed/trash/' . $general['post']->id); ?>' onclick="return confirm('Move this post to trash?');" class='btn btn-danger btn-sm'><?= varlang('trash-1'); ?></a>
    <?php } ?>
</h3>

<a href='<?= url('feed'); ?>'><?= varlang('feeds-1'); ?></a> / <?= varlang('edit-post'); ?>
<?php if (isset($post_langs[WebAPL\Language::getId()])) { ?>
    / <?= $post_langs[WebAPL\Language::getId()]->title; ?>
<?php } ?>


<div class='c10'></div>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#general" role="tab" data-toggle="tab"><?= varlang('general'); ?></a></li>
    <?php
    foreach (Language::getList() as $lang)
        if (isset($post_langs[$lang->id])) {
            ?>
            <li><a href="#lang<?= $lang->id; ?>" role="tab" data-toggle="tab"><?= varlang('varianta-in'); ?> <?= $lang->name; ?></a></li>
        <?php } ?>
    <li><a href="#media" role="tab" data-toggle="tab"><?= varlang('media'); ?></a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="general">
        <?= View::make('sections.feed.tab-post-general')->with($general)->render(); ?>
    </div>
    <?php
    foreach (Language::getList() as $lang) {
        if (isset($post_langs[$lang->id])) {
            ?>
            <div class="tab-pane" id="lang<?= $lang->id; ?>">
                <?= View::make('sections.feed.tab-post-lang')->with('post_lang', $post_langs[$lang->id])->with('post', $general['post']); ?>
            </div>
        <?php }
    }
    ?>
    <div class="tab-pane" id="media">
        <div class="c20"></div>
        <?= Files::widget('post_cover', $general['post']->id, 1); ?>
    </div>
</div>

<?php if ($general['post']->is_trash) { ?>
    <form method="post" action="<?= url('feed/delete'); ?>">
        <input type="hidden" name="id" value="<?= $general['post']->id; ?>" />

        <input type="submit" class="btn btn-danger pull-right" onclick="return confirm('<?= varlang('delete-this-post'); ?>');" value="<?= varlang('delete-this-post-1'); ?>" />
    </form>
    <div class='c10'></div>
<?php } ?>