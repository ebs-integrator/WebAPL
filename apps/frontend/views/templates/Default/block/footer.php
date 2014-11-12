<?php if (isset($alert_post) && $alert_post) { ?>
    <div class="n_alert" id="alertbox" style="display: none;" data-alertid="<?= $alert_post->id; ?>">
        <div class='cntn'>
            <img src="<?= res('assets/img/alert.png'); ?>" alt="" >
            <p><?= varlang('alerte'); ?></p>
            <a href='javascript:;' class="alertclose"></a>
        </div>
        <div class='n_info'>
            <?php if (strtotime($alert_post->created_at)) { ?>
                <div class='n_data'><?= date('d-m-Y, H:i', strtotime($alert_post->created_at)); ?></div>
            <?php } ?>
            <div class='clearfix'></div>
            <p><a href="<?= Language::url('topost/' . $alert_post->id); ?>"><?= $alert_post->title; ?></a></p>
            <a href="<?= Language::url('topost/' . $alert_post->id); ?>" class="more"></a>
        </div>
        <div class='n_footer'>
            <input id="f_1" type='checkbox'>
            <label for='f_1'><?= varlang('confirm-alert'); ?></label>
        </div>
    </div>
<?php } ?>

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
            <a target="_blank" href="<?= varlang('facebook-link'); ?>"><span><img  alt="" src="<?= res('assets/img/fb.png'); ?>"></span><?= varlang('facebook'); ?></a>
            <a target="_blank" href="<?= varlang('odnoklassniki-link-1'); ?>"><span><img  alt="" src="<?= res('assets/img/ok.png'); ?>"></span><?= varlang('odnoklassniki'); ?></a>
            <a target="_blank" href="<?= varlang('vkontakte-link'); ?>"><span><img  alt="" src="<?= res('assets/img/vk.png'); ?>"></span><?= varlang('vkontakte'); ?></a>
        </div>
        <div class="left socials">
            <a target="_blank" href="<?= varlang('twitter-link'); ?>"><span><img alt=""  src="<?= res('assets/img/twitter.png'); ?>"></span><?= varlang('twitter'); ?></a>
            <a target="_blank" href="<?= varlang('gplus-link'); ?>"><span><img alt=""  src="<?= res('assets/img/gplus.png'); ?>"></span><?= varlang('gplus'); ?></a>
            <a target="_blank" href="<?= varlang('rss-link'); ?>"><span><img alt=""  src="<?= res('assets/img/rsss.png'); ?>" class="rsss"></span><?= varlang('rss'); ?></a>
        </div>
    </div>
    <div class="right">
        <div class="left search">
            <form action="<?= Language::url('search'); ?>" method="get">
                <p><?= varlang('cautare'); ?></p>
                <img alt=""  src="<?= res('assets/img/search.png'); ?>">
                <input type="text" name="words">
                <input type="submit" value="<?= varlang('submit'); ?>">
            </form>
        </div>
        <?php Event::fire('bottom_widgets'); ?>
    </div>
    <div class="clearfix"> </div>
    <p class="copy"><img src="<?= res('assets/img/usaid/lgsp_' . WebAPL\Language::ext() . '.png'); ?>" class="img_copy"><span><a href="javascript:;"><?= varlang('cititi'); ?></a> <?= varlang('licentiere-cc'); ?> <a href="<?= varlang('licenta-link'); ?>"><?= varlang('licenta'); ?></a> <?= varlang('material'); ?></span></p>
</footer>

<?php Event::fire('bottom_contructor'); ?>

<?= SettingsModel::one('stats_code'); ?>

<script src="<?= res('assets/js/plugins.js'); ?>"></script>
<script src="<?= res('assets/js/icheck.js'); ?>"></script>
<script src="<?= res('assets/js/jquery.bxslider.min.js'); ?>"></script>
<script src="<?= res('assets/js/jquery.cookie.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="<?= res('assets/js/vendor/modernizr-2.6.2.min.js'); ?>"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="<?= res('assets/js/jquery.selectBoxIt.min.js'); ?>"></script>
<script src="<?= res('assets/js/main.js'); ?>"></script>

</body>
</html>
