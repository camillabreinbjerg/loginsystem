<?php

session_start();
// hvis brugeren er logget på, kan personen se den hemmelige tekst
if (!isset($_SESSION['uid'])) {
    echo 'Du er ikke logget på og kan derfor ikke se den hemmelighed tekst. Du vil blive sendt tilbage til log ind siden om 2 sekunder..';
    header('Refresh: 2; URL = login.php');
    die;
}

?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Log ind - Hemmelig side</title>
</head>
<body>
    <p>Her er den hemmelige tekst, fordi du er logget ind: <strong>"Du ser godt ud i dag!"</strong> :)</p>
    <ul>
        <li><a href='logout.php'>Log ud</li>
    </ul>

</body>
</html> 
