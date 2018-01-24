<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
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
echo "connected to DB1"; //debug
if (isset($_POST["submit"])) {
    echo "inside";
    $sql = "INSERT INTO driver(driver_id, name, date_of_birth, address, hobby)
                VALUES ('" . addslashes($_POST['driver_id') . "',
                        '" . addslashes($_POST['name']) . "',
                        '" . addslashes($_POST['birthday']) . "',
                        '" . addslashes($_POST['address']) . "',
                        '" . addslashes($_POST['hobby']) . "');";
    echo $sql."<br>"; //debug
    $result = sqlsrv_query($conn, $sql);
    // In case of failure
    if (!$result) {
        echo "baaad";
        die("Couldn't add the part specified.<br>");
    }
    echo "The details have been added to the database.<br><br>";
}
?>
<form class="card" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
    <h1>Add a new driver to the Database:</h1>
    <table border="0">
        <tr>
            <td>Driver ID:</td>
            <td><label>
                    <input name="driver_id" type="text" size="25" required
                           title="Driver ID is a required field!"
                           placeholder="*" class="required"
                    />
                </label></td>
        </tr>
        <tr>
            <td>Driver name:</td>
            <td><label>
                    <input name="name" type="text" size="20"
                           placeholder="Driver's name"
                    />
                </label></td>
        </tr>
        <tr>
            <td>Driver's birthday</td>
            <td><label>
                    <input name="birthday" type="date" size="25">
                </label></td>
        </tr>
        <tr>
            <td>Driver's address:</td>
            <td><label>
                    <input name="address" type="text" size="25"
                            placeholder="Driver's address"
                    />
                </label></td>
        </tr>
        <tr>
            <td>Driver's main hobby:</td>
            <td><label>
                    <input name="hobby" type="text" size="25"
                           placeholder="Driver's main hobby"
                    />
                </label></td>
        </tr>
        <tr>
            <td><br>
                <button class="fab" type="reset"><p class="plus" style="font-size: 25px">&#10006</p></button>
            </td>
            <td align="right"><br>
                <button type="submit" name="submit" value="submit" class="fab"><p class="plus">+</p></button>
            </td>
        </tr>

    </table>
</form>
</body>
</html>


