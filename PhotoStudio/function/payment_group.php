<?php
require '../config/dbconn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the selected payment method
    $paymentMethod = $_POST['payment_method'];
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $email = $_POST['email'];
    $backdrop = $_POST['backdrop'];
    $appointment_time = $_POST['appointment-time'];
    $appointment_date = $_POST['appointment-date'];
    $extra_person = $_POST['extra-person'];
    $package_type = "group_package";

    $pax = 5;
    $price = 1000;
    $paymongo_payment = 50000;

    if($extra_person == ""){
        $paymongo_payment = 50000;
        $pax = 5;
    }else{
        $price += $extra_person * 200;
        $pax += $extra_person;
        $paymongo_payment += $extra_person * 20000;
    }

    $curl = curl_init();

    $data = [
        'data' => [
            'attributes' => [
                'amount' => $paymongo_payment,
                'description' => 'Payment for service',
                'remarks' => 'Payment for selected method: ' . $paymentMethod,
                'redirect' => [
                    'success' => 'http://localhost/PhotoStudio/page/book_group.php', 
                    'failed' => 'http://localhost/PhotoStudio/page/book_group.php', 
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
  
                // Decode the JSON response
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


handle: /* 
    /** 
    //redirect check if payment is successful or not
    if (isset($_SESSION['link_id'])) {
        $paymentStatus = checkPaymentStatus($_SESSION['link_id']);
        

        if ($paymentStatus == 'paid') {
            // update db confirmation email

            $package_type = "solo_package";
                     
            $sql = "INSERT INTO users (first_name, last_name, email, time, date, package_type) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $first_name, $last_name, $email, $appointment_time, $appointment_date, $package_type);

        
            if ($stmt->execute()) {
        
                $_SESSION['alert'] = "
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration successful!',
                        text: 'Please verify your email.',
                    });
                </script>
                ";

                header("Location: ../page/book_solo.html");
            } else {
                $_SESSION['alert'] = "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration failed!',
                        text: 'Please try again.',
                    });
                </script>
                ";
                header("Location: ../page/book_solo.html");
            }        


            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Payment successful',
                });
            </script>
            ";
            header("Location: ../page/book_solo.html");
            exit(0);
        } elseif ($paymentStatus == 'unpaid') {

            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Unpaid',
                    text: 'Please pay the amount',
                });
            </script>
            ";
            header("Location: ../page/book_solo.html");
            exit(0);
        } elseif ($paymentStatus == 'failed') {
            // Handle failed payment
            $_SESSION['alert'] = "
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Payment Failed',
                    text: 'Please try again',
                });
            </script>
            ";
            header("Location: ../page/book_solo.html");
            exit(0);
        }
    }
}

web hook retrieve link: 
 
 curl --request POST \
     --url https://api.paymongo.com/v1/webhooks$linkId \
     --header 'accept: application/json' \
     --header 'authorization: Basic c2tfdGVzdF9SWFdhazk1REZmY1huSGczS1ZCa3RrcTY6' \
     --header 'content-type: application/json' \
     --data '
{
  "data": {
    "attributes": {
      "events": [
        "payment.paid",
        "payment.failed"
      ],
      "url": "link of my website"
    }
  }
}
'

RETURN LINK
function checkPaymentStatus($linkId) {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.paymongo.com/v1/links/$linkId",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Authorization: Basic c2tfdGVzdF9SWFdhazk1REZmY1huSGczS1ZCa3RrcTY6', 
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #: " . $err;
        return null; // Return null on error
    } else {
        $decodedResponse = json_decode($response, true);
        $status = $decodedResponse['data']['attributes']['status'] ?? '';
        return $status; // Return the payment status
    }
}
*/

}
?>