<form class="ajax-auto-submit" action='<?= url('poll/save_lang'); ?>' method='post'>
    <input type='hidden' name='poll_id' value='<?= isset($poll->id) ? $poll->id : 0; ?>' />
    <input type='hidden' name='poll_question_id' value='<?= isset($poll_question->id) ? $poll_question->id : 0; ?>' />
    <input type='hidden' name='lang_id' value='<?= isset($lang->id) ? $lang->id : 0; ?>' />

    <table class="table table-bordered">
        <tr>
            <th>Question: </th>
            <td>
                <input type="text" name="question" class='form-control' value='<?= isset($poll_question->title) ? $poll_question->title : ''; ?>' />
            </td>
        </tr>
    </table>


    <script>
        var poll_<?= ( isset($poll_question->lang_id) ? $poll_question->lang_id : '') ?>_options = {
            url: '<?= url('poll/list/answer/' . ( isset($poll_question->id) ? $poll_question->id : '')) ?>',
            datatype: "json",
            mtype: 'POST',
            autoencode: true,
            loadonce: false,
            colNames: ['ID', 'Answer'],
            colModel: [ 
                {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}, width: 10},
                {name: 'answer', index: 'answer', height: 50, resizable: true, align: "left", editable: true, edittype: "text"}
            ],
            rowNum: 30,
            multiselect: true,
            rowList: [30, 50, 100],
            pager: '',
            altRows: true,
            sortname: 'id',
            viewrecords: true,
            sortorder: "asc",
            height: $(window).height() * 0.7,
            width: $('#content').width() - 70,
            caption: "",
            editurl: '<?= url('poll/edititem/' . ( isset($poll_question->id) ? $poll_question->id : '' )) ?>',
            ondblClickRow: function(rowid) {
                jQuery(this).jqGrid('editGridRow', rowid, {
                    recreateForm: true,
                    closeAfterEdit: true,
                    closeOnEscape: true,
                    reloadAfterSubmit: false
                });
            },
            loadComplete: function() {
            }
        };
    </script>

    <?= View::make('sections/jqgrid/form')->with('options', 'poll_'. ( isset($poll_question->lang_id) ? $poll_question->lang_id : '') .'_options'); ?>

</form>