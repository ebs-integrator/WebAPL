<script>
    var allfeeds_options = {
        url: '<?= url('feed/allfeeds') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', '<?= varlang('name-3'); ?>', '<?= varlang('state'); ?>'],
        colModel: [
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'name', index: 'name', height: 50, resizable: true, sortable:false, align: "left", editable: true, edittype: "text"},
            {name: 'enabled', index: 'enabled', resizable: true, sortable:false, align: "left", sorttype: "text", editable: true, edittype: "select", editoptions: {value: '0:<?= varlang('inactive'); ?>;1:<?= varlang('active'); ?>'}, formatter: function(value) {
                    return "<center data-value='" + value + "'>" + (value == 1 ? '<span class="label label-success"><?= varlang('active'); ?></span>' : '<span class="label label-danger"><?= varlang('inactive'); ?></span>') + "</center>";
                }, unformat: function(value) {
                    return value === '<?= varlang('active'); ?>' ? 1 : 0;
                }}
        ],
        rowNum: 30,
        multiselect: false,
        rowList: [30, 50, 100, 200, 500],
        pager: '',
        altRows: true,
        //sortname: 'id',
        viewrecords: false,
        //sortorder: "asc",
        height: $(window).height() * 0.7,
        width: $('#content').width() - 70,
        caption: "",
        loadComplete: function() {
            $("#pager-allfeeds_left table").hide();
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('feed/edit') ?>/' + rowid;
        }
    }
</script>


<a href="<?= url('feed/create'); ?>" class="btn btn-success"><?= varlang('create-new-feed'); ?></a>
<div class="c20"></div>
<?= View::make('sections/jqgrid/form')->with('options', 'allfeeds_options')->with('id', 'allfeeds'); ?>

