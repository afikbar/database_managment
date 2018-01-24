<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>Uber Heatmap</title>
</head>
<body>
<?php
// Connecting to the database
$server = "tcp:techniondbcourse01.database.windows.net,1433";
$user = "dbstudents";
$pass = "Qwerty12!";
$database = "dbstudents";
$c = array("Database" => $database, "UID" => $user, "PWD" => $pass);
sqlsrv_configure('WarningsReturnAsErrors', 0);
$conn = sqlsrv_connect($server, $c);
if ($conn === false) {
    echo "error";
    die(print_r(sqlsrv_errors(), true));
}
echo "connected to DB<br>"; //debug
?>
<form class="card" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" style="width: 50rem">
    <h1>Data visualization:</h1>
    <table border="0">
        <tr>
            <td>
                <select name="hour" required>
                    <option value="" disabled selected hidden>Hour</option>
                    <?php
                    foreach (range(1, 24) as $number) {
                        echo '<option value=' . $number . '>' . $number . '</option>';
                    }
                    ?>
                </select>
            </td>
            <td><label>
                    <input name="lat" type="number" size="25" step="any" required
                           min="-90" max="90" title="Latitude is a required field!"
                           placeholder="Latitude"
                    />
                </label></td>
            <td><label>
                    <input name="long" type="number" size="25" step="any" required
                           min="-180" max="180" title="Longitude is a required field!"
                           placeholder="Longitude"
                    />
                </label></td>
            <td><label>
                    <input name="radius" type="number" size="25" step="any" required
                           min="0" title="Radius is a required field!"
                           placeholder="Radius"
                    />
                </label></td>
        </tr>
        <tr>
            <td colspan="4">
                <button class="btn" type="submit" name="submit" value="submit">Submit</button>
            </td>
        </tr>
    </table>
</form>
<div class="card">
    <div id="googleMap" style="width:50rem;height:40rem;">
        <script>
            function myMap() {
                var qLat =  <?php echo json_encode($pLat); ?>;
                var qLng = <?php echo json_encode($pLong); ?>;
                var qRadius = <?php echo json_encode($radius); ?>;
                var qColor = <?php echo json_encode($color); ?>;
                var qPos = new google.maps.LatLng(40.720485, -74.000206);
                // var qPos = new google.maps.LatLng(qLat, qLng);
                var mapProp = {
                    center: qPos,
                    zoom: 10,
                };
                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                var qCircle = new google.maps.Circle({
                    center: qPos,
                    // radius: qRadius,
                    radius: 500,
                    strokeColor: "#0000FF",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    // fillColor: qColor,
                    fillColor: "#0000FF",
                    fillOpacity: 0.4
                })
                qCircle.setMap(map)

            }

            function loadScript() {
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCv6wuQJDE4QzG9Oy_FDXcOtuptY4Lksu8&callback=myMap";
                document.body.appendChild(script);
            }
        </script>
    </div>
    <?php
    if (isset($_POST["submit"])) {
        echo "user input<br>";
        $hour = $_POST['hour'];
        $pLat = $_POST['lat'];
        $pLong = $_POST['long'];
        $radius = $_POST['radius'];
        echo "before sql" . $pLat . "<br>";
        $sql = "SELECT count(car_id) AS carCnt
                    FROM small_drive Details
                    WHERE (datepart(HOUR, Details.Ctime) = 19) AND
                          ((1.60934 * 2 * 3961 * asin(sqrt(POWER((sin(radians((" . $pLat . " - Details.location_lat) / 2))) , 2) +
                                       cos(radians(Details.location_lat)) * cos(radians(" . $pLat . ")) *
                                       POWER((sin(radians((" . $pLong . " - Details.location_long) / 2))) , 2)))) <= " . $radius . ");";

        echo $sql . "<br>"; //debug
        $result = sqlsrv_query($conn, $sql);
        // In case of failure
        if (!$result) {
            die("Couldn't add the part specified.<br>");
        }
        $cnt = $result['carCnt'];
        if ($cnt <= 20) {
            $color = "#0000FF";
        } elseif ($cnt <= 50) {
            $color = "#FF1493";
        } else {
            $color = "FF0000";
        }
        echo "before load<br>";
        echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv6wuQJDE4QzG9Oy_FDXcOtuptY4Lksu8&callback=myMap"></script>';
    }
    ?>
<!--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCv6wuQJDE4QzG9Oy_FDXcOtuptY4Lksu8&callback=myMap"></script>-->
</div>
</body>
</html>