<h3><?= $act->title; ?></h3>

<form action="<?= url('actelocale/save'); ?>" method="post" class="ajax-auto-submit">

    <input type="hidden" name="id" value="<?= $act->id; ?>" />
    
    <table class="table table-bordered table-hover">
        <tr>
            <th><?= varlang('nr-5'); ?></th>
            <td>
                <input type="text" value="<?= $act->doc_nr; ?>" name="doc_nr" class="form-control"/> 
            </td>
        </tr>
        <tr>
            <th><?= varlang('title-5'); ?></th>
            <td>
                <input type="text" value="<?= $act->title; ?>" name="title" class="form-control"/> 
            </td>
        </tr>
        <tr>
            <th><?= varlang('date-6'); ?></th>
            <td>
                <div class="input-group date datetimepicker">        
                    <input type="text" class="form-control" value="<?= $act->date_upload; ?>" name="date_upload" data-date-format="YYYY-MM-DD HH:mm:ss" />		
                    <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>    
                </div> 
            </td>
        </tr>
        <tr>
            <th><?= varlang('type-1'); ?></th>
            <td>
                <?=Form::select('type', array('Dispoziție' => 'Dispoziție', 'Decizie' => 'Decizie'), $act->type, array('class' => 'form-control'));?>
            </td>
        </tr>
        <tr>
            <th><?= varlang('emitent'); ?></th>
            <td>
                <?=Form::select('emitent', array('Primaria' => 'Primaria', 'Consiliu Local' => 'Consiliu Local'), $act->type, array('class' => 'form-control'));?>
            </td>
        </tr>
    </table>

</form>

<h4><?= varlang('document-1'); ?></h4>

<?=Files::widget(ActeLocaleModel::$filesModule, $act->id, 1, ActeLocaleModel::$filesDir);?>