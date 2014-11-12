<?php foreach ($items as $item) { ?>
    <?php
    $nodeName = isset($item['lang']['title']) && $item['lang']['title'] ? $item['lang']['title'] : "Page #{$item->id}";
    ?>
    <?php if (count($item['list'])) { ?>
        <li>
            <span>
                <?php if (User::has("page-order")) { ?>
                    <a class="label-default move-btn" href="<?= url('page/move/' . $item->id . '/1'); ?>">&#65514;</a> <a class="label-default move-btn" href="<?= url('page/move/' . $item->id . '/0'); ?>">&#65516;</a>
                <?php } ?>
                <a class='<?= isset($page->id) && $page->id == $item->id ? 'active' : ''; ?>' href='<?= url('page/index/' . $item->id); ?>'><?= $nodeName; ?></a>
            </span>
            <ul>
                <?= View::make('sections.page.block-tree', array('items' => $item['list'])); ?>
            </ul>
        </li>
    <?php } else { ?>
        <li>
            <?php if (User::has("page-order")) { ?>
                <a class="label-default move-btn" href="<?= url('page/move/' . $item->id . '/1'); ?>">&#65514;</a> <a class="label-default move-btn" href="<?= url('page/move/' . $item->id . '/0'); ?>">&#65516;</a>
            <?php } ?>
            <a class='<?= isset($page->id) && $page->id == $item->id ? 'active' : ''; ?>' href='<?= url('page/index/' . $item->id); ?>'><?= $nodeName; ?></a>
        </li>
    <?php } ?>
<?php } ?>
