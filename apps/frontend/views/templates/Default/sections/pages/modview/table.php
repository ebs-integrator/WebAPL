<table class="atz">
    <tbody>
        <?php 
        $nr = 0;
        foreach ($feedPosts as $item) {
            $nr++;
        ?>
        <tr><td><?=$nr;?>.</td><td><?=$item->title;?></td><td><?=$item->text;?></td></tr>
        <?php } ?>
    </tbody>
</table>


<?php
if (method_exists($feedPosts, 'links')) {
    echo $feedPosts->links();
}
?>