<?php

class Post
{
  private $conn;
  private $table = 'posts';
  
  // Post Properties
  public $id;
  public $category_id;
  public $category_name;
  public $title;
  public $body;
  public $author;
  public $created_at;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Create Post
  public function create()
  {
    $query = 'INSERT INTO ' . $this->table . 
        ' SET
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id';
    
    // Prepare statement        
    $stmt = $this->conn->prepare($query);
    
    // Bind parameter
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->category_id);
    
    //Execute query
    if ($stmt->execute()) {
      return true;
    }
    
    printf("Error: %s.\n, $stmt->error");

    return false;
  }
  
  // Get Posts
  public function read()
  {
    $query = 'SELECT
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
      FROM
        ' . $this->table . ' p
      LEFT JOIN
        categories c ON p.category_id = c.id
      ORDER BY
        p.created_at DESC';  

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    //Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get single post
  public function readSingle()
  {
    $query = 'SELECT
        c.name as category_name,
        p.id,
        p.category_id,
        p.title,
        p.body,
        p.author,
        p.created_at
      FROM
        ' . $this->table . ' p
      LEFT JOIN
        categories c ON p.category_id = c.id
      WHERE
        p.id = ?
      LIMIT 0,1';    
  
    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind id
    $stmt->bindParam(1, $this->id);

    //Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set properties
    $this->title = $row['title'];
    $this->body = $row['body'];
    $this->author = $row['author'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
  }  

  // Udpate post
  public function update()
  {
    $query = 'UPDATE ' . $this->table . 
        ' SET 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id 
          WHERE 
          id = :id';
    
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':id', $this->id);      
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':body', $this->body);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':category_id', $this->category_id);

    if ($stmt->execute()) {
      return true;
    }
    
    printf("Error: %s.\n, $stmt->error");

    return false;  
  }
}
