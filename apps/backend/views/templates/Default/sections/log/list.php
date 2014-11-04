<h3><?= varlang('log-1'); ?></h3>

<table class="table table-bordered table-hover">

    <tr>
        <th><?= varlang('date-4'); ?></th>
        <th><?= varlang('message-1'); ?></th>
        <th><?= varlang('user-2'); ?></th>
        <th><?= varlang('ip'); ?></th>
    </tr>

    <?php foreach ($list as $log) { ?>
        <tr class="log-item log-<?= $log->level; ?>">
            <td><?= $log->event_date; ?></td>
            <td><?= Str::limit($log->message, 100); ?></td>
            <td>
                <?php if ($log->user_id) { ?>
                    <b><?= $log->username; ?></b>
                <?php } else { ?>
                    <i><?= varlang('anonim'); ?></i>
                <?php } ?>
                <div class="log-body" style="display: none;">
                    <pre><?= $log->url; ?></pre>
                    <pre><?= $log->message; ?></pre>
                </div>
            </td>
            <td><?= $log->ip; ?></td>
        </tr>
    <?php } ?>

</table>



<!-- Modal -->
<div class="modal fade" id="errorDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?= varlang('close-1'); ?></span></button>
                <h4 class="modal-title" id="myModalLabel"><?= varlang('log-item-details'); ?></h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= varlang('close-1'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        $('body').on('click', '.log-item', function() {
            $("#errorDetails .modal-body").html($(this).find(".log-body").html());
            $("#errorDetails").modal('show');
        });
    });
</script>