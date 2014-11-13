<h3><a href="<?= url('person/list'); ?>"><?= varlang('persons-1'); ?></a> / <?= varlang('edit-person-1'); ?></h3>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#general" role="tab" data-toggle="tab"><?= varlang('general-5'); ?></a></li>
    <?php foreach (Language::getList() as $lang) { ?>
        <li><a href="#lang<?= $lang->id; ?>" role="tab" data-toggle="tab"><?= $lang->name; ?></a></li>
    <?php } ?>
    <?php if ($person) { ?>
        <li><a href="#dynamic" role="tab" data-toggle="tab"><?= varlang('dynamic-fields'); ?></a></li>
    <?php } ?>
    <li><a href="#events" role="tab" data-toggle="tab"><?= varlang('evenimente'); ?></a></li>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="general">
        <?php
        echo Template::moduleView($module, 'views.tab-general', array(
            'person' => $person,
            'selected_groups' => $selected_groups,
            'person_groups' => $person_groups,
            'feeds' => $feeds
        ));
        ?>
    </div>
    <?php foreach (Language::getList() as $lang) { ?>
        <div class="tab-pane" id="lang<?= $lang->id; ?>">
            <?php
            echo Template::moduleView($module, 'views.tab-lang', array(
                'person_lang' => isset($person_lang[$lang->id]) ? $person_lang[$lang->id] : array(),
                'person' => $person,
                'lang' => $lang
            ));
            ?>
        </div>
    <?php } ?>
    <?php if ($person) { ?>
        <div class="tab-pane" id="dynamic">
            <?php
            echo Template::moduleView($module, 'views.tab-dynamic', array(
                'person' => $person
            ));
            ?>
        </div>
    <?php } ?>
    <div class="tab-pane" id="events">
        <?php
        echo Template::moduleView($module, 'views.tab-events', array(
            'person' => $person
        ));
        ?>
    </div>
</div>

<form action="<?= url('person/delete'); ?>" method="post">
    <input type="hidden" name="id" value="<?= $person->id; ?>" />

    <button type="submit" class="btn btn-danger pull-right" onclick="return confirm('<?= varlang('confirm-person-delete'); ?>');"><?= varlang('delete-person'); ?></button>
</form>