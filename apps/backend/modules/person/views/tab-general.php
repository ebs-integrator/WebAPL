<form class="ajax-auto-submit" action='<?= url('person/save'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($person->id) ? $person->id : 0; ?>' />

    <table class="table table-bordered">
        <tr>
            <th>Phone: </th>
            <td>
                <input type="text" name="phone" class='form-control' value='<?= isset($person->phone) ? $person->phone : ''; ?>' placeholder="077 111 111" />
            </td>
        </tr>
        <tr>
            <th>Email: </th>
            <td>
                <input type="text" name="email" class='form-control' value='<?= isset($person->email) ? $person->email : ''; ?>' placeholder="name@gmail.com" />
            </td>
        </tr>
        <tr>
            <th>Birth date: </th>
            <td>
                <input type="text" name="date_birth" class='form-control' value='<?= isset($person->date_birth) ? $person->date_birth : date("Y-m-d"); ?>' />
            </td>
        </tr>
    </table>
</form>

<form class="ajax-auto-submit" action='<?= url('person/save_person_groups'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($person->id) ? $person->id : 0; ?>' />

    <table class="table table-bordered">
        <tr>
            <th>Groups: </th>
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

<table class="table table-bordered">
    <?php if (isset($person->id)) { ?>
        <tr>
            <th>Photo:</th>
            <td>
                <?= Files::widget('person', $person->id, 1); ?>
            </td>
        </tr>
    <?php } ?>
</table>
