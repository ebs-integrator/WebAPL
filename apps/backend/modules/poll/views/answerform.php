<h2>Edit answer</h2>

<form class="ajax-auto-submit" action='<?= url('poll/answer/save'); ?>' method='post'>
    <input type='hidden' name='answer_id' value='<?= isset($answer->id) ? $answer->id : 0; ?>' />

    <table class="table table-bordered">
        <?php foreach ($answer_langs as $answer_lang) { ?>
        <tr>
            <th>Answer in <?=\Core\APL\Language::getItem($answer_lang->lang_id)->name;?></th>
            <td>
                <input type="text" name="answer[<?=$answer_lang->id;?>]" class='form-control' value='<?= isset($answer_lang->text) ? $answer_lang->text : ''; ?>' />
            </td>
        </tr>
        <?php } ?>
    </table>

</form>