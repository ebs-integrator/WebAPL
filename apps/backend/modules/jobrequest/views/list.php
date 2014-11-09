<h2><?= varlang('recrut'); ?></h2>

<script>
    var jobrequest_options = {
        url: '<?= url('jobrequest/getlist') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', '<?= varlang('post-1'); ?>', '<?= varlang('name-6'); ?>', '<?= varlang('cv-2'); ?>', '<?= varlang('date-7'); ?>'],
        colModel: [
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'title', index: 'title', height: 50, resizable: true, sortable:false, align: "left", editable: false, edittype: "text"},
            {name: 'name', index: 'name', resizable: true, sortable:false, align: "left", sorttype: "text", editable: false, edittype: "text"},
            {name: 'cv_path', index: 'cv_path', resizable: true, sortable:false, align: "left", sorttype: "text", editable: false, edittype: "select", editoptions: {value: '0:<?= varlang('disabled'); ?>;1:<?= varlang('enabled-5'); ?>'}, formatter: function(value) {
                    return "<a href='" + value + "' target='_blank'>CV</a>";
                }},
            {name: 'date_created', index: 'date_created', resizable: true, sortable:false, align: "left", sorttype: "text", editable: false, edittype: "text"},
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
        editurl: '<?= url('jobrequest/edititem') ?>',
        loadComplete: function() {
        },
        onSelectRow: function() {
        }
    };
</script>

<?= View::make('sections/jqgrid/form')->with('options', 'jobrequest_options'); ?>