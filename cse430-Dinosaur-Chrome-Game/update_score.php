<?php
session_start();
require_once 'dbcon.php';

if ($_SESSION['loggin'] && isset($_POST['score'])) {
    $user = $_SESSION['username'];
    $score = $_POST['score'];

    $updateSql = "UPDATE dino SET score='$score' WHERE username='$user'";
    if ($conn->query($updateSql) === TRUE) {
        echo "Score updated successfully";
    } else {
        echo "Error updating score: " . $conn->error;
    }
} else {
    echo "Invalid request";
}

$conn->close();
?>