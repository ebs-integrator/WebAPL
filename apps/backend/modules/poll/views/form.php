<h3><a href="<?= url('poll/list'); ?>"><?= varlang('polls'); ?></a> / <?= varlang('poll-form'); ?></h3>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#general" role="tab" data-toggle="tab"><?= varlang('general-6'); ?></a></li>
    <?php foreach (Language::getList() as $lang) { ?>
        <li><a href="#lang<?= $lang->id; ?>" role="tab" data-toggle="tab"><?= $lang->name; ?></a></li>
    <?php } ?>
</ul>


<div class="tab-content">
    <div class="tab-pane active" id="general">
        <?php
        echo Template::moduleView($module, 'views.tab-general', array(
            'poll' => $poll
        ));
        ?>

        <br>
        <h3><?= varlang('answers'); ?></h3>
        <?php
        echo Template::moduleView($module, 'views.tab-answers', array(
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