<script>
    var poll_options = {
        url: '<?= url('poll/getlist') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', '<?= varlang('title-7'); ?>', '<?= varlang('date-created'); ?>', '<?= varlang('enabled-7'); ?>'],
        colModel: [ 
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'title', index: 'title', height: 50, resizable: true, sortable:false, align: "left", editable: true, edittype: "text"},
            {name: 'date_created', index: 'date_created', height: 50, resizable: true, sortable:false, align: "left", editable: true, edittype: "text"},
            {name: 'enabled', index: 'enabled', resizable: true, sortable:false, align: "left", sorttype: "text", editable: true, edittype: "select", editoptions: {value: '0:Disabled;1:Enabled'}, formatter: function(value) {
                    return "<center data-value='" + value + "'>" + (value ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>') + "</center>";
                }, unformat: function(value) {
                    return value === 'Enabled' ? 1 : 0;
                }}
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

<h2><?= varlang('polls'); ?></h2>

<a href="<?= url('poll/form'); ?>" class="btn btn-success" type="submit"><?= varlang('create-new-poll'); ?></a>

<div class="c20"></div>

<?= View::make('sections/jqgrid/form')->with('options', 'poll_options'); ?>
