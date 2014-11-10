<section>
    <div class="dirs_menu">
        <div class="wrap">
            <a href="/"><?= varlang('acasa'); ?> »</a>
            <a href="javascript:;"><?= varlang('contacts'); ?></a>
        </div>
    </div>
    <div class='wrap'>
        <p class="c_title"><?= varlang('contacts'); ?></p>
        <div class='left ccc'>
            <div class="emrg_block">
                <p class='subt'><?= varlang('aprt-primariei'); ?></p>
                <div class="emrg">
                    <p class="ul_title">
                        <span class="left"><?= varlang('telefon'); ?>	</span>
                        <span class="right"><?= varlang('serviciu'); ?></span>
                    </p>
                    <ul>
                        <?php foreach ($feedPosts as $item) { ?>
                            <li>
                                <div class="left"><?= isset($item->phone_one) ? $item->phone_one : ''; ?></div>
                                <div class="right"><?= $item['title']; ?></div>
                            </li>
                        <?php } ?>
                    </ul>
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
                    <img  alt="" src="<?= res('assets/img/phone_book.png'); ?>">
                    <a href="<?= WebAPL\Language::url('topropr/more_contacts');?>"><?= varlang('all-nr-phone'); ?></a>
                </div>
                <?php Event::fire('contact_col1_contructor'); ?>
                <div class="clearfix25"></div>
                <div class='left contact_r'>
                    <p class='subt'><?= varlang('adresa'); ?></p>
                    <div id="map-canvas2" style="width:100%; height:300px;"></div>
                    <div class="prp">
                        <img  alt="" src="<?= res('assets/img/notebook.png'); ?>">
                        <a href="<?= varlang('orar-link'); ?>"><?= varlang('orar-autobus'); ?></a>
                    </div>
                    <div class="map_info"><?= $page->text; ?></div>
                    <?php Event::fire('contact_col2_contructor'); ?>
                </div>
            </div>

        </div>

        <div class='left form contact'>
            <?= View::make('sections.pages.blocks.contactForm'); ?>
            <?php Event::fire('contact_col3_contructor'); ?>
        </div>
        <?php if ($page->have_socials) { ?>
            <?= View::make('sections.elements.socials', array('url' => $page_url)); ?>
        <?php } ?>
        <div class='hr_grey'></div>
    </div>
</section>