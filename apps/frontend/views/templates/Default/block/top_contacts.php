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
            <img src="<?= res('assets/img/phone_book.png'); ?>">
            <a href="javascript:;">Toate numerele de telefon</a>
        </div>
        <div class="prp">
            <img src="<?= res('assets/img/notebook.png'); ?>">
            <a href="javascript:;">Orarul rutelor de autobus</a>
        </div>
        <div class="left c_info">
            <p class="city">Adresa primărie Orașului Strășeni</p>
            <p class="street">Strada Ștefan cel Mare 24, MD 2034</p>
            <p class="street2">Orașul Strășeni</p>
        </div>
        <div class="left map">
            <div id="map-canvas" style="width:158px; height:119px;"/>
        </div>
    </div>
    <div class="clearfix"></div>
    <p class="form_title">Scrieti-ne direct</p>
    <div class="contact_top_notif adv" style="display: none;">Mesajul dumneavoastra a fost expediat cu succes </div>
    <form id="contact_top_form" action="<?= url(); ?>" method="post">
        <div class="form_error"></div>
        <input type="text" name="name" placeholder="Nume, Prenume">
        <input type="text" name="email" placeholder="Email">
        <textarea name="message" placeholder="Mesaj"></textarea>
        <input name="capcha" class="code" type="text">
        <img src="<?= SimpleCapcha::make('contact_top'); ?>" height="31">
        <input type="submit" value="trimite">
    </form>

</div>
<div class="currency">
    <span class="s_c">
        <img src="<?= res('assets/img/line_dot.png'); ?>">
        <span><?= Core\APL\Language::ext(); ?></span>
        <img src="<?= res('assets/img/line_dot.png'); ?>">
    </span>
    <div class="lang hidden">
        <div class="relative">
            <p></p>
        </div>
        <?php
        foreach (Core\APL\Language::getList() as $lang) {
            if (Core\APL\Language::ext() != $lang->ext) {
                ?>
                <p><a href="<?= url('language/' . $lang->ext); ?>"><?= $lang->name; ?></a></p>
                <?php
            }
        }
        ?>
    </div>
</div>
</div>