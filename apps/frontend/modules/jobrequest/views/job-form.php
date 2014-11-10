<form class="cv_form" action="<?= url('job/apply'); ?>" method="post">

    <input type="hidden" name="post_id" value="<?= $post_id; ?>" />
    <input type='text' name="name" placeholder="<?= varlang('name-last-name'); ?>"/>
    <div class="upload"><?= varlang('cv'); ?></div>
    <input type="file" name="upload" id='upload'/>
    <input type='submit' value='<?= varlang('apply'); ?>'/>
    <div class="clearfix"></div>
    <div class="form_error"></div>
</form>

<script src="<?= res('assets/js/jquery.form.js'); ?>"></script>
<script>
    jQuery(document).ready(function($) {

        $(".cv_form").submit(function(e) {
            e.preventDefault();
            
            var form = $(this);
            $(this).ajaxSubmit({
                success: function(data) {
                    if (data.error == 0) {
                        form.fadeOut(400, function() {
                            $(this).remove();
                        });
                    } else {
                        form.find(".form_error").html(data.message);
                    }
                },
                dataType: 'json',
                resetForm: false
            });
            
            
            return false;
        });


    });
</script>