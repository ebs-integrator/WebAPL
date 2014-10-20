<?php if (isset($alert_post) && $alert_post) { ?>
    <div class="n_alert" id="alertbox" style="display: none;" data-alertid="<?= $alert_post->id; ?>">
        <div class='cntn'>
            <img src="<?= res('assets/img/alert.png'); ?>">
            <p><?= varlang('alerte'); ?></p>
            <a href='javascript:;' class="alertclose"></a>
        </div>
        <div class='n_info'>
            <div class='n_data'><?= date('d-m-Y, H:i', strtotime($alert_post->created_at)); ?></div>
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
        <div class="f_menu">
            <div class="content">
                <?php if (isset($buttom_pages) && count($buttom_pages)) { ?>
                <ul>
                    <?php foreach ($buttom_pages as $item) { ?>
                    <li><a href="<?= Language::url('topost/' . $item->id); ?>"><?= $item->title; ?></a></li>
                    <?php } ?>
                </ul>   
                <?php } ?>
            </div>
        </div>
        <div class="content">
            <ul class="f_social">
                <li><a target="_blank" class="f_fb" href="<?= varlang('facebook_link'); ?>"><img src="<?=res('assets/img/fb.png');?>"></a></li>
                <li><a target="_blank" class="f_odno" href="<?= varlang('odnoklassniki-link-1'); ?>"><img src="<?=res('assets/img/odno.png');?>"></a></li>
                <li><a target="_blank" class="f_vk"b href="<?= varlang('vkontakte-link'); ?>"><img src="<?=res('assets/img/vk.png');?>"></a></li>
                <li><a target="_blank" class="f_twitter" href="<?= varlang('twitter-link'); ?>"><img src="<?=res('assets/img/twitter.png');?>"></a></li>
                <li><a target="_blank" class="f_gplus" href="<?= varlang('gplus-link'); ?>"><img src="<?=res('assets/img/gplus.png');?>"></a></li>
                <li><a target="_blank" class="f_rss" href="<?= varlang('rss-link'); ?>"><img src="<?=res('assets/img/rss.png');?>"></a></li>
            </ul>
            <div class="clearfix50"></div>
            <form method="get" action="<?= Language::url('search'); ?>" class="search">
                <label><?= varlang('cautare'); ?></label>
                <input type="text" name="words">
                <input type="submit" value="<?= varlang('submit'); ?>">
            </form>
            <?php Event::fire('bottom_widgets'); ?>
            <p class="copy"><a href="javascript:;"><?= varlang('cititi'); ?></a> <?= varlang('licentiere-cc'); ?> <a href="<?= varlang('licenta-link'); ?>"><?= varlang('licenta'); ?></a> <?= varlang('material'); ?></p>

        </div>

    </div>   
    <div class="right">
        <div id="map-canvas3" style="width:100%; height:500px;"></div>
        <div class="content">
            <p class="y_info"><?= varlang('address'); ?></p>
            <p class="w_info">
                <span><?= varlang('street'); ?></span>
                <span><?= varlang('city'); ?></span>
            </p>
        </div>
    </div>
    <div class="clearfix"> </div>
</footer>

<?php Event::fire('bottom_contructor'); ?>

<script src="<?=res('assets/js/plugins.js');?>"></script>
<script src="<?=res('assets/js/icheck.js');?>"></script>
<script src="<?=res('assets/js/jquery.bxslider.min.js');?>"></script>
<script src="<?=res('assets/js/jquery.cookie.js');?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="<?=res('assets/js/vendor/modernizr-2.6.2.min.js');?>"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="<?=res('assets/js/jquery.selectBoxIt.min.js');?>"></script>
<script src="<?=res('assets/js/main.js');?>"></script>

</body>
</html>
