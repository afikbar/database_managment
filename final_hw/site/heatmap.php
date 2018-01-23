<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>Uber Heatmap</title>
</head>
<body>
<form class="card" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" style="width: 40rem">
    <h1>Data visualization:</h1>
    <table border="0">
        <tr>
            <td>
                <?php
                echo '<select name="hour">';
                foreach (range(1,24) as $number) {
                echo '<option value='.$number.'>'.$number.'</option>';
                }
                echo '</select>';
                ?>
            </td>
            <td><label>
                <input name="long" type="number" size="25" required
                       title="Latitude is a required field!"
                       placeholder="Latitude"
                />
            </label></td>
            <td><label>
                <input name="long" type="number" size="25" required
                       title="Longitude is a required field!"
                       placeholder="Longitude"
                />
            </label></td>
            <td><label>
                <input name="radius" type="number" size="25" required
                       title="Radius is a required field!"
                       placeholder="Radius"
                />
            </label></td>

        </tr>
    </table>
</form>
<div class="card">
    <div id="googleMap" style="width:40rem;height:400px;">
        <script>
            function myMap() {
                var mapProp = {
                    center: new google.maps.LatLng(40.720485, -74.000206),
                    zoom: 10,
                };
                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
            }
        </script>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXeYz8-_twayJlyygdP3WIZc4SO1AVYSE&callback=myMap"></script>
</div>
</body>
</html>