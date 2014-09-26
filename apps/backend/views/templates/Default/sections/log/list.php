<h3>Log</h3>

<table class="table table-bordered">

    <tr>
        <th>Date</th>
        <th>Message</th>
        <th>User</th>
        <th>IP</th>
    </tr>

    <?php foreach ($list as $log) { ?>
        <tr class="log-<?=$log->level;?>">
            <td><?= $log->event_date; ?></td>
            <td><?= Str::limit($log->message, 100); ?></td>
            <td>
                <?php if ($log->user_id) { ?>
                    <b><?= $log->username; ?></b>
                <?php } else { ?>
                    <i>Anonim</i>
                <?php } ?>
            </td>
            <td><?= $log->ip; ?></td>
        </tr>
    <?php } ?>

</table>