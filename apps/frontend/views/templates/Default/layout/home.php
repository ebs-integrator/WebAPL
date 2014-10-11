<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= Core\APL\Template::getPageTitle(); ?></title>

        <?php foreach (\Core\APL\Template::getMetas() as $metaName => $metaContent) { ?>
            <meta name="<?= $metaName; ?>" content="<?= $metaContent; ?>">
        <?php } ?>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="<?= res('assets/css/jquery.bxslider.css'); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?= res('assets/css/normalize.css'); ?>">
        <link rel="stylesheet" href="<?= res('assets/css/main.css'); ?>">

        <?php if (isset($favicon) && $favicon) { ?>
            <link rel="icon" href="<?= url($favicon->path); ?>" type="image/x-icon">
        <?php } ?>

        <?php Template::pullCurrentSchema(); ?>


        <script>
            var res_url = "<?= res(''); ?>";
            var base_url = '<?= url(); ?>';

            var disqus_url = '<?= url(); ?>';
            var disqus_shortname = 'aplkopceak';
            var disqus_title = '<?= Core\APL\Template::getPageTitle(); ?>';
            var disqus_config = function () {
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
        <header>
            <div class="left">
                <a href="<?= Language::url('/'); ?>"><img src="<?= res('assets/img/s_logo.png'); ?>" class="logo logo_home"></a>
                <?= Core\APL\Actions::call('logo_contructor'); ?>
            </div>
            <div class="left home_menu">
                <?= View::make('sections.elements.topmenu'); ?>
            </div>
            <div class="header_mini ">
                <div class="head_list"></div>
            </div>
            <div class="contact right"><?= View::make('block.top_contacts'); ?></div>
            <div class="hr"></div>
        </header>

        <div class="menu_content header_menu_content hidden">
            <ul class="menu_list">
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
            <ul class="social">
                <li>(022) 22-32-53</li>
                <li><a href='<?= varlang('facebook_link'); ?>' class="fb"><?= varlang('facebook'); ?></a></li>
                <li><a href='<?= varlang('odnoklassniki-link-1'); ?>' class="odno"><?= varlang('odnoklassniki'); ?></a></li>
                <li><a href='<?= varlang('vkontakte-link'); ?>' class="vk"><?= varlang('vkontakte'); ?></a></li>
                <li><a href='<?= varlang('twitter-link'); ?>' class="twitter"><?= varlang('twitter'); ?></a></li>
                <li><a href='<?= varlang('gplus-link'); ?>' class="gplus"><?= varlang('gplus'); ?></a></li>
                <li><a href='<?= varlang('rss-link'); ?>' class="rsss"><?= varlang('rss'); ?></a></li>
            </ul>
        </div>

        <?= $content; ?> 


        <?= View::make('block.footer'); ?>
