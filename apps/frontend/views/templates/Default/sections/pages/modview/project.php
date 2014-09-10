<table class="plcu">
    <thead>
        <tr><th>Denumire proiect</th><td><?= $post->title; ?></td></tr>
    </thead>
    <tbody>
        <?php if ($post->pr_date_interval) { ?>
            <tr><th>Data de start și finalizare	</th><td><strong><?= $post->pr_date_interval; ?></strong></td></tr>
        <?php } ?>
        <?php if ($post->pr_domain) { ?>
            <tr><th>Domeniu	</th><td><?= $post->pr_domain; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_state) { ?>
            <tr><th>Stadiul de realizare proiect</th><td><strong><?= $post->pr_state; ?></strong></td></tr>
        <?php } ?>
        <?php if ($post->pr_value) { ?>
            <tr><th>Valoarea proiectului</th><td><strong><?= $post->pr_value; ?></strong></td></tr>
        <?php } ?>
        <?php if ($post->pr_partners) { ?>
            <tr><th>Parteneri	</th><td><?= $post->pr_partners; ?></td></tr>
        <?php } ?>
        <?php if ($post->text) { ?>
            <tr><th>Relevanța și impactul regional al proiectului</th><td><?= $post->text; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_activites) { ?>
            <tr><th>Activități principale</th><td><?= $post->pr_activites; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_products) { ?>
            <tr><th>Produsele proiectului	</th><td><?= $post->pr_products; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_results) { ?>
            <tr><th>Rezultatele proiectului	</th><td><?= $post->pr_results; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_objectives) { ?>
            <tr><th>Obiectivele proiectului</th><td><?= $post->pr_objectives; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_price) { ?>
            <tr><th>Valoarea totală a proiectului</th><td><?= $post->pr_price; ?></td></tr>
        <?php } ?>
        <?php if ($post->docs) { ?>
            <tr>
                <th>Fișiere</th>
                <td>
                    <?php foreach ($post->docs as $doc) { ?>
                    <a href="<?=url($doc->path);?>" target="_blank" class="<?=$doc->extension;?>"><?=$doc->name;?></a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>