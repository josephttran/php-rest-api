<?php

class Database
{
  private $host = 'localhost';
  private $database = 'blog';
  private $info;  
  private $conn;

  public function __construct()
  {
    // include username and password
    $this->info = include_once $_SERVER['DOCUMENT_ROOT'] . '/info.php';
  }

  public function connect()
  {
    $opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
    $this->conn = null;

    try {
      $this->conn = new PDO(
          'mysql:host=' . $this->host . ';dbname=' . $this->database, 
          $this->info['username'], 
          $this->info['password'], 
          $opt);
    } catch(PDOException $e) {
      echo 'Connection Error: ' . $e->getMessage();
    }

    return $this->conn; 
  }
}
