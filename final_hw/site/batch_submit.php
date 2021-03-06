<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>UBER-NYC DB batch submit</title>
</head>
<body>
<?php
if (isset($_POST["submit"])) {
// Connect to the database
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
    $file = $_FILES[csv][tmp_name];
    $file = fopen($file, 'r');
    $csvAsArray = [];
    //$csvAsArray = array_map(function($v){return str_getcsv($v, ",");}, file($file));
    // doesnt work since csv contain line-breaks. use instead this:
    while ($row = fgetcsv($file)) {
        $csvAsArray[] = $row;
    }

    fclose($file);
    $header = array_shift($csvAsArray);
    //print_r($header."<br>");
    $csv = array();
    foreach ($csvAsArray as $row) {
        $csv[] = array_combine($header, $row);
    }
    foreach ($csv as $row) {
        $sql = "INSERT INTO small_drive(car_id, location_lat, location_long, Ctime)
                VALUES ('" . addslashes($row['Base']) . "',
                        '" . addslashes($row['Lat']) . "',
                        '" . addslashes($row['Lon']) . "',
                        '" . addslashes($row['Date/Time']) . "');";
        $result = sqlsrv_query($conn, $sql);
        if (!$result) {
            echo("Couldn't add the drive specified.<br>");
            echo $sql."<br>";
        }
    }
    echo "<h2>Submitted!</h2>";
}
?>
<div class="card" style="text-align: left; width: auto">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <h2>Submit a .csv file:</h2>
        <table>
            <tr><td><label class="btn">
                        Select file
                    <input name="csv" type="file" id="csv" required/>
                </label></td>
            <td>
                    <input class="btn" type="submit" name="submit" value="Submit"/>
                </td></tr>
        </table>
    </form>
</div>
</body>
</html>
