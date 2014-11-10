<table class="plcu">
    <thead>
        <tr><th><?= varlang('denumire-proiect'); ?></th><td><?= $post->title; ?></td></tr>
    </thead>
    <tbody>
        <?php if ($post->pr_date_interval) { ?>
            <tr><th><?= varlang('data-proiect'); ?>	</th><td><strong><?= $post->pr_date_interval; ?></strong></td></tr>
        <?php } ?>
        <?php if ($post->pr_domain) { ?>
            <tr><th><?= varlang('domeniu'); ?>	</th><td><?= $post->pr_domain; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_state) { ?>
            <tr><th><?= varlang('stadiul'); ?></th><td><strong><?= $post->pr_state; ?></strong></td></tr>
        <?php } ?>
        <?php if ($post->pr_value) { ?>
            <tr><th><?= varlang('valoarea-proiectului'); ?></th><td><strong><?= $post->pr_value; ?></strong></td></tr>
        <?php } ?>
        <?php if ($post->pr_partners) { ?>
            <tr><th><?= varlang('parteneri'); ?>	</th><td><?= $post->pr_partners; ?></td></tr>
        <?php } ?>
        <?php if ($post->text) { ?>
            <tr><th><?= varlang('relevanta'); ?></th><td><?= $post->text; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_activites) { ?>
            <tr><th><?= varlang('activitati-proiecte'); ?></th><td><?= $post->pr_activites; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_products) { ?>
            <tr><th><?= varlang('produsele-proiectului'); ?></th><td><?= $post->pr_products; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_results) { ?>
            <tr><th><?= varlang('rezultatele-proiectului'); ?>	</th><td><?= $post->pr_results; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_objectives) { ?>
            <tr><th><?= varlang('obiectivele-proiectului'); ?></th><td><?= $post->pr_objectives; ?></td></tr>
        <?php } ?>
        <?php if ($post->pr_price) { ?>
            <tr><th><?= varlang('valoarea-totala'); ?></th><td><?= $post->pr_price; ?></td></tr>
        <?php } ?>

        <?php if ($post->pr_aditional_fields) { ?>
            <?php
            $fields = @unserialize($post->pr_aditional_fields);
            if (is_array($fields)) {
                foreach ($fields as $field) {
                    if ($field['lang_id'] == 0 || $field['lang_id'] == WebAPL\Language::getId()) {
                        ?>
                        <tr><th><?= $field['name']; ?></th><td><?= $field['value']; ?></td></tr>
                        <?php
                    }
                }
            }
            ?>
        <?php } ?>

        <?php if ($post->docs) { ?>
            <tr>
                <th><?= varlang('fisiere'); ?></th>
                <td>
                    <?php foreach ($post->docs as $doc) { ?>
                        <a href="<?= url($doc->path); ?>" target="_blank" class="<?= $doc->extension; ?>"><?= $doc->name; ?></a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>