<h3>
    <a href="<?= url('poll/list'); ?>"><?= varlang('polls'); ?></a> / 
    <a href="<?= url('poll/form/' . $answer->poll_id); ?>"><?= varlang('poll-form'); ?></a> /
    <?= varlang('edit-answer'); ?>
</h3>

<form class="ajax-auto-submit" action='<?= url('poll/answer/save'); ?>' method='post'>
    <input type='hidden' name='answer_id' value='<?= isset($answer->id) ? $answer->id : 0; ?>' />

    <table class="table table-bordered table-hover">
        <tr>
            <th><?= varlang('ord-2'); ?></th>
            <td>
                <input type="text" name="general[ord]" class='form-control' value='<?= isset($answer->ord) ? $answer->ord : ''; ?>' />
            </td>
        </tr>
        <?php foreach ($answer_langs as $answer_lang) { ?>
        <tr>
            <th><?= varlang('answer-in-'); ?> <?=\WebAPL\Language::getItem($answer_lang->lang_id)->name;?></th>
            <td>
                <input type="text" name="answer[<?=$answer_lang->id;?>]" class='form-control' value='<?= isset($answer_lang->title) ? $answer_lang->title : ''; ?>' />
            </td>
        </tr>
        <?php } ?>
    </table>

</form>

<a onclick="return confirm('<?= varlang('delete-confirm'); ?>');" class="btn btn-danger pull-right" href="<?=url('poll/answer/delete/'.(isset($answer->id) ? $answer->id : 0));?>"><?= varlang('delete-answer'); ?></a>