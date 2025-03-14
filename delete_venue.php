<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $venue_id = (int) $_GET['id'];

    $sql = "DELETE FROM venue WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $venue_id);

    if ($stmt->execute()) {
        header("Location: admindash.php?msg=Venue deleted successfully!");
        exit;
    } else {
        echo "Error deleting venue: " . $stmt->error;
    }
}
?>