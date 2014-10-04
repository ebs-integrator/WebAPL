<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>APL::Install</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

    </head>
    <body>

        <div class="container-fluid">
            <div class="col-sm-8"><br></div>
            <div class="row col-sm-8 col-sm-offset-2">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <span class="navbar-brand">INSTALARE PLATFORMA</span>
                        </div>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-9">
                            <ul class="nav navbar-nav">
                                <li class="<?=isset($step) && $step == 1 ? 'active' : '';?>"><a>Welcome</a></li>
                                <li class="<?=isset($step) && $step == 2 ? 'active' : '';?>"><a>Step 2</a></li>
                                <li class="<?=isset($step) && $step == 3 ? 'active' : '';?>"><a>Step 3</a></li>
                                <li class="<?=isset($step) && $step == 4 ? 'active' : '';?>"><a>Step 4</a></li>
                                <li class="<?=isset($step) && $step == 5 ? 'active' : '';?>"><a>Step 5</a></li>
                                <li class="<?=isset($step) && $step == 6 ? 'active' : '';?>"><a>Finish</a></li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
                <?= $content; ?>
            </div>
        </div>

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>
