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
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link href="<?= res('assets/css/jquery.bxslider.css'); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?= res('assets/css/normalize.css'); ?>">
        <link rel="stylesheet" href="<?= res('assets/css/main.css'); ?>">        
        <link rel="stylesheet" href="<?= res('assets/css/jquery.selectBoxIt.css'); ?>">
        <link href="<?= res('assets/js/square/red.css" rel="stylesheet'); ?>">

        <?php Template::pullCurrentSchema(); ?>

        <script src="<?= res('assets/js/jquery-2.1.1.js'); ?>"></script>
    </head>
    <body>
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/ro_RO/sdk.js#xfbml=1&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="overlay hidden"></div>
        <div class="overlay2 hidden"></div>
        <div class="overlay3 hidden"></div>
        <header class="page">
            <div class="left">
                <?= View::make('sections.elements.topmenu'); ?>
            </div>
            <div class="header_mini ">
                <div class="head_list"></div>                
            </div>
            <div class="contact right"><?= View::make('block.top_contacts'); ?></div>
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
                <li><?= varlang('nr-phone'); ?></li>
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