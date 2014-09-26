<table class="plc">
    <tbody>
        <?php foreach ($posts as $k => $item) { ?>
        <tr><td><?=$k+1;?>.</td>
            <td><a href="<?=$page_url;?>?item=<?=$item->uri;?>"><?=$item->title;?></a></td>
            <td>
                <table>
                    <tr><td><?= varlang('data-proiect'); ?>:</td><td><?=$item->pr_date_interval;?></td></tr>
                    <tr><td><?= varlang('domeniu'); ?>:</td><td><?=$item->pr_domain;?></td></tr>
                    <tr><td><?= varlang('stadiul'); ?>:</td><td><?=$item->pr_state;?></td></tr>
                    <tr><td><?= varlang('valoarea-proiectului'); ?>:</td><td><?=$item->pr_value;?></td></tr>
                </table>
                <a class="more" href="<?=$page_url;?>?item=<?=$item->uri;?>"></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php
if (method_exists($posts, 'links')) {
    echo $posts->links();
}
?>