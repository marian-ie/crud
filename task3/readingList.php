<?php

class Books {
    private $conn;
    private $table = "Books";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllBooks() {
        $query = "SELECT book_id, book_name, author, genre, target_date, status FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBooksById($book_id) {
        $query = "SELECT book_id, book_name, author, genre, target_date, status FROM " . $this->table . " WHERE book_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$book_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addBooks($book_name, $author, $genre, $target_date, $status) {
        $query = "INSERT INTO " . $this->table . " (book_name, author, genre, target_date, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$book_name, $author, $genre, $target_date, $status]);
    }

    public function updateBooks($book_id, $book_name, $author, $genre, $target_date, $status) {
        $query = "UPDATE " . $this->table . " SET book_name = ?, author = ?, genre = ?, target_date = ?, status = ? WHERE book_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$book_name, $author, $genre, $target_date, $status, $book_id]);
    }

    public function updateStatus($book_id, $status) {
        $query = "UPDATE " . $this->table . " SET status = ? WHERE book_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $book_id]);
    }

    public function deleteBooks($book_id) {
        $query = "DELETE FROM " . $this->table . " WHERE book_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$book_id]);
    }
}