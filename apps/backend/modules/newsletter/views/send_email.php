<table class="table table-bordered">
        <tr>
            <th>Newsletter: </th>
            <td>
                <button class="sendnewsletter btn btn-default">Send this post</button>
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