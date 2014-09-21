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
            <a href="javascript:;"><span><img src="<?= res('assets/img/fb.png'); ?>"></span>Facebook</a>
            <a href="javascript:;"><span><img src="<?= res('assets/img/ok.png'); ?>"></span>Odnoklassniki</a>
            <a href="javascript:;"><span><img src="<?= res('assets/img/vk.png'); ?>"></span>Vkontakte</a>
        </div>
        <div class="left socials">
            <a href="javascript:;"><span><img src="<?= res('assets/img/twitter.png'); ?>"></span>Twitter</a>
            <a href="javascript:;"><span><img src="<?= res('assets/img/gplus.png'); ?>"></span>Google+</a>
            <a href="<?= Language::url('rss'); ?>"><span><img src="<?= res('assets/img/rsss.png'); ?>" class="rsss"></span>RSS</a>
        </div>
    </div>
    <div class="right">
        <div class="left search">
            <form action="<?= Language::url('search'); ?>" method="get">
                <p>Căutare prin site</p>
                <img src="<?= res('assets/img/search.png'); ?>">
                <input type="text" name="words">
                <input type="submit">
            </form>
        </div>
        <?= Core\APL\Actions::call('bottom_widgets'); ?>
    </div>
    <div class="clearfix"> </div>
    <p class="copy"><a href="javascript:;">Cititi mai multe</a> despre licențiere CC, sau <a href="javascript:;">utilizati licența</a> pentru propriul dvs. material.</p>
</footer>


<script>
    var res_url = "<?= res(''); ?>";
    var base_url = '<?= url(); ?>';

</script>

<script src="<?= res('assets/js/plugins.js'); ?>"></script>
<script src="<?= res('assets/js/icheck.js'); ?>"></script>
<script src="<?= res('assets/js/jquery.bxslider.min.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="<?= res('assets/js/vendor/modernizr-2.6.2.min.js'); ?>"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="<?= res('assets/js/jquery.selectBoxIt.min.js'); ?>"></script>
<script src="<?= res('assets/js/main.js'); ?>"></script>
<script type="text/javascript" src="//vk.com/js/api/openapi.js?115"></script>

<script type="text/javascript">
    VK.init({apiId: 1, onlyWidgets: true});
</script>
<script>!function(d, s, id) {
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
