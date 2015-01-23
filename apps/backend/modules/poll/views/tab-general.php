<form class="ajax-auto-submit" action='<?= url('poll/save'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($poll->id) ? $poll->id : 0; ?>' />

    <table class="table table-bordered table-hover">
        <?php if (isset($poll->date_created)) { ?>
        <tr>
            <th><?= varlang('date-created'); ?></th>
            <td>
                <input type="text" name="date_created" class='form-control' value='<?= isset($poll->date_created) ? $poll->date_created : ''; ?>' />
            </td>
        </tr>
        <?php } ?>
        <tr>
            <th><?= varlang('active-1'); ?></th>
            <td>
                <input type="checkbox" name="active" class='make-switch' <?= isset($poll->active) && $poll->active ? 'checked' : ''; ?> />
            </td>
        </tr>
        <tr>
            <th><?= varlang('enabled-7'); ?></th>
            <td>
                <input type="checkbox" name="enabled" class='make-switch' <?= isset($poll->enabled) && $poll->enabled ? 'checked' : ''; ?> />
            </td>
        </tr>
        <?php if (isset($poll->id)) { ?>
        <tr>
            <th></th>
            <td>
                <input type="text" class="form-control" value="[poll id=<?= $poll->id;?>]" />
            </td>
        </tr>
        <?php } ?>
        <?php if (isset($poll->id)) { ?>
            <tr>
                <th><?= varlang('delete--1'); ?></th>
                <td>
                    <a href="<?= url('poll/del/'.$poll->id) ?>" id="delete-menu" class="btn btn-danger pull-right"><?= varlang('delete--1'); ?></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</form>