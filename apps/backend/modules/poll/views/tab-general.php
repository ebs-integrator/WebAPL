<form class="ajax-auto-submit" action='<?= url('poll/save'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($poll->id) ? $poll->id : 0; ?>' />

    <table class="table table-bordered">
        <?php if (isset($poll->date_created)) { ?>
        <tr>
            <th>Date created: </th>
            <td>
                <input type="text" name="date_created" class='form-control' value='<?= isset($poll->date_created) ? $poll->date_created : ''; ?>' />
            </td>
        </tr>
        <?php } ?>
        <tr>
            <th>Enabled: </th>
            <td>
                <input type="checkbox" name="enabled" class='make-switch' <?= isset($poll->enabled) && $poll->enabled ? 'checked' : ''; ?> />
            </td>
        </tr>
        <?php if (isset($poll->id)) { ?>
            <tr>
                <th>Delete: </th>
                <td>
                    <a href="<?= url('poll/del/'.$poll->id) ?>" id="delete-menu" class="btn btn-danger pull-right">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</form>