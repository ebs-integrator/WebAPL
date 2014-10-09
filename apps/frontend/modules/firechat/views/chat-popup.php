<div id="firechat" class="dop" style="height: 535px; display: <?= $session_exist ? 'block' : 'none'; ?>;">
    <div class="top">
        <div class="left firechat-photo" style=" display: <?= $session_exist ? 'block' : 'none'; ?>;">
            <div class="photo">
                <img src="<?= isset($person_icon) ? url($person_icon->path) : url('apps/frontend/modules/firechat/assets/chat.jpg'); ?>">
            </div>
        </div>

        <div class="right" >
            <div class="buttons">
                <button class="firechat-hide"><img src="<?= res('assets/img/save.png'); ?>"></button>
                <button class="firechat-show" style="display: none;"><img src="<?= res('assets/img/unsave.png'); ?>"></button>

                <button class="firechat-close"><img src="<?= res('assets/img/close.png'); ?>"></button>
            </div>
        </div>
        <div class="right firechat-name" style="display:<?= $session_exist ? 'block' : 'none'; ?>;">
            <p class="c_name">
                <?= varlang('discuta-cu-primar'); ?> <span class="firechat-person"><?= isset($person) ? $person->first_name . " " . $person->last_name : ''; ?></span>
            </p>
            <p class="status on">
                <?= varlang('online'); ?>
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

        $("body").on('click', '.firechat-start-with', function() {
            if (current_person > 0)
                return intick ? false : tickChat(7, 0);

            var person = $(this).data('personid');
            if (current_person != person) {
                startChat(person);
            }
        });

        $("body").on("click", ".firechat-start", function() {
            if (current_person > 0)
                return intick ? false : tickChat(7, 0);

            startChat(0);
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

        $("body").on("click", ".firechat-hide", function() {
            $("#firechat .content").slideToggle(500);
            $("#firechat").animate({height: 40}, 500);
            $(".firechat-hide").hide();
            $(".firechat-show").show();
            $("#firechat .top").animate({height: 40}, 500);
            if (current_person) {
                $("#firechat .top .firechat-photo, #firechat .top .firechat-name").hide();
            }
        });

        $("body").on("click", ".firechat-show", function() {
            $("#firechat .content").slideToggle(500);
            $("#firechat").animate({height: 535}, 500);
            $(".firechat-show").hide();
            $(".firechat-hide").show();
            $("#firechat .top").animate({height: 103}, 500);
            if (current_person) {
                $("#firechat .top .firechat-photo, #firechat .top .firechat-name").show();
            }
        });

        $("body").on("submit", ".firechat-register", function(e) {
            e.preventDefault();

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