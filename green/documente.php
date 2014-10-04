<?php include "blocks/page.php"; ?>

<section>
    <div class="wrap">
        <div class="left_block">
            <nav>
                <a href="javascript:;">
                    <p>Întrebări frecvente</p>
                    <span>Daca aveti intrebari referirtor la utilizarea sute-ului va rugat sa accesatzi meniul dat</span>
                    <div class="more"></div>
                </a>
            </nav>
            <nav>
                <a href="javascript:;">
                    <p>Modele de cereri</p>
                    <span>Promit să construiesc case pentru sute de familii. </span>
                    <div class="more"></div>
                </a>
            </nav>
            <nav>
                <a href="javascript:;">
                    <p>Ghid de completare</p>
                    <span>Promit să fac din acest oras alegerea preferată pentru investiții și crearea de locuri de muncă. </span>
                    <div class="more"></div>
                </a>
            </nav>
        </div>
        <div class="right_block">
            <div class="dirs_menu">
                <a href="javascript:;">Principala »</a>
                <a href="javascript:;">Cetățeni și Business »</a>      
                <a href="javascript:;">Autorizații și certificate »</a>     
                <a href="javascript:;">Întrebări frecvente/ Modele de cereri / Ghid de completare »</a>                 
                <a href="javascript:;">Modele de cereri</a>
            </div>
            <form method="" action="" class="search">
                <input type="text" placeholder="Caută modelul/formularul">
                <input type="submit" value="caută">
            </form>
            <ul class="docs">
                <li class="doc"><a href="javascript:;">Cerere eliberare acord de functionare <span class="dwnl"></span></a></li>
                <li class="pdf"><a href="javascript:;">Cerere de stabilire a sumei datorate pentru ocuparea domeniului public cu cale de acces  <span class="dwnl"></span></a></li>
                <li class="xls"><a href="javascript:;">Cerere stabilire sume pentru ocuparea domeniului public cu ghereta  <span class="dwnl"></span></a></li>
                <li class="doc"><a href="javascript:;">Cerere eliberare acord de functionare <span class="dwnl"></span></a></li>
                <li class="doc"><a href="javascript:;">Cerere de stabilire a sumei datorate pentru ocuparea domeniului public cu cale de acces  <span class="dwnl"></span></a></li>
                <li class="xlsx"><a href="javascript:;">Cerere eliberare acord de functionare <span class="dwnl"></span></a></li>
                <li class="pdf"><a href="javascript:;">Cerere stabilire sume pentru ocuparea domeniului public cu ghereta  <span class="dwnl"></span></a></li>
                <li class="pdf"><a href="javascript:;">Cerere de stabilire a sumei datorate pentru ocuparea domeniului public cu cale de acces  <span class="dwnl"></span></a></li>
                <li class="doc"><a href="javascript:;">Cerere eliberare acord de functionare <span class="dwnl"></span></a></li>
                <li class="doc"><a href="javascript:;">Cerere eliberare acord de functionare <span class="dwnl"></span></a></li>
                <li class="doc"><a href="javascript:;">Cerere de stabilire a sumei datorate pentru ocuparea domeniului public cu cale de acces  <span class="dwnl"></span></a></li>
                <li class="xlsx"><a href="javascript:;">Cerere eliberare acord de functionare <span class="dwnl"></span></a></li>
                <li class="pdf"><a href="javascript:;">Cerere stabilire sume pentru ocuparea domeniului public cu ghereta  <span class="dwnl"></span></a></li>
                <li class="pdf"><a href="javascript:;">Cerere de stabilire a sumei datorate pentru ocuparea domeniului public cu cale de acces  <span class="dwnl"></span></a></li>
                <li class="doc"><a href="javascript:;">Cerere eliberare acord de functionare <span class="dwnl"></span></a></li>
            </ul>
            <div class='pag'>
                <span class='w_p'>Pagina</span>
                <!--<span class='p_n'><a href='javascript:;'>Precedenta</a></span>-->
                <ul>
                    <?php echo $presenter->render(); ?>
                </ul>
                <!--<span class='n_p'><a href='javascript:;'>următoarea</a></span>-->
            </div>
            <div class="clearfix50"></div>
            <table>
                <tr>
                    <td>
                        <div class="fb-like"  data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                    </td>
                    <td>
                        <a href="https://twitter.com/" class="twitter-share-button" >Tweet</a>
                    </td>
                    <td>
                        <div id="ok_shareWidget"></div>   
                    </td>
                </tr>
            </table>
        </div>
        <div class="clearfix50"></div>
    </div>

</section>
<?php include"blocks/footer.php"; ?>



