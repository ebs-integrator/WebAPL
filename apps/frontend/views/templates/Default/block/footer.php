<footer>
    <div class="left">
        <?php if (isset($buttom_pages) && count($buttom_pages)) { ?>
            <div class="left links">
                <?php foreach ($buttom_pages as $item) { ?>
                    <a href="<?= Language::url('topost/' . $item->id); ?>"><?= $item->title; ?></a>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="left socials">
            <a target="_blank" href="<?= varlang('facebook_link'); ?>"><span><img src="<?= res('assets/img/fb.png'); ?>"></span><?= varlang('facebook'); ?></a>
            <a target="_blank" href="<?= varlang('odnoklassniki-link-1'); ?>"><span><img src="<?= res('assets/img/ok.png'); ?>"></span><?= varlang('odnoklassniki'); ?></a>
            <a target="_blank" href="<?= varlang('vkontakte-link'); ?>"><span><img src="<?= res('assets/img/vk.png'); ?>"></span><?= varlang('vkontakte'); ?></a>
        </div>
        <div class="left socials">
            <a target="_blank" href="<?= varlang('twitter-link'); ?>"><span><img src="<?= res('assets/img/twitter.png'); ?>"></span><?= varlang('twitter'); ?></a>
            <a target="_blank" href="<?= varlang('gplus-link'); ?>"><span><img src="<?= res('assets/img/gplus.png'); ?>"></span><?= varlang('gplus'); ?></a>
            <a target="_blank" href="<?= varlang('rss-link'); ?>"><span><img src="<?= res('assets/img/rsss.png'); ?>" class="rsss"></span><?= varlang('rss'); ?></a>
        </div>
    </div>
    <div class="right">
        <div class="left search">
            <form action="<?= Language::url('search'); ?>" method="get">
                <p><?= varlang('cautare'); ?></p>
                <img src="<?= res('assets/img/search.png'); ?>">
                <input type="text" name="words">
                <input type="submit" value="<?= varlang('submit'); ?>">
            </form>
        </div>
        <?= Core\APL\Actions::call('bottom_widgets'); ?>
    </div>
    <div class="clearfix"> </div>
    <p class="copy"><a href="javascript:;"><?= varlang('cititi'); ?></a> <?= varlang('licentiere-cc'); ?> <a href="<?= varlang('licenta-link'); ?>"><?= varlang('licenta'); ?></a> <?= varlang('material'); ?></p>
</footer>

<?= \Core\APL\Actions::call('bottom_contructor'); ?>

<script src="<?= res('assets/js/plugins.js'); ?>"></script>
<script src="<?= res('assets/js/icheck.js'); ?>"></script>
<script src="<?= res('assets/js/jquery.bxslider.min.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="<?= res('assets/js/vendor/modernizr-2.6.2.min.js'); ?>"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="<?= res('assets/js/jquery.selectBoxIt.min.js'); ?>"></script>
<script src="<?= res('assets/js/main.js'); ?>"></script>

</body>
</html>
