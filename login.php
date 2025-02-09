<?php
session_start();
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ielogoties | Brīvprātīgais Centrs</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
</head>
<body>

<div class="auth-container">
    <div class="auth-box">
        <!-- Close Button -->
        <a href="index.php" class="close-btn">
            <i class="fa-solid fa-xmark"></i>
        </a>

        <h2><i class="fa-solid fa-sign-in-alt"></i> Ielogoties</h2>
        
        <?php
            if (isset($_SESSION['pazinojums'])) {
                echo "<p class='login-notif'>" . $_SESSION['pazinojums'] . "</p>";
                unset($_SESSION['pazinojums']);
            }
        ?>

        <form action="database/login_function.php" method="post">
            <div class="input-group">
                <label><i class="fa-solid fa-user"></i> Lietotājvārds</label>
                <input type="text" name="lietotajs" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-lock"></i> Parole</label>
                <input type="password" name="parole" required>
            </div>

            <button type="submit" name="ielogoties" class="btn active">Ielogoties</button>
        </form>

        <p class="switch-form">Nav konta? <a href="register.php">Reģistrējies šeit</a></p>
    </div>
</div>

</body>
</html>
