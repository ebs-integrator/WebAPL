<script>
    var person_options = {
        url: '<?= url('person/getlist') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', 'First Name', 'Last Name'],
        colModel: [
            {name: 'person_id', index: 'person_id', editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'first_name', index: 'first_name', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
            {name: 'last_name', index: 'last_name', resizable: true, align: "left", sorttype: "text", editable: false, edittype: "text"},
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
        editurl: '',
        loadComplete: function() {
            $("#pager-mperson_left table").hide();
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('person/form') ?>/'+rowid;
        }
    };
</script>

<?= View::make('sections/jqgrid/form')->with(array(
    'options' => 'person_options',
    'id' => 'mperson'
)); ?>

<div class="c20"></div>
<a href="<?=url('person/emptyperson');?>" class="btn btn-success">New person</a>