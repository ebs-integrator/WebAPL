<h3><?= varlang('acte-locale'); ?></h3>

<script>
    var actelocale_options = {
        url: '<?= url('actelocale/getlist') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', '<?= varlang('nr-5'); ?>', '<?= varlang('title-5'); ?>', '<?= varlang('type-1'); ?>', '<?= varlang('date-6'); ?>', '<?= varlang('emitent'); ?>'],
        colModel: [
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'nr', index: 'nr', height: 50, resizable: true, sortable:false, align: "left", editable: true, edittype: "text"},
            {name: 'title', index: 'title', resizable: true, sortable:false, align: "left", sorttype: "text", editable: true, edittype: "text"},
            {name: 'type', index: 'type', resizable: true, sortable:false, align: "left", sorttype: "text", editable: true, edittype: "text"},
            {name: 'date', index: 'date', resizable: true, sortable:false, align: "left", sorttype: "text", editable: true, edittype: "text"},
            {name: 'emitent', index: 'emitent', resizable: true, sortable:false, align: "left", sorttype: "text", editable: true, edittype: "text"},
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
            $("#pager-actelocale_list_left table").hide();
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('actelocale/edit') ?>/' + rowid;
        }
    };
</script>

<a href="<?= url('actelocale/create'); ?>" class="btn btn-success"><?= varlang('new-record'); ?></a>
<div class="c20"></div>
<?=
View::make('sections/jqgrid/form')->with(array(
    'id' => 'actelocale_list',
    'options' => 'actelocale_options'
));
?>
