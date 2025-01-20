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
    $game = $_POST['game']; // Get the selected game

    $checkUserSql = "SELECT score FROM dino WHERE username='$user' AND game='$game'";
    $result = $conn->query($checkUserSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['score'] = $row['score'];
        $_SESSION['user_exists'] = true;
        $_SESSION['username'] = $user;
        $_SESSION['loggin'] = true;
    } else {
        $score = 0;
        echo $game . " " . $user . " " . $score;
        $insertSql = "INSERT INTO dino (username, score, game) VALUES ('$user', '$score', '$game')";

        if ($conn->query($insertSql) === TRUE) {
            $_SESSION['score'] = 0;
            $_SESSION['user_exists'] = false;
            $_SESSION['username'] = $user;
            $_SESSION['loggin'] = true;
        } else {
            // Handle error
        }
    }

    // Redirect based on the selected game
    if ($game == 'dinosaur') {
        header("Refresh: 2; url=cse430-Dinosaur-Chrome-Game/index.php");
    } else if ($game == 'human') {
        header("Refresh: 2; url=cse430-human-Chrome-Game/index.php");
    }
}

$conn->close();
?>