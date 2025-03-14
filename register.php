<?php 

include 'connect.php';
// if(isset($_POST['fullname'])){
// echo "<p>hi</p>";
// }
// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';
// echo($_SERVER['HTTP_REFERER']);
// if (isset($_SERVER['HTTP_REFERER'])) {
//     $refererParts = explode('/', $_SERVER['HTTP_REFERER']);
//     foreach ($refererParts as $part) {
//         if (strpos($part, 'signup') !== false) {
//             // Found 'signup' in the referer
//             // Proceed with your signup logic
//             break;
//         }
//     }
// }
$referrer=$_SERVER['HTTP_REFERER'];
$referrer_arr=explode('/', $referrer);
$count=(count($referrer_arr));

// if($_SERVER['HTTP_REFERER']=='http://localhost/finalproject/signup.php'){
if($referrer_arr[$count-1]=='signup.php'){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password using bcrypt
    $password = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $checkEmail = "SELECT * FROM customer WHERE email = '$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "Email Address Already Exists!";
    } else {
        $insertQuery = "INSERT INTO customer(fullname, email, password) VALUES ('$fullname', '$email', '$password')";

        if ($conn->query($insertQuery) === TRUE) {
            header("location: signin.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>






