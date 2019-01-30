<?php

    class Post {
        
        // DB Params
        private $conn;
        private $table = 'posts';

        // Post Properties
        public $id;
        public $category_id;
        public $category_name; // create later
        public $title;
        public $body;
        public $author;
        public $created_at;

        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Post
        public function read() {

            // Select Query
            $query = 'SELECT
                        c.name as category_name,
                        p.id,
                        p.category_id,
                        p.title,
                        p.body,
                        p.author,
                        p.created_at
                    FROM
                        '.$this->table.' p
                    LEFT JOIN
                        categories c ON p.category_id = c.id
                    ORDER BY
                        p.created_at DESC
                    ';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;

        } // End of read funciton
        
        // Get Single Post
        public function readSingle() {
            // Select Query
            $query = 'SELECT 
                        c.name as category_name,
                        p.id,
                        p.category_id,
                        p.title,
                        p.body,
                        p.author,
                        p.created_at
                      FROM
                        '.$this->table.' p
                      LEFT JOIN
                        categories c ON p.category_id = c.id
                      WHERE
                        p.id = ?
                      LIMIT 0,1';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Id
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set Properties
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_name = $row['category_name'];
            $this->created_at = $row['created_at'];

        } // End of readSingle function

        // Create Post
        public function create() {
            // Create Query
            $query = 'INSERT INTO '.$this->table.'
                        SET
                            title = :title,
                            body = :body,
                            author = :author,
                            category_id = :category_id';
            
            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            
            // Bidn Data
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);

            // Execute Query
            if($stmt->execute()) {
                return true;
            }
            
            // Print Error is something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        } // End of create function

        // Update Post
        public function update() {
            // Update Query
            $query = 'UPDATE '.$this->table.'
                        SET
                            title = :title,
                            body = :body,
                            author = :author,
                            category_id = :category_id
                        WHERE
                            id = :id';
            
            // Prepate Statement
            $stmt = $this->conn->prepare($query);

            // Clean Data 
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind ID
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':body', $this->body);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':category_id', $this->category_id);
            $stmt->bindParam(':id', $this->id);

            // Execute Query
            if($stmt->execute()) {
                return true;
            }

            // Print Error is something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        } // End of Update Function

        // Delete Post
        public function delete() {
            $query = 'DELETE FROM '.$this->table.' WHERE id = :id';
            
            // Prepate Statement
            $stmt = $this->conn->prepare($query);

            // Clean ID
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind ID
            $stmt->bindParam(':id', $this->id);

            // Execute Query
            if($stmt->execute()) {
                return true;
            }

            //Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        } // End of delete function

    } // End of Class  

?>