<?php
/**
 * Created by PhpStorm.
 * User: AWT-KRIPAL
 * Date: 3/16/2019
 * Time: 7:39 PM
 */

class product
{
    // database connection and table name
    private $conn;
    private $table_name = "products";

    // table columns
    public $id;
    public $name;
    public $price;
    public $description;
    public $quantity;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //create
    public function create()
    {
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, price=:price, description=:description, quantity=:quantity, created=:created";

        $prods = $this->conn->prepare($query);

        // sanitize
        $this->name        = htmlspecialchars(strip_tags($this->name));
        $this->price       = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->quantity    = htmlspecialchars(strip_tags($this->quantity));
        $this->created     = htmlspecialchars(strip_tags($this->created));

        // bind values
        $prods->bindParam(":name", $this->name);
        $prods->bindParam(":price", $this->price);
        $prods->bindParam(":description", $this->description);
        $prods->bindParam(":$this->quantity", $this->quantity);
        $prods->bindParam(":created", $this->created);

        if ($prods->execute())
        {
            return true;
        }

        return false;

    }

    //read
    public function read()
    {
        $query = "SELECT id, name, description, price, quantity FROM " . $this->table_name;

        $product = $this->conn->prepare($query);

        $product->execute();

        return $product;
    }

    //update
    public function update()
    {
    }

    //delete
    public function delete()
    {
    }
}