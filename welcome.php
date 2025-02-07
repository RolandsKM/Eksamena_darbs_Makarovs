<?php
session_start();
if (!isset($_SESSION['lietotajvards'])) {
    header("Location: login.php");
    exit;
}
?>

<h2>Laipni lūdzam, <?php echo $_SESSION['lietotajvards']; ?>!</h2>
<a href="logout.php">Izrakstīties</a>
