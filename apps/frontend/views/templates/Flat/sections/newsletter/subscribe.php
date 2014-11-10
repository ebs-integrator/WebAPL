
<script>
    jQuery(document).ready(function ($) {

        $(".newsletter_subscribe_form").submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.post('<?= url('newsletter/subscribe'); ?>', $(this).serialize(), function (data) {
                if (data.error == 0) {
                    form.html("<font color='white'>Multumesc pentru abonare!</font>");
                } else {
                    alert(data.message);
                }
            });
            return false;
        });

    });
</script>

<form class="newsletter_subscribe_form" action="<?= url('newsletter/subscribe'); ?>">
    <label><?= varlang('aboneazatate-la-buletin'); ?></label>
    <input name="email" type="text" placeholder="<?= varlang('email-dvs'); ?>">
    <input type="submit" value="<?= varlang('submit-1'); ?>">
</form>


