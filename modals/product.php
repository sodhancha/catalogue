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
    public $slug;
    public $name;
    public $price;
    public $description;
    public $quantity;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    //create
    public function create(){

    }

    //read
    public function read(){
        $query = "SELECT id, name, description, price, quantity FROM " . $this->table_name;

        $product = $this->conn->prepare($query);

        $product->execute();

        return $product;
    }

    //update
    public function update(){}

    //delete
    public function delete(){}
}