<?php
require "con_db.php";

if (isset($_POST['ielogoties'])) {
    session_start();

    $lietotajvards = htmlspecialchars($_POST['lietotajs']);
    $parole = $_POST['parole'];

    $vaicajums = $savienojums->prepare("SELECT * FROM Brivpratigo_lietotaji WHERE lietotajvards = ?");
    $vaicajums->bind_param("s", $lietotajvards);
    $vaicajums->execute();
    $rezultats = $vaicajums->get_result();
    $lietotajs = $rezultats->fetch_assoc();

    if ($lietotajs && password_verify($parole, $lietotajs['parole'])) {
        $_SESSION['lietotajvards'] = $lietotajs['lietotajvards'];
        $_SESSION['lietotaju_ID'] = $lietotajs['lietotaju_ID'];
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['pazinojums'] = "Nepareizs lietotājvārds vai parole!";
        header("Location: ../login.php");
        exit;
    }

    $vaicajums->close();
    $savienojums->close();
}
?>
