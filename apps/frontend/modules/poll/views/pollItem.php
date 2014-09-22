<?php if ($poll) { ?>
    <form class="poll_form" action="#" method="post">
        <p class="snd_title"><?= $poll->title; ?></p>

        <input type="hidden" name="id" value="<?= $poll->id; ?>" />

        <div class="form_error"></div>

        <div class='r_sond'>
            <?php foreach ($poll->answers as $k => $answer) { ?>
                <div><input type='radio' name='poll_answer' value="<?= $answer->id; ?>" id='answer_<?= $answer->id; ?>' <?=$k==0?'checked':''?>/><label for='answer_<?= $answer->id; ?>'><?= $answer->title; ?></label></div>
            <?php } ?>
        </div>
        <hr class="reg">
        <p class="int_code">Introduceti codul, previne voturile automate</p>

        <div class="snd_code">
            <input type="text" name="capcha">
            <div class="img_code">
                <img height="31" src="<?= SimpleCapcha::make('poll'); ?>">
            </div>
        </div>
        <div class="clearfix"></div>

        <input type="submit" value="trimite" class="snd_sbm">
    </form>
    
    <?=View::make('sections.elements.socials');?>


    <script>
        jQuery(document).ready(function($) {

            $(".poll_form").submit(function(e) {
                e.preventDefault();

                var form = $(this);

                $.post('<?= url('poll/register'); ?>', $(this).serialize(), function(data) {
                    if (data.error == 0) {
                        form.fadeOut(400, function() {
                            form.html(data.html);
                            form.show(200);
                        });
                    } else {
                        form.find(".form_error").html(data.message);
                    }
                });

                return false;
            });

        });
    </script>


<?php } ?>