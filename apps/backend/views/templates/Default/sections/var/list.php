<h3>
    <a href='<?= url("var/index"); ?>'><?= varlang('vars'); ?></a> 
    <?php foreach (array_reverse($var_parents) as $parent) { ?>
        / <a href='<?= url("var/index/{$parent->key}"); ?>'><?= Str::words(strip_tags($parent->value), 12); ?></a>
    <?php } ?>
    / 
    <?php if (isset($var) && $var->key) { ?>
        <a href='<?= url("var/index/{$var->key}"); ?>'><?= Str::words(strip_tags($var->value), 12); ?></a>
    <?php } ?>
</h3>

<form action="<?= url('var/search'); ?>" method="post">
    <input type="search" name="varname" placeholder="" class="form-control" />
</form>


<?php
$errorSearch = Session::get('searchfail');
$searchList = Session::get('searchresult');

if ($errorSearch === 0 && $searchList) {
    foreach ($searchList as $item) {
        ?>
        <a href="<?= url("var/index/" . $item['var_key']); ?>"><?= $item['value']; ?></a><br>
        <?php
    }
}
?>


<br>

<table class='table table-bordered'>
    <tr>
        <th><?= varlang('key'); ?></th>
        <th><?= varlang('name-9'); ?></th>
        <th><?= varlang('action-2'); ?></th>
    </tr>
    <?php if (count($var_list)) { ?>
        <?php foreach ($var_list as $item) { ?>
            <tr>
                <td><input type='text' class='form-control' onClick="this.select();" value="&lt;?= varlang('<?= $item->key; ?>'); ?&gt;" /></td>
                <td>
                    <form action="<?= url('var/edit'); ?>" method="post" class="ajax-auto-submit">
                        <input type="hidden" name="id" value="<?= $item->id; ?>" />
                        <textarea rows="1" style="border: 0;" name="value"><?= $item->value; ?></textarea>
                    </form>
                </td>
                <td>
                    <a href='<?= url("var/index/{$item->key}"); ?>'>View sub</a>
                    <?= $item->num_vars; ?>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="3">
        <center><?= varlang('no-vars'); ?></center>
    </td>
    </tr>
<?php } ?>
</table>



<h4>Create new var</h4>

<form method="post" action='<?= url("var/create"); ?>'>
    <input type="hidden" name='parent_key' value='<?= $var_key; ?>' />
    <input type='text' name='key' value='' autocomplete="off" placeholder='Key' class='form-control' />
    <div class='c10'></div>
    <?php foreach (\Core\APL\Language::getList() as $lang) { ?>
        <input type='text' autocomplete="off" name='text[<?= $lang->id; ?>]' value='' placeholder='Text in <?= $lang->name; ?>' class='form-control' />
        <div class='c10'></div>
    <?php } ?>
    <input type='submit' class='btn btn-success' value='Create' />
</form>