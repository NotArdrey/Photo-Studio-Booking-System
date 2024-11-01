<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoStudio</title>
    <link rel="stylesheet" href="../style/book_solo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha384-0u1+Ko2A3WSXU8B8v7uYF6WfhMTzAC5ZfZx5ddtKkM4KaNmi5a68F40Vz5Dui1Li" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


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
            <img src="../Photos/img13.jpg" alt="Solo Photo" class="photo">
            <div class="details">
                <h3>Group Package</h3>
                <p>₱1,000.00</p>
                <ul>
                    <li>30-minute photoshoot for three to five person</li>
                    <li>Includes ten enhanced soft copies of the images</li>
                    <li>One cohesive backdrop to enhance visual appeal</li>
                    <li>Selected photos will undergo post-processing and enhancement</li>
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
                <form class="appointment-form" action = "../function/payment_group.php" method ="POST">
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
 
                        <label for="Extra-person"> Extra Person (₱200.00 each, max of 10):</label>
                        <input type="number" name="extra-person" min="1" max="10"oninput="validateInput(this)" >

                    </div>

                    <div class="column">
                        <label for="last-name">Last Name:</label>
                        <input type="text" id="last-name" name="last-name" required>
        
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
                                           
                        <label for="appointment-date">Appointment Date:</label>
                        <input type="date" id="appointment-date" name="appointment-date" required>
                    </div>
                
                            
                <div class="btn">
                    <button type="submit" class="styled-button">
                    Pay Downpayment

                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    

    
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
</script>

<?php
            if(isset($_SESSION['alert'])) {
                echo $_SESSION['alert'];
                unset($_SESSION['alert']);
            }
?>