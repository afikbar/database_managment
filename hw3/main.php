<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>TedTalks DB</title>
</head>
<body>
<h1>Welcome to TedTalks Information System!</h1>
<h2> Here is our generic descriptions, WOW!</h2>
<div class="card" style="text-align:center;">
    <img src="ted.gif" style="width:600px;border-radius: 8px">
</div>
<br>
<br>
<div class="card datagrid">
    <?php
    $server = "techniondbcourse01.database.windows.net,1433";
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
    //connection established
    $results_per_page = 10;
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    };
    $start_from = ($page - 1) * $results_per_page;
    $sql = "SELECT name,comments,views,duration FROM Ted ORDER BY CURRENT_TIMESTAMP
            OFFSET $start_from ROWS FETCH NEXT  $results_per_page ROWS ONLY ";
    $rs_result = sqlsrv_query($conn, $sql);
    ?>
    <table>
        <thead>
        <tr>
            <th>Talk's Title</th>
            <th>Popularity</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="2">
                <div id="paging">
                    <ul>
                        <?php
                        $sql = "SELECT COUNT(name) AS total FROM Ted";
                        $result = sqlsrv_query($conn, $sql);
                        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                        $total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
                        if ($page!=1){
                            echo "<li><a href='main.php?page=".($page-1)."'><span>Previous</span></a></li>";
                        };
                        if ($page!=$total_pages) {
                            echo "<li><a href='main.php?page=" . ($page + 1)."'><span>Next</span></a></li>";
                        };
//                        for ($i = 1; $i <= $total_pages; $i++) {  // print links for all pages
//                            echo "<li><a href='main.php?page=" . $i . "'";
//                            if ($i == $page) echo " class='active'";
//                            echo ">" . $i . "</a></li>";
//                        };
                        ?>
                        <!--                        <li><a href="#"><span>Previous</span></a></li>-->
                        <!--                        <li><a href="#" class="active"><span>1</span></a></li>-->
                        <!--                        <li><a href="#"><span>2</span></a></li>-->
                        <!--                        <li><a href="#"><span>3</span></a></li>-->
                        <!--                        <li><a href="#"><span>4</span></a></li>-->
                        <!--                        <li><a href="#"><span>5</span></a></li>-->
                        <!--                        <li><a href="#"><span>Next</span></a></li>-->
                    </ul>
                </div>
        </tr>
        </tfoot>
        <tbody>
        <?php
        $i = 1;
        while ($row = sqlsrv_fetch_array($rs_result, SQLSRV_FETCH_ASSOC)) {
            if ($i % 2 == 0) {
                $cls = 'class="alt"';
            } else {
                $cls = '';
            }
            $popularity = (10 * $row['comments'] + 0.1 * $row['views']) / $row['duration'];
            $popularity = round($popularity,4);
            echo "<tr " .$cls . "><td>" . $row['name'] . "</td><td align='center'>" . $popularity . "</td></tr>";
            $i++;
        }
        ?>
        </tbody>
    </table>
</div>


</body>
</html>


