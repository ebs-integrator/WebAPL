<div class="left email">
    <script>
        jQuery(document).ready(function($) {

            $(".newsletter_subscribe_form").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                $.post('<?= url('newsletter/subscribe'); ?>', $(this).serialize(), function(data) {
                    if (data.error == 0) {
                        $(".email").text("Multumesc pentru abonare!");
                    } else {
                        alert(data.message);
                    }
                });
                return false;
            });

        });
    </script>

    <p><?= varlang('aboneazatate-la-buletin'); ?></p>
    <img src="<?= res('assets/img/email.png'); ?>">
    <form class="newsletter_subscribe_form" action="<?= url('newsletter/subscribe'); ?>">
        <input required="" name="email" type="text" placeholder="<?= varlang('email-dvs'); ?>">
        <input type="submit" value="<?= varlang('submit-1'); ?>">
    </form>
</div>


