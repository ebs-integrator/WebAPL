<h3>Evenimente</h3>

<script>
    var newsletter_options = {
        url: '<?= url('calendar/getlist') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', 'EventDate', 'Title', 'Period', 'Enabled'],
        colModel: [
            {name: 'id', index: 'id', editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'event_date', index: 'event_date', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
            {name: 'title', index: 'title', resizable: true, align: "left", sorttype: "text", editable: false, edittype: "text"},
            {name: 'period', index: 'period', resizable: true, align: "left", sorttype: "text", editable: false, edittype: "text"},
            {name: 'enabled', index: 'enabled', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "select", editoptions: {value: '0:Disabled;1:Enabled'}, formatter: function(value) {
                    return "<center data-value='" + value + "'>" + (value ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>') + "</center>";
                }, unformat: function(value) {
                    return value === 'Enabled' ? 1 : 0;
                }}
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
            $("#pager-calendar_list_left table").hide();
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('calendar/edit') ?>/' + rowid;
        }
    };
</script>

<?=
View::make('sections/jqgrid/form')->with(array(
    'id' => 'calendar_list',
    'options' => 'newsletter_options'
));
?>

<form action="<?= url('calendar/create'); ?>" method='post'>
    <div class='c20'></div>
    <h4>Create new event</h4>
    <?php foreach (\Core\APL\Language::getList() as $lang) { ?>
        <input class="form-control" name="lang[<?= $lang->id; ?>][name]" placeholder="Event name in <?= $lang->name; ?>"/>
        <div class='c10'></div>
    <?php } ?>
    <div class='c20'></div>
    <input class='form-control' type="text" name="general[period]" placeholder="Period" />
    <div class='c10'></div>
    <input class='form-control' type='text' name='general[date]' placeholder="Data" value='<?=date("Y-m-d H:i:s");?>' />
    <br>
    <button class="btn btn-success">Creaza eveniment</button>
    <div class='c20'></div>
</form>