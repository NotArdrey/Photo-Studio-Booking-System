<?php
require '../config/dbconn.php';
session_start();

//Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: ../page/login.php");
    exit();
}

// Database connection check (optional)
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoStudio</title>
    <link rel="stylesheet" href="../style/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha384-0u1+Ko2A3WSXU8B8v7uYF6WfhMTzAC5ZfZx5ddtKkM4KaNmi5a68F40Vz5Dui1Li" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="../js/script.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
        .static-alert-container {
            position: absolute; 
        }
    </style>
</head>
<body>
<div class="sidebar">
    <img src="../Photos/profile_admin.jpg" alt="Solo Photo" class="profile">
    <h2>Admin Panel</h2>
    <hr>
    <ul>
        <li><a href="#" class="nav-link" data-target="reservation"><i class="fas fa-tachometer-alt"></i>Reservations</a></li>
        <li><a href="#" class="nav-link" data-target="add-reservation"><i class="fas fa-calendar-plus"></i>Add Reservation</a></li>
        <li><a href="#" class="nav-link" data-target="history"><i class="fas fa-users"></i>History</a></li>
        <li><a href="#" class="nav-link" data-target="admin"><i class="fas fa-cog"></i>Admin</a></li>
        <li><a href="#" class="nav-link" data-target="add-admin"><i class="fas fa-user-plus"></i>Add Admin</a></li>
        <li><a href="../function/logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
    </ul>
</div>


<!-- Reservation Section -->
<div id="reservation" class="content-section active">
    <div class="container mt-5">
        <h2>Reservation List</h2>
        <div class="d-flex justify-content-between mb-3">
            <div>
                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            </div>
            <div>
                <select id="sortOptions" class="form-select">
                    <option value="name-asc">Name (A-Z)</option>
                    <option value="name-desc">Name (Z-A)</option>
                    <option value="date-asc">Date (latest first)</option>
                    <option value="date-desc">Date (Oldest first)</option>
                    <option value="time-asc">Time (latest first)</option>
                    <option value="time-desc">Time (Oldest first)</option>
                </select>
            </div>
        </div>
        <table class="table table-striped table-bordered mx-auto medium">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th style="width: 80px; text-align: center;">Backdrop</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Package Type</th>
                    <th>Pax</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="reservationTable">
            <?php
                    $sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name, email, backdrop, time, date, package_type, pax, price 
                            FROM users 
                            WHERE archive = 'no' AND complete = 'no'
                            ORDER BY date ASC, time ASC";

                    $result = $conn->query($sql);
                    $counter = 1;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            echo "<tr>";
                            echo "<td>" . $counter . "</td>";
                            echo "<td>" . $row['full_name'] . "</td>";  
                            echo "<td>" . $row['email'] . "</td>";       
                            echo "<td class='backdrop-column'>" . $row['backdrop'] . "</td>"; 
                            echo "<td>" . $row['time'] . "</td>"; 
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['package_type'] . "</td>";
                            echo "<td>" . $row['pax'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "<td>
                                    <a href='#' 
                                    data-toggle='modal' 
                                    data-target='#editModal' 
                                    data-id='" . $row['id'] . "' 
                                    data-fullname='" . $row['full_name'] . "' 
                                    data-email='" . $row['email'] . "' 
                                    data-backdrop='" . $row['backdrop'] . "' 
                                    data-time='" .  $row['time'] . "'
                                    data-date='" . $row['date'] . "' 
                                    data-packagetype='" . $row['package_type'] . "' 
                                    data-pax='" . $row['pax'] . "' 
                                    data-price='" . $row['price'] . "' 
                                    class='btn btn-warning btn-sm'>Edit</a>";

                            // Add the "Complete" button only for the first row
                            if ($counter === 1) {
                                echo " <form action=../function/admin.php method='POST' style='display:inline;'>
                                            <input type='hidden' name='reservation_id' value='" . $row['id'] . "'>
                                            <button type='submit' class='btn btn-primary btn-sm' name='complete-btn'>Complete</button>
                                        </form>";
                            }
                            echo "</td>";
                            echo "</tr>";
                            $counter++;
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center'>No data available</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Reservation Section -->    
<div id="add-reservation" class="content-section">
    <h2>Add Reservation</h2>
    <div class="photo-section">
            <div class="details-forms">
                <form class="appointment-form" action = "../function/admin.php" method = "POST">
                    <div class="column">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first_name" required>
    
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>

                             
                        <label for="appointment-time">Appointment Time</label>
                        <select id="appointment-time" name="appointment-time" required>
                            <option value="" disabled selected>Select a time</option>
                            <option value="9:00 AM">9:00 AM</option>
                            <option value="9:30 AM">9:30 AM</option>
                            <option value="10:00 AM">10:00 AM</option>
                            <option value="10:30 AM">10:30 AM</option>
                            <option value="1:00 PM">1:00 PM</option>
                            <option value="1:30 PM">1:30 PM</option>
                            <option value="2:00 PM">2:00 PM</option>
                            <option value="2:30 PM">2:30 PM</option>
                            <option value="3:00 PM">3:00 PM</option>
                            <option value="3:30 PM">3:30 PM</option>
                            <option value="4:00 PM">4:00 PM</option>
                            <option value="4:30 PM">4:30 PM</option>
                        </select>

                        <label for="appointment-date">Appointment Date</label>
                        <input type="date" id="appointment-date" name="appointment-date" required>

                    </div>

                    <div class="column">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last_name" required>
        
                        <label for="package">Preferred Package</label>
                        <select id="package" name="package" required>
                            <option value="" disabled selected>Select a Package</option>
                            <option value="solo_package">Solo Package</option>
                            <option value="pair_package">Pair Package</option>
                            <option value="group_package">Group Package</option>
                            <option value="1-2 Years Old">1-2 Years Old</option>
                            <option value="3-4 Years Old">3-4 Years Old</option>
                            <option value="5-6 Years Old">5-6 Years Old</option>
                        </select>

                        <label for="backdrop">Preferred Backdrop</label>
                        <select id="backdrop" name="backdrop" required>
                            <option value="" disabled selected>Select a color</option>
                            <option value="white">White</option>
                            <option value="black">Black</option>
                            <option value="red">Red</option>
                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <option value="yellow">Yellow</option>
                            <option value="purple">Purple</option>
                            <option value="pink">Pink</option>
                            <option value="gray">Gray</option>
                        </select>
                        <label for="Extra-person">Extra Person</label>
                        <input type="number" name="extra-person" min="1" max="10"oninput="validateInput(this)" >
                    </div>
                <div class="btn-two">
                    <button type="submit" name ="add-list-btn" class="styled-button">
                        Add New Reservation
                    </button>
                </div>
                </div>
            </form> 
        </div>
    </div>
</div>

<!-- History Section -->
<div id="history" class="content-section">
    <div class="container mt-5">
        <h2>History List</h2>
        <div class="d-flex align-items-center justify-content-between mb-2" style="gap: 8px;">
            <div class="flex-grow-1" style="max-width: 300px;">
                <!-- Set a custom width for the search input -->
                <input type="text" id="searchInput-history" class="form-control form-control-sm" placeholder="Search...">
            </div>
            <div class="d-flex gap-4"> <!-- Increased gap between elements -->

                <button id="generateReportBtn" class="btn btn-primary" style="width: auto; ">Generate Report</button>
                <select id="sortOptions-history" class="form-select form-select-sm" style="width: auto; margin-left: 20px;">
                    <option value="name-asc">Name (A-Z)</option>
                    <option value="name-desc">Name (Z-A)</option>
                    <option value="date-asc">Date (latest first)</option>
                    <option value="date-desc">Date (Oldest first)</option>
                    <option value="time-asc">Time (Ascending)</option>
                    <option value="time-desc">Time (Descending)</option>
                </select>
            </div>
        </div>

        <table class="table table-striped table-bordered mx-auto medium">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th style="width: 80px; text-align: center;">Backdrop</th>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Package Type</th>
                    <th>Pax</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody id="reservationTable-history">
                <?php
                    $sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name, email, backdrop, time, date, package_type, pax, price FROM users WHERE complete = 'yes'";
                    $result = $conn->query($sql);
                    $counter = 1;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            echo "<tr>";
                            echo "<td>" . $counter++ . "</td>";
                            echo "<td>" . $row['full_name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td class='backdrop-column'>" . $row['backdrop'] . "</td>";
                            echo "<td>" . $row['time'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['package_type'] . "</td>";
                            echo "<td>" . $row['pax'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>No data available</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>




<!-- admin Section -->
<div id="admin" class="content-section">
    <div class="container mt-5">
        <h2>Admin List</h2>
        <div class="d-flex justify-content-between mb-3">
            <div>
                <input type="text" id="searchInput-admin" class="form-control" placeholder="Search...">
            </div>
            <div>
                <select id="sortOptions-admin" class="form-select">
                    <option value="name-asc">Name (A-Z)</option>
                    <option value="name-desc">Name (Z-A)</option>
                </select>
            </div>
        </div>
        <table class="table table-striped table-bordered mx-auto medium">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="reservationTable-admin">
            <?php
                $sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name , username, password FROM admin";

                $result = $conn->query($sql);
                $counter = 1;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];
            
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>";
                        echo "<td>" . $row['full_name'] . "</td>"; 
                        echo "<td>" . $row['username'] . "</td>"; 
                        echo "<td>" . $row['password'] . "</td>"; 
                        echo "<td>
                                <a href='#' 
                                data-toggle='modal' 
                                data-target='#adminModal' 
                                data-id='" . $row['id'] . "' 
                                data-fullname='" . $row['full_name'] . "' 
                                data-username='" . $row['username'] . "' 
                                data-password='" . $row['password'] . "' 
                                class='btn btn-warning btn-sm'>Edit</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No data available</td></tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Add Admin Section -->    
<div id="add-admin" class="content-section">
<h2>Add Admin</h2>
        <div class="photo-section">
                <div class="details-forms">
                    <form class="appointment-form" action = "../function/admin.php" method = "POST">
                        <div class="column">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" name="first_name" required>
        
                            <label for="email">Username</label>
                            <input type="text" id="username" name="username" required>
                        </div>

                        <div class="column">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" name="last_name" required>

                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>

                    <div class="btn-two">
                        <button type="submit" name ="add-admin-btn" class="styled-button">
                            Add Admin
                        </button>
                    </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>



<!-- User Modal -->   
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    
                <form id = "editForm" method=  "POST" action="../function/admin.php">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="backdrop" >Backdrop</label>
                                <select id="backdrop" name="backdrop" class="form-control" required>
                                    <option value="white">White</option>
                                    <option value="black">Black</option>
                                    <option value="red">Red</option>
                                    <option value="blue">Blue</option>
                                    <option value="green">Green</option>
                                    <option value="yellow">Yellow</option>
                                    <option value="purple">Purple</option>
                                    <option value="pink">Pink</option>
                                    <option value="gray">Gray</option>
                                </select>  
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="time">Time</label>
                                <select class="form-control" name="time" id="time" required>
                                    <option value="" disabled>Select a time</option>
                                    <option value="9:00 AM">9:00 AM</option>
                                    <option value="9:30 AM">9:30 AM</option>
                                    <option value="10:00 AM">10:00 AM</option>
                                    <option value="10:30 AM">10:30 AM</option>
                                    <option value="1:00 PM">1:00 PM</option>
                                    <option value="1:30 PM">1:30 PM</option>
                                    <option value="2:00 PM">2:00 PM</option>
                                    <option value="2:30 PM">2:30 PM</option>
                                    <option value="3:00 PM">3:00 PM</option>
                                    <option value="3:30 PM">3:30 PM</option>
                                    <option value="4:00 PM">4:00 PM</option>
                                    <option value="4:30 PM">4:30 PM</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" name="date" id="appointment-date" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="package_type">Package Type</label>
                                <select id="package_type" class="form-control" name="package_type" required>
                                    <option value="solo_package">Solo Package</option>
                                    <option value="pair_package">Pair Package</option>
                                    <option value="group_package">Group Package</option>
                                    <option value="1-2 Years Old">1-2 Years Old</option>
                                    <option value="3-4 Years Old">3-4 Years Old</option>
                                    <option value="5-6 Years Old">5-6 Years Old</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="pax">Pax</label>
                                <input type="number" class="form-control" name="pax" id="pax" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" name="price" id="price" required>
                        </div>
                    </div>
                    <div class="modal-footer">    
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" name="archive">Archive</button>
                        <button type="submit" class="btn btn-primary" name="update">Update</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
 


<!-- Admin Modal --> 
<div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminModalLabel">Edit Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="edit_id" id="edit_id">
                <form id="editAdminForm" method="POST" action="../function/admin.php">
                    <div class="mb-3">
                        <label for="editFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="editfirst_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="editlast_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editusername" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="editpassword" name="password">
                    </div>
                    <input type="hidden" id="editAdminId" name="adminId">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="save-changes">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var id = button.data('id');
        var fullname = button.data('fullname');
        var email = button.data('email');
        var backdrop = button.data('backdrop');
        var time = button.data('time');
        var date = button.data('date');
        var packagetype = button.data('packagetype');
        var pax = button.data('pax');
        var price = button.data('price');

    
        var modal = $(this);
        modal.find('#edit_id').val(id);
        modal.find('#first_name').val(fullname.split(' ')[0]); 
        modal.find('#last_name').val(fullname.split(' ')[1]); 
        modal.find('#email').val(email);
        modal.find('#backdrop').val(backdrop);
        modal.find('#time').val(time);
        modal.find('#appointment-date').val(date);
        modal.find('#package_type').val(packagetype);
        modal.find('#pax').val(pax);
        modal.find('#price').val(price);
    });


        $('#adminModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var modal = $(this); 
            

            var id = button.data('id'); 
            var fullname = button.data('fullname');
            var username = button.data('username'); 

            
            modal.find('#editAdminId').val(id); 
            modal.find('#editfirst_name').val(fullname.split(' ')[0]); 
            modal.find('#editlast_name').val(fullname.split(' ')[1]);
            modal.find('#editusername').val(username); 
    });

        document.querySelector('.btn-danger').addEventListener('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, archive it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) { 
                const form = document.querySelector('form'); 
                const archiveInput = document.createElement('input');
                archiveInput.type = 'hidden';
                archiveInput.name = 'archive';
                archiveInput.value = 'true';
                form.appendChild(archiveInput);
                
                
                const editId = document.querySelector('#edit_id').value;
                if (editId) {
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'edit_id';
                    idInput.value = editId;
                    form.appendChild(idInput); 
                }

                form.submit(); 
            }
        });
    });

    const today = new Date(); 
    const todayDate = today.toISOString().split('T')[0];
    
    const minDate = new Date();
    minDate.setDate(today.getDate() + 2);
    const minDateString = minDate.toISOString().split('T')[0]; 
    
    const maxDate = new Date();
    maxDate.setMonth(today.getMonth() + 2);
    const maxDateString = maxDate.toISOString().split('T')[0];
    
    const dateInput = document.getElementById('appointment-date');
    dateInput.setAttribute('min', minDateString);
    dateInput.setAttribute('max', maxDateString);

    function validateInput(input) {
    let value = parseInt(input.value);
 
    if (value > 10) {
        input.value = 10;
    } else if (value < 1) {
        input.value = 1;
    }
    }

    document.addEventListener("DOMContentLoaded", function() {
    const today = new Date();
    const todayDate = today.toISOString().split('T')[0];
    
    const minDate = new Date();
    minDate.setDate(today.getDate() + 2);
    const minDateString = minDate.toISOString().split('T')[0];
    
    const maxDate = new Date();
    maxDate.setMonth(today.getMonth() + 2);
    const maxDateString = maxDate.toISOString().split('T')[0];
    
    const dateInput = document.getElementById('appointment-date');
    dateInput.setAttribute('min', minDateString);
    dateInput.setAttribute('max', maxDateString);
    });

    //reservation list
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const sortOptions = document.getElementById('sortOptions');
        const tableBody = document.getElementById('reservationTable');
        let rows = Array.from(tableBody.getElementsByTagName('tr'));

  
    function filterRows() {
        const searchTerm = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(searchTerm) ? '' : 'none';
        });
    }


    function sortRows() {
        const sortValue = sortOptions.value;
        rows.sort((a, b) => {
            let valA, valB;

            switch (sortValue) {
                case 'name-asc':
                    valA = a.cells[1].textContent.toLowerCase();
                    valB = b.cells[1].textContent.toLowerCase();
                    return valA.localeCompare(valB);
                case 'name-desc':
                    valA = a.cells[1].textContent.toLowerCase();
                    valB = b.cells[1].textContent.toLowerCase();
                    return valB.localeCompare(valA);
                case 'date-asc':
                    valA = new Date(a.cells[5].textContent);
                    valB = new Date(b.cells[5].textContent);
                    return valA - valB;
                case 'date-desc':
                    valA = new Date(a.cells[5].textContent);
                    valB = new Date(b.cells[5].textContent);
                    return valB - valA;
                case 'time-asc':
                    valA = a.cells[4].textContent;
                    valB = b.cells[4].textContent;
                    return valA.localeCompare(valB);
                case 'time-desc':
                    valA = a.cells[4].textContent;
                    valB = b.cells[4].textContent;
                    return valB.localeCompare(valA);
            }
        });
        rows.forEach(row => tableBody.appendChild(row));
    }

    searchInput.addEventListener('input', filterRows);
    sortOptions.addEventListener('change', sortRows);
});

    //history list
    document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput-history');
    const sortOptions = document.getElementById('sortOptions-history');
    const tableBody = document.getElementById('reservationTable-history');
    let rows = Array.from(tableBody.getElementsByTagName('tr'));

  
    function filterRows() {
        const searchTerm = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(searchTerm) ? '' : 'none';
        });
    }


    function sortRows() {
        const sortValue = sortOptions.value;
        rows.sort((a, b) => {
            let valA, valB;

            switch (sortValue) {
                case 'name-asc':
                    valA = a.cells[1].textContent.toLowerCase();
                    valB = b.cells[1].textContent.toLowerCase();
                    return valA.localeCompare(valB);
                case 'name-desc':
                    valA = a.cells[1].textContent.toLowerCase();
                    valB = b.cells[1].textContent.toLowerCase();
                    return valB.localeCompare(valA);
                case 'date-asc':
                    valA = new Date(a.cells[5].textContent);
                    valB = new Date(b.cells[5].textContent);
                    return valA - valB;
                case 'date-desc':
                    valA = new Date(a.cells[5].textContent);
                    valB = new Date(b.cells[5].textContent);
                    return valB - valA;
                case 'time-asc':
                    valA = a.cells[4].textContent;
                    valB = b.cells[4].textContent;
                    return valA.localeCompare(valB);
                case 'time-desc':
                    valA = a.cells[4].textContent;
                    valB = b.cells[4].textContent;
                    return valB.localeCompare(valA);
            }
        });
        rows.forEach(row => tableBody.appendChild(row));
    }
    searchInput.addEventListener('input', filterRows);
    sortOptions.addEventListener('change', sortRows);
});



   //admin list
   document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput-admin');
    const sortOptions = document.getElementById('sortOptions-admin');
    const tableBody = document.getElementById('reservationTable-admin');
    let rows = Array.from(tableBody.getElementsByTagName('tr'));

  
    function filterRows() {
        const searchTerm = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(searchTerm) ? '' : 'none';
        });
    }


    function sortRows() {
        const sortValue = sortOptions.value;
        rows.sort((a, b) => {
            let valA, valB;

            switch (sortValue) {
                case 'name-asc':
                    valA = a.cells[1].textContent.toLowerCase();
                    valB = b.cells[1].textContent.toLowerCase();
                    return valA.localeCompare(valB);
                case 'name-desc':
                    valA = a.cells[1].textContent.toLowerCase();
                    valB = b.cells[1].textContent.toLowerCase();
                    return valB.localeCompare(valA);
                case 'date-asc':
                    valA = new Date(a.cells[5].textContent);
                    valB = new Date(b.cells[5].textContent);
                    return valA - valB;
                case 'date-desc':
                    valA = new Date(a.cells[5].textContent);
                    valB = new Date(b.cells[5].textContent);
                    return valB - valA;
                case 'time-asc':
                    valA = a.cells[4].textContent;
                    valB = b.cells[4].textContent;
                    return valA.localeCompare(valB);
                case 'time-desc':
                    valA = a.cells[4].textContent;
                    valB = b.cells[4].textContent;
                    return valB.localeCompare(valA);
            }
        });
        rows.forEach(row => tableBody.appendChild(row));
    }
    searchInput.addEventListener('input', filterRows);
    sortOptions.addEventListener('change', sortRows);
});


$('#editModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    
   
    var adminId = button.data('id');
    var fullName = button.data('fullname');
    var username = button.data('username');
    var password = button.data('password'); 

    
    var modal = $(this);
    modal.find('#editAdminId').val(adminId);
    modal.find('#editFullName').val(fullName);
    modal.find('#editUsername').val(username);
    modal.find('#editPassword').val(password);
});




document.getElementById('generateReportBtn').addEventListener('click', function () {
    // Get the table data
    let tableData = [];
    let totalSales = 0; // Initialize total sales
    let rows = document.querySelectorAll('#reservationTable-history tr');

    rows.forEach((row) => {
        let rowData = [];
        let cells = row.querySelectorAll('td');
        
        // Only process rows that have cells (to skip header or empty rows)
        if (cells.length > 0) {
            cells.forEach((cell, index) => {
                const cellValue = cell.innerText;
                rowData.push(cellValue);
                
                // Assuming the price is in the 8th column (index 7)
                if (index === 8) {
                    totalSales += parseFloat(cellValue) || 0; // Add price to total sales, handling NaN with || 0
                }
            });
            tableData.push(rowData);
        }
    });

    // Use jsPDF and jsPDF AutoTable to create a PDF document
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Add title to the PDF
    doc.text("Reservation Report", 14, 20);

    // Define the columns for the table
    const columns = ["No", "Name", "Email", "Backdrop", "Time", "Date", "Package Type", "Pax", "Price"];

    // Add autoTable with black-and-white settings
    doc.autoTable({
        head: [columns],
        body: tableData,
        startY: 30, // Start after the title
        theme: 'plain', // Use 'plain' theme for a simple black-and-white look
        styles: { 
            fontSize: 10, 
            textColor: [0, 0, 0], // Black text color
            lineColor: [0, 0, 0], // Black line color for borders
            lineWidth: 0.1 // Set border line width
        },
        headStyles: { 
            fillColor: [255, 255, 255], // White background for header
            textColor: [0, 0, 0], // Black text color
            fontStyle: 'bold' // Bold font for header
        },
        alternateRowStyles: {
            fillColor: [255, 255, 255], // White background for alternate rows
        },
        margin: { top: 30 }
    });

    // Add total sales below the table
    doc.text(`Total Sales: ${totalSales.toFixed(2)} PHP`, 14, doc.lastAutoTable.finalY + 10); // Position below the table

    // Save the PDF
    doc.save("reservation_report.pdf");
});

</script>
</body>
</html>
    <?php
        if(isset($_SESSION['alert'])) {
            echo $_SESSION['alert'];
            unset($_SESSION['alert']);
        }
    ?>
