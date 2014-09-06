<form class="ajax-auto-submit" action='<?= url('page/save'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($page['id']) ? $page['id'] : 0; ?>' />

    <table class="table table-bordered">
        <tr>
            <th>Parent: </th>
            <td>
                <select name="page[parent]" class='form-control'>
                    <option value='0'>----</option>
                    <?= View::make('sections.page.element-tree-option', array('level' => 1, 'items' => $tree_pages, 'selected' => isset($page->parent) ? $page->parent : 0)); ?>
                </select>
            </td>
        </tr>
        <tr class="<?=isset($page->clone_id) && $page->clone_id ? 'label-warning':'';?>">
            <th>Clone: </th>
            <td>
                <select name="page[clone_id]" class='form-control'>
                    <option value='0'>----</option>
                    <?= View::make('sections.page.element-tree-option', array('level' => 1, 'items' => $tree_pages, 'selected' => isset($page->clone_id) ? $page->clone_id : 0)); ?>
                </select>
                <?php if (isset($page->clone_id) && $page->clone_id) { ?>
                <a href="<?=url('page/index/'.$page->clone_id);?>">View clone page</a>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th>View mod:</th>
            <td>
                <select name="page[view_mod]" class='form-control'>
                    <option value="">Default</option>
                    <?php foreach ($view_mods as $view_key => $view_mod) { ?>
                        <option value="<?= $view_key; ?>" <?= isset($page->view_mod) && $page->view_mod == $view_key ? 'selected' : ''; ?>><?= $view_mod['name']; ?></option>
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