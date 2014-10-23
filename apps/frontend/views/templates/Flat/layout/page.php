<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= Core\APL\Template::getPageTitle(isset($page) ? $page : null); ?></title>

        <?php foreach (\Core\APL\Template::getMetas() as $metaName => $metaContent) { ?>
            <meta name="<?= $metaName; ?>" content="<?= $metaContent; ?>" >
        <?php } ?>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php if (isset($favicon) && $favicon) { ?>
            <link rel="icon" href="<?= url($favicon->path); ?>" type="image/x-icon" />
        <?php } ?>

        <link href="<?= res('assets/css/jquery.bxslider.css'); ?>" rel="stylesheet" />
        <link href="<?= res('assets/js/square/red.css'); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?= res('assets/css/normalize.css'); ?>" />
        <link rel="stylesheet" href="<?= res('assets/css/main.css'); ?>" />
        <link rel="stylesheet" href="<?= res('assets/css/jquery.selectBoxIt.css'); ?>" />

        <?php Template::pullCurrentSchema(); ?>

        <script>
            var res_url = "<?= res(''); ?>";
            var base_url = '<?= url(); ?>';

            var disqus_url = '<?= url(); ?>';
            var disqus_shortname = '<?= SettingsModel::one('disqus_shortname'); ?>';
            var disqus_title = '<?= Core\APL\Template::getPageTitle(isset($page) ? $page : null); ?>';
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

        <div class="page_header">
            <div class="page_top_header">
                <div class="img_back"><img alt="" class="top_back" src="<?= (isset($super_parent['id']) && $bg_parent = Files::extract('page_bg', $super_parent['id'], 'path')) ? url($bg_parent) : res('assets/img/top1.png'); ?>"></div>
                <div class="page_top_content">
                    <div class="row1">
                        <div class="left">
                            <a href="<?= Language::url('/'); ?>" class="l_box"><span><?= str_replace(" ", "</span><span>", SettingsModel::one('sitename_' . Language::ext())); ?></span></a>

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
                                            <li><a href="<?= url('language/' . $lang->ext . '/' . (isset($active_page_id) ? $active_page_id : '')); ?>"><?= $lang->ext; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                    <div class="m_footer">
                                        <a href="javascript:;" class="m_map"><?= varlang('map'); ?></a>
                                        <a href="javascript:;" class="m_phone"><?= varlang('nr-phone'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <p class="telef"><?= varlang('nr-phone'); ?></p>
                            <div class="cont">
                                <a class="contact_us">Contactează-ne</a>
                                <div class="cont_form">
                                    <div class="relative">
                                        <img src="/apps/frontend/views/templates/Flat/assets/img/c_arrow.png" alt="">
                                    </div>
                                    <p class="title">datele de Contact ale primăriei</p>
                                    <div class="d_hr"></div>
                                    <ul>
                                        <li>
                                            <img src="/apps/frontend/views/templates/Flat/assets/img/c_mail.png" alt="">
                                            <p>Email</p>
                                            <p><a href="mailto:info@xxxxxxxx.md"> info@xxxxxxxx.md</a></p>
                                        </li>
                                        <li>
                                            <img src="/apps/frontend/views/templates/Flat/assets/img/c_phone.png" alt="">
                                            <p>Relații cu publicul</p>
                                            <p>(0-2xx) xx-xx-xx</p>
                                        </li>
                                        <li>
                                            <img src="/apps/frontend/views/templates/Flat/assets/img/c_fx.png" alt="">
                                            <p>Fax</p>
                                            <p>(0-2xx) xx-xx-xx</p>
                                        </li>
                                        <div class="clearfix"></div>
                                    </ul>
                                    <div class="prp">
                                        <a href="http://lpa.devebs.net/ro/topost/127">Mai multe date de contact</a>
                                    </div>
                                    <div class="prp">
                                        <a href="http://www.autogara.md/orar/">Orarul rutelor de autobus</a>
                                    </div>
                                    <div class="left c_info" onclick="window.open('https://www.google.ro/maps/dir//' + loc_lat + ',' + loc_long + '/@' + loc_lat + ',' + loc_long + ',14z');">
                                        <p class="city">Adresa primăriei Orașului XXXXXX</p>
                                        <p class="street">Strada xxxxxxxxx</p>
                                        <p class="street">Orașul XXXXXX</p>
                                    </div>
                                    <div class="right map">
                                        <div id="map-canvas" style="width: 158px; height: 119px; position: relative; overflow: hidden; -webkit-transform: translateZ(0px); background-color: rgb(229, 227, 223);"><div class="gm-style" style="position: absolute; left: 0px; top: 0px; overflow: hidden; width: 100%; height: 100%; z-index: 0;"><div style="position: absolute; left: 0px; top: 0px; overflow: hidden; width: 100%; height: 100%; z-index: 0; cursor: url(https://maps.gstatic.com/mapfiles/openhand_8_8.cur) 8 8, default;"><div style="position: absolute; left: 0px; top: 0px; z-index: 1; width: 100%; transform-origin: 0px 0px 0px; transform: matrix(1, 0, 0, 1, 0, 0);"><div style="-webkit-transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;"><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><div style="position: absolute; left: 0px; top: 0px; z-index: 1;"><div style="width: 256px; height: 256px; -webkit-transform: translateZ(0px); position: absolute; left: -275px; top: -134px;"></div><div style="width: 256px; height: 256px; -webkit-transform: translateZ(0px); position: absolute; left: -19px; top: -134px;"></div></div></div></div><div style="-webkit-transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;"></div><div style="-webkit-transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;"></div><div style="-webkit-transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;"></div><div style="position: absolute; z-index: 0; left: 0px; top: 0px;"><div style="overflow: hidden;"></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><div style="position: absolute; left: 0px; top: 0px; z-index: 1;"><div style="width: 256px; height: 256px; -webkit-transform: translateZ(0px); position: absolute; left: -275px; top: -134px; opacity: 1; transition: opacity 200ms ease-out; -webkit-transition: opacity 200ms ease-out;"><img src="https://mts1.googleapis.com/vt?pb=!1m4!1m3!1i14!2i9493!3i5752!2m3!1e0!2sm!3i279000000!3m9!2sro-RO!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!20m1!1b1" draggable="false" style="width: 256px; height: 256px; -webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; -webkit-transform: translateZ(0px);"></div><div style="width: 256px; height: 256px; -webkit-transform: translateZ(0px); position: absolute; left: -19px; top: -134px; opacity: 1; transition: opacity 200ms ease-out; -webkit-transition: opacity 200ms ease-out;"><img src="https://mts0.googleapis.com/vt?pb=!1m4!1m3!1i14!2i9494!3i5752!2m3!1e0!2sm!3i279000000!3m9!2sro-RO!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!20m1!1b1" draggable="false" style="width: 256px; height: 256px; -webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; -webkit-transform: translateZ(0px);"></div></div></div></div><div style="position: absolute; left: 0px; top: 0px; z-index: 2; width: 100%; height: 100%;"></div><div style="position: absolute; left: 0px; top: 0px; z-index: 3; width: 100%; transform-origin: 0px 0px 0px; transform: matrix(1, 0, 0, 1, 0, 0);"><div style="-webkit-transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div><div style="-webkit-transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div><div style="-webkit-transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;"></div><div style="-webkit-transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;"></div></div></div><div style="margin-left: 5px; margin-right: 5px; z-index: 1000000; position: absolute; left: 0px; bottom: 0px;"><a target="_blank" href="http://maps.google.com/maps?ll=47.151994,28.61002&amp;z=14&amp;t=m&amp;hl=ro-RO&amp;gl=US&amp;mapclient=apiv3" title="Faceţi clic pentru a vizualiza această zonă pe Hărţi Google" style="position: static; overflow: visible; float: none; display: inline;"><div style="width: 62px; height: 26px; cursor: pointer;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/google_white2.png" draggable="false" style="position: absolute; left: 0px; top: 0px; width: 62px; height: 26px; -webkit-user-select: none; border: 0px; padding: 0px; margin: 0px;"></div></a></div><div class="gmnoprint" style="z-index: 1000001; position: absolute; right: 0px; bottom: 0px; width: 12px;"><div draggable="false" class="gm-style-cc" style="-webkit-user-select: none;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="width: auto; height: 100%; margin-left: 1px; background-color: rgb(245, 245, 245);"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right;"><a style="color: rgb(68, 68, 68); text-decoration: none; cursor: pointer; display: none;">Date cartografice</a><span style="display: none;"></span></div></div></div><div style="padding: 15px 21px; border: 1px solid rgb(171, 171, 171); font-family: Roboto, Arial, sans-serif; color: rgb(34, 34, 34); -webkit-box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px; box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px; z-index: 10000002; display: none; width: 0px; height: 0px; position: absolute; left: 5px; top: 5px; background-color: white;"><div style="padding: 0px 0px 10px; font-size: 16px;">Date cartografice</div><div style="font-size: 13px;"></div><div style="width: 13px; height: 13px; overflow: hidden; position: absolute; opacity: 0.7; right: 12px; top: 12px; z-index: 10000; cursor: pointer;"><img src="https://maps.gstatic.com/mapfiles/api-3/images/mapcnt3.png" draggable="false" style="position: absolute; left: -2px; top: -336px; width: 59px; height: 492px; -webkit-user-select: none; border: 0px; padding: 0px; margin: 0px;"></div></div><div class="gmnoscreen" style="position: absolute; right: 0px; bottom: 0px;"><div style="font-family: Roboto, Arial, sans-serif; font-size: 11px; color: rgb(68, 68, 68); direction: ltr; text-align: right; background-color: rgb(245, 245, 245);"></div></div><div class="gmnoprint gm-style-cc" draggable="false" style="z-index: 1000001; position: absolute; -webkit-user-select: none; right: 0px; bottom: 0px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="width: auto; height: 100%; margin-left: 1px; background-color: rgb(245, 245, 245);"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right;"><a href="http://www.google.com/intl/ro-RO_US/help/terms_maps.html" target="_blank" style="text-decoration: none; cursor: pointer; color: rgb(68, 68, 68);">Condiţii de utilizare</a></div></div><div draggable="false" class="gm-style-cc" style="-webkit-user-select: none; display: none; position: absolute; right: 0px; bottom: 0px;"><div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;"><div style="width: 1px;"></div><div style="width: auto; height: 100%; margin-left: 1px; background-color: rgb(245, 245, 245);"></div></div><div style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right;"><a target="_new" title="Raportaţi la Google erori în harta rutieră sau în imagini" href="http://maps.google.com/maps?ll=47.151994,28.61002&amp;z=14&amp;t=m&amp;hl=ro-RO&amp;gl=US&amp;mapclient=apiv3&amp;skstate=action:mps_dialog$apiref:1&amp;output=classic" style="font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); text-decoration: none; position: relative;">Raportaţi o eroare pe hartă</a></div></div></div></div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <p class="form_title">Scrieți-ne un mesaj</p>
                                    <div class="contact_top_notif adv" style="display: none;">Mesajul dumneavoastră a fost expediat cu succes </div>
                                    <form id="contact_top_form" action="http://lpa.devebs.net" method="post">
                                        <div class="form_error"></div>
                                        <input required="" type="text" name="name" placeholder="Nume Prenume">
                                        <input required="" type="text" name="email" placeholder="Email">
                                        <textarea name="message" placeholder="Mesaj"></textarea>
                                        <input required="" name="capcha" class="code" type="text">
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHgAAAA8CAMAAACac46aAAAAY1BMVEXw8PBfP5bd2eTLw9mnl8OVgbdxVaG5rc6Da6yFV1ji3N3Htre6o6StkJGffX7VycqSamtng3XN1NG8x8He4uCrubJ4kISaq6OJnpN0PDPRw8DBrKng2diif3mDUkqTaWKylpF7X0ZZAAAEfklEQVRYhb2Yi3qiMBCFiVw0ImhUtCqo7/+UO5PrJARIW7vn+3aLYvlzJpOT2Cz7hVjwmk9/VPyG83Ou+Cg3HfxZbDI3Zvc3JUjmfhb7C67GMqm/Ao+9Be8wp49ylwfyzTEkcUeUSewqL8qKsWo8hgVuFJyGXa2LTTXtNChDguEQE8OuCFMqjw1tYgxT3IAadbsmz6rKIl/NcTPiV/8Oh3+n49kDZZOviPJ0pg/W4p0QXh3SsFBq+HQ5W9557kVoXY7yvnBDWAgp+EzxO+71dOrg5+XsoZigY4gIWqtMo25r1rRN0+x2ewtWPNAVBkDLLMRwk3q+hng6bBjbpGDrlnPGlXaOK476+kK7Fy9fN1893iD4DQmNGbeAtVxea26HNrXguiPYLAu4t/CRZUpE77nktjtUc1Cl5ujSGMb++tIX8o0eWPf+/ni8h9frCSUPn1kkgBW3Dt7lR5hhw0XihXbX3VRXq88CYYIsrODtAbjtOCpdpREnF5W7/Y6Y9JSbmMzXRVGsY2PA+W0iEf0lxElihfrfW7bQ1K9ZMCbIOstLm5vr8BNY6ENsT9JTrHgiAENTv2fB2OFlSZYa2wSu0fA+YvgsUcZu6Bim+DEPtptTVenLyiNv4xOcZbK3DFYPw0o29Tx4I10WKq9z9Yre32FHR7gIFiIznkmLo+6RlRuoqDYFsYjLi9F5xsTaxsAnmZLG50mvY63Fph6r9C1vpwwH6+fqkguFTf0YXk+I6oWptsI2JysbeppBNm937eFwaOX+oLknEphubWl5ST2M0iOqjVfrHURlLSdaCfKSW78EDK/oOSTYIpJcF94W3cDWsG85lcJgOzlw0FvQ1spl/xiSyWsP3AIYuG29BdWt2hXl3J5pO109+/4QhluQ2xPKPTCjGyFsy/DCtNTF24HtRjUWtPhCfkp5jhV37+4Clrfq8ur6qfMXU6hnkuWSnK5ZRk8cYAy5nKt1fbQNdZw1rCwvzvKKno0U2GKBKxtcVx4si+54Pl7F9AxLYY69l8Bo2Bz/YACY1AYLhtUsmxJ8mcPtbKFVci+BS7JLoHEDljsRet/T2p/0ubqLPcpp2fG6Yt4MZ9lBgtVuIGvugWF6u647nUcP8vWI7lX5pljnqxV+T1XbooktOdOwcg9mE5Lgmq6uRA3xrmaeKuoXI1MIXE3CZHTjL68U9RPrmH5PdScf3dm4fBpZat3cB7ucpvX26zpMrKbCQM1xwIIxkhGEpdbc2rX5tF63l0PLyJwIrlUO8o9azBwt9lDr1oLlUXdxijGpnsPj3vf9fXgmRrXh2iDGqGq3mtumGB59b3ouHL8I1+W/kCZ5U+/3dSN35KUZBj2mDgKcJuFYBCt0eelJIEU9Hnzk19R3b4CzTAmzWa0H0Dhum+DXiScBDdZ+8bfGOR65kNokruBv8CjLLGH7mNTf/o5BnypZzA0hEfxDnsWqn5pLHrvE+yHQxyqumON+hBdidVR6nBD4Ad4YG+F+0uAk1kX0XxicxupDFgH+B2zc4N+AvaLiBQv/7Pk33H9SeFFSgFrF9wAAAABJRU5ErkJggg==" height="37" alt="">
                                        <input type="submit" value="Trimite">
                                    </form>
                                </div>                       
                            </div>
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
                            <div class="lang">
                                <p>ro</p>
                                <ul>
                                    <li><a href="http://lpa.devebs.net/language/ru/103">ru</a></li>
                                    <li><a href="http://lpa.devebs.net/language/en/103">en</a></li>
                                    <li><a href="http://lpa.devebs.net/language/bg/103">bg</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>



        <?= $content; ?>


        <?= View::make('block.footer'); ?>