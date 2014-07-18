<div class="col-sm-6">
    <h3>Create link:</h3>
    <div class="panel-group" id="accordion">
        <?= Actions::call('create_menu_items_form'); ?>
    </div>
</div>

<div class="col-sm-6">
    <h3>Order links:</h3>
    <div class="dd">
        <?= View::make('sections.menu.block-treeview', array('items' => $menuItems)); ?>
    </div>
</div>


<div class="modal fade" id="editnode-dialog" tabindex="-1" role="dialog" aria-labelledby="edit-node-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="edit-node-modal">Edit menu item</h4>
            </div>
            <form id="menu-node-form">
                <div class="modal-body" id="edit-node-body"> text </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-menu-node">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= res('assets/lib/nestable/jquery.nestable.js'); ?>"></script>
<link rel="stylesheet" href="<?= res('assets/lib/nestable/nestable.css'); ?>">
<script>

    function menu_tree_update() {
        $.post('<?= url('menu/gettree'); ?>', {menu_id: <?= $menu->id; ?>}, function(data) {
            $(".dd").html(data).nestable({});
        }, 'html');
    }

    jQuery(document).ready(function($) {
        $('.dd').nestable({});

        $('budy').on('change', '.dd', function() {
            $.post('<?= url('menu/savetree'); ?>', {tree: $('.dd').nestable('serialize')}, function() {

            }, 'json');
        });

        $("body").on('click', '.remove-tree-node', function() {
            if (confirm("Delete this node?")) {
                $.post('<?= url('menu/deletenode'); ?>', {id: $(this).data('id')}, function() {
                    menu_tree_update();
                }, 'json');
            }
        });

        $("body").on('click', '.edit-tree-node', function() {
            $.post('<?= url('menu/editnode'); ?>', {id: $(this).data('id')}, function(data) {
                $("#edit-node-body").html(data);
                $('#editnode-dialog').modal();
            }, 'html');
        });
        
        $("body").on('click', '#save-menu-node', function() {
            $.post('<?= url('menu/savenode'); ?>', $("#menu-node-form").serialize(), function(data) {
                $('#editnode-dialog').modal('hide');
                menu_tree_update();
            }, 'json');
        });
    });
</script>