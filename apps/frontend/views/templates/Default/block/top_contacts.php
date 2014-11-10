<p class="tel"><?= varlang('nr-phone'); ?></p>
    <a class="mini_contacte" href="<?= WebAPL\Language::url('topage/contactsView'); ?>"></a>
    <a class="mini_contacte1" href="<?= WebAPL\Language::url('topage/contactsView'); ?>"></a>
<div class="cont">
    <div class="contact_us_btn">
        <button class="contact_us"><?= varlang('contact-us'); ?></button>
        <div class="cont_form">
            <div class="relative">
                <p></p>
            </div>
            <p class="title"><?= varlang('date-contact'); ?></p>
            <div class="d_hr"></div>
            <ul>
                <li>
                    <p><?= varlang('email'); ?> : <span><a href="mailto:<?= varlang('email-address'); ?>"> <?= varlang('email-address'); ?></a></span></p>
                    <p><?= varlang('relatii'); ?> : <span><?= varlang('nr-relatii'); ?></span></p>
                    <p><?= varlang('fax'); ?> : <span><?= varlang('nr-fax'); ?></span></p>
                </li>
            </ul>
            <div class="clearfix"></div>
            <div class="anp">
                <a href="<?= WebAPL\Language::url('topropr/more_contacts'); ?>"><?= varlang('all-nr-phone'); ?></a>
            </div>
            <div class="anp">
                <a href="<?= varlang('orar-link'); ?>"><?= varlang('orar-autobus'); ?></a>
            </div>
            <div class='clearfix'></div>
            <p class="title"><?= varlang('viziteaza'); ?></p>
            <div class="d_hr"></div>
            <div class="left" onclick="window.open('https://www.google.ro/maps/dir//' + loc_lat + ',' + loc_long + '/@' + loc_lat + ',' + loc_long + ',14z');">
                <div class="c_info">
                    <p class="city"><?= varlang('address'); ?></p>            
                    <p class="street2"><?= varlang('street'); ?></p>
                    <p class="street2"><?= varlang('city'); ?></p>
                </div>
            </div>
            <div class="left map">
                <a href="javascript:window.open('https://www.google.ro/maps/dir//' + loc_lat + ',' + loc_long + '/@' + loc_lat + ',' + loc_long + ',14z');">
                    <img src="<?= res('assets/img/mapitem.png'); ?>" alt="" />
                </a>
            </div>        
            <div class="clearfix10"></div>

            <p class="title"><?= varlang('scrieti-direct'); ?></p>
            <div class="d_hr"></div>
            <div class="contact_top_notif adv" style="display: none;"><?= varlang('success'); ?> </div>
            <form id="contact_top_form" action="<?= url(); ?>" method="post">
                <div class="form_error"></div>
                <input required="" type="text" name="name" placeholder="<?= varlang('name-last-name'); ?>">
                <input required="" type="text" name="email" placeholder="<?= varlang('email'); ?>">
                <textarea required="" name="message" placeholder="<?= varlang('message'); ?>"></textarea>
                <input required="" name="capcha" class="code" type="text">
                <img alt="" src="<?= SimpleCapcha::make('contact_top'); ?>" height="31">
                <input type="submit" value="<?= varlang('send-3'); ?>">
            </form>
        </div>
    </div>


    <div class="currency">
        <span class="s_c">
            <img alt=""  src="<?= res('assets/img/line_dot.png'); ?>">
            <span><?= WebAPL\Language::ext(); ?></span>
            <img alt=""  src="<?= res('assets/img/line_dot.png'); ?>">
        </span>
        <div class="lang">
            <div class="relative">
                <p></p>
            </div>
            <?php
            foreach (WebAPL\Language::getList() as $lang) {
                if (WebAPL\Language::ext() != $lang->ext && $lang->enabled == 1) {
                    ?>
                    <p><a href="<?= url('language/' . $lang->ext . '/' . (isset($active_page_id) ? $active_page_id : '')); ?>"><?= $lang->name; ?></a></p>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>