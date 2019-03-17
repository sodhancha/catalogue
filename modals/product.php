<?php
/**
 * Created by PhpStorm.
 * User: AWT-KRIPAL
 * Date: 3/16/2019
 * Time: 7:39 PM
 */

class Product
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
        $query = "INSERT INTO " . $this->table_name . " 
                SET 
                    name=:name, 
                    price=:price, 
                    description=:description, 
                    quantity=:quantity, 
                    created=:created";

        $prods = $this->conn->prepare($query);

        // sanitize
        $this->name        = $this->_filter_input($this->name));
        $this->price       = $this->_filter_input($this->price));
        $this->description = $this->_filter_input($this->description));
        $this->quantity    = $this->_filter_input($this->quantity));
        $this->created     = $this->_filter_input($this->created));

        // bind values
        $prods->bindParam(":name", $this->name);
        $prods->bindParam(":price", $this->price);
        $prods->bindParam(":description", $this->description);
        $prods->bindParam(":quantity", $this->quantity);
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
        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                quantity = :quantity
            WHERE
                id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name        = htmlspecialchars(strip_tags($this->name));
        $this->price       = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->quantity    = htmlspecialchars(strip_tags($this->quantity));
        $this->id          = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if ($stmt->execute())
        {
            return true;
        }

        return false;
    }

    //delete
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

     private function _filter_input( $vals ){
        return htmlspecialchars(strip_tags( $vals );
    }
}