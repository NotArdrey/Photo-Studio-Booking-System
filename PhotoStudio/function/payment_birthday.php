<?php
require '../config/dbconn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $paymentMethod = $_POST['payment_method'];
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $email = $_POST['email'];
    $backdrop = $_POST['backdrop'];
    $appointment_time = $_POST['appointment-time'];
    $appointment_date = $_POST['appointment-date'];
    $package_type = $_POST['package']; 
    $pax = 1;
    $price = 1000;
    $paymongo_payment = 80000;

    
    if ($package_type == "1-2 Years Old") {
        $price = 400;
        $paymongo_payment = 40000;
    } else if ($package_type == "3-4 Years Old") {
        $price = 500;
        $paymongo_payment = 50000;
    } else if ($package_type == "5-6 Years Old") {
        $price = 750;
        $paymongo_payment = 75000;
    }
 
    $curl = curl_init();


    $data = [
        'data' => [
            'attributes' => [
                'amount' => $paymongo_payment,
                'description' => 'Payment for service',
                'remarks' => 'Payment for selected method: ' . $paymentMethod,
                'redirect' => [
                    'success' => 'http://localhost/PhotoStudio/page/book_birthday.php', 
                    'failed' => 'http://localhost/PhotoStudio/page/book_birthday.php', 
                ]
            ]
        ]
    ];

    //cURL option
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.paymongo.com/v1/links',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Authorization:',
            'Content-Type: application/json',
        ],
    ]);

    if (preg_match('/^[a-zA-Z\s]+$/', $first_name) && preg_match('/^[a-zA-Z\s-]+$/', $last_name)) {

        if (preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {

            $response = curl_exec($curl);
            $err = curl_error($curl);

      
            curl_close($curl);
 
            if ($err) {
                echo "cURL Error #: " . $err;
            } else {
                $archive = "no";
                $complete = "no";
   
                $decodedResponse = json_decode($response, true);
            
                $sql = "INSERT INTO users (first_name, last_name, email, backdrop, time, date, package_type, pax, price, archive, complete) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                

                $stmt = $conn->prepare($sql);
                
             
                if ($stmt === false) {
                    die('Prepare failed: ' . htmlspecialchars($conn->error));
                }
                

                $stmt->bind_param("sssssssssss", $first_name, $last_name, $email, $backdrop, $appointment_time, $appointment_date, $package_type, $pax, $price, $archive, $complete);
                
                if ($stmt->execute()) {
                
                } else {
                    echo "Error: " . $stmt->error;
                }

                $checkoutUrl = $decodedResponse['data']['attributes']['checkout_url'] ?? '';
                $linkId = $decodedResponse['data']['id'] ?? ''; 

               
                if ($linkId) {
                    $_SESSION['link_id'] = $linkId; 
                }

                if ($checkoutUrl) {

                header("Location: $checkoutUrl");
                exit();
                } else {
                    echo "Error generating payment link. Please try again.";
                }
            }
        } else {
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Email',
                    text: 'Follow email format',
                });
            </script>
            ";
            header("Location: ../page/book_solo.html");
            exit(0);
        }
    } else {
        $_SESSION['alert'] = "
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Name',
                text: 'Name should be letters only',
            });
        </script>
        ";
        header("Location: ../page/book_solo.html");
        exit(0);
    }
}
?>