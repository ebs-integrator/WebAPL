<!doctype html>
<html class="no-js">
    <head>
        <meta charset="UTF-8">
        <title><?= varlang('title'); ?></title>

        <!--IE Compatibility modes-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!--Mobile first-->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?= res('assets/lib/bootstrap/css/bootstrap.min.css'); ?>">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= res('assets/lib/font-awesome/css/font-awesome.min.css'); ?>">

        <link rel="stylesheet" href="<?= res('assets/lib/switch/css/bootstrap3/bootstrap-switch.min.css'); ?>">
        <link rel="stylesheet" href="<?= res('assets/lib/treeview/jquery.treeview.css'); ?>">
        <link rel="stylesheet" href="<?= res('assets/lib/chosen/chosen.css'); ?>">
        <link rel="stylesheet" href="<?= res('assets/css/bootstrap-datetimepicker.min.css'); ?>">
        <link rel="stylesheet" href="<?= res('assets/lib/treeview/jquery.treeview.css'); ?>">
        <link rel="stylesheet" type="text/css" media="screen" href="<?= res('assets/lib/jquery-ui/jquery-ui.css') ?>" />

        <!-- Metis core stylesheet -->
        <link rel="stylesheet" href="<?= res('assets/css/main.css'); ?>">

        <!-- Metis Theme stylesheet -->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!--[if lt IE 9]>
          <script src="<?= res('assets/lib/html5shiv/html5shiv.js'); ?>"></script>
          <script src="<?= res('assets/lib/respond/respond.min.js'); ?>"></script>
        <![endif]-->

        <style>
            body.boxed {
                background: url("../img/pattern/arches.png") repeat;
            }
            #top > .navbar {
                border-top: 3px solid #4eb25c;
            }
            #top > .navbar .dropdown-menu > li > a:hover,
            #top > .navbar .dropdown-menu > li > a:focus {
                background-color: #222;
                color: #ffffff;
            }
            #menu {
                background-color: #303030 !important;
            }
            #menu > li > a {
                color: #ffffff;
                text-shadow: none !important;
            }
            .sidebar-left-mini #menu > li > a > .link-title {
                background-color: #303030 !important;
            }
        </style>

        <!--Modernizr 2.8.2-->
        <script src="<?= res('assets/lib/modernizr/modernizr.min.js'); ?>"></script>

        <!--jQuery -->
        <script src="<?= res('assets/lib/jquery/jquery.min.js'); ?>"></script>
        <script>
            var base_url = '<?= url('/'); ?>';
            var assets_url = '<?= res('/'); ?>';
        </script>
    </head>
    <body class="  ">
        <div class="bg-dark dk" id="wrap">
            <div id="top">

                <!-- .navbar -->
                <nav class="navbar navbar-inverse navbar-static-top">
                    <div class="container-fluid">

                        <!-- Brand and toggle get grouped for better mobile display -->
                        <header class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="<?= url('/'); ?>" class="navbar-brand">
                                <img src="<?= res('assets/img/logo.png'); ?>" alt="">
                            </a>
                        </header>
                        <div class="topnav">
                            <div class="btn-group">
                                <a data-placement="bottom" data-original-title="Fullscreen" data-toggle="tooltip" class="btn btn-default btn-sm" id="toggleFullScreen">
                                    <i class="glyphicon glyphicon-fullscreen"></i>
                                </a>
                            </div>
                            <div class="btn-group">
                                <?php foreach (Core\APL\Language::getList() as $lang) { ?>
                                    <a data-placement="bottom" data-original-title="E-mail" data-toggle="tooltip" href="<?=url("home/changelang/".$lang->ext);?>" class="btn btn-default btn-sm <?= $lang->id == Core\APL\Language::getId() ? 'active' : '' ?>">
                                        <?= strtoupper($lang->ext); ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="btn-group">
                                <a href="<?= url('auth/logout'); ?>" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
                                    <i class="fa fa-power-off"></i>
                                </a>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse navbar-ex1-collapse">

                            <!-- .nav -->
                            <ul class="nav navbar-nav">
                                <?php if (User::has("modules-view")) { ?>
                                    <li> <a href="<?= url('module'); ?>"><?= varlang('extensions'); ?></a></li>
                                <?php } ?>
                                <?php if (User::has("user-view")) { ?>
                                    <li> <a href="<?= url('user'); ?>"><?= varlang('users'); ?></a></li>
                                <?php } ?>
                                <?php if (User::has('lang-view')) { ?>
                                    <li> <a href="<?= url('home/languages'); ?>"><?= varlang('languages'); ?></a></li>
                                <?php } ?>
                                <?php if (User::has('settings-view')) { ?>
                                    <li> <a href="<?= url('settings'); ?>"><?= varlang('settings'); ?></a></li>
                                <?php } ?>
                                <?php if (User::has('log-view')) { ?>
                                    <li> <a href="<?= url('log'); ?>"><?= varlang('log'); ?></a></li>
                                <?php } ?>
                                <li><img id="loading" style="display: none;margin-top: 14px;" src="<?= res('assets/img/ajax-loader.gif'); ?>" /></li>
                            </ul><!-- /.nav -->
                        </div>
                    </div><!-- /.container-fluid -->
                </nav><!-- /.navbar -->
            </div><!-- /#top -->
            <div id="left">
                <div class="media user-media bg-dark dker">
                    <div class="user-media-toggleHover">
                        <span class="fa fa-user"></span>
                    </div>
                    <div class="user-wrapper bg-dark">
                        <div class="media-body">
                            <h5 class="media-heading"><?= varlang('hello-'); ?><b><?= Auth::user()->username; ?></b></h5><br>
                        </div>
                    </div>
                </div>

                <!-- #menu -->
                <ul id="menu" class="bg-blue dker">
                    <li class="nav-header"><?= varlang('menu'); ?></li>
                    <li class="nav-divider"></li>
                    <?php if (User::has("page-view")) { ?>
                        <li><a href="<?= url('page'); ?>"><i class="fa"></i><span class="link-title">&nbsp;<?= varlang('pages'); ?></span></a></li>
                    <?php } ?>
                    <?php if (User::has('feed-view')) { ?>
                        <li><a href="<?= url('feed'); ?>"><i class="fa"></i><span class="link-title">&nbsp;<?= varlang('feeds'); ?></span></a></li>
                    <?php } ?>
                    <li><a href="<?= url('var'); ?>"><i class="fa"></i><span class="link-title">&nbsp;<?= varlang('var'); ?></span></a></li>

                    <?= Actions::call('construct_left_menu'); ?>
                </ul><!-- /#menu -->
            </div><!-- /#left -->
            <div id="content">
                <div>
                    <div class="inner bg-light lter">
                        <div class="col-lg-12">
                            <?= $content; ?>
                        </div>
                    </div><!-- /.inner -->
                </div><!-- /.outer -->
            </div><!-- /#content -->
        </div><!-- /#wrap -->
        <footer class="Footer bg-dark dker">
            <p>2014 &copy; APL</p>
        </footer><!-- /#footer -->

        <!-- Modal -->
        <div class="modal fade bs-example-modal-lg" id="fileModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog bs-example-modal-lg">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= varlang('close'); ?></span></button>
                        <h4 class="modal-title" id="myModalLabel"><?= varlang('select-file'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <iframe src data-src="<?= res('assets/lib/fileman/index.html?integration=custom'); ?>" style="width:100%;height:70vh" frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?= varlang('close'); ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!--Bootstrap -->
        <script src="<?= res('assets/lib/bootstrap/js/bootstrap.min.js'); ?>"></script>


        <!-- module -->
        <script src="<?= res('assets/lib/jquery-ui/jquery-ui.min.js'); ?>" type="text/javascript"></script>
        <script src="<?= res('assets/lib/jquery-form/jquery.form.js'); ?>"></script>
        <script src="<?= res('assets/js/inc/widget.file.js'); ?>"></script>
        <script src="<?= res('assets/lib/switch/js/bootstrap-switch.min.js'); ?>"></script>
        <script src="<?= res('assets/lib/treeview/jquery.cookie.js'); ?>"></script>
        <script src="<?= res('assets/lib/treeview/jquery.treeview.js'); ?>"></script>
        <script src="<?= res('assets/lib/chosen/chosen.jquery.js'); ?>"></script>
        <script src="<?= res('assets/lib/ckeditor/ckeditor.js'); ?>"></script>
        <script src="<?= res('assets/lib/ckeditor/adapters/jquery.js'); ?>"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js"></script>
        <script src="<?= res('assets/js/bootstrap-datetimepicker.min.js'); ?>"></script>

        <!-- Screenfull -->
        <script src="<?= res('assets/lib/screenfull/screenfull.js'); ?>"></script>

        <!-- Metis core scripts -->
        <script src="<?= res('assets/js/core.min.js'); ?>"></script>

        <script src="<?= res('assets/js/main.js'); ?>"></script>
    </body>
</html>