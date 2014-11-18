<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
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
            <meta name="<?= $metaName; ?>" content="<?= $metaContent; ?>">
        <?php } ?>

        <meta name="viewport" content="width=device-width, initial-scale=1" >

        <link href="<?= res('assets/css/jquery.bxslider.css'); ?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?= res('assets/css/normalize.css'); ?>" />
        <link rel="stylesheet" href="<?= res('assets/css/main.css'); ?>"/>

        <?php if (isset($favicon) && $favicon) { ?>
            <link rel="icon" href="<?= url($favicon->path); ?>" type="image/x-icon" />
        <?php } ?>

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
        <header>
            <div class="left">
                <?php if (Files::extract('website_logo_sm_' . WebAPL\Language::ext(), 1, 'path')) { ?>
                    <a href="<?= Language::url('/'); ?>"><img alt=""  src="<?= url(Files::extract('website_logo_sm_' . WebAPL\Language::ext(), 1, 'path')); ?>" title="<?= Files::extract('website_logo_sm_' . WebAPL\Language::ext(), 1, 'name'); ?>" alt="<?= Files::extract('website_logo_sm_' . WebAPL\Language::ext(), 1, 'name'); ?>" class="logo logo_home"></a>
                <?php } ?>
                <?php Event::fire('logo_contructor'); ?>
            </div>
            <div class="left home_menu">
                <div class="left">
                    <?= View::make('sections.elements.topmenu'); ?>
                </div>
                <div class="header_mini ">
                    <div class="head_list"></div>                
                </div>
                <div class="contact right"><?= View::make('block.top_contacts'); ?></div>
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
                <li><?= varlang('nr-phone'); ?></li>
                <li><a href='<?= varlang('facebook_link'); ?>' class="fb"><?= varlang('facebook'); ?></a></li>
                <li><a href='<?= varlang('odnoklassniki-link-1'); ?>' class="odno"><?= varlang('odnoklassniki'); ?></a></li>
                <li><a href='<?= varlang('vkontakte-link'); ?>' class="vk"><?= varlang('vkontakte'); ?></a></li>
                <li><a href='<?= varlang('twitter-link'); ?>' class="twitter"><?= varlang('twitter'); ?></a></li>
                <li><a href='<?= varlang('gplus-link'); ?>' class="gplus"><?= varlang('gplus'); ?></a></li>
                <li><a href='<?= varlang('rss-link'); ?>' class="rsss"><?= varlang('rss'); ?></a></li>
            </ul>
        </div>
        <div class="top_search">
            <form action="<?= Language::url('search'); ?>" method="get">                
                <div><input type="text" name="words" placeholder="<?= varlang('cautare'); ?>"></div>
                <input type="submit" value="<?= varlang('submit'); ?>">
            </form>
        </div>
        <?= $content; ?> 


        <?= View::make('block.footer'); ?>
