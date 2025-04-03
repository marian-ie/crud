<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type");

    include 'database.php';
    include '../class/Employee.php';

    $database = new Database();
    $db = $database->getConnection();

    if(!$db) {
        echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    }

    $emp = new Employee($db);

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET': 
            if(isset($_GET['id'])) {
                $employeeData = $emp->getEmployeeById($_GET['id']);
                if ($employeeData) {
                    echo json_encode(["status" => "success", "employee" => $employeeData]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Employee not found"]);
                }
            } else {
                $emps = $emp->getAllEmployees();
                echo json_encode(["status" => "success", "employee" => $emps]);
            }
            break;
            case 'POST':
                $data = json_decode(file_get_contents("php://input"), true);
            
                if (!$data) {
                    echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
                    exit;
                }
            
                if (isset($data['first_name'], $data['last_name'], $data['middle_initial'], $data['mobile_number'], $data['email'], $data['sex'], $data['job_title'])) {
                    $result = $emp->addEmployee(
                        $data['first_name'], 
                        $data['last_name'], 
                        $data['middle_initial'], 
                        $data['mobile_number'], 
                        $data['email'], 
                        $data['sex'], 
                        $data['job_title']
                    );
            
                    if ($result) {
                        echo json_encode(["status" => "success", "message" => "Employee added successfully"]); // Fixed missing parenthesis
                    } else {
                        echo json_encode(["status" => "error", "message" => "Failed to add employee"]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Invalid input"]);
                }
                break;
            

                case 'PUT':
                    $data = json_decode(file_get_contents("php://input"), true);
                
                    if (!$data) {
                        echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
                        exit;
                    }
                
                    if (isset($data['id'], $data['first_name'], $data['last_name'], $data['middle_initial'], $data['mobile_number'], $data['email'], $data['sex'], $data['job_title'])) { // Fixed typo here
                        $result = $emp->updateEmployee(
                            $data['id'],
                            $data['first_name'],
                            $data['last_name'],
                            $data['middle_initial'],
                            $data['mobile_number'], 
                            $data['email'],
                            $data['sex'],
                            $data['job_title']
                        );
                
                        if ($result) {
                            echo json_encode(["status" => "success", "message" => "Employee updated successfully"]);
                        } else {
                            echo json_encode(["status" => "error", "message" => "Failed to update employee"]);
                        }
                    } else {
                        echo json_encode(["status" => "error", "message" => "Invalid input"]);
                    }
                    break;
                
                    case 'DELETE':
                        if (isset($_GET['id'])) {
                            $id = $_GET['id']; // Get the ID from the query string
                            // Assuming $emp is your Employee object and has the deleteEmployee method
                            $result = $emp->deleteEmployee($id);
                            if ($result) {
                                echo json_encode(["status" => "success", "message" => "Employee deleted successfully"]);
                            } else {
                                echo json_encode(["status" => "error", "message" => "Failed to delete employee"]);
                            }
                        } else {
                            echo json_encode(["status" => "error", "message" => "Invalid ID"]);
                        }
                        break;

    }
?>
