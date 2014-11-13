<h3><a href="<?= url('calendar/list'); ?>"><?= varlang('calendar-1'); ?></a> / <?= varlang('edit-event'); ?></h3>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#general" role="tab" data-toggle="tab"><?= varlang('general-3'); ?></a></li>
    <?php foreach (Language::getList() as $lang) { ?>
        <li><a href="#lang<?= $lang->id; ?>" role="tab" data-toggle="tab"><?= varlang('varianta-in-1'); ?> <?= $lang->name; ?></a></li>
    <?php } ?>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="general">
        <form class="ajax-auto-submit" action='<?= url('calendar/save'); ?>' method='post'>
            <input type='hidden' name='id' value='<?= isset($calendar->id) ? $calendar->id : 0; ?>' />

            <table class="table table-bordered table-hover">
                <tr>
                    <th><?= varlang('period-'); ?></th>
                    <td>
                        <input type="text" name="period" class='form-control' value='<?= isset($calendar->period) ? $calendar->period : ''; ?>' placeholder="Period" />
                    </td>
                </tr>
                <tr>
                    <th><?= varlang('event-date-'); ?></th>
                    <td>
                        <input type="text" name="event_date" class='form-control datetimepicker' data-date-format="YYYY-MM-DD HH:mm" value='<?= isset($calendar->event_date) ? date("Y-m-d H:i", strtotime($calendar->event_date)) : date("Y-m-d H:i"); ?>' />
                    </td>
                </tr>
                <tr>
                    <th><?= varlang('group-'); ?></th>
                    <td>
                        <select class="chzn-select" name="group_id">
                            <option value="0">---</option>
                            <?php foreach ($groups as $group) { ?>
                                <option value="<?= $group->id; ?>" <?= isset($calendar->calendar_group_id) && $calendar->calendar_group_id == $group->id ? 'selected' : ''; ?>><?= $group->name; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><?= varlang('enabled--3'); ?></th>
                    <td>
                        <input type="checkbox" name="enabled" class='make-switch' <?= isset($calendar->enabled) && $calendar->enabled ? 'checked' : ''; ?> />
                    </td>
                </tr>

                <tr>
                    <th><?= varlang('repetare'); ?></th>
                    <td>
                        <select name="repeat_frequency" class="form-control">
                            <option value="none"><?= varlang('fara-repetare'); ?></option>
                            <option value="zilnic" <?= isset($calendar->repeat_frequency) && $calendar->repeat_frequency == 'zilnic' ? 'selected' : ''; ?>>Zilnic</option>
                            <option value="saptaminal" <?= isset($calendar->repeat_frequency) && $calendar->repeat_frequency == 'saptaminal' ? 'selected' : ''; ?>>Saptaminal</option>
                            <option value="lunar" <?= isset($calendar->repeat_frequency) && $calendar->repeat_frequency == 'lunar' ? 'selected' : ''; ?>>Lunar</option>
                            <option value="anual" <?= isset($calendar->repeat_frequency) && $calendar->repeat_frequency == 'anual' ? 'selected' : ''; ?>>Anual</option>
                        </select>
                        <br>
                        <input type="text" name="repeat_to_date" class='form-control datetimepicker' data-date-format="YYYY-MM-DD HH:mm" value='<?= isset($calendar->repeat_to_date) && strtotime($calendar->repeat_to_date) ? $calendar->repeat_to_date : date("Y-m-d H:i:s"); ?>' />
                    </td>
                </tr>

                <?php if (isset($persons) && $persons) { ?>
                    <tr>
                        <th><?= varlang('eveniment-atasat-la-persoana'); ?></th>
                        <td>
                            <select name="person_id" class="form-control">
                                <option value="0">---</option>
                                <?php foreach ($persons as $person) { ?>
                                    <option value="<?= $person->person_id; ?>" <?= isset($calendar->person_id) && $calendar->person_id == $person->person_id ? 'selected' : ''; ?>><?= $person->first_name; ?> <?= $person->last_name; ?></option>
                                <?php } ?>
                            </select>
                            <br>
                            
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </form>
    </div>
    <?php foreach (Language::getList() as $lang) { ?>
        <div class="tab-pane" id="lang<?= $lang->id; ?>">
            <?php if (isset($langs[$lang->id]) && $langs[$lang->id]) { ?>
                <form class="ajax-auto-submit" action='<?= url('calendar/save_lang'); ?>' method='post'>
                    <input type='hidden' name='id' value='<?= isset($langs[$lang->id]['id']) ? $langs[$lang->id]['id'] : 0; ?>' />

                    <table class="table table-bordered table-hover">
                        <tr>
                            <th><?= varlang('title--5'); ?></th>
                            <td>
                                <input type="text" name="lang[<?= $langs[$lang->id]['id']; ?>][title]" class='form-control' value='<?= isset($langs[$lang->id]['title']) ? $langs[$lang->id]['title'] : ''; ?>' />
                            </td>
                        </tr>
                        <tr>
                            <th><?= varlang('locatie'); ?></th>
                            <td>
                                <input type="text" name="lang[<?= $langs[$lang->id]['id']; ?>][location]" class='form-control' value='<?= isset($langs[$lang->id]['location']) ? $langs[$lang->id]['location'] : ''; ?>' />
                            </td>
                        </tr>
                    </table>
                </form>
            <?php } else { ?>
                <?= varlang('event-lang-not-found'); ?>
            <?php } ?>
        </div>
    <?php } ?>
</div>
