<script>
    var allposts_options = {
        url: '<?= url('feed/allposts') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', 'Title', 'Date'],
        colModel: [
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'title', index: 'title', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
            {name: 'date', index: 'date', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "text"},
        ],
        rowNum: 30,
        multiselect: false,
        rowList: [30, 50, 100],
        pager: '',
        altRows: true,
        //sortname: 'id',
        viewrecords: false,
        //sortorder: "asc",
        height: $(window).height() * 0.7,
        width: $('#content').width() - 70,
        caption: "",
        loadComplete: function() {
            $("#pager-allposts_left table").hide();
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('feed/editpost') ?>/' + rowid;
        }
    }
</script>


<a href="<?= url('feed/newpost'); ?>" class="btn btn-success">Create new post</a>
<div class="c20"></div>
<?= View::make('sections/jqgrid/form')->with('options', 'allposts_options')->with('id', 'allposts'); ?>

