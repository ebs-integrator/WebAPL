<div class="form green">
    <form class="firechat-register" action="" method="">
        <div class="contenta">
            <?php if (isset($person_selected) && $person_selected) { ?>
                <input type="hidden" name="person_id" value="<?= $person_selected; ?>" />
            <?php } else { ?>
                <label><?= varlang('functionar'); ?> *</label>
                <select name="person_id">
                    <?php foreach ($persons as $person) { ?>
                        <option value="<?= $person->id; ?>"><?= $person->first_name; ?> <?= $person->last_name; ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
            <label><?= varlang('name-last-name'); ?> * </label>
            <input name="name" type="text" >
            <label><?= varlang('email'); ?>*</label>
            <input name="email" type="text" >    
            <input type="submit" value="<?= varlang('submit'); ?>">
            <div class="clearfix"></div>
        </div>
    </form>
</div>