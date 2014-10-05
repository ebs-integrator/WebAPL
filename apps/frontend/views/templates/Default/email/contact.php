<h2>Un nou mesaj</h2>
<br>

<?php if (isset($name)) { ?>
    <b>Nume:</b> <?= $name; ?><br>
<?php } ?>
<?php if (isset($address)) { ?>
    <b>Adresa:</b> <?= $address; ?><br>
<?php } ?>
<?php if (isset($email)) { ?>
    <b>Email:</b> <?= $email; ?><br>
<?php } ?>
<?php if (isset($subject)) { ?>
    <b>Subiect:</b> <?= $subject; ?><br>
<?php } ?>
<?php if (isset($messages)) { ?>
    <b>Mesaj:</b> <?= $messages; ?><br>
<?php } ?>