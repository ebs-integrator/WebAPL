<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= Core\APL\Template::getPageTitle(); ?></title>

        <?php foreach (\Core\APL\Template::getMetas() as $metaName => $metaContent) { ?>
            <meta name="<?= $metaName; ?>" content="<?= $metaContent; ?>">
        <?php } ?>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <?php if (isset($favicon) && $favicon) { ?>
            <link rel="icon" href="<?= url($favicon->path); ?>" type="image/x-icon">
        <?php } ?>

        <link href="<?= res('assets/css/jquery.bxslider.css'); ?>" rel="stylesheet" />
        <link href="<?= res('assets/js/square/red.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?= res('assets/css/normalize.css'); ?>">
        <link rel="stylesheet" href="<?= res('assets/css/main.css'); ?>">
        <link rel="stylesheet" href="<?= res('assets/css/jquery.selectBoxIt.css'); ?>">

        <?php Template::pullCurrentSchema(); ?>

        <script>
            var res_url = "<?= res(''); ?>";
            var base_url = '<?= url(); ?>';

            var disqus_url = '<?= url(); ?>';
            var disqus_shortname = 'aplkopceak';
            var disqus_title = '<?= Core\APL\Template::getPageTitle(); ?>';
            var disqus_config = function() {
                this.language = "<?= Core\APL\Language::ext(); ?>";
            };

            var loc_lat = <?= SettingsModel::one('pos_lat') ? SettingsModel::one('pos_lat') : 0; ?>;
            var loc_long = <?= SettingsModel::one('pos_long') ? SettingsModel::one('pos_long') : 0; ?>;
        </script>

        <script src="<?= res('assets/js/jquery-2.1.1.js'); ?>"></script>
    </head>
    <body>
        <div class="overlay hidden"></div>
        <div class="overlay2 hidden"></div>
        <div class="overlay3 hidden"></div>

        <div class="page_header">
            <div class="page_top_header">
                <img class="top_back" src="<?= res('assets/img/top1.png'); ?>">
                <div class="page_top_content">
                    <div class="row1">
                        <div class="left">
                            <a href="<?= Language::url('/'); ?>" class="l_box">primăria strășeni</a>

                            <div class="mini_header">
                                <div class="mh_button"></div>
                                <div class="content hidden">
                                    <ul class="m_menu">
                                        <?php
                                        if (isset($general_pages)) {
                                            foreach ($general_pages as $item) {
                                                ?>
                                                <li><a href='<?= $item->url; ?>'><?= $item->title; ?></a></li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                    <ul class="m_socials">
                                        <li class="fb"><a href="<?= varlang('facebook_link'); ?>"></a></li>
                                        <li class="odno"><a href="<?= varlang('odnoklassniki-link-1'); ?>"></a></li>
                                        <li class="vk"><a href="<?= varlang('vkontakte-link'); ?>"></a></li>
                                        <li class="twitter"><a href="<?= varlang('twitter-link'); ?>"></a></li>
                                        <li class="gplus"><a href="<?= varlang('gplus-link'); ?>"></a></li>
                                        <li class="rss"><a href="<?= varlang('rss-link'); ?>"></a></li>
                                    </ul>
                                    <ul class="m_lang">
                                        <?php foreach (Core\APL\Language::getList() as $lang) { ?>
                                        <li><a href="<?= url('language/' . $lang->ext . '/' . (isset($active_page_id) ? $active_page_id : '')); ?>"><?=$lang->ext;?></a></li>
                                        <?php } ?>
                                    </ul>
                                    <div class="m_footer">
                                        <a href="javascript:;" class="m_map">Harta</a>
                                        <a href="javascript:;" class="m_phone"><?= varlang('nr-phone'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <p class="telef"><?= varlang('nr-phone'); ?></p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row2">
                        <div class="content">
                            <ul>
                                <?php
                                if (isset($general_pages)) {
                                    foreach ($general_pages as $item) {
                                        ?>
                                        <li class="<?= isset($parrents_ids) && in_array($item->id, $parrents_ids) ? 'active' : ''; ?>"><a href='<?= $item->url; ?>'><?= $item->title; ?></a></li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>



        <?= $content; ?>


        <?= View::make('block.footer'); ?>