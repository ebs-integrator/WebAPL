<h3><a href="<?= url('calendar/list'); ?>">Events</a> / Edit event</h3>

<ul class="nav nav-tabs" role="tablist" id="form-tabs">
    <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
    <?php foreach (Language::getList() as $lang) { ?>
        <li><a href="#lang<?= $lang->id; ?>" role="tab" data-toggle="tab">Language <?= $lang->name; ?></a></li>
    <?php } ?>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="general">
        <form class="ajax-auto-submit" action='<?= url('calendar/save'); ?>' method='post'>
            <input type='hidden' name='id' value='<?= isset($calendar->id) ? $calendar->id : 0; ?>' />

            <table class="table table-bordered">
                <tr>
                    <th>Period: </th>
                    <td>
                        <input type="text" name="period" class='form-control' value='<?= isset($calendar->period) ? $calendar->period : ''; ?>' placeholder="Period" />
                    </td>
                </tr>
                <tr>
                    <th>Event date: </th>
                    <td>
                        <input type="text" name="event_date" class='form-control' value='<?= isset($calendar->event_date) ? $calendar->event_date : date("Y-m-d H:i:s"); ?>' />
                    </td>
                </tr>
                <tr>
                    <th>Enabled: </th>
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
                            <th>Title: </th>
                            <td>
                                <input type="text" name="lang[<?= $langs[$lang->id]['id']; ?>][title]" class='form-control' value='<?= isset($langs[$lang->id]['title']) ? $langs[$lang->id]['title'] : ''; ?>' />
                            </td>
                        </tr>
                    </table>
                </form>
            <?php } else { ?>
                Event lang not found
            <?php } ?>
        </div>
    <?php } ?>
</div>
