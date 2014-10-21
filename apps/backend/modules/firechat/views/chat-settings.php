<h2><?= varlang('firechat-settings'); ?></h2>

<form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

    <table class="table table-bordered">

        <tr>
            <th><?= varlang('firechat-host'); ?></th>
            <td>
                <input type='text' name='set[firechat_host]' class='form-control' value='<?= isset($setts['firechat_host']) ? $setts['firechat_host'] : ''; ?>'/>
            </td>
        </tr>

    </table>

</form>
