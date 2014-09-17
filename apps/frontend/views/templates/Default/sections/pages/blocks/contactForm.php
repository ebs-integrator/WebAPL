<form class="contact_sub_form" action="contact/submit" method="post">
    <p class="ftb">Scrieți-ne direct</p>
    <div class="content green">
        <div class="form_error"></div>
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
        <label class="code_lbl">Cod de verificare*</label>
        <input class="code" name="capcha" type="text">
        <img height="31" src="<?= SimpleCapcha::make('contact'); ?>">
        <div class="clearfix"></div>
        <input type="submit" value="trimite">
        <div class="clearfix"></div>
    </div>
</form>


<script>
    jQuery(document).ready(function($) {

        $(".contact_sub_form").submit(function(e) {
            e.preventDefault();

            var form = $(this);

            $.post('<?= url('contact/submit'); ?>', $(this).serialize(), function(data) {
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