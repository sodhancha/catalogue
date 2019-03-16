<?php
/**
 * Created by PhpStorm.
 * User: AWT-KRIPAL
 * Date: 3/16/2019
 * Time: 7:39 PM
 */

class product
{
    // Connection instance
    private $connection;

    // table name
    private $table_name = "products";

    // table columns
    public $id;
    public $slug;
    public $name;
    public $price;
    public $quantity;

    public function __construct($connection){
        $this->connection = $connection;
    }

    //create
    public function create(){

    }

    //show
    public function show(){
        $query = "SELECT * FROM" . $this->table_name;

        $product = $this->connection->prepare($query);

        $product->execute();

        return $product;
    }

    //update
    public function update(){}

    //delete
    public function delete(){}
}