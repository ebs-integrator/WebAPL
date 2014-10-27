<h3>Șablon</h3>

<p>Selectați șablonul site-ului</p>

<form action="<?= url('install/checktpl'); ?>" method="post">

    <?php if (Session::get('tplerror')) { ?>
        <div class="alert alert-danger" role="alert"><?= Session::get('tplerror'); ?></div>
    <?php } ?>

    <label class="col-lg-6">
        <center>
            <input class="form-control" type="radio" name="tpl" value="Default" checked />
            <img src="<?= url('install/res/tpl_default.jpg'); ?>" class="col-lg-12"/><br>
            Default
        </center>
    </label>
    <label class="col-lg-6">
        <center>
            <input class="form-control" type="radio" name="tpl" value="Flat" />
            <img src="<?= url('install/res/tpl_flat.jpg'); ?>" class="col-lg-12"/><br>
            Flat
        </center>
    </label>

    <hr/>

    <button class="btn btn-info btn-lg">Următorul pas</button>
</form>