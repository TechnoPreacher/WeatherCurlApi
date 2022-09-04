<!DOCTYPE html>

<head>
    <title></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>
</head>

<?php
require_once "Weather.php";
require_once "GeoGoogle.php";

$lat = 46.477;
$lng = 30.732;

//если нет гет-параметров - значит не было выбора точки - не приходил AJAX-запрос
//а раз не приходил - то просто выдаём тело без данных

if (!isset($_GET['lng'])) {
    ?>

    <body class="mx-auto w-50">

    <div class='hidden'
         data-lat='<?= $lat ?>'
         data-lng='<?= $lng ?>'
    >
    </div>

    <div class="w-50 mx-auto" id="map" style="width:400px; height:400px"></div>
    <div class="w-50 mx-auto" id="location">Координаты маркера:<?= $lat ?> , <?= $lng ?></div>

    <span class='hidden' id="clicked_element"></span>

    <script type="text/javascript">
        var locationInfo = document.getElementById('location');
        DG.then(function () {
            var map,
                lat,
                lng,
                marker,
                clickedElement = document.getElementById('clicked_element');
            map = DG.map('map', {
                center: [46.4775, 30.7326],
                zoom: 15
            });
            marker = DG.marker([<?= $lat ?>, <?= $lng ?>], {draggable: true}).on('click', function (x) {
                lat = x.target._latlng.lat.toFixed(3);
                lng = x.target._latlng.lng.toFixed(3);
                $.ajax({
                    type: 'GET', url: 't1.local?lat=' + lat + '&lng=' + lng,
                    success: function (data) {
                        clickedElement.innerHTML = data;
                    }
                });
            })
            marker.on('drag', function (e) {
                lat = e.target._latlng.lat.toFixed(3);
                lng = e.target._latlng.lng.toFixed(3);
                locationInfo.innerHTML = 'GPS: ' + lat + ', ' + lng;
            }).addTo(map).bindPopup(':-)')
        });
    </script>
    </body>

<?php } else {

    $weather = new Weather();
    $Rates = $weather->prepareUrl($_GET['lat'], $_GET['lng']);
    $temp = $weather->getTemp();
    $hum = $weather->getHum();

    $geo = new GeoGoogle();
    $data = $geo->prepareUrl($_GET['lat'], $_GET['lng']);
    $city = $geo->getCity() . ", " . $geo->getCountry();

    ?>

    <div class="w-50 mx-auto"> Локация: <?= $city ?? "" ?></div>
    <div class="w-50 mx-auto"> Температура: <?= $temp ?? "" ?></div>
    <div class="w-50 mx-auto"> Влажность: <?= $hum ?? "" ?></div>

<?php } ?>

</html>