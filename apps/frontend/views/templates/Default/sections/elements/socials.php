<div class="clearfix10"></div>
<div class="clearfix10"></div>

<?php
$link = URL::full();
$socialID = uniqid();
?>

<a rel="nofollow" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=$link;?>">
    <img class="opc-hover" src="<?=res('assets/img/socicons/share_fb.png');?>" alt=""  />
</a>
<a rel="nofollow" target="_blank" href="http://www.odnoklassniki.ru/dk?st.cmd=anonymMain&st.redirect=%2Fdk%3Fst.cmd%3DuserStatuses%26amp%3Bst.disp.type%3Dlinks%26amp%3Bst.layer.cmd%3DPopLayerAddSharedResourceOuter%26amp%3Bst.layer.s%3D1%26amp%3Bst.layer._surl%3D<?=$link;?>">
    <img class="opc-hover" src="<?=res('assets/img/socicons/share_odno.png');?>" alt=""  />
</a>
<a rel="nofollow" target="_blank" href="http://vkontakte.ru/share.php?url=<?=$link;?>">
    <img class="opc-hover" src="<?=res('assets/img/socicons/share_vk.png');?>"  alt="" />
</a>
<a rel="nofollow" target="_blank" href="https://twitter.com/intent/tweet?text=&source=apl&related=apl&via=apl&url=<?=$link;?>">
    <img class="opc-hover" src="<?=res('assets/img/socicons/share_tw.png');?>" alt=""  />
</a>
<a rel="nofollow" target="_blank" href="mailto:?body=<?=$link;?>">
    <img class="opc-hover" src="<?=res('assets/img/socicons/share_email.png');?>" alt=""  />
</a>