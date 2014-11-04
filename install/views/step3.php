<h3>Pregătire bază de date</h3>

<p>Introduceți datele de conectare la baza de date</p>
<p>Datele le puteți obține din panelul de administrare a hosting-ului sau de la furnizorul de hosting</p>

<form action="<?= url('install/checkdb'); ?>" method="post">
    
    <?php if (Session::get('conerror')) { ?>
    <div class="alert alert-danger" role="alert"><?=Session::get('conerror');?></div>
    <?php } ?>
    
    <table class="table table-bordered table-hover">
        <tr>
            <td>Hostul de conectare</td>
            <td>
                <input type="text" required="" name="dbhost" value="<?= Session::get('dbhost') ? Session::get('dbhost') : 'localhost'; ?>" class="form-control" />
            </td>
        </tr>
        <tr>
            <td>Numele bazei de date</td>
            <td>
                <input type="text" required="" name="dbname" value="<?= Session::get('dbname'); ?>" class="form-control" />
            </td>
        </tr>
        <tr>
            <td>Numele de utilizator</td>
            <td>
                <input type="text" required="" name="dbuser" value="<?= Session::get('dbuser'); ?>" class="form-control" />
            </td>
        </tr>
        <tr>
            <td>Parolă</td>
            <td>
                <input type="text" name="dbpass" value="<?= Session::get('dbpass'); ?>" class="form-control" />
            </td>
        </tr>
    </table>

    <button class="btn btn-info btn-lg">Următorul pas</button>
</form>