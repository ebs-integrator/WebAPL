<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= Core\APL\Template::getPageTitle(); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link href="<?= res('assets/css/jquery.bxslider.css'); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?= res('assets/css/normalize.css'); ?>">
        <link rel="stylesheet" href="<?= res('assets/css/main.css'); ?>">
        <!--        <link rel="stylesheet" href="/css/jquery.selectBoxIt.css">-->

        <script src="<?= res('assets/js/jquery-2.1.1.js'); ?>"></script>
    </head>
    <body>
        <div class="overlay hidden"></div>
        <div class="overlay2 hidden"></div>
        <div class="overlay3 hidden"></div>
        <header>
            <div class="left">
                <a href="<?= Language::url('/'); ?>"><img src="<?= res('assets/img/s_logo.png'); ?>" class="logo logo_home"></a>
                <button class="home_chat firechat-start">
                    <div class="pot"></div>
                    <div class="pct">
                        <p><?=varlang('discuta');?><span><?= varlang('online'); ?></span></p>
                        <span><?= varlang('offline'); ?></span><!--<?= varlang('online'); ?>-->
                    </div>
                </button>
            </div>
            <div class="left home_menu">
                <?=View::make('sections.elements.topmenu');?>
            </div>
            <div class="header_mini ">
                <div class="head_list"></div>
                <div class="menu_content hidden">
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
                        <p>(022) 22-32-53</p>
                        <li><a href='<?=varlang('facebook_link');?>' class="fb"><?=varlang('facebook');?></a></li>
                        <li><a href='<?= varlang('odnoklassniki-link-1'); ?>' class="odno"><?=varlang('odnoklassniki');?></a></li>
                        <li><a href='<?= varlang('vkontakte-link'); ?>' class="vk"><?= varlang('vkontakte'); ?></a></li>
                        <li><a href='<?= varlang('twitter-link'); ?>' class="twitter"><?= varlang('twitter'); ?></a></li>
                        <li><a href='<?= varlang('gplus-link'); ?>' class="gplus"><?= varlang('gplus'); ?></a></li>
                        <li><a href='<?= varlang('rss-link'); ?>' class="rsss"><?= varlang('rss'); ?></a></li>
                    </ul>
                </div>
            </div>
            <div class="contact right"><?=View::make('block.top_contacts');?></div>
        <div class="hr"></div>
    </header>



    <?= $content; ?> 


    <?= View::make('block.footer'); ?>
