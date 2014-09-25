<div class="form green">
    <form class="firechat-register" action="" method="">
        <div class="contenta">
            <?php if (isset($person_selected) && $person_selected) { ?>
                <input type="hidden" name="person_id" value="<?= $person_selected; ?>" />
            <?php } else { ?>
                <label>Functionar *</label>
                <select name="person_id">
                    <?php foreach ($persons as $person) { ?>
                        <option value="<?= $person->id; ?>"><?= $person->first_name; ?> <?= $person->last_name; ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
            <label>Numele Prenumele * </label>
            <input name="name" type="text" >
            <label>Email*</label>
            <input name="email" type="text" >    
            <input type="submit" value="trimite">
            <div class="clearfix"></div>
        </div>
    </form>
</div>