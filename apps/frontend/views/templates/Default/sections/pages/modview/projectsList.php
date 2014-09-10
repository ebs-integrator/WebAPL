<table class="plc">
    <tbody>
        <?php foreach ($posts as $k => $item) { ?>
        <tr><td><?=$k+1;?>.</td>
            <td><a href="<?=$page_url;?>?item=<?=$item->uri;?>"><?=$item->title;?></a></td>
            <td>
                <table>
                    <tr><td>Data de start și finalizare:</td><td><?=$item->pr_date_interval;?></td></tr>
                    <tr><td>Domeniu:</td><td><?=$item->pr_domain;?></td></tr>
                    <tr><td>Stadiul de realizare proiect:</td><td><?=$item->pr_state;?></td></tr>
                    <tr><td>Valoarea proiectului:</td><td><?=$item->pr_value;?></td></tr>
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