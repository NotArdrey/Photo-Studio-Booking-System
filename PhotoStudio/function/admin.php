<?php
require '../config/dbconn.php';
session_start();

    $edit_id = $first_name = $last_name = $email = $backdrop = $time = $date = $package_type = $pax = $price = "";
    $edit_mode = false;
    
    if (isset($_GET['reservation_id'])) {
        $edit_id = $_GET['reservation_id'];
        $edit_mode = true;

        $sql = "SELECT * FROM users WHERE id = $edit_id";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc(); 
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $email = $row['email'];
            $backdrop = $row['backdrop'];
            $time = $row['time'];
            $date = $row['date'];
            $package_type = $row['package_type'];
            $pax = $row['pax'];
            $price = $row['price'];
        }
    }    


    if (isset($_POST['complete-btn'])) {
        $edit_id = $_POST['reservation_id'];
        $status = "yes";
    
        $sql = "UPDATE users SET complete = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status,$edit_id);
    
        if ($stmt->execute()) {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Transaction complete!',
                });
            </script>
            ";     
            header("Location: ../page/admin.php");
            exit();

        } else {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Error Updating',
                    text: 'Please try again',
                });
            </script>
            ";     
            header("Location: ../page/admin.php");
            exit();
        }

    }
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['complete'])) {
        $edit_id = $_POST['edit_id'];
        $status = "yes";
    
        $sql = "UPDATE users SET complete = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $status,$edit_id);
    
        if ($stmt->execute()) {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Transaction complete!',
                });
            </script>
            ";     
            header("Location: ../page/admin.php");
            exit();

        } else {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Error Updating',
                    text: 'Please try again',
                });
            </script>
            ";     
            header("Location: ../page/admin.php");
            exit();
        }

    }

    
    //update admin
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save-changes'])) {

        $edit_id = $_POST['adminId'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        if ($_SESSION['userID'] != $edit_id) {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Unauthorized',
                    text: 'You are not allowed to edit this admin record.',
                });
            </script>
            ";
            header("Location: ../page/admin.php");
            exit();
        }
    
        $sql = "SELECT first_name, last_name, username, password FROM admin WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $stmt->bind_result($current_first_name, $current_last_name, $current_username, $current_password);
        $stmt->fetch();
        $stmt->close();
     
        $isChanged = false;
        if ($first_name !== $current_first_name || $last_name !== $current_last_name || $username !== $current_username) {
            $isChanged = true;
        }
    
        if (!empty($password) && !password_verify($password, $current_password)) {
            $isChanged = true;
        }
    
        if (!$isChanged) {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'No Changes Detected',
                    text: 'Values are the same.',
                });
            </script>
            ";
            header("Location: ../page/admin.php");
            exit();
        }
    
        
        if (!empty($password)) {
           
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE admin SET first_name = ?, last_name = ?, username = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
    
            if ($stmt === false) {
                die("Failed to prepare the SQL statement: " . $conn->error);
            }
    
            $stmt->bind_param("ssssi", $first_name, $last_name, $username, $hashedPassword, $edit_id);
        } else {
            
            $sql = "UPDATE admin SET first_name = ?, last_name = ?, username = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
    
            if ($stmt === false) {
                die("Failed to prepare the SQL statement: " . $conn->error);
            }
    
            $stmt->bind_param("sssi", $first_name, $last_name, $username, $edit_id);
        }
    
       
        if ($stmt->execute()) {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Record has been updated',
                });
            </script>
            ";
            header("Location: ../page/admin.php");
            exit();
        } else {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Error Updating',
                    text: 'Please try again',
                });
            </script>
            ";
            header("Location: ../page/admin.php");
            exit();
        }
    }


    //archive records for user
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['archive']) && $_POST['archive'] === 'true') {
        $edit_id = $_POST['edit_id'];
        $archive = "yes";
    
        $query = "UPDATE users SET archive = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $archive, $edit_id); 
    
    
        if ($stmt->execute()) {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Record has been archived',
                });
            </script>
            ";
            header("Location: ../page/admin.php");
            exit();
        } else {
           
            echo "Error: " . $stmt->error;
        }
    
    } else {
        
    }




   //update user
   if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $edit_id = $_POST['edit_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $backdrop = $_POST['backdrop'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $package_type = $_POST['package_type'];
    $pax = $_POST['pax'];
    $price = $_POST['price'];


    $sql = "SELECT first_name, last_name, email, backdrop, time, date, package_type, pax, price FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $stmt->bind_result($current_first_name, $current_last_name, $current_email, $current_backdrop, $current_time, $current_date, $current_package_type, $current_pax, $current_price);
    $stmt->fetch();
    $stmt->close();

    $isChanged = false;
    if ($first_name !== $current_first_name || $last_name !== $current_last_name || $email !== $current_email || 
        $backdrop !== $current_backdrop || $time !== $current_time || $date !== $current_date || 
        $package_type !== $current_package_type || $pax != $current_pax || $price != $current_price) {
        $isChanged = true;
    }

    if (!$isChanged) {
        $_SESSION['alert'] = "
        <script>
            Swal.fire({
                icon: 'info',
                title: 'No Changes Detected',
                text: 'Values are the same.',
            });
        </script>
        ";
        header("Location: ../page/admin.php");
        exit();
    }

    
    $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, backdrop = ?, time = ?, date = ?, package_type = ?, pax = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Failed to prepare the SQL statement: " . $conn->error);
    }

    $stmt->bind_param("sssssssiis", $first_name, $last_name, $email, $backdrop, $time, $date, $package_type, $pax, $price, $edit_id);

    // Execute the update
    if ($stmt->execute()) {
        $_SESSION['alert'] = "
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Record has been updated',
            });
        </script>
        ";
        header("Location: ../page/admin.php");
        exit();
    } else {
        $_SESSION['alert'] = "
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Error Updating',
                text: 'Please try again',
            });
        </script>
        ";
        header("Location: ../page/admin.php");
        exit();
    }
}




    //add admin
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add-admin-btn'])) {

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
       
        $insert_sql = "INSERT INTO admin (first_name, last_name, username, password) VALUES (?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        
        if ($insert_stmt === false) {
            die("Failed to prepare the INSERT statement: " . $conn->error);
        }
        
        $insert_stmt->bind_param("ssss", $first_name, $last_name, $username, $hashed_password);
        
        if ($insert_stmt->execute()) {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Admin has been added successfully',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
            ";
            header("Location: ../page/admin.php");
            exit();
        } else {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error Inserting Admin',
                    text: 'Please try again',
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
            ";
            header("Location: ../page/admin.php");
            exit();
        }
    }


    //add user
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add-list-btn'])) {
        // Initialize an array to hold validation errors
        $errors = [];
    
        // Get form data
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $appointment_time = $_POST['appointment-time'];
        $appointment_date = $_POST['appointment-date'];
        $package_type = $_POST['package'];
        $backdrop = $_POST['backdrop'];
        $extra_person = $_POST['extra-person'];
    
        // Validate first name
        if (empty($first_name)) {
            $errors[] = "First name is required.";
        }
    
        // Validate last name
        if (empty($last_name)) {
            $errors[] = "Last name is required.";
        }
    
        // Validate email
        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!validateEmail($email)) {
            $errors[] = "Invalid email format.";
        }
    
        // Validate appointment time
        if (empty($appointment_time)) {
            $errors[] = "Appointment time is required.";
        }
    
        // Validate appointment date
        if (empty($appointment_date)) {
            $errors[] = "Appointment date is required.";
        } elseif (strtotime($appointment_date) < time()) {
            $errors[] = "Appointment date must be in the future.";
        }
    
        // Validate package
    
        // Validate backdrop
        if (empty($backdrop)) {
            $errors[] = "Preferred backdrop color is required.";
        }

        if ($package_type == "1-2 Years Old") {
            $package_type = "1-2 Years Old";
            $price = 800;
            $pax = 1;
        } else if ($package_type == "3-4 Years Old") {
            $package_type = "3-4 Years Old";
            $price = 1000;
            $pax = 1;
        } else if ($package_type == "5-6 Years Old") {
            $package_type = "5-6 Years Old";
            $price = 1500;
            $pax = 1;
        }else if ($package_type == "solo_package") {
            $package_type = "solo_package";
            $price = 500;
            $pax = 1;
        } else if ($package_type == "pair_package") {
            $package_type = "pair_package";
            $price = 700;
            $pax = 2;
        }else if ($package_type == "group_package") {
            $package_type = "group_package";
            $pax = 5;
            $price = 1000;
            if($extra_person == ""){
                $price = 1000;
                $pax = 5;
            }else{
                $price += $extra_person * 200;
                $pax += $extra_person;
            }
        }

    
        if (empty($errors)) {
            $archive = "no";
            $complete = "no";
            $sql = "INSERT INTO users (first_name, last_name, email, backdrop, time, date, package_type, pax, price, archive, complete) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssss", $first_name, $last_name, $email, $backdrop, $appointment_time, $appointment_date, $package_type, $pax, $price, $archive, $complete);
            
            if ($stmt->execute()) {
                $_SESSION['alert'] = "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Reservation added',
                    });
                </script>
                ";
                header("Location: ../page/admin.php");
                exit(0);
            } else {
                echo "Error: " . $stmt->error;
            }
    
            
            $stmt->close();
        } else {
            
            foreach ($errors as $error) {
                echo "<div class='error'>$error</div>";
            }
        }
    }
    
    






    /**$data = json_decode(file_get_contents('php://input'), true);

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO admin (first_name, last_name, username, password) VALUES (?, ?, ?, ?)");
$fullName = explode(' ', $data['full_name']);
$firstName = $fullName[0];
$lastName = isset($fullName[1]) ? $fullName[1] : ''; // Handle case where there may be only one name
$username = $data['username'];
$password = password_hash($data['password'], PASSWORD_DEFAULT); // Hash the password

// Bind parameters and execute
$stmt->bind_param("ssss", $firstName, $lastName, $username, $password);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add admin.']);
}

$stmt->close();



$stmt = $conn->prepare("UPDATE admin SET first_name = ?, last_name = ?, username = ?, password = ? WHERE id = ?");
$fullName = explode(' ', $data['full_name']);
$firstName = $fullName[0];
$lastName = isset($fullName[1]) ? $fullName[1] : ''; // Handle case where there may be only one name
$username = $data['username'];
$password = password_hash($data['password'], PASSWORD_DEFAULT); // Hash the password
$adminId = $data['adminId'];

// Bind parameters and execute
$stmt->bind_param("ssssi", $firstName, $lastName, $username, $password, $adminId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update admin.']);
}

$stmt->close();
*/
?>
