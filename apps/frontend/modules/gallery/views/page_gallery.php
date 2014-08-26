<?php if ($list) { ?>
<div class="gal">
    <ul class='gallery bxslider g_slide'>
        <?php foreach ($list as $item) { ?>
        <li><img src="<?= url($item->path); ?>"></li>                    
        <?php } ?>
    </ul>
    <p class="counter"><span class='current'></span>/<span class='total'></span></p>
</div> 
<?php } ?>