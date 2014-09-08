<script>
    var jobrequest_options = {
        url: '<?= url('jobrequest/getlist') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', 'Post', 'Name', 'CV', 'Date'],
        colModel: [
            {name: 'id', index: 'id', editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'title', index: 'title', height: 50, resizable: true, align: "left", editable: false, edittype: "text"},
            {name: 'name', index: 'name', resizable: true, align: "left", sorttype: "text", editable: false, edittype: "text"},
            {name: 'cv_path', index: 'cv_path', resizable: true, align: "left", sorttype: "text", editable: false, edittype: "select", editoptions: {value: '0:Disabled;1:Enabled'}, formatter: function(value) {
                    return "<a href='" + value + "' target='_blank'>CV</a>";
                }},
            {name: 'date_created', index: 'date_created', resizable: true, align: "left", sorttype: "text", editable: false, edittype: "text"},
        ],
        rowNum: 15,
        multiselect: false,
        rowList: [15, 30, 45],
        pager: '',
        altRows: true,
        sortname: 'id',
        viewrecords: true,
        sortorder: "asc",
        height: $(window).height() * 0.7,
        width: $('#content').width() - 70,
        caption: "",
        editurl: '<?= url('jobrequest/edititem') ?>',
        loadComplete: function() {
        },
        onSelectRow: function() {
        }
    };
</script>

<?= View::make('sections/jqgrid/form')->with('options', 'jobrequest_options'); ?>