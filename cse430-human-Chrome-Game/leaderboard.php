<?php

session_start();
if ($_SESSION['loggin']) {
    $user = $_SESSION['username'];
    $score = $_SESSION['score'];
} else {
    header("Location: pleaseSignup.html");
    exit();
}
require_once 'dbcon.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Human Game | Leaderboard</title>
    <link rel="stylesheet" type="text/css" href="css/leaderboard.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
    <h1>Human Game Leaderboard</h1>
    <table id="leaderboard-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Username</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody id="leaderboard-body">
            <!-- Leaderboard data will be inserted here by JavaScript -->
        </tbody>
    </table>
    <a href="index.php">Back to Game</a>

    <script>
        function fetchLeaderboard() {
            fetch('fetch_leaderboard.php?game=human')
                .then(response => response.json())
                .then(data => {
                    const leaderboardBody = document.getElementById('leaderboard-body');
                    leaderboardBody.innerHTML = '';
                    data.forEach((entry, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${String(index + 1).padStart(2, '0')}</td>
                            <td>${entry.username}</td>
                            <td>${entry.score}</td>
                        `;
                        leaderboardBody.appendChild(row);
                    });
                });
        }

        document.addEventListener('DOMContentLoaded', fetchLeaderboard);
    </script>
</body>
</html>