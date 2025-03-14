<?php 
session_start();
if (!isset($_SESSION['customer_id']) || $_SESSION['role'] !== 'admin') {
    
    header('Location: signin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #eebb5d;
            padding: 10px 20px;
            text-align: center;
        }

        .navbar {
            display: flex;
            background-color:grey;
            overflow: hidden;
            justify-content: center;
        }

        .navbar a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
        }

        .navbar a:hover {
            background-color:  #eebb5d;
            color: black;
        }

        .logout-button {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 8px 15px;
            background-color:  #eebb5d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .logout-button:hover {
            background-color: #ff4c29;
        }

        .content {
            display: none;
            padding: 20px;
        }

        .active {
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #eebb5d;
            color: white;
        }
        form {
    border: 2px solid #eebb5d; 
    padding: 20px;            
    border-radius: 5px;       
    width: 50%;               
    margin: 20px auto;        
    background-color: #fff8e6; 
}

form input, form textarea, form button {
    width: 100%;              
    margin-bottom: 10px;      
    padding: 8px;             
    border: 1px solid #eebb5d; 
    border-radius: 5px;       
    box-sizing: border-box;   
}
form input:focus, form textarea:focus {
    outline: none;            
    border: 2px solid #d69a4d;
    background-color: #fff4dc; 
}

form button {
    background-color: #eebb5d; 
    color: white;              
    border: none;              
    cursor: pointer;          
    font-weight: bold;
    padding: 10px 15px;        
    border-radius: 5px;        
}

form button:hover {
    background-color: #d69a4d; 
    color: #fff;               
}
    </style>
    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.content');
            sections.forEach(section => section.classList.remove('active'));
            document.getElementById(sectionId).classList.add('active');
        }
    function validateForm() {
    const venueName = document.getElementById('venue_name').value.trim();
    const capacity = document.getElementById('capacity').value.trim();
    const description = document.getElementById('description').value.trim();
    const image = document.getElementById('image').files[0];

    // Validate Venue Name
    if (venueName === "") {
        alert("Venue Name is required.");
        return false;
    }
    if (venueName.length < 3 || venueName.length > 50) {
        alert("Venue Name must be between 3 and 50 characters.");
        return false;
    }
    const venueNamePattern = /^[a-zA-Z0-9\s\-,&']+$/; 
    if (!venueNamePattern.test(venueName)) {
        alert("Venue Name can only contain letters, numbers, spaces, hyphens, commas, ampersands, and apostrophes.");
        return false;
    }

    // Validate Capacity
    if (capacity === "") {
        alert("Capacity is required.");
        return false;
    }
    const capacityNumber = Number(capacity);
    if (isNaN(capacityNumber) || capacityNumber <= 0 || capacityNumber > 10000) {
        alert("Capacity must be a positive number and less than or equal to 10,000.");
        return false;
    }
    if (!Number.isInteger(capacityNumber)) {
        alert("Capacity must be a whole number.");
        return false;
    }

    // Validate Description
    if (description === "") {
        alert("Description is required.");
        return false;
    }
    if (description.length < 10 || description.length > 500) {
        alert("Description must be between 10 and 500 characters.");
        return false;
    }

    // Validate Image
    if (!image) {
        alert("Venue Image is required.");
        return false;
    }

    const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (!allowedExtensions.exec(image.name)) {
        alert("Invalid file type. Please upload an image with extensions: jpg, jpeg, png, or gif.");
        return false;
    }

    const maxSizeInMB = 5; // 5 MB
    if (image.size > maxSizeInMB * 1024 * 1024) {
        alert(`Image size must not exceed ${maxSizeInMB} MB.`);
        return false;
    }

    return true;
}

    </script>
</head>

<body>
    <header>
        <h1>Welcome Admin</h1>
        <a href="adminlogout.php" class="logout-button">Log Out</a>
    </header>

    <div class="navbar">
        <a href="javascript:void(0)" onclick="showSection('customerBooking')">Customer Booking</a>
        <a href="javascript:void(0)" onclick="showSection('addVenue')">Add Venue</a>
    </div>

    <div id="customerBooking" class="content active">
        <h2>Booking Management</h2>
        <table>
    <tr>
        <th>ID</th>
        <th>Booking Id</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Hall Name</th>
        <th>Booking Date</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Status</th>
        <th>Created Date and Time</th>
        <th>Actions</th>
    </tr>
    <?php 
    include 'connect.php'; 
    $sql = "SELECT * FROM bookings";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) <= 0) {
        echo "<tr><td colspan='11'>No data found in table.</td></tr>";
    } else {
        $i = 1;
        while ($row = mysqli_fetch_assoc($query)) {
    ?>
            <tr>
                <td><?php echo $i++ . "."; ?></td>
                <td><?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['venue']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['start_time']; ?></td>
                <td><?php echo $row['end_time']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <a href="approve.php?booking_id=<?php echo $row['booking_id']; ?>">Approve</a> 
                    <a href="delete.php?booking_id=<?php echo $row['booking_id']; ?>" onclick="return confirm('Are you sure you want to delete this data?')">Delete</a>
                    <a href="decline.php?booking_id=<?php echo $row['booking_id']; ?>" onclick="return confirm('Are you sure you want to decline this booking?')">Decline</a>
                </td>
            </tr>
    <?php
        }
    }
    ?>
</table>

    </div>
<!-- ADD VENUE -->
    
<div id="addVenue" class="content">
    <h2>Add Venue</h2>
    <form action="add_venue.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="venue_name">Venue Name:</label>
        <input type="text" name="venue_name" id="venue_name" required><br><br>

        <label for="capacity">Capacity:</label>
        <input type="number" name="capacity" id="capacity" required><br><br>

        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br><br>

        <label for="image">Venue Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required><br><br>

        <button type="submit">Add Venue</button>
    </form>

    <!-- Manage Venues Table -->
    <h2>Manage Venues</h2>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Capacity</th>
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            include 'connect.php';
            $sql = "SELECT * FROM venue ORDER BY id DESC";
            $result = $conn->query($sql);
            
            while ($venue = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $venue['id']; ?></td>
                    <td><?php echo htmlspecialchars($venue['name']); ?></td>
                    <td><?php echo $venue['capacity']; ?></td>
                    <td><?php echo htmlspecialchars($venue['description']); ?></td>
                    <td><img src="<?php echo $venue['image_path']; ?>" alt="Venue Image" style="width:100px; height:auto;"></td>
                    <td>
                        <a href="edit_venue.php?id=<?php echo $venue['id']; ?>">Edit</a>
                        <a href="delete_venue.php?id=<?php echo $venue['id']; ?>" onclick="return confirm('Are you sure you want to delete this venue?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>