
<div class="row">
    <div class="col-lg-4">
        <div class="box">
            <header>
                <h5><?= varlang('pages-2'); ?></h5>
            </header>
            <div class="body">
                <ul class="treeview treeview-gray">
                    <?= View::make('sections.page.block-tree', array('items' => $tree_pages)); ?>
                </ul>
            </div>
        </div>

        <?php if (User::has("page-create")) { ?>
        <div class="box">
            <header>
                <h5><?= varlang('create-new-page'); ?></h5>
            </header>
            <div class="body">
                <form action="<?= url('page/create'); ?>" method="post">
                    <select name="parent" class='form-control'>
                        <option value='0'>----</option>
                        <?= View::make('sections.page.element-tree-option', array('level' => 1, 'items' => $tree_pages)); ?>
                    </select>
                    <div class='c10'></div>
                    <input type='submit' value="<?= varlang('create-3'); ?>" class='btn btn-success pull-right' />
                    <div class='clearfix'></div>
                </form>
            </div>
        </div>
        <?php } ?>
    </div><!-- /.col-lg-4 -->
    <?php if (isset($page) && $page && User::has("page-edit")) { ?>
        <div class="col-lg-8">
            <div class="box">
                <header>
                    <h5><?= varlang('form-3'); ?></h5> <a href='<?= url('page/delete/' . $page->id); ?>' onclick='return confirm("Delete this page? ");' class='label label-danger pull-right' style='line-height: 38px'><?= varlang('delete'); ?></a>
                </header>
                <div class="body">
                    <?= View::make('sections.page.block-form'); ?>
                </div>
            </div>
        </div><!-- /.col-lg-8 -->
    <?php } ?>
</div><!-- /.row -->