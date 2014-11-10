
<script>
    var lastSel;
    var poll_<?= ( isset($poll->id) ? $poll->id : '') ?>_options = {
        url: '<?= url('poll/list/answer/' . ( isset($poll->id) ? $poll->id : '')) ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', '<?= varlang('answer'); ?>', '<?= varlang('count'); ?>', '<?= varlang('ord-2'); ?>'],
        colModel: [
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}, width: 10},
            {name: 'answer', index: 'answer', height: 50, resizable: true, sortable: false, align: "left", editable: false, edittype: "text"},
            {name: 'count', index: 'count', height: 50, resizable: true, sortable: false, align: "left", editable: false, edittype: "text"},
            {name: 'ord', index: 'ord', height: 50, resizable: true, sortable: false, align: "left", editable: true, edittype: "text"}
        ],
        rowNum: 30,
        multiselect: false,
        rowList: [30, 50, 100, 200, 500],
        pager: '',
        altRows: true,
        sortname: 'id',
        viewrecords: true,
        sortorder: "asc",
        height: $(window).height() * 0.7,
        width: $('#content').width() - 70,
        caption: "",
        editurl: '<?=url('poll/answer/jqsave');?>',
        loadComplete: function() {
            $("#pager-poll_we_left table").hide();
        },
        onSelectRow: function(id) {
            if (id && id !== lastSel) {
                jQuery('#list-poll_we').restoreRow(lastSel);
                lastSel = id;
            }
            jQuery('#list-poll_we').editRow(id, true);
        },
        ondblClickRow: function (rowid) {
            window.location.href = '<?= url('poll/answer/edit') ?>/' + rowid;
        }
    };
</script>

<div class="c20"></div>
<a class="btn btn-success" href="<?= url('poll/anwser/create/' . $poll->id); ?>"><?= varlang('add-answer'); ?></a>
<div class="c20"></div>

<?= View::make('sections/jqgrid/form')->with('options', 'poll_' . ( isset($poll->id) ? $poll->id : '') . '_options')->with('id', 'poll_we'); ?>
