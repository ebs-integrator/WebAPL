<script>
    var person_group_options = {
        url: '<?= url('person/getgroups') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: [
            'ID',
            'Name',
        ],
        colModel: [ 
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'name', index: 'name', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
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
            $("#pager-group_person_left table").hide();
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('person/editgroup') ?>/' + rowid;
        }
    };
</script>

<?=
View::make('sections/jqgrid/form')->with(array(
    'options' => 'person_group_options',
    'id' => 'group_person'
));
?>

<div class="c20"></div>
<form action="<?=url('person/savegroup');?>" method="post">
    <h3>Create new group</h3>
    <?php foreach (\Core\APL\Language::getList() as $lang) { ?>
        Name in <?= $lang->name; ?>:<br>
        <input type="text" class="form-control" name="lang[<?= $lang->id; ?>][name]" />
        <div class="c10"></div>
    <?php } ?>

    <button class="btn btn-success">Create group</button>
</form>
