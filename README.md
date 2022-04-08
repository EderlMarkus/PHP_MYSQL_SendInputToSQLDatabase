# Simple Input to SQL
This is a little demonstration of how to send Data from an Website to your SQL Database with PHP.

## Installing

Download the 'PostHandler.php', save it in your Directory and import it with the Require-Function:

```
require_once 'PostHandler.php';

```

## Usage

First create a connection to your SQL-Database with the 'connectToMySQL' Function:
(in this example its a local database created with XAMPP)

### Connection to your SQL-Database
```
$FormHandler = new FormHandler('localhost', 'root', 'testdb', '');
```

### Creating a new Table
You can create a new Table like so:
```
$table = $FormHandler->createNewSQLTable("newtable");
```
The Function 'createNewSQLTable' will return the tablename and can be stored an a variable for later usage.

### Validate Input-Data
You can validate your data with the Function 'test_input' (as shown here: https://www.w3schools.com/php/php_form_validation.asp/) 

```
$testedInput = $FormHandler->test_input($_POST['yourinput']);
```
### Using prepared statement
Because why wouldn't you?
```
$sql = "INSERT INTO " . $table . " (User, data) VALUES (?,?)";
$stmt = $databaseconnection->prepare($sql);
$stmt->bind_param("ss", $user, $data);
return $stmt->execute();
```

## Live-Demo:
https://edma.at/PHP_Database/