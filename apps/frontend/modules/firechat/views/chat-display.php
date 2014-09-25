
<script src="https://cdn.firebase.com/v0/firebase.js"></script>
<script src="https://cdn.firebase.com/v0/firebase-simple-login.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<!-- Download from https://github.com/firebase/Firechat -->
<link rel="stylesheet" href="/apps/backend/modules/firechat/assets/firechat-default.css" />
<script src="/apps/backend/modules/firechat/assets/firechat-default.js"></script>
<style>
    #firechat-wrapper {
        height: 527px;
        width: 100%;
        margin: 0px auto;
        text-align: center;
    }

    #firechat-header, #firechat-tab-list, .tab-pane-menu {
        display: none;
    }
</style>

<div id="firechat-wrapper"></div>
<script type='text/javascript'>
    var to_person = <?= $chat->person_id; ?>;

    var chatRef = new Firebase('https://aplchat.firebaseio.com');
    var chat = new FirechatUI(chatRef, document.getElementById("firechat-wrapper"));

    var chatRun = function(uid) {
<?php if ($chat->roomId) { ?>
            chat._chat.enterRoom('<?= $chat->roomId; ?>');
<?php } else { ?>
            chat._chat.createRoom('With <?= $chat->user_name; ?>', 'private', function(roomId) {
                chat._chat.enterRoom(roomId);

                var fredNameRef = new Firebase('https://aplchat.firebaseio.com/room-metadata/' + roomId);
                fredNameRef.child('person_id').set(to_person);
                fredNameRef.child('closed').set(0);

                jQuery.post('<?= url('firechat/newroom'); ?>', {roomId: roomId, userId: uid});
            });
<?php } ?>
    };

    var simpleLogin = new FirebaseSimpleLogin(chatRef, function(err, user) {
        if (user) {
            chat.setUser(user.id, '<?= $chat->user_name; ?>');

            setTimeout(function() {
                chatRun(user.id);
            }, 500);
        } else {
            simpleLogin.login('anonymous');
        }
    });
</script>
