<div class="clearfix10"></div>
<div class="clearfix10"></div>

<?php
$link = Request::url();
$socialID = uniqid();
?>

<table>
    <tr>
        <td>
            
            <!--- FACEBOOK --->
            <div class="fb-like" data-href="<?= $link; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>

        </td>
        <td>

            <!--- TWITTER --->
            <a href="https://twitter.com/" class="twitter-share-button" data-url="<?= $link; ?>">Tweet</a>

        </td>
        <td>

            <!--- ODNOKLASSNIKI --->
            <div id="ok_shareWidget<?= $socialID; ?>"></div>
            <script>
                !function(d, id, did, st) {
                    var js = d.createElement("script");
                    js.src = "http://connect.ok.ru/connect.js";
                    js.onload = js.onreadystatechange = function() {
                        if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
                            if (!this.executed) {
                                this.executed = true;
                                setTimeout(function() {
                                    OK.CONNECT.insertShareWidget(id, did, st);
                                }, 0);
                            }
                        }
                    };
                    d.documentElement.appendChild(js);
                }(document, "ok_shareWidget<?= $socialID; ?>", "<?= $link; ?>", "{width:145,height:30,st:'rounded',sz:20,ck:1}");
            </script>

        </td>
    </tr>
</table>

