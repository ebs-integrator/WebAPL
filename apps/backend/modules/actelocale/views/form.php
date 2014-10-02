<h3>Edit #<?= $act->title; ?></h3>

<table class="table table-bordered">
    <tr>
        <th>Nr</th>
        <td>
            <input type="text" value="<?= $act->doc_nr; ?>" name="doc_nr" class="form-control"/> 
        </td>
    </tr>
    <tr>
        <th>Title</th>
        <td>
            <input type="text" value="<?= $act->title; ?>" name="title" class="form-control"/> 
        </td>
    </tr>
    <tr>
        <th>Date</th>
        <td>
            <div class="input-group date datetimepicker">        
                <input type="text" class="form-control" value="<?= $act->date_upload; ?>" name="date_upload" data-date-format="YYYY-MM-DD hh:mm:ss" />		
                <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>    
            </div> 
        </td>
    </tr>
</table>