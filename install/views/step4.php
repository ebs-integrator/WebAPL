<h3>Template</h3>

<p>Selectati tema site-ului</p>

<form action="<?= url('install/checktpl'); ?>" method="post">

    <?php if (Session::get('tplerror')) { ?>
        <div class="alert alert-danger" role="alert"><?= Session::get('tplerror'); ?></div>
    <?php } ?>

    <label>
        <input type="radio" name="tpl" value="Default" checked /> Default
    </label>
    <label>
        <input type="radio" name="tpl" value="Flat" checked /> Flat
    </label>

    <hr/>

    <button class="btn btn-info btn-lg">Urmatorul pas</button>
</form>