<ol class="dd-list">
    <?php foreach ($items as $item) { ?>
        <li class="dd-item" data-id="<?= $item->id; ?>">
            <div class="dd-handle">
                <?= $item->title; ?> 
            </div>
            <div class="nestable-controls">
                <a data-id="<?= $item->id; ?>" class=" btn btn-sm remove-tree-node pull-right">x</a>
                <a data-id="<?= $item->id; ?>" class=" edit-tree-node btn btn-sm pull-right">e</a> 
            </div>
            <?php if ($item->list) { ?>
                <?= View::make('sections.menu.block-treeview', array('items' => $item->list)); ?>
            <?php } ?>
        </li>
    <?php } ?>
</ol>