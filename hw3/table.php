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
    $sql = "SELECT name,url,(10*comments+0.1*views)/duration AS popularity FROM Ted ORDER BY CURRENT_TIMESTAMP
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
                    <?php
                    $sql = "SELECT COUNT(name) AS total FROM Ted";
                    $result = sqlsrv_query($conn, $sql);
                    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
                    $total_pages = ceil($row["total"] / $results_per_page); // calculate total pages with results
                    echo "<label style='float: left; background: transparent'>Showing page {$page} out
                        of {$total_pages} </label>";
                    echo "<ul>";

                        if ($page != 1) {
                            echo "<li><a href='table.php?page=", ($page - 1), "'><span>Previous</span></a></li>";
                        };
                        if ($page != $total_pages) {
                            echo "<li><a href='table.php?page=", ($page + 1), "'><span>Next</span></a></li>";
                        };
                        ?>
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
            $popularity = (float)$row['popularity'];
            $popularity = round($popularity, 4);
            echo "<tr {$cls}><td><a href={$row['url']}> {$row['name']} </a></td>
                             <td align='center'>{$popularity}</td></tr>";
            $i++;
        }
        ?>
        </tbody>
    </table>
</div>