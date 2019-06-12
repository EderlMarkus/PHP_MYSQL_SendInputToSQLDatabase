<?php

class FormHandler
{

    private $connection;

    /**
     * Constructor: Requires host-, database- & username as well as password of the SQL-database you want to write in.
     */
    function __construct($host, $user,  $db, $pass) {
        $this->connection = new mysqli($host, $user, $pass, $db) or die('Unable to connect');
    }

    /**
     * Testing input to make sure no harmful code can be pushed. Requries a String as Parameter and returns the String after checking.
     */
    public function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Adds niew Line to a Table in the Database. Returns boolean if successfull or not. Currently writes hardcoded
     * in the columns "user" and "data". 
     */
    public function addLineToTableInDatabase($table, $user, $data)
    {
        $sqlStatement = "INSERT INTO $table (User, data) VALUES (?, ?)";
        return $this->executePreparedStatement($sqlStatement, $user, $data);
    }

    /**
    * Prepare Statement because reasons (https://www.w3schools.com/php/php_mysql_prepared_statements.asp)
     */
    private function executePreparedStatement($statement, $user, $data){
        $sql = $this->connection->prepare($statement);
        $sql->bind_param("ss", $user, $data);
        return $sql->execute();
    }


    /**
     * Creates a new Table in the SQL Database with the Predefined COlumns "User", "data" and "Time"
     */
    public function createNewSQLTable($tablename)
    {
        $sql = "CREATE TABLE " . $tablename . " (data varchar(255), User varchar(255), Time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)";
        $query = $this->connection->query($sql);
        return $tablename;
    }

    /**
     * Converts the given SQL-Table to an Array and returns the array.
     */
    public function getTableAsArray($table)
    {
        $sql = "SELECT * FROM " . $table;
        $result = $this->connection->query($sql);
        $returnarray = [];
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($returnarray, $row);
            }
        }
        return $returnarray;
    }

    /**
     * Converts the given table to an HTML-Table and returns the table.
     */
    public function getTableAsHTMLTable($table)
    {
        $tableAsArray = $this->getTableAsArray($table);
        $returnHTML = "<table id='table'><tbody><tr><th>Message</th><th>User</th><th>Timestamp</th></tr>";

        for ($i = 0; $i < sizeof($tableAsArray); $i++) {
            $returnHTML .= "<tr>";
            for ($o = 0; $o < sizeof($tableAsArray[$i]) / 2; $o++) {
                $returnHTML .= "<td>" . $tableAsArray[$i][$o] . "</td>";
            }
            $returnHTML .= "</tr>";
        }

        $returnHTML .= "</tbody></table>";

        return $returnHTML;

    }

}
