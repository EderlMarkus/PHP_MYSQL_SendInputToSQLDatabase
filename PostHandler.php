<?php

class FormHandler
{
    public function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function addLineToTableInDatabase($table, $user, $data, $databaseconnection)
    {
        $sql = "INSERT INTO " . $table . " (User, data) VALUES ('" . $user . "','" . $data . "') ";
        return $databaseconnection->query($sql);
    }

    public function connectToMySQL($host, $user, $pass, $db)
    {
        $db = new mysqli($host, $user, $pass, $db) or die('Unable to connect');
        return $db;
    }

    public function createNewSQLTable($tablename, $databaseconnection)
    {
        $sql = "CREATE TABLE " . $tablename . " (data varchar(255), User varchar(255), Time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)";
        $query = $databaseconnection->query($sql);
        return $tablename;
    }

    public function getTableAsArray($table, $databaseconnection)
    {
        $sql = "SELECT * FROM " . $table;
        $result = $databaseconnection->query($sql);
        $returnarray = [];
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($returnarray, $row);
            }
        }
        return $returnarray;
    }

    public function getTableAsHTMLTable($table, $databaseconnection)
    {
        $tableAsArray = $this->getTableAsArray($table, $databaseconnection);
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
