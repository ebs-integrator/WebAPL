<?php
$uroles = User::extractRoles($user->id);
?>

<?php if ((User::has('user-chpwd') && (!User::has('user-ptpsw', $uroles))) || $user->id == Auth::user()->id) { ?>

    <?php if (User::has('user-edit')) { ?>
        <form action="<?= url('user/save'); ?>" method="post" class="ajax-auto-submit">
            <h4><?= varlang('edit-details'); ?></h4>

            <input type="hidden" name="id" value="<?= $user->id; ?>" />

            <table class="table table-bordered table-hover">
                <tr>
                    <th><?= varlang('username-1'); ?></th>
                    <td>
                        <input class="form-control" type="text" value="<?= $user->username; ?>" name="username" placeholder="<?= varlang('username-1'); ?>"/>
                    </td>
                </tr>
                <tr>
                    <th><?= varlang('email-4'); ?></th>
                    <td>
                        <input class="form-control" type="email" value="<?= $user->email; ?>" name="email" placeholder="<?= varlang('email-4'); ?>"/>
                    </td>
                </tr>
            </table>
        </form>
    <?php } ?>

    <form action="<?= url('user/changepassword'); ?>" method="post" class="ajax-auto-submit">
        <h4><?= varlang('change-password'); ?></h4>

        <input type="hidden" name="id" value="<?= $user->id; ?>" />

        <table class="table table-bordered table-hover">
            <tr>
                <th><?= varlang('new-password'); ?></th>
                <td>
                    <input class="form-control" type="password" name="password" placeholder="<?= varlang('new-password'); ?>"/>
                </td>
            </tr>
        </table>
    </form>
<?php } ?>

<?php if (User::has('user-roles') && (!User::has('user-ptroles', $uroles) || $user->id == Auth::user()->id)) { ?>
    <form action="<?= url('user/saveroles'); ?>" method="post" class="ajax-auto-submit">

        <h4><?= varlang('this-user-can'); ?></h4>

        <input type="hidden" name="id" value="<?= $user->id; ?>" />

        <select name="roles[]" class="chzn-select" data-placeholder=" " multiple>
            <?php foreach ($roles as $role) { ?>
                <option value="<?= $role->id; ?>" <?= User::has($role->key, $uroles) ? 'selected' : ''; ?>><?= $role->name; ?></option>
            <?php } ?>
        </select>

    </form>
<?php } ?>

<?php if (User::has('user-delete')) { ?>
    <div class="c20"></div>
    <form action="<?= url('user/delete'); ?>" method="post">
        <input type="hidden" name="id" value="<?= $user->id; ?>" />

        <button type="submit" onclick="return confirm('<?= varlang('delete-user'); ?>');" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i></button>
    </form>
<?php } ?>

<div class="c20" style="height: 200px;"></div>