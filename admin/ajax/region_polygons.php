<?php

include("../../config.php");
include("../adminClass.php");

$sql = "SELECT * FROM master_regions WHERE canada = 0";

$reg = $adm->getThisAllArray($sql);

/*
[0] => Array
        (
            [region_id] => 30
            [coordinates] => -67.796631,45.989329/-67.791138,47.073863/-67.884521,47.115/-67.944946,47.185979/-67.999878,47.256864/-68.076782,47.271775/-68.230591,47.379754/-68.373413,47.338823/-68.395386,47.286682/-68.505249,47.268048/-68.724976,47.223299/-68.911743,47.185979/-69.054565,47.23076/-69.060059,47.320207/-69.0271,47.398349/-69.21936,47.45038/-69.505005,47.204642/-69.99939,46.687131/-70.048828,46.411352/-70.164185,46.354511/-70.20813,46.297611/-70.224609,46.240652/-70.257568,46.198844/-70.235596,46.157005/-70.3125,46.000778/-70.230103,45.962606/-70.224609,45.886185/-70.394897,45.79434/-70.350952,45.717686/-70.675049,45.556372/-70.675049,45.490946/-70.62561,45.444717/-70.576172,45.390735/-70.576172,45.356005/-70.72998,45.402307/-70.762939,45.394593/-70.801392,45.356005/-70.812378,45.232349/-70.894775,45.205263/-70.938721,45.286482/-71.004639,45.298075/-71.048584,45.263289/-71.021118,44.37295/-71.007385,43.992815/-70.977173,43.949327/-71.49353,43.886016/-71.647339,43.814711/-71.685791,43.743321/-71.663818,43.71355/-71.636353,43.691708/-71.639099,43.651975/-71.641846,43.622159/-71.625366,43.586359/-71.61438,43.540585/-71.60614,43.502745/-71.586914,43.480826/-71.562195,43.436966/-71.570435,43.409038/-71.570435,43.39507/-71.603394,43.361132/-71.589661,43.32318/-71.567688,43.269206/-71.534729,43.229195/-71.523743,43.193163/-71.507263,43.161116/-71.482544,43.139074/-71.463318,43.088949/-71.463318,43.056848/-71.446838,43.032761/-71.430359,43.008664/-71.408386,42.966472/-71.367188,42.910172/-71.342468,42.875964/-71.290283,42.817566/-71.243591,42.779275/-71.205139,42.751046/-71.213379,42.712714/-71.199646,42.674359/-71.114502,42.69253/-71.144714,42.751046/-71.089783,42.79137/-71.034851,42.793385/-70.922241,42.839724/-70.861816,42.849793/-70.823364,42.857846/-70.639343,43.080925/-70.556946,43.203174/-70.534973,43.2932/-70.345459,43.432977/-70.342712,43.49079/-70.186157,43.524655/-70.139465,43.58238/-70.210876,43.638063/-70.188904,43.687736/-70.092773,43.719505/-70.037842,43.786958/-69.944458,43.798854/-69.867554,43.739352/-69.752197,43.731414/-69.384155,43.826601/-69.147949,43.941417/-69.0271,44.083639/-69.038086,44.150681/-69.005127,44.221584/-68.950195,44.339565/-68.90625,44.437702/-68.746948,44.292401/-68.741455,44.221584/-68.543701,44.162504/-68.334961,44.182204/-68.115234,44.253069/-67.884521,44.370987/-67.714233,44.445546/-67.329712,44.52001/-67.126465,44.637391/-66.906738,44.746733/-66.906738,44.808147/-66.936951,44.82763/-66.983643,44.833474/-66.979523,44.855869/-66.968536,44.905496/-66.996002,44.933696/-67.155304,45.157832/-67.206116,45.173324/-67.232208,45.166547/-67.273407,45.191716/-67.29538,45.167515/-67.2995,45.153959/-67.311859,45.134586/-67.342072,45.125867/-67.38739,45.147179/-67.397003,45.163642/-67.39975,45.185909/-67.425842,45.223644/-67.446442,45.249755/-67.471161,45.272954/-67.479401,45.291313/-67.456055,45.304837/-67.451935,45.328013/-67.428589,45.368549/-67.420349,45.38109/-67.446442,45.41484/-67.472534,45.426407/-67.478027,45.444717/-67.489014,45.471688/-67.509613,45.489983/-67.484894,45.490946/-67.469788,45.498647/-67.464294,45.506347/-67.431335,45.504422/-67.413483,45.507309/-67.445068,45.598666/-67.476654,45.60347/-67.49176,45.602509/-67.501373,45.590978/-67.564545,45.595783/-67.615356,45.611156/-67.637329,45.625563/-67.646942,45.614037/-67.714233,45.678361/-67.733459,45.691792/-67.72522,45.661087/-67.807617,45.675482/-67.806244,45.800084/-67.749939,45.824014/-67.807617,45.870888/-67.798004,45.893831/-67.752686,45.910078/-67.765045,45.929185/-67.774658,45.944466/-67.784271,45.99887/-67.796631,45.989329/
            [region_name] => Lincoln, ME
            [region_edited] => 1
            [canada] => 0
            [center_lat] => 45.3622432
            [center_lng] => -68.504716
            [centered] => 1
            [distanced] => 1
        )
        */
# Build GeoJSON feature collection array
$geojson = array(
    'type'      => 'FeatureCollection',
    'features'  => array()
 );
 


 # Loop through rows to build feature arrays
 foreach ($reg as $row) {

    
    $properties = array("region_id" => $row['region_id'],
                        "region_name" => $row['region_name'],
                        "center_lat" => $row['center_lat'],
                        "center_lng" => $row['center_lng']
 );

 $poly = explode("/",$row['coordinates']);
                    array_pop($poly);

 $coordenadas = [];

foreach($poly as $coord) {
                        $p = explode(",",$coord);
                        $lat = $p[1];
                        $lng = $p[0];
                  
                        

                        $coordenadas[] = [$lng,$lat];
                    }
 

     $feature = array(
          'type' => 'Feature',
          'geometry' => array('type' => 'Polygon',
           'coordinates' => [$coordenadas] ),
          'properties' => $properties
     );
     # Add feature arrays to feature collection array
     array_push($geojson['features'], $feature);
 }
 
 header('Content-type: application/json');
 echo json_encode($geojson, JSON_NUMERIC_CHECK);