<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>TedTalks DB batch submit</title>
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
    echo $header."<br>";
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
        echo $sql."<br>";
        $result = sqlsrv_query($conn, $sql);
        if (!$result) {
            die("Couldn't add the part specified.<br>");
        }
        echo "added successfuly<br>";
    }
    echo "<h2>Submitted!</h2>";
}
?>
<div class="card" style="text-align: left; width: auto">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <input name="csv" type="file" id="csv" required/>
        <br><br>
        <input type="submit" name="submit" value="Submit"/>
    </form>
</div>
</body>
</html>
