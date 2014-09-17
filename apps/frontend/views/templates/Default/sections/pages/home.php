<section>
    <div class="logo">
        <img src="<?= res('assets/img/logo.png'); ?>">
    </div>
    <div class="menu">

        <img src="<?= res('assets/img/back1.png'); ?>" class="backg">
        <div class="wrap"> 
            <?php foreach ($general_pages as $item) { ?>
                <div class="box">                    
                    <a href="<?= $item->url; ?>" class="<?= $item->id == $page->id ? 'active' : ''; ?>">
                        <span class="menu_img"><img src="<?= res('assets/img/menu4.png'); ?>"></span>
                        <span class="menu_title"><?= $item->title; ?></span>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<section>
    <div class="wrap ">
        <div class="right global">   
<!--            <article class="doc">
                <p class="ttl"><img src="<?= res('assets/img/doc.png'); ?>"><a href="javascript:;">Toate actele locale</a></p>
                <div class="hr"></div>
                <ul class="bxslider2">
                    <li>
                        <table>
                            <tr>
                                <td> Denumire:</td>
                                <td>Cu privire la aprobarea Regulamentului privind organizarea educaţiei incluzive în instituţiile de învăţămînt preuniversitar din mun. Bălţi</td>
                            </tr>
                            <tr>
                                <td>Tipul Doc.:</td>
                                <td>Decizie</td>                                    
                            </tr>
                            <tr>
                                <td>Emis:</td>
                                <td>Primăria Strășeni</td>                                    
                            </tr>
                            <tr>
                                <td>Data emiterii:  </td>
                                <td>31.07.2014</td>                                    
                            </tr>
                        </table>
                    </li>

                    <li>
                        <table>
                            <tr>
                                <td> Denumire:</td>
                                <td>Cu privire la aprobarea Regulamentului privind organizarea educaţiei incluzive în instituţiile de învăţămînt preuniversitar din mun. Bălţi</td>
                            </tr>
                            <tr>
                                <td>Tipul Doc.:</td>
                                <td>Decizie</td>                                    
                            </tr>
                            <tr>
                                <td>Emis:</td>
                                <td>Primăria Strășeni</td>                                    
                            </tr>
                            <tr>
                                <td>Data emiterii:  </td>
                                <td>31.07.2014</td>                                    
                            </tr>
                        </table>
                    </li>

                    <li>
                        <table>
                            <tr>
                                <td> Denumire:</td>
                                <td>Cu privire la aprobarea Regulamentului privind organizarea educaţiei incluzive în instituţiile de învăţămînt preuniversitar din mun. Bălţi</td>
                            </tr>
                            <tr>
                                <td>Tipul Doc.:</td>
                                <td>Decizie</td>                                    
                            </tr>
                            <tr>
                                <td>Emis:</td>
                                <td>Primăria Strășeni</td>                                    
                            </tr>
                            <tr>
                                <td>Data emiterii:  </td>
                                <td>31.07.2014</td>                                    
                            </tr>
                        </table>
                    </li>
                </ul>
            </article>-->
            <article class="news">
                <p class="ttl"><img src="<?= res('assets/img/stiri.png'); ?>"><a href="javascript:;">Știri</a></p>
                <div class="hr"></div>
                <ul>
                    <li>
                        <span>18 Iul 2014
                            <img src="<?= res('assets/img/d_arrow.png'); ?>">
                        </span>
                        <a href="javascript:;">„Priveşti şi câştigi”: Norocul a dat peste o familie din Străşeni</a>
                    </li>
                    <li>
                        <span>18 Iul 2014
                            <img src="<?= res('assets/img/d_arrow.png'); ?>">
                        </span>
                        <a href="javascript:;">Persoanele îmbolnăvite de hepatită virală A la Drăgușeni sunt copii. Ce spun epidemiologii </a>
                    </li>
                </ul>
                <a href="javascript:;" class="more"></a>
            </article>
        </div>
        <div class="left global">    
            <?php foreach ($sub_pages as $item) { ?>
                <article>
                    <p class="ttl"> <a href="<?= $item->url; ?>"><?= $item->title; ?></a></p>
                    <ul>
                        <?php
                        foreach ($item['childrens'] as $k => $chitem) {
                            if ($k < 4) {
                                ?>
                                <li><a href="<?= $chitem->url; ?>"><?= $chitem->title; ?></a></li>
                                <?php
                            }
                        }
                        ?> 
                    </ul> 
                    <a href="<?= $item->url; ?>" class="more"></a>
                </article>
            <?php } ?>
        </div>
    </div>
    <div class="clearfix"></div>
</section>
