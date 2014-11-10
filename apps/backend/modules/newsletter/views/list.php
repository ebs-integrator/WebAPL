<h2><?= varlang('newsletter-2'); ?></h2>

<script>
    var newsletter_options = {
        url: '<?= url('newsletter/getlist') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', '<?= varlang('email-5'); ?>', '<?= varlang('subscribe-date'); ?>', '<?= varlang('enabled-6'); ?>'],
        colModel: [
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'email', index: 'email', height: 50, resizable: true, sortable:false, align: "left", editable: true, edittype: "text"},
            {name: 'subscribe_date', index: 'subscribe_date', resizable: true, sortable:false, align: "left", sorttype: "text", editable: false, edittype: "text"},
            {name: 'enabled', index: 'enabled', resizable: true, sortable:false, align: "left", sorttype: "text", editable: true, edittype: "select", editoptions: {value: '0:<?= varlang('dezabonat'); ?>;1:<?= varlang('abonat'); ?>'}, formatter: function(value) {
                    return "<center data-value='" + value + "'>" + (value == 1 ? '<span class="label label-success"><?= varlang('abonat'); ?></span>' : '<span class="label label-danger"><?= varlang('dezabonat'); ?></span>') + "</center>";
                }, unformat: function(value) {
                    return value === '<?= varlang('abonat'); ?>' ? 1 : 0;
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

<a href="<?=url('newsletter/export');?>" class="btn btn-success"><?= varlang('export'); ?></a>
<div class="c20"></div>
<?= View::make('sections/jqgrid/form')->with('options', 'newsletter_options'); ?>