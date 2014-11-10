<table class="cns_locali">
    <thead>
        <tr>
            <td>
                <?= varlang('name-last-name'); ?>,
                <span><?= varlang('aparteneta'); ?></span>
            </td>
            <td><?= varlang('sectorul'); ?></td>
        </tr>
        <tr><td colspan="2"></td></tr>
    </thead>
</table>
<?php
foreach ($groups as $group) {
    foreach ($group['persons'] as $person) {
        ?>
        <table class="c_l_u">
            <tr>
                <td>
                    <div class="clu_img">
                        <?php if (isset($person->path) && $person->path) { ?>
                            <img alt="<?= $person->first_name; ?> <?= $person->last_name; ?>" title="<?= $person->first_name; ?> <?= $person->last_name; ?>" src='<?= url($person->path); ?>'>
                        <?php } else { ?>
                            <img alt="" src="<?= res('assets/img/nophoto.png'); ?>">
                        <?php } ?>
                    </div>
                    <div class="clu_cont">
                        <p class="clu_nume"><?= $person->first_name; ?><span> <?= $person->last_name; ?></span></p>
                        <p class="clu_partid"><?= $person->activity; ?></p>
                        <?php if ($person->phone) { ?>
                            <p class="tel"><?= $person->phone; ?></p>
                        <?php } ?>
                        <?php if ($person->email) { ?>
                            <p class="email"><a href="mailto:<?= $person->email; ?>" target="_blank"><?= $person->email; ?></a></p>
                        <?php } ?>
                    </div>
                </td>
                <td>
                    <div class="sec_span"><?= varlang('sectorul'); ?></div>
                    <?= $person->text; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php
                    $folder = isset($person->posts[0]) ? $person->posts[0] : array();
                    ?>
                    <ul class="dcr">
                        <?php if ($folder) { ?>
                            <li><a href='javascript:;'><?= $folder->title; ?> <span class="more"></span></a>
                                <div class='dcr_box'>
                                    <ul>
                                        <?php foreach ($folder->docs as $doc) { ?>
                                            <li class="<?= $doc->extension; ?>">
                                                <span><a href="<?= url($doc->path); ?>"><?= $doc->name; ?></a></span>
                                                <a href="<?= url($doc->path); ?>" class="dcr_dwnl"></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
        </table>
        <?php
    }
}
?>