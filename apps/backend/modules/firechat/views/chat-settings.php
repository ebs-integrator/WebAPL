<h2><?= varlang('firechat-settings'); ?></h2>

<form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

    <table class="table table-bordered table-hover">

        <tr>
            <th><?= varlang('firechat-host'); ?></th>
            <td>
                <input type='text' name='set[firechat_host]' class='form-control' value='<?= isset($setts['firechat_host']) ? $setts['firechat_host'] : ''; ?>'/>
            </td>
        </tr>
        <tr>
            <th><?= varlang('firebase-secrets-key'); ?></th>
            <td>
                <input type='text' name='set[firechat_key]' class='form-control' value='<?= isset($setts['firechat_key']) ? $setts['firechat_key'] : ''; ?>'/>
            </td>
        </tr>

    </table>

</form>
