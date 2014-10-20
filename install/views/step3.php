<h3>Baza de date</h3>

<p>Introduceti datele de conectare la baza de date</p>

<form action="<?= url('install/checkdb'); ?>" method="post">
    
    <?php if (Session::get('conerror')) { ?>
    <div class="alert alert-danger" role="alert"><?=Session::get('conerror');?></div>
    <?php } ?>
    
    <table class="table table-bordered">
        <tr>
            <td>Host</td>
            <td>
                <input type="text" required="" name="dbhost" value="<?= Session::get('dbhost'); ?>" class="form-control" />
            </td>
        </tr>
        <tr>
            <td>Nume</td>
            <td>
                <input type="text" required="" name="dbname" value="<?= Session::get('dbname'); ?>" class="form-control" />
            </td>
        </tr>
        <tr>
            <td>Username</td>
            <td>
                <input type="text" required="" name="dbuser" value="<?= Session::get('dbuser'); ?>" class="form-control" />
            </td>
        </tr>
        <tr>
            <td>Password</td>
            <td>
                <input type="text" name="dbpass" value="<?= Session::get('dbpass'); ?>" class="form-control" />
            </td>
        </tr>
    </table>

    <button class="btn btn-info btn-lg">Urmatorul pas</button>
</form>