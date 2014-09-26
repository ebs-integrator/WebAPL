<script>
    var newsletter_options = {
        url: '<?= url('newsletter/getlist') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', 'Email', 'Subscribe Date', 'Enabled'],
        colModel: [
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'email', index: 'email', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
            {name: 'subscribe_date', index: 'subscribe_date', resizable: true, align: "left", sorttype: "text", editable: false, edittype: "text"},
            {name: 'enabled', index: 'enabled', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "select", editoptions: {value: '0:Disabled;1:Enabled'}, formatter: function(value) {
                    return "<center data-value='" + value + "'>" + (value ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>') + "</center>";
                }, unformat: function(value) {
                    return value === 'Enabled' ? 1 : 0;
                }}
        ],
        rowNum: 15,
        multiselect: true,
        rowList: [15, 30, 45],
        pager: '',
        altRows: true,
        sortname: 'id',
        viewrecords: true,
        sortorder: "asc",
        height: $(window).height() * 0.7,
        width: $('#content').width() - 70,
        caption: "",
        editurl: '<?= url('newsletter/edititem') ?>',
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
        onSelectRow: function() {
        }
    };
</script>

<?= View::make('sections/jqgrid/form')->with('options', 'newsletter_options'); ?>