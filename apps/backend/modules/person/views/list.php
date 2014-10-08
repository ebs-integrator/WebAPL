<h2><?= varlang('persons'); ?></h2>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#plist" role="tab" data-toggle="tab"><?= varlang('persons-1'); ?></a></li>
    <li><a href="#pgroups" role="tab" data-toggle="tab"><?= varlang('person-groups'); ?></a></li>
    <li><a href="#audience" role="tab" data-toggle="tab"><?= varlang('audience'); ?></a></li>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="plist">
        <?= Template::moduleView($module, 'views.tab-person-list'); ?>
    </div>
    <div class="tab-pane" id="pgroups">
        <?= Template::moduleView($module, 'views.tab-group-list'); ?>
    </div>
    <div class="tab-pane" id="audience">
        <?= Template::moduleView($module, 'views.tab-audience-list'); ?>
    </div>
</div>