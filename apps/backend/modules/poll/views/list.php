<script>
    var poll_options = {
        url: '<?= url('poll/getlist') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', 'Title', 'Date Created', 'Enabled'],
        colModel: [ 
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'title', index: 'title', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
            {name: 'date_created', index: 'date_created', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
            {name: 'enabled', index: 'enabled', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "select", editoptions: {value: '0:Disabled;1:Enabled'}, formatter: function(value) {
                    return "<center data-value='" + value + "'>" + (value ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>') + "</center>";
                }, unformat: function(value) {
                    return value === 'Enabled' ? 1 : 0;
                }}
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
        editurl: '<?= url('poll/edititem') ?>',
        ondblClickRow: function(rowid) {
            jQuery(this).jqGrid('editGridRow', rowid, {
                recreateForm: true,
                closeAfterEdit: true,
                closeOnEscape: true,
                reloadAfterSubmit: false
            });
        },
        loadComplete: function() {
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('poll/form') ?>/' + rowid;
        }
    };
</script>

<?= View::make('sections/jqgrid/form')->with('options', 'poll_options'); ?>

<div class="c20"></div>

<a href="<?= url('poll/form'); ?>" class="btn btn-success" type="submit">Create new poll</a>