<div class="left email">
    <script>
        jQuery(document).ready(function($) {

            $(".newsletter_subscribe_form").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                $.post('<?= url('newsletter/subscribe'); ?>', $(this).serialize(), function(data) {
                    if (data.error == 0) {
                        $(".email").fadeOut(400, function() {
                            $(this).remove();
                        });
                    } else {
                        alert(data.message);
                    }
                });
                return false;
            });

        });
    </script>

    <p>Aboneazate la Buletinul informativ al primăriei</p>
    <img src="<?= res('assets/img/email.png'); ?>">
    <form class="newsletter_subscribe_form" action="<?= url('newsletter/subscribe'); ?>">
        <input name="email" type="text" placeholder="Email-ul Dvs.">
        <input type="submit">
    </form>
</div>


