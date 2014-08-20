<h3><a href="<?=url('person/list');?>">Persons</a> / Person form</h3>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
    <?php foreach (Language::getList() as $lang) { ?>
        <li><a href="#lang<?= $lang->id; ?>" role="tab" data-toggle="tab">Language <?= $lang->name; ?></a></li>
    <?php } ?>
    <?php if ($person) { ?>
        <li><a href="#dynamic" role="tab" data-toggle="tab">Dynamic fields</a></li>
    <?php } ?>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="general">
        <?php
        echo Template::moduleView($module, 'views.tab-general', array(
            'person' => $person
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
</div>