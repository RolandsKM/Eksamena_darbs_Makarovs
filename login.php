<?php
session_start();
require 'assets/con_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $lietotajvards = mysqli_real_escape_string($savienojums, $_POST['lietotajvards']);
    $parole = $_POST['parole'];

    $query = "SELECT * FROM Brivpratigo_lietotaji WHERE lietotajvards='$lietotajvards'";
    $result = mysqli_query($savienojums, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($parole, $user['parole'])) {
            $_SESSION['lietotajvards'] = $user['lietotajvards'];
            $_SESSION['lietotaju_ID'] = $user['lietotaju_ID'];
            header("Location: welcome.php");
            exit;
        } else {
            echo "Nepareiza parole!";
        }
    } else {
        echo "Lietotājs neeksistē!";
    }
}
?>

<form method="POST">
    <input type="text" name="lietotajvards" placeholder="Lietotājvārds" required>
    <input type="password" name="parole" placeholder="Parole" required>
    <button type="submit" name="login">Pieslēgties</button>
</form>
<a href="register.php">Nav konta? Reģistrēties</a>
