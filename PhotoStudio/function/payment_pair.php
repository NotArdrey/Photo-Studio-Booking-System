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
    $package_type = "pair_package";
    $pax = 2;
    $price = 700;
    $paymongo_payment = 35000;


    // cURL initialization
    $curl = curl_init();

    // Prepare the data for the payment link
    $data = [
        'data' => [
            'attributes' => [
                'amount' => $paymongo_payment,
                'description' => 'Payment for service',
                'remarks' => 'Payment for selected method: ' . $paymentMethod,
                'redirect' => [
                    'success' => 'http://localhost/PhotoStudio/page/book_pair.php', 
                    'failed' => 'http://localhost/PhotoStudio/page/book_pair.php', 
                ]
            ]
        ]
    ];

    // Set cURL option
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

            // Execute cURL request
            $response = curl_exec($curl);
            $err = curl_error($curl);

            // Close cURL session
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
                $stmt->bind_param("sssssssssss", $first_name, $last_name, $email, $backdrop, $appointment_time, $appointment_date, $package_type, $pax, $price, $archive, $complete);
    
                if ($stmt->execute()) {
    
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Extract the checkout URL and link ID from the response
                $checkoutUrl = $decodedResponse['data']['attributes']['checkout_url'] ?? '';
                $linkId = $decodedResponse['data']['id'] ?? ''; // Store the link ID for polling

                // Store the link ID in the session
                if ($linkId) {
                    $_SESSION['link_id'] = $linkId; // Store it in the session
                }

                // Redirect to the checkout URL
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
            header("Location: ../page/book_pair.php");
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
        header("Location: ../page/book_pair.php");
        exit(0);
    }



}
?>