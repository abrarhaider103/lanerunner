<?php
include("../config.php");
include("adminClass.php");

$sql = "SELECT * FROM master_regions WHERE canada = 0";

$pol = $adm->getThisAll($sql);
//$rn = $adm->getThisAll("SELECT * FROM regions");

?>
<script src="../plugins/leaflet/leaflet-src.js"></script>
<link rel="stylesheet" href="../plugins/leaflet/leaflet.css"/>

<script src="../plugins/leafletDraw/src/Leaflet.draw.js"></script>
<script src="../plugins/leafletDraw/src/Leaflet.Draw.Event.js"></script>
<link rel="stylesheet" href="../plugins/leafletDraw/src/leaflet.draw.css"/>

<script src="../plugins/leafletDraw/src/Toolbar.js"></script>
<script src="../plugins/leafletDraw/src/Tooltip.js"></script>

<script src="../plugins/leafletDraw/src/ext/GeometryUtil.js"></script>
<script src="../plugins/leafletDraw/src/ext/LatLngUtil.js"></script>
<script src="../plugins/leafletDraw/src/ext/LineUtil.Intersect.js"></script>
<script src="../plugins/leafletDraw/src/ext/Polygon.Intersect.js"></script>
<script src="../plugins/leafletDraw/src/ext/Polyline.Intersect.js"></script>
<script src="../plugins/leafletDraw/src/ext/TouchEvents.js"></script>

<script src="../plugins/leafletDraw/src/draw/DrawToolbar.js"></script>
<script src="../plugins/leafletDraw/src/draw/handler/Draw.Feature.js"></script>
<script src="../plugins/leafletDraw/src/draw/handler/Draw.SimpleShape.js"></script>
<script src="../plugins/leafletDraw/src/draw/handler/Draw.Polyline.js"></script>
<script src="../plugins/leafletDraw/src/draw/handler/Draw.Marker.js"></script>
<script src="../plugins/leafletDraw/src/draw/handler/Draw.Circle.js"></script>
<script src="../plugins/leafletDraw/src/draw/handler/Draw.CircleMarker.js"></script>
<script src="../plugins/leafletDraw/src/draw/handler/Draw.Polygon.js"></script>
<script src="../plugins/leafletDraw/src/draw/handler/Draw.Rectangle.js"></script>


<script src="../plugins/leafletDraw/src/edit/EditToolbar.js"></script>
<script src="../plugins/leafletDraw/src/edit/handler/EditToolbar.Edit.js"></script>
<script src="../plugins/leafletDraw/src/edit/handler/EditToolbar.Delete.js"></script>

<script src="../plugins/leafletDraw/src/Control.Draw.js"></script>

<script src="../plugins/leafletDraw/src/edit/handler/Edit.Poly.js"></script>
<script src="../plugins/leafletDraw/src/edit/handler/Edit.SimpleShape.js"></script>
<script src="../plugins/leafletDraw/src/edit/handler/Edit.Rectangle.js"></script>
<script src="../plugins/leafletDraw/src/edit/handler/Edit.Marker.js"></script>
<script src="../plugins/leafletDraw/src/edit/handler/Edit.CircleMarker.js"></script>
<script src="../plugins/leafletDraw/src/edit/handler/Edit.Circle.js"></script>

</head>
<body >


                        <div id="map" style="width: 100%; height: 600px; border: 1px solid #ccc"></div>
                  

        <script>
            var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                osm = L.tileLayer(osmUrl, { maxZoom: 18, attribution: osmAttrib }),
                map = new L.Map('map', { center: new L.LatLng(37.901731270574196, -100.79423582803), zoom: 4 });

            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
            }).addTo(map);


            <?php
                foreach($pol as $c => $v){
                    echo "var polygon$c = L.polygon([";
                    $poly = explode("/", $v->coordinates);
                    array_pop($poly);
                    foreach($poly as $coord) {
                        $p = explode(",",$coord);
                        $lat = $p[1];
                        $lng = $p[0];
                        $coord = $lat.", ".$lng;
                        echo "[".$coord."],";
                    }
                    echo "]).addTo(map); ";

                    if ($v->center_lat === '' || is_null($v->center_lat) ) {} else { 

                    echo "

                    var marker$c = L.marker([$v->center_lat, $v->center_lng]).addTo(map);
                    marker$c.bindPopup('<b>$v->region_name</b>');
";

                }
            }

          
            ?>



        </script>
</body>
</html>
