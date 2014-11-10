<div class="av green">
    <p><span><?= varlang('atentie'); ?> </span><?= varlang('info-atentie'); ?></p>
</div>
<div class="form green">
    <form class="person_subscribe_form" action="" method="post">
        <p class="ftb"><?= varlang('online-audienta'); ?></p>
        <div class="form_error"></div>
        <div class="content">
            <label><?= varlang('functionar'); ?> *</label>
            <select name="person_id">
                <?php foreach ($persons as $person) { ?>
                    <option value="<?= $person->id; ?>"><?= $person->first_name; ?> <?= $person->last_name; ?></option>
                <?php } ?>
            </select>
            <label><?= varlang('name-last-name'); ?> * </label>
            <input type="text" name="name" >
            <label><?= varlang('telefon'); ?> *</label>
            <input type="text" name="phone" >  
            <label><?= varlang('email'); ?> *</label>
            <input type="text" name="email" >  
            <label><?= varlang('cod-verificare'); ?> *</label>
            <input class="code" name="capcha" type="text">
            <img src="<?= SimpleCapcha::make('person_subscribe'); ?>" height="31">
            <input type="submit" value="<?= varlang('trimite'); ?>">
            <div class="clearfix"></div>
        </div>
    </form>
</div>

<script>
    jQuery(document).ready(function($) {

        $(".person_subscribe_form").submit(function(e) {
            e.preventDefault();

            var form = $(this);

            $.post('<?= url('person/subscribe_to_audience'); ?>', $(this).serialize(), function(data) {
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
