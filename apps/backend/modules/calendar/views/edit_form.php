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

            <table class="table table-bordered">
                <tr>
                    <th><?= varlang('period-'); ?></th>
                    <td>
                        <input type="text" name="period" class='form-control' value='<?= isset($calendar->period) ? $calendar->period : ''; ?>' placeholder="Period" />
                    </td>
                </tr>
                <tr>
                    <th><?= varlang('event-date-'); ?></th>
                    <td>
                        <input type="text" name="event_date" class='form-control datetimepicker' data-date-format="YYYY-MM-DD hh:mm:ss" value='<?= isset($calendar->event_date) ? $calendar->event_date : date("Y-m-d H:i:s"); ?>' />
                    </td>
                </tr>
                <tr>
                    <th><?= varlang('group-'); ?></th>
                    <td>
                        <select class="chzn-select" name="group_id">
                            <option value="0">---</option>
                            <?php foreach ($groups as $group) { ?>
                                <option value="<?=$group->id;?>" <?= isset($calendar->calendar_group_id) && $calendar->calendar_group_id == $group->id ? 'selected' : '';?>><?=$group->name;?></option>
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
            </table>
        </form>
    </div>
    <?php foreach (Language::getList() as $lang) { ?>
        <div class="tab-pane" id="lang<?= $lang->id; ?>">
            <?php if (isset($langs[$lang->id]) && $langs[$lang->id]) { ?>
                <form class="ajax-auto-submit" action='<?= url('calendar/save_lang'); ?>' method='post'>
                    <input type='hidden' name='id' value='<?= isset($langs[$lang->id]['id']) ? $langs[$lang->id]['id'] : 0; ?>' />

                    <table class="table table-bordered">
                        <tr>
                            <th><?= varlang('title--5'); ?></th>
                            <td>
                                <input type="text" name="lang[<?= $langs[$lang->id]['id']; ?>][title]" class='form-control' value='<?= isset($langs[$lang->id]['title']) ? $langs[$lang->id]['title'] : ''; ?>' />
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
