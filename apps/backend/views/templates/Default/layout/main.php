<!doctype html>
<html class="no-js">
    <head>
        <meta charset="UTF-8">
        <title>Metis</title>

        <!--IE Compatibility modes-->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!--Mobile first-->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?=res('assets/lib/bootstrap/css/bootstrap.min.css');?>">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?=res('assets/lib/font-awesome/css/font-awesome.min.css');?>">

        <!-- Metis core stylesheet -->
        <link rel="stylesheet" href="<?=res('assets/css/main.css');?>">

        <!-- Metis Theme stylesheet -->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!--[if lt IE 9]>
          <script src="<?=res('assets/lib/html5shiv/html5shiv.js');?>"></script>
          <script src="<?=res('assets/lib/respond/respond.min.js');?>"></script>
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
        <script src="<?=res('assets/lib/modernizr/modernizr.min.js');?>"></script>
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
                            <a href="index.html" class="navbar-brand">
                                <img src="<?=res('assets/img/logo.png');?>" alt="">
                            </a> 
                        </header>
                        <div class="topnav">
                            <div class="btn-group">
                                <a data-placement="bottom" data-original-title="Fullscreen" data-toggle="tooltip" class="btn btn-default btn-sm" id="toggleFullScreen">
                                    <i class="glyphicon glyphicon-fullscreen"></i>
                                </a> 
                            </div>
                            <div class="btn-group">
                                <a data-placement="bottom" data-original-title="E-mail" data-toggle="tooltip" class="btn btn-default btn-sm">
                                    <i class="fa fa-envelope"></i>
                                    <span class="label label-warning">5</span> 
                                </a>
                                <a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#helpModal">
                                    <i class="fa fa-question"></i>
                                </a> 
                            </div>
                            <div class="btn-group">
                                <a href="<?=url('auth/logout');?>" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
                                    <i class="fa fa-power-off"></i>
                                </a> 
                            </div>
                        </div>
                        <div class="collapse navbar-collapse navbar-ex1-collapse">

                            <!-- .nav -->
                            <ul class="nav navbar-nav">
                                <li> <a href="dashboard.html">item</a></li>
                                <li> <a href="dashboard.html">item</a></li>
                                <li> <a href="dashboard.html">item</a></li>
                                <li> <a href="dashboard.html">item</a></li>
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
                            <h5 class="media-heading">Hello, <b><?=Auth::user()->username;?></b></h5><br>
                        </div>
                    </div>
                </div>

                <!-- #menu -->
                <ul id="menu" class="bg-blue dker">
                    <li class="nav-header">Menu</li>
                    <li class="nav-divider"></li>
                    <li><a href="dashboard.html"><i class="fa fa-dashboard"></i><span class="link-title">&nbsp;Extensions</span></a></li>
                    <li><a href="dashboard.html"><i class="fa fa-dashboard"></i><span class="link-title">&nbsp;Dashboard</span></a></li>
                    <li><a href="dashboard.html"><i class="fa fa-dashboard"></i><span class="link-title">&nbsp;Dashboard</span></a></li>
                    <li><a href="dashboard.html"><i class="fa fa-dashboard"></i><span class="link-title">&nbsp;Dashboard</span></a></li>
                </ul><!-- /#menu -->
            </div><!-- /#left -->
            <div id="content">
                <div>
                    <div class="inner bg-light lter">
                        <div class="col-lg-12">
                            <?=$content;?>
                        </div>
                    </div><!-- /.inner -->
                </div><!-- /.outer -->
            </div><!-- /#content -->
        </div><!-- /#wrap -->
        <footer class="Footer bg-dark dker">
            <p>2014 &copy; APL</p>
        </footer><!-- /#footer -->

        <!-- #helpModal -->
        <div id="helpModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                            in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal --><!-- /#helpModal -->

        <!--jQuery 2.1.1 -->
        <script src="<?=res('assets/lib/jquery/jquery.min.js');?>"></script>

        <!--Bootstrap -->
        <script src="<?=res('assets/lib/bootstrap/js/bootstrap.min.js');?>"></script>

        <!-- Screenfull -->
        <script src="<?=res('assets/lib/screenfull/screenfull.js');?>"></script>

        <!-- Metis core scripts -->
        <script src="<?=res('assets/js/core.min.js');?>"></script>

        <!-- Metis demo scripts -->
        <script src="<?=res('assets/js/app.min.js');?>"></script>
        <script src="<?=res('assets/js/style-switcher.min.js');?>"></script>
    </body>
</html>