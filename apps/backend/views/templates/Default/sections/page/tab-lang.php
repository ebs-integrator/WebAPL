<form class="ajax-auto-submit" action='<?= url('page/save'); ?>' method='post'>
    <input type='hidden' name='id' value='<?= isset($page['id']) ? $page['id'] : 0; ?>' />

    <table class="table table-bordered table-hover">
        <tr>
            <th><?= varlang('frontend-link-'); ?></th>
            <td>
                <?php
                $link = "/" . (Language::getItem($plang->lang_id)->ext) . "/topost/" . (isset($page['id']) ? $page['id'] : 0) . '?is_admin=1';
                ?>
                <a href="<?=$link;?>" target="_blank"><?=$link;?></a>
            </td>
        </tr>
        <tr>
            <th><?= varlang('title--3'); ?></th>
            <td>
                <input type="text" name="lang[<?= $plang->id; ?>][title]" class='form-control' value='<?= isset($plang->title) ? $plang->title : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('enabled--1'); ?></th>
            <td>
                <input type="checkbox" name="lang[<?= $plang->id; ?>][enabled]" class='make-switch' <?= isset($plang->enabled) && $plang->enabled ? 'checked' : ''; ?> />
            </td>
        </tr>
        <tr>
            <th><?= varlang('uri-'); ?></th>
            <td>
                <input type="text" name="lang[<?= $plang->id; ?>][uri]" class='form-control' value='<?= isset($plang->uri) ? $plang->uri : ''; ?>' />
            </td>
        </tr>
        <tr>
            <th><?= varlang('text-'); ?></th>
            <td>
                <textarea name="lang[<?= $plang->id; ?>][text]" class='ckeditor-run'><?= isset($plang->text) ? $plang->text : ''; ?></textarea>
            </td>
        </tr>
    </table>
</form>