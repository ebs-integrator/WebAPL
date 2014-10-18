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
                <li><a target="_blank" href="<?= varlang('facebook_link'); ?>"><img src="<?=res('assets/img/fb.png');?>"></a></li>
                <li><a target="_blank" href="<?= varlang('odnoklassniki-link-1'); ?>"><img src="<?=res('assets/img/odno.png');?>"></a></li>
                <li><a target="_blank" href="<?= varlang('vkontakte-link'); ?>"><img src="<?=res('assets/img/vk.png');?>"></a></li>
                <li><a target="_blank" href="<?= varlang('twitter-link'); ?>"><img src="<?=res('assets/img/twitter.png');?>"></a></li>
                <li><a target="_blank" href="<?= varlang('gplus-link'); ?>"><img src="<?=res('assets/img/gplus.png');?>"></a></li>
                <li><a target="_blank" href="<?= varlang('rss-link'); ?>"><img src="<?=res('assets/img/rss.png');?>"></a></li>
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
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="<?=res('assets/js/vendor/modernizr-2.6.2.min.js');?>"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="<?=res('assets/js/jquery.selectBoxIt.min.js');?>"></script>
<script src="<?=res('assets/js/main.js');?>"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?115"></script>

<script type="text/javascript">
    VK.init({apiId: 1, onlyWidgets: true});
</script>
<script>!function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
        if (!d.getElementById(id)) {
            js = d.createElement(s);
            js.id = id;
            js.src = p + '://platform.twitter.com/widgets.js';
            fjs.parentNode.insertBefore(js, fjs);
        }
    }(document, 'script', 'twitter-wjs');</script>
</body>
</html>
