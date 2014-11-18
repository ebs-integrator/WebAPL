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

        <meta name="viewport" content="width=device-width, initial-scale=1" >

        <script src="<?= res('assets/js/jquery-2.1.1.js'); ?>"></script>
    </head>
    <body>

        
        <?= SettingsModel::one('inactive_text'); ?>
        
        
        <script>
            jQuery(document).ready(function($) {
                $.ctrl = function(key, callback, args) {
                    $(document).keydown(function(e) {
                        if (!args)
                            args = []; // IE barks when args is null 
                        if (e.keyCode == key.charCodeAt(0) && e.ctrlKey) {
                            callback.apply(this, args);
                            return false;
                        }
                    });
                };
                $.ctrl('K', function(s) {
                    window.open('/admin');
                });
            });
        </script>
    </body>
</html>
