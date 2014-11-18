<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
    <head>
        <!--
            CMS Platform WebAPL 1.0 is a free open source software for creating and managing
            a web site for Local Public Administration institutions. The platform was
            developed at the initiative and on a concept of USAID Local Government Support
            Project in Moldova (LGSP) by the Enterprise Business Solutions Srl (www.ebs.md).
            The opinions expressed on the website belong to their authors and do not
            necessarily reflect the views of the United States Agency for International
            Development (USAID) or the US Government.

            This program is free software: you can redistribute it and/or modify it under
            the terms of the GNU General Public License as published by the Free Software
            Foundation, either version 3 of the License, or any later version.

            This program is distributed in the hope that it will be useful, but WITHOUT ANY
            WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
            PARTICULAR PURPOSE. See the GNU General Public License for more details.

            You should have received a copy of the GNU General Public License along with
            this program. If not, you can read the copy of GNU General Public License in
            English here: <http://www.gnu.org/licenses/>.

            For more details about CMS WebAPL 1.0 please contact Enterprise Business
            Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
            email to office@ebs.md 
        -->
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= WebAPL\Template::getPageTitle(isset($page) ? $page : null); ?></title>

        <?php foreach (\WebAPL\Template::getMetas() as $metaName => $metaContent) { ?>
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
            var disqus_title = '<?= WebAPL\Template::getPageTitle(isset($page) ? $page : null); ?>';
            var disqus_config = function () {
                this.language = "<?= WebAPL\Language::ext(); ?>";
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
                <div class="img_back">
                    <?php
                    $bg_final = res('assets/img/top1.png');
                    if (isset($page['id']) && $bg_page = Files::extract('page_bg', $page['id'], 'path')) {
                        $bg_final = url($bg_page);
                    } elseif (isset($super_parent['id']) && $bg_parent = Files::extract('page_bg', $super_parent['id'], 'path')) {
                        $bg_final = url($bg_parent);
                    }
                    ?>
                    <img alt="" class="top_back" src="<?= $bg_final; ?>">
                </div>
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
                                        <?php foreach (WebAPL\Language::getList() as $lang) { ?>
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
                            <?= View::make('block.top_contacts'); ?>
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
                                <p><?= WebAPL\Language::ext(); ?></p>
                                <ul>
                                    <?php
                                    foreach (WebAPL\Language::getList() as $lang) {
                                        if (WebAPL\Language::ext() != $lang->ext && $lang->enabled == 1) {
                                            ?>
                                            <li><a href="<?= url('language/' . $lang->ext . '/' . (isset($active_page_id) ? $active_page_id : '')); ?>"><?= $lang->ext; ?></a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="top_search">
            <form method="get" action="<?= Language::url('search'); ?>">
                <div><input type="text" name="words" placeholder="<?= varlang('cautare'); ?>"></div>
                <input type="submit" value="<?= varlang('submit'); ?>">
            </form>
        </div>


        <?= $content; ?>


        <?= View::make('block.footer'); ?>