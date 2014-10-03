
<script src="https://cdn.firebase.com/v0/firebase.js"></script>
<script src="https://cdn.firebase.com/v0/firebase-simple-login.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<!-- Download from https://github.com/firebase/Firechat -->
<link rel="stylesheet" href="/apps/backend/modules/firechat/assets/firechat-default.css" />
<script src="/apps/backend/modules/firechat/assets/firechat-default.js"></script>
<style>

    @font-face {
        font-family: 'open_sansbold';
        src: url("<?= res('assets/font/opensans-bold-webfont.eot'); ?>");
        src: url("<?= res('assets/font/opensans-bold-webfont.eot?#iefix'); ?>") format('embedded-opentype'),
            url("<?= res('assets/font/opensans-bold-webfont.woff'); ?>") format('woff'),
            url("<?= res('assets/font/opensans-bold-webfont.ttf'); ?>") format('truetype');
        font-weight: normal;
        font-style: normal;

    }
    @font-face {
        font-family: 'open_sansregular';
        src: url("<?= res('assets/font/opensans-regular-webfont.eot'); ?>");
        src: url("<?= res('assets/font/opensans-regular-webfont.eot?#iefix'); ?>") format('embedded-opentype'),
            url("<?= res('assets/font/opensans-regular-webfont.woff'); ?>") format('woff'),
            url("<?= res('assets/font/opensans-regular-webfont.ttf'); ?>") format('truetype');
        font-weight: normal;
        font-style: normal;

    }
    @font-face {
        font-family: 'open_sanssemibold';
        src: url("<?= res('assets/font/opensans-semibold-webfont.eot'); ?>");
        src: url("<?= res('assets/font/opensans-semibold-webfont.eot?#iefix'); ?>") format('embedded-opentype'),
            url("<?= res('assets/font/opensans-semibold-webfont.woff'); ?>") format('woff'),
            url("<?= res('assets/font/opensans-semibold-webfont.ttf'); ?>") format('truetype');
        font-weight: normal;
        font-style: normal;

    }
    @font-face {
        font-family: 'open_sanssemibold_italic';
        src: url("<?= res('assets/font/opensans-semibolditalic-webfont.eot'); ?>");
        src: url("<?= res('assets/font/opensans-semibolditalic-webfont.eot?#iefix'); ?>") format('embedded-opentype'),
            url("<?= res('assets/font/opensans-semibolditalic-webfont.woff'); ?>") format('woff'),
            url("<?= res('assets/font/opensans-semibolditalic-webfont.ttf'); ?>") format('truetype');
        font-weight: normal;
        font-style: normal;

    }
    #firechat-wrapper {
        width: 100%;
        margin: 0px auto;
        text-align: center;
    }

    #firechat-header, #firechat-tab-list, .tab-pane-menu ,#firechat .fifth{
        display: none;
    }
    #firechat label{

    }
    #firechat .message:nth-child(odd){
        background:#fff;
    }
    #firechat .message,#firechat .chat{
        border:0px;
    }
    #firechat .message .name{
        font:15px 'open_sansbold';
        color:#713871;
    }
    #firechat em{
        color:#b9b9b9;
        font:13px 'open_sansregular';
        float:right;
    }
    #firechat .fourfifth{
        width:100%;
    }
    #firechat .message.message-self {
        margin-left:0px;
    }
    #firechat .message{
        margin-left:10px;
        border-left:3px solid #d9d9d9;
        padding-left:18px;
        margin-bottom:20px;
    }
    #firechat .chat{
        padding-left:15px;
        height: 310px;
        margin-bottom:17px;
    }   
    #firechat .message-content{
        font:15px 'open_sanssemibold';
        color:#4c4c4c;
    }
    #firechat textarea{
        height:60px;
        border: 1px solid #d9d9d9;
        padding: 10px;
        font: 13px 'open_sanssemibold_italic';
        color: #959595;
        width: 380px;
        margin: 0 auto;
        display: block;

    }
    #firechat textarea:focus{
        outline:none;
    }
    #firechat .clearfix > label{
        margin-left:10px;
        font: 15px 'open_sansbold';
        color: #b6c57e;
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

            chat._chat.on('room-enter', function(room) {
                chat._chat.sendSystemMessage(room.id, "Acest chat se inregistreaza");
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

    var room = null;
    chat._chat.on('room-enter', function(r) {
        room = r;
    });

    window.leaveChat = function() {
        chat._chat.sendSystemMessage(room.id, "<?= $chat->user_name; ?> a parasit chat-ul", 'default', function () {
            chat._chat.leaveRoom(room.id);
        });
    };
</script>
