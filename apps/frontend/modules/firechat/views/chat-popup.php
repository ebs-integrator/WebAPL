<div id="firechat" class="dop" style="height: 535px; display: <?= $session_exist ? 'block' : 'none'; ?>;">
    <div class="top">
        <div class="left firechat-photo" style=" display: <?= $session_exist ? 'block' : 'none'; ?>;">
            <div class="photo">
                <img src="<?= isset($person_icon) ? url($person_icon->path) : url('apps/frontend/modules/firechat/assets/chat.jpg'); ?>">
            </div>
        </div>

        <div class="right" >
            <div class="buttons">
                <button class="firechat-hide"></button>
                <button class="firechat-show" style="display: none;"></button>

                <button class="firechat-close"></button>
            </div>
        </div>
        <div class="right firechat-name" style="display:<?= $session_exist ? 'block' : 'none'; ?>;">
            <p class="c_name">
                <?= varlang('discuta-cu-primar'); ?> <span class="firechat-person"><?= isset($person) ? $person->first_name . " " . $person->last_name . " " . $person->function : ''; ?></span>
            </p>
            <p class="status on">
                <?= varlang('online'); ?>
            </p>
        </div>
        <hr>
    </div>
    <div class="content">
        <?php if ($session_exist) { ?>
            <?= WebAPL\Template::moduleView('firechat', 'views.chat-iframe'); ?>
        <?php } else { ?>
            <?=
            WebAPL\Template::moduleView('firechat', 'views.chat-form', array(
                'persons' => $persons
            ));
            ?>
        <?php } ?>
    </div>
</div>



<script>
    $(document).ready(function($) {
        var current_person = <?= isset($chat) && $chat->active ? $chat->person_id : 0; ?>;

        var startChat = function(id) {
            $(".firechat-photo, .firechat-name").hide();
            jQuery.post('<?= url('firechat/getform'); ?>', {id: id}, function(data) {
                $("#firechat .content").html(data).show();
                $("#firechat").stop().slideToggle(500).animate({height: 535}, 500);
            });
        }

        var intick = false;
        var tickChat = function(times, nr) {
            intick = true;
            $("#firechat .top").animate({'backgroundColor': nr ? '#7c4d7c' : '#AA79AA'}, 200);
            if (times > 0) {
                setTimeout(function() {
                    tickChat(times - 1, nr ? 0 : 1);
                }, 600);
            } else {
                intick = false;
            }
        }

        $("body").on('click', '.firechat-start-with', function(e) {
            e.preventDefault();

            if (current_person > 0)
                return intick ? false : tickChat(7, 0);

            var person = $(this).data('personid');
            if (current_person != person) {
                startChat(person);
            }

            return false;
        });

        $("body").on("click", ".firechat-start", function(e) {
            e.preventDefault();

            if (current_person > 0)
                return intick ? false : tickChat(7, 0);

            startChat(0);

            return false;
        });

        $("body").on("click", ".firechat-close", function() {
            jQuery.post('<?= url('firechat/close'); ?>', {}, function() {
                var cframe = document.getElementById("firechatIframe");
                if (cframe) {
                    cframe.contentWindow.leaveChat();
                }
                current_person = 0;
                $("#firechat").slideToggle(500);
            });
        });

        var firechat_hide = function(speed) {
            $("#firechat .content").slideToggle(speed);
            $("#firechat").animate({height: 40}, speed);
            $(".firechat-hide").hide();
            $(".firechat-show").show();
            $("#firechat .top").animate({height: 40}, speed);
            if (current_person) {
                $("#firechat .top .firechat-photo, #firechat .top .firechat-name").hide();
            }
            $.cookie('firechat_hidded', 1, {path: '/'});
        };

        $("body").on("click", ".firechat-hide", function() {
            firechat_hide(500);
        });

        if ($.cookie('firechat_hidded') == 1) {
            firechat_hide(0);
        }

        $("body").on("click", ".firechat-show", function() {
            $("#firechat .content").slideToggle(500);
            $("#firechat").animate({height: 535}, 500);
            $(".firechat-show").hide();
            $(".firechat-hide").show();
            $("#firechat .top").animate({height: 103}, 500);
            if (current_person) {
                $("#firechat .top .firechat-photo, #firechat .top .firechat-name").show();
            }
            $.cookie('firechat_hidded', 0, {path: '/'});
        });

        $("body").on("submit", ".firechat-register", function(e) {
            e.preventDefault();

            $.post('<?= url('firechat/register'); ?>', $(this).serialize(), function(data) {
                if (data.error === 0) {
                    $("#firechat .content").html(data.html);
                    $(".firechat-person").text(data.person.first_name + " " + data.person.last_name + " " + data.person.function);
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

        $("body").on('click', '.firechat-inactive', function() {
            $(".firechat-photo, .firechat-name").hide();
            $("#firechat .content").html('<center><br><br><br><?= varlang('chat-erro'); ?> <a href="<?=WebAPL\Language::url('topage/page_calendar');?>" style="color:#673167"><?= varlang('chat-erro-no'); ?></a></center>').show();
            $("#firechat").stop().slideToggle(500).animate({height: 535}, 500);
        });
    });
</script>