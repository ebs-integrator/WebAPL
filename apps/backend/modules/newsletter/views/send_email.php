<table class="table table-bordered table-hover">
        <tr>
            <th><?= varlang('newsletter-2'); ?>: </th>
            <td>
                <button class="sendnewsletter btn btn-default"><?= varlang('send-this-post'); ?></button>
            </td>
        </tr>
</table>

<script>
jQuery(document).ready(function ($) {
    
    $('body').on('click', '.sendnewsletter', function () {
        
        $.post('<?=url('newsletter/sendarticle');?>', {id:'<?=$post->id;?>'}, function () {
            alert('Email sended');
        });
        
    });
    
});
</script>