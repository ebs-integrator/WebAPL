<div class="av">
    <p><span><?= varlang('atentie-'); ?></span><?= varlang('atent-msg'); ?></p>
</div>
<div class="form compl">
    <form class="complaint_form" action="#" method="post">
        <p class="ftb"><?= varlang('formular-de-completare'); ?></p>
        <div class="form_error"></div>
        <div class="content">
            <input type="hidden" name="post_id" value="<?=isset($post->id) ? $post->id : '';?>" />
            <div class="nmpm">
                <label><?= varlang('numele-prenume'); ?></label>
                <input name="name" type="text">
            </div>
            <div class="nmpm">
                <label><?= varlang('email-1'); ?></label>
                <input name="email" type="text" >
            </div>
            <div class='clearfix'></div>
            <div class='apt'>
                <label><?= varlang('adresa-postala-telefon-'); ?></label>
                <input name="address" type="text" >
            </div>
            <label><?= varlang('subiect-1'); ?></label>                 
            <input name="subject" type="text"  class="subj">
            <label><?= varlang('mesaj'); ?></label>
            <textarea name="message"></textarea>
            <label><?= varlang('cod-de-verificare'); ?></label>
            <input name="capcha" class="code" type="text">
            <img src="<?= SimpleCapcha::make('complaint'); ?>" height="31">
            <div class="clearfix"></div>
            <div class='radio_b'>
                <input type='radio' name='private' value="0" id='rad1' />
                <label for='rad1'><?= varlang('public'); ?></label>
                <input type='radio' name='private' value="1" id='rad2' checked/>
                <label for='rad2'><?= varlang('privat'); ?></label>
            </div>
            <input type="submit" value="<?= varlang('trimite'); ?>">
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