<script>
    var languages_options = {
        url: '<?= url('home/langs') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', 'Name', 'Ext', 'Enabled'],
        colModel: [
            {name: 'id', index: 'id', editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'name', index: 'name', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
            {name: 'ext', index: 'ext', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "text"},
            {name: 'enabled', index: 'enabled', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "text"},
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
        editurl: '<?= url('home/editlang') ?>',
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
    }
</script>

<?= View::make('sections/jqgrid/form')->with('options', 'languages_options'); ?>