<section>
    <div class="dirs_menu">
        <div class="wrap">
            <a href="javascript:;">Principala »</a>
            <a href="javascript:;">Contacte</a>
        </div>
    </div>
    <div class='wrap'>
        <p class="c_title"><?= varlang('contacts'); ?></p>
        <div class='left contact_r contact_hidden'>
            <p class='subt'><?= varlang('adresa'); ?></p>
            <div id="map-canvas3" style="width:100%; height:300px;"></div>            
        </div>
        <div class='left ccc'>
            <div class="ccc_hidden">                
                <div class="map_info"><?= $page->text; ?></div>
                <div class="prp">
                    <img src="<?= res('assets/img/notebook.png'); ?>">
                    <a href="<?= varlang('orar-link'); ?>"><?= varlang('orar-autobus'); ?></a>
                </div>
            </div>
            <div class='contact_l'>
                <p class='subt'><?= varlang('legatura-directa'); ?></p>
                <ul class='date_contact'>
                    <li>
                        <p><?= varlang('phone-anti'); ?></p>
                        <p><?= varlang('nr-anti'); ?></p>
                    </li>
                    <li>
                        <p><?= varlang('email'); ?></p>
                        <p><?= varlang('email-address'); ?></p>
                    </li>
                    <li>
                        <p><?= varlang('relatii'); ?></p>
                        <p><?= varlang('nr-relatii'); ?></p>                                    
                    </li>
                    <li>
                        <p><?= varlang('fax'); ?></p>
                        <p><?= varlang('nr-fax'); ?></p>
                    </li>
                </ul>
                <div class="prp">
                    <img src="<?= res('assets/img/phone_book.png'); ?>">
                    <a href="urgenta.php"><?= varlang('all-nr-phone'); ?></a>
                </div>

            </div>
            <div class="chat"> 
                <a href="javascript:;">
                    <img src="<?= res('assets/img/chat_man.png'); ?>" class="mn">
                    <span class="chat_dot"></span>
                    <span class="green"><?= varlang('discuta'); ?>-</span><span class="violet"><?= varlang('online'); ?></span>
                    <hr>
                    <p class="center"><?= varlang('vorbeste-direct'); ?></p>
                </a>

            </div>
        </div>
        <div class='left contact_r'>
            <p class='subt'><?= varlang('adresa'); ?></p>
            <div id="map-canvas2" style="width:100%; height:300px;"></div>
            <div class="prp">
                <img src="<?= res('assets/img/notebook.png'); ?>">
                <a href="<?= varlang('orar-link'); ?>"><?= varlang('orar-autobus'); ?></a>
            </div>
            <div class="map_info"><?= $page->text; ?></div>
        </div>
        <div class='left form contact'>
            <?= View::make('sections.pages.blocks.contactForm'); ?>
        </div>
        <div class='clearfix140'></div>
        <?php if ($page->have_socials) { ?>
            <?= View::make('sections.elements.socials', array('url' => $page_url)); ?>
        <?php } ?>
        <div class='hr_grey'></div>
    </div>
</section>