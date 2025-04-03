<?php
    class Employee {
        private $conn;
        private $table = "Employees";

        public function __construct($db) {
            $this->conn = $db;
        }

        public function getAllEmployees() {
            $query = "SELECT id, first_name, last_name, middle_initial, 
                    mobile_number, email, sex, job_title FROM ". $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getEmployeeById($id) {
            $query = "SELECT id, first_name, last_name, middle_initial, mobile_number, email,
            sex, job_title FROM ". $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

        public function addEmployee($first_name, $last_name, $middle_initial, $mobile_number, $email, $sex, $job_title) {
            $query = "INSERT INTO " . $this->table . " (first_name, last_name, middle_initial, 
            mobile_number, email, sex, job_title) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$first_name, $last_name, $middle_initial, $mobile_number, $email, $sex, $job_title]);
        }

        public function updateEmployee($id, $first_name, $last_name, $middle_initial, $mobile_number, $email, $sex, $job_title){
            $query = "UPDATE " . $this->table . " SET first_name = ?, last_name = ?, middle_initial = ?,
            mobile_number = ?, email = ?, sex = ?, job_title = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$first_name, $last_name, $middle_initial, $mobile_number, $email, $sex, $job_title, $id]);
        }

        public function deleteEmployee($id) {
            $query = "DELETE FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$id]);
        }
        
    }
?>