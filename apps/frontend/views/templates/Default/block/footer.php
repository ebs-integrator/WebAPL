<footer>
    <div class="left">
        <div class="left links">
            <a href="javascript:;">Orasul</a>
            <a href="javascript:;">Harta site-ului</a>
            <a href="javascript:;">Contacte</a>
        </div>
        <div class="left socials">
            <a href="javascript:;"><span><img src="<?= res('assets/img/fb.png'); ?>"></span>Facebook</a>
            <a href="javascript:;"><span><img src="<?= res('assets/img/ok.png'); ?>"></span>Odnoklassniki</a>
            <a href="javascript:;"><span><img src="<?= res('assets/img/vk.png'); ?>"></span>Vkontakte</a>
        </div>
        <div class="left socials">
            <a href="javascript:;"><span><img src="<?= res('assets/img/twitter.png'); ?>"></span>Twitter</a>
            <a href="javascript:;"><span><img src="<?= res('assets/img/gplus.png'); ?>"></span>Google+</a>
            <a href="javascript:;"><span><img src="<?= res('assets/img/rsss.png'); ?>" class="rsss"></span>RSSS</a>
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
        <div class="left email">
            <p>Aboneazate la Buletinul informativ al primăriei</p>
            <img src="<?= res('assets/img/email.png'); ?>">
            <input type="text" placeholder="Email-ul Dvs.">
            <input type="submit">
        </div>
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
<script type="text/javascript">
    !function(d, id, did, st) {
        var js = d.createElement("script");
        js.src = "http://connect.ok.ru/connect.js";
        js.onload = js.onreadystatechange = function() {
            if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
                if (!this.executed) {
                    this.executed = true;
                    setTimeout(function() {
                        OK.CONNECT.insertShareWidget(id, did, st);
                    }, 0);
                }
            }
        };
        d.documentElement.appendChild(js);
    }(document, "ok_shareWidget", document.URL, "{width:145,height:30,st:'oval',sz:20,ck:1}");
</script>

</body>
</html>
