<section>
    <div class="wrap">
        <div class="left_block">
            <div class="contact_l">
                <p class="subt"><?= varlang('legatura-directa'); ?></p>
                <ul class="date_contact">
                    <li>
                        <img src="<?= res('assets/img/c_phone.png'); ?>">
                        <p><?= varlang('phone-anti'); ?></p>
                        <p><?= varlang('nr-anti'); ?></p>
                    </li>
                    <li>
                        <img src="<?= res('assets/img/c_mail.png'); ?>">
                        <p><?= varlang('email'); ?></p>
                        <p><?= varlang('email-address'); ?></p>
                    </li>
                    <li>
                        <img src="<?= res('assets/img/c_phone.png'); ?>"
                             <p><?= varlang('relatii'); ?></p>
                        <p><?= varlang('nr-relatii'); ?></p>                                    
                    </li>
                    <li>
                        <img src="<?= res('assets/img/c_fx.png'); ?>">
                        <p><?= varlang('fax'); ?></p>
                        <p><?= varlang('nr-fax'); ?></p>
                    </li>
                    <div class="clearfix"></div>
                </ul>
                <div class="prp">
                    <a href="<?= PostProperty::postWithProperty('more_contacts', true)->url; ?>"><?= varlang('all-nr-phone'); ?></a>
                </div>
                <?= \Core\APL\Actions::call('contact_col1_contructor'); ?>
            </div>
        </div>
        <div class="right_block">
            <?= View::make('sections.elements.breadcrumbs'); ?>

            <div class="contact_r">
                <p class="subt"><?= varlang('adresa'); ?></p>
                <div id="map-canvas2" style="width: 100%; height: 445px;"></div>
                <div class="prp">
                    <a href="<?= varlang('orar-link'); ?>"><?= varlang('orar-autobus'); ?></a>
                </div>
                <div class="map_info"><?= $page->text; ?></div>
                <?= \Core\APL\Actions::call('contact_col2_contructor'); ?>
            </div>


            <div class="contact_f">
                <?= View::make('sections.pages.blocks.contactForm'); ?>
                <?= \Core\APL\Actions::call('contact_col3_contructor'); ?>                 
            </div>
        </div>
    </div>
</section>

