<?php
session_start();
require_once 'PostHandler.php';
$FormHandler = new FormHandler;
$connection = $FormHandler->connectToMySQL('localhost', 'root', '', 'testdb');
$table = $FormHandler->createNewSQLTable("newtable", $connection);

//AutoFill of User-Field if User was already set
function setUser($user){
    $FormHandler = new FormHandler;
    $user = $FormHandler->test_input($user);
    $_SESSION["User"] = $user;
    echo "<script>document.getElementById('name').value = '".$user."'</script>";
}

if (isset($_SESSSION["User"])){
    setUser($user);
}

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
    <form method="post">
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

if (isset($_POST["message"]) && isset($_POST["User"])) {
    if (empty($_POST["User"]) && empty($_POST["message"])) {
        echo "Please enter your Name and your Message";
    } else if (empty($_POST["User"])) {
        echo "Please enter your Name";
    } else if (empty($_POST["message"])) {
        setUser($_POST["User"]);
        echo "Please enter your Message";
    } else {
        setUser($_POST["User"]);
        $testedMessage = $FormHandler->test_input($_POST['message']);
        $testedUser = $FormHandler->test_input($_POST['User']);
        $FormHandler->addLineToTableInDatabase($table, $testedUser, $testedMessage, $connection);

        echo $FormHandler->getTableAsHTMLTable("newtable", $connection);
    }
}

?>