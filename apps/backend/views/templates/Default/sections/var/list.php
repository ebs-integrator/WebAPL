<h3>
    <a href='<?= url("var/index"); ?>'>Vars</a> 
    <?php foreach (array_reverse($var_parents) as $parent) { ?>
        / <a href='<?= url("var/index/{$parent->key}"); ?>'><?= Str::words(strip_tags($parent->value), 12); ?></a>
    <?php } ?>
    / 
    <?php if (isset($var) && $var->key) { ?>
        <a href='<?= url("var/index/{$var->key}"); ?>'><?= Str::words(strip_tags($var->value), 12); ?></a>
    <?php } ?>
</h3>

<br>

<table class='table table-bordered'>
    <tr>
        <th>Key</th>
        <th>Name</th>
        <th>Action</th>
    </tr>
    <?php if (count($var_list)) { ?>
        <?php foreach ($var_list as $item) { ?>
            <tr>
                <td><?= $item->key; ?></td>
                <td>
                    <form action="<?=url('var/edit');?>" method="post" class="ajax-auto-submit">
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
        <center>No vars</center>
        </td>
        </tr>
    <?php } ?>
</table>



<h4>Create new var</h4>

<form method="post" action='<?= url("var/create"); ?>'>
    <input type="hidden" name='parent_key' value='<?= $var_key; ?>' />
    <input type='text' name='key' value='' placeholder='Key' class='form-control' />
    <div class='c10'></div>
    <?php foreach (\Core\APL\Language::getList() as $lang) { ?>
        <input type='text' name='text[<?= $lang->id; ?>]' value='' placeholder='Text in <?= $lang->name; ?>' class='form-control' />
        <div class='c10'></div>
    <?php } ?>
    <input type='submit' class='btn btn-success' value='Create' />
</form>