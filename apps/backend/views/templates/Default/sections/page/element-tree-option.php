<?php
$count = count($items);
foreach ($items as $k => $item) {
    $nodeName = isset($item['lang']['title']) && $item['lang']['title'] ? $item['lang']['title'] : "Page #{$item->id}";
    ?>
    <?php if ((isset($exclude) && $exclude === $item->id) === FALSE) { ?>
        <option value='<?= $item->id; ?>' <?= isset($selected) && $selected == $item->id ? 'selected' : ''; ?>><?= $level - 1 ? str_repeat('┃', $level - 1) : ""; ?><?= $count == $k + 1 ? '┗' : '┣' ?><?= $nodeName; ?></option>
        <?php
        if ($item['list']) {
            echo View::make('sections.page.element-tree-option', array('level' => $level + 1, 'items' => $item['list'], 'selected' => isset($selected) ? $selected : 0));
        }
    }
}
?>