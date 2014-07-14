<h3>Menu</h3>
<form action='<?= url('menu/save'); ?>' method='post'>

    <input type='hidden' name='id' value='<?= isset($menu['id']) ? $menu['id'] : 0; ?>' />

    <ul class="nav nav-tabs" role="tablist" id="form-tabs">
        <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
        <li><a href="#links" role="tab" data-toggle="tab">Links</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="general">
            <?=View::make('sections.menu.tab-general');?>
        </div>
        <div class="tab-pane" id="links">
            <?=View::make('sections.menu.tab-links');?>
        </div>
    </div>

    <input type='submit' value='Save' class='btn btn-success pull-right' />

</form>

<div class='clearfix'></div>