<?php
session_start();
require 'assets/con_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $lietotajvards = mysqli_real_escape_string($savienojums, $_POST['lietotajvards']);
    $vards = mysqli_real_escape_string($savienojums, $_POST['vards']);
    $uzvards = mysqli_real_escape_string($savienojums, $_POST['uzvards']);
    $epasts = mysqli_real_escape_string($savienojums, $_POST['epasts']);
    $parole = password_hash($_POST['parole'], PASSWORD_DEFAULT);
    $vecums = (int)$_POST['vecums'];
    $dzimums = mysqli_real_escape_string($savienojums, $_POST['dzimums']);

    $query = "INSERT INTO Brivpratigo_lietotaji (lietotajvards, vards, uzvards, epasts, parole, vecums, dzimums) 
              VALUES ('$lietotajvards', '$vards', '$uzvards', '$epasts', '$parole', '$vecums', '$dzimums')";

    if (mysqli_query($savienojums, $query)) {
        $_SESSION['pazinojums'] = "Reģistrācija veiksmīga! Vari pieslēgties.";
        header("Location: login.php");
        exit();
    } else {
        echo "Kļūda: " . mysqli_error($savienojums);
    }
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reģistrācija | Brīvprātīgais Centrs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-box">
        <h2><i class="fa-solid fa-user-plus"></i> Reģistrēties</h2>

        <form method="POST">
            <div class="input-group">
                <label><i class="fa-solid fa-user"></i> Lietotājvārds</label>
                <input type="text" name="lietotajvards" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-user"></i> Vārds</label>
                <input type="text" name="vards" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-user"></i> Uzvārds</label>
                <input type="text" name="uzvards" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-envelope"></i> E-pasts</label>
                <input type="email" name="epasts" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-lock"></i> Parole</label>
                <input type="password" name="parole" required>
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-calendar"></i> Vecums</label>
                <input type="number" name="vecums" >
            </div>

            <div class="input-group">
                <label><i class="fa-solid fa-venus-mars"></i> Dzimums</label>
                <select name="dzimums">
                    <option value="male">Vīrietis</option>
                    <option value="female">Sieviete</option>
                    <option value="other">Cits</option>
                </select>
            </div>

            <button type="submit" name="register" class="btn active">Reģistrēties</button>
        </form>

        <p class="switch-form">Jau ir konts? <a href="login.php">Pieslēgties</a></p>
    </div>
</div>

</body>
</html>
