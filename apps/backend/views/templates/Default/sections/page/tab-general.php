<form class="ajax-auto-submit" action='<?= url('page/save'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($page['id']) ? $page['id'] : 0; ?>' />

    <table class="table table-bordered table-hover">
        <?php if (User::has('page-move')) { ?>
            <tr>
                <th><?= varlang('parent-'); ?></th>
                <td>
                    <select name="page[parent]" class='form-control'>
                        <option value='0'>----</option>
                        <?= View::make('sections.page.element-tree-option', array('level' => 1, 'items' => $tree_pages, 'selected' => isset($page->parent) ? $page->parent : 0, 'exclude' => (isset($page->id) ? $page->id : null))); ?>
                    </select>
                </td>
            </tr>
        <?php } ?>
        <tr class="<?= isset($page->clone_id) && $page->clone_id ? 'label-warning' : ''; ?>">
            <th><?= varlang('clone-'); ?></th>
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
            <th><?= varlang('redirect-to-'); ?></th>
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
            <th><?= varlang('view-mod'); ?></th>
            <td>
                <div style="width: 90%; display: inline-block;">
                    <select name="page[view_mod]" id="viewModComutator" class='chzn-select'>
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
                            <option data-src="sdfsdfd" value="<?= $view_key; ?>" <?= $state; ?>><?= $view_mod['name']; ?></option>
                        <?php } ?>
                        <?php if (!$finded && isset($page->view_mod) && $page->view_mod) { ?>
                            <option value="<?= $page->view_mod; ?>" selected>Undefined (<?= $page->view_mod; ?>):inactive</option>
                        <?php } ?>
                    </select>
                </div>

                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#pageViewHelp"><i class="glyphicon glyphicon-asterisk"></i></button>
            </td>
        </tr>
        <tr>
            <th><?= varlang('properties'); ?></th>
            <td>
                <select name="properties[]" class='chzn-select' multiple>
                    <?php foreach ($page_properties_all as $property) { ?>
                        <option value="<?= $property->id; ?>" <?= in_array($property->id, $page_properties) ? 'selected' : ''; ?>><?= $property->name; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><?= varlang('date--4'); ?></th>
            <td>
                <input type="text" name="page[created_at]" class='form-control datetimepicker' data-date-format="YYYY-MM-DD HH:mm:ss" value='<?= isset($page->created_at) ? $page->created_at : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('general-node-'); ?></th>
            <td>
                <input type="checkbox" name="page[general_node]" class='make-switch' <?= isset($page->general_node) && $page->general_node ? 'checked' : ''; ?> />
            </td>
        </tr>
        <tr>
            <th><?= varlang('home-page-'); ?></th>
            <td>
                <input type="checkbox" name="page[is_home_page]" class='make-switch' <?= isset($page->is_home_page) && $page->is_home_page ? 'checked' : ''; ?> />
            </td>
        </tr>
        <tr>
            <th><?= varlang('have-socials-'); ?></th>
            <td>
                <input type="checkbox" name="page[have_socials]" class='make-switch' <?= isset($page->have_socials) && $page->have_socials ? 'checked' : ''; ?> />
            </td>
        </tr>
        <tr>
            <th><?= varlang('have-comments'); ?></th>
            <td>
                <input type="checkbox" name="page[have_comments]" class='make-switch' <?= isset($page->have_comments) && $page->have_comments ? 'checked' : ''; ?> />
            </td>
        </tr>
    </table>

    <?php if (isset($menu['id'])) { ?>
        <button type="button" id="delete-menu" class="btn btn-danger pull-right">Delete</button>
    <?php } ?>
</form>


<!-- Modal -->
<div class="modal fade" id="pageViewHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= varlang('close-2'); ?></span></button>
                <h4 class="modal-title" id="myModalLabel"><?= varlang('view-mod-help'); ?></h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th><?= varlang('nume-2'); ?></th>
                        <th><?= varlang('screen'); ?></th>
                        <th></th>
                    </tr>
                    <?php
                    foreach ($view_mods as $view_key => $view_mod) {
                        ?>
                        <tr>
                            <td>
                                <a target="_blank" href="<?= url('/../' . \WebAPL\Language::ext() . "/topage/" . $view_key); ?>"><i class="glyphicon glyphicon-zoom-in"></i></a>
                                <b><?= $view_mod['name']; ?></b>
                                <?php if ($view_mod['info']) { ?>
                                    <br>
                                    <?= $view_mod['info']; ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                $helpFile = '/apps/frontend/views/templates/Default/help/' . $view_key . '.png';
                                ?>
                                <?php if ($view_mod['screen']) { ?>
                                    <a href="<?= $view_mod['screen']; ?>" target="_blank"><img src="<?= $view_mod['screen']; ?>" style="max-width: 100px; max-height: 70px;" /></a>
                                <?php } else { ?>
                                    <a href="<?= $helpFile; ?>" target="_blank"><img src="<?= $helpFile; ?>" style="max-width: 100px; max-height: 70px;" /></a>
                                <?php } ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btnWcom" data-com="<?= $view_key; ?>"><i class="glyphicon glyphicon-ok"></i></button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="wmClose" class="btn btn-default" data-dismiss="modal"><?= varlang('close-2'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function() {
        $(".btnWcom").click(function() {
            $("#viewModComutator").val($(this).attr('data-com')).trigger('chosen:updated');
            $("#viewModComutator").change();
            $(".wmClose").click();
        });
    });
</script>