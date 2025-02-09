<?php
session_start();
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vietējo brīvprātīgais centrs - Filtri</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <a href="./" class="logo"><i class="fa-solid fa-handshake-angle"></i> Brīvprātīgais Centrs</a>
        <div class="header_btn">
            <a class="btn" data-target="#modal-ticket">Par Mums</a>
            <a class="btn">Sludinājumi</a>
            <a class="btn">Kontakti</a>
            <a class="btn">Ziedot</a>
            <?php if (isset($_SESSION['lietotajvards'])): ?>
    <div class="profile-dropdown">
        <button class="btn profile-btn">
            <?php echo htmlspecialchars($_SESSION['lietotajvards']); ?> <i class="fa-solid fa-chevron-down"></i>
        </button>
        <div class="dropdown-menu">
            <a href="user/profile.php"><i class="fa-solid fa-user"></i> Profils</a>
            <a href="logout.php"><i class="fa-solid fa-sign-out-alt"></i> Iziet</a>
        </div>
    </div>
<?php else: ?>
    <a href="login.php" class="btn">Pieslēgties/Reģistrēties</a>
<?php endif; ?>

        </div>
    </header>

    <section id="filters">
        <h2>Atrodiet brīvprātīgo iespējas</h2>
        <div class="filter-container">
            <input type="text" placeholder="Meklēt..." class="search-input">
            
            <select class="filter-dropdown">
                <option value="">Izvēlieties kategoriju</option>
                <option value="environment">Vides Aizsardzība</option>
                <option value="animals">Dzīvnieku Palīdzība</option>
                <option value="education">Izglītība</option>
                <option value="social">Sociālā Palīdzība</option>
                <option value="sports">Sporta Brīvprātīgie</option>
                <option value="arts">Mākslas un Kultūras Pasākumi</option>
            </select>

            <select class="filter-dropdown">
                <option value="">Izvēlieties atrašanās vietu</option>
                <option value="riga">Rīga</option>
                <option value="liepaja">Liepāja</option>
                <option value="ventspils">Ventspils</option>
                <option value="daugavpils">Daugavpils</option>
            </select>

            <div class="checkbox-group">
              
            </div>

            <button class="search-btn">Meklēt</button>
        </div>
    </section>

</body>
</html>
