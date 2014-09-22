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
        <tr class="<?= isset($page->clone_id) && $page->clone_id ? 'label-warning' : ''; ?>">
            <th>Clone: </th>
            <td>
                <select name="page[clone_id]" class='form-control'>
                    <option value='0'>----</option>
                    <?= View::make('sections.page.element-tree-option', array('level' => 1, 'items' => $tree_pages, 'selected' => isset($page->clone_id) ? $page->clone_id : 0)); ?>
                </select>
                <?php if (isset($page->clone_id) && $page->clone_id) { ?>
                    <a href="<?= url('page/index/' . $page->clone_id); ?>">View clone page</a>
                <?php } ?>
            </td>
        </tr>
        <tr class="<?= isset($page->redirect_to) && $page->redirect_to ? 'label-warning' : ''; ?>">
            <th>Redirect to: </th>
            <td>
                <select name="page[redirect_to]" class='form-control'>
                    <option value='0'>----</option>
                    <?= View::make('sections.page.element-tree-option', array('level' => 1, 'items' => $tree_pages, 'selected' => isset($page->redirect_to) ? $page->redirect_to : 0)); ?>
                </select>
                <?php if (isset($page->redirect_to) && $page->redirect_to) { ?>
                    <a href="<?= url('page/index/' . $page->redirect_to); ?>">View redirect page</a>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th>View mod:</th>
            <td>
                <select name="page[view_mod]" class='chzn-select'>
                    <option value="">Default</option>
                    <?php $finded = false; ?>
                    <?php
                    foreach ($view_mods as $view_key => $view_mod) {
                        if (isset($page->view_mod) && $page->view_mod == $view_key) {
                            $state = 'selected';
                            $finded = true;
                        } else {
                            $state = '';
                        }
                        ?>
                        <option value="<?= $view_key; ?>" <?= $state; ?>><?= $view_mod['name']; ?></option>
                    <?php } ?>
                    <?php if (!$finded && isset($page->view_mod) && $page->view_mod) { ?>
                        <option value="<?= $page->view_mod; ?>" selected>Undefined (<?= $page->view_mod; ?>):inactive</option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Properties:</th>
            <td>
                <select name="properties[]" class='chzn-select' multiple>
                    <?php foreach ($page_properties_all as $property) { ?>
                        <option value="<?= $property->id; ?>" <?= in_array($property->id, $page_properties) ? 'selected' : ''; ?>><?= $property->name; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Date: </th>
            <td>
                <input type="text" name="page[created_at]" class='form-control datetimepicker' data-date-format="YYYY-MM-DD hh:mm:ss" value='<?= isset($page->created_at) ? $page->created_at : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th>General node: </th>
            <td>
                <input type="checkbox" name="page[general_node]" class='make-switch' <?= isset($page->general_node) && $page->general_node ? 'checked' : ''; ?> />
            </td>
        </tr>
        <tr>
            <th>Home page: </th>
            <td>
                <input type="checkbox" name="page[is_home_page]" class='make-switch' <?= isset($page->is_home_page) && $page->is_home_page ? 'checked' : ''; ?> />
            </td>
        </tr>
        <tr>
            <th>Have socials: </th>
            <td>
                <input type="checkbox" name="page[have_socials]" class='make-switch' <?= isset($page->have_socials) && $page->have_socials ? 'checked' : ''; ?> />
            </td>
        </tr>
        <tr>
            <th>Have comments: </th>
            <td>
                <input type="checkbox" name="page[have_comments]" class='make-switch' <?= isset($page->have_comments) && $page->have_comments ? 'checked' : ''; ?> />
            </td>
        </tr>
    </table>

    <?php if (isset($menu['id'])) { ?>
        <button type="button" id="delete-menu" class="btn btn-danger pull-right">Delete</button>
    <?php } ?>
</form>