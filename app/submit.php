<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role = trim($_POST['role']);
    $experience = intval($_POST['experience']);

    if (empty($name) || empty($email) || empty($phone) || empty($role)) {
        echo "All fields are required!";
        exit();
    }

    $stmt = $conn->prepare(
        "INSERT INTO users (name, email, phone, role, experience) VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param("ssssi", $name, $email, $phone, $role, $experience);

    if ($stmt->execute()) {
        echo "<h2>Application Submitted Successfully!</h2>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>