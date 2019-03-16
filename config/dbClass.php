<?php
/**
 * Created by PhpStorm.
 * User: AWT-KRIPAL
 * Date: 3/16/2019
 * Time: 2:54 PM
 */

class dbClass
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "catalogue";

    public $connection;

    // get the database connection
    public function getConnection(){

        $this->connection = null;

        try{
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password);
            $this->connection->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Error: " . $exception->getMessage();
        }

        return $this->connection;
    }
}