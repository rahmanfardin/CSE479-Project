<?php
require_once 'dbcon.php';

$game = $_GET['game'] ?? 'dinosaur'; // Default to 'dinosaur' game if not specified

$query = "SELECT username, score FROM dino WHERE game='$game' ORDER BY score DESC";
$result = $conn->query($query);

$leaderboard = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($leaderboard);

$conn->close();
?>