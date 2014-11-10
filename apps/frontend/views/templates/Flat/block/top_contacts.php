<p class="telef"><?= varlang('nr-phone'); ?></p>
<div class="cont">
    <a class="contact_us"><?= varlang('contact-us'); ?></a>
    <div class="cont_form">
        <div class="relative">
            <img src="<?= res('assets/img/c_arrow.png'); ?>" alt="">
        </div>
        <p class="title"><?= varlang('date-contact'); ?></p>
        <ul>
            <li>
                <p><?= varlang('email'); ?></p>
                <p><a href="mailto:<?= varlang('email-address'); ?>"> <?= varlang('email-address'); ?></a></p>
            </li>
            <li>
                <p><?= varlang('relatii'); ?></p>
                <p><?= varlang('nr-relatii'); ?></p>
            </li>
            <li>
                <p><?= varlang('fax'); ?></p>
                <p><?= varlang('nr-fax'); ?></p>
            </li>
            <div class="clearfix"></div>
        </ul>
        <div class="prp">
            <a href="<?= WebAPL\Language::url('topropr/more_contacts'); ?>"><?= varlang('all-nr-phone'); ?></a>
        </div>
        <div class="prp">
            <a href="<?= varlang('orar-link'); ?>"><?= varlang('orar-autobus'); ?></a>
        </div>
        <div class="left c_info"  onclick="window.open('https://www.google.ro/maps/dir//' + loc_lat + ',' + loc_long + '/@' + loc_lat + ',' + loc_long + ',14z');">
            <p class="city"><?= varlang('address'); ?></p>
            <p class="street"><?= varlang('street'); ?></p>
            <p class="street"><?= varlang('city'); ?></p>
        </div>
        <div class="right map">
            <a href="javascript:window.open('https://www.google.ro/maps/dir//' + loc_lat + ',' + loc_long + '/@' + loc_lat + ',' + loc_long + ',14z');">
                <img src="<?= res('assets/img/mapitem.png'); ?>" alt="" />
            </a>
        </div>
        <div class="clearfix"></div>
        <p class="form_title"><?= varlang('scrieti-direct'); ?></p>
        <div class="contact_top_notif adv" style="display: none;"><?= varlang('success'); ?> </div>
        <form id="contact_top_form" action="<?= url(); ?>" method="post">
            <div class="form_error"></div>
            <input required="" type="text" name="name" placeholder="<?= varlang('name-last-name'); ?>">
            <input required="" type="text" name="email" placeholder="<?= varlang('email'); ?>">
            <textarea name="message" placeholder="<?= varlang('message'); ?>"></textarea>
            <input required="" name="capcha" class="code" type="text">
            <img src="<?= SimpleCapcha::make('contact_top'); ?>" height="37"  alt="">
            <input type="submit" value="<?= varlang('send-3'); ?>">
        </form>
    </div>                       
</div>