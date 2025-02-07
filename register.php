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
        echo "Reģistrācija veiksmīga! <a href='login.php'>Pieslēgties</a>";
    } else {
        echo "Kļūda: " . mysqli_error($savienojums);
    }
}
?>

<form method="POST">
    <input type="text" name="lietotajvards" placeholder="Lietotājvārds" required>
    <input type="text" name="vards" placeholder="Vārds" required>
    <input type="text" name="uzvards" placeholder="Uzvārds" required>
    <input type="email" name="epasts" placeholder="E-pasts" required>
    <input type="password" name="parole" placeholder="Parole" required>
    <input type="number" name="vecums" placeholder="Vecums" required>
    <select name="dzimums">
        <option value="male">Vīrietis</option>
        <option value="female">Sieviete</option>
        <option value="other">Cits</option>
    </select>
    <button type="submit" name="register">Reģistrēties</button>
</form>
<a href="login.php">Jau ir konts? Pieslēgties</a>
