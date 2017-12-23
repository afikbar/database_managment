<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>TedTalks DB</title>
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
    echo "connected to DB<br>"; //debug
    echo $_FILES[csv][error]."<br>";
    echo $_FILES[csv][name]."<br>";
    echo $_FILES[csv][tmp_name]."<br>";
    $file = $_FILES[csv][tmp_name];
    echo "Importing file: ";
    echo $file."<br>";
    echo "file($_FILES[csv][tmp_name])";
    echo "<br>";
    $csvAsArray = array_map('str_getcsv', file($_FILES[csv][tmp_name]));
    echo "$csvAsArray";
    $header = array_shift($csvAsArray);
    $csv = array();
    echo "before CSV create<br>";
//    if (($handle = fopen($file, "r")) !== FALSE) {
//        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//            $sql = "INSERT INTO Ted(name, main_speaker, description, event, languages, speaker_occupation, url, duration, comments, views)
//            VALUES  ('" . addslashes($data[7]) . "',
//                     '" . addslashes($data[6]) . "',
//                     '" . addslashes($data[1]) . "',
//                     '" . addslashes($data[3]) . "',
//                     '" . addslashes($data[5]) . "',
//                     '" . addslashes($data[12]) . "',
//                     '" . addslashes($data[15]) . "',
//                     '" . addslashes($data[2]) . "',
//                     '" . addslashes($data[0]) . "',
//                     '" . addslashes($data[16]) . "');
//             ";
//            sqlsrv_query($conn, $sql);
//        }
//        fclose($handle);
//    }

    foreach ($csvAsArray as $row) {
        echo "$row<br>";
        $csv[] = array_combine($header, $row);
    }
    echo "$csv";
    foreach ($csv as $row) {
        $sql = "INSERT INTO Ted(name, main_speaker, description, event, languages,
                                speaker_occupation, url, duration, comments, views)
                VALUES ('".addslashes($row['name'])."',
                        '".addslashes($row['main_speaker'])."',
                        '".addslashes($row['description'])."',
                        '".addslashes($row['event'])."',
                        '".addslashes($row['languages'])."',
                        '".addslashes($row['speaker_occupation'])."',
                        '".addslashes($row['url'])."',
                        '".addslashes($row['duration'])."',
                        '".addslashes($row['comments'])."',
                        '".addslashes($row['views'])."');";
        sqlsrv_query($conn, $sql);
    }
}
?>
<div class="card" style="text-align: left; width: auto">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <input name="csv" type="file" id="csv"/>
        <br><br>
        <input type="submit" name="submit" value="Submit"/>
    </form>
</div>
</body>
</html>
