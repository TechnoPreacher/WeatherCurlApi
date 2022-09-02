<!DOCTYPE html>

<head>
    <title></title>
    <script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>


<?php
require_once "Weather.php";
if (isset($_GET['lng'])) // Проверка существования переменной
{
    // Складываем значение полученной переменной с 10
    echo $_GET['lat'] .'****'.$_GET['lng'];


$x = new Weather();
$s=$x->allRates($_GET['lat'], $_GET['lng']);

echo $s;

}
$Lat = "";
$Lng = " ";
?>


<body class="mx-auto w-50">

<div
        class='hidden'
        data-lat='<?= $Lat ?>'
        data-lng='<?= $Lng ?>'
></div>


<div id="map" style="width:300px; height:300px"></div>
Координаты маркера: <div id="location">LatLng(54.98, 82.89)</div>
Вы кликнули в: <span id="clicked_element">никуда</span>
ajax: <span id="clicked_element2">ничего</span>
<script type="text/javascript">
    var locationInfo = document.getElementById('location');

    DG.then(function () {
        var map,
            lat,
        lng,
            marker,
            clickedElement = document.getElementById('clicked_element');
        clickedElement2 = document.getElementById('clicked_element2');

        map = DG.map('map', {
            center: [46.4775, 30.7326],
            zoom: 15
        });



        marker = DG.marker([46.477, 30.732], {
            draggable: true
        }).on('click', function() {
            clickedElement.innerHTML = 'маркер';

            var num = 5; // Значение, которое необходимо передать в PHP

            $.ajax({
                type: 'GET',              // Задаем метод передачи
                url: 't1.local?lat=' + lat +'&lng='+lng, // URL для передачи параметра
                success: function(data) {
                  //  alert(data); // Выводим результат на экран
                    clickedElement2.innerHTML = data;
                }
            });


        }).addTo(map).bindPopup('Обновлено :-)')

        marker.on('drag', function(e) {
             lat = e.target._latlng.lat.toFixed(3),
                lng = e.target._latlng.lng.toFixed(3);

            locationInfo.innerHTML = lat + ', ' + lng;

        });








    });



</script>





</body>
</html>