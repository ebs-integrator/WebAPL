<form class="ajax-auto-submit" action='<?= url('person/save_lang'); ?>' method='post'>
    <input type='hidden' name='person_id' value='<?= isset($person->id) ? $person->id : 0; ?>' />
    <input type='hidden' name='person_lang_id' value='<?= isset($person_lang->id) ? $person_lang->id : 0; ?>' />
    <input type='hidden' name='lang_id' value='<?= isset($lang->id) ? $lang->id : 0; ?>' />
    
    <table class="table table-bordered table-hover">
        <tr>
            <th><?= varlang('first-name-'); ?></th>
            <td>
                <input type="text" name="first_name" class='form-control' value='<?= isset($person_lang->first_name) ? $person_lang->first_name : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('last-name-'); ?></th>
            <td>
                <input type="text" name="last_name" class='form-control' value='<?= isset($person_lang->last_name) ? $person_lang->last_name : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('function-'); ?></th>
            <td>
                <input type="text" name="function" class='form-control' value='<?= isset($person_lang->function) ? $person_lang->function : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('civil-state-'); ?></th>
            <td>
                <input type="text" name="civil_state" class='form-control' value='<?= isset($person_lang->civil_state) ? $person_lang->civil_state : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('studies-'); ?></th>
            <td>
                <input type="text" name="studies" class='form-control' value='<?= isset($person_lang->studies) ? $person_lang->studies : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('activity-'); ?></th>
            <td>
                <input type="text" name="activity" class='form-control' value='<?= isset($person_lang->activity) ? $person_lang->activity : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('motto-'); ?></th>
            <td>
                <input type="text" name="motto" class='form-control' value='<?= isset($person_lang->motto) ? $person_lang->motto : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('text--1'); ?></th>
            <td>
                <textarea class="ckeditor-run" name="text[<?= isset($person_lang->id) ? $person_lang->id : 0; ?>]"><?= isset($person_lang->text) ? $person_lang->text : ''; ?></textarea>
            </td>
        </tr>
    </table>
</form>