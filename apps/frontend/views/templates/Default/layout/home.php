<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link href="<?=res('assets/css/jquery.bxslider.css');?>" rel="stylesheet" />
        <link rel="stylesheet" href="<?=res('assets/css/normalize.css');?>">
        <link rel="stylesheet" href="<?=res('assets/css/main.css');?>">
<!--        <link rel="stylesheet" href="/css/jquery.selectBoxIt.css">-->
        
    </head>
    <body>
        <div class="overlay hidden"></div>
        <div class="overlay2 hidden"></div>
        <header>
            <div class="left">
                <button class="chat">
                    <span class="green">Chat</span><span class="violet">-online</span>
                    <span class="g_dot"></span>
                </button>
            </div>
            <div class="contact right">
                <p class="tel">(022) 22-32-53</p>
                <div class="cont">
                    <button class="contact_us">Contactează-ne</button>
                    <div class="cont_form hidden">
                        <div class="relative">
                            <p></p>
                        </div>
                        <p class="title">Contacte</p>
                        <div class="d_hr"></div>
                        <ul>
                            <li>
                                <p>Telefon Anticameră</p>
                                <p>(0-237) 22-33-44</p>
                            </li>
                            <li>
                                <p>Email</p>
                                <p>info@straseni.gov.md</p>
                            </li>
                            <li>
                                <p>Relatii cu publicul </p>
                                <p>(0-237) 22-33-44</p>                                    
                            </li>
                            <li>
                                <p>Fax</p>
                                <p>(0-237) 55-66-77</p>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="prp">
                            <img src="<?=res('assets/img/phone_book.png');?>">
                            <a href="javascript:;">Toate numerele de telefon</a>
                        </div>                            
                        <div class="prp">
                            <img src="<?=res('assets/img/notebook.png');?>">
                            <a href="javascript:;">Orarul rutelor</a>
                        </div>
                        <div class="left c_info">
                            <p class="city">Orașul Strășeni</p>
                            <p class="street">Strada Ștefan cel Mare 24, MD 2034</p>
                            <p class="street">Orașul Strășeni</p>
                        </div>
                        <div class="left map">
                            <div id="map-canvas"/>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <p class="form_title">Scrieti-ne direct</p>
                    <form method="" action="">
                        <input type="text" placeholder="Nume, Prenume">
                        <input type="text" placeholder="Email">
                        <textarea placeholder="Mesaj"></textarea>
                        <input type="submit">
                    </form>
                </div>
                <div class="currency">                        
                    <span class="s_c">
                        <img src="<?=res('assets/img/line_dot.png');?>">
                        <span>ro</span>
                        <img src="<?=res('assets/img/line_dot.png');?>">
                    </span>
                    <div class="lang hidden">
                        <div class="relative">
                            <p></p>
                        </div>
                        <p>Romană</p>
                        <p>Rusă</p>
                        <p>Engleza</p>
                        <p>Bulgară</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="hr"></div>
    </header>



<?=$content;?> 


<?=View::make('block.footer');?>