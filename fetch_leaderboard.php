<?php
require_once 'dbcon.php';

$query = "
    SELECT username, score, game 
    FROM dino 
    WHERE game IN ('dinosaur', 'human') 
    ORDER BY FIELD(game, 'dinosaur', 'human'), score DESC
";
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