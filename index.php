<?php
    include '../api/database.php';
    include '../class/DbTest.php';

    $database = new Database();
    $conn = $database->getConnection();

    $test = new DbTest($conn);
    $connectionStatus = $test->checkConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Reading List</title>
    <link rel="stylesheet" href='../read/styles.css'>
</head>
<body>
    
    <div class="header">
        <div class="logo">Interactive Reading List</div>
    </div>

    <div class="container">
        <div class="table-container">
            <div class="page-header">
                <div class="page-title">Reading List</div>
                <button class="add-btn" onclick="openAddBooksModal()">Add New Read</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Genre</th>
                        <th>Target Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="booksTableBody">
                    <!-- Books will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Books Modal -->
    <div id="addBooksModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddBooksModal()">&times;</span>
            <h3>New Read Details</h3>

            <div class="form-grid">
                <div class="form-group">
                    <input type="text" id="book_name" placeholder="Title">
                    <input type="text" id="author" placeholder="Author">
                </div>
                <div class="form-group">
                    <p>Genre:</p>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="fiction" name="genre" value="Fiction">
                            <label for="fiction">Fiction</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="nonfiction" name="genre" value="Non Fiction">
                            <label for="nonfiction">Non Fiction</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="target_date">Target Date:</label>
                    <input type="date" id="target_date">
                </div>
            </div>
            <button onclick="addBook()">Save</button>
        </div>
    </div>

    <!-- Update Books Modal -->
    <div id="updateBooksModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeUpdateModal()">&times;</span>
            <h3>Edit Read Details</h3>

            <input type="hidden" id="edit_book_id">
            
            <div class="form-grid">
                <div class="form-group">
                    <input type="text" id="edit_book_name" placeholder="Title">
                    <input type="text" id="edit_author" placeholder="Author">
                </div>
                <div class="form-group">
                    <p>Genre:</p>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="edit_fiction" name="edit_genre" value="Fiction">
                            <label for="edit_fiction">Fiction</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="edit_nonfiction" name="edit_genre" value="Non Fiction">
                            <label for="edit_nonfiction">Non Fiction</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_target_date">Target Date:</label>
                    <input type="date" id="edit_target_date">
                </div>
                <div class="form-group">
                    <label for="edit_status">Status:</label>
                    <select id="edit_status">
                        <option value="Pending">Pending</option>
                        <option value="Done">Done</option>
                    </select>
                </div>
            </div>
            <button onclick="updateBook()">Update</button>
        </div>
    </div>

    <script src="readingList.js"></script>
</body>
</html>