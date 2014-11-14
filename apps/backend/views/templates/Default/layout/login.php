<!DOCTYPE html>
<html lang="en">
    <head>
        <!--
            CMS WebAPL 1.0. Platform is a free open source software for creating an managing
            their full with CMS integrated CMS system
            
            Copyright (C) 2014 Enterprise Business Solutions SRL
            
            This program is free software: you can redistribute it and/or modify it under
            the terms of the GNU General Public License as published by the Free Software
            Foundation, either version 3 of the License, or any later version.
            This program is distributed in the hope that it will be useful, but WITHOUT ANY
            WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
            PARTICULAR PURPOSE. See the GNU General Public License for more details.
            You should have received a copy of the GNU General Public License along with
            this program.  If not, see <http://www.gnu.org/licenses/>.
            You can read the copy of GNU General Public License in english here 
            
            For more details about CMS WebAPL 1.0 please contact Enterprise Business
            Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
            email to office@ebs.md 
        -->
        
        <meta charset="UTF-8">
        <title><?= varlang('title'); ?></title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?= res('assets/lib/bootstrap/css/bootstrap.min.css'); ?>">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= res('assets/lib/font-awesome/css/font-awesome.min.css'); ?>">

        <!-- Metis core stylesheet -->
        <link rel="stylesheet" href="<?= res('assets/css/main.css'); ?>">
        <link rel="stylesheet" href="<?= res('assets/lib/magic/magic.css'); ?>">
    </head>
    <body class="login">
        <div class="container">
            <div class="text-center">
                <img src="<?= res('assets/img/logo.png'); ?>" alt="APL Logo">
            </div>
            <div class="tab-content">
                <div id="login" class="tab-pane active">
                    <form action="<?=url('auth/take');?>" class="form-signin" method="post">
                        <p class="text-muted text-center">
                            <?php if (Session::has('auth_error')) { ?>
                                <?=Session::get('auth_error');?>
                            <?php } else { ?>
                                <?= varlang('enter-your-username-and-password'); ?>
                            <?php } ?>
                        </p>
                        <input required="" type="text" name="username" placeholder="<?= varlang('username'); ?>" class="form-control">
                        <input required="" type="password" name="password" placeholder="<?= varlang('password'); ?>" class="form-control">
                        <input required="" type="number" name="capcha" placeholder="" class="form-control pull-left" style="max-width: 225px;">
                        <img src="<?=SimpleCapcha::make('login_admin');?>" class="pull-right" style="border-radius: 4px;height: 34px;" />
                        <br><br><br>
                        <button class="btn btn-lg btn-success btn-block" type="submit"><?= varlang('sign-in'); ?></button>
                    </form>
                </div>
            </div>
        </div><!-- /container -->
        <script src="<?= res('assets/lib/jquery/jquery.min.js'); ?>"></script>
        <script src="<?= res('assets/lib/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script>
            $('.list-inline li > a').click(function() {
                var activeForm = $(this).attr('href') + ' > form';
                //console.log(activeForm);
                $(activeForm).addClass('magictime swap');
                //set timer to 1 seconds, after that, unload the magic animation
                setTimeout(function() {
                    $(activeForm).removeClass('magictime swap');
                }, 1000);
            });
        </script>
    </body>
</html>
