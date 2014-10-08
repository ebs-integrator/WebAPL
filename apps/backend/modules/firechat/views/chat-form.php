<h3><?= varlang('chat-2'); ?></h3>

<form action='<?=url('firechat/audience');?>' method="post" class='ajax-auto-submit'>
    <input type='hidden' name='id' value='<?=isset($person->id) ? $person->id : '';?>' />
    <?= varlang('accesible'); ?> 
    <input type="checkbox" class="make-switch" name="for_audience" <?= isset($person->for_audience) && $person->for_audience ? 'checked' : ''; ?> />
</form>
<div>
    
</div>

<iframe src="<?=url('firechat/display');?>" style="border: 0;width: 100%;height: 600px;"></iframe>