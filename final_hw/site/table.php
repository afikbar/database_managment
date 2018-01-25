<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <base target="tableFrame">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>Table</title>
</head>

<div class="card datagrid">
    <h2>Drives around POI in NYC:</h2>
    <?php
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
    //connection established
    $results_per_page = 10;
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    };
    $start_from = ($page - 1) * $results_per_page;
    $sql = "SELECT * FROM POI_NYC ORDER BY Hour ASC";
//    $sql = "SELECT name,url,(10*comments+0.1*views)/duration AS popularity FROM Ted ORDER BY CURRENT_TIMESTAMP
//            OFFSET $start_from ROWS FETCH NEXT  $results_per_page ROWS ONLY ";
    $rs_result = sqlsrv_query($conn, $sql);
    ?>
    <table>
        <thead>
        <tr>
            <th>Hour</th>
            <th>Central Park</th>
            <th>Times Sqaure</th>
            <th>Empire States Building</th>
            <th>Chinatown</th>
        </tr>
        </thead>
<!--        <tfoot>-->
<!--        <tr>-->
<!--            <td colspan="2" style="background: #B2EBF2;">-->
<!--                <div id="paging">-->
<!--                    --><?php
//                    $sql = "SELECT COUNT(name) AS total FROM Ted";
//                    $result = sqlsrv_query($conn, $sql);
//                    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
//                    $total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
//                    echo "<label style='float: left;'>Showing page {$page} out
//                        of {$total_pages} </label>";
//                    echo "<ul>";
//
//                    if ($page > 1) {
//                        echo "<li><a href='table.php?page=", ($page - 1), "'><span>Previous</span></a></li>";
//                    };
//                    if ($page < $total_pages) {
//                        echo "<li><a href='table.php?page=", ($page + 1), "'><span>Next</span></a></li>";
//                    };
//                    ?>
<!--                    </ul>-->
<!---->
<!--                </div>-->
<!--        </tr>-->
<!--        </tfoot>-->
        <tbody>
        <?php
        $i = 1;
        while ($row = sqlsrv_fetch_array($rs_result, SQLSRV_FETCH_ASSOC)) {
            if ($i % 2 == 0) {
                $cls = 'class="alt"';
            } else {
                $cls = '';
            }
            $hour = $row['Hour'];
            $cp = $row['CentralPark'];
            $ts = $row['TimesSquare'];
            $esb = $row['EmpireStatesBLD'];
            $cht = $row['Chinatown'];

            echo "<tr {$cls}><td align='center'>{$hour}</td>
                             <td align='center'>{$cp}</td><td align='center'>{$ts}</td>
                             <td align='center'>{$esb}</td><td align='center'>{$cht}</td></tr>";
            $i++;
        }
        ?>
        </tbody>
    </table>
    <small>*Each POI Area is 500 meters</small>
</div>