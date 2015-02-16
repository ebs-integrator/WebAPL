<script>
    function checkbox_formatter(value) {
        if (value) {
            return "Enabled";
        } else {
            return "Disabled";
        }
    }

    var languages_options = {
        url: '<?= url('home/langs') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', '<?= varlang('name-10'); ?>', '<?= varlang('ext-1'); ?>', '<?= varlang('enabled-9'); ?>'],
        colModel: [
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 30}},
            {name: 'name', index: 'name', height: 50, resizable: true, sortable:false, align: "left", editable: true, edittype: "text"},
            {name: 'ext', index: 'ext', resizable: true, sortable:false, align: "left", sorttype: "text", editable: true, edittype: "text"},
            {name: 'enabled', index: 'enabled', resizable: true, sortable:false, align: "left", sorttype: "text", editable: true, edittype: "select", editoptions: {value: '0:Disabled;1:Enabled', size: 1}, formatter: function(value) {
                    return "<center data-value='" + value + "'>" + (value == 1 ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>') + "</center>";
                }, unformat: function(value) {
                    return value === 'Enabled' ? 1 : 0;
                }},
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

<!--- Promote RO Language
<h3><?= varlang('limba-implicita'); ?></h3>
<form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">
    <select name="set[default_language]" class="form-control">
        <?php foreach (WebAPL\Language::getList() as $language) { ?>
            <option value="<?= $language->id; ?>" <?= SettingsModel::one('default_language') == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
        <?php } ?>
    </select>
</form>
--->

<h3><?= varlang('limbi-disponibile'); ?></h3>
<?= View::make('sections/jqgrid/form')->with('options', 'languages_options'); ?>