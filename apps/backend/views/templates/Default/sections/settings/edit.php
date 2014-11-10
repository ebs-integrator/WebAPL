<h3><?= varlang('settings-1'); ?></h3>

<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#general" role="tab" data-toggle="tab"><?= varlang('general-7'); ?></a></li>
    <li><a href="#apparence" role="tab" data-toggle="tab"><?= varlang('aparenta'); ?></a></li>
    <li><a href="#location" role="tab" data-toggle="tab"><?= varlang('location-1'); ?></a></li>
    <li><a href="#comments" role="tab" data-toggle="tab"><?= varlang('comments'); ?></a></li>
    <li><a href="#ment" role="tab" data-toggle="tab"><?= varlang('inca'); ?></a></li>
    <li><a href="#stats" role="tab" data-toggle="tab"><?= varlang('statistica'); ?></a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="general">


        <form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

            <table class="table table-bordered table-hover">

                <?php foreach (WebAPL\Language::getList() as $lang) { ?>
                    <tr>
                        <th><?= varlang('sitename'); ?> (<?= $lang->name; ?>):</th>
                        <td>
                            <input type='text' name='set[sitename_<?= $lang->ext; ?>]' class='form-control' value='<?= isset($setts['sitename_' . $lang->ext]) ? $setts['sitename_' . $lang->ext] : ''; ?>'/>
                        </td>
                    </tr>
                <?php } ?>

                <tr>
                    <th><?= varlang('cachelife'); ?></th>
                    <td>
                        <input type='number' name='set[cachelife]' class='form-control' value='<?= isset($setts['cachelife']) ? $setts['cachelife'] : ''; ?>'/>
                        <br><br>
                        <button type='button' id='ccache' class='btn btn-success'>Clear cache</button>
                    </td>
                </tr>

            </table>

        </form>

    </div>

    <div class="tab-pane" id="apparence">


        <form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

            <table class="table table-bordered table-hover">

                <?php
                $colorSchemes = \WebAPL\Template::getColorSchemes();
                ?>
                <?php if ($colorSchemes) { ?>
                    <tr>
                        <th><?= varlang('template-color-schema'); ?></th>
                        <td>
                            <select class='form-control' name="set[templateSchema]">
                                <option name=''>---</option>
                                <?php foreach ($colorSchemes as $schemaKey => $schema) { ?>
                                    <option value='<?= $schemaKey; ?>' <?= isset($setts['templateSchema']) && $setts['templateSchema'] == $schemaKey ? 'selected' : ''; ?>><?= isset($schema['name']) ? $schema['name'] : 'undefined name'; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                <?php } ?>

            </table>

        </form>

        <?php if (Config::get('template.logo')) { ?>
            <?php if (Config::get('template.logo_multilang')) { ?>
                <?php foreach (WebAPL\Language::getList() as $lang) { ?>
                    <h4><?= varlang('home-logo-in-'); ?> <?= $lang->name; ?></h4>
                    <?= Files::widget('website_logo_' . $lang->ext, 1, 1); ?>
                    <?php if (Config::get('template.logo_small')) { ?>
                        <h5><?= varlang('home-logo-small'); ?></h5>
                        <?= Files::widget('website_logo_sm_' . $lang->ext, 1, 1); ?>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <h4><?= varlang('logo'); ?></h4>
                <?= Files::widget('website_logo', 1, 1); ?>
                <?php if (Config::get('template.logo_small')) { ?>
                    <h4><?= varlang('home-logo-small'); ?></h4>
                    <?= Files::widget('website_logo_sm', 1, 1); ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <h4><?= varlang('favicon'); ?></h4>
        <?= Files::widget('website_favicon', 1, 1); ?>
    </div>


    <div class="tab-pane" id="location">



        <form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

            <table class="table table-bordered table-hover">

                <tr>
                    <th>
                        <?= varlang('location'); ?>
                        <input type='hidden' name='set[pos_lat]' id="latbox" placeholder="Lat" class='form-control' value='<?= isset($setts['pos_lat']) ? $setts['pos_lat'] : ''; ?>'/><br>
                        <input type='hidden' name='set[pos_long]'id="longbox" placeholder="Long" class='form-control' value='<?= isset($setts['pos_long']) ? $setts['pos_long'] : ''; ?>'/>
                    </th>
                    <td class='col-lg-8'>
                        <div style="overflow:hidden;height:300px;width:100%;">
                            <div id="gmap_canvas" style="height:300px;width:100%;"></div>
                            <style>#gmap_canvas img{max-width:none!important;background:none!important}</style>
                        </div>
                    </td>
                </tr>


            </table>

        </form>

    </div>
    <div class="tab-pane" id="comments">

        <form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

            <table class="table table-bordered table-hover">

                <tr>
                    <th><?= varlang('disqus-shortname'); ?></th>
                    <td>
                        <input type='text' name='set[disqus_shortname]' class='form-control' value='<?= isset($setts['disqus_shortname']) ? $setts['disqus_shortname'] : ''; ?>'/>
                    </td>
                </tr>

            </table>

        </form>

    </div>
    <div class="tab-pane" id="ment">


        <form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

            <table class="table table-bordered table-hover">

                <tr>
                    <th><?= varlang('website-activ'); ?></th>
                    <td>
                        <input type="hidden" name="set[website_on]" value="0" />
                        <input type='checkbox' name='set[website_on]' class='make-switch' <?= isset($setts['website_on']) && $setts['website_on'] ? 'checked' : ''; ?>/>
                        <br><?= varlang('pentru-a-accesa-website-ul-folositi-linkul'); ?> <a href="<?= url('../?is_admin=1'); ?>" target="_blank"><?= varlang('click-aici'); ?></a>
                    </td>
                </tr>

                <tr>
                    <th><?= varlang('ment-text'); ?></th>
                    <td>
                        <textarea name='set[inactive_text]' class='ckeditor-run'><?= isset($setts['inactive_text']) ? $setts['inactive_text'] : ''; ?></textarea>
                    </td>
                </tr>

            </table>

        </form>


    </div>


    <div class="tab-pane" id="stats">


        <form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

            <table class="table table-bordered table-hover">

                <tr>
                    <th class="col-lg-3"><?= varlang('inserare-cod-pentru-statistica'); ?></th>
                    <td>
                        <textarea name='set[stats_code]' class="form-control" style="min-height: 400px"><?= isset($setts['stats_code']) ? $setts['stats_code'] : ''; ?></textarea>
                    </td>
                </tr>

            </table>

        </form>


    </div>

</div>










<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
    markers = [];
    function init_map() {

        var myOptions = {
            zoom: 14,
            scrollwheel: true,
            center: new google.maps.LatLng(<?= isset($setts['pos_lat']) ? $setts['pos_lat'] : '0'; ?>, <?= isset($setts['pos_long']) ? $setts['pos_long'] : '0'; ?>),
            mapTypeId: google.maps.MapTypeId.ROADMAP};
        map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: new google.maps.LatLng(<?= isset($setts['pos_lat']) ? $setts['pos_lat'] : '0'; ?>, <?= isset($setts['pos_long']) ? $setts['pos_long'] : '0'; ?>)});

        var infowindow = new google.maps.InfoWindow({
            content: ''
        });



        google.maps.event.addListener(map, "click", function(e) {

            //lat and lng is available in e object
            computepos(e.latLng);
            marker.setPosition(e.latLng);
            map.setCenter(marker.getPosition());

        });
        google.maps.event.addListener(marker, "dragend", function(e) {

            computepos(marker.getPosition());

        });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
        });
    }

    function addMarker(location) {
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
        markers.push(marker);
    }

    // Sets the map on all markers in the array.
    function setAllMap(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setAllMap(null);
    }

    // Shows any markers currently in the array.
    function showMarkers() {
        setAllMap(map);
    }

    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        clearMarkers();
        markers = [];
    }
    function computepos(point)
    {
        var latA = Math.abs(Math.round(point.lat() * 1000000.));
        var lonA = Math.abs(Math.round(point.lng() * 1000000.));
        if (point.lat() < 0)
        {
            var ls = '-' + Math.floor((latA / 1000000)).toString();
        }
        else
        {
            var ls = Math.floor((latA / 1000000)).toString();
        }
        var lm = Math.floor(((latA / 1000000) - Math.floor(latA / 1000000)) * 60).toString();
        var ld = (Math.floor(((((latA / 1000000) - Math.floor(latA / 1000000)) * 60) - Math.floor(((latA / 1000000) - Math.floor(latA / 1000000)) * 60)) * 100000) * 60 / 100000).toString();
        if (point.lng() < 0)
        {
            var lgs = '-' + Math.floor((lonA / 1000000)).toString();
        }
        else
        {
            var lgs = Math.floor((lonA / 1000000)).toString();
        }
        var lgm = Math.floor(((lonA / 1000000) - Math.floor(lonA / 1000000)) * 60).toString();
        var lgd = (Math.floor(((((lonA / 1000000) - Math.floor(lonA / 1000000)) * 60) - Math.floor(((lonA / 1000000) - Math.floor(lonA / 1000000)) * 60)) * 100000) * 60 / 100000).toString();
        document.getElementById("latbox").value = point.lat().toFixed(6);
        document.getElementById("longbox").value = point.lng().toFixed(6);
        $("#latbox").change();
    }
    //google.maps.event.addDomListener(window, 'load', init_map);
    var loadedmap = false;
    $(document).ready(function() {
        $('a[href="#location"]').click(function() {
            if (loadedmap === false) {
                init_map();
                loadedmap = true;
            }
        });
    });



</script>