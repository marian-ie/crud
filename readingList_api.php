<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type");

    // Handle preflight OPTIONS request
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }

    include 'database.php';
    include '../class/readingList.php';

    $database = new Database();
    $db = $database->getConnection();

    if (!$db) {
        echo json_encode(["status" => "error", "message" => "Database connection failed"]);
        exit;
    }

    $books = new Books($db);

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            if(isset($_GET['book_id'])){
                $booksData = $books->getBooksById($_GET['book_id']);
                if ($booksData) {
                    echo json_encode(["status" => "success", "books" => $booksData]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Book not found"]);
                }
            } else {
                $allBooks = $books->getAllBooks();
                echo json_encode(["status" => "success", "books" => $allBooks]);
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);

            if(!$data) {
                echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
                exit;
            }

            if (isset($data['book_name'], $data['author'], $data['genre'], $data['target_date'], $data['status'])){
                $result = $books->addBooks($data['book_name'], $data['author'], $data['genre'], $data['target_date'], $data['status']);
                if ($result) {
                    echo json_encode(["status" => "success", "message" => "New Read Added Successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to Add New Read"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid input - missing required fields"]);
            }
            break;

        case 'PUT':
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data) {
                echo json_encode(["status" => "error", "message" => "Invalid JSON input"]);
                exit;
            }

            // Check if this is just a status update
            if (isset($data['book_id'], $data['status'], $data['update_status_only']) && $data['update_status_only'] === true) {
                $result = $books->updateStatus($data['book_id'], $data['status']);
                
                if ($result) {
                    echo json_encode(["status" => "success", "message" => "Status Updated Successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed To Update Status"]);
                }
            } 
            // Full book update
            else if (isset($data['book_id'], $data['book_name'], $data['author'], $data['genre'], $data['target_date'], $data['status'])) {
                $result = $books->updateBooks($data['book_id'], $data['book_name'], $data['author'], $data['genre'], $data['target_date'], $data['status']);

                if ($result) {
                    echo json_encode(["status" => "success", "message" => "Book Updated Successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed To Update Book"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid input - missing required fields"]);
            }
            break;

        case 'DELETE':
            if (isset($_GET['book_id'])) {
                $result = $books->deleteBooks($_GET['book_id']);
                if ($result) {
                    echo json_encode(["status" => "success", "message" => "Book Deleted Successfully"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to Delete Book"]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid ID"]);
            }
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    }
?>