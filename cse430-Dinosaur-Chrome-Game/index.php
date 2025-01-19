<?php
session_start();
if ($_SESSION['loggin']) {
    $user = $_SESSION['username'];
    $score = $_SESSION['score'];
} else {
    header("Location: pleaseSignup.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>DINO | RAWRRRR!</title>
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>
    <h1>Dinosaur Game!</h1>
    <p class="username">Welcome, <span id="username"><?php echo htmlspecialchars($user); ?></span></p>
    <p class="previous-score">Previous Highscore: <span id="previous-score"><?php echo htmlspecialchars($score); ?></span></p>
    <canvas id="game" height="200" width="800"></canvas>
    <p class="controls">press space bar to start</p>

    <form action="logout.php" method="post" class="logout-form">
        <button type="submit" class="logout-button">Logout</button>
    </form>
    
    <button id="refresh-button">Refresh</button>
    <button id="leaderboard-button" onclick="window.location.href='leaderboard.php'">Show Leaderboard</button>

    <!-- Game Over Screen -->
    <div id="game-over-screen" class="hidden">
        <h2>Game Over!</h2>
        <p>Your score: <span id="final-score"></span></p>
        <button id="restart-button">Restart</button>
    </div>

    <script src="js/helpers.js"></script>
    <script src="js/objects/game-object.js"></script>
    <script src="js/objects/cactus.js"></script>
    <script src="js/objects/dinosaur.js"></script>
    <script src="js/objects/background.js"></script>
    <script src="js/objects/score.js"></script>
    <script src="js/game.js"></script>
    <script>
        new Game({
            el: document.getElementById("game")
        });

        function updateHighScore() {
            fetch('get_highscore.php')
                .then(response => response.json())
                .then(data => {
                    if (data.score !== undefined) {
                        const previousScoreElement = document.getElementById('previous-score');
                        const previousScore = parseInt(previousScoreElement.textContent);
                        previousScoreElement.textContent = data.score;

                        if (data.score > previousScore) {
                            previousScoreElement.classList.add('highlight');
                        } else {
                            previousScoreElement.classList.remove('highlight');
                        }
                    } else {
                        alert('Error: ' + data.error);
                    }
                });
        }

        document.getElementById('refresh-button').addEventListener('click', function() {
            updateHighScore();
            location.reload();
        });

        // Fetch and update high score on page load
        updateHighScore();
    </script>
</body>
</html>