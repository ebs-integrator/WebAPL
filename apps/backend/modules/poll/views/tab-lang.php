<form class="ajax-auto-submit" action='<?= url('poll/save_lang'); ?>' method='post'>
    <input type='hidden' name='poll_id' value='<?= isset($poll->id) ? $poll->id : 0; ?>' />
    <input type='hidden' name='poll_question_id' value='<?= isset($poll_question->id) ? $poll_question->id : 0; ?>' />
    <input type='hidden' name='lang_id' value='<?= isset($lang->id) ? $lang->id : 0; ?>' />

    <table class="table table-bordered table-hover">
        <tr>
            <th><?= varlang('question-'); ?></th>
            <td>
                <input type="text" name="question" class='form-control' value='<?= isset($poll_question->title) ? $poll_question->title : ''; ?>' />
            </td>
        </tr>
    </table>

</form>