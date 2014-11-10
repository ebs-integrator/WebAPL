<form class="contact_sub_form" action="contact/submit" method="post">
    <p class="ftb"><?= varlang('scrieti-direct'); ?></p>
    <div class="content green">
        <div class="form_error"></div>
        <div class="nmpm">
            <label><?= varlang('name-last-name'); ?>*</label>
            <input required="" name="name" type="text">
        </div>
        <div class="nmpm">
            <label><?= varlang('email'); ?>*</label>
            <input required="" name="email" type="text" >
        </div>
        <div class='clearfix'></div>
        <div class='apt'>
            <label><?= varlang('adresa-telefon'); ?> </label>
            <input required="" name="address" type="text" >
        </div>
        <label><?= varlang('subiect'); ?>*</label>
        <input required="" name="subject" type="text"  class="subj">
        <label><?= varlang('message'); ?></label>
        <textarea required="" name="message"></textarea>
        <label class="code_lbl"><?= varlang('cod-verificare'); ?>*</label>
        <input required="" class="code" name="capcha" type="text">
        <img  alt="" height="31" src="<?= SimpleCapcha::make('contact'); ?>">
        <div class="clearfix"></div>
        <input type="submit" value="<?= varlang('send-3'); ?>">
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
                        $(this).html(data.html).fadeIn(300);
                    });
                } else { 
                    form.find(".form_error").html(data.message);
                }
            });

            return false;
        });

    });
</script>