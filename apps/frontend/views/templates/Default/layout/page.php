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

        <script src="<?= res('assets/js/jquery-2.1.1.js'); ?>"></script>
    </head>
    <body>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
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
        <header>
            <div class="left">
                <a href="<?= Language::url('/'); ?>"><img src="<?= res('assets/img/s_logo.png'); ?>" class="logo"></a>
                <?php
                if (isset($general_pages)) {
                    foreach ($general_pages as $item) {
                        ?>
                        <div class="top_menu">
                            <a href='<?= $item->url; ?>' class="<?= $item->id == $active_page_id ? 'active' : ''; ?>">
                                <div class="left">
                                    <?php if ($item->image_icon_active && isset($parrents_ids) && in_array($item->id, $parrents_ids)) { ?>
                                        <img src="<?= url($item->image_icon_active->path); ?>">
                                    <?php } elseif ($item->image_icon) { ?>
                                        <img src="<?= url($item->image_icon->path); ?>">
                                    <?php } ?>
                                </div>
                                <div class="left title third"><?= $item->title; ?></div></a>
                        </div>
                        <?php
                    }
                }
                ?>
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
                        <li><a href='javascript:;' class="fb">Facebook</a></li>
                        <li><a href='javascript:;' class="odno">Odnoklassniki</a></li>
                        <li><a href='javascript:;' class="vk">Vkontakte</a></li>
                        <li><a href='javascript:;' class="twitter">twitter</a></li>
                        <li><a href='javascript:;' class="gplus">google+</a></li>
                        <li><a href='javascript:;' class="rsss">rsss</a></li>
                    </ul>
                </div>
            </div>
            <div class="contact right"><?=View::make('block.top_contacts');?></div>
    </header>



    <?= $content; ?> 


    <?= View::make('block.footer'); ?>