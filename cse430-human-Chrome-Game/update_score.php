<?php
session_start();
require_once 'dbcon.php';

if ($_SESSION['loggin'] && isset($_POST['score'])) {
    $user = $_SESSION['username'];
    $newScore = $_POST['score'];

    // Retrieve the current score from the database
    $query = "SELECT score FROM dino WHERE username='$user'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentScore = $row['score'];

        // Update the score only if the new score is higher
        if ($newScore > $currentScore) {
            $updateSql = "UPDATE dino SET score='$newScore' WHERE username='$user'";
            if ($conn->query($updateSql) === TRUE) {
                echo "Score updated successfully";
            } else {
                echo "Error updating score: " . $conn->error;
            }
        } else {
            echo "New score is not higher than the current score";
        }
    } else {
        echo "User not found";
    }
} else {
    echo "Invalid request";
}

$conn->close();
?>