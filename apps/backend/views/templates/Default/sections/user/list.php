<script>
    var users_options = { 
        url: '<?= url('user/lists') ?>',
        datatype: "json",
        mtype: 'POST',
        autoencode: true,
        loadonce: false,
        colNames: ['ID', '<?= varlang('username-1'); ?>', '<?= varlang('email-4'); ?>'],
        colModel: [
            {name: 'id', index: 'id', hidden: true, editable: false, editoptions: {readonly: true, size: 10}},
            {name: 'username', index: 'username', height: 50, resizable: true, sortable:false, align: "left", editable: true, edittype: "text"},
            {name: 'email', index: 'email', resizable: true, sortable:false, align: "left", sorttype: "text", editable: true, edittype: "text"}
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
        ondblClickRow: function() {
        },
        loadComplete: function() {
            $("#pager-user_list_left table").hide();
        },
        onSelectRow: function(rowid) {
            window.location.href = '<?= url('user/view') ?>/'+rowid;
        }
    }
</script>

<?= View::make('sections/jqgrid/form')->with(array(
    'options' => 'users_options',
    'id' => 'user_list'
)); ?>

<form action="<?=url('user/create');?>" method="post">
    <div class="c20"></div>
    <h3><?= varlang('new-user'); ?></h3>
    <input class="form-control" type="text" name="username" placeholder="<?= varlang('username-1'); ?>"/>
    <div class="c10"></div>
    <input class="form-control" type="email" name="email" placeholder="<?= varlang('email-4'); ?>"/>
    <div class="c10"></div>
    <input class="form-control" type="password" name="password" placeholder="<?= varlang('password-1'); ?>"/>
    <div class="c10"></div>
    <input class="btn btn-success" type="submit" value="<?= varlang('save'); ?>" />
    <div class="c20"></div>
    <div class="c20"></div>
</form>