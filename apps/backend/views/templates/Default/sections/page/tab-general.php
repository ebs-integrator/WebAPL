<form class="ajax-auto-submit" action='<?= url('page/save'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($page['id']) ? $page['id'] : 0; ?>' />

    <table class="table table-bordered">
        <tr>
            <th>Parent: </th>
            <td>
                <select name="page[parent]" class='form-control'>
                    <option value='0'>----</option>
                    <?= View::make('sections.page.element-tree-option', array('level' => 1, 'items' => $tree_pages)); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>View mod:</th>
            <td>
                <select name="page[view_mod]" class='form-control'>
                    <option value="">Default</option>
                    <?php foreach ($view_mods as $view_key => $view_mod) { ?>
                    <option value="<?=$view_key;?>" <?= isset($page->view_mod) && $page->view_mod ? 'selected' : ''; ?>><?=$view_mod['name'];?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Date: </th>
            <td>
                <input type="text" name="page[created_at]" class='form-control' value='<?= isset($page->created_at) ? $page->created_at : ''; ?>' />
            </td>
        </tr>
    </table>

    <?php if (isset($menu['id'])) { ?>
        <button type="button" id="delete-menu" class="btn btn-danger pull-right">Delete</button>
    <?php } ?>
</form>