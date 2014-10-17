<table class="urg">
    <thead><tr><td><?= varlang('telefon'); ?></td><td><?= varlang('serviciu'); ?></td></tr></thead>
    <tbody>
        <?php foreach ($feedPosts as $item) { ?>
        <tr>
            <td><?= isset($item->phone_one) ? $item->phone_one : ''; ?></td>
            <td><?= $item['title']; ?></td>
        </tr> 
        <?php } ?>
    </tbody>
</table>

<?php
if (method_exists($feedPosts, 'links')) {
    echo $feedPosts->links();
}
?>