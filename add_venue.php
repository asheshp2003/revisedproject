<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venue_name = $conn->real_escape_string($_POST['venue_name']);
    $capacity = (int) $_POST['capacity'];
    $description = $conn->real_escape_string($_POST['description']); // Clean input

    //to handle image upload
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
                $stmt = $conn->prepare("INSERT INTO venue (name, capacity, description, image_path) VALUES (?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("siss", $venue_name, $capacity, $description, $imagePath);

                    if ($stmt->execute()) {
                        echo "<script>alert('Venue added successfully!'); window.location.href='admindash.php';</script>";
                        exit;
                    } else {
                        echo "Error adding venue: " . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    echo "Failed to prepare the SQL statement.";
                }
            } else {
                echo "Failed to upload the image.";
            }
        } else {
            echo "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        echo "Image upload error.";
    }
} else {
    echo "Invalid request method.";
}

//  to close connection
$conn->close();
?>
