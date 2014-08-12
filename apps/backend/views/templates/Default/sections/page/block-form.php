<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
    <?php foreach ($page_langs as $plang) { ?>
        <li><a href="#lang<?= $plang->id; ?>" role="tab" data-toggle="tab">Language <?= Language::getItem($plang->lang_id)->name; ?></a></li>
    <?php } ?>
    <li><a href="#files" role="tab" data-toggle="tab">Files</a></li>
    <!--<li><a href="#actelocale" role="tab" data-toggle="tab">Acte Locale</a></li>-->
    <li><a href="#attachment" role="tab" data-toggle="tab">Attachment</a></li>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="general">
        <?= View::make('sections.page.tab-general'); ?>
    </div>
    <?php foreach ($page_langs as $plang) { ?>
        <div class="tab-pane" id="lang<?= $plang->id; ?>">
            <?= View::make('sections.page.tab-lang', array('plang' => $plang)); ?>
        </div>
    <?php } ?>
    <div class="tab-pane" id="files">
        <div class='c20'></div>
        <?= Files::widget('page', $page->id); ?>
    </div>
    <div class="tab-pane" id="actelocale">
        <?= View::make('sections.page.tab-actelocale'); ?>
    </div>
    <div class="tab-pane" id="attachment">
        <table class="table table-bordered">
            <?=Actions::call('page_attachment', $page);?>
        </table>
    </div>
</div>


