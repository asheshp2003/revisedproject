<?php
require_once 'connect.php';

if (isset($_GET['booking_id']) && !empty($_GET['booking_id'])) {
    $booking_id = (int)$_GET['booking_id'];

    if ($booking_id > 0) {
        $sql = "DELETE FROM bookings WHERE booking_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header('Location: admindash.php?msg=Booking deleted');
        } else {
            header('Location: admindash.php?msg=Error: Booking not found');
        }
        $stmt->close();
    } else {
        header('Location: admindash.php?msg=Invalid Booking ID');
    }
} else {
    header('Location: admindash.php?msg=No Booking ID provided');
}
?>
