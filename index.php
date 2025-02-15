<?php
session_start();
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vietējo brīvprātīgais centrs</title>
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
    
    <section id="start">
        <div class="info">
            <h1>Sveicināti vietējo brīvprātīgo centrā!</h1>
            <p>Vietējo brīvprātīgais centrs ir lieliska vieta kur dod roku lai izpalīdzētu saviem vietējiem un pastiprinātu draudzību ar apkārtējiem.</p>
        </div>
        <div class="search-container">
            <input type="text" placeholder="Meklēt..." class="search-input">
            <button class="search-btn">Meklēt</button>
        </div>
    </section>
    
    <section id="types">
        <div class="type-container">
            <button class="carousel-btn left-btn" onclick="prevSlide()">&#9665;</button>
            <div class="carousel-container">
                <div class="carousel">
                    <div class="volunteer-type">Vides Aizsardzība</div>
                    <div class="volunteer-type">Dzīvnieku Palīdzība</div>
                    <div class="volunteer-type">Izglītība</div>
                    <div class="volunteer-type">Sociālā Palīdzība</div>
                    <div class="volunteer-type">Sporta Brīvprātīgie</div>
                    <div class="volunteer-type">Mākslas un Kultūras Pasākumi</div>
                </div>
            </div>
            <button class="carousel-btn right-btn" onclick="nextSlide()">&#9655;</button>
        </div>
        
        <!-- Button container -->
        <div class="btn-container">
    <a href="more_filter.php" class="normal-btn">Vairāk</a>
</div>
    </section>
</body>
</html>