<h3>Contul de administrator</h3>

<p>Introduceți datele administratorului care va fi creat</p>

<form action="<?= url('install/checkadmin'); ?>" method="post">

    <?php if (Session::get('uerror')) { ?>
        <div class="alert alert-danger" role="alert"><?= Session::get('uerror'); ?></div>
    <?php } ?>

    <table class="table table-bordered table-hover">
        <tr>
            <th>Nume</th>
            <td>
                <input type="text" required="" name="username" class="form-control" />
            </td>
        </tr>
        <tr>
            <th>Email</th>
            <td>
                <input type="email" required="" name="email" class="form-control" />
            </td>
        </tr>
        <tr>
            <th>Parolă</th>
            <td>
                <input type="password" required="" name="password" class="form-control" />
            </td>
        </tr>
        <tr>
            <th>Confirmare parolă</th>
            <td>
                <input type="password" required="" name="password2" class="form-control" />
            </td>
        </tr>
    </table>

    <hr/>

    <button class="btn btn-info btn-lg">Următorul pas</button>
</form>