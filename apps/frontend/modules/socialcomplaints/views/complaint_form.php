<div class="av">
    <p><span>ATENTIE ! </span>Petitiile anonime sau cele in care nu sunt trecute datele de identificare ale persoanei nu se iau în considerare si se claseaza, potrivit prezentei ordonante, administratorul site-ului rezervindu-si dreptul de a nu le face publice.</p>
</div>
<div class="form compl">
    <form class="complaint_form" action="#" method="post">
        <p class="ftb">Formular de completare</p>
        <div class="form_error"></div>
        <div class="content">
            <div class="nmpm">
                <label>Numele Prenume*</label>
                <input name="name" type="text">
            </div>
            <div class="nmpm">
                <label>Email*</label>
                <input name="email" type="text" >
            </div>
            <div class='clearfix'></div>
            <div class='apt'>
                <label>Adresa Postala/Telefon </label>
                <input name="address" type="text" >
            </div>
            <label>Subiect*</label>                 
            <input name="subject" type="text"  class="subj">
            <label>Mesaj</label>
            <textarea name="message"></textarea>
            <label>Cod de verificare*</label>
            <input name="capcha" class="code" type="text">
            <img src="<?= SimpleCapcha::make('complaint'); ?>" height="31">
            <div class="clearfix"></div>
            <div class='radio_b'>
                <input type='radio' name='private' value="0" id='rad1' />
                <label for='rad1'>Public</label>
                <input type='radio' name='private' value="1" id='rad2' checked/>
                <label for='rad2'>Privat</label>
            </div>
            <input type="submit" value="trimite">
            <div class="clearfix"></div>
        </div>
    </form>
</div>

<script>
    jQuery(document).ready(function($) {

        $(".complaint_form").submit(function(e) {
            e.preventDefault();

            var form = $(this);

            $.post('<?= url('create_complaint'); ?>', $(this).serialize(), function(data) {
                if (data.error == 0) {
                    form.fadeOut(400, function () {
                        $(this).remove();
                    });
                } else { 
                    form.find(".form_error").html(data.message);
                }
            });

            return false;
        });

    });
</script>