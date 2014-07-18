<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
    <li><a href="#files" role="tab" data-toggle="tab">Files</a></li>
    <li><a href="#aclocale" role="tab" data-toggle="tab">Acte Locale</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="general">
        <?= View::make('sections.page.tab-general'); ?>
    </div>
    <div class="tab-pane" id="files">
        <div class='c20'></div>
        <?=Files::widget('page', $page->id);?>
    </div>
</div>