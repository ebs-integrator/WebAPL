<h3><a href="<?= url('poll/list'); ?>">Polls</a> / Poll form</h3>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
    <?php foreach (Language::getList() as $lang) { ?>
        <li><a href="#lang<?= $lang->id; ?>" role="tab" data-toggle="tab">Language <?= $lang->name; ?></a></li>
    <?php } ?>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="general">
        <?php
        echo Template::moduleView($module, 'views.tab-general', array(
            'poll' => $poll
        ));
        ?>
    </div>
    <?php foreach (Language::getList() as $lang) { ?>
        <div class="tab-pane" id="lang<?= $lang->id; ?>">
            <?php
            echo Template::moduleView($module, 'views.tab-lang', array(
                'poll_question' => isset($poll_question[$lang->id]) ? $poll_question[$lang->id] : array(),
                'poll' => $poll,
                'lang' => $lang
            ));
            ?>
        </div>
    <?php } ?>
</div>