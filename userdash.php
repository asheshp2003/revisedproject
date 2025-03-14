<?php 
session_start();

// to check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: signin.php");
    exit();
}

include 'connect.php'; 

// to fetch user details using session
$customer_id = $_SESSION['customer_id']; 

// to get user details
$query_user = "SELECT * FROM customer WHERE customer_id = ?";
$stmt_user = $conn->prepare($query_user);

if (!$stmt_user) {
    die("Error preparing user query: " . $conn->error);
}

$stmt_user->bind_param("i", $customer_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// to fetch approved bookings for the user
$query_approved = "SELECT * FROM bookings WHERE customer_id = ? AND status = 'approved' ORDER BY created_at DESC";
$stmt_approved = $conn->prepare($query_approved);

if (!$stmt_approved) {
    die("Error preparing approved bookings query: " . $conn->error);
}

$stmt_approved->bind_param("i", $customer_id);
$stmt_approved->execute();
$result_approved = $stmt_approved->get_result();

// to fetch pending bookings for the user
$query_pending = "SELECT * FROM bookings WHERE customer_id = ? AND status = 'pending' ORDER BY created_at DESC";
$stmt_pending = $conn->prepare($query_pending);

if (!$stmt_pending) {
    die("Error preparing pending bookings query: " . $conn->error);
}

$stmt_pending->bind_param("i", $customer_id);
$stmt_pending->execute();
$result_pending = $stmt_pending->get_result();

// to fetch declined bookings
$query_declined = "SELECT * FROM bookings WHERE customer_id = ? AND status = 'declined' ORDER BY created_at DESC";
$stmt_declined = $conn->prepare($query_declined);

if (!$stmt_declined) {
    die("Error preparing declined bookings query: " . $conn->error);
}

$stmt_declined->bind_param("i", $customer_id);
$stmt_declined->execute();
$result_declined = $stmt_declined->get_result();

// to close prepared statements
$stmt_user->close();
$stmt_approved->close();
$stmt_pending->close();
$stmt_declined->close();


$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #ffffff; 
            color: #333;
        }
        header {
            background-color: #f9f9f9;
            padding: 10px;
            text-align: center;
            position: relative;
        }
        header h1 {
            margin: 0;
            color: #eebb5d; 
        }
        .logout-button {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 8px 15px;
            background-color: #eebb5d; 
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .logout-button:hover {
            background-color: #d9a84c; 
        }
        .container {
            margin: 20px;
        }
        .buttons {
            margin-bottom: 20px;
        }
        .buttons button {
            margin-right: 10px;
            padding: 10px;
            background-color: #eebb5d; 
            border: none;
            border-radius: 3px;
            cursor: pointer;
            color: white; 
        }
        .buttons button:hover {
            background-color: #d9a84c; 
        }
        .section {
            display: none;
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9; 
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .section.active {
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #eebb5d; 
            color: white; 
        }
        
        form {
            background-color: #f9f9f9; 
            border: 2px solid #eebb5d; 
            border-radius: 8px; 
            padding: 20px; 
            max-width: 500px; /
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            margin: auto; 
        }
        label {
            display: block; 
            font-weight: bold; 
            margin-bottom: 8px; 
            color: #333; 
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="time"] {
            width: 100%; 
            padding: 10px; 
            margin-bottom: 20px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            font-size: 14px; 
            box-sizing: border-box; 
        }
        input[type="radio"] {
            margin-right: 5px;
        }
        button {
            background-color: #eebb5d; 
            color: white; 
            padding: 10px 20px; 
            border-radius: 4px; 
            cursor: pointer; 
            font-weight: bold; 
            transition: background-color 0.3s ease; 
        }
        button:hover {
            background-color: #d9a84c; 
        }
    </style>
    <script>

function restrictPastDates() {
            const dateInput = document.getElementById('date');
            const today = new Date();
            const formattedToday = today.toISOString().split('T')[0];
            dateInput.min = formattedToday;
        }

        // to validate form inputs before submission
        function validateBookingForm() {
    const startTime = document.getElementById('start_time').value.trim();
    const endTime = document.getElementById('end_time').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const date = document.getElementById('date').value.trim();

    // to validate Start and End Time
    if (!startTime || !endTime) {
        alert("Please select both start and end times.");
        return false;
    }
    if (startTime >= endTime) {
        alert("End time must be later than start time.");
        return false;
    }

    //to validate nepali number
    const phoneRegex = /^(97|98|96)\d{8}$/;
if (!phoneRegex.test(phone)) {
    alert("Please enter a valid 10-digit Nepali mobile number.");
    return false;
}


    // to validate Date (Should not be in the past)
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Reset hours to compare only the date
    const selectedDate = new Date(date);

    if (selectedDate < today) {
        alert("The booking date cannot be in the past.");
        return false;
    }

    return true;
}


        document.addEventListener('DOMContentLoaded', restrictPastDates);
    </script>
</head>
<body>
<header>
    <h1>Welcome, <?php echo htmlspecialchars($user['fullname']); ?>!</h1>
    <a href="logout.php" class="logout-button">Log Out</a>
</header>
<div class="container">
    <div class="buttons">
        <button onclick="showSection('booking-form')">Booking Form</button>
        <button onclick="showSection('approved-bookings')">Approved Bookings</button>
        <button onclick="showSection('pending-bookings')">Pending Bookings</button>
        <button onclick="showSection('declined-bookings')">Declined Bookings</button>
    </div>
    <div id="booking-form" class="section active">
    <h2>Booking Form</h2>
    <form action="process_booking.php" method="POST" onsubmit="return validateBookingForm()">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['fullname']); ?>" required /><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required /><br><br>

    <label for="phone">Phone:</label>
    <input type="tel" id="phone" name="phone" required /><br><br>

    <label>Choose Venue:</label><br>
    <?php 
    include 'connect.php';
    $sql = "SELECT name FROM venue ORDER BY id ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($venue = $result->fetch_assoc()) {
            echo '<label><input type="radio" name="venue" value="' . htmlspecialchars($venue['name']) . '" required /> ' . htmlspecialchars($venue['name']) . '</label><br>';
        }
    } else {
        echo '<p>No venues available for booking.</p>';
    }
    ?><br>

    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required /><br><br>

    <label for="start_time">Start Time:</label>
    <input type="time" id="start_time" name="start_time" required /><br><br>

    <label for="end_time">End Time:</label>
    <input type="time" id="end_time" name="end_time" required /><br><br>

    <button type="submit">Submit Booking</button>
</form>

</div>
</div>
</div>
<div id="approved-bookings" class="section">
    <h2>Approved Bookings</h2>
    <?php if ($result_approved->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Venue</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($booking = $result_approved->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['venue']); ?></td>
                        <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['start_time']) . " - " . htmlspecialchars($booking['end_time']); ?></td>
                        <td><?php echo htmlspecialchars($booking['created_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No approved bookings found.</p>
    <?php endif; ?>
</div>

<div id="pending-bookings" class="section">
    <h2>Pending Bookings</h2>
    <?php if ($result_pending->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Venue</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($booking = $result_pending->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['venue']); ?></td>
                        <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['start_time']) . " - " . htmlspecialchars($booking['end_time']); ?></td>
                        <td><?php echo htmlspecialchars($booking['created_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pending bookings found.</p>
    <?php endif; ?>
</div>

<div id="declined-bookings" class="section">
    <h2>Declined Bookings</h2>
    <?php if ($result_declined->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Venue</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($booking = $result_declined->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['venue']); ?></td>
                        <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['start_time']) . " - " . htmlspecialchars($booking['end_time']); ?></td>
                        <td><?php echo htmlspecialchars($booking['created_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No declined bookings found.</p>
    <?php endif; ?>
</div>

<script>
    function showSection(sectionId) {
        const sections = document.querySelectorAll('.section');
        sections.forEach(section => section.classList.remove('active'));
        document.getElementById(sectionId).classList.add('active');
    }
</script>
</body>
</html>
