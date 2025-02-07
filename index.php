<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vietējo brīvprātīgais centrs</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <a href="./" class="logo"><i class="fa-solid fa-handshake-angle"></i> Brīvprātīgais Centrs
        </a>
        <div class="header_btn">
            <a class="btn" data-target="#modal-ticket">Par Mums</a>
            <a class="btn">Sludinājumi</a>
            <a class="btn">Kontakti</a>
            <a class="btn">Ziedot</a>
            <a class="btn">Pieslēgties/Reģistrēties </a>
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
            <button class="normal-btn">Vairāk</button>
        </div>
    </section>
</body>
</html>