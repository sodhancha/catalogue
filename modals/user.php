<?php
/**
 * Created by PhpStorm.
 * User: AWT-KRIPAL
 * Date: 3/17/2019
 * Time: 6:51 AM
 */

class User
{
    // database connection and table name
    private $conn;
    private $table_name = "users";

    // table columns
    public $id;
    public $name;
    public $email;
    public $password;
    public $created;
    public $modified;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function emailExists()
    {
        $query = "SELECT id, name, password
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";

        $stmt        = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num > 0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id       = $row['id'];
            $this->name     = $row['name'];
            $this->password = $row['password'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }
}