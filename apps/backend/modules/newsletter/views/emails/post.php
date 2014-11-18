<style>
    @import url(http://fonts.googleapis.com/css?family=Open+Sans:300,400,700,600);
</style>
<div style="width:100%;background-color:#f2f3f4;margin:0px;padding:30px 0px">
    <div style="width:700px;background-color:#fff;
         box-shadow: 0px 1px 13px 0px rgba(183,183,183,1);margin:0 auto;font-family: 'Open Sans', sans-serif;font-weight: 400">  
        <div style="width:95%;height:60px;border-bottom:1px solid #efefef;padding:0px 18px;">
            <p style=" float:left;margin:0px;font-weight:300;color:#33627c;font-size: 17px;margin-top:24px;padding-left: 12px;" class="MsoNormal">Newsletter</p>
        </div>
        <div style="width:77%;padding: 55px 80px 85px;">
            <p style="color:#003d79;font-size:22px;margin:0px;font-weight: 600" class="MsoNormal"><?=$post->title;?></p>
            
            <p style="margin-top: 22px;font-size: 13px;color:#5a5a5a;" class="MsoNormal"><?=Str::words(strip_tags($post->text), 50);?></p>

            <div>
                <div style="height:30px;"></div>
                <a href="<?=$post_url;?>" target="_blank" style="background-color: #019ae6;border-bottom: 2px solid #247cab;color:#fff;font-size: 12px;text-decoration: none;font-weight: 700;padding:7px 18px;margin-right:20px;">Vezi articolul</a>
            </div>

            <p style="margin-top: 22px;font-size: 11px;color:#a7a7a7;" class="MsoNormal">
                Pentru dezabonare, click <a href="<?=$unsubscribe_link;?>" target="_blank" style="text-decoration: none;color:#a7a7a7;font-weight: 700">aici</a>.
            </p>
        </div>
    </div>
</div>