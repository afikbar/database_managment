<html>
<head>
<style>
th, td {
    padding: 10px;
}
</style>
</head>
<body>
<h1>Add Parts</h1>
<?php
	// Connecting to the database
    $server = "tcp:techniondbcourse01.database.windows.net,1433";
    $user = "afikbar";
    $pass = "Qwerty12!";
    $database = "afikbar";
    $c = array("Database" => $database, "UID" => $user, "PWD" => $pass);
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect($server, $c);
    if($conn === false)
    {
        echo "error";
        die(print_r(sqlsrv_errors(), true));
    }
	//echo "connected to DB"; //debug
	// In case of success
		if (isset($_POST["submit"]))
		{
		// First insert data to the Parts table
		$sql = "INSERT INTO Parts(pid,pname,color) VALUES($_POST[PID],'$_POST[PNAME]', '$_POST[COLOR]')";
		//echo $sql."<br>"; //debug
		/* Example:  $sql = "INSERT INTO Parts(pid,pname,color) VALUES($_POST[PID], ', 'Red');"; */
		$result = sqlsrv_query($conn, $sql);
		// In case of failure
		if (!$result)
		{
			die("Couldn't add the part specified.<br>");
		}
		// Now insert data to the Catalog table
		$sql = "INSERT INTO Catalog(sid,pid,cost) VALUES($_POST[SUPID],$_POST[PID], $_POST[PRICE])";
		// echo $sql."<br>"; //debug
		$result = sqlsrv_query($conn, $sql);
		// In case of failure
		if (!$result) {
			die("Couldn't add the part to the catalog.<br>");
		}
		echo "The details have been added to the database.<br><br>";
		}
?>

<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
	<select name="SUPID">
		<option value="">Choose Supplier...</option>
		<?php
			$sql = "SELECT sid,sname FROM Suppliers;";
			$result = sqlsrv_query($conn, $sql);
			while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
			{
				echo'<option value='.$row['sid'].'>'.$row['sname'].'</option>'; //debug
				//your code here
			}
		 ?>
	</select>
	<h2>Part Details</h2>
	<table border="0">
		<tr>
			<td>ID</td>
			<td><input name="PID" type="text" size="10"></td>
		</tr>
		<tr>
			<td>Name</td>
			<td><input name="PNAME" type="text" size="20"></td>
		</tr>
		<tr>
			<td>Color</td>
			<td><input name="COLOR" type="text" size="10"></td>
		</tr>
		<tr>
			<td>Price</td>
			<td><input name="PRICE" type="text" size="5"></td>
		</tr>
		<tr>
			<td colspan="2"><br><input name="submit" type="submit" value="Send"></td>
		</tr>

	</table>
</form>
</body>
</html>


