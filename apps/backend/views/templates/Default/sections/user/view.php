<table class="table table-bordered">
    <tr>
        <th></th>
        <td>

        </td>
    </tr>
</table>


<form action="<?=url('user/saveroles');?>" method="post" class="ajax-auto-submit">

    <h4>User access</h4>

    <input type="hidden" name="id" value="<?=$user->id;?>" />
    
    <select name="roles[]" class="chzn-select" multiple>
        <?php
        $uroles = User::extractRoles($user->id);
        ?>
        <?php foreach ($roles as $role) { ?>
            <option value="<?= $role->id; ?>" <?= User::has($role->key, $uroles) ? 'selected' : ''; ?>><?= $role->name; ?></option>
        <?php } ?>
    </select>

</form>