<?php
class Database
{
    private $servername = "localhost";
    private $username = "timonun179_0968794";
    private $password = "725ceff8";
    private $dbname  = "timonun179_leenheer";

    public function connect()
    {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) 
        {
            die("Connection failed: " . $conn->connect_error);
        } 
        else
        {
            return $conn;
        }
    }

    public function executeQuery($query)
    {
        return $this->connect()->query($query);
    }
}
?>