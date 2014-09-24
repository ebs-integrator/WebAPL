<script>
    var posts_options = {
        url: '<?= url('feed/allposts') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', 'Title', 'Date', 'Views'],
        colModel: [
            {name: 'id', index: 'id', editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'title', index: 'title', height: 50, resizable: true, align: "left", editable: true, edittype: "text"},
            {name: 'date', index: 'date', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "text"},
            {name: 'views', index: 'views', resizable: true, align: "left", sorttype: "text", editable: true, edittype: "text"},
        ],
        rowNum: 15,
        multiselect: false,
        rowList: [15, 30, 45],
        pager: '',
        altRows: true,
        //sortname: 'id',
        viewrecords: false,
        //sortorder: "asc",
        height: $(window).height() * 0.7,
        width: $('#content').width() - 70,
        caption: "",
        loadComplete: function() {
            $("#add_list, #edit_list, #del_list").hide();
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('feed/editpost') ?>/'+rowid;
        }
    }
</script>

<?= View::make('sections/jqgrid/form')->with('options', 'posts_options'); ?>

<div class="c20"></div>
<a href="<?= url('feed/newpost'); ?>" class="btn btn-success">Create new post</a>