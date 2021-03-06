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
    $user = "afikbar";
    $pass = "Qwerty12!";
    $database = "afikbar";
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
    $csv = array();
    foreach ($csvAsArray as $row) {
        $csv[] = array_combine($header, $row);
    }
    foreach ($csv as $row) {
        $sql = "INSERT INTO Ted(name, main_speaker, description, event, languages,
                                speaker_occupation, url, duration, comments, views)
                VALUES ('" . addslashes($row[name]) . "',
                        '" . addslashes($row[main_speaker]) . "',
                        '" . addslashes($row[description]) . "',
                        '" . addslashes($row[event]) . "',
                        '" . addslashes($row[languages]) . "',
                        '" . addslashes($row[speaker_occupation]) . "',
                        '" . addslashes($row[url]) . "',
                        '" . addslashes($row[duration]) . "',
                        '" . addslashes($row[comments]) . "',
                        '" . addslashes($row[views]) . "');";
        sqlsrv_query($conn, $sql);
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
