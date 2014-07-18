<form action='<?= url('menu/save'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($menu['id']) ? $menu['id'] : 0; ?>' />

    <table class="table table-bordered">
        <tr>
            <th>Name: </th>
            <td>
                <input type="text" name="menu[name]" class='form-control' value='<?= isset($menu['name']) ? $menu['name'] : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th>Enabled: </th>
            <td>
                <input type="checkbox" name="menu[enabled]" class='make-switch' <?= isset($menu['enabled']) && $menu['enabled'] ? 'checked' : ''; ?> />
            </td>
        </tr>
    </table>


    <input type='submit' value='Save' class='btn btn-success pull-right' />
    <?php if (isset($menu['id'])) { ?>
        <button type="button" id="delete-menu" class="btn btn-danger pull-right">Delete</button>
    <?php } ?>
</form>

<?php if (isset($menu['id'])) { ?>
    <script>
        jQuery(document).ready(function($) {
            $("body").on('click', '#delete-menu', function() {
                if (confirm("Delete this menu?")) {
                    $.post('<?= url('menu/drop'); ?>', {id: <?= $menu['id']; ?>}, function() {
                        //window.location.href = "<?= url('menu'); ?>";
                    }, 'json');
                }
            });
        });
    </script>
<?php } ?>