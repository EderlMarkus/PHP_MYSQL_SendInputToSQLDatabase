<?php
require_once 'PostHandler.php';
$FormHandler = new FormHandler;
$connection = $FormHandler->connectToMySQL('localhost', 'root', '', 'testdb');
$table = $FormHandler->createNewSQLTable("newtable", $connection);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Input Database</title>
</head>
<body>
    <form method="post">
        <p>Your Name:</p>
        <input name="User" type="text"></input>
        <p>Your Message:</p>
        <input name="text" type="text"></input>
        <p>
        <input type="submit" name="submit" value="Add Data">
    </form>
</body>
</html>


<?php

if (isset($_POST["text"]) && isset($_POST["User"])) {

    if (empty($_POST["User"]) && empty($_POST["text"])) {
        echo "Please enter your Name and your Message";
    } else if (empty($_POST["User"])) {
        echo "Please enter your Name";
    } else if (empty($_POST["text"])) {
        echo "Please enter your Message";
    } else {
        $testedMessage = $FormHandler->test_input($_POST['text']);
        $testedUser = $FormHandler->test_input($_POST['User']);
        $FormHandler->addLineToTableInDatabase($table, $testedUser, $testedMessage, $connection);
        echo ( $FormHandler->getTable("newtable", $connection));
    }
}

?>