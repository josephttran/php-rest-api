<?php

class Category {
  private $conn;
  private $table = 'categories';

  // Properties
  public $id;
  public $name;
  public $created_at;

  // Constructor with database
  public function __construct($db) {
    $this->conn = $db;
  }
  
  // Create category
  public function create()
  {
    $query = "INSERT INTO {$this->table} SET name = :name, created_at = :created_at";
    
    // Prepare statement        
    $stmt = $this->conn->prepare($query);
    
    // Bind parameter
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':created_at', $this->created_at);
    
    //Execute query
    if ($stmt->execute()) {
      return true;
    }
    printf("Error: %s.\n, $stmt->error");

    return false;
  }

  // Get categories
  public function read()
  {
    // Create query
    $query = "SELECT id, name, created_at FROM {$this->table} ORDER BY created_at DESC";
    
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    
    // Excute statement
    $stmt->execute();

    return $stmt;
  }

  // Update categories
  public function update()
  {
    $query = "UPDATE {$this->table} 
        SET 
            name = :name, 
            created_at = :created_at 
        WHERE 
            id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':created_at', $this->created_at);

    if ($stmt->execute()) {
      return true;
    }
    
    printf("Error: %s.\n, $stmt->error");

    return false;  
  }

  // Delete in categories
  public function delete()
  {
    $query = "DELETE FROM {$this->table} WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':id', $this->id);

    if ($stmt->execute()) {
      return true;
    }
    
    printf("Error: %s.\n, $stmt->error");

    return false;  
  }
}