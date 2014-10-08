<form action="<?= url('feed/takecreate'); ?>" method="post">

    <h2><?= varlang('create-new-feed'); ?></h2>

    <?= View::make('sections.feed.block-form'); ?>

    <h3><?= varlang('set-aditional-fields'); ?></h3>

    <?php foreach ($fields as $field) { ?>
    <label><input type="checkbox" name="fields[]" value="<?= $field->id; ?>" /> <?= $field->title; ?></label><br>
    <?php } ?>

    <input type="submit" class="btn btn-success pull-right"/>

    <div class="clearfix"></div>
</form>