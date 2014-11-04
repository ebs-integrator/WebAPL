<h3>Cerințe tehnice</h3>

<p>Pentru a continua procesul de instalare este necesar să verificați dacă dispuneți de toate cerințele tehnice.</p>

<table class="table table-bordered table-hover">
    <tr>
        <td>PHP 5.4+</td>
        <td>
            <?php if ($req['php_version']) { ?>
                <label class="label label-success">PHP <?= phpversion(); ?></label>
            <?php } else { ?>
                <label class="label label-danger">PHP <?= phpversion(); ?></label>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>MCrypt PHP Extension</td>
        <td>
            <?php if ($req['mcrypt']) { ?>
                <label class="label label-success">Accesibil</label>
            <?php } else { ?>
                <label class="label label-danger">Inaccesibil</label>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>PDO MySQL PHP Extension</td>
        <td>
            <?php if ($req['pdo']) { ?>
                <label class="label label-success">Accesibil</label>
            <?php } else { ?>
                <label class="label label-danger">Inaccesibil</label>
            <?php } ?>
        </td>
    </tr>
    <?php if (isset($req['rewrite'])) { ?>
        <tr>
            <td>Apache Rewrite Mod</td>
            <td>
                <?php if ($req['rewrite']) { ?>
                    <label class="label label-success">Accesibil</label>
                <?php } else { ?>
                    <label class="label label-danger">Inaccesibil</label>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>

<h3>Drepturi de scriere</h3>

<p>Ca procesul de instalare să decurgă fără erori trebuie ca următoarele dosare și fisierele din ele să dețină drepturi de scriere.</p>
<p>Oferirea drepturilor de scriere se face cu ajutorul unui client FTP (ex. Filezilla), drepturile recomandate sunt: 0777</p>

<table class="table table-bordered table-hover">
    <tr>
        <td>/apps/frontend/storage/</td>
        <td>
            <?php if ($req['wr_fr_storage']) { ?>
                <label class="label label-success">poate fi scris</label>
            <?php } else { ?>
                <label class="label label-danger">nu poate fi scris</label>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>/apps/backend/storage/</td>
        <td>
            <?php if ($req['wr_bk_storage']) { ?>
                <label class="label label-success">poate fi scris</label>
            <?php } else { ?>
                <label class="label label-danger">nu poate fi scris</label>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>/upload/</td>
        <td>
            <?php if ($req['wr_upload']) { ?>
                <label class="label label-success">poate fi scris</label>
            <?php } else { ?>
                <label class="label label-danger">nu poate fi scris</label>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>/install/</td>
        <td>
            <?php if ($req['wr_install']) { ?>
                <label class="label label-success">poate fi scris</label>
            <?php } else { ?>
                <label class="label label-danger">nu poate fi scris</label>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>/apps/frontend/config/</td>
        <td>
            <?php if ($req['wr_fr_db']) { ?>
                <label class="label label-success">poate fi scris</label>
            <?php } else { ?>
                <label class="label label-danger">nu poate fi scris</label>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td>/apps/backend/config/</td>
        <td>
            <?php if ($req['wr_bk_db']) { ?>
                <label class="label label-success">poate fi scris</label>
            <?php } else { ?>
                <label class="label label-danger">nu poate fi scris</label>
            <?php } ?>
        </td>
    </tr>

</table>

<?php if ($valid_step) { ?>
    <a href="<?= url('install/step3'); ?>" class="btn btn-info btn-lg">Următorul pas</a>
<?php } else { ?>
    <a href="#" class="btn btn-default btn-lg">Următorul pas</a>
<?php } ?>


<br><br>