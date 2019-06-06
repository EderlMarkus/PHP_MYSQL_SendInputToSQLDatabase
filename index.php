<?php
session_start();
require_once 'PostHandler.php';
$FormHandler = new FormHandler('localhost', 'root', 'testdb','');
$table = $FormHandler->createNewSQLTable("PHP_Database");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Input Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post" action="">
        <p class="headers">Your Name:</p>
        <input id="name" name="User" type="text"></input>
        <p class="headers">Your Message:</p>
        <input id="message" name="message" type="text"></input>
        <p>
        <input type="submit" id="submit" class="headers" name="submit" value="Add Data">
    </form>
</body>
</html>


<?php


/**
 * User-Managment: AutoFill of User-Field if User was already set */

 /**
  * setUser: Checks input, sets Session-Variable and fills out HTML Input Field with a JS.
  */
function setUser($user, $handler)
{
    echo "<script>console.log('hallo')</script>";
    $user = $handler->test_input($user);
    $_SESSION["User"] = $user;
    echo "<script>document.getElementById('name').value = '" . $user . "'</script>";
}

/**
 * Check if Session for Username is already set, if so call setuser
 */
if (isset($_SESSION["User"])) {
    setUser($_SESSION["User"], $FormHandler);
}

/**
 * Validation if the Input-Fields have been set, if so, call setuser, test input and add Line to Database.
 * if not echo the missing Data.
 */

if (isset($_POST["message"]) && isset($_POST["User"])) {
    if (empty($_POST["User"]) && empty($_POST["message"])) {
        echo "Please enter your Name and your Message";
    } else if (empty($_POST["User"])) {
        echo "Please enter your Name";
    } else if (empty($_POST["message"])) {
        setUser($_POST["User"], $FormHandler);
        echo "Please enter your Message";
    } else {
        setUser($_POST["User"], $FormHandler);
        $testedMessage = $FormHandler->test_input($_POST['message']);
        $testedUser = $FormHandler->test_input($_POST['User']);
        $FormHandler->addLineToTableInDatabase($table, $testedUser, $testedMessage);
        echo $FormHandler->getTableAsHTMLTable($table);
    }

}

?>