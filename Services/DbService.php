<?php
namespace Services;

include 'EnvService.php';

class DbService
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $connection;

    // Constructor to initialize the database connection details
    public function __construct()
    {
        $this->host = 'localhost';
        $this->username = 'root';
        $this->password = '';
        $this->database = 'kgbdb';

        $this->connect();
    }

    // Connect to the database using mysqli
    private function connect()
    {
        $this->connection = new \mysqli($this->host, $this->username, $this->password, $this->database);

        // Check if the connection has failed
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    public function prepare($sql)
    {
        return $this->connection->prepare($sql);
    }
    // Query method to run SQL queries
    public function query($sql)
    {
        return $this->connection->query($sql);
    }

    public function execute($sql)
    {
        return $this->connection->query($sql);
    }

    // Close the database connection
    public function close()
    {
        $this->connection->close();
    }
}
