<h3><?= varlang('settings-1'); ?></h3>

<form action="<?= url('settings/save'); ?>" method="post" class="ajax-auto-submit">

    <table class="table table-bordered">

        <tr>
            <th>Nume site</th>
            <td>
                <input type='text' name='set[sitename]' placeholder="Nume site" class='form-control' value='<?= isset($setts['sitename']) ? $setts['sitename'] : ''; ?>'/>
            </td>
        </tr>

        <?php
        $colorSchemes = \Core\APL\Template::getColorSchemes();
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
        
        
        <tr>
            <th><?= varlang('website-activ'); ?></th>
            <td>
                <input type="hidden" name="set[website_on]" value="0" />
                <input type='checkbox' name='set[website_on]' class='make-switch' <?= isset($setts['website_on']) && $setts['website_on'] ? 'checked' : ''; ?>/>
                <br><?= varlang('pentru-a-accesa-website-ul-folositi-linkul'); ?> <a href="<?=url('../?is_admin=1');?>"><?= varlang('click-aici'); ?></a>
            </td>
        </tr>


    </table>

</form>

<h4>Favicon</h4>
<?= Files::widget('website_favicon', 1, 1); ?>

<h4>Home logo</h4>
<?= Files::widget('website_logo', 1, 1); ?>

<h4>Home logo (small)</h4>
<?= Files::widget('website_logo_sm', 1, 1); ?>


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
    google.maps.event.addDomListener(window, 'load', init_map);



</script>