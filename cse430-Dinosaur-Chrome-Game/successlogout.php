<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>DINO | Good Bye</title>
    <script>
        // Countdown timer
        let countdown = 5;
        function updateCountdown() {
            if (countdown > 0) {
                document.getElementById('countdown').innerText = countdown;
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                window.location.href = '../index.html';
            }
        }
        window.onload = function() {
            updateCountdown();
        }
    </script>
</head>
<body>
    <h2>You have been logged out!</h2>
    <p>You will be redirected to the signup page in <span id="countdown">5</span> seconds...</p>
</body>
</html>