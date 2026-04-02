<?php
$conn = mysqli_connect("localhost","root","","login_db");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $course = trim($_POST['course']);
    $message = trim($_POST['message']);

    // Validate inputs
    if(empty($name) || empty($email) || empty($phone)){
        echo "❌ Please fill all required fields";
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo "❌ Invalid email format";
    } else {
        // Use prepared statements to prevent SQL injection
        $sql = "INSERT INTO login (name, email, phone, course, message) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if($stmt){
            $stmt->bind_param("sssss", $name, $email, $phone, $course, $message);
            
            if($stmt->execute()){
                echo "✅ Data saved successfully";
            } else {
                echo "❌ Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "❌ Error: " . $conn->error;
        }
    }
}
$conn->close();
?>