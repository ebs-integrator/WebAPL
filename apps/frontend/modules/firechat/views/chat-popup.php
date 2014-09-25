<div id="firechat" class="dop" style="display: <?= $session_exist ? 'block' : 'none'; ?>;">
    <div class="top">
        <div class="left firechat-photo" style=" display: <?= $session_exist ? 'block' : 'none'; ?>;">
            <div class="photo">
                <img src="<?= isset($person_icon) ? $person_icon->path : ''; ?>">
            </div>
        </div>

        <div class="right" >
            <div class="buttons">
                <button class="firechat-hide"><img src="<?= res('assets/img/save.png'); ?>"></button>
                <button class="firechat-close"><img src="<?= res('assets/img/close.png'); ?>"></button>
            </div>
        </div>
        <div class="right firechat-name" style="display:<?= $session_exist ? 'block' : 'none'; ?>;">
            <p class="c_name">
                Discută on-line cu
                primarul <span class="firechat-person"><?= isset($person) ? $person->first_name . " " . $person->last_name : ''; ?></span>
            </p>
            <p class="status on">
                on-line
            </p>
        </div>
        <hr>
    </div>
    <div class="content">
        <?php if ($session_exist) { ?>
            <?= Core\APL\Template::moduleView('firechat', 'views.chat-iframe'); ?>
        <?php } else { ?>
            <?=
            Core\APL\Template::moduleView('firechat', 'views.chat-form', array(
                'persons' => $persons
            ));
            ?>
<?php } ?>
    </div>
</div>

<script>
    $(document).ready(function($) {
        //$("#firechat")

        var current_person = <?=isset($chat) && $chat->active ? $chat->person_id : 0;?>;

        var startChat = function(id) {
            $(".firechat-photo, .firechat-name").hide();
            jQuery.post('<?= url('firechat/getform'); ?>', {id: id}, function(data) {
                $("#firechat .content").html(data);
                $("#firechat").stop().slideToggle(500).animate({height: 630}, 500);
            });
        }

        $("body").on('click', '.firechat-start-with', function() {
            var person = $(this).data('personid');
            if (current_person != person) {
                startChat(person);
            }
        });

        $("body").on("click", ".firechat-start", function() {
            startChat(0);
        });

        $("body").on("click", ".firechat-close", function() {
            current_person = 0;
            $("#firechat").slideToggle(500);
            
            jQuery.post('<?= url('firechat/close'); ?>', {});
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
            console.log($(".firechat-register").serialize());
            $.post('<?= url('firechat/register'); ?>', $(this).serialize(), function(data) {
                if (data.error === 0) {
                    $("#firechat .content").html(data.html);
                    $(".firechat-person").text(data.person.first_name + " " + data.person.last_name);
                    $(".firechat-photo img").attr('src', data.person.photo);

                    $(".firechat-photo, .firechat-name").show();
                    
                    current_person = data.person.id;
                } else {
                    alert('Chat error!');
                    //window.location.reload();
                }
            }, 'json');

            return false;
        });
    });
</script>