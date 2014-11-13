<script>
    var events_options = {
        url: '<?= url('calendar/get_person_list/' . $person['id']) ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', 'Titlu'],
        colModel: [
            {name: 'id', index: 'id', editable: false, editoptions: {readonly: true, size: 10}, hidden: true},
            {name: 'title', index: 'title', height: 50, resizable: true, sortable: false, align: "left", editable: true, edittype: "text"},
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
            $("#pager-pevents_left table").hide();
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('calendar/edit') ?>/' + rowid;
        }
    };
</script>


<div class="c20"></div>

<?=
View::make('sections/jqgrid/form')->with(array(
    'options' => 'events_options',
    'id' => 'pevents'
));
?>
