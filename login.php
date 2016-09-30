<?php

session_start();

if (isset($_SESSION['uid'])) {
   echo 'You are already logged! You will be redirected to the secret page in 2 seconds...';
   header('Refresh: 2; URL = secret.php');
}

?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Log ind</title>
</head>
<body>
    <?php
        $resultat = '';
        // her tjekkes om formen er korrekt
        if (isset($_POST['login'])) {
            $username = filter_input(INPUT_POST, 'Brugernavn');
            $password = filter_input(INPUT_POST, 'Password');
            // her tjekkes om alt er korrekt
            if (empty($username) || is_string($username) == false) {
                die('Skriv venligst et korrekt brugernavn!');
            }
            if (empty($password)) {
                die('Skriv venligst et password!');
            }
            require_once('dbcon.php');
            // hvis brugeren har indtastet det korrekte, så hentes det fra databasen
            $getUser = 'SELECT id, Navn, password, email FROM users WHERE Brugernavn = ?';
            $statement = $connection->prepare($getUser);
            $statement->bind_param('s', $username);
            $statement->execute();
            $statement->bind_result($uid, $name, $hashedPassword, $email);
            $statement->fetch();
            $statement->close();
            // tjekker om brugernavnet findes i databasen
            if (!$uid) {
                die('Dette brugernavn "'. $username .'" eksisterer ikke!');
            }
            // hvis brugeren bliver fundet, så finder databasen passwordet
            if (!password_verify($password, $hashedPassword)) {
                die('Dette brugernavn "'. $username .'" findes, men passwordet er forkert!');
            }
            // Hvis det hele spiller, så bliver brugeren logget ind
            $_SESSION['uid'] = $uid;
            $resultat = 'Hej '. $name .'! Du er nu logget ind!';
            $connection->close();
        }
    ?>
    <p><?php echo $resultat; ?></p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"> 
        <input type="text" name="Brugernavn" placeholder="Brugernavn">
        <input type="text" name="Password" placeholder="Password">
        <input type="submit" name="login" value="log ind">
    </form>
    <ul>
        <li><a href='secret.php'>Gå til den hemmelige side</a></li>
        <li><a href='index.php'>Gå tilbage til forsiden</a></li>
    </ul>
</body>
</html>
