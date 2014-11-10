<section>
    <div class="wrap">        
        <div class="contact_left">
            <div class="urg_block">
                <?= View::make('sections.elements.breadcrumbs'); ?>
                <?php if (isset($feedPosts) && count($feedPosts)) { ?>
                <p class="subt"><?= varlang('aprt-primariei'); ?></p>
                    <table class="urg">
                        <thead><tr><td><?= varlang('telefon'); ?></td><td><?= varlang('serviciu'); ?></td></tr></thead>
                        <tbody>
                            <?php foreach ($feedPosts as $item) { ?>
                                <tr>
                                    <td><?= isset($item->phone_one) ? $item->phone_one : ''; ?></td>
                                    <td><?= $item['title']; ?></td>
                                </tr> 
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
            <div class="left_contacts">
                <div class="contact_l">
                    <p class="subt"><?= varlang('legatura-directa'); ?></p>
                    <ul class="date_contact">
                        <li>
                            <img alt=""  src="<?= res('assets/img/c_phone.png'); ?>">
                            <p><?= varlang('phone-anti'); ?></p>
                            <p><?= varlang('nr-anti'); ?></p>
                        </li>
                        <li>
                            <img  alt="" src="<?= res('assets/img/c_mail.png'); ?>">
                            <p><?= varlang('email'); ?></p>
                            <p><?= varlang('email-address'); ?></p>
                        </li>
                        <li>
                            <img  alt="" src="<?= res('assets/img/c_phone.png'); ?>"
                                  <p><?= varlang('relatii'); ?></p>
                            <p><?= varlang('nr-relatii'); ?></p>                                    
                        </li>
                        <li>
                            <img alt=""  src="<?= res('assets/img/c_fx.png'); ?>">
                            <p><?= varlang('fax'); ?></p>
                            <p><?= varlang('nr-fax'); ?></p>
                        </li>
                    </ul>
                    <div class="prp">
                        <a href="<?= WebAPL\Language::url('topropr/more_contacts');?>"><?= varlang('all-nr-phone'); ?></a>
                    </div>
                    <?php Event::fire('contact_col1_contructor'); ?>
                </div>
                <div class="contact_r">
                    <p class="subt"><?= varlang('adresa'); ?></p>
                    <div id="map-canvas2" style="width: 100%; height: 245px;"></div>
                    <div class="prp">
                        <a href="<?= varlang('orar-link'); ?>"><?= varlang('orar-autobus'); ?></a>
                    </div>
                    <div class="map_info"><?= $page->text; ?></div>
                    <?php Event::fire('contact_col2_contructor'); ?>
                </div>
            </div>

        </div>

        <div class="right_contacts">            
            <div class="contact_f">
                <?= View::make('sections.pages.blocks.contactForm'); ?>
                <?php Event::fire('contact_col3_contructor'); ?>                 
            </div>
        </div>
    </div>
</section>

