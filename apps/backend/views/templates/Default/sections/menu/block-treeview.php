<ol class="dd-list">
    <?php foreach ($items as $item) { ?>
        <li class="dd-item" data-id="<?= $item->id; ?>"><a data-id="<?= $item->id; ?>" class="edit-tree-node btn btn-sm">e</a> <a data-id="<?= $item->id; ?>" class="btn btn-sm remove-tree-node">x</a>
            <div class="dd-handle"><?= $item->title; ?> </div>
            <?php if ($item->list) { ?>
                <?= View::make('sections.menu.block-treeview', array('items' => $item->list)); ?>
            <?php } ?>
        </li>
    <?php } ?>
</ol>