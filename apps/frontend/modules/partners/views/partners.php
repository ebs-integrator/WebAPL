<article class="atn partners-img">
    <?php if ($list) { ?>

    <p class="ttl"><a><?= varlang('parteneri'); ?></a></p>

    <div class="hr"></div>
    <?php foreach ($list as $item) {
    $url = $item->name;
    if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
        $url3 = $url;
    } else {
        $url3 = "";
    }
    if ($url3) {
    ?>
    <a target="_blank" href="<?= url($url3) ?>">
        <?php } else { ?><a><?php } ?>
            <img src="<?= url($item->path); ?>">
        </a>
        <?php } ?>

        <?php } ?>
</article>
