<script>
    var audience_options = {
        url: '<?= url('person/getaudiences') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', '<?= varlang('consilier'); ?>', '<?= varlang('name-8'); ?>', '<?= varlang('phone-2'); ?>', '<?= varlang('email-7'); ?>', '<?= varlang('date-8'); ?>'],
        colModel: [ 
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'full_name', index: 'full_name', height: 50, resizable: true, sortable:false, align: "left", editable: true, edittype: "text"},
            {name: 'name', index: 'name', resizable: true, sortable:false, align: "left", sorttype: "text", editable: false, edittype: "text"},
            {name: 'phone', index: 'last_name', resizable: true, sortable:false, align: "left", sorttype: "text", editable: false, edittype: "text"},
            {name: 'email', index: 'email', resizable: true, sortable:false, align: "left", sorttype: "text", editable: false, edittype: "text"},
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
        editurl: '',
        loadComplete: function() {
            $("#pager-audience_list_left table").hide();
        }
    };
</script>

<?= View::make('sections/jqgrid/form')->with(array(
    'options' => 'audience_options',
    'id' => 'audience_list'
)); ?>
