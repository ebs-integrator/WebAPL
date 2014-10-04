<h3>Template</h3>

<p>bla bla bla bla bla bla bla blabla bla bla blabla bla bla blabla bla bla bla</p>

<form action="<?= url('install/checktpl'); ?>" method="post">

    <?php if (Session::get('tplerror')) { ?>
        <div class="alert alert-danger" role="alert"><?= Session::get('tplerror'); ?></div>
    <?php } ?>

    <label>
        <input type="radio" name="tpl" value="Default" checked /> Default
    </label>

        <hr/>
        
    <button class="btn btn-info btn-lg">Urmatorul pas</button>
</form>