<form class="ajax-auto-submit" action='<?= url('person/save'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($person->id) ? $person->id : 0; ?>' />

    <table class="table table-bordered table-hover">
        <tr>
            <th><?= varlang('phone--1'); ?></th>
            <td>
                <input type="text" name="phone" class='form-control' value='<?= isset($person->phone) ? $person->phone : ''; ?>' placeholder="077 111 111" />
            </td>
        </tr>
        <tr>
            <th><?= varlang('email--5'); ?></th>
            <td>
                <input type="text" name="email" class='form-control' value='<?= isset($person->email) ? $person->email : ''; ?>' placeholder="name@gmail.com" />
            </td>
        </tr>
        <tr>
            <th><?= varlang('birth-date-'); ?></th>
            <td>
                <input type="text" name="date_birth" class='form-control datetimepicker' data-date-format="YYYY-MM-DD" value='<?= isset($person->date_birth) ? $person->date_birth : date("Y-m-d"); ?>' />
            </td>
        </tr>
<!--        <tr>
            <th><?= varlang('accesibil-pentru-audienta-'); ?></th>
            <td>
                <input type="checkbox" class="make-switch" name="for_audience" class='form-control' <?= isset($person->for_audience) && $person->for_audience ? 'checked' : ''; ?> />
            </td>
        </tr>-->
        <tr>
            <th><?= varlang('feed-'); ?></th>
            <td>
                <select name="feed_id" class="form-control">
                    <option value="0">---</option>
                    <?php foreach ($feeds as $feed) { ?>
                        <option value="<?= $feed->id; ?>" <?= isset($person['feed_id']) && $person['feed_id'] == $feed->id ? 'selected' : '' ?>><?= $feed->name; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><?= varlang('user--1'); ?></th>
            <td>
                <select name="user_id" class="form-control">
                    <option value="0">---</option>
                    <?php foreach (User::orderBy('username', 'asc')->get() as $user) { ?>
                        <option value="<?= $user->id; ?>" <?= isset($person['user_id']) && $person['user_id'] == $user->id ? 'selected' : '' ?>><?= $user->username; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
    </table>
</form>

<form class="ajax-auto-submit" action='<?= url('person/save_person_groups'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($person->id) ? $person->id : 0; ?>' />

    <table class="table table-bordered table-hover">
        <tr>
            <th><?= varlang('groups-'); ?></th>
            <td>
                <select id="attach_pgroup" name="groups[]" class="form-control chzn-select-deselect" multiple>
                    <option value="0">---</option>
                    <?php foreach ($person_groups as $pgroup) { ?>
                        <option value="<?= $pgroup['id']; ?>" <?= in_array($pgroup['id'], $selected_groups) ? 'selected' : '' ?>><?= $pgroup['name']; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
    </table>
</form>

<table class="table table-bordered table-hover">
    <?php if (isset($person->id)) { ?>
        <tr>
            <th><?= varlang('photo'); ?></th>
            <td>
                <?= Files::widget('person', $person->id, 1); ?>
            </td>
        </tr>
        <tr>
            <th><?= varlang('chat-icon'); ?></th>
            <td>
                <?= Files::widget('person_chat', $person->id, 1); ?>
            </td>
        </tr>
    <?php } ?>
</table>
