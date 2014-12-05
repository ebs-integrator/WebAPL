<h3><?= varlang('calendar-1'); ?></h3>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#elist" role="tab" data-toggle="tab"><?= varlang('event-list'); ?></a></li>
    <li><a href="#egroups" role="tab" data-toggle="tab"><?= varlang('event-group'); ?></a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="elist">
        <script>
            var elist_options = {
                url: '<?= url('calendar/getlist') ?>',
                datatype: "json",
                mtype: 'POST',
                autoencode: true,
                loadonce: false,
                colNames: ['ID', '<?= varlang('event-date-'); ?>', '<?= varlang('title--5'); ?>', '<?= varlang('period-'); ?>', '<?= varlang('enabled--3'); ?>'],
                colModel: [
                    {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
                    {name: 'event_date', index: 'event_date', height: 50, resizable: true, sortable: false, align: "left", editable: true, edittype: "text"},
                    {name: 'title', index: 'title', resizable: true, sortable: false, align: "left", sorttype: "text", editable: false, edittype: "text"},
                    {name: 'period', index: 'period', resizable: true, sortable: false, align: "left", sorttype: "text", editable: false, edittype: "text"},
                    {name: 'enabled', index: 'enabled', resizable: true, sortable: false, align: "left", sorttype: "text", editable: true, edittype: "select", editoptions: {value: '0:Disabled;1:Enabled'}, formatter: function(value) {
                            return "<center data-value='" + value + "'>" + (value ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>') + "</center>";
                        }, unformat: function(value) {
                            return value === 'Enabled' ? 1 : 0;
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
            'options' => 'elist_options'
        ));
        ?>

        <form action="<?= url('calendar/create'); ?>" method='post'>
            <div class='c20'></div>
            <h4><?= varlang('create-new-event'); ?></h4>

            <select class="chzn-select" name="general[calendar_group_id]">
                <option value="0">---</option>
                <?php foreach ($groups as $group) { ?>
                    <option value="<?= $group->id; ?>"><?= $group->name; ?></option>
                <?php } ?>
            </select>
            <br><br>
            <?php foreach (\WebAPL\Language::getList() as $lang) { ?>
                <input class="form-control" name="lang[<?= $lang->id; ?>][name]" placeholder="<?= varlang('event-name-in-'); ?><?= $lang->name; ?>"/>
                <div class='c10'></div>
            <?php } ?>
            <div class='c20'></div>
            <input class='form-control' type="text" name="general[period]" placeholder="<?= varlang('period-'); ?>" />
            <div class='c10'></div>
            <input class='form-control datetimepicker' data-date-format="YYYY-MM-DD HH:mm:ss" type='text' name='general[date]' placeholder="<?= varlang('event-date-'); ?>" value='<?= date("Y-m-d H:i:s"); ?>' />
            <br>
            <button class="btn btn-success"><?= varlang('creaza-eveniment'); ?></button>
            <div class='c20'></div>
        </form>

    </div>

    <div class="tab-pane" id="egroups">
        <script>
            var egroups_options = {
                url: '<?= url('calendar/getgroups') ?>',
                datatype: "json",
                mtype: 'POST',
                autoencode: true,
                loadonce: false,
                colNames: ['ID', 'Name'],
                colModel: [
                    {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
                    {name: 'name', index: 'name', height: 50, resizable: true, sortable: false, align: "left", editable: true, edittype: "text"}
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
                editurl: '<?= url('calendar/editgroup') ?>',
                loadComplete: function() {
                }, ight: $(window).height() * 0.7,
                onSelectRow: function(rowid) {
                },
                ondblClickRow: function(rowid) {
                    jQuery(this).jqGrid('editGridRow', rowid, {
                        recreateForm: true,
                        closeAfterEdit: true,
                        closeOnEscape: true,
                        reloadAfterSubmit: false
                    });
                },
            };
        </script>

        <?=
        View::make('sections/jqgrid/form')->with(array(
            'id' => 'calendar_group_list',
            'options' => 'egroups_options'
        ));
        ?>
    </div>
</div>