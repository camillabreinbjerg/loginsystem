<?php

session_start();

unset($_SESSION['uid']);

echo 'Du er nu logget ud og vil blive sendt tilbage til forsiden om 2 sekunder...';

header('Refresh: 2; URL = index.php');

?>
