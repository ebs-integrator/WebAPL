<ul class="sec_details left">
    <li>
        <span class="sec_criteria">Data:</span>
        <span class="crt_details"><?= date("d-m-Y", strtotime($post->created_at)); ?></span>
    </li>
    <li>

        <span class="sec_criteria">Ora:</span>
        <span class="crt_details"><?= $post->hours; ?></span>
    </li>
    <li>
        <span class="sec_criteria">Locația:</span>
        <span class="crt_details"><?= $post->location; ?></span>
    </li>                
</ul>
<div class="clearfix50"></div>
<?= $post->text; ?>
<div class="clearfix50"></div>