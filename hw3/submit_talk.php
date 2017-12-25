<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>
<?php
// Connecting to the database
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
//echo "connected to DB"; //debug
if (isset($_POST["submit"])) {
    $sql = "INSERT INTO Ted(name, main_speaker, description, event, languages,
                                speaker_occupation, url, duration, comments, views)
                VALUES ('" . addslashes($_POST[name]) . "',
                        '" . addslashes($_POST[main_speaker]) . "',
                        '" . addslashes($_POST[description]) . "',
                        '" . addslashes($_POST[event]) . "',
                        '" . addslashes($_POST[languages]) . "',
                        '" . addslashes($_POST[speaker_occupation]) . "',
                        '" . addslashes($_POST[url]) . "',
                        '" . addslashes($_POST[duration]) . "',
                        '" . addslashes($_POST[comments]) . "',
                        '" . addslashes($_POST[views]) . "');";
    //echo $sql."<br>"; //debug
    $result = sqlsrv_query($conn, $sql);
    // In case of failure
    if (!$result) {
        die("Couldn't add the part specified.<br>");
    }
    echo "The details have been added to the database.<br><br>";
}
?>
<form class="card" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
    <h1>Add a new TedTalk to the Databse:</h1>
    <table border="0">
        <tr>
            <td>Name:</td>
            <td><label>
                    <input name="name" type="text" size="25">
                </label></td>
        </tr>
        <tr>
            <td>Main Speaker:</td>
            <td><label>
                    <input name="main_speaker" type="text" size="20">
                </label></td>
        </tr>
        <tr>
            <td>Description:</td>
            <td><label>
                    <TEXTAREA name="description" rows="7" cols="25"
                    >Enter a brief description of the Talk.</TEXTAREA>
                </label></td>
        </tr>
        <tr>
            <td>Event</td>
            <td><label>
                    <input name="event" type="text" size="25">
                </label></td>
        </tr>
        <tr>
            <td>Number of languages:</td>
            <td><label>
                    <input name="languages" type="text" size="5">
                </label></td>
        </tr>
        <tr>
            <td>Speaker's Occupation:</td>
            <td><label>
                    <input name="speaker_occupation" type="text" size="25">
                </label></td>
        </tr>
        <tr>
            <td>Talk Link:</td>
            <td><label>
                    <input name="url" type="text" size="25">
                </label></td>
        </tr>
        <tr>
            <td>Talk's duration (Minutes)</td>
            <td><label>
                    <input name="duration" type="text" size="5">
                </label></td>
        </tr>
        <tr>
            <td>Talk's amount of comments:</td>
            <td><label>
                    <input name="comments" type="text" size="5">
                </label></td>
        </tr>
        <tr>
            <td>Views:</td>
            <td><label>
                    <input name="views" type="text" size="5">
                </label></td>
        </tr>
        <tr>
            <td colspan="2"><br><input name="submit" type="submit" value="Send"></td>
        </tr>

    </table>
</form>
</body>
</html>


