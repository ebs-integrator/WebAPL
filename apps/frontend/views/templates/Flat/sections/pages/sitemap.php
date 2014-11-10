<section>
    <div class="wrap">
        <?php foreach ($tree as $k => $item) { ?>
            <div class="left_site">
                <p class="s_title"><?= $k + 1; ?>. <?= $item->title; ?>:</p>
            </div>
            <div class="right_site">
                <?php foreach ($item['list'] as $kl => $sitem) { ?>
                    <div class='sitemap'>
                        <p><a href='<?= WebAPL\Language::url('topost/' . $sitem->id); ?>'><?= $k + 1; ?>.<?= $kl + 1; ?>. <?= $sitem->title; ?></a></p>
                        <ul>
                            <?php foreach ($sitem['list'] as $titem) { ?>
                                <li>
                                    <a href='<?= WebAPL\Language::url('topost/' . $titem->id); ?>'><?= $titem->title; ?></a>

                                    <?php if ($titem['list']) { ?>
                                        <ul>
                                            <?php foreach ($titem['list'] as $qitem) { ?>
                                                <li>
                                                    <a href='<?= WebAPL\Language::url('topost/' . $qitem->id); ?>'><?= $qitem->title; ?></a>
                                                    <?php if ($qitem['list']) { ?>
                                                        <ul>
                                                            <?php foreach ($qitem['list'] as $witem) { ?>
                                                                <a href='<?= WebAPL\Language::url('topost/' . $witem->id); ?>'><?= $witem->title; ?></a>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>

                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <div class='clearfix'></div>
            </div>
            <div class='clearfix'></div>
        <?php } ?>
    </div>
</section>




