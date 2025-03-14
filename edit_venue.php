<?php

include 'connect.php';

if (isset($_GET['id'])) {
    $venue_id = (int) $_GET['id']; // is is used to converts 'id' to an integer for security

    // SQL query to fetch the venue details by ID
    $sql = "SELECT * FROM venue WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $venue_id); 
    $stmt->execute();
    $result = $stmt->get_result(); 
    $venue = $result->fetch_assoc(); 
    $stmt->close();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $venue_id = (int) $_POST['id']; 
    $venue_name = $conn->real_escape_string($_POST['venue_name']); 
    $capacity = (int) $_POST['capacity']; 
    $description = $conn->real_escape_string($_POST['description']); 
    $image_updated = false; 
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name']; 
        $imageName = basename($_FILES['image']['name']); 
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION)); 
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif']; 

        if (in_array($imageExtension, $allowedExtensions)) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); 
            }

            $uniqueImageName = uniqid('venue_', true) . '.' . $imageExtension;
            $imagePath = $uploadDir . $uniqueImageName; 
          
            if (move_uploaded_file($imageTmpPath, $imagePath)) {
                $image_updated = true; 
            } else {
                echo "Failed to upload the image."; 
            }
        } else {
            echo "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed."; 
        }
    }

    if ($image_updated) {
        $sql = "UPDATE venue SET name = ?, capacity = ?, description = ?, image_path = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissi", $venue_name, $capacity, $description, $imagePath, $venue_id);
    } else {
        $sql = "UPDATE venue SET name = ?, capacity = ?, description = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sisi", $venue_name, $capacity, $description, $venue_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Venue updated successfully!'); window.location.href='admindash.php?section=addVenue';</script>";
        exit();
    } else {
        echo "Error updating venue: " . $stmt->error;
    }

    $stmt->close();
} 
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Venue</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        h2 {
            color: #eebb5d;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #f9f9f9;
            border: 2px solid #eebb5d;
            border-radius: 8px;
            padding: 20px 30px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Input and button styling */
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        button {
            background-color: #eebb5d;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #d8a54a;
        }

      
        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
    
</head>
<body>
    <div>
        <h2>Edit Venue</h2>
        <form action="edit_venue.php" method="POST" enctype="multipart/form-data" >

           
            <input type="hidden" name="id" value="<?php echo $venue['id']; ?>">

            
            <label for="venue_name">Venue Name:</label>
            <input type="text" name="venue_name" value="<?php echo htmlspecialchars($venue['name']); ?>" required>

          
            <label for="capacity">Capacity:</label>
            <input type="number" name="capacity" value="<?php echo $venue['capacity']; ?>" required>

            
            <label for="description">Description:</label>
            <textarea name="description" required><?php echo htmlspecialchars($venue['description']); ?></textarea>

            
            <label for="image">Current Image:</label>
            <?php if (!empty($venue['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($venue['image_path']); ?>" alt="Current Image">
            <?php endif; ?>

        
            <label for="image">Upload New Image :</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit">Update Venue</button>
        </form>
    </div>
</body>
</html>