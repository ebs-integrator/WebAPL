<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login Page</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?= res('assets/lib/bootstrap/css/bootstrap.min.css'); ?>">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= res('assets/lib/font-awesome/css/font-awesome.min.css'); ?>">

        <!-- Metis core stylesheet -->
        <link rel="stylesheet" href="<?= res('assets/css/main.min.css'); ?>">
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
                                Enter your username and password
                            <?php } ?>
                        </p>
                        <input type="text" name="username" placeholder="Username" class="form-control">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                        <button class="btn btn-lg btn-success btn-block" type="submit">Sign in</button>
                    </form>
                </div>
                <div id="forgot" class="tab-pane">
                    <form action="<?=url('auth/remember');?>" class="form-signin" method="post">
                        <p class="text-muted text-center">Enter your valid e-mail</p>
                        <input type="email" placeholder="mail@domain.com" required="required" class="form-control">
                        <br>
                        <button class="btn btn-lg btn-danger btn-block" type="submit">Recover Password</button>
                    </form>
                </div>
            </div>
            <div class="text-center">
                <ul class="list-inline">
                    <li> <a class="text-muted" href="#login" data-toggle="tab">Login</a>  </li>
                    <li> <a class="text-muted" href="#forgot" data-toggle="tab">Forgot Password</a>  </li>
                </ul>
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
