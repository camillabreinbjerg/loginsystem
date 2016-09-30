<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Muligheden for at oprette bruger</title>
</head>
<body>
    <?php
        $resultat = '';
        // Her tjekkes der om formen er indsendt
        if (isset($_POST['opretbruger'])) {
            // her valideres formen, fx om der er @ i e-mailen (http://php.net/manual/en/filter.filters.validate.php)
            $name = filter_input(INPUT_POST, 'Navn');
            $username = filter_input(INPUT_POST, 'Brugernavn');
            $password = filter_input(INPUT_POST, 'Password');
            $email = filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL);
            // nedestående tjekker om der skulle være nogle fejl i formen
            // die betyder at der er en fejl og så kommer teksten frem fx 'please enter a valid name'
            if (empty($name) || is_string($name) == false) {
                die('Skriv venligst et navn!');
            }
            if (empty($username) || is_string($username) == false) {
                die('Skriv venligst et brugernavn!');
            }
            if (empty($password)) {
                die('Skriv venligst et password!');
            }
            if (empty($email) || $email == false) {
                die('Skriv venligst en email!');
            }
            // Hvis formen er indtastet rigtigt, så hash'es passwordet inde i databasen
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Nu indsættes brugeren i min database og det sker gennem dbcon.php
            require_once('dbcon.php');
            $insertNewUser = 'INSERT INTO users (Navn, Brugernavn, Password, Email) VALUES (?,?,?,?)';
            $statement = $connection->prepare($insertNewUser);
            $statement->bind_param('ssss', $name, $username, $hashedPassword, $email);
            $statement->execute();
            // her tjekkes om brugeren er kommet ind i databasen
            // hvis ikke, så er det fordi brugeren allerede eksisterer i databasen
            if ($statement->affected_rows > 0) {
                $resultat = 'Success! Tak '. $name . ' for din oprettelse!';
            } else {
                $resultat = 'Dette brugernavn "'. $username .'" eksisterer allerede! Vælg venligst et andet!';
            }
            
            $statement->close();
            $connection->close();

        }
    ?>
    <p><?php echo $resultat; ?></p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>"> 
        <p><input type="text" name="Navn" placeholder="Navn"></p>
        <p><input type="text" name="Brugernavn" placeholder="Brugernavn"></p>
        <p><input type="text" name="Password" placeholder="Password"></p>
        <p><input type="text" name="Email" placeholder="Email"></p>
        <input type="submit" name="opretbruger" value="Opret bruger">
    </form>
    <ul>
        <li><a href='index.php'>Gå tilbage til forsiden</a></li>
    </ul>
</body>
</html>
