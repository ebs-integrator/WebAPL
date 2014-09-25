<?php if (User::has('user-edit')) { ?>
    <form action="<?= url('user/save'); ?>" method="post" class="ajax-auto-submit">
        <h4>Edit details:</h4>

        <input type="hidden" name="id" value="<?= $user->id; ?>" />

        <table class="table table-bordered">
            <tr>
                <th>Username</th>
                <td>
                    <input class="form-control" type="text" value="<?= $user->username; ?>" name="username" placeholder="Username"/>
                </td>
            </tr>
            <tr>
                <th>Email</th>
                <td>
                    <input class="form-control" type="email" value="<?= $user->email; ?>" name="email" placeholder="Email"/>
                </td>
            </tr>
        </table>
    </form>
<?php } ?>

<?php if (User::has('user-chpwd')) { ?>
    <form action="<?= url('user/changepassword'); ?>" method="post" class="ajax-auto-submit">
        <h4>Change password:</h4>

        <input type="hidden" name="id" value="<?= $user->id; ?>" />

        <table class="table table-bordered">
            <tr>
                <th>New password</th>
                <td>
                    <input class="form-control" type="password" name="password" placeholder="Password"/>
                </td>
            </tr>
        </table>
    </form>
<?php } ?>

<?php if (User::has('user-roles')) { ?>
    <form action="<?= url('user/saveroles'); ?>" method="post" class="ajax-auto-submit">

        <h4>This user can:</h4>

        <input type="hidden" name="id" value="<?= $user->id; ?>" />

        <select name="roles[]" class="chzn-select" multiple>
            <?php
            $uroles = User::extractRoles($user->id);
            ?>
            <?php foreach ($roles as $role) { ?>
                <option value="<?= $role->id; ?>" <?= User::has($role->key, $uroles) ? 'selected' : ''; ?>><?= $role->name; ?></option>
            <?php } ?>
        </select>

    </form>
<?php } ?>