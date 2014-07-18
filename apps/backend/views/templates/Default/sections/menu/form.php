<h3>Menu</h3>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
    <?php if (isset($menu) && $menu) { ?>
        <li><a href="#links" role="tab" data-toggle="tab">Links</a></li>
    <?php } ?>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="general">
        <?= View::make('sections.menu.tab-general'); ?>
    </div>
    <?php if (isset($menu) && $menu) { ?>
        <div class="tab-pane" id="links">
            <?= View::make('sections.menu.tab-links'); ?>
        </div>
    <?php } ?>
</div>

<div class='clearfix'></div>