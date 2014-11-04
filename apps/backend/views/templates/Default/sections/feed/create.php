<form action="<?= url('feed/takecreate'); ?>" method="post">

    <h2><?= varlang('create-new-feed'); ?></h2>

    <?= View::make('sections.feed.block-form'); ?>

    <h3><?= varlang('set-aditional-fields'); ?></h3>


    <select id="feedFilds" class="form-control">
        <option value="">---</option>
        <?php foreach ($fields_groups as $group) { ?>
            <option value="<?= $group->key; ?>"><?= $group->name; ?></option>
        <?php } ?>
    </select>

    <br>
    
    <?php foreach ($fields as $field) { ?>
        <label class="col-lg-3"><input class="feedField" type="checkbox" data-groups="<?= $field->gkeys; ?>" name="fields[]" value="<?= $field->id; ?>" /> <?= $field->title; ?></label>
    <?php } ?>

    <input type="submit" class="btn btn-success pull-right" value="<?= varlang('create-group');?>"/>

    <div class="clearfix"></div>
</form>