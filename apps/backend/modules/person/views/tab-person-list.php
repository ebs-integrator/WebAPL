<script>
    var person_options = {
        url: '<?= url('person/getlist') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', '<?= varlang('first-name-'); ?>', '<?= varlang('last-name-'); ?>', '<?= varlang('groups-'); ?>'],
        colModel: [
            {name: 'person_id', index: 'person_id', editable: false, editoptions: {readonly: true, size: 10}, hidden: true},
            {name: 'first_name', index: 'first_name', height: 50, resizable: true, sortable:false, align: "left", editable: true, edittype: "text"},
            {name: 'last_name', index: 'last_name', resizable: true, sortable:false, align: "left", sorttype: "text", editable: false, edittype: "text"},
            {name: 'grupe', index: 'grupe', resizable: true, sortable:false, align: "left", sorttype: "text", editable: false, edittype: "text"},
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
            $("#pager-mperson_left table").hide();
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('person/form') ?>/'+rowid;
        }
    };
</script>


<div class="c20"></div>
<a href="<?=url('person/emptyperson');?>" class="btn btn-success"><?= varlang('new-person'); ?></a>
<div class="c20"></div>

<?= View::make('sections/jqgrid/form')->with(array(
    'options' => 'person_options',
    'id' => 'mperson'
)); ?>
