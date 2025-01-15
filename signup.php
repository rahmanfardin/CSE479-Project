<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

session_unset();
session_destroy();
session_start();

require_once 'dbcon.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];

    $checkUserSql = "SELECT score FROM dino WHERE username='$user'";
    $result = $conn->query($checkUserSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['score'] = $row['score'];
        $_SESSION['user_exists'] = true;
        $_SESSION['username'] = $user;
        $_SESSION['loggin'] = true;
        header("Refresh: 10; url=cse430-Dinosaur-Chrome-Game/index.php");
        echo "Username already exists. Current score: " . $score.$_SESSION['score'].$_SESSION['user_exists'].$_SESSION['username'].$_SESSION['loggin'];
        
    } else {
        $score = 0;
        $insertSql = "INSERT INTO dino (username, score) VALUES ('$user', '$score')";

        if ($conn->query($insertSql) === TRUE) {
            $_SESSION['score'] = 0;
            $_SESSION['user_exists'] = false;
            $_SESSION['username'] = $user;
            $_SESSION['loggin'] = true;
            echo "New record created successfully";
            header("Refresh: 5; url=cse430-Dinosaur-Chrome-Game/index.php");
        } else {
            echo "Error: " . $insertSql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
