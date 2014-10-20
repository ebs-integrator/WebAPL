<h3>Admin account</h3>

<p>Introduceti datele administratorului</p>

<form action="<?= url('install/checkadmin'); ?>" method="post">

    <?php if (Session::get('uerror')) { ?>
        <div class="alert alert-danger" role="alert"><?= Session::get('uerror'); ?></div>
    <?php } ?>

    <table class="table table-bordered">
        <tr>
            <th>Username</th>
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
            <th>Password</th>
            <td>
                <input type="password" required="" name="password" class="form-control" />
            </td>
        </tr>
        <tr>
            <th>Confirm password</th>
            <td>
                <input type="password" required="" name="password2" class="form-control" />
            </td>
        </tr>
    </table>

    <hr/>

    <button class="btn btn-info btn-lg">Urmatorul pas</button>
</form>