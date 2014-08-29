<?php foreach ($items as $item) { ?>
    <?php
    $nodeName = isset($item['lang']['title']) && $item['lang']['title'] ? $item['lang']['title'] : "Page #{$item->id}";
    ?>
    <?php if (count($item['list'])) { ?>
        <li>
            <span><a class='<?= isset($page->id) && $page->id == $item->id ? 'active' : ''; ?>' href='<?= url('page/index/' . $item->id); ?>'><?= $nodeName; ?></a></span>
            <ul>
                <?= View::make('sections.page.block-tree', array('items' => $item['list'])); ?>
            </ul>
        </li>
    <?php } else { ?>
        <li><a class='<?= isset($page->id) && $page->id == $item->id ? 'active' : ''; ?>' href='<?= url('page/index/' . $item->id); ?>'><?= $nodeName; ?></a></li>
    <?php } ?>
<?php } ?>
