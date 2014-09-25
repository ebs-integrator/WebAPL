
<script src="https://cdn.firebase.com/v0/firebase.js"></script>
<script src="https://cdn.firebase.com/v0/firebase-simple-login.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

<!-- Download from https://github.com/firebase/Firechat -->
<link rel="stylesheet" href="/apps/backend/modules/firechat/assets/firechat-default.css" />
<script src="/apps/backend/modules/firechat/assets/firechat-default.js"></script>
<style>
    #firechat-wrapper {
        height: 500px;
        max-width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        background-color: #fff;
        margin: 50px auto;
        text-align: center;
    }
</style>

<div id="firechat-wrapper"></div>
<script type='text/javascript'>
    var to_person = 21;

    var chatRef = new Firebase('https://aplchat.firebaseio.com');
    var chat = new FirechatUI(chatRef, document.getElementById("firechat-wrapper"));
    var simpleLogin = new FirebaseSimpleLogin(chatRef, function(err, user) {
        if (user) {
            chat.setUser(user.id, 'Anonymous' + user.id.substr(0, 8));
            setTimeout(function() {
                chat._chat.createRoom('ROOM' + user.id.substr(0, 8), 'private', function(roomId) {
                    chat._chat.enterRoom(roomId);

                    var fredNameRef = new Firebase('https://aplchat.firebaseio.com/room-metadata/' + roomId);
                    fredNameRef.child('person_id').set(to_person);
                    fredNameRef.child('closed').set(0);
                })
            }, 500);
        } else {
            simpleLogin.login('anonymous');
        }
    });
</script>
