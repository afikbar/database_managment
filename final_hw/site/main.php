<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <title>UBER NYC</title>
</head>
<body>
<!--<h1><img src="images/uber.svg" style="width:50rem;border-radius: 8px"></h1>-->

<!--<h2>View and manage previous TedTalks</h2>-->
<div class="card" style="text-align:center;flex-direction: row;">
    <img class="nyc_elem" src="images/new-york-picture-full.jpg">
    <img class="uber_elem" src="images/uber.svg" style="" alt="UBER NYC">
</div>
<br>
<br>
    <img src="images/load2.gif" id="loading"/>
    <iframe name="tableFrame" src="table.php" style="width: 100%; height: 100%;"
            onload="document.getElementById('loading').style.display='none';"></iframe>


</body>
</html>


