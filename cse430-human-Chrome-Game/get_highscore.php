<?php
require_once 'dbcon.php';

session_start();
if ($_SESSION['loggin']) {
    $user = $_SESSION['username'];

    // Retrieve the current high score from the database
    $query = "SELECT score FROM dino WHERE username='$user' and game='human'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentScore = $row['score'];
        
        // Update session score
        $_SESSION['score'] = $currentScore;

        echo json_encode(['score' => $currentScore]);
    } else {
        echo json_encode(['score' => 0]);
    }
} else {
    echo json_encode(['error' => 'User not logged in']);
}

$conn->close();
?>