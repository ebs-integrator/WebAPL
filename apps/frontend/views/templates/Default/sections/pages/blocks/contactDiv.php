<div class="bsa_block">
    <p class="bsa_head">Raportează un abuz social</p>
    <div class="bsa_content">
        <?php if (isset($tel)) { ?>
        <div class="bsa_tel">
            <span>Telefon </span>
            <p><?=$tel;?></p>
        </div>
        <?php } ?>
        <?php if (isset($fax)) { ?>
        <div class="bsa_fax">
            <span>Fax</span>
            <p><?=$fax;?></p>
        </div>
        <?php } ?>
        <?php if (isset($email)) { ?>
        <div class="bsa_email">
            <span>Email</span>
            <p><?=$email;?></p>
        </div>
        <?php } ?>
    </div>
</div>