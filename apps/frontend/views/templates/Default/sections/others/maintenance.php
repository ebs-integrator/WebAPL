<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
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
