<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link href="<?=res('assets/css/jquery.bxslider.css');?>" rel="stylesheet" />
        <link href="<?=res('assets/js/square/red.css');?>" rel="stylesheet">
        <link rel="stylesheet" href="<?=res('assets/css/normalize.css');?>">
        <link rel="stylesheet" href="<?=res('assets/css/main.css');?>">
        <link rel="stylesheet" href="<?=res('assets/css/jquery.selectBoxIt.css');?>">

        <script src="<?=res('assets/js/jquery-2.1.1.js');?>"></script>
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
        <div class="page_header">
            <div class="page_top_header">
                <img class="top_back" src="img/top1.png">
                <div class="page_top_content">
                    <div class="row1">
                        <div class="left">
                            <a href="javascript:;" class="l_box">primăria strășeni</a>


                            <div class="mini_header">
                                <div class="mh_button"></div>
                                <div class="content hidden">
                                    <ul class="m_menu">
                                        <li><a href="javascript:;">CetĂȚeni Și Business</a></li>
                                        <li><a href="javascript:;">primăria</a></li>
                                        <li><a href="javascript:;">consiliul local</a></li>
                                        <li><a href="javascript:;">TRANSPARENȚĂ</a></li>
                                    </ul>
                                    <ul class="m_socials">
                                        <li class="fb"><a href="javascript:;"></a></li>
                                        <li class="odno"><a href="javascript:;"></a></li>
                                        <li class="vk"><a href="javascript:;"></a></li>
                                        <li class="twitter"><a href="javascript:;"></a></li>
                                        <li class="gplus"><a href="javascript:;"></a></li>
                                        <li class="rss"><a href="javascript:;"></a></li>
                                    </ul>
                                    <ul class="m_lang">
                                        <li><a href="javascript:;">ro</a></li>
                                        <li><a href="javascript:;">ru</a></li>
                                        <li><a href="javascript:;">en</a></li>
                                        <li><a href="javascript:;">bg</a></li>
                                    </ul>
                                    <div class="m_footer">
                                        <a href="javascript:;" class="m_map">Harta</a>
                                        <a href="javascript:;" class="m_phone">(022) 22-32-53</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <p class="telef">(022) 22-32-53</p>
                        </div>
                        <div class="clearfix"></div> 
                    </div>                       
                    <div class="row2">
                        <div class="content">
                            <ul>
                                <li class="active"><a href="javascript:;">cetățeni și business</a></li>
                                <li><a href="javascript:;">primăria</a></li>
                                <li><a href="javascript:;">consiliul local</a></li>
                                <li><a href="javascript:;">TRANSPARENȚĂ</a></li
                            </ul>
                        </div>
                    </div>
                    <div class="clearfix"></div>  
                </div>
            </div>
        </div>

        <?= $content; ?> 
        
        <?= View::make('block.footer'); ?>
