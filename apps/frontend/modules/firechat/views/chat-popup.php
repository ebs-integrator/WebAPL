<div id="firechat" class="dop" style="display: none;">
    <div class="top">
        <div class="left firechat-photo" style=" display: none;">
            <div class="photo">
                <img src="<?= res('assets/img/small_p.png'); ?>">
            </div>
        </div>

        <div class="right" style="width: 60px;">
            <div class="buttons">
                <button class="firechat-hide"><img src="<?= res('assets/img/save.png'); ?>"></button>
                <button class="firechat-close"><img src="<?= res('assets/img/close.png'); ?>"></button>
            </div>
        </div>
        <div class="right firechat-name" style="width: 220px; display:none;">
            <p class="c_name">
                Discută on-line cu
                primarul Ion Vasilica
            </p>
            <p class="status on">
                on-line
            </p>
        </div>
        <hr>
    </div>
    <div class="content">

        <div class="form green firechat-register">
            <form action="" method="">
                <div class="contenta">
                    <label>Functionar *</label>
                    <select name="person_id">
                        <?php foreach ($persons as $person) { ?>
                            <option value="<?= $person->id; ?>"><?= $person->first_name; ?> <?= $person->last_name; ?></option>
                        <?php } ?>
                    </select>
                    <label>Numele Prenumele * </label>
                    <input name="name" type="text" >
                    <label>Email*</label>
                    <input name="email" type="text" >    
                    <input type="submit" value="trimite">
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>


    </div>
</div>

<script>
    $(document).ready(function($) {
        //$("#firechat")
        $("body").on("click", ".firechat-start", function() {
            $("#firechat").stop().slideToggle(500).animate({height: 630}, 500);
        });

        $("body").on("click", ".firechat-close", function() {
            $("#firechat").slideToggle(500);
        });

        $("body").on("click", ".firechat-hide", function() {
            $("#firechat .content").slideToggle(500);
            $("#firechat").animate({height: 103}, 500);
            $(this).removeClass("firechat-hide").addClass("firechat-show");
        });

        $("body").on("click", ".firechat-show", function() {
            $("#firechat .content").slideToggle(500);
            $("#firechat").animate({height: 630}, 500);
            $(this).removeClass("firechat-show").addClass("firechat-hide");
        });

        $("body").on("submit", ".firechat-register", function(e) {
            e.preventDefault();

            $.post('<?= url('firechat/register'); ?>', $(this).serialize(), function(data) {
                if (data.error === 0) {
                    $("#firechat .content").html(data.html);
                } else {
                    alert('Chat error!');
                    window.location.reload();
                }
            }, 'json');

            return false;
        });
    });
</script>