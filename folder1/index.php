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
    <title>Management Information System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <button id="menu-toggle" class="menu-toggle">&#9776;</button>
            <div class="logo">Management Information System</div>
            <ul class="menu">
                <li><a href="#">Departments</a></li>
                <li><a href="../employees/employee.js">Employees</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">Orders</a></li>
            </ul>
        </div>
    </div>
    <div class="status-container">
        Database Connection Status:
        <span class="status <?= $connectionStatus['status'] === 'success' ? 'success' : 'error' ?>">
            <?= $connectionStatus['message'] ?>
        </span>
    </div>
    <div class="container">
        <div class="table-container">
            <div class="page-header">
                <div class="page-title">Employee List</div>
                <button class="add-btn" onclick="openAddEmployeeModal()">Add Employee</button>
            </div>
            <div class="search-filter">
                <input type="text" id="searchBox" placeholder="Search by Name..." onkeyup="filterEmployee()">

                <select id="filterSex" onchange="filterEmployee()">
                    <option value="">Filter by Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <select id="filterJobTitle" onchange="filterEmployee()">
                    <option value="">Select Job Title</option>
                    <option value="Project Manager">Project Manager</option>
                    <option value="Business Analyst">Business Analyst</option>
                    <option value="Fullstack Software Engineer">Fullstack Software Engineer</option>
                    <option value="Front End Developer">Front End Developer</option>
                    <option value="Back End Developer">Back End Developer</option>
                    <option value="Quality Assurance Engineer">Quality Assurance Engineer</option>
                </select>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>M.I</th>
                        <th>Last Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Sex</th>
                        <th>Job Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody">
                </tbody>
            </table>
        </div>
        <div id="addEmployeeModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeAddEmployeeModal()">&times;</span>
                <h3>Enter Employee Details</h3>

                <div class="form-grid">

                    <div class="from-group">
                        <input type="text" id="first_name" placeholder="FirstName">
                        <input type="text" id="middle_initial" placeholder="M.I">
                        <input type="text" id="last_name" placeholder="Last Name">
                        <input type="text" id="mobile_number" placeholder="Mobile Number">
                    </div>

                    <div class="form-group">
                        <input type="email" id="email" placeholder="Email">
                        <select id="sex">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>

                        <select id="job_title">
                            <option value="Select Job Title">Select Job Title</option>
                            <option value="Project Manager">Project Manager</option>
                            <option value="Business Analyst">Business Analyst</option>
                            <option value="Fullstack Software Engineer">Fullstack Software Engineer</option>
                            <option value="Front End Developer">Front End Developer</option>
                            <option value="Back End Developer">Back End Developer</option>
                            <option value="Quality Assurance Engineer">Quality Assurance Engineer</option>
                        </select>

                        <select id="department">
                            <option value="">Loading departments...</option>
                        </select>
                    </div>
                </div>
                <button onclick="addEmployee()">Save Employee Details</button>
            </div>
        </div>
    </div>
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()"&times;></span>
            <h3>Update Employee</h3>
            <div class="form-grid">

                <div class="form-group">
                    <input type="hidden" id="editId">
                    <input type="text" id="editFirstName" placeholder="First Name">
                    <input type="text" id="editMiddleInitial" placeholder="M.I">
                    <input type="text" id="editLastName" placeholder="LastName">
                    <input type="text" id="editMobileNumber" placeholder="Mobile Number">
                </div>

                <div class="form-group">
                    <input type="email" id="editEmail" placeholder="Email">
                    <select id="editSex">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>

                    <select id="editJobTitle">
                        <option value="Select Job Title">Select Job Title</option>
                        <option value="Project Manager">Project Manager</option>
                        <option value="Business Analyst">Business Analyst</option>
                        <option value="Fullstack Software Engineer">Fullstack Software Engineer</option>
                        <option value="Front End Developer">Front End Developer</option>
                        <option value="Back End Developer">Back End Developer</option>
                        <option value="Quality Assurance Engineer">Quality Assurance Engineer</option>
                    </select>

                    <select id="department">
                        <option value="">Loading departments...</option>
                    </select>
                </div>
            </div>
            <button onclick="updateEmployee()">Save Changes</button>
        </div>
    </div>
    <script src="employee.js"></script>
</body>
</html>
