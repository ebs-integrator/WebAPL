<script>
    jQuery(document).ready(function($) {
        $("#add_link_form").on("submit", function(event) {
            event.preventDefault();
            $.post('<?= url('menu/addlink'); ?>', $(this).serialize(), function(data) {
                $("#add_link_form")[0].reset();
                menu_tree_update();
            }, 'json');
            return false;
        });
    });
</script>

<div class="panel panel-default">
    <div class="panel-heading">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><h4 class="panel-title">Add link</h4></a>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
        <div class="panel-body">

            <form id="add_link_form" method="post">
                <input type="hidden" name="id" value="<?= $menu->id; ?>" />
                <?php foreach (Language::getList() as $lang) { ?>
                    <input type="text" name="link[<?= $lang->id; ?>][name]" placeholder="Name in <?= $lang->name; ?>" class="form-control" value="" />
                    <div class="c10"></div>
                    <input type="text" name="link[<?= $lang->id; ?>][link]" placeholder="http://" class="form-control" value="" />
                    <div class="c20"></div>
                <?php } ?>
                <button type="submit" id="add_link_button" class="btn pull-right">Add</button>
            </form>

            <div class="clearfix"></div>
        </div>
    </div>
</div>
