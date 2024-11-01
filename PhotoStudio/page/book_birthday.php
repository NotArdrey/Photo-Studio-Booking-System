

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoStudio</title>
    <link rel="stylesheet" href="../style/book_birthday.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha384-0u1+Ko2A3WSXU8B8v7uYF6WfhMTzAC5ZfZx5ddtKkM4KaNmi5a68F40Vz5Dui1Li" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<body>
    <header class="header">

        <div class="social-media">
            Captured By K 
            </a>
        </div> 

         <!-- Navigation Bar -->
        <nav class="nav" aria-label="Main navigation">
            <ul class="nav_list">
                <li class="nav_item">
                    <a class="link--nav" href="../page/index.html">Home</a>
                </li>
                <li class="nav_item">
                    <a class="link--nav" href="../page/bookings.html">Book</a>
                </li>
                <li class="nav_item">
                    <a class="link--nav" href="../page/faqs.html">FAQs</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="title">
        <div class="appointment-logo">
            <i class="fas fa-calendar-check"></i> 
        </div>
        <h2>Select Appointment</h2>
    </div>


    <div class="container">
        <div class="photo-section-first">
            <img src="../Photos/img10.jpg" alt="Solo Photo"  class = "photo-one">
            <div class="details">
                <h3>Birthday Package</h3>
                <h4>1-2 Years Old</h4>
                <p>₱800.00</p>
                <ul> 
                    <li>20-minute session capturing adorable moments</li>
                    <li>Includes six enhanced soft copies</li>
                    <li>one charming backdrop to enhance visual appeal</li>
                    <li>For 1-year-olds, shoes or sandals are provided</li>
                </ul>
            </div>
        </div>

        <div class="photo-section-first">
            <img src="../Photos/img4.jpg" alt="Solo Photo" class="photo">
            <div class="details">
                <h3>Birthday Package</h3>
                <h4>3-4 Years Old</h4>
                <p>₱1,000.00</p>
                <ul>
                    <li>20-minute session capturing joyful expressions</li>
                    <li>Includes seven enhanced soft copies</li>
                    <li>one fun backdrop to enhance visual appeal</li>
            
                </ul>
            </div>
        </div>

        <div class="photo-section-first">
            <img src="../Photos/img2.jpg" alt="Solo Photo" class="photo">
            <div class="details">
                <h3>Birthday Package</h3>
                <h4>5-6 Years Old</h4>
                <p>₱1,500.00</p>
                <ul>
                    <li>20-minute session capturing playful moments</li>
                    <li>Includes nine enhanced soft copies</li>
                    <li>One vibrant backdrop to enhance visual appeal</li>
                </ul>
            </div> 
        </div>
        <div class="title-two">
            <div class="checklist-logo">
                <i class="fas fa-check-square"></i>
            </div>
            <h2>Details to Appointment</h2>
        </div>
        <div class="photo-section">
            <div class="details-forms">
                <form class="appointment-form" action = "../function/payment_birthday.php" method = "POST">
                    <div class="column">
                        <label for="first-name">First Name:</label>
                        <input type="text" id="first-name" name="first-name" required>
    
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                             
                        <label for="appointment-time">Appointment Time:</label>
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

                        <label for="appointment-date">Appointment Date:</label>
                        <input type="date" id="appointment-date" name="appointment-date" required>


                    </div>

                    <div class="column">
                        <label for="last-name">Last Name:</label>
                        <input type="text" id="last-name" name="last-name" required>
        
                        <label for="package">Preferred Package:</label>
                        <select id="package" name="package" required>
                            <option value="" disabled selected>Select a Package</option>
                            <option value="1-2 Years Old">1-2 Years Old</option>
                            <option value="3-4 Years Old">3-4 Years Old</option>
                            <option value="5-6 Years Old">5-6 Years Old</option>
                        </select>

                        <label for="backdrop">Preferred Backdrop:</label>
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
                    </div>
                <div class="btn">
                    <button type="submit" class="styled-button">
                    Pay Downpayment

                    </button>
                </div>
                </div>
            </form> 
        </div>
    </div>
    <div id="calendar"></div>

    <footer class = "footer">
        <h2>Reach Us Here</h2>
        <p><a href="mailto:neilardrey14@gmail.com">neilardrey14@gmail.com</a></p>
        <p>+63 094710775227</p>
        <p>102 Purok 2, Batang, Ligao, Philippines</p>
        <a href="https://www.facebook.com" target="_blank" aria-label="Facebook" id = "footer-facebook"><i class="fab fa-facebook"></i></a>
        <a href="https://www.instagram.com" target="_blank" aria-label="Instagram" id = "footer-instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://www.tiktok.com" target="_blank" aria-label="TikTok" id = "footer-tiktok"><i class="fab fa-tiktok"></i></a>
    </footer>



</body>
</html>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('appointment-date');
        const timeSelect = document.getElementById('appointment-time');
        
        // Set minimum date to 2 days from now
        const today = new Date();
        const minDate = new Date();
        minDate.setDate(today.getDate() + 2);
        
        // Set maximum date to 2 months from now
        const maxDate = new Date();
        maxDate.setMonth(today.getMonth() + 2);
        
        dateInput.setAttribute('min', minDate.toISOString().split('T')[0]);
        dateInput.setAttribute('max', maxDate.toISOString().split('T')[0]);
    });
</script>


<?php
            if(isset($_SESSION['alert'])) {
                echo $_SESSION['alert'];
                unset($_SESSION['alert']);
            }
?>
