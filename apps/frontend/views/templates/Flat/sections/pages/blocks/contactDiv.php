<div class="bsa_block">
    <p class="bsa_head"><?= varlang('raporteaza-abuz'); ?></p>
    <div class="bsa_content">
        <?php if (isset($tel)) { ?>
        <div class="bsa_tel">
            <span><?= varlang('telefon'); ?> </span>
            <p><?=$tel;?></p>
        </div>
        <?php } ?>
        <?php if (isset($fax)) { ?>
        <div class="bsa_fax">
            <span><?= varlang('fax'); ?></span>
            <p><?=$fax;?></p>
        </div>
        <?php } ?>
        <?php if (isset($email)) { ?>
        <div class="bsa_email">
            <span><?= varlang('email'); ?></span>
            <p><?=$email;?></p>
        </div>
        <?php } ?>
    </div>
</div>