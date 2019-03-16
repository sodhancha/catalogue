<?php
include_once './dbClass.php';

try
{
    $dbClass    = new dbClass();
    $connection = $dbClass->getConnection();
    $sql        = file_get_contents("data/database.sql");
    $connection->exec($sql);
    echo "Database and tables created successfully!";
} catch (PDOException $e)
{
    echo $e->getMessage();
}