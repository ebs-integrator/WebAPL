<script>
    window.firechat_lang = {
        your_message : '<?= varlang('your-message'); ?>',
        type_your_message : '<?= varlang('type-your-message'); ?>'
    };
</script>
<script src="https://cdn.firebase.com/v0/firebase.js"></script>
<script src="https://cdn.firebase.com/v0/firebase-simple-login.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>

<!-- Download from https://github.com/firebase/Firechat -->
<link rel="stylesheet" href="/apps/backend/modules/firechat/assets/firechat-default.css" />
<script src="/apps/backend/modules/firechat/assets/firechat-default.js"></script>
<style>
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
        font-family: 'Open Sans', sans-serif;
        font-size: 15px;
        color:#713871;
    }
    #firechat em, .sendmail{
        color:#b9b9b9;
        font-family: 'Open Sans', sans-serif;
        font-size:13px;
        float:right;
    }
    .sendmail a {
        color:#713871;
    }
    .sendmail {
        margin-top: -30px;
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
        font-family: 'Open Sans', sans-serif;
        font-size:15px;
        font-weight: 600;
        color:#4c4c4c;
    }
    #firechat textarea{
        height:55px;
        border: 1px solid #d9d9d9;
        padding: 10px;
        font-family: 'Open Sans', sans-serif;
        font-size:13px;
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
        font-family: 'Open Sans', sans-serif;
        font-size:15px;
        font-weight: 600;
        color: #b6c57e;
    }

</style>

<?php Event::fire('firechat_top'); ?>

<div id="firechat-wrapper"></div>
<div class="sendmail"><?= varlang('fire-save'); ?> <a href="javascript:;"><?= varlang('fire-click'); ?></a></div>

<?php Event::fire('firechat_bottom'); ?>

<script type='text/javascript'>
    var to_person = <?= $chat->person_id; ?>;

    var chatRef = new Firebase('<?=SettingsModel::one('firechat_host');?>');
    var chat = new FirechatUI(chatRef, document.getElementById("firechat-wrapper"));

    var chatRun = function(uid) {
<?php if ($chat->roomId) { ?>
            chat._chat.enterRoom('<?= $chat->roomId; ?>');
<?php } else { ?>
            chat._chat.createRoom('With <?= $chat->user_name; ?>', 'private', function(roomId) {
                chat._chat.enterRoom(roomId);

                var fredNameRef = new Firebase('<?=SettingsModel::one('firechat_host');?>/room-metadata/' + roomId);
                fredNameRef.child('person_id').set(to_person);
                fredNameRef.child('closed').set(0);

                jQuery.post('<?= url('firechat/newroom'); ?>', {roomId: roomId, userId: uid});
            });

            chat._chat.on('room-enter', function(room) {
                chat._chat.sendSystemMessage(room.id, "<?= varlang('fire-reg'); ?>");
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
        chat._chat.sendSystemMessage(room.id, "<?= $chat->user_name; ?> <?= varlang('fire-out'); ?>", 'default', function() {
                    chat._chat.leaveRoom(room.id);
                });
            };

            jQuery(".sendmail a").on('click', function() {
                var conf = confirm('<?= varlang('fire-rlu'); ?> <?= $chat->user_email; ?>');
                        if (conf) {
                            var html = $('.chat').html();
                            jQuery.post('<?= url('firechat/sendmail'); ?>', {messages: html}, function() {
                                alert('<?= varlang('fire-email'); ?>');
                            });
                        }
                    });
</script>
