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
if (isset($_POST["submit"])) {
    echo "user input<br>";
    $pLat = $_POST['lat'];
    $pLong = $_POST['long'];
    $radius = $_POST['radius'];
    echo "before sql<br>";
    $sql = "SELECT count(car_id)
            FROM small_drive Details 
            WHERE (1.60934 * 2 * 3961 * asin(sqrt((sin(radians((:pLat - Details.location_lat) / 2))) ^ 2 +
                                     cos(radians(Details.location_lat)) * cos(radians(:pLat)) *
                                     (sin(radians((:pLong - Details.location_long) / 2))) ^ 2)) <= :radius);";
    echo $sql."<br>"; //debug
    $result = sqlsrv_query($conn, $sql);
    // In case of failure
    if (!$result) {
        die("Couldn't add the part specified.<br>");
    }
    echo '<script type="text/javascript">','loadScript();','</script>';
}
?>
<form class="card" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" style="width: 50rem">
    <h1>Data visualization:</h1>
    <table border="0">
        <tr>
            <td>
                <select required>
                    <option value="" disabled selected hidden>Hour</option>
                    <?php
                    foreach (range(1, 24) as $number) {
                        echo '<option value=' . $number . '>' . $number . '</option>';
                    }
                    ?>
                </select>
            </td>
            <td><label>
                    <input name="long" type="number" size="25" step="any" required
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
                <button class="btn" type="submit">Submit</button>
            </td>
        </tr>
    </table>
</form>
<div class="card">
    <div id="googleMap" style="width:50rem;height:40rem;">
        <script>
            function myMap() {
                var qLat =  <?php echo json_encode($pLat); ?>;
                var qLng= <?php echo json_encode($pLong); ?>;
                var qRadius = <?php echo json_encode($radius); ?>;
                var qColor = <?php echo json_encode($color); ?>;
                // var qPos =  new google.maps.LatLng(40.720485, -74.000206);
                var qPos =  new google.maps.LatLng(qLat,qLng);
                var mapProp = {
                    center: qPos,
                    zoom: 10,
                };
                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                var qCircle = new google.maps.Circle({
                    center: qPos,
                    radius: qRadius,
                    strokeColor: "#0000FF",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: qColor,
                    fillOpacity: 0.4
                })
                qCircle.setMap(map)

            }
            function loadScript() {
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDXeYz8-_twayJlyygdP3WIZc4SO1AVYSE&callback=myMap";
                document.body.appendChild(script);
            }
        </script>
    </div>

<!--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXeYz8-_twayJlyygdP3WIZc4SO1AVYSE&callback=myMap"></script>-->
</div>
</body>
</html>